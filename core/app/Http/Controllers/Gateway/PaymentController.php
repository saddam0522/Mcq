<?php

namespace App\Http\Controllers\Gateway;

use App\Models\Exam;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Result;
use App\Models\Deposit;
use App\Constants\Status;
use App\Lib\FormProcessor;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\WrittenPreview;
use App\Models\GatewayCurrency;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function deposit($id = null)
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method')->orderby('name')->get();

        $pageTitle = 'Deposit Methods';

        $exam = null;
        if (Route::current()->getName() == 'user.payment') {
            $pageTitle = 'Payment Methods';
            $exam = Exam::findOrFail($id);

            if ($exam->question_type ==  Status::MCQ) {
                $exist = Result::where('user_id', auth()->id())->where('exam_id', $exam->id)->first();
            } else {
                $exist = WrittenPreview::where('user_id', auth()->id())->where('exam_id', $exam->id)->first();
            }

            if ($exist) {
                $notify[] = ['error', 'Sorry you have already participated in this exam'];
                return back()->withNotify($notify);
            }

            if (@session('examId') != $id) {
                session()->forget('newPrice');
            }

            Session::put('exam', $exam);
        }

        return view('Template::user.payment.deposit', compact('gatewayCurrency', 'pageTitle', 'exam'));
    }

    public function depositInsert(Request $request)
    {
        $request->validate([
            'amount'   => 'required|numeric|gt:0',
            'gateway'  => 'required',
            'currency' => 'required',
            'exam_id'  => 'nullable|numeric|gt:0',
        ]);

        $examId = @$request->exam_id;
        if ($examId) {
            $exam = Exam::where('status', Status::ACTIVE)->where('end_date', '>=', \Carbon\Carbon::now()->toDateString())
                ->whereHas('questions', function ($questions) {
                    $questions->where('status', Status::ACTIVE);
                })
                ->whereHas('subject', function ($sub) {
                    $sub->where('status', Status::ACTIVE)->whereHas('category', function ($cat) {
                        $cat->where('status', Status::ACTIVE);
                    });
                })->find($examId);

            if (!$exam) {
                $notify[] = ['error', 'Exam not found'];
                return back()->withNotify($notify);
            }

            if (session('newPrice')) {
                $price      = @session('newPrice');
                $couponCode = @session('coupon');
                $coupon = Coupon::where('coupon_code', $couponCode)->where('status', '=', 1)->first();

                if (!$coupon) {
                    $notify[] = ['error', 'Coupon not found'];
                    return back()->withNotify($notify);
                }

                if ($coupon->exam_id != 0 && $coupon->exam_id != $exam->id) {
                    $notify[] = ['error', 'Coupon is invalid'];
                    return back()->withNotify($notify);
                }

                if ($coupon->amount_type == 2) {
                    $price = $exam->exam_fee - $coupon->coupon_amount;
                } else {
                    $discount = $exam->exam_fee * ($coupon->coupon_amount / 100);
                    $price    = $exam->exam_fee - $discount;
                }
            } else {
                $price = $exam->exam_fee;
            }
        }


        if (isset($price) && $price != $request->amount) {
            $notify[] = ['error', 'Sorry amount mismatch'];
            return back()->withNotify($notify);
        }

        $user = auth()->user();
        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->where('method_code', $request->gateway)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
            $notify[] = ['error', 'Please follow deposit limit'];
            return back()->withNotify($notify);
        }

        $charge      = $gate->fixed_charge + ($request->amount * $gate->percent_charge / 100);
        $payable     = $request->amount + $charge;
        $finalAmount = $payable * $gate->rate;

        $data                  = new Deposit();
        $data->user_id         = $user->id;
        if ($examId) {
            $data->exam_id     = $examId;
        }
        $data->method_code     = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount          = $request->amount;
        $data->charge          = $charge;
        $data->rate            = $gate->rate;
        $data->final_amount    = $finalAmount;
        $data->btc_amount      = 0;
        $data->btc_wallet      = "";
        $data->trx             = getTrx();

        if ($examId) {
            $data->success_url = route('user.exam.list');
            $data->failed_url  = route('user.exam.list');
        } else {
            $data->success_url = urlPath('user.deposit.history');
            $data->failed_url  = urlPath('user.deposit.history');
        }

        $data->save();

        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }


    public function appDepositConfirm($hash)
    {
        try {
            $id = decrypt($hash);
        } catch (\Exception $ex) {
            abort(404);
        }
        $data = Deposit::where('id', $id)->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'DESC')->firstOrFail();
        $user = User::findOrFail($data->user_id);
        auth()->login($user);
        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }


    public function depositConfirm()
    {
        $track = session()->get('Track');
        $deposit = Deposit::where('trx', $track)->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'DESC')->with('gateway')->firstOrFail();

        if ($deposit->method_code >= 1000) {
            return to_route('user.deposit.manual.confirm');
        }


        $dirName = $deposit->gateway->alias;
        $new = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);


        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return back()->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if (@$data->session) {
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $pageTitle = 'Payment Confirm';

        return view("Template::$data->view", compact('data', 'pageTitle', 'deposit'));
    }


    public static function userDataUpdate($deposit, $isManual = null)
    {
        if ($deposit->status == Status::PAYMENT_INITIATE || $deposit->status == Status::PAYMENT_PENDING) {
            $deposit->status = Status::PAYMENT_SUCCESS;
            $deposit->save();

            $user = User::find($deposit->user_id);
            $user->balance += $deposit->amount;
            $user->save();

            $methodName = $deposit->methodName();

            $transaction               = new Transaction();
            $transaction->user_id      = $deposit->user_id;
            $transaction->amount       = $deposit->amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge       = $deposit->charge;
            $transaction->trx_type     = '+';
            $transaction->details      = 'Deposit Via ' . $methodName;
            $transaction->trx          = $deposit->trx;
            $transaction->remark       = 'deposit';
            $transaction->save();

            if (!$isManual) {
                $adminNotification            = new AdminNotification();
                $adminNotification->user_id   = $user->id;
                $adminNotification->title     = 'Deposit successful via ' . $methodName;
                $adminNotification->click_url = urlPath('admin.deposit.successful');
                $adminNotification->save();
            }

            notify($user, $isManual ? 'DEPOSIT_APPROVE' : 'DEPOSIT_COMPLETE', [
                'method_name'     => $methodName,
                'method_currency' => $deposit->method_currency,
                'method_amount'   => showAmount($deposit->final_amount, currencyFormat: false),
                'amount'          => showAmount($deposit->amount, currencyFormat: false),
                'charge'          => showAmount($deposit->charge, currencyFormat: false),
                'rate'            => showAmount($deposit->rate, currencyFormat: false),
                'trx'             => $deposit->trx,
                'post_balance'    => showAmount($user->balance)
            ]);

            $exam = null;
            if ($deposit->exam_id) {
                $exam = Exam::find($deposit->exam_id);
            }

            if ($exam) {
                if (session('newPrice')) {
                    $coupon = Coupon::where('coupon_code', session('coupon'))->first();
                    $coupon->use_limit -= 1;
                    $coupon->update();
                }

                $user->balance -= $deposit->amount;
                $user->update();

                $transaction               = new Transaction();
                $transaction->user_id      = $deposit->user_id;
                $transaction->amount       = $deposit->amount;
                $transaction->post_balance = getAmount($user->balance);
                $transaction->charge       = 0;
                $transaction->trx_type     = '-';
                $transaction->details      = 'Payment of exam fee Via ' . $methodName;
                $transaction->trx          = $deposit->trx;
                $transaction->remark       = 'exam_fee';
                $transaction->save();

                $adminNotification            = new AdminNotification();
                $adminNotification->user_id   = $user->id;
                $adminNotification->title     = 'Payment completed for ' . $exam->title . ' exam';
                $adminNotification->click_url = urlPath('admin.report.transaction');
                $adminNotification->save();

                notify($user, 'EXAM_FEE', [
                    'title'           => $exam->title,
                    'type'            => $exam->question_type == 1 ? 'MCQ' : 'Written',
                    'mark'            => $exam->totalmark,
                    'method_name'     => $methodName,
                    'method_currency' => $deposit->method_currency,
                    'method_amount'   => getAmount($deposit->final_amo),
                    'amount'          => getAmount($deposit->amount),
                    'charge'          => getAmount($deposit->charge),
                    'currency'        => gs()->cur_text,
                    'rate'            => getAmount($deposit->rate),
                    'trx'             => $deposit->trx,
                    'post_balance'    => getAmount($user->balance)
                ]);
                session()->put('paid', 'ok');
            }
        }
    }

    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data  = Deposit::with('gateway')->where('status', Status::PAYMENT_INITIATE)->where('trx', $track)->first();
        abort_if(!$data, 404);
        if ($data->method_code > 999) {
            $pageTitle = 'Confirm Deposit';
            $method    = $data->gatewayCurrency();
            $gateway   = $method->method;
            return view('Template::user.payment.manual', compact('data', 'pageTitle', 'method', 'gateway'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $track = session()->get('Track');
        $data  = Deposit::with('gateway')->where('status', Status::PAYMENT_INITIATE)->where('trx', $track)->first();
        abort_if(!$data, 404);
        $gatewayCurrency = $data->gatewayCurrency();
        $gateway         = $gatewayCurrency->method;
        $formData        = $gateway->form->form_data;

        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);

        $data->detail = $userData;
        $data->status = Status::PAYMENT_PENDING;
        $data->save();

        $depositText                  = $data->exam_id ? 'payment' : 'deposit';
        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $data->user->id;
        $adminNotification->title     = ucfirst($depositText) . ' request from ' . $data->user->username;
        $adminNotification->click_url = urlPath('admin.deposit.details', $data->id);
        $adminNotification->save();

        notify($data->user, 'DEPOSIT_REQUEST', [
            'method_name'     => $data->gatewayCurrency()->name,
            'method_currency' => $data->method_currency,
            'method_amount'   => showAmount($data->final_amount, currencyFormat: false),
            'amount'          => showAmount($data->amount, currencyFormat: false),
            'charge'          => showAmount($data->charge, currencyFormat: false),
            'rate'            => showAmount($data->rate, currencyFormat: false),
            'trx'             => $data->trx
        ]);

        $notify[] = ['success', "You have $depositText request has been taken"];
        return to_route('user.deposit.history')->withNotify($notify);
    }
}

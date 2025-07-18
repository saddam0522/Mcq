<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Form;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Deposit;
use App\Constants\Status;
use App\Lib\FormProcessor;
use App\Models\CouponUser;
use App\Models\DeviceToken;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use Illuminate\Validation\Rule;
use App\Lib\GoogleAuthenticator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function home()
    {
        $pageTitle = 'Dashboard';

        $user = auth()->user();
        $totalDeposit = Deposit::where('user_id', $user->id)->sum('amount');
        $totalTrx = Transaction::where('user_id', $user->id)->count();
        $examList =  Exam::where('status', 1)->where('end_date', '>=', \Carbon\Carbon::now()->toDateString())
            ->whereHas('questions', function ($questions) {
                $questions->where('status', Status::ACTIVE);
            })
            ->whereHas('subject', function ($sub) {
                $sub->where('status', 1)->whereHas('category', function ($cat) {
                    $cat->where('status', 1);
                });
            })->latest()->with('subject.category')->take(8)->get();

        return view('Template::user.dashboard', compact('pageTitle', 'totalDeposit', 'totalTrx', 'examList'));
    }

    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit History';
        $deposits = auth()->user()->deposits()->searchable(['trx'])->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function show2faForm()
    {
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . gs('site_name'), $secret);
        $pageTitle = '2FA Security';
        return view('Template::user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user, $request->code, $request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = Status::ENABLE;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user, $request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = Status::DISABLE;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions()
    {
        $pageTitle = 'Transactions';
        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');

        $transactions = Transaction::where('user_id', auth()->id())->searchable(['trx'])->filter(['trx_type', 'remark'])->orderBy('id', 'desc')->paginate(getPaginate());

        return view('Template::user.transactions', compact('pageTitle', 'transactions', 'remarks'));
    }

    public function userData()
    {
        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $pageTitle  = 'User Data';
        $info       = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries  = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        return view('Template::user.user_data', compact('pageTitle', 'user', 'countries', 'mobileCode'));
    }

    public function userDataSubmit(Request $request)
    {

        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $countryData  = (array)json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes  = implode(',', array_column($countryData, 'dial_code'));
        $countries    = implode(',', array_column($countryData, 'country'));

        $request->validate([
            'country_code' => 'required|in:' . $countryCodes,
            'country'      => 'required|in:' . $countries,
            'mobile_code'  => 'required|in:' . $mobileCodes,
            'username'     => 'required|unique:users|min:6',
            'mobile'       => ['required', 'regex:/^([0-9]*)$/', Rule::unique('users')->where('dial_code', $request->mobile_code)],
        ]);


        if (preg_match("/[^a-z0-9_]/", trim($request->username))) {
            $notify[] = ['info', 'Username can contain only small letters, numbers and underscore.'];
            $notify[] = ['error', 'No special character, space or capital letters in username.'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        $user->country_code = $request->country_code;
        $user->mobile       = $request->mobile;
        $user->username     = $request->username;


        $user->address      = $request->address;
        $user->city         = $request->city;
        $user->state        = $request->state;
        $user->zip          = $request->zip;
        $user->country_name = @$request->country;
        $user->dial_code    = $request->mobile_code;

        $user->profile_complete = Status::YES;
        $user->save();

        return to_route('user.home');
    }


    public function addDeviceToken(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()->all()];
        }

        $deviceToken = DeviceToken::where('token', $request->token)->first();

        if ($deviceToken) {
            return ['success' => true, 'message' => 'Already exists'];
        }

        $deviceToken          = new DeviceToken();
        $deviceToken->user_id = auth()->user()->id;
        $deviceToken->token   = $request->token;
        $deviceToken->is_app  = Status::NO;
        $deviceToken->save();

        return ['success' => true, 'message' => 'Token saved successfully'];
    }

    public function downloadAttachment($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $title = slug(gs('site_name')) . '- attachments.' . $extension;
        try {
            $mimetype = mime_content_type($filePath);
        } catch (\Exception $e) {
            $notify[] = ['error', 'File does not exists'];
            return back()->withNotify($notify);
        }
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function applyCoupon(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'coupon' => 'required',
            'examid' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors());
        }
        $coupon = Coupon::where('coupon_code', '=', strtoupper($request->coupon))->where('status', '=', 1)->first();

        if (!$coupon) {
            return response()->json(['coupon' => ['Sorry! Invalid coupon']]);
        }

        if ($coupon->use_limit <= 0) {
            return response()->json(['coupon' => ['Sorry! Coupon limit has been reached']]);
        }
        if ($coupon->start_date > Carbon::now()->toDateString()) {
            return response()->json(['coupon' => ['Sorry! Coupon is not valid in this date']]);
        }
        if ($coupon->end_date < Carbon::now()->toDateString()) {
            return response()->json(['coupon' => ['Sorry! Coupon has been expired']]);
            $coupon->status = 0;
            $coupon->update();
        }


        $general = gs();
        $exam = Exam::find($request->examid);

        if (!$exam) {
            return response()->json(['coupon' => ['Sorry! Something went wrong']]);
        }

        $couponUser = CouponUser::where('user_id', auth()->id())->where('coupon_id', $coupon->id)->get();

        if ($exam->exam_fee < $coupon->min_order_amount) {
            return response()->json(['coupon' => ["Sorry! Minimum exam price is required for this coupon is " . getAmount($coupon->min_order_amount) . ' ' . $general->cur_text]]);
        }

        if ($couponUser->count() >= $coupon->usage_per_user) {
            return response()->json(['coupon' => ['Sorry! Your Coupon limit has been reached']]);
        } else {
            $couponUser = new CouponUser();
            $couponUser->user_id = auth()->id();
            $couponUser->coupon_id = $coupon->id;
            $couponUser->save();
        }

        if ($coupon->exam_id == 0) {
            if ($coupon->amount_type == 2) {
                $newPrice = $exam->exam_fee - $coupon->coupon_amount;
            } else {
                $discount = $exam->exam_fee * ($coupon->coupon_amount / 100);
                $newPrice = $exam->exam_fee - $discount;
            }
            session()->put('newPrice', $newPrice);
            session()->put('examId', $request->examid);
            session()->put('coupon', $coupon->coupon_code);
            return response()->json(['yes' => "Coupon applied! new price is $newPrice " . $general->cur_text, 'newPrice' => "$newPrice" . ' ' . $general->cur_text]);
        } else {
            if ($coupon->exam_id != $exam->id) {
                return response()->json(['coupon' => ['Sorry! Coupon not valid for this exam']]);
            } else {
                if ($coupon->amount_type == 2) {
                    $newPrice = $exam->exam_fee - $coupon->coupon_amount;
                } else {
                    $discount = $exam->exam_fee * ($coupon->coupon_amount / 100);
                    $newPrice = $exam->exam_fee - $discount;
                }
                session()->put('newPrice', $newPrice);
                session()->put('examId', $request->examid);
                session()->put('coupon', $coupon->coupon_code);
                return response()->json(['yes' => "Coupon applied! new price is $newPrice " . $general->cur_text, 'newPrice' => "$newPrice" . ' ' . $general->cur_text]);
            }
        }
    }
}

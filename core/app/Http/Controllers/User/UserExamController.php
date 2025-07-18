<?php

namespace App\Http\Controllers\User;


use App\Models\Exam;
use App\Models\Result;
use App\Models\Options;
use App\Constants\Status;
use App\Models\Questions;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Models\WrittenPreview;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;


class UserExamController extends Controller
{
    public function examList(Request $request)
    {

        $pageTitle = "Exam List";
        $examList =  Exam::where('status', Status::ACTIVE)->where('end_date', '>=', \Carbon\Carbon::now()->toDateString())
            ->whereHas('questions', function ($questions) {
                $questions->where('status', Status::ACTIVE);
            })
            ->whereHas('subject', function ($sub) {
                $sub->where('status', Status::ACTIVE)->whereHas('category', function ($cat) {
                    $cat->where('status', Status::ACTIVE);
                });
            })->latest()->with('subject.category')->searchable(['title', 'subject:name'])->paginate(getPaginate());

        return view('Template::user.exam.examList', compact('pageTitle', 'examList'));
    }

    public function perticipateExam($id)
    {
        session()->forget('exam');
        $pageTitle = 'Participation of exam';
        $exam = Exam::find($id);
        if (!$exam) {
            $notify[] = ['error', 'Exam not found'];
            return back()->withNotify($notify);
        }
        if ($exam->upcomming($exam->id)) {
            $notify[] = ['error', 'Sorry!! this is an upcoming exam'];
            return back()->withNotify($notify);
        }
        if ($exam->question_type == Status::MCQ) {
            $exist = Result::where('user_id', auth()->id())->where('exam_id', $exam->id)->first();
            if ($exist) {
                $notify[] = ['error', 'Sorry you have already participated in this exam'];
                return back()->withNotify($notify);
            }

            $result = new Result();
            $result->exam_id = $exam->id;
            $result->user_id = auth()->id();
            $result->result_mark = 0;
            $result->total_correct_ans = 0;
            $result->total_wrong_ans = 0;
            $result->result_status = Status::FAILED;
            $result->save();
        } else {
            $exist = WrittenPreview::where('user_id', auth()->id())->where('exam_id', $exam->id)->first();
            if ($exist) {
                $notify[] = ['error', 'Sorry you have already participated in this exam'];
                return back()->withNotify($notify);
            }

            $written = new WrittenPreview();
            $written->exam_id = $exam->id;
            $written->user_id = auth()->id();
            $written->status = Status::ATTENDED;
            $written->save();
        }

        if ($exam->random_question == 1) {
            $questions = Questions::where('exam_id', $id)->inRandomOrder()->get();
        } else {
            $questions = Questions::where('exam_id', $id)->get();
        }

        return view('Template::user.exam.examScript', compact('pageTitle', 'questions', 'exam'));
    }

    public function takeExam($id)
    {
        $exam = Exam::findOrFail($id);
        $user = auth()->user();

        if ($exam->question_type == 1) {
            $exist = Result::where('user_id', auth()->id())->where('exam_id', $exam->id)->first();
        } else {
            $exist = WrittenPreview::where('user_id', auth()->id())->where('exam_id', $exam->id)->first();
        }
        if ($exist) {
            $notify[] = ['error', 'Sorry you have already participated in this exam'];
            return back()->withNotify($notify);
        }

        if (session('newPrice')) {
            $price = session('newPrice');
        } else {
            $price = $exam->exam_fee;
        }
        if ($price > $user->balance) {
            $notify[] = ['error', 'Insufficient balance'];
            return back()->withNotify($notify);
        }

        $user->balance -= $price;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = getAmount($price);
        $transaction->post_balance = getAmount($user->balance);
        $transaction->charge = 0;
        $transaction->trx_type = '-';
        $transaction->details = "Payment of exam fee, $exam->title";
        $transaction->trx = getTrx();
        $transaction->remark = 'exam_fee';
        $transaction->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'Payment completed for ' . $exam->title . ' exam';
        $adminNotification->click_url = urlPath('admin.report.transaction');
        $adminNotification->save();

        notify($user, 'EXAM_FEE_FROM_BALANCE', [
            'title' => $exam->title,
            'type' => $exam->question_type == Status::MCQ ? 'MCQ' : 'Written',
            'mark' => $exam->totalmark,
            'amount' => getAmount($price),
            'trx' => $transaction->trx,
            'currency' => gs()->cur_text,
            'post_balance' => getAmount($user->balance)
        ]);

        return redirect(route('user.exam.perticipate', $exam->id));
    }

    public function scriptSubmission(Request $request)
    {

        $exam = Exam::findOrFail($request->examId);

        if ($exam->question_type == Status::MCQ) {

            $passMark = ($exam->totalmark * $exam->pass_percentage) / 100;
            $correctAns = 0;
            $wrongAns = 0;
            $resultMark = 0;

            if ($request->ans) {
                foreach ($request->ans as $k => $ans) {

                    $qtn = Questions::findOrFail($k);
                    $opt = Options::findOrFail($ans);

                    if ($opt->correct_ans == 1) {
                        $correctAns += 1;
                    } else if ($opt->correct_ans == 0) {
                        $wrongAns += 1;
                    }

                    $resultMark = $exam->totalmark - $qtn->marks * $wrongAns;
                }
                if ($exam->negative_marking == Status::YES) {
                    $resultMark -= $exam->reduce_mark * $wrongAns;
                }

                if ($correctAns == 0) {
                    $resultMark = 0;
                }
            }

            $result  = Result::where('user_id', auth()->id())->where('exam_id', $exam->id)->first();
            $result->exam_id = $exam->id;
            $result->user_id = auth()->id();
            $result->result_mark = $resultMark ?? 0;
            $result->total_correct_ans = $correctAns ?? 0;
            $result->total_wrong_ans = $wrongAns ?? 0;
            $result->result_status = $passMark > $resultMark ? Status::FAILED : Status::PASSED ?? Status::FAILED;
            $result->save();
            return redirect(route('user.exam.result', $exam->id));
        } else {
            WrittenPreview::where('user_id', auth()->id())->where('exam_id', $exam->id)->delete();
            $purifier = new \HTMLPurifier();
            foreach ($request->written as $k => $ans) {
                $qtn = Questions::findOrFail($k);
                $written = new WrittenPreview();
                $written->exam_id = $exam->id;
                $written->question_id = $qtn->id;
                $written->user_id = auth()->id();
                $written->question = $qtn->question;
                $written->answer = htmlspecialchars_decode($purifier->purify($ans ?? ''));
                $written->status = Status::NOT_REVIEWED;
                $written->save();
            }
            return redirect(route('user.exam.result', $exam->id));
        }
    }

    public function result($id)
    {
        $exam = Exam::findOrFail($id);
        if ($exam->question_type == Status::MCQ) {
            $pageTitle = "Exam Result";
            $result = Result::where('exam_id', $exam->id)->first();
            return view('Template::user.exam.result', compact('pageTitle', 'exam', 'result'));
        } else {
            $pageTitle = "Submission";
            return view('Template::user.exam.writtenPrev', compact('pageTitle', 'exam'));
        }
    }

    public function mcqExamHistory(Request $request)
    {
        $pageTitle = "Mcq Exam History";
        $histories = Result::where('user_id', auth()->id())->searchable(['exam:title'])->whereHas('exam', function ($q) {
            $q->where('question_type', Status::MCQ);
        })->paginate(getPaginate());

        return view('Template::user.exam.examHistory', compact('pageTitle', 'histories'));
    }

    public function writtenExamHistory(Request $request)
    {
        $pageTitle = "Written Exam History";
        $collection = WrittenPreview::where('user_id', auth()->id())->whereHas('exam')->searchable(['exam:title'])->get();
        $histories = $collection->groupBy('exam_id');
        $examId = array_keys($histories->toArray());
        $exams = Exam::whereIn('id', $examId)->paginate(getPaginate());
        return view('Template::user.exam.writtenExamHistory', compact('pageTitle', 'histories', 'exams'));
    }

    public function writtenExamDetails($examid)
    {
        $pageTitle = "Written Exam Result Details";
        $user  = auth()->user();
        $detailQuestions = WrittenPreview::where('user_id', $user->id)->where('exam_id', $examid)->with(['writtenQuestion', 'exam'])->get();
        $exam  = Exam::findOrFail($examid);
        return view('Template::user.exam.writtenExamDetails', compact('pageTitle', 'detailQuestions', 'exam', 'user'));
    }



    public function perticipate()
    {
        $exam = session('exam');
        $paid = session('paid');
        if (!$paid) {
            $notify[] = ['error', 'Sorry Invalid Request'];
            return redirect(route('user.exam.list'))->withNotify($notify);
        }
        session()->forget('paid');
        return redirect(route('user.exam.perticipate', $exam->id));
    }

    public function mcqCertificate($id)
    {
        $result  = Result::findOrFail($id);
        $pageTitle = 'Certificate';
        $cert = certificate([
            'sitename'   => gs('site_name'),
            'name'       => auth()->user()->fullname,
            'score'      => $result->result_mark,
            'exam_title' => $result->exam->title,
            'date'       => showDateTime($result->created_at, 'd M Y')
        ]);
        $cert_name = slug($result->exam->title) . '-' . slug(showDateTime($result->created_at, 'd M Y'));
        return view('Template::certificate', compact('cert', 'pageTitle', 'cert_name'));
    }

    public function writtenCertificate($examid)
    {
        $exam  = Exam::findOrFail($examid);
        $result = $exam->written->where('user_id', auth()->id())->last();
        $pageTitle = 'Certificate';
        $getMark = $exam->totalWrittenMark(auth()->id());
        $gnl = gs();

        $cert  = certificate([
            'sitename'   => gs('site_name'),
            'name'       => auth()->user()->fullname,
            'score'      => $getMark,
            'exam_title' => $exam->title,
            'date'       => showDateTime($result->updated_at, 'd M Y')
        ]);
        $cert_name = slug($exam->title) . '-' . slug(showDateTime($result->updated_at, 'd M Y'));
        return view('Template::certificate', compact('cert', 'pageTitle', 'cert_name'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\User;
use App\Constants\Status;
use Illuminate\Http\Request;
use App\Models\WrittenPreview;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WrittenReviewController extends Controller
{
    public function allPending(Request $request)
    {
        $pageTitle = "All pending written script";
        $pendings = WrittenPreview::whereNotNull('answer')->where('status', 0)->searchable(['exam:title', 'user:username', 'writtenQuestion:question'])->latest()->paginate(getPaginate());
        return view('admin.written.allPending', compact('pageTitle', 'pendings'));
    }

    public function pendingExam(Request $request)
    {
        $pageTitle = "All pending written exam";
        $pendings = WrittenPreview::whereNotNull('answer')->where('status', Status::NOT_REVIEWED)->searchable(['exam:title'])->groupBy('exam_id')->latest()->paginate(getPaginate());
        return view('admin.written.pendingExam', compact('pageTitle', 'pendings'));
    }

    public function pendingExamDetails(Request $request, $id)
    {
        $search = $request->search;
        if ($search) {
            $pageTitle = "Result of $search";
            $pendings = WrittenPreview::whereNotNull('answer')->where('status', 0)->where('exam_id', $id)->whereHas('user', function ($user) use ($search) {
                $user->where('username', $search);
            })->groupBy('user_id')->paginate(15);
        } else {
            $pageTitle = "All pending user scripts";
            $pendings = WrittenPreview::whereNotNull('answer')->where('status', 0)->where('exam_id', $id)->groupBy('user_id')->latest()->paginate(15);
        }
        $pageTitle = "All pending user scripts";
        $pendings = WrittenPreview::whereNotNull('answer')->where('status', 0)->where('exam_id', $id)->searchable(['user:username'])->groupBy('user_id')->latest()->paginate(15);

        return view('admin.written.userPendingExam', compact('pageTitle', 'pendings'));
    }

    public function writtenDetailsUser($userid, $examid)
    {
        $pageTitle = 'Written Details';
        $detailQuestions = WrittenPreview::where('user_id', $userid)->where('exam_id', $examid)->with(['writtenQuestion', 'exam'])->get();
        $exam  = Exam::findOrFail($examid);
        $user  = User::findOrFail($userid);
        return view('admin.written.writtenDetailsUser', compact('pageTitle', 'detailQuestions', 'exam', 'user'));
    }



    public function reviewedExam(Request $request)
    {
        $pageTitle = "All reviewed written exam";
        $reviewed = WrittenPreview::where('status', 1)->searchable(['exam:title'])->groupBy('exam_id')->latest()->paginate(getPaginate());

        return view('admin.written.reviewedExam', compact('pageTitle', 'reviewed'));
    }

    public function reviewedExamDetails(Request $request, $id)
    {
        $search = $request->search;
        if ($search) {
            $pageTitle = "Result of $search";
            $reviewed = WrittenPreview::where('status', 1)->where('exam_id', $id)->whereHas('user', function ($user) use ($search) {
                $user->where('username', $search);
            })->groupBy('user_id')->paginate(15);
        } else {
            $pageTitle = "All reviewed user scripts";
            $reviewed = WrittenPreview::where('status', 1)->where('exam_id', $id)->groupBy('user_id')->latest()->paginate(15);
        }


        return view('admin.written.userReviewedExam', compact('pageTitle', 'reviewed'));
    }

    public function writtenDetails($userid, $qtnid)
    {
        $pageTitle = 'Written Details';
        $details = WrittenPreview::where('user_id', $userid)->where('question_id', $qtnid)->with(['writtenQuestion', 'exam'])->first();
        return view('admin.written.writtenDetails', compact('pageTitle', 'details'));
    }

    public function giveMark(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'mark' => 'required|numeric|min:0'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors());
        }

        $wp = WrittenPreview::find($id);
        if (!$wp) {
            return response()->json(['mark' => ['Question not found']]);
        }
        if ($request->mark > $wp->writtenQuestion->marks) {
            return response()->json(['mark' => ['Given mark can not be greater than question mark']]);
        }
        $wp->given_mark = $request->mark;
        $wp->status = 1;
        $wp->update();
        return response()->json(['yes' => 'Mark has been given']);
    }

    public function giveCorrectAns(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'ans' => 'required|numeric|min:0'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors());
        }

        $wp = WrittenPreview::find($id);
        if (!$wp) {
            return response()->json(['mark' => ['Question not found']]);
        }

        $wp->correct_ans = 1;
        $wp->update();
        return response()->json(['yes' => 'Correct answer provided']);
    }
}

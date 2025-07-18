<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Options;
use App\Models\Questions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{

    public function addMcq($examid)
    {
        $pageTitle = 'Add Mcq Question';
        $exam = Exam::findOrFail($examid);
        return view('admin.question.addMcq', compact('pageTitle', 'exam'));
    }

    public function store(Request $request)
    {
        $purifier = new \HTMLPurifier();
        $request->validate([
            'question' => 'required',
            'mark' => 'required|numeric|min:0',
            'option' => 'required',
            'option.*' => 'required',
            'correct' => 'required'
        ], [
            'correct.required' => 'Please select a correct answer',
            'option.*.required' => 'Options are required'
        ]);

        $exam = Exam::findOrFail($request->examid);
        $marks = Questions::where('exam_id', $exam->id)->sum('marks');
        $newMark = $marks + $request->mark;
        if ($exam->totalmark == $marks || $newMark > $exam->totalmark) {
            $notify[] = ['error', 'Sorry! Can\'t add questions,exam total mark exceeded'];
            return back()->withNotify($notify);
        }

        $qtn = new Questions();
        $qtn->exam_id = $request->examid;
        $qtn->question = htmlspecialchars_decode($purifier->purify($request->question));
        $qtn->marks = $request->mark;
        $qtn->save();

        foreach ($request->option as $key => $opt) {
            $op = new Options();
            $op->question_id = $qtn->id;
            $op->option = $opt;
            if ($request->correct == $key) {
                $op->correct_ans = 1;
            }
            $op->save();
        }

        $notify[] = ['success', 'Question added successfully'];
        return back()->withNotify($notify);
    }

    public function editMcq($id)
    {
        $pageTitle = 'Edit Mcq Question';
        $qtn = Questions::findOrFail($id);
        $exam = Exam::findOrFail($qtn->exam_id);
        return view('admin.question.editMcq', compact('pageTitle', 'exam', 'qtn'));
    }

    public function update(Request $request, $id)
    {
        $purifier = new \HTMLPurifier();
        $request->validate([
            'question' => 'required',
            'mark' => 'required|numeric|min:0',
            'option' => 'required',
            'correct' => 'required'
        ], [
            'correct.required' => 'Please select a correct answer'
        ]);


        $exam = Exam::findOrFail($request->examid);
        $qtn = Questions::findOrFail($id);
        $marks = Questions::where('exam_id', $exam->id)->sum('marks');

        if ($request->mark != $qtn->marks) {
            $newMark = $marks + $request->mark;
            if ($newMark > $exam->totalmark) {
                $notify[] = ['error', 'Sorry! Can\'t update questions,exam total mark exceeded'];
                return back()->withNotify($notify);
            }
        }


        $qtn->exam_id = $request->examid;
        $qtn->question = htmlspecialchars_decode($purifier->purify($request->question));
        $qtn->marks = $request->mark;
        $qtn->save();

        Options::where('question_id', $id)->delete();
        foreach ($request->option as $key => $option) {

            $opt = new Options();
            $opt->question_id = $qtn->id;
            $opt->option = $option;
            if ($request->correct == $key) {
                $opt->correct_ans = 1;
            }
            $opt->save();
        }

        $notify[] = ['success', 'Question Updated successfully'];
        return back()->withNotify($notify);
    }

    public function remove($id)
    {
        $qtn = Questions::findOrFail($id);
        Options::where('question_id', $qtn->id)->delete();
        $qtn->delete();
        $notify[] = ['success', 'Question has been removed'];
        return back()->withNotify($notify);
    }

    public function written($id)
    {
        $pageTitle = 'Add Written Questions';
        $exam = Exam::findOrFail($id);
        return view('admin.question.writtenQuestion', compact('pageTitle', 'exam'));
    }

    public function writtenStore(Request $request, $id)
    {
        $purifier = new \HTMLPurifier();
        $request->validate([
            'question' => 'required',
            'mark' => 'required|numeric|min:0'
        ]);
        $qtn = new Questions();
        $qtn->exam_id = $id;
        $qtn->question = htmlspecialchars_decode($purifier->purify($request->question));
        $qtn->marks = $request->mark;
        $qtn->written_ans = htmlspecialchars_decode($purifier->purify($request->answer));
        $qtn->status = $request->status ? 1 : 0;
        $qtn->save();
        $notify[] = ['success', 'Question Added successfully'];
        return back()->withNotify($notify);
    }

    public function writtenEdit($id)
    {
        $pageTitle = 'Add Written Questions';
        $qtn = Questions::findOrFail($id);
        return view('admin.question.writtenQuestionEdit', compact('pageTitle', 'qtn'));
    }

    public function writtenUpdate(Request $request, $id)
    {
        $purifier = new \HTMLPurifier();
        $request->validate([
            'question' => 'required',
            'mark' => 'required|numeric|min:0'
        ]);
        $qtn = Questions::findOrFail($id);
        $qtn->question = htmlspecialchars_decode($purifier->purify($request->question));
        $qtn->marks = $request->mark;
        $qtn->written_ans = htmlspecialchars_decode($purifier->purify($request->answer));
        $qtn->status = $request->status ? 1 : 0;
        $qtn->update();
        $notify[] = ['success', 'Question Updated successfully'];
        return back()->withNotify($notify);
    }
}

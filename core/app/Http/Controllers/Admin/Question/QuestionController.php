<?php

namespace App\Http\Controllers\Admin\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Subject;
use App\Models\QuestionBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        $questions = $request->input('questions');
        $adminId = auth()->id();

        // Filter out invalid entries
        $questions = array_filter($questions, function ($question) {
            return isset($question['question_text']) && isset($question['options']) && is_array($question['options']);
        });

        foreach ($questions as $data) {
            Question::storeWithRelations($data, $adminId);
        }

        Session::forget('questions');
        return back()->with('success', 'Questions stored successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $questions = Question::where('question_text', 'LIKE', "%$query%")->get(['id', 'question_text']);
        return response()->json($questions);
    }

    public function mcqList()
    {
        $pageTitle = 'MCQ Questions List';
        $questions = Question::with(['topics', 'chapters', 'questionBanks'])->paginate(10);
        return view('admin.question.mcqList', compact('pageTitle', 'questions'));
    }

    public function addMcq()
    {
        $pageTitle = 'Add New MCQ Question';
        $questionBanks = \App\Models\QuestionBank::all();
        $subjects = \App\Models\Subject::all();
        return view('admin.question.addMcq', compact('pageTitle', 'questionBanks', 'subjects'));
    }
}

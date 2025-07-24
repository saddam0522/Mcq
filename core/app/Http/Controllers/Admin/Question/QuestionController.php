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
            // Ensure options are grouped and encoded as JSON
            $data['options'] = array_values(array_filter($data['options'], function ($option) {
                return !empty($option); // Remove empty options
            }));

            // Pass the complete options array to the model
            Question::storeWithRelations($data, $adminId);
        }

        Session::forget('questions');
        $notify[] = ['success', 'Questions stored successfully'];
        return back()->withNotify($notify);
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

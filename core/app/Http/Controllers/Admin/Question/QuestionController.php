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
        $adminId = auth()->id();

        $request->validate([
            'type' => 'required|in:both,question_bank,subjective',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_answer' => 'required',
        ]);

        $shared = [
            'question_bank_ids' => $request->input('question_bank_ids', []),
            'subject_id'        => $request->input('subject_id'),
            'chapter_id'        => $request->input('chapter_id'),
            'topic_ids'         => $request->input('topic_ids', []),
        ];

        foreach ($request->input('questions') as $q) {
            // Filter empty options
            $q['options'] = array_values(array_filter($q['options'], fn($opt) => !empty($opt)));

            // Map correct_answer index to actual value
            $correctIndex = intval($q['correct_answer']);
            $q['correct_answer'] = $q['options'][$correctIndex] ?? null;

            $data = array_merge($q, $shared);
            \App\Models\Question::storeWithRelations($data, $adminId);
        }
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

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
        $type = $request->input('type');
        $shared = [
            'question_bank_ids' => $request->input('question_bank_ids', []),
            'subject_id' => $request->input('subject_id'),
            'chapter_id' => $request->input('chapter_id'),
            'topic_ids' => $request->input('topic_ids', []),
        ];

        $questions = array_filter($request->input('questions', []), function ($q) {
            return !empty($q['question_text']) && 
                !empty($q['options']) && 
                count(array_filter($q['options'])) >= 2 &&
                isset($q['correct_answer']);
        });

        foreach ($questions as $q) {
            $q = array_merge($q, $shared);
            Question::storeWithRelations($q, $adminId);
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

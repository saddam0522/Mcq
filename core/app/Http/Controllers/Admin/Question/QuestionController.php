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
            'questions.*.correct_answer' => 'required|array|min:1',
        ]);

        // Shared assignment data from the top section
        $shared = [
            'question_bank_ids' => $request->input('question_bank_ids', []),
            'subject_id'        => $request->input('subject_id'),
            'chapter_id'        => $request->input('chapter_id'),
            'topic_ids'         => $request->input('topic_ids', []),
        ];

        foreach ($request->input('questions') as $q) {
            // Clean options
            $options = array_values(array_filter($q['options'], fn($opt) => !empty($opt)));

            // Map correct answers from indexes to ensure they're valid
            $correctIndexes = array_map('intval', $q['correct_answer'] ?? []);

            // Prevent invalid indexes (e.g., out of bounds)
            $correctIndexes = array_filter($correctIndexes, fn($i) => isset($options[$i]));

            // Merge shared and per-question data
            $data = array_merge($q, $shared);
            $data['options'] = $options;
            $data['correct_answer'] = json_encode($correctIndexes); // store as JSON

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

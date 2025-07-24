<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Topic;
use App\Models\Subject;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'All Topics';
        $subjects = Subject::all();
        $chapters = Chapter::query();

        if ($request->subject_id) {
            $chapters->where('subject_id', $request->subject_id);
        }

        $chapters = $chapters->get();
        $topics = Topic::with('chapter');

        if ($request->chapter_id) {
            $topics->where('chapter_id', $request->chapter_id);
        }

        $topics = $topics->latest()->paginate(getPaginate());
        return view('admin.topic.index', compact('pageTitle', 'subjects', 'chapters', 'topics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'chapter_id' => 'required|exists:chapters,id',
            'title' => 'required|string|max:150',
            'content' => 'nullable|string',
            'banner' => 'nullable|string',
            'status' => 'nullable',
        ]);

        Topic::create([
            'chapter_id' => $request->chapter_id,
            'title' => $request->title,
            'content' => $request->content,
            'banner' => $request->banner,
            'status' => $request->status ? 1 : 0,
        ]);

        $notify[] = ['success', 'Topic created successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'chapter_id' => 'required|exists:chapters,id',
            'title' => 'required|string|max:150',
            'content' => 'nullable|string',
            'banner' => 'nullable|string',
            'status' => 'nullable',
        ]);

        $topic = Topic::findOrFail($id);
        $topic->update([
            'chapter_id' => $request->chapter_id,
            'title' => $request->title,
            'content' => $request->content,
            'banner' => $request->banner,
            'status' => $request->status ? 1 : 0,
        ]);

        $notify[] = ['success', 'Topic updated successfully'];
        return back()->withNotify($notify);
    }

    public function getChaptersBySubject(Request $request)
    {
        $chapters = Chapter::where('subject_id', $request->subject_id)->get();
        return response()->json(['success' => true, 'chapters' => $chapters]);
    }

    public function getTopicsByChapter(Request $request)
    {
        $chapterId = $request->input('chapter_id');
        $topics = Topic::where('chapter_id', $chapterId)->get(['id', 'title']);
        return response()->json($topics);
    }
}

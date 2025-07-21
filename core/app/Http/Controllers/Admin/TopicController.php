<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'All Topics';
        $chapters = Chapter::all();
        $topics = Topic::with('chapter');

        if ($request->chapter_id) {
            $topics->where('chapter_id', $request->chapter_id);
        }

        $topics = $topics->latest()->paginate(getPaginate());
        return view('admin.topic.index', compact('pageTitle', 'chapters', 'topics'));
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
}

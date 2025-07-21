<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Subject;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'All Chapters';
        $subjects = Subject::all();
        $chapters = Chapter::with('subject');

        if ($request->subject_id) {
            $chapters->where('subject_id', $request->subject_id);
        }

        $chapters = $chapters->latest()->paginate(getPaginate());
        return view('admin.chapter.index', compact('pageTitle', 'subjects', 'chapters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'banner' => 'nullable|string',
            'status' => 'nullable',
        ]);

        Chapter::create([
            'subject_id' => $request->subject_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'banner' => $request->banner,
            'status' => $request->status ? 1 : 0,
        ]);

        $notify[] = ['success', 'Chapter created successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'banner' => 'nullable|string',
            'status' => 'nullable',
        ]);

        $chapter = Chapter::findOrFail($id);
        $chapter->update([
            'subject_id' => $request->subject_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'banner' => $request->banner,
            'status' => $request->status ? 1 : 0,
        ]);

        $notify[] = ['success', 'Chapter updated successfully'];
        return back()->withNotify($notify);
    }
}

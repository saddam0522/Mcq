<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Subject;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    public function allSubject(Request $request)
    {
        $pageTitle = 'All Subjects';
        $subjects = Subject::searchable(['name'])->latest()->paginate(getPaginate());
        $categories = Category::get(['name', 'id']);
        return view('admin.subject.all', compact('pageTitle',  'categories', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:subjects',
            'category_id' => 'required|numeric',
            'short_details' => 'required'
        ]);

        $subject = new Subject();
        $subject->category_id = $request->category_id;
        $subject->name = $request->name;
        $subject->slug = Str::slug($request->name);
        $subject->short_details = $request->short_details;
        $subject->status = $request->status ? 1 : 0;
        $subject->is_popular = $request->is_popular ? 1 : 0;
        $subject->save();
        $notify[] = ['success', 'Subject Created Successfully'];
        return back()->withNotify($notify);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:subjects,name,' . $id,
            'category_id' => 'required|numeric',
            'short_details' => 'required'
        ]);

        $subject = Subject::findOrFail($id);
        $subject->category_id = $request->category_id;
        $subject->name = $request->name;
        $subject->short_details = $request->short_details;
        $subject->status = $request->status ? 1 : 0;
        $subject->is_popular = $request->is_popular ? 1 : 0;
        $subject->save();
        $notify[] = ['success', 'Subject Updated Successfully'];
        return back()->withNotify($notify);
    }
}

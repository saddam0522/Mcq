<?php

namespace App\Http\Controllers\Admin\Questionbank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuestionBank;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class QuestionbankController extends Controller
{
    public function index()
    {
        $pageTitle = 'Question Banks';
        $categories = Category::all();
        $questionBanks = QuestionBank::with(['category', 'createdBy', 'updatedBy'])->paginate(getPaginate());
        $emptyMessage = 'No question banks found.';
        return view('admin.question-bank.index', compact('pageTitle', 'categories', 'questionBanks', 'emptyMessage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:question_banks',
            'category_id' => 'required|exists:categories,id',
            'year' => 'nullable|integer',
            'status' => 'nullable',
        ]);

        QuestionBank::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'year' => $request->year,
            'status' => $request->status ? 1 : 0,
            'created_by' => Auth::guard('admin')->id(),
        ]);

        $notify[] = ['success', 'Question Bank Created Successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:question_banks,name,' . $id,
            'category_id' => 'required|exists:categories,id',
            'year' => 'nullable|integer',
            'status' => 'nullable',
        ]);

        $questionBank = QuestionBank::findOrFail($id);
        $questionBank->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'year' => $request->year,
            'status' => $request->status ? 1 : 0,
            'updated_by' => Auth::id(),
        ]);

        $notify[] = ['success', 'Question Bank Updated Successfully'];
        return back()->withNotify($notify);
    }

    public function delete($id)
    {
        $questionBank = QuestionBank::findOrFail($id);
        $questionBank->delete();

        $notify[] = ['success', 'Question Bank Deleted Successfully'];
        return back()->withNotify($notify);
    }
}

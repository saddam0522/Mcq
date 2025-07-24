<?php

namespace App\Http\Controllers\Admin\Questionbank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuestionBank;
use Illuminate\Support\Facades\Auth;

class QuestionbankController extends Controller
{
    public function index()
    {
        $pageTitle = 'Question Banks';
        $questionBanks = QuestionBank::with(['createdBy', 'updatedBy'])->paginate(getPaginate());
        $emptyMessage = 'No question banks found.';
        return view('admin.question-bank.index', compact('pageTitle', 'questionBanks', 'emptyMessage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:question_banks',
            'year' => 'nullable|integer',
        ]);

        QuestionBank::create([
            'name' => $request->name,
            'year' => $request->year,
            'created_by' => Auth::id(),
        ]);

        $notify[] = ['success', 'Question Bank Created Successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:question_banks,name,' . $id,
            'year' => 'nullable|integer',
        ]);

        $questionBank = QuestionBank::findOrFail($id);
        $questionBank->update([
            'name' => $request->name,
            'year' => $request->year,
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

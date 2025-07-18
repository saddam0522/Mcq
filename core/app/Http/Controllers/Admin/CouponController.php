<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Coupon;
use App\Constants\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    public function allCoupons(Request $request)
    {
        if ($request->search) {
            $search = $request->search;
            $pageTitle = "Search Result of $search";
            $coupons = Coupon::where('coupon_code', 'like', "%$search%")->where('name', 'like', "%$search%")->paginate(15);
        } else {
            $pageTitle = "All Coupons";
            $coupons = Coupon::latest()->paginate(15);
        }


        return view('admin.coupon.allCoupons', compact('pageTitle', 'coupons'));
    }

    public function addCoupons()
    {
        $pageTitle = 'Add New Coupon';
        $exams = Exam::where('value', Status::PAID)->get(['id', 'title']);
        return view('admin.coupon.addCoupon', compact('pageTitle', 'exams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'details' => 'required|max:100',
            'amount_type' => 'required|numeric|in:1,2',
            'exam_id' => 'required|numeric',
            'coupon_amount' => 'required|numeric|min:1',
            'min_order_amount' => 'nullable|numeric|min:0',
            'coupon_code' => 'required|unique:coupons',
            'use_limit' => 'nullable|numeric|min:0',
            'usage_per_user' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|after:start_date',

        ], [
            'exam_id.required' => 'Please select the exam'
        ]);

        $coupon = new Coupon();
        $coupon->exam_id = $request->exam_id;
        $coupon->name = $request->name;
        $coupon->details  = $request->details;
        $coupon->amount_type = $request->amount_type;
        $coupon->coupon_amount = $request->coupon_amount;
        $coupon->min_order_amount = $request->min_order_amount ?? 0;
        $coupon->coupon_code = strtoupper($request->coupon_code);

        $coupon->use_limit = $request->use_limit ?? 0;
        $coupon->usage_per_user = $request->usage_per_user ?? 0;
        $coupon->start_date =  Carbon::parse($request->start_date)->format('Y-m-d');
        $coupon->end_date =  Carbon::parse($request->end_date)->format('Y-m-d');
        $coupon->status = $request->status ? 1 : 0;
        $coupon->save();
        $notify[] = ['success', 'Coupon added successfully'];
        return back()->withNotify($notify);
    }

    public function edit($id)
    {
        $pageTitle = 'Update Coupon';
        $coupon = Coupon::findOrFail($id);
        $exams = Exam::where('value', Status::PAID)->get(['id', 'title']);
        return view('admin.coupon.editCoupon', compact('pageTitle', 'coupon', 'exams'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'details' => 'required|max:100',
            'exam_id' => 'required|numeric',
            'amount_type' => 'required|numeric|in:1,2',
            'coupon_amount' => 'required|numeric|min:1',
            'min_order_amount' => 'nullable|numeric|min:0',
            'coupon_code' => 'required|unique:coupons,coupon_code,' . $id,
            'use_limit' => 'nullable|numeric|min:0',
            'usage_per_user' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|after:start_date',

        ], [
            'exam_id.required' => 'Please select the exam'
        ]);

        $coupon = Coupon::findOrFail($id);
        $coupon->exam_id = $request->exam_id;
        $coupon->name = $request->name;
        $coupon->details  = $request->details;
        $coupon->amount_type = $request->amount_type;
        $coupon->coupon_amount = $request->coupon_amount;
        $coupon->min_order_amount = $request->min_order_amount ?? 0;
        $coupon->coupon_code = $request->coupon_code;
        $coupon->use_limit = $request->use_limit ?? 0;
        $coupon->usage_per_user = $request->usage_per_user ?? 0;
        $coupon->start_date =  Carbon::parse($request->start_date)->format('Y-m-d');
        $coupon->end_date =  Carbon::parse($request->end_date)->format('Y-m-d');
        $coupon->status = $request->status ? 1 : 0;
        $coupon->save();
        $notify[] = ['success', 'Coupon updated successfully'];
        return back()->withNotify($notify);
    }
}

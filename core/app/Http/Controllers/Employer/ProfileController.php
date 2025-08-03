<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function changePasswordForm()
    {
        $pageTitle = "Change Password";
        return view('templates.basic.employer.auth.change-password', compact('pageTitle'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $employer = auth()->guard('employer')->user();

        if (!Hash::check($request->current_password, $employer->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $employer->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function profileForm()
    {
        $pageTitle = "Profile Settings";
        $employer = auth()->guard('employer')->user();
        return view('templates.basic.employer.auth.profile-setting', compact('pageTitle', 'employer'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'representative_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employers,email,' . auth()->id(),
        ]);

        $employer = auth()->guard('employer')->user();
        $employer->update($request->only('company_name', 'representative_name', 'email'));

        return back()->with('success', 'Profile updated successfully.');
    }
}

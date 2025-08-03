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
            'industry' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'company_address' => 'nullable|string|max:255',
            'company_city' => 'nullable|string|max:255',
            'company_country' => 'nullable|string|max:255',
            'representative_name' => 'required|string|max:255',
            'representative_designation' => 'nullable|string|max:255',
            'representative_email' => 'nullable|email|max:255',
            'representative_phone' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $employer = auth()->guard('employer')->user();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = 'uploads/employer/logo/';
            $logoName = uniqid() . '.' . $request->logo->extension();
            $request->logo->move(public_path($logoPath), $logoName);
            $employer->logo = $logoPath . $logoName;
        }

        $employer->update($request->except(['logo', 'email']));

        return back()->with('success', 'Profile updated successfully.');
    }
}

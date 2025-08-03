<?php

namespace App\Http\Controllers\Employer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/employer/dashboard';

    public function __construct()
    {
        // $this->middleware('guest:employer')->except('logout');
    }

    public function showLoginForm()
    {
        $pageTitle = "Employer Login";
        return view('templates.basic.employer.auth.login', compact('pageTitle'));
    }

    protected function guard()
    {
        return auth()->guard('employer');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('employer.login')->with('success', 'Logged out successfully.');
    }
}

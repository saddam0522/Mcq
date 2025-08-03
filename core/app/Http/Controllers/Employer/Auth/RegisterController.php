<?php

namespace App\Http\Controllers\Employer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $pageTitle = "Employer Registration";
        return view('templates.basic.employer.auth.register', compact('pageTitle'));
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $employer = $this->create($request->all());

        auth()->guard('employer')->login($employer);

        return redirect()->route('employer.dashboard')->with('success', 'Registration successful.');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|unique:employers',
            'password' => 'required|min:6|confirmed',
            'company_name' => 'required|string|max:255',
            'representative_name' => 'required|string|max:255',
        ]);
    }

    protected function create(array $data)
    {
        return Employer::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'company_name' => $data['company_name'],
            'representative_name' => $data['representative_name'],
        ]);
    }
}

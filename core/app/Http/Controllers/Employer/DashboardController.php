<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $pageTitle = "Employer Dashboard";
        return view('templates.basic.employer.dashboard.dashboard', compact('pageTitle'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobController extends Controller
{
    public function alljobs()
    {
        $pageTitle = "All Jobs";
        return view('Template::jobs.all', compact('pageTitle'));
    }
    public function jobDetails()
    {
        $pageTitle = "Job Details";
        return view('Template::jobs.details', compact('pageTitle'));
    }
}

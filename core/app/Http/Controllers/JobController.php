<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function alljobs()
    {
        $pageTitle = "All Jobs";
        $jobs = JobPost::with('category', 'employer')->where('status', 'published')->paginate(6);
        return view('Template::jobs.all', compact('pageTitle', 'jobs'));
    }

    public function jobDetails($id)
    {
        $job = JobPost::with('category', 'employer')->where('id', $id)->firstOrFail();
        $pageTitle = $job->title;
        return view('Template::jobs.details', compact('pageTitle', 'job'));
    }
}

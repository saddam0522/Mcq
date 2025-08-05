<?php

namespace App\Http\Controllers\Employer\Jobpost;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manage Jobs';
        $jobPosts = JobPost::where('employer_id', auth()->id())->with('category')->paginate(10);
        $categories = JobCategory::where('is_active', true)->pluck('name', 'id');
        return view('templates.basic.employer.job-post.index', compact('pageTitle', 'jobPosts', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'location' => 'required|string|max:255',
            'job_type' => 'required|in:Full Time,Part Time,Contract,Internship',
            'work_mode' => 'required|in:Office,Remote,Hybrid',
            'experience_required' => 'nullable|integer|min:0',
            'salary' => 'nullable|numeric|min:0',
            'currency' => 'required|string|max:10',
            'published_at' => 'required|date',
            'deadline' => 'required|date|after_or_equal:published_at',
            'short_description' => 'nullable|string',
            'full_description' => 'required|string',
            'skills' => 'nullable|array',
            'education' => 'nullable|string|max:255',
            'gender_preference' => 'nullable|string|max:255',
            'vacancies' => 'required|integer|min:1',
        ]);

        JobPost::create(array_merge($request->all(), ['employer_id' => auth()->id()]));

        return back()->with('success', 'Job created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'location' => 'required|string|max:255',
            'job_type' => 'required|in:Full Time,Part Time,Contract,Internship',
            'work_mode' => 'required|in:Office,Remote,Hybrid',
            'experience_required' => 'nullable|integer|min:0',
            'salary' => 'nullable|numeric|min:0',
            'currency' => 'required|string|max:10',
            'published_at' => 'required|date',
            'deadline' => 'required|date|after_or_equal:published_at',
            'short_description' => 'nullable|string',
            'full_description' => 'required|string',
            'skills' => 'nullable|array',
            'education' => 'nullable|string|max:255',
            'gender_preference' => 'nullable|string|max:255',
            'vacancies' => 'required|integer|min:1',
        ]);

        $jobPost = JobPost::where('employer_id', auth()->id())->findOrFail($id);
        $jobPost->update($request->all());

        return back()->with('success', 'Job updated successfully.');
    }

    public function destroy($id)
    {
        $jobPost = JobPost::where('employer_id', auth()->id())->findOrFail($id);
        $jobPost->delete();

        return back()->with('success', 'Job deleted successfully.');
    }

    public function getJobCategories()
    {
        $categories = JobCategory::where('is_active', true)->select('id', 'name')->get();
        return response()->json($categories);
    }
}

<?php

namespace App\Http\Controllers\Admin\Jobportal;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobCategoryController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Job Categories';
        $jobCategories = JobCategory::searchable(['name'])->orderBy('name')->paginate(getPaginate());
        $jobCategories->getCollection()->transform(function ($category) {
            $category->job_posts_count = $category->jobPosts()->count();
            return $category;
        });
        $emptyMessage = 'No job categories found.';
        return view('admin.job-portal.category.index', compact('pageTitle', 'jobCategories', 'emptyMessage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:job_categories',
        ]);

        $category = new JobCategory();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->is_active = $request->is_active ? 1 : 0;
        $category->save();

        $notify[] = ['success', 'Job Category Created Successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:job_categories,name,' . $id,
        ]);

        $category = JobCategory::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->is_active = $request->is_active ? 1 : 0;
        $category->save();

        $notify[] = ['success', 'Job Category Updated Successfully'];
        return back()->withNotify($notify);
    }

    public function destroy($id)
    {
        $category = JobCategory::findOrFail($id);

        if ($category->jobPosts()->count() > 0) {
            $notify[] = ['error', 'Cannot delete category with associated job posts.'];
            return back()->withNotify($notify);
        }

        $category->delete();
        $notify[] = ['success', 'Job Category Deleted Successfully'];
        return back()->withNotify($notify);
    }
}

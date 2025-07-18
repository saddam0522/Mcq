<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function allCategories(Request $request)
    {

        $pageTitle = 'All Categories';
        $categories = Category::searchable(['name'])->orderBy('name')->paginate(getPaginate());
        return view('admin.category.all', compact('pageTitle',  'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status ? 1 : 0;
        $category->save();
        $notify[] = ['success', 'Category Created Successfully'];
        return back()->withNotify($notify);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $id
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status ? 1 : 0;
        $category->save();
        $notify[] = ['success', 'Category Updated Successfully'];
        return back()->withNotify($notify);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = BlogCategory::paginate();
        return view('admin.pages.blog-category.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.blog-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCategoryRequest $request)
{
    // dd($request->all());
    $data = $request->validated();

    if (empty($data['slug'])) {
        $data['slug'] = Str::slug($data['name']['en']);
    } else {
        $data['slug'] = Str::slug($data['slug']);
    }
    // dd($data);
    BlogCategory::create($data);

    return redirect()->route('admin.blog-categories.index')
        ->with('success', 'Category created successfully');
}

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $category = BlogCategory::findOrFail($id);
        return view('admin.pages.blog-category.create', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogCategoryRequest $request,string  $id)
    {
        // dd($request->all());
        $category = BlogCategory::findOrFail($id);
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']['en']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        $category->update($data);

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $category = BlogCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Category deleted successfully');
    }
}

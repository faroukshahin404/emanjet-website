<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryRequest;
use App\Models\BlogCategory;
use App\Services\Admin\AdminListStatistics;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BlogCategory::query();
        if ($request->filled('category')) {
            $query->where('id', $request->category);
        }
        $results = $query->paginate(10)->withQueryString();
        $categories = BlogCategory::all();
        $stats = AdminListStatistics::blogCategories();

        return view('admin.pages.blog-category.index', compact('results', 'categories', 'stats'));
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
        $data = $request->validated();
        $data['slug'] = $this->uniqueCategorySlug(Str::slug($data['name']['en'] ?? '') ?: 'category');

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
    public function update(BlogCategoryRequest $request, string $id)
    {
        $category = BlogCategory::findOrFail($id);
        $data = $request->validated();
        $data['slug'] = $this->uniqueCategorySlug(
            Str::slug($data['name']['en'] ?? '') ?: 'category',
            (int) $category->id
        );

        $category->update($data);

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Ensure a unique slug for blog_categories (base from English name).
     */
    private function uniqueCategorySlug(string $base, ?int $ignoreId = null): string
    {
        $slug = $base !== '' ? $base : 'category';
        $counter = 0;

        do {
            $candidate = $counter === 0 ? $slug : $slug . '-' . $counter;
            $query = BlogCategory::query()->where('slug', $candidate);
            if ($ignoreId !== null) {
                $query->where('id', '!=', $ignoreId);
            }
            if (! $query->exists()) {
                return $candidate;
            }
            $counter++;
        } while ($counter < 1000);

        return $slug . '-' . uniqid();
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

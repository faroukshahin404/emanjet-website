<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    use UploadFile;
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Blog::with('category');
        if ($request->has('blog') && $request->blog != '') {
            $query->where('id', $request->blog);
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        $results = $query->latest()->paginate();
        $blogs = Blog::all();
        $categories = BlogCategory::all();
        return view('admin.pages.blogs.index', compact('results', 'blogs', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.pages.blogs.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        // dd($request->all());
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload($request->file('image'), 'blogs', $data['title']['en']);
        }

        foreach (['en', 'ar'] as $lang) {
            if (!empty($data['meta_tags'][$lang])) {
                $data['meta_tags'][$lang] = array_map('trim', explode(',', $data['meta_tags'][$lang]));
            }
        }

        Blog::create($data);

        return redirect()->route('admin.blogs.index')->with('success', __('Blog created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Blog::findOrFail($id);
        $categories = BlogCategory::all();
        return view('admin.pages.blogs.create', compact('item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, string $id)
    {
        $blog = Blog::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($blog->image) {
                $this->deleteImage($blog->image);
            }

            $data['image'] = $this->upload($request->file('image'), 'blogs', $data['title']['en']);
        }

        foreach (['en', 'ar'] as $lang) {
            if (!empty($data['meta_tags'][$lang])) {
                $data['meta_tags'][$lang] = array_map('trim', explode(',', $data['meta_tags'][$lang]));
            }
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('success', __('Blog updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image) {
            $this->deleteImage($blog->image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', __('Blog deleted successfully.'));
    }
}

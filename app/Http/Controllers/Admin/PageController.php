<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::with('pageSeos')->get();
        return view('admin.pages.pages.index', compact('pages'));
    }


    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required|string|max:255|unique:pages,slug,' . $id,
            'title' => 'required|string|max:255',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string',
            'meta_tags.image' => 'required|string',
            'meta_tags.keywords' => 'required|string',
            'meta_tags.og_image' => 'required|string',
            'meta_tags.og_title' => 'required|string',
            'meta_tags.og_description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $page = Page::findOrFail($id);

        $page->update([
            'slug' => $request->slug,
            'title' => $request->title,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_tags' => [
                'image' => $request->input('meta_tags.image'),
                'keywords' => $request->input('meta_tags.keywords'),
                'og_image' => $request->input('meta_tags.og_image'),
                'og_title' => $request->input('meta_tags.og_title'),
                'og_description' => $request->input('meta_tags.og_description'),
            ],
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully');
    }
}

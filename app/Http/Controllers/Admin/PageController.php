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
        // return response()->json($pages);
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
            'title.en' => 'required|string|max:255',
            'title.ar' => 'required|string|max:255',
            'meta_title.en' => 'required|string|max:255',
            'meta_title.ar' => 'required|string|max:255',
            'meta_description.en' => 'required|string',
            'meta_description.ar' => 'required|string',
            'meta_tags.en.image' => 'required|string',
            'meta_tags.en.keywords' => 'required|string',
            'meta_tags.en.og_image' => 'required|string',
            'meta_tags.en.og_title' => 'required|string',
            'meta_tags.en.og_description' => 'required|string',
            'meta_tags.ar.image' => 'required|string',
            'meta_tags.ar.keywords' => 'required|string',
            'meta_tags.ar.og_image' => 'required|string',
            'meta_tags.ar.og_title' => 'required|string',
            'meta_tags.ar.og_description' => 'required|string',
            'status' => 'sometimes|boolean'
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        $page = Page::findOrFail($id);
    
        $updateData = [
            'slug' => $request->slug,
            'title' => [
                'en' => $request->input('title.en'),
                'ar' => $request->input('title.ar')
            ],
            'meta_title' => [
                'en' => $request->input('meta_title.en'),
                'ar' => $request->input('meta_title.ar')
            ],
            'meta_description' => [
                'en' => $request->input('meta_description.en'),
                'ar' => $request->input('meta_description.ar')
            ],
            'meta_tags' => [
                'en' => [
                    'image' => $request->input('meta_tags.en.image'),
                    'keywords' => $request->input('meta_tags.en.keywords'),
                    'og_image' => $request->input('meta_tags.en.og_image'),
                    'og_title' => $request->input('meta_tags.en.og_title'),
                    'og_description' => $request->input('meta_tags.en.og_description')
                ],
                'ar' => [
                    'image' => $request->input('meta_tags.ar.image'),
                    'keywords' => $request->input('meta_tags.ar.keywords'),
                    'og_image' => $request->input('meta_tags.ar.og_image'),
                    'og_title' => $request->input('meta_tags.ar.og_title'),
                    'og_description' => $request->input('meta_tags.ar.og_description')
                ]
            ],
            'status' => $request->has('status') ? 1 : 0
        ];
    
        $page->update($updateData);
    
        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully');
    }
}

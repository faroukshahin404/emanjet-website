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
            'meta_tags_image_en' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_tags_image_ar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_tags_og_image_en' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_tags_og_image_ar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_tags.en.keywords' => 'required|string',
            'meta_tags.en.og_title' => 'required|string',
            'meta_tags.en.og_description' => 'required|string',
            'meta_tags.ar.keywords' => 'required|string',
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

        // Initialize meta_tags with existing values
        $metaTags = [
            'en' => [
                'image' => isset($page->meta_tags['en']) ? $page->meta_tags['en']['image'] : '',
                'keywords' => $request->input('meta_tags.en.keywords'),
                'og_image' => isset($page->meta_tags['en']) ? $page->meta_tags['en']['og_image'] : '',
                'og_title' => $request->input('meta_tags.en.og_title'),
                'og_description' => $request->input('meta_tags.en.og_description')
            ],
            'ar' => [
                'image' => isset($page->meta_tags['ar']) ? $page->meta_tags['ar']['image'] : '',
                'keywords' => $request->input('meta_tags.ar.keywords'),
                'og_image' => isset($page->meta_tags['ar']) ? $page->meta_tags['ar']['og_image'] : '',
                'og_title' => $request->input('meta_tags.ar.og_title'),
                'og_description' => $request->input('meta_tags.ar.og_description')
            ]
        ];

        // Process image uploads

        // Handle English image upload
        if ($request->hasFile('meta_tags_image_en')) {
            // Delete old file if exists
            if (isset($page->meta_tags['en']['image']) && !empty($page->meta_tags['en']['image'])) {
                $oldImagePath = public_path($page->meta_tags['en']['image']);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('meta_tags_image_en');
            $filename = 'page_' . $id . '_en_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pages'), $filename);
            $metaTags['en']['image'] = 'uploads/pages/' . $filename;
        }

        if ($request->hasFile('meta_tags_og_image_en')) {
            // Delete old file if exists
            if (isset($page->meta_tags['en']['og_image']) && !empty($page->meta_tags['en']['og_image'])) {
                $oldImagePath = public_path($page->meta_tags['en']['og_image']);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('meta_tags_og_image_en');
            $filename = 'page_' . $id . '_en_og_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pages'), $filename);
            $metaTags['en']['og_image'] = 'uploads/pages/' . $filename;
        }

        if ($request->hasFile('meta_tags_image_ar')) {
            if (isset($page->meta_tags['ar']['image']) && !empty($page->meta_tags['ar']['image'])) {
                $oldImagePath = public_path($page->meta_tags['ar']['image']);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('meta_tags_image_ar');
            $filename = 'page_' . $id . '_ar_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pages'), $filename);
            $metaTags['ar']['image'] = 'uploads/pages/' . $filename;
        }

        if ($request->hasFile('meta_tags_og_image_ar')) {
            // Delete old file if exists
            if (isset($page->meta_tags['ar']['og_image']) && !empty($page->meta_tags['ar']['og_image'])) {
                $oldImagePath = public_path($page->meta_tags['ar']['og_image']);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('meta_tags_og_image_ar');
            $filename = 'page_' . $id . '_ar_og_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pages'), $filename);
            $metaTags['ar']['og_image'] = 'uploads/pages/' . $filename;
        }

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
            'meta_tags' => $metaTags,
            'status' => $request->has('status') ? 1 : 0
        ];

        $page->update($updateData);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully');
    }
  
}

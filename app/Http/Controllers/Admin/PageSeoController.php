<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSeo;
use Illuminate\Http\Request;

class PageSeoController extends Controller
{

    public function index($pageId)
    {
        $page = Page::with('pageSeos')->findOrFail($pageId);
        return view('admin.pages.pages-seo.index', compact('page'));
    }

    public function edit($id)
    {
        $pageSeo = PageSeo::findOrFail($id);
        return view('admin.pages.pages-seo.edit', compact('pageSeo'));
    }
    public function update(Request $request, $id)
    {
        $pageSeo = PageSeo::findOrFail($id);

        $validatedData = $request->validate([
            'section_type' => 'required|string|max:255',
            'order' => 'required|integer',
            'status' => 'required|boolean',
            'content_json.en.images.*' => 'sometimes|string', // Maintain existing images
            'content_json.ar.images.*' => 'sometimes|string', // Maintain existing images
        ]);

        // Get the existing content
        $contentJson = is_array($pageSeo->content_json)
            ? $pageSeo->content_json
            : json_decode($pageSeo->content_json, true) ?? [];

        // Process both languages
        foreach (['en', 'ar'] as $lang) {
            if (!isset($contentJson[$lang])) {
                $contentJson[$lang] = [];
            }

            // Handle single image upload
            if ($request->hasFile("image_uploads.$lang.image")) {
                $file = $request->file("image_uploads.$lang.image");

                // Delete old image if exists
                if (isset($contentJson[$lang]['image']) && !empty($contentJson[$lang]['image'])) {
                    $oldImagePath = public_path($contentJson[$lang]['image']);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Store new image
                $filename = 'seo_' . $lang . '_' . $id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/seo-images'), $filename);
                $contentJson[$lang]['image'] = 'uploads/seo-images/' . $filename;
            }

            // Handle multiple images upload - only process if files are actually uploaded
            if ($request->hasFile("image_uploads.$lang.images")) {
                // First, delete all old images if they exist
                if (isset($contentJson[$lang]['images']) && is_array($contentJson[$lang]['images'])) {
                    foreach ($contentJson[$lang]['images'] as $oldImage) {
                        $oldImagePath = public_path($oldImage);
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                }

                // Clear the old images array
                $contentJson[$lang]['images'] = [];

                // Store new images
                foreach ($request->file("image_uploads.$lang.images") as $upload) {
                    if ($upload) {
                        $filename = 'seo_' . $lang . '_' . $id . '_' . time() . '_' . rand(1000, 9999) . '.' . $upload->getClientOriginalExtension();
                        $upload->move(public_path('uploads/seo-images'), $filename);
                        $contentJson[$lang]['images'][] = 'uploads/seo-images/' . $filename;
                    }
                }
            } elseif ($request->has("content_json.$lang.images")) {
                // Maintain existing images if no new files are uploaded
                $contentJson[$lang]['images'] = $request->input("content_json.$lang.images", []);
            }

            // Merge other content fields
            if ($request->has("content_json.$lang")) {
                foreach ($request->input("content_json.$lang", []) as $key => $value) {
                    // Skip image fields as they're handled above
                    if ($key === 'image' || $key === 'images') {
                        continue;
                    }

                    $contentJson[$lang][$key] = $value;
                }
            }
        }

        $pageSeo->update([
            'section_type' => $validatedData['section_type'],
            'order' => $validatedData['order'],
            'status' => $validatedData['status'],
            'content_json' => $contentJson,
        ]);

        return redirect()
            ->route('admin.pages-seo.index', $pageSeo->page_id)
            ->with('success', 'SEO section updated successfully.');
    }
}

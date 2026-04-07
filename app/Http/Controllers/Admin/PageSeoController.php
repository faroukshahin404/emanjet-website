<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSeo;
use App\Services\Admin\AdminListStatistics;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PageSeoController extends Controller
{
    public function toggleStatus(PageSeo $pageSeo): RedirectResponse
    {
        $pageSeo->update(['status' => ! $pageSeo->status]);

        return back()->with(
            'success',
            $pageSeo->status
                ? __('Section is now visible on the website.')
                : __('Section is now hidden on the website.')
        );
    }

    public function index(Page $page)
    {
        $page->load('pageSeos');
        $stats = AdminListStatistics::pageSeosForPage($page);

        return view('admin.pages.pages-seo.index', compact('page', 'stats'));
    }

    public function edit(PageSeo $pageSeo)
    {
        return view('admin.pages.pages-seo.edit', compact('pageSeo'));
    }

    public function update(Request $request, PageSeo $pageSeo)
    {

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

        if ($pageSeo->section_type === 'social-media') {
            $request->validate([
                'social_links' => 'nullable|array',
                'social_links.*.icon_class' => 'nullable|string|max:191',
                'social_links.*.url' => 'nullable|string|max:2048',
            ]);

            $links = collect($request->input('social_links', []))
                ->map(function ($row) {
                    $row = is_array($row) ? $row : [];

                    return [
                        'icon_class' => trim((string) ($row['icon_class'] ?? '')),
                        'url' => trim((string) ($row['url'] ?? '')),
                        'visible' => filter_var($row['visible'] ?? false, FILTER_VALIDATE_BOOL),
                    ];
                })
                ->filter(fn (array $r) => $r['icon_class'] !== '' && $r['url'] !== '')
                ->values()
                ->all();

            $payload = ['links' => $links];
            $contentJson = [
                'en' => $payload,
                'ar' => $payload,
            ];

            $pageSeo->update([
                'section_type' => $validatedData['section_type'],
                'order' => $validatedData['order'],
                'status' => $validatedData['status'],
                'content_json' => $contentJson,
            ]);

            return redirect()
                ->route('admin.pages.sections.index', ['page' => $pageSeo->page_id])
                ->with('success', __('Page section updated successfully.'));
        }

        // Process both languages
        foreach (['en', 'ar'] as $lang) {
            if (! isset($contentJson[$lang])) {
                $contentJson[$lang] = [];
            }

            // Handle single image upload
            if ($request->hasFile("image_uploads.$lang.image")) {
                $file = $request->file("image_uploads.$lang.image");

                // Delete old image if exists
                if (isset($contentJson[$lang]['image']) && ! empty($contentJson[$lang]['image'])) {
                    $oldImagePath = public_path($contentJson[$lang]['image']);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Store new image
                $filename = 'seo_'.$lang.'_'.$pageSeo->id.'_'.time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/seo-images'), $filename);
                $contentJson[$lang]['image'] = 'uploads/seo-images/'.$filename;
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
                        $filename = 'seo_'.$lang.'_'.$pageSeo->id.'_'.time().'_'.rand(1000, 9999).'.'.$upload->getClientOriginalExtension();
                        $upload->move(public_path('uploads/seo-images'), $filename);
                        $contentJson[$lang]['images'][] = 'uploads/seo-images/'.$filename;
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
            ->route('admin.pages.sections.index', ['page' => $pageSeo->page_id])
            ->with('success', __('Page section updated successfully.'));
    }
}

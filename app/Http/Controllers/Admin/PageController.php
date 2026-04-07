<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\Admin\AdminListStatistics;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::with('pageSeos')->get();
        $stats = AdminListStatistics::pages();

        return view('admin.pages.pages.index', compact('pages', 'stats'));
    }


    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
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

        try {
            $uploadDirectory = $this->ensurePagesUploadDirectory();
            $timestamp = now()->timestamp;

            if ($request->hasFile('meta_tags_image_en')) {
                $metaTags['en']['image'] = $this->replaceMetaImage(
                    file: $request->file('meta_tags_image_en'),
                    oldRelativePath: $page->meta_tags['en']['image'] ?? null,
                    uploadDirectory: $uploadDirectory,
                    filenamePrefix: "page_{$id}_en_{$timestamp}"
                );
            }

            if ($request->hasFile('meta_tags_og_image_en')) {
                $metaTags['en']['og_image'] = $this->replaceMetaImage(
                    file: $request->file('meta_tags_og_image_en'),
                    oldRelativePath: $page->meta_tags['en']['og_image'] ?? null,
                    uploadDirectory: $uploadDirectory,
                    filenamePrefix: "page_{$id}_en_og_{$timestamp}"
                );
            }

            if ($request->hasFile('meta_tags_image_ar')) {
                $metaTags['ar']['image'] = $this->replaceMetaImage(
                    file: $request->file('meta_tags_image_ar'),
                    oldRelativePath: $page->meta_tags['ar']['image'] ?? null,
                    uploadDirectory: $uploadDirectory,
                    filenamePrefix: "page_{$id}_ar_{$timestamp}"
                );
            }

            if ($request->hasFile('meta_tags_og_image_ar')) {
                $metaTags['ar']['og_image'] = $this->replaceMetaImage(
                    file: $request->file('meta_tags_og_image_ar'),
                    oldRelativePath: $page->meta_tags['ar']['og_image'] ?? null,
                    uploadDirectory: $uploadDirectory,
                    filenamePrefix: "page_{$id}_ar_og_{$timestamp}"
                );
            }
        } catch (\Throwable $exception) {
            Log::error('Failed to upload page meta image.', [
                'page_id' => $id,
                'message' => $exception->getMessage(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', __('Unable to upload image. Please check uploads/pages directory permissions.'));
        }

        $updateData = [
            'slug' => $page->slug,
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

    private function ensurePagesUploadDirectory(): string
    {
        $directory = public_path('uploads/pages');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        if (!is_writable($directory)) {
            throw new \RuntimeException('uploads/pages directory is not writable.');
        }

        return $directory;
    }

    private function replaceMetaImage(
        UploadedFile $file,
        ?string $oldRelativePath,
        string $uploadDirectory,
        string $filenamePrefix
    ): string {
        $this->deleteOldImage($oldRelativePath);

        $extension = $file->getClientOriginalExtension();
        $filename = $filenamePrefix . '.' . $extension;
        $file->move($uploadDirectory, $filename);

        return 'uploads/pages/' . $filename;
    }

    private function deleteOldImage(?string $relativePath): void
    {
        if (empty($relativePath)) {
            return;
        }

        $fullPath = public_path($relativePath);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }

}

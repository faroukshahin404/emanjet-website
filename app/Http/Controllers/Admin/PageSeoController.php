<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        // return response()->json($pageSeo->content_json);
        return view('admin.pages.pages-seo.edit', compact('pageSeo'));
    }
    public function update(Request $request, $id)
    {
        $pageSeo = PageSeo::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'section_type' => 'required|string|max:255',
            'order' => 'required|integer',
            'status' => 'required|boolean',
            'content_json' => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Process content_json data
        $contentJson = $request->content_json;

        $pageSeo->update([
            'section_type' => $request->section_type,
            'content_json' => $contentJson,
            'order' => $request->order,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.pages-seo.index', $pageSeo->page_id)
            ->with('success', 'SEO section updated successfully');
    }
    //     public function update(Request $request, $id)
// {
//     $pageSeo = PageSeo::findOrFail($id);

    //     $validator = Validator::make($request->all(), [
//         'section_type' => 'required|string|max:255',
//         'order' => 'required|integer',
//         'status' => 'required|boolean',
//         'content_json' => 'required|array',
//     ]);

    //     if ($validator->fails()) {
//         return redirect()->back()
//             ->withErrors($validator)
//             ->withInput();
//     }

    //     // Get current content for reference when updating images
//     $currentContent = is_array($pageSeo->content_json) ? $pageSeo->content_json : json_decode($pageSeo->content_json, true);

    //     // Process content_json data
//     $contentJson = $request->content_json;

    //     // Process image uploads in content_json
//     foreach ($contentJson as $lang => $content) {
//         foreach ($content as $key => $value) {
//             // Handle image field uploads
//             if (stripos($key, 'image') !== false && $request->hasFile("file_{$lang}_{$key}")) {
//                 // Delete old file if exists
//                 if (isset($currentContent[$lang][$key]) && !empty($currentContent[$lang][$key])) {
//                     $oldImagePath = public_path($currentContent[$lang][$key]);
//                     if (file_exists($oldImagePath)) {
//                         unlink($oldImagePath);
//                     }
//                 }

    //                 $file = $request->file("file_{$lang}_{$key}");
//                 $filename = 'seo_' . $pageSeo->id . '_' . $lang . '_' . $key . '_' . time() . '.' . $file->getClientOriginalExtension();
//                 $file->move(public_path('uploads/pages/seo'), $filename);
//                 $contentJson[$lang][$key] = 'uploads/pages/seo/' . $filename;
//             }

    //             // Handle arrays of objects that might contain images
//             if (is_array($value)) {
//                 foreach ($value as $index => $item) {
//                     if (is_array($item)) {
//                         foreach ($item as $itemKey => $itemValue) {
//                             if (stripos($itemKey, 'image') !== false && $request->hasFile("file_{$lang}_{$key}_{$index}_{$itemKey}")) {
//                                 // Delete old file if exists
//                                 if (isset($currentContent[$lang][$key][$index][$itemKey]) && !empty($currentContent[$lang][$key][$index][$itemKey])) {
//                                     $oldImagePath = public_path($currentContent[$lang][$key][$index][$itemKey]);
//                                     if (file_exists($oldImagePath)) {
//                                         unlink($oldImagePath);
//                                     }
//                                 }

    //                                 $file = $request->file("file_{$lang}_{$key}_{$index}_{$itemKey}");
//                                 $filename = 'seo_' . $pageSeo->id . '_' . $lang . '_' . $key . '_' . $index . '_' . $itemKey . '_' . time() . '.' . $file->getClientOriginalExtension();
//                                 $file->move(public_path('uploads/pages/seo'), $filename);
//                                 $contentJson[$lang][$key][$index][$itemKey] = 'uploads/pages/seo/' . $filename;
//                             }
//                         }
//                     }
//                 }
//             }
//         }
//     }

    //     $pageSeo->update([
//         'section_type' => $request->section_type,
//         'content_json' => $contentJson,
//         'order' => $request->order,
//         'status' => $request->status,
//     ]);

    //     return redirect()->route('admin.pages-seo.index', $pageSeo->page_id)
//         ->with('success', 'SEO section updated successfully');
// }
}

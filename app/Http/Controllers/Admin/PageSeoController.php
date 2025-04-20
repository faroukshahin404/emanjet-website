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
        return view('admin.pages.pages-seo.edit', compact('pageSeo'));
    }
    public function update(Request $request, $id)
    {
        $pageSeo = PageSeo::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'section_type' => 'required|string|max:255',
            'order' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $contentJson = json_decode($pageSeo->content_json, true);

        foreach ($request->except(['_token', '_method', 'section_type', 'order', 'status']) as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $nestedKey => $nestedValue) {
                    if (isset($contentJson[$key]) && is_array($contentJson[$key])) {
                        $contentJson[$key][$nestedKey] = $nestedValue;
                    }
                }
            } else {
                $contentJson[$key] = $value;
            }
        }

        $pageSeo->update([
            'section_type' => $request->section_type,
            'content_json' => json_encode($contentJson),
            'order' => $request->order,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.pages-seo.index', $pageSeo->page_id)
            ->with('success', 'SEO section updated successfully');
    }
}

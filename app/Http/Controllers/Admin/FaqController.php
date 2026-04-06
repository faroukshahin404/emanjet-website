<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FaqRequest;
use App\Models\Faq;
use App\Services\Admin\AdminListStatistics;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Faq::query();

        if ($request->filled('search')) {
            $term = '%'.$request->search.'%';
            $query->where(function ($q) use ($term) {
                $q->where('question->en', 'like', $term)
                    ->orWhere('question->ar', 'like', $term)
                    ->orWhere('answer->en', 'like', $term)
                    ->orWhere('answer->ar', 'like', $term);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->boolean('status'));
        }

        $results = $query->ordered()->paginate()->withQueryString();
        $stats = AdminListStatistics::faqs();

        return view('admin.pages.faqs.index', compact('results', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqRequest $request)
    {
        Faq::create($request->validated());

        return redirect()->route('admin.faqs.index')->with('success', __('FAQ created successfully.'));
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
        $item = Faq::findOrFail($id);

        return view('admin.pages.faqs.create', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FaqRequest $request, string $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->update($request->validated());

        return redirect()->route('admin.faqs.index')->with('success', __('FAQ updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', __('FAQ deleted successfully.'));
    }
}

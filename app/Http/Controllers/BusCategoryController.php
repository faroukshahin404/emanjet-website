<?php

namespace App\Http\Controllers;

use App\Models\BusCategory;
use Illuminate\Http\Request;

class BusCategoryController extends Controller
{

    public function index()
    {
        $results = BusCategory::get();
        return view('admin.pages.bus-categories.index', compact('results'));
    }
    public function create()
    {
        return view('admin.pages.bus-categories.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0|max:5',
            'passengers' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $busCategory = new BusCategory();
        $busCategory->name_ar = $validated['name_ar'];
        $busCategory->name_en = $validated['name_en'];
        $busCategory->rate = $validated['rate'];
        $busCategory->passengers = $validated['passengers'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('bus-categories', $filename, 'public');
            $busCategory->image = $path;
        }

        $busCategory->save();

        return redirect()->route('admin.bus-categories.index')
            ->with('success', __('Bus category created successfully'));

    }
    public function edit()
    {

    }
    public function update()
    {

    }
    public function delete()
    {

    }



}

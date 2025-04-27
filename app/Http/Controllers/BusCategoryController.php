<?php

namespace App\Http\Controllers;

use App\Models\BusCategory;
use Illuminate\Http\Request;

class BusCategoryController extends Controller
{

    public function index()
    {
        $results = BusCategory::paginate();
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
    
        // Handle image upload using the same method as in the example
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'bus_category_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/bus-categories'), $filename);
            $busCategory->image = 'uploads/bus-categories/' . $filename;
        }
    
        $busCategory->save();
    
        return redirect()->route('admin.bus-categories.index')
            ->with('success', __('Bus category created successfully'));
    }
    public function edit($id)
    {
        $item = BusCategory::find($id);
        return view('admin.pages.bus-categories.create' , compact('item'));

    }

    public function update(Request $request, $id)
    {
        $busCategory = BusCategory::findOrFail($id);
        
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0|max:5',
            'passengers' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $busCategory->name_ar = $validated['name_ar'];
        $busCategory->name_en = $validated['name_en'];
        $busCategory->rate = $validated['rate'];
        $busCategory->passengers = $validated['passengers'];
        
        if ($request->hasFile('image')) {
            if ($busCategory->image && !empty($busCategory->image)) {
                $oldImagePath = public_path($busCategory->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            $file = $request->file('image');
            $filename = 'bus_category_' . $id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/bus-categories'), $filename);
            $busCategory->image = 'uploads/bus-categories/' . $filename;
        }
        
        $busCategory->save();
        
        return redirect()->route('admin.bus-categories.index')
            ->with('success', __('Bus category updated successfully'));
    }
    
    public function destroy($id)
    {
        $busCategory = BusCategory::findOrFail($id);
        
        if ($busCategory->image && !empty($busCategory->image)) {
            $imagePath = public_path($busCategory->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $busCategory->delete();
        
        return redirect()->route('admin.bus-categories.index')
            ->with('success', __('Bus category deleted successfully'));
    }
}

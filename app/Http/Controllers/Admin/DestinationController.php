<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DestinationRequest;
use App\Models\Destination;
use App\Traits\UploadFile;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    use UploadFile;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Destination::query();

        if ($request->filled('destination')) {
            $query->where('id', $request->destination);
        }

        $results = $query->latest()->paginate();
        $destinations = Destination::all();

        return view('admin.pages.destinations.index', compact('results', 'destinations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.destinations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DestinationRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload($request->file('image'), 'destinations', $data['name']['en']);
        }

        foreach (['en', 'ar'] as $lang) {
            if (!empty($data['meta_tags'][$lang])) {
                $data['meta_tags'][$lang] = array_map('trim', explode(',', $data['meta_tags'][$lang]));
            }
        }

        Destination::create($data);

        return redirect()->route('admin.destinations.index')->with('success', __('Destination created successfully.'));
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
        $item = Destination::findOrFail($id);
        return view('admin.pages.destinations.create', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DestinationRequest $request, string $id)
    {
        $destination = Destination::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($destination->image) {
                $this->deleteImage($destination->image);
            }

            $data['image'] = $this->upload($request->file('image'), 'destinations', $data['name']['en']);
        }

        foreach (['en', 'ar'] as $lang) {
            if (!empty($data['meta_tags'][$lang])) {
                $data['meta_tags'][$lang] = array_map('trim', explode(',', $data['meta_tags'][$lang]));
            }
        }

        $destination->update($data);

        return redirect()->route('admin.destinations.index')->with('success', __('Destination updated successfully.'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destination = Destination::findOrFail($id);

        if ($destination->image) {
            $this->deleteImage($destination->image);
        }

        $destination->delete();

        return redirect()->route('admin.destinations.index')->with('success', __('Destination deleted successfully.'));
    }
}

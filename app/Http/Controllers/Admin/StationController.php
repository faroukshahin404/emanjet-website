<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function index(Request $request)
    {
        $query = Station::query();
        if ($request->has('station') && $request->station != '') {
            $query->where('id', $request->station);
        }
        if ($request->has('status') && $request->status != '') {
            $query->where('is_available', $request->status);
        }
        $results = $query->paginate();
        $stations = Station::all();
        return view('admin.pages.stations.index', compact('results', 'stations'));
    }

    public function toggleAvailableOnline(Request $request, Station $station)
    {
        $station->available_online = !$station->available_online;
        $station->save();

        return response()->json(['success' => true]);
    }
}

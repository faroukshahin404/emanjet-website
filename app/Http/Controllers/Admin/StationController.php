<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function index()
    {
        $results = Station::paginate();
        return view('admin.stations.index', compact('results'));
    }

    public function toggleAvailableOnline(Request $request, Station $station)
    {
        $station->available_online = !$station->available_online;
        $station->save();

        return response()->json(['success' => true]);
    }
}

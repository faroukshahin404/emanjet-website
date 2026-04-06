<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Services\Admin\AdminListStatistics;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $query = City::query();
        if ($request->has('city') && $request->city != '') {
            $query->where('id', $request->city);
        }
        if ($request->has('status') && $request->status != '') {
            $query->where('available_online', $request->status);
        }
        $results = $query->paginate()->withQueryString();
        $cities = City::all();
        $stats = AdminListStatistics::cities();

        return view('admin.pages.cities.index', compact('results', 'cities', 'stats'));
    }

    public function toggleAvailableOnline(Request $request, City $city)
    {
        $city->available_online = !$city->available_online;
        $city->save();

        return response()->json(['success' => true]);
    }
}

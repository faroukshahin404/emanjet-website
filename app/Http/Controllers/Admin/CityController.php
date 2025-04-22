<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::paginate();
        return view('admin.cities.index', compact('cities'));
    }

    public function toggleAvailableOnline(Request $request, City $city)
    {
        $city->available_online = !$city->available_online;
        $city->save();

        return response()->json(['success' => true]);
    }
}

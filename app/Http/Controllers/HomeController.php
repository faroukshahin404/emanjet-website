<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Contact;
use App\Models\Station;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $stations = Station::where('available_online', 1)->get();
        $cities = City::available()->orderBy('rank')->get();
        return view('home.index', [
            'stations' => $stations,
            'cities'=> $cities,
        ]);
    }


    public function getCities()
    {
        $cities = City::available()->orderBy('rank')->get();
        $cities->transform(function ($city) {
            return [
                'id' => $city->id,
                'name' => $city->name,
                'image' => $city->image,
            ];
        });

        return response()->json($cities);
    }
    public function getStations(City $city)
    {
        $stations = $city->stations()->where('available_online', 1)->select('id', 'name')->get();
        $stations->transform(function ($station) {
            return [
                'id' => $station->id,
                'name' => $station->name,
            ];
        });

        return response()->json($stations);
    }

    public function tickets()
    {
        return view('mobile.tickets');
    }

    public function settings()
    {
        return view('mobile.settings');
    }

    public function contact_us()
    {
        return view('other.contact-us');
    }
    public function submit_contact_form(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'name' => 'required',
            'message' => 'required'
        ]);
        Contact::create([
            'name' => $request->name,
            'mobile' => $request->phone,
            'message' => $request->message,
        ]);
        return redirect()->back()->with('success', __('Submitted Successfully!'));
    }
}

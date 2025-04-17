<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('home.index');
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
        $stations = $city->stations()->select('id', 'name')->get();
        $stations->transform(function ($station) {
            return [
                'id' => $station->id,
                'name' => $station->name,
            ];
        });

        return response()->json($stations);
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

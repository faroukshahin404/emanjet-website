<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Contact;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $cities = City::available()->orderBy('rank')->get();

        return view('home.index', compact('cities'));
    }
    public function contact_us(){
        return view('other.contact-us');
    }
    public function submit_contact_form(Request $request){
        $request->validate([
            'phone'=>'required',
            'name'=>'required',
            'message'=>'required'
        ]);
        Contact::create([
            'name'=>  $request->name,
            'mobile'=> $request->phone,
            'message'=> $request->message,
        ]);
        return redirect()->back()->with('success' , __('Submitted Successfully!'));
    }
}

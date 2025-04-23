<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Models\ReservationBookingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('profile.index', compact('user', ));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('mobile.profile.edite', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
        ],[
            'name.required' => __('Name is required'),
            'mobile.required' => __('Mobile is required'),
            'mobile.max' => __('Mobile must be less than 20 characters'),
        ]);

        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->save();

        return redirect()->route('profile.index')->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }
}

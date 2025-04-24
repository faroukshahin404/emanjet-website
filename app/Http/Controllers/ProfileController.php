<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Models\ReservationBookingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\ViewModels\TicketViewModel;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $requests = ReservationBookingRequest::where('user_id', $user->id)->whereHas('bookingSeats')->get();
        $tickets = $requests->map(fn($res) => (new TicketViewModel($res))->toArray());


        return view('profile.index', compact('user', 'tickets'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('mobile.profile.edite', compact('user'));
    }

    public function settings()
    {
        return view('mobile.other.settings');
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

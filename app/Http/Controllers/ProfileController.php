<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\TicketResource;
use App\Models\ReservationBookingRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ViewModels\TicketViewModel;

class ProfileController extends Controller
{

    public function __construct(protected AuthService $authService)
    {
        $this->authService = $authService;
    }
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
        return view('mobile.profile.edit', compact('user'));
    }

    public function settings()
    {
        return view('mobile.other.settings');
    }

    public function update(ProfileRequest $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
        ],[
            'name.required' => __('Name is required'),
            'email.required' => __('Mobile is required'),
        ]);

        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('mobile.settings')->with('success', __('Profile updated successfully'));
    }
}

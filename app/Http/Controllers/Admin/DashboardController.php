<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_reservations' => \App\Models\ReservationBookingRequest::count(),
            'today_reservations' => \App\Models\ReservationBookingRequest::whereDate('created_at', \Carbon\Carbon::today())->count(),
            'total_revenue'      => \App\Models\ReservationBookingRequest::sum('total'),
            'total_users'        => \App\Models\User::count(),
            'active_trips'       => \App\Models\RunTrip::where('available_online', 1)->count(),
        ];

        $recent_bookings = \App\Models\ReservationBookingRequest::with(['user', 'runTrip', 'stationFrom', 'stationTo'])
            ->latest()
            ->take(8)
            ->get();

        return view('admin.pages.dashboard.index', compact('stats', 'recent_bookings'));
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelTicketResource;
use App\Models\ReservationBookingRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function get_profile()
    {
        if (auth('sanctum')->check()) {

            return response()->json([
                'status' => true,
                'message' => null,
                'data' => auth('sanctum')->user()
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
    }
    public function update_profile(Request $request)
    {
        $user = auth('sanctum')->user();
        if ($request->name) {
            $user->name = $request->name;
        }
        if ($request->email) {
            $user->email = $request->email;
        }

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully!',
            'data' => auth('sanctum')->user()
        ]);
    }
    public function tickets(){
        $user = auth('sanctum')->user();

        $tickets = ReservationBookingRequest::where('user_id', $user->id)->whereHas('bookingSeats')->get();
        return response()->json([
            'status' => true,
            'message' => null,
            'data' => TravelTicketResource::collection($tickets)
        ]);
        
    }
}

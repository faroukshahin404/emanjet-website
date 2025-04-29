<?php

namespace App\Http\Controllers;

use App\Http\Requests\OnewayConfirmBookingRequest;
use App\Services\ConfirmBookingService;
use App\Traits\FawryIntegration;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfirmBookingController extends Controller
{
    protected $confirmBookingService;
    use  FawryIntegration;


    public function __construct(ConfirmBookingService $confirmBookingService)
    {
        $this->confirmBookingService = $confirmBookingService;
    }
    public function confirmBooking(OnewayConfirmBookingRequest $request)
    {
        try {
            DB::beginTransaction();
            $ticket = $this->confirmBookingService->one_way_confirm_booking($request);
            if ($request->payment_method == 'fawry') {
                $payment_link = $this->getPaymentLink($ticket->id, $ticket->total, $ticket->user_id, 1, asset('/'));
                DB::commit();
                return redirect()->to($payment_link);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'success',
                    'data' => $ticket
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

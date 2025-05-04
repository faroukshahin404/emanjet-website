<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OnewayConfirmBookingRequest;
use App\Http\Requests\RoundConfirmBookingRequest;
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
    public function oneway_confirm_booking(OnewayConfirmBookingRequest $request)
    {
        try {
            DB::beginTransaction();

            $ticket = $this->confirmBookingService->one_way_confirm_booking($request , 'application');
            if ($request->payment_method == 'fawry') {
                $payment_link = $this->getPaymentLink($ticket->id, $ticket->total, $ticket->user_id, 1, asset('/'));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'payment_link' => $payment_link,
                    'message' => 'Payment link generated successfully',
                    'data' => $ticket
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Incorrect payment method!'
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            
            
            return response()->json([
                'status' => false,
                'message' => 'Error happened! try again later!',
                'error' => $e->getMessage()
            ]);
        }
    }
    public function round_confirm_booking(RoundConfirmBookingRequest $request)
    {

        try {
            DB::beginTransaction();
            $ticket = $this->confirmBookingService->round_confirm_booking($request, 'application');
            if ($request->payment_method == 'fawry') {
                $payment_link = $this->getPaymentLink($ticket->id, $ticket->total, $ticket->user_id, 1, asset('/'));
                DB::commit();
                return response()->json([
                    'status' => true,
                    'payment_link' => $payment_link,
                    'message' => 'Payment link generated successfully',
                    'data' => $ticket
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Incorrect payment method!'
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Error happened! try again later!',
                'error' => $e->getMessage()
            ]);
        }
    }
}

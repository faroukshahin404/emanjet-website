<?php

namespace App\Http\Controllers;

use App\Models\PaymentDataSave;
use App\Traits\QNBPaymentIntegration;
use App\Models\Page;
use App\Models\ReservationBookingRequest;
use App\Models\RunTrip;
use App\Models\TripStation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use QNBPaymentIntegration;
    public function index($payment_key)
    {
        try {
            $page = Page::where('slug', 'usage-terms')->first();
            $privacePageSeos = $page->pageSeos()->get();
            $heroSection = @$privacePageSeos->first()->translated_content_json;
            $serviceSection = @$privacePageSeos->first()->translated_content_json;
            $tickets = ReservationBookingRequest::where('payment_key', $payment_key)
            ->whereHas('bookingSeats')->get();
            if ($tickets->count() == 0) {
                abort(404);
            }
            $tripTime = $this->getTripTime($tickets->first()->runTrip_id, $tickets->first()->stationFrom_id);
            return view('payment.index')->with([
                'heroSection' => $heroSection,
                'serviceSection' => $serviceSection,
                'tickets' => $tickets,
                'tripTime' => $tripTime
            ]);
        } catch (\Exception $e) {
            abort(404);
        }
    }
    public function getTripTime($runTrip_id, $stationFrom_id = null)
    {
        $runTrip = RunTrip::find($runTrip_id);

        if ($stationFrom_id == null) {
            return Carbon::parse($runTrip->startDate . ' ' . $runTrip->startTime)->format('Y-m-d H:i:s');
        }
        $tripStation = TripStation::where([
            'station_id' => $stationFrom_id,
            'tripData_id' => $runTrip->tripData_id,
        ])->first();

        return Carbon::parse($runTrip->startDate . ' ' . $runTrip->startTime)->addMinutes(@$tripStation->timeInMinutes ?? 0)->format('Y-m-d H:i:s');
    }
    public function confirm(Request $request)
    {
        try {
            $request->validate([
                'payment_key' => 'required',
                'agree' => 'required',
            ]);
            $tickets = ReservationBookingRequest::where('payment_key', $request->payment_key)
            ->whereHas('bookingSeats')->get();
            if ($tickets->count() == 0) {
                abort(404);
            }
            $payment = $this->initiateQNBPaymentLink([
                'amount' => $tickets->sum('total'),
                'order_id' => $request->payment_key,
            ]);
            PaymentDataSave::where('item_id', $request->payment_key)->update([
                'referance_num' => $payment['data']['paymentLink']['id'],
            ]);

            if ($payment['success'] == true) {
                return redirect($payment['url']);
            } else {
                return redirect()->back()->with('error', __('Payment failed'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('Payment failed'));
        }
    }
}

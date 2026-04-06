<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TripDetailsResource;
use App\Models\City;
use App\Http\Resources\CityResource;
use App\Models\Contact;
use App\Models\Page;
use App\Models\RunTrip;
use App\Traits\BookingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PublicServiceController extends Controller
{
    use BookingTrait;

    private function setApiLocale(?Request $request = null): void
    {
        $req = $request ?? request();
        app()->setLocale($req->header('lang', 'ar') === 'en' ? 'en' : 'ar');
    }

    public function cities()
    {
        $this->setApiLocale();

        try {
            $cities = City::with('stations')
                ->whereHas('stations')
                ->where('active', 1)
                ->where('available_online', 1)
                ->get();

            if ($cities->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => __('No data found.'),
                    'data' => [],
                ], 200);
            }

            return response()->json([
                'status' => true,
                'message' => '',
                'data' => CityResource::collection($cities),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Cities API Error: '.$e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching cities',
                'data' => [],
            ], 500);
        }
    }

    public function search_trips(Request $request)
    {
        $this->setApiLocale($request);

        try {
            $validator = Validator::make($request->all(), [
                'station_from_id' => 'required|exists:stations,id',
                'station_to_id' => 'required|exists:stations,id',
                'date' => 'required',
                'seats' => 'nullable|integer',
            ], [
                'station_from_id.required' => __('From station is required!'),
                'station_from_id.exists' => __('Station not found'),
                'station_to_id.required' => __('To station is required'),
                'station_to_id.exists' => __('Station not found'),
                'date.required' => __('Date is required'),
                'date.date' => __('Invalid date format'),
                'seats.integer' => __('Invalid number of seats'),
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => [],
                ], 200);
            }
            $date = $this->parseAnyDate($request->date);

            $trips = $this->getTrips(date: $date, stationFrom_id: $request->station_from_id, stationTo_id: $request->station_to_id, seats: $request->seats);

            return response()->json([
                'status' => true,
                'message' => '',
                'data' => $trips,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Search Trips API Error: '.$e->getMessage());

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => __('An error occurred while fetching trips'),
                'data' => [],
            ], 500);
        }
    }

    public function trip_details(Request $request)
    {
        $this->setApiLocale($request);

        try {
            $validator = Validator::make($request->all(), [
                'trip_id' => 'required|exists:run_trips,id',
                'station_from_id' => 'required|exists:stations,id',
                'station_to_id' => 'required|exists:stations,id',
            ], [
                'trip_id.required' => __('Trip ID is required'),
                'trip_id.exists' => __('Trip not found'),
                'station_from_id.required' => __('From station is required!'),
                'station_from_id.exists' => __('Station not found'),
                'station_to_id.required' => __('To station is required'),
                'station_to_id.exists' => __('Station not found'),

            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => [],
                ], 200);
            }

            $trip = RunTrip::find($request->trip_id);
            if ($trip) {
                $data_json['status'] = true;
                $data_json['message'] = '';
                $data_json['data'] = new TripDetailsResource($trip);

                return response()->json($data_json, 200);
            }
            $data_json['status'] = true;
            $data_json['message'] = "Trip doesn't exist";

            return response()->json($data_json, 400);
        } catch (\Exception $e) {
            Log::error('Search Trips API Error: '.$e->getMessage());

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => __('An error occurred while fetching trips'),
                'data' => [],
            ], 500);
        }
    }

    public function contact_us(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'phone' => 'required',
                    'name' => 'required',
                    'message' => 'required',
                ],
                [
                    'phone.required' => __('Phone is required'),
                    'name.required' => __('Name is required'),
                    'message.required' => __('Message is required'),
                ]
            );
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }
            Contact::create([
                'name' => $request->name,
                'mobile' => $request->phone,
                'message' => $request->message,
            ]);

            return response()->json(['status' => true, 'message' => __('Submitted Successfully!')]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function privacy_policy()
    {
        $page = Page::where('slug', 'privacy-policy')->first();
        $privacePageSeos = $page->pageSeos()->get();
        $heroSection = @$privacePageSeos->first()->translated_content_json;
        $serviceSection = @$privacePageSeos->first()->translated_content_json;
        $seo = getSeoData($page);

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => [
                'title' => $heroSection['title'],
                'description' => $heroSection['description'],
            ],
        ]);
    }

    public function usage_terms()
    {
        $page = Page::where('slug', 'usage-terms')->first();
        $privacePageSeos = $page->pageSeos()->get();
        $heroSection = @$privacePageSeos->first()->translated_content_json;
        $serviceSection = @$privacePageSeos->first()->translated_content_json;
        $seo = getSeoData($page);

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => [
                'title' => $heroSection['title'],
                'description' => $heroSection['description'],
            ],
        ]);
    }
}

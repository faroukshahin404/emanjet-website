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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PublicServiceController extends Controller
{
    use BookingTrait;
    public function cities()
    {
        try {
            $err_message = 'لا يوجد بيانات';
            if (request()->header('lang') == 'en') {
                $err_message = 'not found data';
            }

            $cities = City::with('stations')
                ->whereHas('stations')
                ->where('active', 1)
                ->get();

            if ($cities->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => $err_message,
                    'data' => []
                ], 200);
            }

            return response()->json([
                'status' => true,
                'message' => '',
                'data' => CityResource::collection($cities)
            ], 200);
        } catch (\Exception $e) {
            Log::error('Cities API Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching cities',
                'data' => []
            ], 500);
        }
    }

    public function search_trips(Request $request)
    {
        try {
            $validator =     Validator::make($request->all(), [
                'station_from_id' => 'required|exists:stations,id',
                'station_to_id' => 'required|exists:stations,id',
                'date' => 'required',
                'seats' => 'nullable|integer'
            ], [
                'station_from_id.required' => $request->header('lang') == 'ar' ? 'من محطة مطلوبة!' : 'From station required',
                'station_from_id.exists' => $request->header('lang') == 'ar' ? 'المحطة غير موجودة' : 'Station not found',
                'station_to_id.required' =>  $request->header('lang') == 'ar' ? 'الي محطة مطلوبة' : 'To station required',
                'station_to_id.exists' => $request->header('lang') == 'ar' ? 'المحطة غير موجودة' : 'Station not found',
                'date.required' => $request->header('lang') == 'ar' ? 'التاريخ مطلوب' : 'Date required',
                'date.date' => $request->header('lang') == 'ar' ? 'التاريخ خطأ' : 'Invalid date format',
                'seats.integer' => $request->header('lang') == 'ar' ? 'عدد المقاعد خطأ' : 'Invalid number of seats'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => []
                ], 200);
            }
            $date = $this->parseAnyDate($request->date);
            dd($date);
            
            $trips = $this->getTrips(date: $date, stationFrom_id: $request->station_from_id, stationTo_id: $request->station_to_id, seats: $request->seats);
            return response()->json([
                'status' => true,
                'message' => '',
                'data' => $trips
            ], 200);
        } catch (\Exception $e) {
            Log::error('Search Trips API Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => $request->header('lang') == 'ar' ? 'حدث خطأ أثناء جلب الرحلات' : 'An error occurred while fetching trips',
                'data' => []
            ], 500);
        }
    }
    public function trip_details(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'trip_id' => 'required|exists:run_trips,id',
                'station_from_id' => 'required|exists:stations,id',
                'station_to_id' => 'required|exists:stations,id',
            ], [
                'trip_id.required' => $request->header('lang') == 'ar' ? 'رقم الرحلة مطلوب' : 'Trip ID required',
                'trip_id.exists' => $request->header('lang') == 'ar' ? 'رقم الرحلة غير موجود' : 'Trip not found',
                'station_from_id.required' => $request->header('lang') == 'ar' ? 'من محطة مطلوبة!' : 'From station required',
                'station_from_id.exists' => $request->header('lang') == 'ar' ? 'المحطة غير موجودة' : 'Station not found',
                'station_to_id.required' =>  $request->header('lang') == 'ar' ? 'الي محطة مطلوبة' : 'To station required',
                'station_to_id.exists' => $request->header('lang') == 'ar' ? 'المحطة غير موجودة' : 'Station not found',

            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => []
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
            Log::error('Search Trips API Error: ' . $e->getMessage());
            dd($e);
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => $request->header('lang') == 'ar' ? 'حدث خطأ أثناء جلب الرحلات' : 'An error occurred while fetching trips',
                'data' => []
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
                    'message' => 'required'
                ],
                [
                    'phone.required' => __('Phone is required'),
                    'name.required' => __('Name is required'),
                    'message.required' => __('Message is required')
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
            'status'=>true,
            'message'=>'success',
            'data'=> [
                'title'=>$heroSection['title'],
                'description'=>$heroSection['description']
            ]
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
            'status'=>true,
            'message'=>'success',
            'data'=> [
                'title'=>$heroSection['title'],
                'description'=>$heroSection['description']
            ]
        ]);
    }
}

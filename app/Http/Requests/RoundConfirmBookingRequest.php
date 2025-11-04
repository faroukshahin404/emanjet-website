<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RoundConfirmBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'station_from_id' => 'required|exists:stations,id',
            'station_to_id' => 'required|exists:stations,id',
            'go_date' => 'required|date|after_or_equal:today',
            'back_date' => 'required|date|after_or_equal:go_date',
            'go_trip_id' => 'required|exists:run_trips,id',
            'back_trip_id' => 'required|exists:run_trips,id',
            'go_seat_id' => 'required|array',
            'go_seat_id.*' => 'required|exists:trip_seats,id',
            'round_seat_id' => 'required|array',
            'round_seat_id.*' => 'required|exists:trip_seats,id',
            'payment_method' => 'required|in:fawry,qnb'
        ];
    }

    public function messages(): array
    {
        return [
            'tripType.required' => __('Trip type is required'),
            'tripType.in' => __('Invalid trip type'),

            'city_from_id.required' => __('Departure city is required'),
            'city_from_id.exists' => __('Invalid departure city'),

            'city_to_id.required' => __('Destination city is required'),
            'city_to_id.exists' => __('Invalid destination city'),

            'station_from_id.required' => __('Departure station is required'),
            'station_from_id.exists' => __('Invalid departure station'),

            'station_to_id.required' => __('Arrival station is required'),
            'station_to_id.exists' => __('Invalid arrival station'),

            'go_date.required' => __('Departure date is required'),
            'go_date.date' => __('Invalid departure date'),
            'go_date.after_or_equal' => __('Departure date must be today or later'),

            'back_date.required' => __('Return date is required'),
            'back_date.date' => __('Invalid return date'),
            'back_date.after_or_equal' => __('Return date must be today or later than departure date'),

            'seats.required' => __('Number of seats is required'),
            'seats.integer' => __('Number of seats must be a number'),
            'seats.min' => __('Number of seats must be at least 1'),

            'go_trip_id.required' => __('Outbound trip is required'),
            'go_trip_id.exists' => __('Invalid outbound trip'),

            'back_trip_id.required' => __('Return trip is required'),
            'back_trip_id.exists' => __('Invalid return trip'),

            'go_seat_id.required' => __('Departure seat is required'),
            'go_seat_id.array' => __('Departure seats must be an array'),
            'go_seat_id.*.exists' => __('One or more departure seats are invalid'),

            'round_seat_id.required' => __('Return seat is required'),
            'round_seat_id.array' => __('Return seats must be an array'),
            'round_seat_id.*.exists' => __('One or more return seats are invalid'),

            'payment_method.required' => __('Payment method is required'),
            'payment_method.in' => __('Invalid payment method')
        ];
    }
    public function failedValidation(Validator $validator)
    {
        // If request expects JSON, return a JSON response
        if ($this->expectsJson()) {
            throw new HttpResponseException(
                response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),

                ], 422)
            );
        }

        // Otherwise, use the default behavior (redirect back)
        parent::failedValidation($validator);
    }
}

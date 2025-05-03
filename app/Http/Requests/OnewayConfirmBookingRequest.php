<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OnewayConfirmBookingRequest extends FormRequest
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
            'selected_trip_id' => 'required|exists:run_trips,id',
            'station_from_id' => 'required|exists:stations,id',
            'station_to_id' => 'required|exists:stations,id',
            'seat_id' => 'required|array',
            'seat_id.*' => 'required|exists:trip_seats,id',
            'payment_method' => 'required|in:fawry'
        ];
    }
    public function messages(): array
    {
        return [
            'selected_trip_id.required' => __('Please select a trip.'),
            'selected_trip_id.exists' => __('The selected trip does not exist.'),

            'station_from_id.required' => __('Please select a departure station.'),
            'station_from_id.exists' => __('The selected station is invalid.'),

            'station_to_id.required' => __('Please select a destination station.'),
            'station_to_id.exists' => __('The selected destination station is invalid.'),

            'seat_id.required' => __('Please select at least one seat.'),
            'seat_id.array' => __('Seat selection must be in array format.'),

            'seat_id.*.exists' => __('One or more selected seats are invalid.'),

            'payment_method.required' => __('Please select a payment method.'),
            'payment_method.in' => __('The selected payment method is invalid.'),
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

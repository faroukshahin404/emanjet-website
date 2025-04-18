<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'station_from_id'=>'required|exists:stations,id',
            'station_to_id'=>'required|exists:stations,id',
            'seat_id'=>'required|array',
            'seat_id.*'=>'required|exists:trip_seats,id',
            'payment_method'=>'required|in:fawry'
        ];
    }
    public function messages(): array
    {
        return [
            'selected_trip_id.required' => 'Please select a trip.',
            'selected_trip_id.exists' => 'The selected trip does not exist.',

            'station_from_id.required' => 'Please select a departure station.',
            'station_from_id.exists' => 'The selected station is invalid.',

            'seat_id.required' => 'Please select at least one seat.',
            'seat_id.array' => 'Seat selection must be in array format.',

            'seat_id.*.exists' => 'One or more selected seats are invalid.',
        ];
    }
}

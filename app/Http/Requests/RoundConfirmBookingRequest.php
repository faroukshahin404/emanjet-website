<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'tripType' => 'required|in:oneway,round',
            'city_from_id' => 'required|exists:cities,id',
            'city_to_id' => 'required|exists:cities,id',
            'station_from_id' => 'required|exists:stations,id',
            'station_to_id' => 'required|exists:stations,id',
            'go_date' => 'required|date|after_or_equal:today',
            'back_date' => 'required|date|after_or_equal:go_date',
            'seats' => 'required|integer|min:1',
            'go_trip_id' => 'required|exists:run_trips,id',
            'back_trip_id' => 'required|exists:run_trips,id',
            'go_seat_id' => 'required|array',
            'go_seat_id.*' => 'required|exists:trip_seats,id',
            'round_seat_id' => 'required|array',
            'round_seat_id.*' => 'required|exists:trip_seats,id',
            'payment_method' => 'required|in:fawry'
        ];
    }

    public function messages(): array
    {
        return [
            'tripType.required' => 'نوع الرحلة مطلوب',
            'tripType.in' => 'نوع الرحلة غير صالح',

            'city_from_id.required' => 'مدينة المغادرة مطلوبة',
            'city_from_id.exists' => 'مدينة المغادرة غير صالحة',

            'city_to_id.required' => 'مدينة الوصول مطلوبة',
            'city_to_id.exists' => 'مدينة الوصول غير صالحة',

            'station_from_id.required' => 'محطة المغادرة مطلوبة',
            'station_from_id.exists' => 'محطة المغادرة غير صالحة',

            'station_to_id.required' => 'محطة الوصول مطلوبة',
            'station_to_id.exists' => 'محطة الوصول غير صالحة',

            'go_date.required' => 'تاريخ الذهاب مطلوب',
            'go_date.date' => 'تاريخ الذهاب غير صالح',
            'go_date.after_or_equal' => 'تاريخ الذهاب يجب أن يكون بعد أو يساوي تاريخ اليوم',

            'back_date.required' => 'تاريخ العودة مطلوب',
            'back_date.date' => 'تاريخ العودة غير صالح',
            'back_date.after_or_equal' => 'تاريخ العودة يجب أن يكون بعد أو يساوي تاريخ الذهاب',

            'seats.required' => 'عدد المقاعد مطلوب',
            'seats.integer' => 'عدد المقاعد يجب أن يكون رقماً',
            'seats.min' => 'عدد المقاعد يجب أن يكون 1 على الأقل',

            'go_trip_id.required' => 'رحلة الذهاب مطلوبة',
            'go_trip_id.exists' => 'رحلة الذهاب غير صالحة',

            'back_trip_id.required' => 'رحلة العودة مطلوبة',
            'back_trip_id.exists' => 'رحلة العودة غير صالحة',

            'go_seat_id.required' => 'مقاعد الذهاب مطلوبة',
            'go_seat_id.array' => 'مقاعد الذهاب يجب أن تكون مصفوفة',
            'go_seat_id.*.exists' => 'واحد أو أكثر من مقاعد الذهاب غير صالحة',

            'round_seat_id.required' => 'مقاعد العودة مطلوبة',
            'round_seat_id.array' => 'مقاعد العودة يجب أن تكون مصفوفة',
            'round_seat_id.*.exists' => 'واحد أو أكثر من مقاعد العودة غير صالحة',

            'payment_method.required' => 'طريقة الدفع مطلوبة',
            'payment_method.in' => 'طريقة الدفع غير صالحة'
        ];
    }
} 
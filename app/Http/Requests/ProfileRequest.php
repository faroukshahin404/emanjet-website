<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
class ProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:20', 'unique:users,mobile,' . auth()->id()],
            'gender' => ['nullable', 'in:male,female'],
            'birthdate' => ['nullable', 'date'],
            'current_password' => ['nullable', 'min:6'],
            'password' => ['nullable', 'min:6', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('The name is required'),
            'name.string' => __('The name must be a string'),
            'name.max' => __('The name should not exceed 255 characters'),
            'mobile.required' => __('The mobile number is required'),
            'mobile.string' => __('The mobile number must be a string'),
            'mobile.max' => __('The mobile number should not exceed 20 characters'),
            'mobile.unique' => __('The mobile number already exists'),
            'gender.in' => __('Gender must be male or female'),
            'birthdate.date' => __('The birthdate must be a valid date'),
            'current_password.min' => __('The current password must be at least 6 characters'),
            'password.min' => __('The new password must be at least 6 characters'),
            'password.confirmed' => __('The password confirmation does not match'),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }
}


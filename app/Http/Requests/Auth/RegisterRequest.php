<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'max:255',
                'regex:/^(01)[0-9]{9}$/', // Egyptian mobile format (01 + 9 digits)
                'unique:users,mobile',
            ],
            "password" => "required|string|min:6|confirmed",
            "password_confirmation" => "required|string",
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __("Name is required"),
            'phone.required' => __("Phone number is required"),
            'phone.regex' => __("Phone number must start with 01 and be followed by 9 digits"),
            'phone.unique' => __("Phone number already exists"),
            'password.required' => __("Password is required"),
            'password.string' => __("Password must be a string"),
            'password.confirmed' => __("Password confirmation does not match"),
            'password_confirmation.required' => __("Password confirmation is required"),
            'password_confirmation.string' => __("Password confirmation must be a string"),
            'password_confirmation.confirmed' => __("Password confirmation does not match"),
            'password.min' => __("Password must be at least 6 characters."),

        ];
    }
}

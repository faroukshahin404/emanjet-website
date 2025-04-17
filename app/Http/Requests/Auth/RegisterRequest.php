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
                'regex:/^(01)[0-9]{9}$/',  // التأكد من رقم الهاتف
                'unique:users,mobile',
            ],
            "password" => "required|string|min:8|confirmed",
            "password_confirmation" => "required|string|min:8",
        ];
    }
}

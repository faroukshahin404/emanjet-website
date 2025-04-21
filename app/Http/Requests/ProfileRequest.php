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

    public function failedValidation(Validator $validator)
    {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }
}


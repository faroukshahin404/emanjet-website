<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AdminUpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password:admin'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ];
    }

    public function attributes(): array
    {
        return [
            'current_password' => __('Current password'),
            'password' => __('New password'),
        ];
    }
}

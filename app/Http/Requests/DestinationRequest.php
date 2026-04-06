<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestinationRequest extends FormRequest
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
        $languages = ['en', 'ar'];

        $rules = [
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'order' => ['nullable', 'integer', 'min:0'],
        ];

        foreach ($languages as $lang) {
            $rules["name.$lang"] = ['required', 'string', 'max:255'];
            $rules["content.$lang"] = ['required', 'string'];
            $rules["meta_title.$lang"] = ['nullable', 'string', 'max:255'];
            $rules["meta_description.$lang"] = ['nullable', 'string'];
            $rules["meta_tags.$lang"] = ['nullable', 'string'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.*.required' => __('The name field is required.'),
            'content.*.required' => __('The content field is required.'),
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->boolean('status'),
            'order' => $this->filled('order') ? (int) $this->input('order') : 0,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'boolean'],
        ];

        foreach (['en', 'ar'] as $lang) {
            $rules["question.$lang"] = ['required', 'string', 'max:255'];
            $rules["answer.$lang"] = ['required', 'string'];
        }

        return $rules;
    }

    /**
     * Localized attribute names for validation errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        $attrs = [
            'order' => __('Order'),
            'status' => __('Status'),
        ];

        foreach (['en' => __('English'), 'ar' => __('Arabic')] as $lang => $label) {
            $attrs["question.$lang"] = __('Question') . ' (' . $label . ')';
            $attrs["answer.$lang"] = __('Answer') . ' (' . $label . ')';
        }

        return $attrs;
    }
}

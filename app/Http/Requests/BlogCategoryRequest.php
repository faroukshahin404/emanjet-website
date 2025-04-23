<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogCategoryRequest extends FormRequest
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
    public function rules()
    {
        $categoryId = $this->route('blog-category') ? $this->route('blog-category')->id : null;

        return [
            'name.en' => 'required|string|max:255',
            'name.ar' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('blog_categories', 'slug')->ignore($categoryId)
            ]
        ];
    }
    public function attributes()
    {
        return [
            'name.en' => 'English Name',
            'name.ar' => 'Arabic Name',
        ];
    }
}

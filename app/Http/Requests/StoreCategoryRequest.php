<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_name' => 'required',
            'section_id' => 'required',
            'url' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'category_name' => 'Category name is required.',
            'section_id' => 'Section ID is required',
            'url' => 'URL is required',
        ];
    }
}

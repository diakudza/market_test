<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:10|unique:brands,title',
            'display_on_home' => 'nullable|boolean',
            'banner_title' => 'nullable|string|min:10',
            'banner_description' => 'nullable|string|min:10',
        ];
    }
}

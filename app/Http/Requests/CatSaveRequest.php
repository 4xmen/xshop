<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasRole('super-admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name' => ['required', 'string', 'min:2', 'max:128'],
            'description' => ['nullable', 'string', 'min:5'],
            'parent_id' => ['nullable', 'exists:cats,id'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}

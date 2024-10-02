<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:128'],
            'subtitle' => ['nullable', 'string',],
            'image' => ['nullable', 'file', 'mimes:jpg,svg,png'],
            'bg' => ['nullable', 'file', 'mimes:jpg,svg,png'],
            'description' => ['nullable', 'string',],
            'parent_id' => ['nullable', 'exists:groups,id'],
            'canonical' => ['nullable', 'url', 'min:5', 'max:128'],
        ];
    }
}

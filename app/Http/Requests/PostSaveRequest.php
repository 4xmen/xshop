<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostSaveRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255', 'min:2'],
            'subtitle' => ['nullable', 'string', 'max:2048'],
            'body' => ['required', 'string', 'min:5'],
            'status' => ['required'],
            'is_pin' => ['nullable'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'icon' => ['nullable', 'string', 'min:3'],
            'group_id' => ['required', 'exists:groups,id'],
            'canonical' => ['nullable', 'url', 'min:5', 'max:128'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClipSaveRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255','min:5'],
            'body' => ['nullable', 'string',],
            'active' => ['nullable', 'boolean'],
            'clip' => ['nullable', 'mimes:mp4', 'max:'.getMaxUploadSize()],
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }
}

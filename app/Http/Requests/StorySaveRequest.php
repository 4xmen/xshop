<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorySaveRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'file', 'mimes:jpg,png'],
            'file' => ['nullable', 'file', 'mimes:mp4,jpg,png,gif,webp','max:'.getMaxUploadSize()],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttachmentSaveRequest extends FormRequest
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
            'title' => ['required','string','min:2'],
            'body' => ['nullable','string'],
            'subtitle' => ['nullable','string'],
            'file' => ['nullable','mimes:png,jpg,svg,mp4,pdf,docx,zip,rar,mp3','max:'.getMaxUploadSize()]
        ];
    }
}

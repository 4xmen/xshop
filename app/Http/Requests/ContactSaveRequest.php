<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactSaveRequest extends FormRequest
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
            //
            'full_name' => ['required', 'string', 'max:255', 'min:3'],
            'Phone' => ['required', 'string', 'max:15', 'min:8'],
            'subject' => ['nullable', 'string', 'max:255', 'min:4'],
            'email' => ['required', 'email', 'max:255', 'min:4'],
            'bodya' => ['required', 'string', 'max:4048', 'min:15'],
        ];
    }
}

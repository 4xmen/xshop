<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransportSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
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
            'title' => ['required','string','min:4'],
            'price' => ['required','integer'],
            'description' => ['nullable','string']
        ];
    }
}

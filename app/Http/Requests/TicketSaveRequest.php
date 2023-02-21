<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('customer')->check();
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
            'title' => ['nullable','string'],
            'body'=>['required','string','min:5']
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressSaveRequest extends FormRequest
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
            'address'=> ['required', 'string', 'min:10'],
            'state'=> ['required', 'numeric'],
            'city'=> ['required', 'numeric'],
        ];
    }
}

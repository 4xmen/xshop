<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class customerUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('customers')->ignore($this->route()->customer->id)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'mobile' => ['required', 'string', 'min:10',Rule::unique('customers')->ignore($this->route()->customer->id)],
            'postal_code' => ['required', 'string', 'min:10'],
            'address' => ['required', 'string', 'min:10'],
            'state' => ['required', 'numeric'],
            'city' => ['required', 'numeric'],
        ];
    }
}

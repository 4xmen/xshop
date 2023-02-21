<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('customer')->check();
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
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('customers')->ignore(Auth::guard('customer')->id())],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'mobile' => ['required', 'string', 'min:10',Rule::unique('customers')->ignore(Auth::guard('customer')->id())],
            'postal_code' => ['required', 'string', 'min:10'],
            'address' => ['required', 'string', 'min:10'],
            'state' => ['required', 'numeric'],
            'city' => ['required', 'numeric'],
        ];
    }
}

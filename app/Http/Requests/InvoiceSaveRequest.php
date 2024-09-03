<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceSaveRequest extends FormRequest
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
            'transport_id' => ['nullable', 'integer', 'exists:transports,id'],
            'address_id' => ['nullable', 'integer', 'exists:addresses,id'],
            'tracking_code' => ['nullable', 'string'],
            'status' => ['required', 'string'],
        ];
    }
}

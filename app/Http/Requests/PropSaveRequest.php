<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasRole('super-admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|required|min:2|max:90',
            'label' => 'string|required|min:2|max:90',
            'category' => 'required|exists:cats,id',
            'icon'=> 'nullable|string',
            'type' => 'string|min:4'
        ];
    }
}

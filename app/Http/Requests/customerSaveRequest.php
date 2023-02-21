<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\URL;

class customerSaveRequest extends FormRequest
{


    public function __construct()
    {
        $this->redirect = URL::previous() . '#register';
    }
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'mobile'=> ['required', 'string', 'min:10'],
            'postal_code'=> ['required', 'string', 'min:10'],
            'address'=> ['required', 'string', 'min:10'],
            'state'=> ['required', 'numeric'],
            'city'=> ['required', 'numeric'],
        ];
    }
}

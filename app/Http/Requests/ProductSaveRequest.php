<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;



class ProductSaveRequest extends FormRequest
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
            //
//            'name' => ['required', 'string', 'min:5', 'max:128','unique:products,name,'.$this->name],
            'name' => ['required', 'string', 'min:5', 'max:128',Rule::unique('products')->ignore($this->id)],
            'body' => ['nullable', 'string', 'min:5'],
            'excerpt' => ['required', 'string', 'min:5'],
            'active'=>['nullable','boolean'],
            'meta' => ['nullable'],
            'cat_id' => ['required', 'exists:cats,id'],
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSaveRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:5', 'max:128', "unique:products,name," . $this->id],
            'sku' => ['nullable', 'string', 'min:1', 'max:128', "unique:products,sku," . $this->id],
            'body' => ['nullable', 'string', 'min:5'],
            'excerpt' => ['required', 'string', 'min:5'],
            'active' => ['nullable', 'boolean'],
            'meta' => ['nullable'],
            'category_id' => ['required', 'exists:categories,id'],
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'canonical' => ['nullable', 'url', 'min:5', 'max:128'],
        ];
    }
}

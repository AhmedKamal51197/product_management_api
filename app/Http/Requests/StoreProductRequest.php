<?php

namespace App\Http\Requests;

use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>['required', 'string', 'max:255',new NotNumbersOnly(),'unique:products,name'],
            'description'=>['required', 'string', 'max:255',new NotNumbersOnly()],
            'price'=>['required', 'numeric', 'min:0'],
            'quatnity'=>['required', 'integer', 'min:0'],
            'image'=>['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'status'=>['required', 'boolean'],

        ];
    }
}

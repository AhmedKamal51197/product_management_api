<?php

namespace App\Http\Requests;

use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name'=>[ 'sometimes','string', 'max:255',new NotNumbersOnly(),'unique:products,name,'.$this->product->id],
            'description'=>[ 'sometimes','string', 'max:255',new NotNumbersOnly()],
            'price'=>[ 'sometimes','numeric', 'min:0'],
            'quantity'=>['sometimes', 'integer', 'min:0'],
            'image'=>[ 'sometimes','image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'status'=>[ 'sometimes','in:active,inactive'],
        ];
    }
}

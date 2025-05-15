<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Traits\ApiResponse;

class InitializeBasketRequest extends FormRequest
{
    use ApiResponse;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'products' => 'required|array',
            'products.*.code' => 'required|string|unique:products,code',
            'products.*.name' => 'required|string',
            'products.*.price' => 'required|numeric',
            'delivery_rules' => 'required|array',
            'offers' => 'required|array',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = $this->errorResponse('Validation failed', $validator->errors(), 422);

        throw new ValidationException($validator, $response);
    }
}

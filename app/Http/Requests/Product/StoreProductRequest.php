<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{


    public function rules(): array
    {
        return [
            'name' => [
                'required'
            ],
            'avg_price' => [
                'required'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'avg_price' => 'O campo preço é obrigatório',
        ];
    }
}

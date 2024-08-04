<?php

namespace App\Http\Requests;

use App\Enums\PaymentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrderRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => [
                'required',
                'exists:users,id',
            ],
            'employee_id' => [
                'required',
                'exists:users,id',
            ],
            'total' => [
                'required',
            ],
            'description' => [
                'sometimes'
            ],
            'payment_type' => [
                'required',
                Rule::in([
                    PaymentType::CREDIT->value,
                    PaymentType::DEBIT->value,
                    PaymentType::PIX->value,
                    PaymentType::CASH->value,
                ]),
            ],
            'items' => [
                'required',
                'array',
                'min:1',
            ],
            'items.*.product_id' => [
                'required',
                'exists:products,id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }
}

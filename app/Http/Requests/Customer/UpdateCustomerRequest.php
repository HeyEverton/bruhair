<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
            ],
            'email' => [
                'sometimes',
                'email',
                'unique:users,email,' . $this->route('id'),
            ],
            'phone_number' => [
                'sometimes',
            ],
            'birthdate' => [
                'sometimes',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'phone_number.required' => 'O campo Telefone é obrigatório',
            'employee_code.required' => 'O campo Código do funcionário é obrigatório',
            'email.unique' => 'Este e-mail já está sendo usado',
        ];
    }
}

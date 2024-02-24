<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
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
            ],
            'phone_number' => [
                'required',
            ],
            'birthdate' => [
                'sometimes',
            ],
            'employee_code' => [
                'required',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'phone_number.required' => 'O campo Telefone é obrigatório',
            'employee_code.required' => 'O campo Código do funcionário é obrigatório'
        ];
    }
}

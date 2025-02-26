<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CareerDevelopmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|in:Promotion,Salary Increase,Training,Position Change',
            'previous_value' => 'nullable|string',
            'new_value' => 'nullable|string',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'Please select an employee',
            'employee_id.exists' => 'The selected employee does not exist',
            'type.required' => 'Development type is required',
            'type.in' => 'The selected development type is invalid',
            'date.required' => 'Date is required',
            'date.date' => 'Please enter a valid date',
        ];
    }
}
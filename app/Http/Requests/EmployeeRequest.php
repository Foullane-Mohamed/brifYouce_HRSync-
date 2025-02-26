<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|email|max:255',
            'user.phone' => 'nullable|string|max:20',
            'user.company_id' => 'required|exists:companies,id',
            'employee.department_id' => 'nullable|exists:departments,id',
            'employee.manager_id' => 'nullable|exists:employees,id',
            'employee.position' => 'nullable|string|max:255',
            'employee.hire_date' => 'nullable|date',
            'employee.birth_date' => 'nullable|date',
            'employee.address' => 'nullable|string',
            'employee.salary' => 'nullable|numeric|min:0',
            'role' => 'required|exists:roles,name',
        ];

        // Add password rule for new employee creation
        if ($this->isMethod('post')) {
            $rules['user.password'] = 'required|string|min:8|confirmed';
            $rules['user.email'] .= '|unique:users,email';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['user.password'] = 'nullable|string|min:8|confirmed';
            $rules['user.email'] .= '|unique:users,email,' . $this->route('employee')->user->id;
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'user.name.required' => 'Employee name is required',
            'user.email.required' => 'Email address is required',
            'user.email.email' => 'Please enter a valid email address',
            'user.email.unique' => 'This email address is already in use',
            'user.password.required' => 'Password is required',
            'user.password.min' => 'Password must be at least 8 characters',
            'user.password.confirmed' => 'Password confirmation does not match',
            'user.company_id.required' => 'Please select a company',
            'user.company_id.exists' => 'The selected company does not exist',
            'employee.department_id.exists' => 'The selected department does not exist',
            'employee.manager_id.exists' => 'The selected manager does not exist',
            'employee.salary.numeric' => 'Salary must be a number',
            'employee.salary.min' => 'Salary must be a positive number',
            'role.required' => 'Please select a role for the employee',
            'role.exists' => 'The selected role does not exist',
        ];
    }
}
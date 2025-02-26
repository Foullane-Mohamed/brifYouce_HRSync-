<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|in:CDI,CDD,Internship,Freelance',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'details' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'Please select an employee',
            'employee_id.exists' => 'The selected employee does not exist',
            'type.required' => 'Contract type is required',
            'type.in' => 'The selected contract type is invalid',
            'start_date.required' => 'Start date is required',
            'start_date.date' => 'Please enter a valid date',
            'end_date.date' => 'Please enter a valid date',
            'end_date.after_or_equal' => 'End date must be after or equal to start date',
            'document.file' => 'Document must be a file',
            'document.mimes' => 'Document must be a file of type: pdf, doc, docx',
            'document.max' => 'Document may not be greater than 10MB',
        ];
    }
}
<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'documents.*' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Training name is required',
            'start_date.date' => 'Please enter a valid date',
            'end_date.date' => 'Please enter a valid date',
            'end_date.after_or_equal' => 'End date must be after or equal to start date',
            'documents.*.file' => 'Documents must be files',
            'documents.*.mimes' => 'Documents must be files of type: pdf, doc, docx, ppt, pptx',
            'documents.*.max' => 'Documents may not be greater than 10MB',
        ];
    }
}
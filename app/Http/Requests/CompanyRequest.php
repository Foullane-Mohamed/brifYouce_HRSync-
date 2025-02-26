<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Make email unique except for updates
        if ($this->isMethod('post')) {
            $rules['email'] .= '|unique:companies';
        } else {
            $rules['email'] .= '|unique:companies,email,' . $this->route('company')->id;
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Company name is required',
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email address is already in use',
            'logo.image' => 'Logo must be an image',
            'logo.mimes' => 'Logo must be a file of type: jpeg, png, jpg, gif',
            'logo.max' => 'Logo may not be greater than 2MB',
        ];
    }
}
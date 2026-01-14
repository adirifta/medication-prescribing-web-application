<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string|max:500',
            'phone' => 'required|string|regex:/^08[0-9]{9,11}$/',
            'email' => 'nullable|email|max:255',
            'blood_type' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'allergies' => 'nullable|string|max:500',
            'chronic_conditions' => 'nullable|string|max:500',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|regex:/^08[0-9]{9,11}$/',
            'emergency_contact_relation' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ];

        // For update, don't require MRN
        if ($this->isMethod('post')) {
            $rules['medical_record_number'] = 'nullable|string|unique:patients,medical_record_number';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Patient name is required.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.before' => 'Date of birth must be in the past.',
            'gender.required' => 'Gender is required.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number must start with 08 and be 11-13 digits.',
            'medical_record_number.unique' => 'This medical record number already exists.',
            'emergency_contact_phone.regex' => 'Emergency contact phone must start with 08 and be 11-13 digits.',
        ];
    }
}

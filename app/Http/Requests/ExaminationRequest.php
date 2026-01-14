<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExaminationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isDoctor();
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'height' => 'nullable|numeric|min:30|max:250',
            'weight' => 'nullable|numeric|min:1|max:300',
            'systolic' => 'nullable|integer|min:50|max:300',
            'diastolic' => 'nullable|integer|min:30|max:200',
            'heart_rate' => 'nullable|integer|min:30|max:250',
            'respiration_rate' => 'nullable|integer|min:6|max:60',
            'temperature' => 'nullable|numeric|min:30|max:45',
            'doctor_notes' => 'required|string|min:10|max:2000',
            'external_file' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx',
            'prescription_notes' => 'nullable|string|max:500',
            'medicines' => 'nullable|array',
            'medicines.*.id' => 'required_with:medicines|string',
            'medicines.*.name' => 'required_with:medicines|string',
            'medicines.*.quantity' => 'required_with:medicines|integer|min:1|max:100',
            'medicines.*.instructions' => 'nullable|string|max:200',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Please select a patient.',
            'height.min' => 'Height must be at least 30 cm.',
            'height.max' => 'Height cannot exceed 250 cm.',
            'weight.min' => 'Weight must be at least 1 kg.',
            'weight.max' => 'Weight cannot exceed 300 kg.',
            'doctor_notes.required' => 'Doctor notes are required.',
            'doctor_notes.min' => 'Doctor notes must be at least 10 characters.',
            'external_file.max' => 'File size cannot exceed 10MB.',
            'medicines.*.quantity.min' => 'Quantity must be at least 1.',
            'medicines.*.quantity.max' => 'Quantity cannot exceed 100.',
        ];
    }
}

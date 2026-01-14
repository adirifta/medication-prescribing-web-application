<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private PatientRepository $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
        $this->middleware('auth');
        $this->middleware('role:doctor');
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $patients = $search
            ? $this->patientRepository->search($search)
            : $this->patientRepository->paginate(10);

        return view('doctor.patients.index', compact('patients', 'search'));
    }

    public function create()
    {
        return view('doctor.patients.create');
    }

    public function store(PatientRequest $request)
    {
        $data = $request->validated();

        // Generate medical record number
        $year = date('Y');
        $lastPatient = \App\Models\Patient::where('medical_record_number', 'like', "MRN-{$year}-%")
            ->orderBy('medical_record_number', 'desc')
            ->first();

        $sequence = 1;
        if ($lastPatient) {
            $lastSequence = intval(substr($lastPatient->medical_record_number, -4));
            $sequence = $lastSequence + 1;
        }

        $data['medical_record_number'] = $this->generateMedicalRecordNumber();

        $patient = $this->patientRepository->create($data);

        return redirect()->route('doctor.patients.show', $patient->id)
            ->with('success', 'Patient created successfully.');
    }

    private function generateMedicalRecordNumber(): string
    {
        $year = date('Y');

        // Get last patient of the year
        $lastPatient = \App\Models\Patient::where('medical_record_number', 'like', "MRN-{$year}-%")
            ->orderByRaw('CAST(SUBSTRING_INDEX(medical_record_number, "-", -1) AS UNSIGNED) DESC')
            ->first();

        if ($lastPatient) {
            $parts = explode('-', $lastPatient->medical_record_number);
            $sequence = intval($parts[2] ?? 0) + 1;
        } else {
            $sequence = 1;
        }

        return sprintf("MRN-%04d-%04d", $year, $sequence);
    }

    public function show($id)
    {
        $patient = $this->patientRepository->getWithExaminations($id);

        if (!$patient) {
            abort(404);
        }

        return view('doctor.patients.show', compact('patient'));
    }

    public function edit($id)
    {
        $patient = $this->patientRepository->find($id);

        if (!$patient) {
            abort(404);
        }

        return view('doctor.patients.edit', compact('patient'));
    }

    public function update(PatientRequest $request, $id)
    {
        $patient = $this->patientRepository->find($id);

        if (!$patient) {
            abort(404);
        }

        $this->patientRepository->update($id, $request->validated());

        return redirect()->route('doctor.patients.show', $id)
            ->with('success', 'Patient updated successfully.');
    }
}

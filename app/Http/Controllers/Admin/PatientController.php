<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\PatientRepositoryInterface;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private PatientRepositoryInterface $patientRepository;

    public function __construct(PatientRepositoryInterface $patientRepository)
    {
        $this->patientRepository = $patientRepository;
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $search = $request->get('search');

        $patients = $this->patientRepository->getAllWithExaminationsCount($search);

        return view('admin.patients.index', compact('patients', 'search'));
    }

    public function show($id)
    {
        $patient = $this->patientRepository->getWithExaminationsAndDoctor($id);

        if (!$patient) {
            abort(404);
        }

        $stats = [
            'total_examinations' => $patient->examinations->count(),
            'last_examination' => $patient->examinations->sortByDesc('examination_date')->first(),
            'total_prescriptions' => $patient->examinations->where('prescription_id', '!=', null)->count(),
        ];

        return view('admin.patients.show', compact('patient', 'stats'));
    }
}

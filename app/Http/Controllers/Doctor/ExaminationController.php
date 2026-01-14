<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExaminationRequest;
use App\Services\MedicineApiService;
use App\Repositories\ExaminationRepository;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExaminationController extends Controller
{
    private ExaminationRepository $examinationRepository;
    private PatientRepository $patientRepository;
    private MedicineApiService $medicineService;

    public function __construct(
        ExaminationRepository $examinationRepository,
        PatientRepository $patientRepository,
        MedicineApiService $medicineService
    ) {
        $this->examinationRepository = $examinationRepository;
        $this->patientRepository = $patientRepository;
        $this->medicineService = $medicineService;
        $this->middleware('auth');
        $this->middleware('role:doctor');
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'date_from', 'date_to']);
        $examinations = $this->examinationRepository->getByDoctor(Auth::id(), $filters);

        return view('doctor.examinations.index', compact('examinations'));
    }

    public function show($id)
{
    $examination = $this->examinationRepository->find($id);

    if (!$examination || $examination->doctor_id !== Auth::id()) {
        abort(403);
    }

    // Load patient data
    $examination->load('patient');

    return view('doctor.examinations.show', compact('examination'));
}

    public function create()
    {
        $patients = $this->patientRepository->all();
        $medicines = $this->medicineService->getMedicines();

        return view('doctor.examinations.create', compact('patients', 'medicines'));
    }

    public function store(ExaminationRequest $request)
    {
        $data = $request->validated();

        // Handle file upload
        if ($request->hasFile('external_file')) {
            $path = $request->file('external_file')->store('examination_files', 'public');
            $data['external_file_path'] = $path;
        }

        $data['doctor_id'] = Auth::id();
        $data['examination_date'] = now();

        // Create prescription if medicines are selected
        $prescriptionData = [];
        if ($request->has('medicines')) {
            $prescriptionData = [
                'status' => 'waiting',
                'notes' => $request->input('prescription_notes'),
            ];
        }

        $examination = $this->examinationRepository->createWithPrescription($data, $prescriptionData);

        // Add prescription items
        if ($examination->prescription && $request->has('medicines')) {
            foreach ($request->input('medicines') as $medicine) {
                $price = $this->medicineService->getCurrentPrice($medicine['id']);

                $examination->prescription->items()->create([
                    'medicine_id' => $medicine['id'],
                    'medicine_name' => $medicine['name'],
                    'quantity' => $medicine['quantity'],
                    'unit_price' => $price,
                    'subtotal' => $price * $medicine['quantity'],
                    'instructions' => $medicine['instructions'],
                ]);
            }

            // Calculate total price
            $total = $examination->prescription->items()->sum('subtotal');
            $examination->prescription->update(['total_price' => $total]);
        }

        return redirect()->route('doctor.examinations.index')
            ->with('success', 'Examination created successfully.');
    }

    public function edit($id)
    {
        $examination = $this->examinationRepository->find($id);

        if (!$examination || $examination->doctor_id !== Auth::id()) {
            abort(403);
        }

        if ($examination->prescription && $examination->prescription->status !== 'waiting') {
            return redirect()->back()
                ->with('error', 'Cannot edit prescription that is already processed.');
        }

        $patients = $this->patientRepository->all();
        $medicines = $this->medicineService->getMedicines();

        return view('doctor.examinations.edit', compact('examination', 'patients', 'medicines'));
    }

    public function update(ExaminationRequest $request, $id)
    {
        $examination = $this->examinationRepository->find($id);

        if (!$examination || $examination->doctor_id !== Auth::id()) {
            abort(403);
        }

        if ($examination->prescription && $examination->prescription->status !== 'waiting') {
            return redirect()->back()
                ->with('error', 'Cannot update prescription that is already processed.');
        }

        $data = $request->validated();

        if ($request->hasFile('external_file')) {
            // Delete old file if exists
            if ($examination->external_file_path) {
                Storage::disk('public')->delete($examination->external_file_path);
            }

            $path = $request->file('external_file')->store('examination_files', 'public');
            $data['external_file_path'] = $path;
        }

        $this->examinationRepository->update($id, $data);

        // Update prescription if exists
        if ($examination->prescription && $request->has('medicines')) {
            // Delete existing items
            $examination->prescription->items()->delete();

            // Add new items
            foreach ($request->input('medicines') as $medicine) {
                $price = $this->medicineService->getCurrentPrice($medicine['id']);

                $examination->prescription->items()->create([
                    'medicine_id' => $medicine['id'],
                    'medicine_name' => $medicine['name'],
                    'quantity' => $medicine['quantity'],
                    'unit_price' => $price,
                    'subtotal' => $price * $medicine['quantity'],
                    'instructions' => $medicine['instructions'],
                ]);
            }

            // Recalculate total
            $total = $examination->prescription->items()->sum('subtotal');
            $examination->prescription->update([
                'total_price' => $total,
                'notes' => $request->input('prescription_notes'),
            ]);
        }

        return redirect()->route('doctor.examinations.index')
            ->with('success', 'Examination updated successfully.');
    }
}

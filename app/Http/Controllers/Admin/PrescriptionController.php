<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::with(['patient', 'doctor', 'pharmacist'])
            ->latest()
            ->paginate(10);

        return view('admin.prescriptions.index', compact('prescriptions'));
    }

    public function show($id)
    {
        $prescription = Prescription::with(['patient', 'doctor', 'pharmacist', 'medicines'])->findOrFail($id);

        return view('admin.prescriptions.show', compact('prescription'));
    }

    public function create()
    {
        // Logic untuk create prescription (jika diperlukan)
        return view('admin.prescriptions.create');
    }

    public function store(Request $request)
    {
        // Logic untuk store prescription
    }

    public function destroy($id)
    {
        $prescription = Prescription::findOrFail($id);
        $prescription->delete();

        return redirect()->route('admin.prescriptions.index')
            ->with('success', 'Prescription deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:pharmacist');
    }

    public function index(Request $request)
    {
        $status = $request->get('status', 'waiting');
        $prescriptions = Prescription::with(['examination.patient', 'items'])
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pharmacist.prescriptions.index', compact('prescriptions', 'status'));
    }

    public function show($id)
    {
        $prescription = Prescription::with(['examination.patient', 'items', 'doctor'])->findOrFail($id);

        return view('pharmacist.prescriptions.show', compact('prescription'));
    }

    public function process($id)
    {
        $prescription = Prescription::findOrFail($id);

        if ($prescription->status !== 'waiting') {
            return redirect()->back()
                ->with('error', 'Prescription has already been processed.');
        }

        $prescription->update([
            'status' => 'processed',
            'pharmacist_id' => Auth::id(),
            'processed_at' => now(),
        ]);

        // Log the action
        activity()
            ->performedOn($prescription)
            ->causedBy(Auth::user())
            ->log('Processed prescription');

        return redirect()->route('pharmacist.prescriptions.show', $id)
            ->with('success', 'Prescription marked as processed.');
    }

    public function complete($id)
    {
        $prescription = Prescription::findOrFail($id);

        if ($prescription->status !== 'processed') {
            return redirect()->back()
                ->with('error', 'Prescription must be processed first.');
        }

        $prescription->update([
            'status' => 'completed',
        ]);

        return redirect()->route('pharmacist.prescriptions.show', $id)
            ->with('success', 'Prescription completed successfully.');
    }

    public function exportPdf($id)
    {
        $prescription = Prescription::with(['examination.patient', 'items', 'doctor', 'pharmacist'])->findOrFail($id);

        $pdf = Pdf::loadView('pharmacist.prescriptions.pdf', compact('prescription'));

        $filename = "receipt-{$prescription->id}-" . now()->format('YmdHis') . ".pdf";

        return $pdf->download($filename);
    }

    public function printReceipt($id)
    {
        $prescription = Prescription::with(['examination.patient', 'items', 'doctor', 'pharmacist'])->findOrFail($id);

        return view('pharmacist.prescriptions.print', compact('prescription'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $query = Prescription::with(['examination.patient', 'doctor', 'pharmacist'])
            ->latest();

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $prescriptions = $query->paginate(20);

        $statuses = [
            'pending' => 'Pending',
            'processed' => 'Processed',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        $totalRevenue = Prescription::where('status', 'completed')->sum('total_price');
        $totalPrescriptions = Prescription::count();

        return view('admin.prescriptions.index', compact(
            'prescriptions',
            'statuses',
            'totalRevenue',
            'totalPrescriptions'
        ));
    }

    public function show($id)
    {
        $prescription = Prescription::with([
            'examination.patient',
            'doctor',
            'pharmacist',
            'medicines'
        ])->findOrFail($id);

        return view('admin.prescriptions.show', compact('prescription'));
    }

    public function destroy($id)
    {
        $prescription = Prescription::findOrFail($id);

        // Check if prescription can be deleted
        if ($prescription->status === 'completed') {
            return redirect()->back()
                ->with('error', 'Cannot delete completed prescription.');
        }

        $prescription->delete();

        // Log the action
        activity()
            ->causedBy(auth()->user())
            ->performedOn($prescription)
            ->log('deleted prescription');

        return redirect()->route('admin.prescriptions.index')
            ->with('success', 'Prescription deleted successfully.');
    }
}

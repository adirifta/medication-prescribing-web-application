<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Examination;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:doctor');
    }

    public function index()
    {
        $doctorId = Auth::id();
        $today = now()->format('Y-m-d');

        $stats = [
            'today_examinations' => Examination::where('doctor_id', $doctorId)
                ->whereDate('examination_date', $today)
                ->count(),
            'total_patients' => Patient::whereHas('examinations', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })->count(),
            'pending_prescriptions' => Prescription::whereHas('examination', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })->where('status', 'waiting')->count(),
            'completed_prescriptions' => Prescription::whereHas('examination', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })->where('status', 'completed')->count(),
        ];

        $recentExaminations = Examination::with('patient')
            ->where('doctor_id', $doctorId)
            ->orderBy('examination_date', 'desc')
            ->limit(5)
            ->get();

        $monthlyData = Examination::select(
                DB::raw('DATE_FORMAT(examination_date, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('doctor_id', $doctorId)
            ->whereYear('examination_date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('doctor.dashboard', compact('stats', 'recentExaminations', 'monthlyData'));
    }
}

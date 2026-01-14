<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:pharmacist');
    }

    public function index()
    {
        $pharmacistId = Auth::id();
        $today = now()->format('Y-m-d');

        $stats = [
            'waiting_prescriptions' => Prescription::where('status', 'waiting')->count(),
            'today_processed' => Prescription::where('pharmacist_id', $pharmacistId)
                ->whereDate('processed_at', $today)
                ->count(),
            'total_processed' => Prescription::where('pharmacist_id', $pharmacistId)->count(),
            'total_revenue' => Prescription::where('pharmacist_id', $pharmacistId)
                ->where('status', 'completed')
                ->sum('total_price'),
        ];

        $recentPrescriptions = Prescription::with(['examination.patient', 'doctor'])
            ->where('pharmacist_id', $pharmacistId)
            ->orderBy('processed_at', 'desc')
            ->limit(5)
            ->get();

        $dailyRevenue = Prescription::select(
                DB::raw('DATE(processed_at) as date'),
                DB::raw('SUM(total_price) as revenue'),
                DB::raw('COUNT(*) as prescriptions')
            )
            ->where('pharmacist_id', $pharmacistId)
            ->where('status', 'completed')
            ->whereYear('processed_at', date('Y'))
            ->whereMonth('processed_at', date('m'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('pharmacist.dashboard', compact('stats', 'recentPrescriptions', 'dailyRevenue'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Examination;
use App\Models\Prescription;
use App\Models\Patient;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $today = now()->format('Y-m-d');
        $weekStart = now()->startOfWeek()->format('Y-m-d');
        $weekEnd = now()->endOfWeek()->format('Y-m-d');

        // Overall Statistics
        $stats = [
            'total_users' => User::count(),
            'total_doctors' => User::where('role', 'doctor')->count(),
            'total_pharmacists' => User::where('role', 'pharmacist')->count(),
            'total_patients' => Patient::count(),
            'total_examinations' => Examination::count(),
            'total_prescriptions' => Prescription::count(),
            'revenue_today' => Prescription::whereDate('created_at', $today)
                ->where('status', 'completed')
                ->sum('total_price'),
            'revenue_week' => Prescription::whereBetween('created_at', [$weekStart, $weekEnd])
                ->where('status', 'completed')
                ->sum('total_price'),
        ];

        // User Statistics by Role
        $userStats = User::select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->get()
            ->pluck('count', 'role');

        // Recent Activities
        $recentActivities = AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Daily Examinations (Last 7 Days)
        $dailyExaminations = Examination::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Monthly Revenue
        $monthlyRevenue = Prescription::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total_price) as revenue')
            )
            ->where('status', 'completed')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Top Doctors by Examinations
        $topDoctors = User::where('role', 'doctor')
            ->withCount('examinations')
            ->orderBy('examinations_count', 'desc')
            ->limit(5)
            ->get();

        // Recent Users
        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'userStats',
            'recentActivities',
            'dailyExaminations',
            'monthlyRevenue',
            'topDoctors',
            'recentUsers'
        ));
    }

    public function analytics()
    {
        // Examination Statistics by Month
        $examinationStats = Examination::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as examinations')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prescription Status Distribution
        $prescriptionStatus = Prescription::select(
                'status',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('status')
            ->get();

        // Revenue by Month
        $revenueByMonth = Prescription::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total_price) as revenue')
            )
            ->where('status', 'completed')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // User Registration by Month
        $userRegistrations = User::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as registrations')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.analytics', compact(
            'examinationStats',
            'prescriptionStatus',
            'revenueByMonth',
            'userRegistrations'
        ));
    }

    public function reports(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $reportType = $request->get('type', 'examinations');

        $data = [];

        switch ($reportType) {
            case 'examinations':
                $data = Examination::with(['patient', 'doctor'])
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->orderBy('created_at', 'desc')
                    ->get();
                break;

            case 'prescriptions':
                $data = Prescription::with(['examination.patient', 'doctor', 'pharmacist'])
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->orderBy('created_at', 'desc')
                    ->get();
                break;

            case 'revenue':
                $data = Prescription::select(
                        DB::raw('DATE(created_at) as date'),
                        DB::raw('COUNT(*) as prescriptions'),
                        DB::raw('SUM(total_price) as revenue')
                    )
                    ->where('status', 'completed')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
                break;
        }

        return view('admin.reports', compact('data', 'startDate', 'endDate', 'reportType'));
    }

    public function exportReport(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $reportType = $request->get('type');

        // Logic for exporting reports to PDF/Excel
        // This would typically generate a file for download

        return redirect()->back()
            ->with('success', 'Report exported successfully.');
    }

    public function revenueReport(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        $revenueData = Prescription::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as prescriptions'),
                DB::raw('SUM(total_price) as revenue')
            )
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totalRevenue = $revenueData->sum('revenue');
        $totalPrescriptions = $revenueData->sum('prescriptions');

        return view('admin.reports.revenue', compact(
            'revenueData',
            'totalRevenue',
            'totalPrescriptions',
            'startDate',
            'endDate'
        ));
    }
}

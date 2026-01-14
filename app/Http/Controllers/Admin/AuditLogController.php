<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $action = $request->get('action');
        $table = $request->get('table');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $logs = AuditLog::query()
            ->with('user')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('table_name', 'like', "%{$search}%")
                      ->orWhere('action', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($userQuery) use ($search) {
                          $userQuery->where('name', 'like', "%{$search}%")
                                   ->orWhere('email', 'like', "%{$search}%");
                      });
                });
            })
            ->when($action, function ($query, $action) {
                $query->where('action', $action);
            })
            ->when($table, function ($query, $table) {
                $query->where('table_name', $table);
            })
            ->when($dateFrom, function ($query, $dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query, $dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $tableNames = AuditLog::select('table_name')
            ->distinct()
            ->pluck('table_name');

        $actions = ['CREATE', 'UPDATE', 'DELETE'];

        return view('admin.audit-logs.index', compact('logs', 'search', 'action', 'table', 'dateFrom', 'dateTo', 'tableNames', 'actions'));
    }

    public function show($id)
    {
        $log = AuditLog::with('user')->findOrFail($id);

        return view('admin.audit-logs.show', compact('log'));
    }

    public function clearOldLogs()
    {
        $days = 30; // Keep logs for 30 days
        $cutoffDate = now()->subDays($days);

        $deleted = AuditLog::where('created_at', '<', $cutoffDate)->delete();

        return redirect()->back()
            ->with('success', "Deleted {$deleted} audit logs older than {$days} days.");
    }
}

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
        $selectedAction = $request->get('action'); // Rename dari $action
        $selectedTable = $request->get('table'); // Rename dari $table
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
            ->when($selectedAction, function ($query, $selectedAction) {
                $query->where('action', $selectedAction);
            })
            ->when($selectedTable, function ($query, $selectedTable) {
                $query->where('table_name', $selectedTable);
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

        $actions = ['CREATE', 'UPDATE', 'DELETE', 'LOGIN', 'LOGOUT'];

        $totalLogs = AuditLog::count();

        return view('admin.audit-logs.index', compact(
            'logs',
            'search',
            'selectedAction', // Gunakan nama baru
            'selectedTable',  // Gunakan nama baru
            'dateFrom',
            'dateTo',
            'tableNames',
            'actions',
            'totalLogs'
        ));
    }

    public function show($id)
    {
        $log = AuditLog::with('user')->findOrFail($id);

        // Format values untuk display
        if ($log->old_values && is_string($log->old_values)) {
            $log->formatted_old_values = json_encode(json_decode($log->old_values, true), JSON_PRETTY_PRINT);
        } elseif ($log->old_values) {
            $log->formatted_old_values = json_encode($log->old_values, JSON_PRETTY_PRINT);
        }

        if ($log->new_values && is_string($log->new_values)) {
            $log->formatted_new_values = json_encode(json_decode($log->new_values, true), JSON_PRETTY_PRINT);
        } elseif ($log->new_values) {
            $log->formatted_new_values = json_encode($log->new_values, JSON_PRETTY_PRINT);
        }

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

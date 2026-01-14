<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $settings = [
            'app_name' => config('app.name'),
            'app_url' => config('app.url'),
            'medicine_api_email' => config('services.medicine_api.email'),
            'medicine_api_phone' => config('services.medicine_api.phone'),
            'cache_enabled' => config('cache.default') !== 'array',
            'session_lifetime' => config('session.lifetime'),
            'maintenance_mode' => app()->isDownForMaintenance(),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => ['required', 'string', 'max:255'],
            'app_url' => ['required', 'url'],
            'medicine_api_email' => ['required', 'email'],
            'medicine_api_phone' => ['required', 'string', 'regex:/^08[0-9]{9,11}$/'],
            'session_lifetime' => ['required', 'integer', 'min:1', 'max:525600'],
        ]);

        // Update .env file or database settings
        // In production, you'd want to use a database settings table

        return redirect()->back()
            ->with('success', 'Settings updated successfully. Please note: Some settings may require a restart.');
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');

        return redirect()->back()
            ->with('success', 'Application cache cleared successfully.');
    }

    public function optimize()
    {
        Artisan::call('optimize:clear');
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');

        return redirect()->back()
            ->with('success', 'Application optimized successfully.');
    }

    public function maintenanceMode(Request $request)
    {
        $action = $request->get('action', 'up');

        if ($action === 'down') {
            Artisan::call('down', [
                '--secret' => 'secret-token-' . time(),
            ]);
            $message = 'Maintenance mode enabled.';
        } else {
            Artisan::call('up');
            $message = 'Maintenance mode disabled.';
        }

        return redirect()->back()
            ->with('success', $message);
    }

    public function backup()
    {
        try {
            // Create a simple database backup
            $backupData = [
                'timestamp' => now()->toDateTimeString(),
                'database' => config('database.connections.mysql.database'),
                'app_version' => app()->version(),
            ];

            // Store backup in storage
            $backupFilename = 'backup-' . now()->format('Y-m-d-H-i-s') . '.json';
            Storage::disk('local')->put('backups/' . $backupFilename, json_encode($backupData, JSON_PRETTY_PRINT));

            return redirect()->back()
                ->with('success', 'Backup created successfully: ' . $backupFilename);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    public function logs()
    {
        $logFile = storage_path('logs/laravel.log');
        $logs = [];

        if (file_exists($logFile)) {
            $logs = array_slice(file($logFile), -100); // Last 100 lines
            $logs = array_reverse($logs); // Show newest first
        }

        return view('admin.settings.logs', compact('logs'));
    }

    public function clearLogs()
    {
        $logFile = storage_path('logs/laravel.log');

        if (file_exists($logFile)) {
            file_put_contents($logFile, '');
        }

        return redirect()->back()
            ->with('success', 'Logs cleared successfully.');
    }
}

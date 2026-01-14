<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Doctor\PatientController as DoctorPatientController;
use App\Http\Controllers\Doctor\ExaminationController as DoctorExaminationController;
use App\Http\Controllers\Pharmacist\DashboardController as PharmacistDashboardController;
use App\Http\Controllers\Pharmacist\PrescriptionController as PharmacistPrescriptionController;
use App\Http\Controllers\Api\MedicineController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Home
Route::get('/', function () {
    return view('welcome');
});

// Dashboard based on role
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isDoctor()) {
        return redirect()->route('doctor.dashboard');
    } elseif ($user->isPharmacist()) {
        return redirect()->route('pharmacist.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [\App\Http\Controllers\Admin\DashboardController::class, 'analytics'])->name('analytics');
    Route::get('/reports', [\App\Http\Controllers\Admin\DashboardController::class, 'reports'])->name('reports');
    Route::post('/export-report', [\App\Http\Controllers\Admin\DashboardController::class, 'exportReport'])->name('export-report');

    // User Management
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::post('/users/{id}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Patient Management
    Route::get('/patients', [\App\Http\Controllers\Admin\PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/{id}', [\App\Http\Controllers\Admin\PatientController::class, 'show'])->name('patients.show');

    // Audit Logs
    Route::get('/audit-logs', [\App\Http\Controllers\Admin\AuditLogController::class, 'index'])->name('audit-logs.index');
    Route::get('/audit-logs/{id}', [\App\Http\Controllers\Admin\AuditLogController::class, 'show'])->name('audit-logs.show');
    Route::post('/audit-logs/clear', [\App\Http\Controllers\Admin\AuditLogController::class, 'clearOldLogs'])->name('audit-logs.clear');

    // System Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/clear-cache', [\App\Http\Controllers\Admin\SettingController::class, 'clearCache'])->name('settings.clear-cache');
    Route::post('/settings/optimize', [\App\Http\Controllers\Admin\SettingController::class, 'optimize'])->name('settings.optimize');
    Route::post('/settings/maintenance', [\App\Http\Controllers\Admin\SettingController::class, 'maintenanceMode'])->name('settings.maintenance');
    Route::post('/settings/backup', [\App\Http\Controllers\Admin\SettingController::class, 'backup'])->name('settings.backup');
    Route::get('/settings/logs', [\App\Http\Controllers\Admin\SettingController::class, 'logs'])->name('settings.logs');
    Route::post('/settings/clear-logs', [\App\Http\Controllers\Admin\SettingController::class, 'clearLogs'])->name('settings.clear-logs');
});

// Doctor Routes
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');

    // Patients
    Route::resource('patients', DoctorPatientController::class);

    // Examinations
    Route::resource('examinations', DoctorExaminationController::class);
    Route::get('examinations/{id}/prescription', [DoctorExaminationController::class, 'prescription'])->name('examinations.prescription');
});

// Pharmacist Routes
    Route::middleware(['auth', 'role:pharmacist'])->prefix('pharmacist')->name('pharmacist.')->group(function () {
        Route::get('/dashboard', [PharmacistDashboardController::class, 'index'])->name('dashboard');

        // Prescriptions
        Route::get('/prescriptions', [PharmacistPrescriptionController::class, 'index'])->name('prescriptions.index');
        Route::get('/prescriptions/{id}', [PharmacistPrescriptionController::class, 'show'])->name('prescriptions.show');
        Route::post('/prescriptions/{id}/process', [PharmacistPrescriptionController::class, 'process'])->name('prescriptions.process');
        Route::post('/prescriptions/{id}/complete', [PharmacistPrescriptionController::class, 'complete'])->name('prescriptions.complete');
        Route::get('/prescriptions/{id}/export', [PharmacistPrescriptionController::class, 'exportPdf'])->name('prescriptions.export');
        Route::get('/prescriptions/{id}/print', [PharmacistPrescriptionController::class, 'printReceipt'])->name('prescriptions.print');
    });

// API Routes
Route::middleware('auth')->prefix('api')->group(function () {
    Route::get('/medicines', [MedicineController::class, 'getMedicines']);
    Route::get('/medicine-price/{medicineId}', [MedicineController::class, 'getMedicinePrice']);
    Route::get('/search-medicines', [MedicineController::class, 'searchMedicines']);
});

require __DIR__.'/auth.php';

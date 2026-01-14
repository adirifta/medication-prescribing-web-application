<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $role = $request->get('role');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $userCounts = [
            'total' => User::count(),
            'doctors' => User::where('role', 'doctor')->count(),
            'pharmacists' => User::where('role', 'pharmacist')->count(),
            'admins' => User::where('role', 'admin')->count(),
        ];

        return view('admin.users.index', compact('users', 'search', 'role', 'userCounts'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'regex:/^08[0-9]{9,11}$/'],
            'role' => ['required', 'in:admin,doctor,pharmacist'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        $user = User::with([
            'examinations' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(5);
            },
            'processedPrescriptions' => function ($query) {
                $query->orderBy('processed_at', 'desc')->limit(5);
            },
            'auditLogs' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(10);
            }
        ])->findOrFail($id);

        $stats = [];

        if ($user->isDoctor()) {
            $stats = [
                'total_examinations' => $user->examinations()->count(),
                'today_examinations' => $user->examinations()->whereDate('created_at', today())->count(),
                'total_prescriptions' => $user->examinations()->has('prescription')->count(),
            ];
        } elseif ($user->isPharmacist()) {
            $stats = [
                'processed_prescriptions' => $user->processedPrescriptions()->count(),
                'today_processed' => $user->processedPrescriptions()->whereDate('processed_at', today())->count(),
                'total_revenue' => $user->processedPrescriptions()->sum('total_price'),
            ];
        }

        return view('admin.users.show', compact('user', 'stats'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'regex:/^08[0-9]{9,11}$/'],
            'role' => ['required', 'in:admin,doctor,pharmacist'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.users.show', $user->id)
            ->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'You cannot delete your own account.');
        }

        // Check if user has related data
        if ($user->examinations()->exists() || $user->processedPrescriptions()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete user with related records.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // Prevent deactivating self
        if ($user->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'You cannot deactivate your own account.');
        }

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $status = $user->is_active ? 'activated' : 'deactivated';

        return redirect()->back()
            ->with('success', "User {$status} successfully.");
    }
}

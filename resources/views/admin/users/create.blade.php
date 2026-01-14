@extends('layouts.app')

@section('title', 'Page Title')

@section('header')
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Create New User') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Add a new user to the system
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Users
                </a>
            </div>
        </div>
    @endsection

@section('content')

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="p-8">
                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- User Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                <i class="fas fa-user-circle mr-3 text-primary-500"></i>
                                User Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="form-label">Full Name</label>
                                    <div class="relative">
                                        <input type="text"
                                               id="name"
                                               name="name"
                                               value="{{ old('name') }}"
                                               required
                                               class="form-input pl-10"
                                               placeholder="John Doe">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="form-label">Email Address</label>
                                    <div class="relative">
                                        <input type="email"
                                               id="email"
                                               name="email"
                                               value="{{ old('email') }}"
                                               required
                                               class="form-input pl-10"
                                               placeholder="john@example.com">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <div class="relative">
                                        <input type="text"
                                               id="phone"
                                               name="phone"
                                               value="{{ old('phone') }}"
                                               required
                                               class="form-input pl-10"
                                               placeholder="08xxxxxxxxxx"
                                               pattern="^08[0-9]{9,11}$">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-phone text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('phone')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Role -->
                                <div>
                                    <label for="role" class="form-label">Role</label>
                                    <select id="role"
                                            name="role"
                                            required
                                            class="form-input">
                                        <option value="">Select Role</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                                        <option value="doctor" {{ old('role') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                                        <option value="pharmacist" {{ old('role') == 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                                    </select>
                                    @error('role')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div>
                                    <label for="password" class="form-label">Password</label>
                                    <div class="relative">
                                        <input type="password"
                                               id="password"
                                               name="password"
                                               required
                                               class="form-input pl-10"
                                               placeholder="Minimum 8 characters">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('password')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <div class="relative">
                                        <input type="password"
                                               id="password_confirmation"
                                               name="password_confirmation"
                                               required
                                               class="form-input pl-10"
                                               placeholder="Re-enter password">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Role Descriptions -->
                        <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-xl">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-4">Role Descriptions</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="p-4 bg-purple-50 dark:bg-purple-900/30 rounded-lg border border-purple-200 dark:border-purple-800">
                                    <div class="flex items-center mb-2">
                                        <div class="w-8 h-8 bg-purple-100 dark:bg-purple-800 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-user-shield text-purple-600 dark:text-purple-400"></i>
                                        </div>
                                        <div class="font-medium text-purple-700 dark:text-purple-400">Administrator</div>
                                    </div>
                                    <div class="text-sm text-purple-600 dark:text-purple-300">
                                        Full system access, user management, reports, settings
                                    </div>
                                </div>
                                <div class="p-4 bg-blue-50 dark:bg-blue-900/30 rounded-lg border border-blue-200 dark:border-blue-800">
                                    <div class="flex items-center mb-2">
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-800 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-user-md text-blue-600 dark:text-blue-400"></i>
                                        </div>
                                        <div class="font-medium text-blue-700 dark:text-blue-400">Doctor</div>
                                    </div>
                                    <div class="text-sm text-blue-600 dark:text-blue-300">
                                        Patient examinations, prescriptions, medical records
                                    </div>
                                </div>
                                <div class="p-4 bg-green-50 dark:bg-green-900/30 rounded-lg border border-green-200 dark:border-green-800">
                                    <div class="flex items-center mb-2">
                                        <div class="w-8 h-8 bg-green-100 dark:bg-green-800 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-prescription-bottle-alt text-green-600 dark:text-green-400"></i>
                                        </div>
                                        <div class="font-medium text-green-700 dark:text-green-400">Pharmacist</div>
                                    </div>
                                    <div class="text-sm text-green-600 dark:text-green-300">
                                        Process prescriptions, generate receipts, medicine inventory
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4 pt-6">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-2"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus mr-2"></i>
                                Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

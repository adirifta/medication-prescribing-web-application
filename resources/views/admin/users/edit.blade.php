@extends('layouts.app')

@section('title', 'Page Title')

@section('header')
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Edit User') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Update user information and role
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to User
                </a>
            </div>
        </div>
    @endsection

@section('content')

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="p-8">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- User Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                <i class="fas fa-user-edit mr-3 text-primary-500"></i>
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
                                               value="{{ old('name', $user->name) }}"
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
                                               value="{{ old('email', $user->email) }}"
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
                                               value="{{ old('phone', $user->phone) }}"
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
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                                        <option value="doctor" {{ old('role', $user->role) == 'doctor' ? 'selected' : '' }}>Doctor</option>
                                        <option value="pharmacist" {{ old('role', $user->role) == 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
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
                                    <label for="password" class="form-label">
                                        <i class="fas fa-info-circle text-gray-400 mr-1"></i>
                                        Password (Leave blank to keep current)
                                    </label>
                                    <div class="relative">
                                        <input type="password"
                                               id="password"
                                               name="password"
                                               class="form-input pl-10"
                                               placeholder="Enter new password">
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
                                               class="form-input pl-10"
                                               placeholder="Re-enter new password">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Summary -->
                        <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-xl">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-4">User Summary</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="p-3 bg-white dark:bg-gray-700 rounded-lg">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">User ID</div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->id }}</div>
                                </div>
                                <div class="p-3 bg-white dark:bg-gray-700 rounded-lg">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Created</div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $user->created_at->format('d M Y') }}
                                    </div>
                                </div>
                                <div class="p-3 bg-white dark:bg-gray-700 rounded-lg">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Last Updated</div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $user->updated_at->format('d M Y') }}
                                    </div>
                                </div>
                                <div class="p-3 bg-white dark:bg-gray-700 rounded-lg">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Email Verified</div>
                                    <div class="text-sm font-medium {{ $user->email_verified_at ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4 pt-6">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-2"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>
                                Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Page Title')

@section('header')
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('User Details') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    View user information and activities
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-medical">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Users
                </a>
            </div>
        </div>
    @endsection

@section('content')

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- User Profile Card -->
            <div class="card mb-8">
                <div class="p-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <!-- User Info -->
                        <div class="flex items-center mb-6 lg:mb-0">
                            <div class="w-20 h-20 gradient-primary rounded-2xl flex items-center justify-center text-3xl font-bold text-white">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="ml-6">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                                <div class="flex items-center mt-2 space-x-4">
                                    <span class="badge {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : ($user->role == 'doctor' ? 'badge-primary' : 'badge-medical') }}">
                                        {{ $user->formatted_role }}
                                    </span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        Member since {{ $user->created_at->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Last Login -->
                        <div class="lg:text-right">
                            <div class="text-sm text-gray-500 dark:text-gray-400">Last Login</div>
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-xl">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-white dark:bg-gray-700 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Email Address</div>
                                    <div class="text-lg font-medium text-gray-900 dark:text-white">{{ $user->email }}</div>
                                </div>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                Verified: {{ $user->email_verified_at ? $user->email_verified_at->format('d M Y') : 'Not Verified' }}
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-xl">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-white dark:bg-gray-700 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Phone Number</div>
                                    <div class="text-lg font-medium text-gray-900 dark:text-white">{{ $user->phone }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            @if(!empty($stats))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach($stats as $key => $value)
                <div class="card">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-600 dark:text-gray-400 capitalize mb-2">
                            {{ str_replace('_', ' ', $key) }}
                        </div>
                        @if(strpos($key, 'revenue') !== false)
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                            IDR {{ number_format($value, 0, ',', '.') }}
                        </div>
                        @else
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $value }}</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- User Activities -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Activities -->
                @if($user->auditLogs->count() > 0)
                <div class="card">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-history mr-3 text-primary-500"></i>
                            Recent Activities
                        </h4>
                        <div class="space-y-4">
                            @foreach($user->auditLogs->take(5) as $log)
                            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center">
                                        @php
                                            $actionColors = [
                                                'CREATE' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-200', 'icon' => 'fa-plus-circle'],
                                                'UPDATE' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-200', 'icon' => 'fa-edit'],
                                                'DELETE' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-800 dark:text-red-200', 'icon' => 'fa-trash-alt'],
                                            ];
                                            $color = $actionColors[$log->action] ?? ['bg' => 'bg-gray-100 dark:bg-gray-700', 'text' => 'text-gray-800 dark:text-gray-200', 'icon' => 'fa-circle'];
                                        @endphp
                                        <span class="badge {{ $color['bg'] }} {{ $color['text'] }} text-xs">
                                            <i class="fas {{ $color['icon'] }} mr-1"></i>
                                            {{ $log->action }}
                                        </span>
                                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $log->table_name }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $log->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                @if($log->description)
                                <div class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                                    {{ $log->description }}
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @if($user->auditLogs->count() > 5)
                        <div class="mt-6 text-center">
                            <a href="#" class="text-primary-600 dark:text-primary-400 hover:underline text-sm">
                                View all activities →
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Recent Examinations or Prescriptions -->
                <div class="card">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-clipboard-list mr-3 text-medical-500"></i>
                            Recent {{ $user->isDoctor() ? 'Examinations' : 'Prescriptions' }}
                        </h4>
                        @if($user->isDoctor() && $user->examinations->count() > 0)
                            <div class="space-y-4">
                                @foreach($user->examinations->take(3) as $examination)
                                <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">
                                                {{ $examination->patient->name }}
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                                {{ Str::limit($examination->doctor_notes, 80) }}
                                            </div>
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $examination->created_at->format('d M') }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @elseif($user->isPharmacist() && $user->processedPrescriptions->count() > 0)
                            <div class="space-y-4">
                                @foreach($user->processedPrescriptions->take(3) as $prescription)
                                <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">
                                                Prescription #{{ str_pad($prescription->id, 6, '0', STR_PAD_LEFT) }}
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                                Patient: {{ $prescription->examination->patient->name }}
                                                <span class="ml-3">Total: {{ $prescription->formatted_total_price }}</span>
                                            </div>
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $prescription->created_at->format('d M') }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-file-alt text-gray-300 dark:text-gray-600 text-4xl mb-3"></i>
                                <p class="text-gray-700 dark:text-gray-300">No {{ $user->isDoctor() ? 'examinations' : 'prescriptions' }} found</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

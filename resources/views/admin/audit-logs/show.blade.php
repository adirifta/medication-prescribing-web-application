{{-- resources/views/admin/audit-logs/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Page Title')

@section('header')
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Audit Log Details') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Detailed view of system activity log
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Logs
                </a>
            </div>
        </div>
    @endsection

@section('content')

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Log Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Basic Information -->
                <div class="card">
                    <div class="p-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-info-circle mr-3 text-primary-500"></i>
                            Log Information
                        </h3>
                        <div class="space-y-6">
                            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Log ID</div>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white mt-1">
                                    {{ $log->id }}
                                </div>
                            </div>

                            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Action</div>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white mt-1">
                                    @php
                                        $actionColors = [
                                            'CREATE' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-200'],
                                            'UPDATE' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-200'],
                                            'DELETE' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-800 dark:text-red-200'],
                                            'LOGIN' => ['bg' => 'bg-purple-100 dark:bg-purple-900/30', 'text' => 'text-purple-800 dark:text-purple-200'],
                                            'LOGOUT' => ['bg' => 'bg-gray-100 dark:bg-gray-700', 'text' => 'text-gray-800 dark:text-gray-200'],
                                        ];
                                        $color = $actionColors[$log->action] ?? ['bg' => 'bg-gray-100 dark:bg-gray-700', 'text' => 'text-gray-800 dark:text-gray-200'];
                                    @endphp
                                    <span class="badge {{ $color['bg'] }} {{ $color['text'] }} px-3 py-1">
                                        {{ $log->action }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Table Name</div>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white mt-1">
                                    {{ $log->table_name }}
                                </div>
                            </div>

                            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Timestamp</div>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white mt-1">
                                    {{ $log->created_at->format('d M Y, H:i:s') }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $log->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Information -->
                <div class="card">
                    <div class="p-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-user-circle mr-3 text-primary-500"></i>
                            User Information
                        </h3>

                        @if($log->user)
                        <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl mb-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                    <span class="text-gray-600 dark:text-gray-400 font-medium text-lg">
                                        {{ substr($log->user->name, 0, 1) }}
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $log->user->name }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $log->user->email }}
                                    </div>
                                    <div class="mt-2">
                                        @php
                                            $roleColors = [
                                                'admin' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                                'doctor' => 'badge-primary',
                                                'pharmacist' => 'badge-medical'
                                            ];
                                        @endphp
                                        <span class="badge {{ $roleColors[$log->user->role] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                            {{ $log->user->formatted_role }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl mb-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                    <i class="fas fa-robot text-gray-400"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                        System Action
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        This action was performed by the system
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Technical Information -->
                        <div class="space-y-4">
                            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">IP Address</div>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white mt-1">
                                    {{ $log->ip_address }}
                                </div>
                            </div>

                            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">User Agent</div>
                                <div class="text-sm text-gray-900 dark:text-white mt-1 truncate">
                                    {{ $log->user_agent }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Changes -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Old Values -->
                @if($log->old_values)
                <div class="card">
                    <div class="p-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-history mr-3 text-blue-500"></i>
                            Old Values
                        </h3>
                        <div class="bg-gray-900 text-gray-300 p-6 rounded-xl overflow-x-auto">
                            <pre class="text-sm font-mono whitespace-pre-wrap">{{ $log->formatted_old_values }}</pre>
                        </div>
                    </div>
                </div>
                @endif

                <!-- New Values -->
                @if($log->new_values)
                <div class="card">
                    <div class="p-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-sync-alt mr-3 text-green-500"></i>
                            New Values
                        </h3>
                        <div class="bg-gray-900 text-gray-300 p-6 rounded-xl overflow-x-auto">
                            <pre class="text-sm font-mono whitespace-pre-wrap">{{ $log->formatted_new_values }}</pre>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            @if(!$log->old_values && !$log->new_values)
            <div class="card mt-8">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clipboard-list text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Data Changes</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        No data changes were recorded for this log entry.
                    </p>
                </div>
            </div>
            @endif

            <!-- Raw Data (Optional) -->
            <div class="card mt-8">
                <div class="p-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-code mr-3 text-gray-500"></i>
                        Raw Log Data
                    </h3>
                    <div class="bg-gray-900 text-gray-300 p-6 rounded-xl overflow-x-auto">
                        <pre class="text-sm font-mono whitespace-pre-wrap">{{ json_encode($log->toArray(), JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

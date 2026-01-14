{{-- resources/views/admin/settings/logs.blade.php --}}
@extends('layouts.app')

@section('title', 'Page Title')

@section('header')
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('System Logs') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    View application logs and error messages
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <form action="{{ route('admin.settings.clear-logs') }}" method="POST"
                      onsubmit="return confirm('Clear all system logs?');">
                    @csrf
                    <button type="submit" class="btn bg-red-600 hover:bg-red-700 text-white">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Clear Logs
                    </button>
                </form>
                <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Settings
                </a>
            </div>
        </div>
    @endsection

@section('content')

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Log File Information -->
            <div class="card mb-8">
                <div class="p-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                Laravel Log File
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Application logs from storage/logs/laravel.log
                            </p>
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-4 md:mt-0">
                            @if(file_exists(storage_path('logs/laravel.log')))
                                <i class="fas fa-clock mr-2"></i>
                                Last modified: {{ date('d M Y H:i:s', filemtime(storage_path('logs/laravel.log'))) }}
                            @endif
                        </div>
                    </div>

                    <!-- Log Statistics -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="p-4 bg-blue-50 dark:bg-blue-900/30 rounded-xl">
                            <div class="text-sm text-blue-600 dark:text-blue-400 mb-2">
                                <i class="fas fa-file-alt mr-2"></i>
                                File Location
                            </div>
                            <div class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                storage/logs/laravel.log
                            </div>
                        </div>

                        <div class="p-4 bg-green-50 dark:bg-green-900/30 rounded-xl">
                            <div class="text-sm text-green-600 dark:text-green-400 mb-2">
                                <i class="fas fa-list-alt mr-2"></i>
                                Log Entries
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ count($logs) }}
                            </div>
                        </div>

                        <div class="p-4 bg-purple-50 dark:bg-purple-900/30 rounded-xl">
                            <div class="text-sm text-purple-600 dark:text-purple-400 mb-2">
                                <i class="fas fa-weight-hanging mr-2"></i>
                                File Size
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                @if(file_exists(storage_path('logs/laravel.log')))
                                    {{ round(filesize(storage_path('logs/laravel.log')) / 1024, 2) }} KB
                                @else
                                    0 KB
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Security Warning -->
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-6">
                        <div class="flex">
                            <i class="fas fa-exclamation-triangle text-yellow-500 mt-1"></i>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Security Notice</h4>
                                <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                    <p>System logs may contain sensitive information including passwords, API keys, and user data.</p>
                                    <p class="mt-1">Access to this page should be restricted to authorized administrators only.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Log Entries -->
            <div class="card">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Recent Log Entries
                        </h3>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Showing last 100 entries
                        </span>
                    </div>

                    @if(count($logs) > 0)
                    <div class="space-y-3 max-h-[600px] overflow-y-auto">
                        @foreach($logs as $logLine)
                        @php
                            $bgColor = 'bg-gray-50 dark:bg-gray-800';
                            $textColor = 'text-gray-800 dark:text-gray-300';
                            $icon = 'fa-circle';

                            if (preg_match('/ERROR|CRITICAL/i', $logLine)) {
                                $bgColor = 'bg-red-50 dark:bg-red-900/20';
                                $textColor = 'text-red-800 dark:text-red-300';
                                $icon = 'fa-exclamation-circle';
                            } elseif (preg_match('/WARNING|ALERT/i', $logLine)) {
                                $bgColor = 'bg-yellow-50 dark:bg-yellow-900/20';
                                $textColor = 'text-yellow-800 dark:text-yellow-300';
                                $icon = 'fa-exclamation-triangle';
                            } elseif (preg_match('/INFO|NOTICE/i', $logLine)) {
                                $bgColor = 'bg-blue-50 dark:bg-blue-900/20';
                                $textColor = 'text-blue-800 dark:text-blue-300';
                                $icon = 'fa-info-circle';
                            } elseif (preg_match('/DEBUG/i', $logLine)) {
                                $bgColor = 'bg-gray-100 dark:bg-gray-800';
                                $textColor = 'text-gray-600 dark:text-gray-400';
                                $icon = 'fa-bug';
                            }
                        @endphp
                        <div class="{{ $bgColor }} p-4 rounded-xl">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas {{ $icon }} {{ str_replace('text-', 'text-', $icon == 'fa-circle' ? 'text-gray-400' : 'text-' . explode('-', $textColor)[1] . '-500') }} mt-1"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="font-mono text-sm {{ $textColor }} whitespace-pre-wrap break-all">
                                        {{ $logLine }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-file-alt text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No log entries found</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            The log file is empty or doesn't exist.
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Log Information Cards -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card">
                    <div class="p-6">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                            Log Information
                        </h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-folder mr-2"></i>
                                Location: storage/logs/
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-history mr-2"></i>
                                Auto-rotation: Daily
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-shield-alt mr-2"></i>
                                Retention: 14 days
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2 text-yellow-500"></i>
                            Log Types
                        </h4>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">ERROR - Critical issues</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">WARNING - Potential issues</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">INFO - General information</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                            <i class="fas fa-cogs mr-2 text-green-500"></i>
                            Log Management
                        </h4>
                        <div class="space-y-3">
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                Regular log rotation is configured to prevent excessive disk usage.
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span class="text-gray-600 dark:text-gray-400">Admin access only</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span class="text-gray-600 dark:text-gray-400">Automatic cleanup</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

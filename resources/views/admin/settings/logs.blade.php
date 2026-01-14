<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('System Logs') }}
            </h2>
            <div class="flex space-x-2">
                <form action="{{ route('admin.settings.clear-logs') }}" method="POST" onsubmit="return confirm('Clear all system logs?');">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                        Clear Logs
                    </button>
                </form>
                <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center px-3 py-1 bg-gray-300 text-gray-700 text-sm rounded hover:bg-gray-400">
                    ← Back to Settings
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Log File Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Laravel Log File</h3>
                        <div class="text-sm text-gray-500">
                            Last modified:
                            @if(file_exists(storage_path('logs/laravel.log')))
                                {{ date('d M Y H:i:s', filemtime(storage_path('logs/laravel.log'))) }}
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="p-4 bg-blue-50 rounded-lg">
                            <div class="text-sm text-blue-700">File Location</div>
                            <div class="text-sm font-medium text-gray-900 truncate">storage/logs/laravel.log</div>
                        </div>
                        <div class="p-4 bg-green-50 rounded-lg">
                            <div class="text-sm text-green-700">Log Entries</div>
                            <div class="text-2xl font-bold text-gray-900">{{ count($logs) }}</div>
                        </div>
                        <div class="p-4 bg-purple-50 rounded-lg">
                            <div class="text-sm text-purple-700">File Size</div>
                            <div class="text-2xl font-bold text-gray-900">
                                @if(file_exists(storage_path('logs/laravel.log')))
                                    {{ round(filesize(storage_path('logs/laravel.log')) / 1024, 2) }} KB
                                @else
                                    0 KB
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Warning</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>System logs may contain sensitive information. Only authorized administrators should view this page.</p>
                                    <p class="mt-1">Logs are automatically rotated and old entries may be deleted.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Log Entries -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Log Entries (Last 100)</h3>

                    @if(count($logs) > 0)
                    <div class="space-y-2 max-h-[600px] overflow-y-auto">
                        @foreach($logs as $index => $logLine)
                        @php
                            // Parse log line for color coding
                            $bgColor = 'bg-gray-50';
                            $textColor = 'text-gray-800';
                            $iconColor = 'text-gray-500';

                            if (str_contains($logLine, 'ERROR') || str_contains($logLine, 'CRITICAL')) {
                                $bgColor = 'bg-red-50';
                                $textColor = 'text-red-800';
                                $iconColor = 'text-red-500';
                            } elseif (str_contains($logLine, 'WARNING') || str_contains($logLine, 'ALERT')) {
                                $bgColor = 'bg-yellow-50';
                                $textColor = 'text-yellow-800';
                                $iconColor = 'text-yellow-500';
                            } elseif (str_contains($logLine, 'INFO') || str_contains($logLine, 'NOTICE')) {
                                $bgColor = 'bg-blue-50';
                                $textColor = 'text-blue-800';
                                $iconColor = 'text-blue-500';
                            } elseif (str_contains($logLine, 'DEBUG')) {
                                $bgColor = 'bg-gray-100';
                                $textColor = 'text-gray-600';
                                $iconColor = 'text-gray-500';
                            }
                        @endphp
                        <div class="p-3 {{ $bgColor }} rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    @if(str_contains($logLine, 'ERROR') || str_contains($logLine, 'CRITICAL'))
                                    <svg class="h-5 w-5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    @elseif(str_contains($logLine, 'WARNING'))
                                    <svg class="h-5 w-5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    @elseif(str_contains($logLine, 'INFO'))
                                    <svg class="h-5 w-5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                    @else
                                    <svg class="h-5 w-5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L7.586 10 5.293 7.707a1 1 0 010-1.414zM11 12a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                    </svg>
                                    @endif
                                </div>
                                <div class="ml-3 flex-1">
                                    <div class="text-sm font-mono {{ $textColor }} whitespace-pre-wrap break-all">
                                        {{ $logLine }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8 text-gray-500">
                        No log entries found.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

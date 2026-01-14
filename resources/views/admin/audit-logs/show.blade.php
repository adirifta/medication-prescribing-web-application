<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Audit Log Details') }}
            </h2>
            <a href="{{ route('admin.audit-logs.index') }}" class="inline-flex items-center px-3 py-1 bg-gray-300 text-gray-700 text-sm rounded hover:bg-gray-400">
                ← Back to Logs
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Log Details Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Info -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">Log Information</h4>
                            <div class="space-y-3">
                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <div class="text-sm text-gray-500">Log ID</div>
                                    <div class="text-lg font-medium text-gray-900">{{ $log->id }}</div>
                                </div>
                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <div class="text-sm text-gray-500">Action</div>
                                    <div class="text-lg font-medium text-gray-900">
                                        <span class="px-2 py-1 text-sm font-semibold rounded-full
                                            {{ $log->action == 'CREATE' ? 'bg-green-100 text-green-800' :
                                               ($log->action == 'UPDATE' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $log->action }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <div class="text-sm text-gray-500">Table Name</div>
                                    <div class="text-lg font-medium text-gray-900">{{ $log->table_name }}</div>
                                </div>
                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <div class="text-sm text-gray-500">Timestamp</div>
                                    <div class="text-lg font-medium text-gray-900">{{ $log->created_at->format('d M Y H:i:s') }}</div>
                                    <div class="text-sm text-gray-500">{{ $log->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- User Info -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">User Information</h4>
                            @if($log->user)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded-full flex items-center justify-center">
                                        <span class="text-gray-600 font-medium">{{ substr($log->user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-lg font-medium text-gray-900">{{ $log->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $log->user->email }}</div>
                                        <div class="mt-1">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $log->user->role_badge }}">
                                                {{ $log->user->formatted_role }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="text-lg font-medium text-gray-900">System Action</div>
                                <div class="text-sm text-gray-500">This action was performed by the system</div>
                            </div>
                            @endif

                            <!-- Technical Info -->
                            <div class="mt-4 space-y-3">
                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <div class="text-sm text-gray-500">IP Address</div>
                                    <div class="text-lg font-medium text-gray-900">{{ $log->ip_address }}</div>
                                </div>
                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <div class="text-sm text-gray-500">User Agent</div>
                                    <div class="text-sm font-medium text-gray-900 truncate">{{ $log->user_agent }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Changes -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Old Values -->
                @if($log->old_values)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Old Values</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <pre class="text-sm text-gray-800 whitespace-pre-wrap max-h-96 overflow-y-auto">{{ $log->formatted_old_values }}</pre>
                        </div>
                    </div>
                </div>
                @endif

                <!-- New Values -->
                @if($log->new_values)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">New Values</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <pre class="text-sm text-gray-800 whitespace-pre-wrap max-h-96 overflow-y-auto">{{ $log->formatted_new_values }}</pre>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            @if(!$log->old_values && !$log->new_values)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="text-center py-8 text-gray-500">
                        No data changes recorded for this log entry.
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>

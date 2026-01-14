<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Audit Logs') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    System activity logs and audit trail
                </p>
            </div>
            <form action="{{ route('admin.audit-logs.clear') }}" method="POST"
                  onsubmit="return confirm('Clear all logs older than 30 days?');">
                @csrf
                <button type="submit" class="btn bg-red-600 hover:bg-red-700 text-white">
                    <i class="fas fa-trash-alt mr-2"></i>
                    Clear Old Logs
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="card mb-8">
                <div class="p-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Search -->
                        <div>
                            <label class="form-label">Search</label>
                            <div class="relative">
                                <input type="text"
                                       name="search"
                                       value="{{ $search }}"
                                       placeholder="Table, user, or action"
                                       class="form-input pl-10">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Action Filter -->
                        <div>
                            <label class="form-label">Action</label>
                            <select name="action" class="form-input">
                                <option value="">All Actions</option>
                                @foreach($actions as $action)
                                <option value="{{ $action }}" {{ $selectedAction == $action ? 'selected' : '' }}>
                                    {{ $action }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Table Filter -->
                        <div>
                            <label class="form-label">Table</label>
                            <select name="table" class="form-input">
                                <option value="">All Tables</option>
                                @foreach($tableNames as $tableName)
                                <option value="{{ $tableName }}" {{ $selectedTable == $tableName ? 'selected' : '' }}>
                                    {{ $tableName }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div>
                            <label class="form-label">Date Range</label>
                            <div class="flex space-x-3">
                                <input type="date"
                                       name="date_from"
                                       value="{{ $dateFrom }}"
                                       class="form-input flex-1">
                                <input type="date"
                                       name="date_to"
                                       value="{{ $dateTo }}"
                                       class="form-input flex-1">
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="md:col-span-4 flex items-end space-x-3">
                            <button type="submit" class="btn btn-primary flex-1">
                                <i class="fas fa-filter mr-2"></i>
                                Apply Filters
                            </button>
                            <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-2"></i>
                                Clear All
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Logs Table -->
            <div class="card">
                <div class="p-6">
                    @if($logs->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Time
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            User
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Action
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Table
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Details
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            IP Address
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($logs as $log)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                            <!-- Time Column -->
                                            <td class="px-4 py-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $log->created_at->format('d M Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $log->created_at->format('H:i:s') }}
                                                </div>
                                            </td>

                                            <!-- User Column -->
                                            <td class="px-4 py-4">
                                                @if($log->user)
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mr-3">
                                                        <span class="text-gray-600 dark:text-gray-400 font-medium">
                                                            {{ substr($log->user->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $log->user->name }}
                                                        </div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ $log->user->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="text-sm text-gray-500 dark:text-gray-400">System</div>
                                                @endif
                                            </td>

                                            <!-- Action Column -->
                                            <td class="px-4 py-4">
                                                @php
                                                    $actionColors = [
                                                        'CREATE' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-200', 'icon' => 'fa-plus-circle'],
                                                        'UPDATE' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-200', 'icon' => 'fa-edit'],
                                                        'DELETE' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-800 dark:text-red-200', 'icon' => 'fa-trash-alt'],
                                                        'LOGIN' => ['bg' => 'bg-purple-100 dark:bg-purple-900/30', 'text' => 'text-purple-800 dark:text-purple-200', 'icon' => 'fa-sign-in-alt'],
                                                        'LOGOUT' => ['bg' => 'bg-gray-100 dark:bg-gray-700', 'text' => 'text-gray-800 dark:text-gray-200', 'icon' => 'fa-sign-out-alt'],
                                                    ];
                                                    $color = $actionColors[$log->action] ?? ['bg' => 'bg-gray-100 dark:bg-gray-700', 'text' => 'text-gray-800 dark:text-gray-200', 'icon' => 'fa-circle'];
                                                @endphp
                                                <div class="flex items-center">
                                                    <span class="badge {{ $color['bg'] }} {{ $color['text'] }}">
                                                        <i class="fas {{ $color['icon'] }} mr-2"></i>
                                                        {{ $log->action }}
                                                    </span>
                                                </div>
                                            </td>

                                            <!-- Table Column -->
                                            <td class="px-4 py-4">
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ $log->table_name }}
                                                </div>
                                            </td>

                                            <!-- Details Column -->
                                            <td class="px-4 py-4">
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    @if($log->action == 'UPDATE')
                                                        @php
                                                            $oldValues = $log->old_values;
                                                            $newValues = $log->new_values;

                                                            if (is_string($oldValues)) {
                                                                $oldValues = json_decode($oldValues, true);
                                                            }
                                                            if (is_string($newValues)) {
                                                                $newValues = json_decode($newValues, true);
                                                            }

                                                            $changes = [];
                                                            if (is_array($oldValues) && is_array($newValues)) {
                                                                $changes = array_keys(array_diff_assoc($newValues, $oldValues));
                                                            } elseif (is_array($newValues)) {
                                                                $changes = array_keys($newValues);
                                                            }
                                                        @endphp

                                                        @if(!empty($changes))
                                                            <div class="text-gray-600 dark:text-gray-400">
                                                                <i class="fas fa-edit mr-1"></i>
                                                                Updated {{ count($changes) }} field(s)
                                                            </div>
                                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                                {{ implode(', ', array_slice($changes, 0, 2)) }}
                                                                @if(count($changes) > 2)
                                                                    <span class="text-gray-400">+{{ count($changes) - 2 }} more</span>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <span class="text-gray-500 dark:text-gray-400">
                                                                <i class="fas fa-info-circle mr-1"></i>
                                                                Updated (no field changes)
                                                            </span>
                                                        @endif

                                                    @elseif($log->action == 'CREATE')
                                                        <div class="text-green-600 dark:text-green-400">
                                                            <i class="fas fa-plus-circle mr-1"></i>
                                                            Created new record
                                                        </div>
                                                        @if($log->new_values)
                                                            @php
                                                                $newData = $log->new_values;
                                                                if (is_string($newData)) {
                                                                    $newData = json_decode($newData, true);
                                                                }
                                                            @endphp
                                                            @if(is_array($newData) && !empty($newData))
                                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                                {{ Str::limit(json_encode(array_slice($newData, 0, 2)), 50) }}
                                                            </div>
                                                            @endif
                                                        @endif

                                                    @elseif($log->action == 'DELETE')
                                                        <div class="text-red-600 dark:text-red-400">
                                                            <i class="fas fa-trash-alt mr-1"></i>
                                                            Deleted record
                                                        </div>

                                                    @else
                                                        <span class="text-gray-600 dark:text-gray-400">
                                                            {{ $log->description ?? 'Action performed' }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- IP Address Column -->
                                            <td class="px-4 py-4">
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $log->ip_address }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($logs->hasPages())
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-700 dark:text-gray-300">
                                    Showing {{ $logs->firstItem() }} to {{ $logs->lastItem() }} of {{ $logs->total() }} log entries
                                </div>
                                <div class="flex space-x-2">
                                    {{ $logs->links() }}
                                </div>
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-history text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No audit logs found</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                @if($search || $selectedAction || $selectedTable || $dateFrom || $dateTo)
                                    No logs match your filter criteria.
                                @else
                                    There are no audit logs in the system yet.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistics -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-5 gap-6">
                <div class="card">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-2">
                            {{ $totalLogs }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Logs</div>
                    </div>
                </div>
                <div class="card">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400 mb-2">
                            {{ $logs->where('action', 'CREATE')->count() }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Create Actions</div>
                    </div>
                </div>
                <div class="card">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-2">
                            {{ $logs->where('action', 'UPDATE')->count() }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Update Actions</div>
                    </div>
                </div>
                <div class="card">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-red-600 dark:text-red-400 mb-2">
                            {{ $logs->where('action', 'DELETE')->count() }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Delete Actions</div>
                    </div>
                </div>
                <div class="card">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400 mb-2">
                            {{ $logs->whereIn('action', ['LOGIN', 'LOGOUT'])->count() }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Auth Actions</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

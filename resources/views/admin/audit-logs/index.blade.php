<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Audit Logs') }}
            </h2>
            <form action="{{ route('admin.audit-logs.clear') }}" method="POST" onsubmit="return confirm('Clear all logs older than 30 days?');">
                @csrf
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Clear Old Logs
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" name="search" value="{{ $search }}" placeholder="Table, user, or action" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Action</label>
                            <select name="action" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">All Actions</option>
                                @foreach($actions as $action)
                                <option value="{{ $action }}" {{ $action == $action ? 'selected' : '' }}>{{ $action }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Table</label>
                            <select name="table" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">All Tables</option>
                                @foreach($tableNames as $tableName)
                                <option value="{{ $tableName }}" {{ $tableName == $table ? 'selected' : '' }}>{{ $tableName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date Range</label>
                            <div class="flex space-x-2">
                                <input type="date" name="date_from" value="{{ $dateFrom }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <input type="date" name="date_to" value="{{ $dateTo }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="md:col-span-4 flex items-end space-x-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Filter
                            </button>
                            <a href="{{ route('admin.audit-logs.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Logs Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Time
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Table
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Details
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        IP Address
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($logs as $log)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $log->created_at->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $log->created_at->format('H:i:s') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($log->user)
                                            <div class="flex items-center">
                                                <div class="text-sm font-medium text-gray-900">{{ $log->user->name }}</div>
                                                <div class="ml-2 px-2 py-1 text-xs font-semibold rounded-full {{ $log->user->role_badge }}">
                                                    {{ $log->user->formatted_role }}
                                                </div>
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $log->user->email }}</div>
                                            @else
                                            <div class="text-sm text-gray-500">System</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $log->action == 'CREATE' ? 'bg-green-100 text-green-800' :
                                                ($log->action == 'UPDATE' ? 'bg-blue-100 text-blue-800' :
                                                ($log->action == 'DELETE' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                                {{ $log->action }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $log->table_name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">
                                                @if($log->action == 'UPDATE')
                                                    @php
                                                        // Cek apakah values sudah array atau masih string JSON
                                                        $oldValues = $log->old_values;
                                                        $newValues = $log->new_values;

                                                        // Jika masih string, decode
                                                        if (is_string($oldValues)) {
                                                            $oldValues = json_decode($oldValues, true);
                                                        }
                                                        if (is_string($newValues)) {
                                                            $newValues = json_decode($newValues, true);
                                                        }

                                                        // Cari perubahan
                                                        $changes = [];
                                                        if (is_array($oldValues) && is_array($newValues)) {
                                                            $changes = array_keys(array_diff_assoc($newValues, $oldValues));
                                                        } elseif (is_array($newValues)) {
                                                            $changes = array_keys($newValues);
                                                        }
                                                    @endphp

                                                    @if(!empty($changes))
                                                        <span class="text-gray-600">Updated:</span>
                                                        {{ implode(', ', array_slice($changes, 0, 3)) }}
                                                        @if(count($changes) > 3)
                                                            <span class="text-gray-500">+{{ count($changes) - 3 }} more</span>
                                                        @endif
                                                    @else
                                                        <span class="text-gray-500">Updated (no field changes detected)</span>
                                                    @endif

                                                @elseif($log->action == 'CREATE')
                                                    <span class="text-green-600">Created new record</span>
                                                    @if($log->new_values && is_array($log->new_values))
                                                        @php
                                                            $newValues = $log->new_values;
                                                            if (is_string($newValues)) {
                                                                $newValues = json_decode($newValues, true);
                                                            }
                                                            $fields = array_keys(array_slice($newValues, 0, 2));
                                                        @endphp
                                                        @if(!empty($fields))
                                                            <div class="text-xs text-gray-500 mt-1">
                                                                Fields: {{ implode(', ', $fields) }}
                                                            </div>
                                                        @endif
                                                    @endif

                                                @elseif($log->action == 'DELETE')
                                                    <span class="text-red-600">Deleted record</span>
                                                    @if($log->old_values && is_array($log->old_values))
                                                        @php
                                                            $oldValues = $log->old_values;
                                                            if (is_string($oldValues)) {
                                                                $oldValues = json_decode($oldValues, true);
                                                            }
                                                            $fields = array_keys(array_slice($oldValues, 0, 2));
                                                        @endphp
                                                        @if(!empty($fields))
                                                            <div class="text-xs text-gray-500 mt-1">
                                                                Contained: {{ implode(', ', $fields) }}
                                                            </div>
                                                        @endif
                                                    @endif

                                                @else
                                                    <span class="text-gray-600">{{ $log->description ?? 'Action performed' }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $log->ip_address }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            No audit logs found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

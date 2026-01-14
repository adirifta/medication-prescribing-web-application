<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex items-center px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                    Edit
                </a>
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-3 py-1 bg-gray-300 text-gray-700 text-sm rounded hover:bg-gray-400">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- User Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="flex-shrink-0 h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center text-xl font-bold text-gray-700">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                                <div class="flex items-center mt-1">
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $user->role_badge }}">
                                        {{ $user->formatted_role }}
                                    </span>
                                    <span class="ml-3 text-sm text-gray-500">Member since {{ $user->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <div class="text-sm text-gray-500">Last Login</div>
                            <div class="text-lg font-semibold text-gray-900">
                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                            </div>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="text-sm text-gray-500">Email Address</div>
                            <div class="text-lg font-medium text-gray-900">{{ $user->email }}</div>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="text-sm text-gray-500">Phone Number</div>
                            <div class="text-lg font-medium text-gray-900">{{ $user->phone }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            @if(!empty($stats))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                @foreach($stats as $key => $value)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500 capitalize">{{ str_replace('_', ' ', $key) }}</div>
                        @if(strpos($key, 'revenue') !== false)
                        <div class="text-2xl font-bold text-green-600">IDR {{ number_format($value, 0, ',', '.') }}</div>
                        @else
                        <div class="text-2xl font-bold text-gray-900">{{ $value }}</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Recent Activities -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Examinations (for Doctors) -->
                @if($user->isDoctor() && $user->examinations->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Recent Examinations</h4>
                        <div class="space-y-3">
                            @foreach($user->examinations as $examination)
                            <div class="p-3 border border-gray-200 rounded-lg">
                                <div class="flex justify-between">
                                    <div class="font-medium text-gray-900">{{ $examination->patient->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $examination->created_at->diffForHumans() }}</div>
                                </div>
                                <div class="text-sm text-gray-600 mt-1">{{ Str::limit($examination->doctor_notes, 100) }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Recent Processed Prescriptions (for Pharmacists) -->
                @if($user->isPharmacist() && $user->processedPrescriptions->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Recent Processed Prescriptions</h4>
                        <div class="space-y-3">
                            @foreach($user->processedPrescriptions as $prescription)
                            <div class="p-3 border border-gray-200 rounded-lg">
                                <div class="flex justify-between">
                                    <div class="font-medium text-gray-900">Prescription #{{ str_pad($prescription->id, 6, '0', STR_PAD_LEFT) }}</div>
                                    <div class="text-sm text-gray-500">{{ $prescription->created_at->diffForHumans() }}</div>
                                </div>
                                <div class="text-sm text-gray-600 mt-1">
                                    Patient: {{ $prescription->examination->patient->name }}
                                    <span class="ml-3">Total: {{ $prescription->formatted_total_price }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Audit Logs -->
            @if($user->auditLogs->count() > 0)
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Recent Activities</h4>
                    <div class="space-y-3">
                        @foreach($user->auditLogs as $log)
                        <div class="p-3 border border-gray-200 rounded-lg">
                            <div class="flex justify-between">
                                <div>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $log->action == 'CREATE' ? 'bg-green-100 text-green-800' :
                                        ($log->action == 'UPDATE' ? 'bg-blue-100 text-blue-800' :
                                        ($log->action == 'DELETE' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ $log->action }}
                                    </span>
                                    <span class="ml-2 text-sm font-medium text-gray-900">{{ $log->table_name }}</span>
                                </div>
                                <div class="text-sm text-gray-500">{{ $log->created_at->diffForHumans() }}</div>
                            </div>

                            @if(!empty($log->old_values) || !empty($log->new_values))
                            <div class="text-xs text-gray-600 mt-2 space-y-1">
                                @if(!empty($log->old_values))
                                    @php
                                        $oldValues = is_string($log->old_values) ? json_decode($log->old_values, true) : $log->old_values;
                                    @endphp
                                    @if(is_array($oldValues) && !empty($oldValues))
                                    <div class="bg-red-50 p-2 rounded">
                                        <strong class="text-red-700">Before:</strong>
                                        @foreach($oldValues as $key => $value)
                                            <div>{{ $key }}: {{ is_array($value) ? json_encode($value) : $value }}</div>
                                        @endforeach
                                    </div>
                                    @endif
                                @endif

                                @if(!empty($log->new_values))
                                    @php
                                        $newValues = is_string($log->new_values) ? json_decode($log->new_values, true) : $log->new_values;
                                    @endphp
                                    @if(is_array($newValues) && !empty($newValues))
                                    <div class="bg-green-50 p-2 rounded">
                                        <strong class="text-green-700">After:</strong>
                                        @foreach($newValues as $key => $value)
                                            <div>{{ $key }}: {{ is_array($value) ? json_encode($value) : $value }}</div>
                                        @endforeach
                                    </div>
                                    @endif
                                @endif
                            </div>
                            @endif

                            @if($log->description)
                            <div class="text-xs text-gray-500 mt-2">
                                <strong>Description:</strong> {{ $log->description }}
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>

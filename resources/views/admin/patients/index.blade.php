<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Patient Management') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="flex space-x-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ $search }}" placeholder="Search by name, MRN, or phone..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Search
                        </button>
                        @if($search)
                        <a href="{{ route('admin.patients.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Clear
                        </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="text-sm text-gray-500">Total Patients</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $patients->total() }}</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="text-sm text-gray-500">Male Patients</div>
                    <div class="text-2xl font-bold text-blue-600">
                        {{ $patients->where('gender', 'male')->count() }}
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="text-sm text-gray-500">Female Patients</div>
                    <div class="text-2xl font-bold text-pink-600">
                        {{ $patients->where('gender', 'female')->count() }}
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="text-sm text-gray-500">New Today</div>
                    <div class="text-2xl font-bold text-green-600">
                        {{ $patients->filter(function($patient) {
                            return $patient->created_at->isToday();
                        })->count() }}
                    </div>
                </div>
            </div>

            <!-- Patients Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($patients->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            MRN
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Patient Details
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Contact
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Medical Info
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Visits
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($patients as $patient)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-mono text-gray-900">
                                                    {{ $patient->medical_record_number }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $patient->created_at->format('d/m/Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10
                                                        {{ $patient->gender == 'male' ? 'bg-blue-100' : 'bg-pink-100' }}
                                                        rounded-full flex items-center justify-center">
                                                        <span class="font-medium {{ $patient->gender == 'male' ? 'text-blue-600' : 'text-pink-600' }}">
                                                            {{ substr($patient->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $patient->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $patient->age }} years •
                                                            {{ ucfirst($patient->gender) }}
                                                        </div>
                                                        <div class="text-xs text-gray-400">
                                                            DOB: {{ $patient->date_of_birth->format('d M Y') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">
                                                    {{ $patient->phone }}
                                                </div>
                                                @if($patient->email)
                                                <div class="text-sm text-gray-500">
                                                    {{ $patient->email }}
                                                </div>
                                                @endif
                                                @if($patient->address)
                                                <div class="text-xs text-gray-400 truncate max-w-xs">
                                                    {{ $patient->address }}
                                                </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($patient->blood_type)
                                                <div class="text-sm">
                                                    <span class="font-medium text-gray-900">Blood:</span>
                                                    <span class="text-gray-700">{{ $patient->blood_type }}</span>
                                                </div>
                                                @endif
                                                @if($patient->allergies)
                                                <div class="text-xs text-red-600 truncate max-w-xs">
                                                    Allergies: {{ Str::limit($patient->allergies, 30) }}
                                                </div>
                                                @endif
                                                @if($patient->chronic_conditions)
                                                <div class="text-xs text-orange-600 truncate max-w-xs">
                                                    Conditions: {{ Str::limit($patient->chronic_conditions, 30) }}
                                                </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-center">
                                                    <div class="text-lg font-bold text-gray-900">
                                                        {{ $patient->examinations_count ?? 0 }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">examinations</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('admin.patients.show', $patient->id) }}" class="text-blue-600 hover:text-blue-900" title="View Details">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('doctor.examinations.create', ['patient_id' => $patient->id]) }}" class="text-purple-600 hover:text-purple-900" title="New Examination">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                        </svg>
                                                    </a>
                                                    @if($patient->emergency_contact_name)
                                                    <span class="text-yellow-600" title="Has Emergency Contact">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                                        </svg>
                                                    </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $patients->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No patients found</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if($search)
                                    No patients match your search criteria.
                                @else
                                    There are no patients in the system yet.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

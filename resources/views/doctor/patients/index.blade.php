<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Patient Management') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Manage your patient records and examinations
                </p>
            </div>
            <a href="{{ route('doctor.patients.create') }}" class="btn btn-primary flex items-center gap-2">
                <i class="fas fa-user-plus"></i>
                New Patient
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search and Filters -->
            <div class="card mb-6">
                <div class="p-6">
                    <form method="GET" class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ $search }}"
                                    placeholder="Search by name, MRN, or phone..."
                                    class="form-input pl-10"
                                >
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="btn btn-primary px-6">
                                <i class="fas fa-search mr-2"></i>
                                Search
                            </button>
                            @if($search)
                                <a href="{{ route('doctor.patients.index') }}" class="btn btn-secondary px-6">
                                    <i class="fas fa-times mr-2"></i>
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Stats Summary -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-users text-blue-600 dark:text-blue-400 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total Patients</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $patients->total() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-file-medical text-green-600 dark:text-green-400 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total Examinations</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalExaminations }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-calendar-check text-purple-600 dark:text-purple-400 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Today's Visits</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $todayVisits }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Patients Table -->
            <div class="card">
                <div class="p-6">
                    @if($patients->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Patient
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Contact
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Last Visit
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($patients as $patient)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                        <td class="px-4 py-4">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mr-3">
                                                    <span class="text-blue-600 dark:text-blue-400 font-semibold">
                                                        {{ substr($patient->name, 0, 1) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $patient->name }}
                                                    </div>
                                                    <div class="flex items-center mt-1">
                                                        <span class="text-xs px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 mr-2">
                                                            {{ $patient->medical_record_number }}
                                                        </span>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ ucfirst($patient->gender) }} • {{ $patient->age }} yrs
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $patient->phone }}</div>
                                            @if($patient->email)
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $patient->email }}</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            @if($patient->examinations->count() > 0)
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ $patient->examinations->first()->examination_date->format('d M Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $patient->examinations_count ?? 0 }} visits
                                                </div>
                                            @else
                                                <div class="text-sm text-gray-500 dark:text-gray-400 italic">No visits yet</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('doctor.patients.show', $patient->id) }}"
                                                   class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 p-2 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20"
                                                   title="View Patient">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('doctor.patients.edit', $patient->id) }}"
                                                   class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 p-2 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20"
                                                   title="Edit Patient">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('doctor.examinations.create', ['patient_id' => $patient->id]) }}"
                                                   class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 p-2 rounded-lg hover:bg-purple-50 dark:hover:bg-purple-900/20"
                                                   title="New Examination">
                                                    <i class="fas fa-file-medical"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $patients->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-injured text-gray-400 dark:text-gray-600 text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No patients found</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                                @if($search)
                                    No patients match your search criteria. Try different keywords.
                                @else
                                    You haven't added any patients yet. Start by creating your first patient record.
                                @endif
                            </p>
                            <a href="{{ route('doctor.patients.create') }}" class="btn btn-primary inline-flex items-center gap-2">
                                <i class="fas fa-user-plus"></i>
                                Add First Patient
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

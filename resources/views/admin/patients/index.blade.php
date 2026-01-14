@extends('layouts.app')

@section('title', 'Page Title')

@section('header')
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Patient Management') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Manage patient records and medical history
                </p>
            </div>
        </div>
    @endsection

@section('content')

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search and Filters -->
            <div class="card mb-8">
                <div class="p-6">
                    <form method="GET" class="flex space-x-4">
                        <div class="flex-1">
                            <div class="relative">
                                <input type="text"
                                       name="search"
                                       value="{{ $search }}"
                                       placeholder="Search by name, MRN, or phone..."
                                       class="form-input pl-10">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search mr-2"></i>
                            Search
                        </button>
                        @if($search)
                        <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-2"></i>
                            Clear
                        </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Patient Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 gradient-primary rounded-xl flex items-center justify-center">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Patients</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $patients->total() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-male text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Male Patients</p>
                                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">
                                    {{ $patients->where('gender', 'male')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-pink-500 to-pink-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-female text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Female Patients</p>
                                <p class="text-2xl font-bold text-pink-600 dark:text-pink-400 mt-1">
                                    {{ $patients->where('gender', 'female')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-user-plus text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">New Today</p>
                                <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">
                                    {{ $patients->filter(function($patient) {
                                        return $patient->created_at->isToday();
                                    })->count() }}
                                </p>
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
                                            MRN
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Patient Details
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Contact
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Medical Info
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Visits
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
                                                <div class="font-mono text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $patient->medical_record_number }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $patient->created_at->format('d/m/Y') }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-4">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 {{ $patient->gender == 'male' ? 'bg-blue-100 dark:bg-blue-900/30' : 'bg-pink-100 dark:bg-pink-900/30' }} rounded-full flex items-center justify-center">
                                                        <span class="{{ $patient->gender == 'male' ? 'text-blue-600 dark:text-blue-400' : 'text-pink-600 dark:text-pink-400' }} font-medium">
                                                            {{ substr($patient->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $patient->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $patient->age }} years •
                                                            {{ ucfirst($patient->gender) }}
                                                        </div>
                                                        <div class="text-xs text-gray-400 dark:text-gray-500">
                                                            DOB: {{ $patient->date_of_birth->format('d M Y') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4">
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    <i class="fas fa-phone mr-2 text-gray-400"></i>
                                                    {{ $patient->phone }}
                                                </div>
                                                @if($patient->email)
                                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                    <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                                    {{ $patient->email }}
                                                </div>
                                                @endif
                                                @if($patient->address)
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate max-w-xs">
                                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                                    {{ $patient->address }}
                                                </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4">
                                                @if($patient->blood_type)
                                                <div class="text-sm mb-1">
                                                    <span class="font-medium text-gray-600 dark:text-gray-400">Blood:</span>
                                                    <span class="ml-1 text-gray-900 dark:text-white">{{ $patient->blood_type }}</span>
                                                </div>
                                                @endif
                                                @if($patient->allergies)
                                                <div class="text-xs text-red-600 dark:text-red-400 truncate max-w-xs">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    {{ Str::limit($patient->allergies, 30) }}
                                                </div>
                                                @endif
                                                @if($patient->chronic_conditions)
                                                <div class="text-xs text-orange-600 dark:text-orange-400 truncate max-w-xs mt-1">
                                                    <i class="fas fa-heartbeat mr-1"></i>
                                                    {{ Str::limit($patient->chronic_conditions, 30) }}
                                                </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4">
                                                <div class="text-center">
                                                    <div class="text-lg font-bold text-gray-900 dark:text-white">
                                                        {{ $patient->examinations_count ?? 0 }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">examinations</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4">
                                                <div class="flex items-center space-x-3">
                                                    <a href="{{ route('admin.patients.show', $patient->id) }}"
                                                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300"
                                                       title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('doctor.examinations.create', ['patient_id' => $patient->id]) }}"
                                                       class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300"
                                                       title="New Examination">
                                                        <i class="fas fa-file-medical-alt"></i>
                                                    </a>
                                                    @if($patient->emergency_contact_name)
                                                    <span class="text-yellow-600 dark:text-yellow-400" title="Has Emergency Contact">
                                                        <i class="fas fa-exclamation-circle"></i>
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
                        @if($patients->hasPages())
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-700 dark:text-gray-300">
                                    Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of {{ $patients->total() }} patients
                                </div>
                                <div class="flex space-x-2">
                                    {{ $patients->links() }}
                                </div>
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-user-injured text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No patients found</h3>
                            <p class="text-gray-600 dark:text-gray-400">
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
@endsection

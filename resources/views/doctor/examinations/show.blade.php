{{-- resources/views/doctor/examinations/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Page Title')

@section('header')
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Examination Details
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    View examination information and prescription
                </p>
            </div>
            <div class="flex items-center space-x-4">
                <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                    <i class="fas fa-moon text-gray-600 dark:text-yellow-400" id="theme-icon"></i>
                </button>
                <div class="flex space-x-2">
                    @if(!$examination->prescription || $examination->prescription->canBeEdited())
                    <a href="{{ route('doctor.examinations.edit', $examination->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                    @endif
                    <a href="{{ route('doctor.examinations.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    @endsection

@section('content')

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Patient Info -->
            <div class="card mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-injured text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $examination->patient->name }}
                                </h3>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    <span class="flex items-center">
                                        <i class="fas fa-id-card mr-2"></i>
                                        MRN: {{ $examination->patient->medical_record_number }}
                                    </span>
                                    <span class="flex items-center mt-1">
                                        <i class="fas fa-venus-mars mr-2"></i>
                                        {{ ucfirst($examination->patient->gender) }}, {{ $examination->patient->age }} years
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center md:text-right">
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Examination Date</div>
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $examination->formatted_examination_date }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $examination->created_at->format('H:i') }} WIB
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vital Signs and Doctor Notes -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Vital Signs -->
                <div class="card">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-heart-pulse mr-3 text-red-500"></i>
                            Vital Signs
                        </h4>

                        <div class="grid grid-cols-2 gap-4">
                            @if($examination->height)
                            <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg">
                                <div class="text-sm text-blue-700 dark:text-blue-300 mb-2 flex items-center">
                                    <i class="fas fa-ruler-vertical mr-2"></i>
                                    Height
                                </div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $examination->height }} cm
                                </div>
                            </div>
                            @endif

                            @if($examination->weight)
                            <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg">
                                <div class="text-sm text-blue-700 dark:text-blue-300 mb-2 flex items-center">
                                    <i class="fas fa-weight-scale mr-2"></i>
                                    Weight
                                </div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $examination->weight }} kg
                                </div>
                            </div>
                            @endif

                            @if($examination->bmi)
                            <div class="p-4 bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg">
                                <div class="text-sm text-green-700 dark:text-green-300 mb-2 flex items-center">
                                    <i class="fas fa-chart-line mr-2"></i>
                                    BMI
                                </div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $examination->bmi }}
                                </div>
                            </div>
                            @endif

                            @if($examination->blood_pressure)
                            <div class="p-4 bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-lg">
                                <div class="text-sm text-red-700 dark:text-red-300 mb-2 flex items-center">
                                    <i class="fas fa-tachometer-alt mr-2"></i>
                                    Blood Pressure
                                </div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $examination->blood_pressure }}
                                </div>
                            </div>
                            @endif

                            @if($examination->heart_rate)
                            <div class="p-4 bg-gradient-to-r from-pink-50 to-pink-100 dark:from-pink-900/20 dark:to-pink-800/20 rounded-lg">
                                <div class="text-sm text-pink-700 dark:text-pink-300 mb-2 flex items-center">
                                    <i class="fas fa-heartbeat mr-2"></i>
                                    Heart Rate
                                </div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $examination->heart_rate }} bpm
                                </div>
                            </div>
                            @endif

                            @if($examination->respiration_rate)
                            <div class="p-4 bg-gradient-to-r from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20 rounded-lg">
                                <div class="text-sm text-teal-700 dark:text-teal-300 mb-2 flex items-center">
                                    <i class="fas fa-lungs mr-2"></i>
                                    Respiration Rate
                                </div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $examination->respiration_rate }} /min
                                </div>
                            </div>
                            @endif

                            @if($examination->temperature)
                            <div class="p-4 bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 rounded-lg">
                                <div class="text-sm text-orange-700 dark:text-orange-300 mb-2 flex items-center">
                                    <i class="fas fa-thermometer-half mr-2"></i>
                                    Temperature
                                </div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $examination->temperature }} °C
                                </div>
                            </div>
                            @endif
                        </div>

                        @if(!$examination->height && !$examination->weight && !$examination->blood_pressure)
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-clipboard-question text-3xl mb-3"></i>
                            <p>No vital signs recorded</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Doctor Notes & Files -->
                <div class="card">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-stethoscope mr-3 text-blue-500"></i>
                            Doctor Notes
                        </h4>

                        <div class="prose max-w-none dark:prose-invert">
                            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg whitespace-pre-line">
                                {{ $examination->doctor_notes }}
                            </div>
                        </div>

                        @if($examination->external_file_path)
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                <i class="fas fa-paperclip mr-2"></i>
                                Attached File
                            </h5>
                            <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <i class="fas fa-file-medical text-gray-400 dark:text-gray-500 text-2xl mr-3"></i>
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        External Examination File
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        Uploaded on {{ $examination->created_at->format('d M Y') }}
                                    </div>
                                </div>
                                <a href="{{ Storage::url($examination->external_file_path) }}" target="_blank"
                                   class="btn btn-secondary text-sm px-3 py-1">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Prescription Information -->
            @if($examination->prescription)
            @php
                $examination->load(['prescription.items']);
            @endphp
            <div class="card mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-prescription-bottle-alt mr-3 text-purple-500"></i>
                            Prescription Details
                        </h4>
                        <span class="badge {{ $examination->prescription->status == 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' :
                                               ($examination->prescription->status == 'processed' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' :
                                               'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200') }}">
                            <i class="fas fa-circle text-xs mr-1"></i>
                            {{ ucfirst($examination->prescription->status) }}
                        </span>
                    </div>

                    @if($examination->prescription->notes)
                    <div class="mb-6">
                        <div class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <i class="fas fa-notes-medical mr-2"></i>
                            Prescription Notes
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                            {{ $examination->prescription->notes }}
                        </div>
                    </div>
                    @endif

                    @if($examination->prescription->items->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Medicine
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Quantity
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Unit Price
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Subtotal
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Instructions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($examination->prescription->items as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                    <td class="px-4 py-4">
                                        <div class="flex items-center">
                                            <i class="fas fa-pills text-purple-500 mr-3"></i>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $item->medicine_name }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $item->quantity }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $item->formatted_unit_price }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $item->formatted_subtotal }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white max-w-xs">
                                            {{ $item->instructions ?? '-' }}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-right text-sm font-medium text-gray-900 dark:text-white">
                                        Total:
                                    </td>
                                    <td colspan="2" class="px-4 py-4 text-sm font-bold text-gray-900 dark:text-white">
                                        {{ $examination->prescription->formatted_total_price }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-pills text-3xl mb-3"></i>
                        <p>No medicines prescribed</p>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <!-- No Prescription -->
            <div class="card mb-6">
                <div class="p-6">
                    <div class="text-center py-8">
                        <div class="w-20 h-20 bg-gradient-to-r from-purple-100 to-purple-200 dark:from-purple-900/30 dark:to-purple-800/30 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-prescription-bottle-alt text-purple-500 dark:text-purple-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No prescription</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                            No prescription has been created for this examination. You can add a prescription by editing this examination.
                        </p>
                        <a href="{{ route('doctor.examinations.edit', $examination->id) }}" class="btn btn-primary">
                            <i class="fas fa-prescription-bottle-alt mr-2"></i>
                            Add Prescription
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Status and Actions -->
            <div class="card">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Examination Status</div>
                            <div class="flex items-center">
                                <span class="badge {{ $examination->status == 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' :
                                                        ($examination->status == 'processed' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' :
                                                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200') }}">
                                    <i class="fas fa-circle text-xs mr-1"></i>
                                    {{ ucfirst($examination->status) }}
                                </span>
                                <div class="text-sm text-gray-500 dark:text-gray-400 ml-3">
                                    Last updated: {{ $examination->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        <div class="flex space-x-3 mt-4 md:mt-0">
                            @if(!$examination->prescription || $examination->prescription->canBeEdited())
                            <a href="{{ route('doctor.examinations.edit', $examination->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Examination
                            </a>
                            @endif
                            <a href="{{ route('doctor.examinations.index') }}" class="btn btn-secondary">
                                <i class="fas fa-list mr-2"></i>
                                Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');

        if (localStorage.getItem('theme') === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            if (themeIcon) {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            }
        }

        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                document.documentElement.classList.toggle('dark');

                if (document.documentElement.classList.contains('dark')) {
                    localStorage.setItem('theme', 'dark');
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                } else {
                    localStorage.setItem('theme', 'light');
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                }
            });
        }
    </script>
    @endpush
@endsection

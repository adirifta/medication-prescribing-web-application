<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Patient Details') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    {{ $patient->medical_record_number }}
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('doctor.examinations.create', ['patient_id' => $patient->id]) }}"
                   class="btn btn-primary flex items-center gap-2">
                    <i class="fas fa-file-medical"></i>
                    New Examination
                </a>
                <div class="relative group">
                    <button class="btn btn-secondary">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 hidden group-hover:block z-10">
                        <a href="{{ route('doctor.patients.edit', $patient->id) }}"
                           class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-t-lg">
                            <i class="fas fa-edit mr-2"></i> Edit Patient
                        </a>
                        <a href="{{ route('doctor.patients.index') }}"
                           class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 border-t border-gray-200 dark:border-gray-700">
                            <i class="fas fa-arrow-left mr-2"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Patient Overview -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Patient Profile -->
                <div class="lg:col-span-2">
                    <div class="card">
                        <div class="p-8">
                            <div class="flex flex-col md:flex-row md:items-center">
                                <div class="flex items-center mb-6 md:mb-0 md:mr-8">
                                    <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-3xl font-bold text-white">
                                        {{ substr($patient->name, 0, 1) }}
                                    </div>
                                </div>

                                <div class="flex-1">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $patient->name }}</h3>
                                    <div class="flex flex-wrap items-center gap-3 mt-2">
                                        <span class="badge badge-primary">
                                            <i class="fas fa-id-card mr-1"></i>
                                            {{ $patient->medical_record_number }}
                                        </span>
                                        <span class="badge bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            <i class="fas fa-{{ $patient->gender == 'male' ? 'mars' : 'venus' }} mr-1"></i>
                                            {{ ucfirst($patient->gender) }}
                                        </span>
                                        <span class="badge bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            <i class="fas fa-birthday-cake mr-1"></i>
                                            {{ $patient->age }} years
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                                        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                                                    <i class="fas fa-phone text-blue-600 dark:text-blue-400"></i>
                                                </div>
                                                <div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">Phone</div>
                                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $patient->phone }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-3">
                                                    <i class="fas fa-calendar-alt text-green-600 dark:text-green-400"></i>
                                                </div>
                                                <div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">Date of Birth</div>
                                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                                        {{ $patient->date_of_birth->format('d F Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if($patient->address)
                                        <div class="md:col-span-2 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mr-3">
                                                    <i class="fas fa-home text-purple-600 dark:text-purple-400"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">Address</div>
                                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $patient->address }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card">
                    <div class="p-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Medical Summary</h3>

                        <div class="space-y-6">
                            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">Examinations</div>
                                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $patient->examinations->count() }}</div>
                                    </div>
                                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center">
                                        <i class="fas fa-stethoscope text-blue-600 dark:text-blue-400 text-xl"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">Prescriptions</div>
                                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                            {{ $patient->examinations->where('prescription')->count() }}
                                        </div>
                                    </div>
                                    <div class="w-12 h-12 bg-green-100 dark:bg-green-800 rounded-full flex items-center justify-center">
                                        <i class="fas fa-prescription text-green-600 dark:text-green-400 text-xl"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">Last Visit</div>
                                        <div class="text-lg font-bold text-purple-600 dark:text-purple-400">
                                            @if($patient->examinations->count() > 0)
                                                {{ $patient->examinations->first()->examination_date->format('d M Y') }}
                                            @else
                                                Never
                                            @endif
                                        </div>
                                    </div>
                                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-800 rounded-full flex items-center justify-center">
                                        <i class="fas fa-calendar-check text-purple-600 dark:text-purple-400 text-xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('doctor.examinations.create', ['patient_id' => $patient->id]) }}"
                               class="w-full btn btn-primary text-center block">
                                <i class="fas fa-plus-circle mr-2"></i>
                                New Examination
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Examinations -->
            <div class="card mb-6">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Examinations</h3>
                        <a href="{{ route('doctor.examinations.create', ['patient_id' => $patient->id]) }}"
                           class="btn btn-primary">
                            <i class="fas fa-plus-circle mr-2"></i>
                            New Examination
                        </a>
                    </div>

                    @if($patient->examinations->count() > 0)
                        <div class="space-y-4">
                            @foreach($patient->examinations->take(5) as $examination)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2">
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                {{ $examination->examination_date->format('d F Y, H:i') }}
                                            </h4>
                                            <span class="ml-4 badge {{ $examination->status == 'completed' ? 'badge-success' : 'badge-warning' }}">
                                                {{ ucfirst($examination->status) }}
                                            </span>
                                        </div>

                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-3">
                                            <i class="fas fa-user-md mr-2"></i>
                                            Dr. {{ $examination->doctor->name }}
                                        </div>

                                        <p class="text-gray-600 dark:text-gray-400 line-clamp-2">
                                            {{ Str::limit($examination->doctor_notes, 200) }}
                                        </p>

                                        @if($examination->prescription)
                                        <div class="mt-4 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <i class="fas fa-prescription-bottle-alt text-green-600 dark:text-green-400 mr-2"></i>
                                                    <span class="font-medium text-green-800 dark:text-green-300">
                                                        Prescription: {{ $examination->prescription->items->count() }} medicines
                                                    </span>
                                                </div>
                                                <div class="text-right">
                                                    <div class="font-bold text-green-800 dark:text-green-300">
                                                        {{ $examination->prescription->formatted_total_price }}
                                                    </div>
                                                    <div class="text-xs text-green-600 dark:text-green-400">
                                                        {{ ucfirst($examination->prescription->status) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('doctor.examinations.show', $examination->id) }}"
                                           class="btn btn-outline px-4 py-2">
                                            <i class="fas fa-eye mr-2"></i>
                                            View
                                        </a>
                                        @if($examination->prescription)
                                        <a href="{{ route('doctor.examinations.prescription', $examination->id) }}"
                                           class="btn btn-primary px-4 py-2">
                                            <i class="fas fa-file-prescription mr-2"></i>
                                            Prescription
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @if($patient->examinations->count() > 5)
                        <div class="mt-6 text-center">
                            <a href="{{ route('doctor.examinations.index', ['patient_id' => $patient->id]) }}"
                               class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 font-medium inline-flex items-center">
                                View all {{ $patient->examinations->count() }} examinations
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                <i class="fas fa-file-medical text-gray-400 dark:text-gray-600 text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No examinations yet</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">
                                This patient hasn't had any examinations. Create the first one now.
                            </p>
                            <a href="{{ route('doctor.examinations.create', ['patient_id' => $patient->id]) }}"
                               class="btn btn-primary inline-flex items-center gap-2">
                                <i class="fas fa-plus-circle"></i>
                                Create First Examination
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Medical Timeline -->
            <div class="card">
                <div class="p-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Medical Timeline</h3>

                    <div class="relative">
                        <!-- Timeline line -->
                        <div class="absolute left-4 md:left-8 top-0 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>

                        <div class="space-y-8">
                            @foreach($patient->examinations->sortByDesc('examination_date') as $examination)
                            <div class="relative flex items-start">
                                <!-- Timeline dot -->
                                <div class="absolute left-3 md:left-7 mt-2 w-3 h-3 bg-blue-500 rounded-full"></div>

                                <!-- Timeline icon -->
                                <div class="absolute left-2 md:left-6 mt-1.5 w-6 h-6 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                    <i class="fas fa-stethoscope text-blue-600 dark:text-blue-400 text-xs"></i>
                                </div>

                                <div class="ml-10 md:ml-16 flex-1">
                                    <div class="card">
                                        <div class="p-6">
                                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                                                <div>
                                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white">
                                                        {{ $examination->examination_date->format('d F Y') }}
                                                    </h4>
                                                    <div class="flex items-center mt-2 text-sm text-gray-600 dark:text-gray-400">
                                                        <i class="fas fa-clock mr-2"></i>
                                                        {{ $examination->examination_date->format('H:i') }}
                                                        <span class="mx-2">•</span>
                                                        <i class="fas fa-user-md mr-2"></i>
                                                        Dr. {{ $examination->doctor->name }}
                                                    </div>
                                                </div>

                                                <div class="flex items-center space-x-3">
                                                    <span class="badge {{ $examination->status == 'completed' ? 'badge-success' : 'badge-warning' }}">
                                                        {{ ucfirst($examination->status) }}
                                                    </span>
                                                    <a href="{{ route('doctor.examinations.show', $examination->id) }}"
                                                       class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 font-medium">
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <div class="font-medium text-gray-900 dark:text-white mb-2">Diagnosis & Notes:</div>
                                                <p class="text-gray-600 dark:text-gray-400">{{ $examination->doctor_notes }}</p>
                                            </div>

                                            @if($examination->prescription)
                                            <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                                    <div class="flex items-center">
                                                        <div class="w-10 h-10 bg-green-100 dark:bg-green-800 rounded-lg flex items-center justify-center mr-3">
                                                            <i class="fas fa-prescription-bottle-alt text-green-600 dark:text-green-400"></i>
                                                        </div>
                                                        <div>
                                                            <div class="font-semibold text-green-800 dark:text-green-300">Prescription Issued</div>
                                                            <div class="text-sm text-green-600 dark:text-green-400">
                                                                {{ $examination->prescription->items->count() }} medicines
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="text-right">
                                                        <div class="text-xl font-bold text-green-800 dark:text-green-300">
                                                            {{ $examination->prescription->formatted_total_price }}
                                                        </div>
                                                        <div class="text-sm text-green-600 dark:text-green-400">
                                                            Status: {{ ucfirst($examination->prescription->status) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <!-- Patient Registration -->
                            <div class="relative flex items-start">
                                <div class="absolute left-3 md:left-7 mt-2 w-3 h-3 bg-green-500 rounded-full"></div>
                                <div class="absolute left-2 md:left-6 mt-1.5 w-6 h-6 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user-plus text-green-600 dark:text-green-400 text-xs"></i>
                                </div>

                                <div class="ml-10 md:ml-16">
                                    <div class="card">
                                        <div class="p-6">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-green-100 dark:bg-green-800 rounded-lg flex items-center justify-center mr-4">
                                                    <i class="fas fa-user-plus text-green-600 dark:text-green-400"></i>
                                                </div>
                                                <div>
                                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white">
                                                        Patient Registered
                                                    </h4>
                                                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                        {{ $patient->created_at->format('d F Y, H:i') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

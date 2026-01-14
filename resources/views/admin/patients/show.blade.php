<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Patient Details') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    View patient information and medical history
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Patients
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Patient Overview -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Patient Info Card -->
                <div class="card lg:col-span-2">
                    <div class="p-8">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                            <!-- Patient Avatar and Basic Info -->
                            <div class="flex items-center mb-6 lg:mb-0">
                                <div class="w-20 h-20 {{ $patient->gender == 'male' ? 'gradient-primary' : 'bg-gradient-to-r from-pink-500 to-pink-600' }} rounded-2xl flex items-center justify-center text-3xl font-bold text-white">
                                    {{ substr($patient->name, 0, 1) }}
                                </div>
                                <div class="ml-6">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $patient->name }}</h3>
                                    <div class="flex items-center mt-2 space-x-4">
                                        <span class="badge {{ $patient->gender == 'male' ? 'badge-primary' : 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200' }}">
                                            {{ ucfirst($patient->gender) }}
                                        </span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-id-card mr-1"></i>
                                            {{ strtoupper($patient->medical_record_number) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Registration Date -->
                            <div class="text-right">
                                <div class="text-sm text-gray-500 dark:text-gray-400">Patient Since</div>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $patient->created_at->format('d M Y') }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $patient->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Information -->
                        <div class="mt-8">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                <i class="fas fa-user-circle mr-3 text-primary-500"></i>
                                Personal Information
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                    <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                        <i class="fas fa-birthday-cake mr-2"></i>
                                        Date of Birth
                                    </div>
                                    <div class="text-lg font-medium text-gray-900 dark:text-white mt-1">
                                        {{ $patient->date_of_birth->format('d F Y') }}
                                    </div>
                                </div>

                                <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Age</div>
                                    <div class="text-lg font-medium text-gray-900 dark:text-white mt-1">
                                        {{ $patient->age }} years
                                    </div>
                                </div>

                                <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                    <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                        <i class="fas fa-phone mr-2"></i>
                                        Phone Number
                                    </div>
                                    <div class="text-lg font-medium text-gray-900 dark:text-white mt-1">
                                        {{ $patient->phone }}
                                    </div>
                                </div>

                                @if($patient->email)
                                <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                    <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                        <i class="fas fa-envelope mr-2"></i>
                                        Email Address
                                    </div>
                                    <div class="text-lg font-medium text-gray-900 dark:text-white mt-1">
                                        {{ $patient->email }}
                                    </div>
                                </div>
                                @endif

                                @if($patient->address)
                                <div class="md:col-span-2 p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                    <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        Address
                                    </div>
                                    <div class="text-lg font-medium text-gray-900 dark:text-white mt-1">
                                        {{ $patient->address }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medical Stats Card -->
                <div class="card">
                    <div class="p-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-chart-line mr-3 text-medical-500"></i>
                            Medical Statistics
                        </h3>

                        <div class="space-y-6">
                            <div class="p-4 bg-blue-50 dark:bg-blue-900/30 rounded-xl">
                                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Examinations</div>
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">
                                    {{ $stats['total_examinations'] }}
                                </div>
                            </div>

                            <div class="p-4 bg-green-50 dark:bg-green-900/30 rounded-xl">
                                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Prescriptions</div>
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">
                                    {{ $stats['total_prescriptions'] }}
                                </div>
                            </div>

                            <div class="p-4 bg-purple-50 dark:bg-purple-900/30 rounded-xl">
                                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Last Visit</div>
                                <div class="text-lg font-bold text-purple-600 dark:text-purple-400 mt-1">
                                    @if($stats['last_examination'])
                                        {{ $stats['last_examination']->examination_date->format('d M Y') }}
                                    @else
                                        Never
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Medical Information -->
                        @if($patient->blood_type || $patient->allergies || $patient->chronic_conditions)
                        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Medical Information</h4>

                            @if($patient->blood_type)
                            <div class="mb-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Blood Type</div>
                                <div class="text-lg font-medium text-gray-900 dark:text-white">{{ $patient->blood_type }}</div>
                            </div>
                            @endif

                            @if($patient->allergies)
                            <div class="mb-3 p-3 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                                <div class="text-sm font-medium text-red-600 dark:text-red-400">Allergies</div>
                                <div class="text-sm text-gray-900 dark:text-gray-300">{{ $patient->allergies }}</div>
                            </div>
                            @endif

                            @if($patient->chronic_conditions)
                            <div class="p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg border border-orange-200 dark:border-orange-800">
                                <div class="text-sm font-medium text-orange-600 dark:text-orange-400">Chronic Conditions</div>
                                <div class="text-sm text-gray-900 dark:text-gray-300">{{ $patient->chronic_conditions }}</div>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            @if($patient->emergency_contact_name)
            <div class="card mb-8">
                <div class="p-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-3 text-yellow-500"></i>
                        Emergency Contact
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="p-4 bg-yellow-50 dark:bg-yellow-900/30 rounded-xl">
                            <div class="text-sm text-gray-500 dark:text-gray-400">Contact Name</div>
                            <div class="text-lg font-medium text-gray-900 dark:text-white mt-1">
                                {{ $patient->emergency_contact_name }}
                            </div>
                        </div>

                        <div class="p-4 bg-yellow-50 dark:bg-yellow-900/30 rounded-xl">
                            <div class="text-sm text-gray-500 dark:text-gray-400">Phone Number</div>
                            <div class="text-lg font-medium text-gray-900 dark:text-white mt-1">
                                {{ $patient->emergency_contact_phone }}
                            </div>
                        </div>

                        <div class="p-4 bg-yellow-50 dark:bg-yellow-900/30 rounded-xl">
                            <div class="text-sm text-gray-500 dark:text-gray-400">Relationship</div>
                            <div class="text-lg font-medium text-gray-900 dark:text-white mt-1">
                                {{ $patient->emergency_contact_relation }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Examinations -->
            <div class="card mb-8">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-file-medical-alt mr-3 text-primary-500"></i>
                            Recent Examinations
                        </h3>
                        @if($patient->examinations->count() > 5)
                        <a href="{{ route('doctor.examinations.index', ['patient_id' => $patient->id]) }}" class="btn btn-outline text-sm">
                            View All ({{ $patient->examinations->count() }})
                        </a>
                        @endif
                    </div>

                    @if($patient->examinations->count() > 0)
                        <div class="space-y-4">
                            @foreach($patient->examinations->take(5) as $examination)
                            <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-3">
                                            <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                                {{ $examination->examination_date->format('d F Y, H:i') }}
                                            </div>
                                            <span class="ml-3 badge {{ $examination->status == 'completed' ? 'badge-medical' : ($examination->status == 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 'badge-primary') }}">
                                                {{ ucfirst($examination->status) }}
                                            </span>
                                        </div>
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-3">
                                            <i class="fas fa-user-md mr-2"></i>
                                            Doctor: {{ $examination->doctor->name }}
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-300">
                                            {{ Str::limit($examination->doctor_notes, 150) }}
                                        </div>
                                    </div>
                                    @if($examination->prescription)
                                    <div class="lg:text-right mt-4 lg:mt-0">
                                        <div class="text-sm font-medium text-green-600 dark:text-green-400">
                                            Prescribed: {{ $examination->prescription->items->count() }} medicines
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            Total: {{ $examination->prescription->formatted_total_price }}
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-file-medical text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No examinations yet</h3>
                            <p class="text-gray-600 dark:text-gray-400">This patient hasn't had any examinations.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Patient Timeline -->
            <div class="card">
                <div class="p-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-8 flex items-center">
                        <i class="fas fa-history mr-3 text-primary-500"></i>
                        Patient Timeline
                    </h3>

                    <div class="relative">
                        <!-- Timeline line -->
                        <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>

                        <div class="space-y-8">
                            @foreach($patient->examinations->sortByDesc('examination_date')->take(5) as $examination)
                            <div class="relative flex items-start">
                                <!-- Timeline dot -->
                                <div class="absolute left-4 mt-2 w-3 h-3 bg-blue-500 dark:bg-blue-400 rounded-full"></div>

                                <div class="ml-10 flex-1">
                                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start mb-4">
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                                Examination - {{ $examination->examination_date->format('d F Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center">
                                                <i class="fas fa-clock mr-2"></i>
                                                {{ $examination->examination_date->format('H:i') }} •
                                                <i class="fas fa-user-md ml-3 mr-2"></i>
                                                Dr. {{ $examination->doctor->name }}
                                            </div>
                                        </div>
                                        <div class="mt-2 lg:mt-0">
                                            <div class="text-sm font-medium {{ $examination->status == 'completed' ? 'text-green-600 dark:text-green-400' : ($examination->status == 'pending' ? 'text-yellow-600 dark:text-yellow-400' : 'text-blue-600 dark:text-blue-400') }}">
                                                {{ ucfirst($examination->status) }}
                                            </div>
                                            @if($examination->prescription)
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                Prescription: {{ $examination->prescription->status }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Vital Signs -->
                                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                                        <div class="font-medium text-gray-900 dark:text-white mb-3">Vital Signs</div>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            @if($examination->height && $examination->weight)
                                            <div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">BMI</div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $examination->bmi }}</div>
                                            </div>
                                            @endif
                                            @if($examination->systolic && $examination->diastolic)
                                            <div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">Blood Pressure</div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $examination->blood_pressure }}</div>
                                            </div>
                                            @endif
                                            @if($examination->heart_rate)
                                            <div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">Heart Rate</div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $examination->heart_rate }} bpm</div>
                                            </div>
                                            @endif
                                            @if($examination->temperature)
                                            <div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">Temperature</div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $examination->temperature }}°C</div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <!-- Patient Registration -->
                            <div class="relative flex items-start">
                                <div class="absolute left-4 mt-2 w-3 h-3 bg-green-500 dark:bg-green-400 rounded-full"></div>
                                <div class="ml-10">
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Patient Registered
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        {{ $patient->created_at->format('d F Y, H:i') }}
                                    </div>
                                    <div class="mt-3 text-sm text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                                        Patient record created in the system with MRN: {{ $patient->medical_record_number }}
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

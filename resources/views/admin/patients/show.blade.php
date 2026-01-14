<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Patient Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.patients.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Patient Overview -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Patient Info Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg lg:col-span-2">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex items-center mb-4 md:mb-0">
                                <div class="flex-shrink-0 h-20 w-20
                                    {{ $patient->gender == 'male' ? 'bg-blue-100' : 'bg-pink-100' }}
                                    rounded-full flex items-center justify-center text-2xl font-bold
                                    {{ $patient->gender == 'male' ? 'text-blue-600' : 'text-pink-600' }}">
                                    {{ substr($patient->name, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-2xl font-bold text-gray-900">{{ $patient->name }}</h3>
                                    <div class="flex items-center mt-1">
                                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ strtoupper($patient->medical_record_number) }}
                                        </span>
                                        <span class="ml-3 text-sm text-gray-500">
                                            {{ $patient->gender == 'male' ? 'Male' : 'Female' }} • {{ $patient->age }} years
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <div class="text-sm text-gray-500">Patient Since</div>
                                <div class="text-lg font-semibold text-gray-900">
                                    {{ $patient->created_at->format('d M Y') }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $patient->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Information -->
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <div class="text-sm text-gray-500">Date of Birth</div>
                                    <div class="text-lg font-medium text-gray-900">
                                        {{ $patient->date_of_birth->format('d F Y') }}
                                    </div>
                                </div>

                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <div class="text-sm text-gray-500">Age</div>
                                    <div class="text-lg font-medium text-gray-900">
                                        {{ $patient->age }} years
                                    </div>
                                </div>

                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <div class="text-sm text-gray-500">Phone Number</div>
                                    <div class="text-lg font-medium text-gray-900">
                                        {{ $patient->phone }}
                                    </div>
                                </div>

                                @if($patient->email)
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <div class="text-sm text-gray-500">Email</div>
                                    <div class="text-lg font-medium text-gray-900">
                                        {{ $patient->email }}
                                    </div>
                                </div>
                                @endif

                                @if($patient->address)
                                <div class="md:col-span-2 p-4 bg-gray-50 rounded-lg">
                                    <div class="text-sm text-gray-500">Address</div>
                                    <div class="text-lg font-medium text-gray-900">{{ $patient->address }}</div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medical Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Medical Statistics</h3>

                        <div class="space-y-4">
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <div class="text-sm text-gray-500">Total Examinations</div>
                                <div class="text-2xl font-bold text-blue-600">{{ $stats['total_examinations'] }}</div>
                            </div>

                            <div class="p-3 bg-green-50 rounded-lg">
                                <div class="text-sm text-gray-500">Prescriptions</div>
                                <div class="text-2xl font-bold text-green-600">{{ $stats['total_prescriptions'] }}</div>
                            </div>

                            <div class="p-3 bg-purple-50 rounded-lg">
                                <div class="text-sm text-gray-500">Last Visit</div>
                                <div class="text-lg font-bold text-purple-600">
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
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">Medical Information</h4>

                            @if($patient->blood_type)
                            <div class="mb-2">
                                <span class="text-sm font-medium text-gray-700">Blood Type:</span>
                                <span class="ml-2 text-sm text-gray-900">{{ $patient->blood_type }}</span>
                            </div>
                            @endif

                            @if($patient->allergies)
                            <div class="mb-2">
                                <span class="text-sm font-medium text-gray-700">Allergies:</span>
                                <div class="ml-2 text-sm text-red-600">{{ $patient->allergies }}</div>
                            </div>
                            @endif

                            @if($patient->chronic_conditions)
                            <div class="mb-2">
                                <span class="text-sm font-medium text-gray-700">Chronic Conditions:</span>
                                <div class="ml-2 text-sm text-orange-600">{{ $patient->chronic_conditions }}</div>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            @if($patient->emergency_contact_name)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Emergency Contact</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 bg-yellow-50 rounded-lg">
                            <div class="text-sm text-gray-500">Contact Name</div>
                            <div class="text-lg font-medium text-gray-900">{{ $patient->emergency_contact_name }}</div>
                        </div>

                        <div class="p-4 bg-yellow-50 rounded-lg">
                            <div class="text-sm text-gray-500">Phone Number</div>
                            <div class="text-lg font-medium text-gray-900">{{ $patient->emergency_contact_phone }}</div>
                        </div>

                        <div class="p-4 bg-yellow-50 rounded-lg">
                            <div class="text-sm text-gray-500">Relationship</div>
                            <div class="text-lg font-medium text-gray-900">{{ $patient->emergency_contact_relation }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Examinations -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Examinations</h3>

                    @if($patient->examinations->count() > 0)
                        <div class="space-y-4">
                            @foreach($patient->examinations->take(5) as $examination)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center">
                                            <span class="text-lg font-semibold text-gray-900">
                                                {{ $examination->examination_date->format('d F Y, H:i') }}
                                            </span>
                                            <span class="ml-3 px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $examination->status == 'completed' ? 'bg-green-100 text-green-800' :
                                                   ($examination->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                                {{ ucfirst($examination->status) }}
                                            </span>
                                        </div>
                                        <div class="mt-2">
                                            <span class="text-sm text-gray-600">Doctor:</span>
                                            <span class="ml-2 text-sm font-medium text-gray-900">
                                                {{ $examination->doctor->name }}
                                            </span>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-600">
                                            {{ Str::limit($examination->doctor_notes, 150) }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-right">
                                            @if($examination->prescription)
                                            <div class="text-sm font-medium text-green-600">
                                                Prescribed: {{ $examination->prescription->items->count() }} medicines
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                Total: {{ $examination->prescription->formatted_total_price }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @if($patient->examinations->count() > 5)
                        <div class="mt-6 text-center">
                            <a href="{{ route('doctor.examinations.index', ['patient_id' => $patient->id]) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                View all {{ $patient->examinations->count() }} examinations →
                            </a>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No examinations yet</h3>
                            <p class="mt-1 text-sm text-gray-500">This patient hasn't had any examinations.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Patient Timeline -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Patient Timeline</h3>

                    <div class="relative">
                        <!-- Timeline line -->
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                        <div class="space-y-8">
                            @foreach($patient->examinations->sortByDesc('examination_date') as $examination)
                            <div class="relative flex items-start">
                                <!-- Timeline dot -->
                                <div class="absolute left-3 mt-1.5 w-2 h-2 bg-blue-500 rounded-full"></div>

                                <div class="ml-10 flex-1">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900">
                                                Examination - {{ $examination->examination_date->format('d F Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500 mt-1">
                                                {{ $examination->examination_date->format('H:i') }} •
                                                Dr. {{ $examination->doctor->name }}
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm font-medium
                                                {{ $examination->status == 'completed' ? 'text-green-600' :
                                                   ($examination->status == 'pending' ? 'text-yellow-600' : 'text-blue-600') }}">
                                                {{ ucfirst($examination->status) }}
                                            </div>
                                            @if($examination->prescription)
                                            <div class="text-sm text-gray-500">
                                                Prescription: {{ $examination->prescription->status }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-3 text-sm text-gray-600">
                                        <div class="font-medium text-gray-900">Vital Signs:</div>
                                        <div class="mt-1 grid grid-cols-2 md:grid-cols-4 gap-2">
                                            @if($examination->height && $examination->weight)
                                            <div class="text-sm">
                                                <span class="text-gray-500">BMI:</span>
                                                <span class="ml-1 font-medium">{{ $examination->bmi }}</span>
                                            </div>
                                            @endif
                                            @if($examination->systolic && $examination->diastolic)
                                            <div class="text-sm">
                                                <span class="text-gray-500">BP:</span>
                                                <span class="ml-1 font-medium">{{ $examination->blood_pressure }}</span>
                                            </div>
                                            @endif
                                            @if($examination->heart_rate)
                                            <div class="text-sm">
                                                <span class="text-gray-500">HR:</span>
                                                <span class="ml-1 font-medium">{{ $examination->heart_rate }} bpm</span>
                                            </div>
                                            @endif
                                            @if($examination->temperature)
                                            <div class="text-sm">
                                                <span class="text-gray-500">Temp:</span>
                                                <span class="ml-1 font-medium">{{ $examination->temperature }}°C</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <!-- Patient Registration -->
                            <div class="relative flex items-start">
                                <div class="absolute left-3 mt-1.5 w-2 h-2 bg-green-500 rounded-full"></div>

                                <div class="ml-10">
                                    <div class="text-lg font-semibold text-gray-900">
                                        Patient Registered
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        {{ $patient->created_at->format('d F Y, H:i') }}
                                    </div>
                                    <div class="mt-3 text-sm text-gray-600">
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

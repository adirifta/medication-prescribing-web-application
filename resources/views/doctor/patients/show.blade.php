<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Patient Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('doctor.examinations.create', ['patient_id' => $patient->id]) }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    + New Examination
                </a>
                <a href="{{ route('doctor.patients.edit', $patient->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit
                </a>
                <a href="{{ route('doctor.patients.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Patient Summary -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Patient Info Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg lg:col-span-2">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex items-center mb-4 md:mb-0">
                                <div class="flex-shrink-0 h-20 w-20 bg-blue-100 rounded-full flex items-center justify-center text-2xl font-bold text-blue-600">
                                    {{ substr($patient->name, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-2xl font-bold text-gray-900">{{ $patient->name }}</h3>
                                    <div class="flex items-center mt-1">
                                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ strtoupper($patient->medical_record_number) }}
                                        </span>
                                        <span class="ml-3 text-sm text-gray-500">
                                            {{ $patient->gender == 'male' ? 'Male' : 'Female' }} • {{ $patient->age }} years
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <div class="text-sm text-gray-500">Registered</div>
                                <div class="text-lg font-semibold text-gray-900">
                                    {{ $patient->created_at->format('d M Y') }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $patient->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="text-sm text-gray-500">Phone Number</div>
                                <div class="text-lg font-medium text-gray-900">{{ $patient->phone }}</div>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="text-sm text-gray-500">Date of Birth</div>
                                <div class="text-lg font-medium text-gray-900">
                                    {{ $patient->date_of_birth->format('d F Y') }}
                                </div>
                            </div>
                            @if($patient->address)
                            <div class="md:col-span-2 p-4 bg-gray-50 rounded-lg">
                                <div class="text-sm text-gray-500">Address</div>
                                <div class="text-lg font-medium text-gray-900">{{ $patient->address }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Medical History</h3>

                        <div class="space-y-4">
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <div class="text-sm text-gray-500">Total Examinations</div>
                                <div class="text-2xl font-bold text-blue-600">{{ $patient->examinations->count() }}</div>
                            </div>

                            <div class="p-3 bg-green-50 rounded-lg">
                                <div class="text-sm text-gray-500">Last Visit</div>
                                <div class="text-lg font-bold text-green-600">
                                    @if($patient->examinations->count() > 0)
                                        {{ $patient->examinations->first()->examination_date->format('d M Y') }}
                                    @else
                                        Never
                                    @endif
                                </div>
                            </div>

                            <div class="p-3 bg-purple-50 rounded-lg">
                                <div class="text-sm text-gray-500">Prescriptions</div>
                                <div class="text-2xl font-bold text-purple-600">
                                    {{ $patient->examinations->where('prescription')->count() }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('doctor.examinations.index', ['patient_id' => $patient->id]) }}" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-center block">
                                View All Examinations
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Examinations -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Examinations</h3>
                        <a href="{{ route('doctor.examinations.create', ['patient_id' => $patient->id]) }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm rounded hover:bg-purple-700">
                            + New Examination
                        </a>
                    </div>

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
                                        <div class="mt-2 text-sm text-gray-600">
                                            {{ Str::limit($examination->doctor_notes, 150) }}
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('doctor.examinations.show', $examination->id) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                            View
                                        </a>
                                        @if($examination->prescription)
                                        <a href="{{ route('doctor.examinations.prescription', $examination->id) }}" class="text-green-600 hover:text-green-900 text-sm">
                                            Prescription
                                        </a>
                                        @endif
                                    </div>
                                </div>

                                @if($examination->prescription)
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Prescription Status:</span>
                                        <span class="font-medium
                                            {{ $examination->prescription->status == 'completed' ? 'text-green-600' :
                                               ($examination->prescription->status == 'waiting' ? 'text-yellow-600' : 'text-blue-600') }}">
                                            {{ ucfirst($examination->prescription->status) }}
                                        </span>
                                    </div>
                                </div>
                                @endif
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
                            <div class="mt-6">
                                <a href="{{ route('doctor.examinations.create', ['patient_id' => $patient->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Create First Examination
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Patient Timeline -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Medical Timeline</h3>

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
                                                {{ $examination->examination_date->format('d F Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500 mt-1">
                                                {{ $examination->examination_date->format('H:i') }} •
                                                Dr. {{ $examination->doctor->name }}
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <a href="{{ route('doctor.examinations.show', $examination->id) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                                View Details
                                            </a>
                                        </div>
                                    </div>

                                    <div class="mt-3 text-sm text-gray-600">
                                        <div class="font-medium text-gray-900">Diagnosis & Notes:</div>
                                        <p class="mt-1">{{ Str::limit($examination->doctor_notes, 200) }}</p>
                                    </div>

                                    @if($examination->prescription)
                                    <div class="mt-3 p-3 bg-green-50 rounded-lg">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <div class="font-medium text-green-800">Prescription</div>
                                                <div class="text-sm text-green-600">
                                                    {{ $examination->prescription->items->count() }} medicines prescribed
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-sm font-medium text-green-800">
                                                    {{ $examination->prescription->formatted_total_price }}
                                                </div>
                                                <div class="text-xs text-green-600">
                                                    {{ ucfirst($examination->prescription->status) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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
                                        Patient record created in the system.
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

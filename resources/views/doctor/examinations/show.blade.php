<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Examination Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('doctor.examinations.edit', $examination->id) }}" class="inline-flex items-center px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                    Edit
                </a>
                <a href="{{ route('doctor.examinations.index') }}" class="inline-flex items-center px-3 py-1 bg-gray-300 text-gray-700 text-sm rounded hover:bg-gray-400">
                    ← Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Patient Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-gray-900">{{ $examination->patient->name }}</h3>
                                <div class="text-sm text-gray-500">
                                    MRN: {{ $examination->patient->medical_record_number }} |
                                    {{ $examination->patient->gender == 'male' ? 'Male' : 'Female' }}, {{ $examination->patient->age }} years
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500">Examination Date</div>
                            <div class="text-lg font-semibold text-gray-900">{{ $examination->formatted_examination_date }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vital Signs -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Vital Signs</h4>

                        <div class="grid grid-cols-2 gap-4">
                            @if($examination->height)
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <div class="text-sm text-blue-700">Height</div>
                                <div class="text-lg font-medium text-gray-900">{{ $examination->height }} cm</div>
                            </div>
                            @endif

                            @if($examination->weight)
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <div class="text-sm text-blue-700">Weight</div>
                                <div class="text-lg font-medium text-gray-900">{{ $examination->weight }} kg</div>
                            </div>
                            @endif

                            @if($examination->bmi)
                            <div class="p-3 bg-green-50 rounded-lg">
                                <div class="text-sm text-green-700">BMI</div>
                                <div class="text-lg font-medium text-gray-900">{{ $examination->bmi }}</div>
                            </div>
                            @endif

                            @if($examination->blood_pressure)
                            <div class="p-3 bg-green-50 rounded-lg">
                                <div class="text-sm text-green-700">Blood Pressure</div>
                                <div class="text-lg font-medium text-gray-900">{{ $examination->blood_pressure }}</div>
                            </div>
                            @endif

                            @if($examination->heart_rate)
                            <div class="p-3 bg-purple-50 rounded-lg">
                                <div class="text-sm text-purple-700">Heart Rate</div>
                                <div class="text-lg font-medium text-gray-900">{{ $examination->heart_rate }} bpm</div>
                            </div>
                            @endif

                            @if($examination->respiration_rate)
                            <div class="p-3 bg-purple-50 rounded-lg">
                                <div class="text-sm text-purple-700">Respiration Rate</div>
                                <div class="text-lg font-medium text-gray-900">{{ $examination->respiration_rate }} /min</div>
                            </div>
                            @endif

                            @if($examination->temperature)
                            <div class="p-3 bg-yellow-50 rounded-lg">
                                <div class="text-sm text-yellow-700">Temperature</div>
                                <div class="text-lg font-medium text-gray-900">{{ $examination->temperature }} °C</div>
                            </div>
                            @endif
                        </div>

                        @if(!$examination->height && !$examination->weight && !$examination->blood_pressure)
                        <div class="text-center py-4 text-gray-500">
                            No vital signs recorded
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Doctor Notes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Doctor Notes</h4>
                        <div class="prose max-w-none">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                {{ $examination->doctor_notes }}
                            </div>
                        </div>

                        @if($examination->external_file_path)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <h5 class="text-sm font-medium text-gray-700 mb-2">Attached File</h5>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">External Examination File</div>
                                    <a href="{{ Storage::url($examination->external_file_path) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">
                                        View File
                                    </a>
                                </div>
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-semibold text-gray-900">Prescription Details</h4>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full
                            {{ $examination->prescription->status == 'completed' ? 'bg-green-100 text-green-800' :
                               ($examination->prescription->status == 'processed' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($examination->prescription->status) }}
                        </span>
                    </div>

                    @if($examination->prescription->notes)
                    <div class="mb-4">
                        <div class="text-sm font-medium text-gray-700">Prescription Notes</div>
                        <div class="mt-1 p-3 bg-gray-50 rounded-lg">{{ $examination->prescription->notes }}</div>
                    </div>
                    @endif

                    @if($examination->prescription->items->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Medicine
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quantity
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Unit Price
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Subtotal
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Instructions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($examination->prescription->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->medicine_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->quantity }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->formatted_unit_price }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->formatted_subtotal }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $item->instructions ?? '-' }}</div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                                        Total:
                                    </td>
                                    <td colspan="2" class="px-6 py-4 text-sm font-bold text-gray-900">
                                        {{ $examination->prescription->formatted_total_price }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4 text-gray-500">
                        No medicines prescribed
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="text-center py-4">
                        <svg class="h-12 w-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No prescription</h3>
                        <p class="mt-1 text-sm text-gray-500">No prescription has been created for this examination.</p>
                        <div class="mt-4">
                            <a href="{{ route('doctor.examinations.edit', $examination->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Add Prescription
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Status and Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-sm text-gray-500">Examination Status</div>
                            <div class="text-lg font-semibold text-gray-900">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full {{
                                    $examination->status == 'completed' ? 'bg-green-100 text-green-800' :
                                    ($examination->status == 'processed' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')
                                }}">
                                    {{ ucfirst($examination->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="flex space-x-3">
                            @if(!$examination->prescription || $examination->prescription->canBeEdited())
                            <a href="{{ route('doctor.examinations.edit', $examination->id) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Edit Examination
                            </a>
                            @endif
                            <a href="{{ route('doctor.examinations.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

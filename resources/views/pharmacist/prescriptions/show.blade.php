@extends('layouts.app')

@section('title', 'Page Title')

@section('header')
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Prescription Details') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Prescription #{{ str_pad($prescription->id, 6, '0', STR_PAD_LEFT) }}
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('pharmacist.prescriptions.index', ['status' => $prescription->status]) }}"
                   class="btn btn-secondary flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i>
                    Back to List
                </a>
                <a href="{{ route('pharmacist.prescriptions.print', $prescription->id) }}" target="_blank"
                   class="btn btn-primary flex items-center gap-2">
                    <i class="fas fa-print"></i>
                    Print
                </a>
            </div>
        </div>
    @endsection

@section('content')

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Prescription Header -->
            <div class="card mb-6">
                <div class="p-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div class="flex items-start gap-4">
                            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-file-prescription text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    Prescription #{{ str_pad($prescription->id, 6, '0', STR_PAD_LEFT) }}
                                </h3>
                                <div class="flex flex-wrap items-center gap-3 mt-2">
                                    @php
                                        $statusConfig = [
                                            'waiting' => ['color' => 'yellow', 'icon' => 'fa-clock'],
                                            'processed' => ['color' => 'blue', 'icon' => 'fa-capsules'],
                                            'completed' => ['color' => 'green', 'icon' => 'fa-check-circle'],
                                        ];
                                        $config = $statusConfig[$prescription->status] ?? ['color' => 'gray', 'icon' => 'fa-circle'];
                                    @endphp
                                    <span class="badge bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800 dark:bg-{{ $config['color'] }}-900 dark:text-{{ $config['color'] }}-200">
                                        <i class="fas {{ $config['icon'] }} mr-1"></i>
                                        {{ ucfirst($prescription->status) }}
                                    </span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        {{ $prescription->created_at->format('d F Y') }}
                                    </span>
                                    @if($prescription->processed_at)
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-history mr-1"></i>
                                        Processed: {{ $prescription->processed_at->format('d M Y') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 min-w-[200px]">
                            <div class="text-center">
                                <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Amount</div>
                                <div class="text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ $prescription->formatted_total_price }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                    {{ $prescription->items->count() }} items
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Patient and Doctor Info -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Patient Info -->
                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-user-injured text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Patient Information</h3>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $prescription->examination->patient->name }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        MRN: {{ $prescription->examination->patient->medical_record_number }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-phone text-green-600 dark:text-green-400"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $prescription->examination->patient->phone }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        Phone Number
                                    </div>
                                </div>
                            </div>

                            @if($prescription->examination->patient->address)
                            <div class="flex items-start p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center mr-3 mt-1">
                                    <i class="fas fa-home text-yellow-600 dark:text-yellow-400"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Address</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        {{ $prescription->examination->patient->address }}
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Doctor and Examination Info -->
                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-user-md text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Doctor & Examination</h3>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-stethoscope text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        Dr. {{ $prescription->doctor->name }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        Attending Doctor
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-calendar-check text-green-600 dark:text-green-400"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $prescription->examination->formatted_examination_date }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        Examination Date
                                    </div>
                                </div>
                            </div>

                            @if($prescription->pharmacist)
                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-prescription-bottle-alt text-purple-600 dark:text-purple-400"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $prescription->pharmacist->name }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        Processing Pharmacist
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prescription Notes -->
            @if($prescription->notes)
            <div class="card mb-6">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-notes-medical text-yellow-600 dark:text-yellow-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Doctor Notes</h3>
                    </div>
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg border border-yellow-200 dark:border-yellow-800">
                        <p class="text-gray-700 dark:text-gray-300">{{ $prescription->notes }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Medicine List -->
            <div class="card mb-6">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-pills text-green-600 dark:text-green-400"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Medicine List</h3>
                        </div>
                        <div class="badge badge-primary">
                            <i class="fas fa-capsules mr-1"></i>
                            {{ $prescription->items->count() }} items
                        </div>
                    </div>

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
                                @foreach($prescription->items as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                    <td class="px-4 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                                                <i class="fas fa-pill text-blue-600 dark:text-blue-400 text-xs"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $item->medicine_name }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    ID: {{ $item->medicine_id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $item->quantity }}</div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $item->formatted_unit_price }}</div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $item->formatted_subtotal }}</div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ $item->instructions ?? 'Take as directed' }}</div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-right text-sm font-semibold text-gray-900 dark:text-white">
                                        Total Amount:
                                    </td>
                                    <td colspan="2" class="px-4 py-4">
                                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                            {{ $prescription->formatted_total_price }}
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div>
                            <div class="flex items-center mb-2">
                                @if($prescription->status == 'waiting')
                                <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-yellow-600 dark:text-yellow-400">Waiting to be processed</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Created: {{ $prescription->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                @elseif($prescription->status == 'processed')
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-capsules text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-blue-600 dark:text-blue-400">Processed - Ready for completion</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Processed: {{ $prescription->processed_at->diffForHumans() }}
                                    </div>
                                </div>
                                @else
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-green-600 dark:text-green-400">Prescription Completed</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Completed successfully
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('pharmacist.prescriptions.export', $prescription->id) }}"
                               class="btn btn-outline flex items-center gap-2 px-6">
                                <i class="fas fa-file-pdf"></i>
                                Download PDF
                            </a>

                            @if($prescription->status == 'waiting')
                            <form action="{{ route('pharmacist.prescriptions.process', $prescription->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary flex items-center gap-2 px-6">
                                    <i class="fas fa-play-circle"></i>
                                    Process Prescription
                                </button>
                            </form>
                            @elseif($prescription->status == 'processed')
                            <form action="{{ route('pharmacist.prescriptions.complete', $prescription->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success flex items-center gap-2 px-6">
                                    <i class="fas fa-check-circle"></i>
                                    Mark as Completed
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

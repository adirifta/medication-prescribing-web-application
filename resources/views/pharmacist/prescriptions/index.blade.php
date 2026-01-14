@extends('layouts.app')

@section('title', 'Page Title')

@section('header')
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Prescriptions Management') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Manage patient prescriptions and pharmacy operations
                </p>
            </div>
            <a href="{{ route('pharmacist.dashboard') }}" class="btn btn-secondary flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Back to Dashboard
            </a>
        </div>
    @endsection

@section('content')

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Status Tabs -->
            <div class="card mb-6">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Prescription Status</h3>
                        @php
                            $waitingCount = \App\Models\Prescription::where('status', 'waiting')->count();
                            $processedCount = \App\Models\Prescription::where('status', 'processed')->count();
                            $completedCount = \App\Models\Prescription::where('status', 'completed')->count();
                        @endphp
                        <div class="flex items-center space-x-4 text-sm">
                            <span class="inline-flex items-center">
                                <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                Waiting: {{ $waitingCount }}
                            </span>
                            <span class="inline-flex items-center">
                                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                Processed: {{ $processedCount }}
                            </span>
                            <span class="inline-flex items-center">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                Completed: {{ $completedCount }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <a href="{{ route('pharmacist.prescriptions.index', ['status' => 'waiting']) }}"
                           class="flex items-center p-4 rounded-xl border-2 {{ $status == 'waiting' ? 'border-yellow-500 bg-yellow-50 dark:bg-yellow-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-yellow-300' }} transition-colors">
                            <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-800 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900 dark:text-white">Waiting</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $waitingCount }} prescriptions
                                </div>
                            </div>
                            @if($waitingCount > 0)
                            <span class="badge badge-warning">{{ $waitingCount }}</span>
                            @endif
                        </a>

                        <a href="{{ route('pharmacist.prescriptions.index', ['status' => 'processed']) }}"
                           class="flex items-center p-4 rounded-xl border-2 {{ $status == 'processed' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-blue-300' }} transition-colors">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-800 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-capsules text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900 dark:text-white">Processed</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $processedCount }} prescriptions
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('pharmacist.prescriptions.index', ['status' => 'completed']) }}"
                           class="flex items-center p-4 rounded-xl border-2 {{ $status == 'completed' ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-green-300' }} transition-colors">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-800 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900 dark:text-white">Completed</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $completedCount }} prescriptions
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Prescriptions List -->
            <div class="card">
                <div class="p-6">
                    @if($prescriptions->count() > 0)
                        <div class="space-y-6">
                            @foreach($prescriptions as $prescription)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-6 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                                    <!-- Left Section: Patient & Doctor Info -->
                                    <div class="flex-1">
                                        <div class="flex items-start gap-4">
                                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                                                <i class="fas fa-file-prescription text-blue-600 dark:text-blue-400 text-xl"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                                        Prescription #{{ str_pad($prescription->id, 6, '0', STR_PAD_LEFT) }}
                                                    </h3>
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
                                                </div>

                                                <!-- Patient & Doctor Info -->
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div class="flex items-center">
                                                        <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mr-3">
                                                            <i class="fas fa-user-injured text-purple-600 dark:text-purple-400 text-sm"></i>
                                                        </div>
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                                {{ $prescription->examination->patient->name }}
                                                            </div>
                                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                                {{ $prescription->examination->patient->medical_record_number }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center">
                                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mr-3">
                                                            <i class="fas fa-user-md text-blue-600 dark:text-blue-400 text-sm"></i>
                                                        </div>
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                                Dr. {{ $prescription->doctor->name }}
                                                            </div>
                                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                                {{ $prescription->created_at->format('d M Y') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Medicine Preview -->
                                                @if($prescription->items->count() > 0)
                                                <div class="mt-4">
                                                    <div class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                                        <i class="fas fa-pills mr-2"></i>
                                                        Medicines ({{ $prescription->items->count() }})
                                                    </div>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach($prescription->items->take(3) as $item)
                                                        <span class="badge bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                            {{ $item->medicine_name }} ({{ $item->quantity }})
                                                        </span>
                                                        @endforeach
                                                        @if($prescription->items->count() > 3)
                                                        <span class="badge bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                            +{{ $prescription->items->count() - 3 }} more
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Section: Price & Actions -->
                                    <div class="lg:w-1/3">
                                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                                            <div class="flex justify-between items-center mb-3">
                                                <div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">Total Price</div>
                                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                                        {{ $prescription->formatted_total_price }}
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">Items</div>
                                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                                        {{ $prescription->items->count() }}
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Actions -->
                                            <div class="flex flex-wrap gap-2">
                                                <a href="{{ route('pharmacist.prescriptions.show', $prescription->id) }}"
                                                   class="btn btn-outline flex-1 justify-center py-2 text-sm">
                                                    <i class="fas fa-eye mr-2"></i>
                                                    View
                                                </a>

                                                @if($prescription->status == 'waiting')
                                                <form action="{{ route('pharmacist.prescriptions.process', $prescription->id) }}" method="POST" class="flex-1">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary w-full py-2 text-sm">
                                                        <i class="fas fa-play-circle mr-2"></i>
                                                        Process
                                                    </button>
                                                </form>
                                                @elseif($prescription->status == 'processed')
                                                <form action="{{ route('pharmacist.prescriptions.complete', $prescription->id) }}" method="POST" class="flex-1">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success w-full py-2 text-sm">
                                                        <i class="fas fa-check-circle mr-2"></i>
                                                        Complete
                                                    </button>
                                                </form>
                                                @endif

                                                <a href="{{ route('pharmacist.prescriptions.export', $prescription->id) }}"
                                                   class="btn btn-secondary flex-1 justify-center py-2 text-sm">
                                                    <i class="fas fa-file-pdf mr-2"></i>
                                                    PDF
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Timeline Info -->
                                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-alt mr-2"></i>
                                            Created: {{ $prescription->created_at->format('d M Y, H:i') }}
                                        </div>
                                        @if($prescription->status != 'waiting')
                                        <div class="flex items-center">
                                            <i class="fas fa-history mr-2"></i>
                                            @if($prescription->processed_at)
                                            Processed: {{ $prescription->processed_at->format('d M Y, H:i') }}
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $prescriptions->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                @if($status == 'waiting')
                                <i class="fas fa-clock text-gray-400 dark:text-gray-600 text-3xl"></i>
                                @elseif($status == 'processed')
                                <i class="fas fa-capsules text-gray-400 dark:text-gray-600 text-3xl"></i>
                                @else
                                <i class="fas fa-check-circle text-gray-400 dark:text-gray-600 text-3xl"></i>
                                @endif
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                @if($status == 'waiting')
                                No waiting prescriptions
                                @elseif($status == 'processed')
                                No processed prescriptions
                                @else
                                No completed prescriptions
                                @endif
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                                @if($status == 'waiting')
                                All prescriptions have been processed. Check back later for new prescriptions from doctors.
                                @else
                                No prescriptions found in this status. Try checking other status tabs.
                                @endif
                            </p>
                            <div class="flex flex-wrap justify-center gap-3">
                                @if($status != 'waiting')
                                <a href="{{ route('pharmacist.prescriptions.index', ['status' => 'waiting']) }}"
                                   class="btn btn-primary inline-flex items-center gap-2">
                                    <i class="fas fa-clock"></i>
                                    View Waiting Prescriptions
                                </a>
                                @endif
                                <a href="{{ route('pharmacist.dashboard') }}"
                                   class="btn btn-outline inline-flex items-center gap-2">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Go to Dashboard
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

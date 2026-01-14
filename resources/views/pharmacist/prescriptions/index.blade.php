{{-- resources/views/pharmacist/prescriptions/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Prescriptions') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Status Tabs -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="px-4 py-6 sm:px-6">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8">
                            <a href="{{ route('pharmacist.prescriptions.index', ['status' => 'waiting']) }}"
                               class="{{ $status == 'waiting' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Waiting
                                @php
                                    $waitingCount = \App\Models\Prescription::where('status', 'waiting')->count();
                                @endphp
                                @if($waitingCount > 0)
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    {{ $waitingCount }}
                                </span>
                                @endif
                            </a>
                            <a href="{{ route('pharmacist.prescriptions.index', ['status' => 'processed']) }}"
                               class="{{ $status == 'processed' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Processed
                            </a>
                            <a href="{{ route('pharmacist.prescriptions.index', ['status' => 'completed']) }}"
                               class="{{ $status == 'completed' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Completed
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Prescriptions List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($prescriptions->count() > 0)
                    <div class="space-y-6">
                        @foreach($prescriptions as $prescription)
                        <div class="border border-gray-200 rounded-lg p-6 hover:bg-gray-50 transition duration-150">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="mb-4 md:mb-0">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-medium text-gray-900">
                                                Prescription #{{ str_pad($prescription->id, 6, '0', STR_PAD_LEFT) }}
                                            </h3>
                                            <div class="mt-1 flex items-center space-x-4">
                                                <div class="flex items-center text-sm text-gray-500">
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    {{ $prescription->examination->patient->name }}
                                                </div>
                                                <div class="flex items-center text-sm text-gray-500">
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                    </svg>
                                                    {{ $prescription->doctor->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <div class="text-right">
                                        <div class="text-lg font-bold text-gray-900">
                                            {{ $prescription->formatted_total_price }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $prescription->items->count() }} medicines
                                        </div>
                                    </div>

                                    <span class="px-3 py-1 text-sm font-semibold rounded-full
                                        {{ $prescription->status == 'completed' ? 'bg-green-100 text-green-800' :
                                           ($prescription->status == 'processed' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($prescription->status) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Medicine List Preview -->
                            @if($prescription->items->count() > 0)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="text-sm font-medium text-gray-700 mb-2">Medicines:</div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($prescription->items->take(3) as $item)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $item->medicine_name }} ({{ $item->quantity }})
                                    </span>
                                    @endforeach
                                    @if($prescription->items->count() > 3)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        +{{ $prescription->items->count() - 3 }} more
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Prescription Notes -->
                            @if($prescription->notes)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="text-sm font-medium text-gray-700 mb-2">Doctor Notes:</div>
                                <div class="text-sm text-gray-600">{{ Str::limit($prescription->notes, 150) }}</div>
                            </div>
                            @endif

                            <!-- Actions -->
                            <div class="mt-6 pt-6 border-t border-gray-200 flex justify-between items-center">
                                <div class="text-sm text-gray-500">
                                    @if($prescription->status == 'waiting')
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Created {{ $prescription->created_at->diffForHumans() }}
                                    </div>
                                    @elseif($prescription->status == 'processed')
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-blue-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Processed {{ $prescription->processed_at->diffForHumans() }}
                                    </div>
                                    @else
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-green-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        Completed
                                    </div>
                                    @endif
                                </div>

                                <div class="flex space-x-3">
                                    <a href="{{ route('pharmacist.prescriptions.show', $prescription->id) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        View Details
                                    </a>

                                    @if($prescription->status == 'waiting')
                                    <form action="{{ route('pharmacist.prescriptions.process', $prescription->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Process
                                        </button>
                                    </form>
                                    @elseif($prescription->status == 'processed')
                                    <form action="{{ route('pharmacist.prescriptions.complete', $prescription->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Complete
                                        </button>
                                    </form>
                                    @endif

                                    <a href="{{ route('pharmacist.prescriptions.export', $prescription->id) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $prescriptions->links() }}
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg class="h-12 w-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($status == 'waiting')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            @elseif($status == 'processed')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            @endif
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">
                            @if($status == 'waiting')
                            No waiting prescriptions
                            @elseif($status == 'processed')
                            No processed prescriptions
                            @else
                            No completed prescriptions
                            @endif
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @if($status == 'waiting')
                            All prescriptions have been processed.
                            @else
                            Get started by checking other status tabs.
                            @endif
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('pharmacist.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Go to Dashboard
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

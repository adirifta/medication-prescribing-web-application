<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('My Examinations') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Manage patient examinations and prescriptions
                </p>
            </div>
            <div class="flex items-center space-x-4">
                <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                    <i class="fas fa-moon text-gray-600 dark:text-yellow-400" id="theme-icon"></i>
                </button>
                <a href="{{ route('doctor.examinations.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle mr-2"></i>
                    New Examination
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="card mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Filters</h3>
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Status Filter -->
                        <div>
                            <label class="form-label">Status</label>
                            <select name="status" class="form-input">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Processed</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        <!-- Date From -->
                        <div>
                            <label class="form-label">Date From</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-input">
                        </div>

                        <!-- Date To -->
                        <div>
                            <label class="form-label">Date To</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-input">
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-end space-x-2">
                            <button type="submit" class="btn btn-primary flex-1">
                                <i class="fas fa-filter mr-2"></i>
                                Filter
                            </button>
                            <a href="{{ route('doctor.examinations.index') }}" class="btn btn-secondary">
                                <i class="fas fa-redo mr-2"></i>
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Examinations Table -->
            <div class="card">
                <div class="p-6">
                    @if($examinations->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Patient
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Vital Signs
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Prescription
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($examinations as $examination)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                    <!-- Patient Column -->
                                    <td class="px-4 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-white text-sm"></i>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $examination->patient->name }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    MRN: {{ $examination->patient->medical_record_number }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Date Column -->
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $examination->created_at->format('d M Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $examination->created_at->format('H:i') }}
                                        </div>
                                    </td>

                                    <!-- Vital Signs Column -->
                                    <td class="px-4 py-4">
                                        @if($examination->height || $examination->weight || $examination->blood_pressure)
                                        <div class="space-y-1">
                                            @if($examination->height && $examination->weight)
                                            <div class="flex items-center text-sm">
                                                <i class="fas fa-weight-scale mr-2 text-blue-500"></i>
                                                <span class="font-medium">{{ $examination->bmi }}</span>
                                                <span class="text-gray-500 dark:text-gray-400 ml-1">BMI</span>
                                            </div>
                                            @endif
                                            @if($examination->blood_pressure)
                                            <div class="flex items-center text-sm">
                                                <i class="fas fa-heart-pulse mr-2 text-red-500"></i>
                                                <span class="font-medium">{{ $examination->blood_pressure }}</span>
                                                <span class="text-gray-500 dark:text-gray-400 ml-1">BP</span>
                                            </div>
                                            @endif
                                        </div>
                                        @else
                                        <div class="text-sm text-gray-500 dark:text-gray-400">No data</div>
                                        @endif
                                    </td>

                                    <!-- Prescription Column -->
                                    <td class="px-4 py-4">
                                        @if($examination->prescription)
                                        <div class="text-sm">
                                            <div class="font-medium {{ $examination->prescription->status == 'waiting' ? 'text-yellow-600 dark:text-yellow-400' : 'text-green-600 dark:text-green-400' }}">
                                                <i class="fas fa-prescription-bottle-alt mr-1"></i>
                                                {{ ucfirst($examination->prescription->status) }}
                                            </div>
                                            @if($examination->prescription->total_price > 0)
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $examination->prescription->formatted_total_price }}
                                            </div>
                                            @endif
                                        </div>
                                        @else
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            No prescription
                                        </div>
                                        @endif
                                    </td>

                                    <!-- Status Column -->
                                    <td class="px-4 py-4">
                                        @php
                                            $statusConfig = [
                                                'pending' => [
                                                    'color' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                    'icon' => 'fas fa-clock'
                                                ],
                                                'processed' => [
                                                    'color' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                                    'icon' => 'fas fa-spinner'
                                                ],
                                                'completed' => [
                                                    'color' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                                    'icon' => 'fas fa-check-circle'
                                                ],
                                            ];
                                            $config = $statusConfig[$examination->status] ?? ['color' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300', 'icon' => 'fas fa-circle'];
                                        @endphp
                                        <span class="badge {{ $config['color'] }} flex items-center">
                                            <i class="{{ $config['icon'] }} mr-1 text-xs"></i>
                                            {{ ucfirst($examination->status) }}
                                        </span>
                                    </td>

                                    <!-- Actions Column -->
                                    <td class="px-4 py-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('doctor.examinations.show', $examination->id) }}"
                                               class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300"
                                               title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(!$examination->prescription || $examination->prescription->canBeEdited())
                                            <a href="{{ route('doctor.examinations.edit', $examination->id) }}"
                                               class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endif
                                            @if(!$examination->prescription && $examination->status === 'pending')
                                            <a href="{{ route('doctor.examinations.prescription', $examination->id) }}"
                                               class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300"
                                               title="Add Prescription">
                                                <i class="fas fa-prescription-bottle-alt"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $examinations->links() }}
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gradient-to-r from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-clipboard-list text-blue-500 dark:text-blue-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No examinations found</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                            You haven't created any examinations yet. Start by creating your first patient examination.
                        </p>
                        <div class="flex justify-center space-x-4">
                            <a href="{{ route('doctor.examinations.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle mr-2"></i>
                                Create Examination
                            </a>
                            <a href="{{ route('doctor.patients.create') }}" class="btn btn-secondary">
                                <i class="fas fa-user-plus mr-2"></i>
                                Add Patient
                            </a>
                        </div>
                    </div>
                    @endif
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
</x-app-layout>

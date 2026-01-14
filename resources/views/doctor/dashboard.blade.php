<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Doctor Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Selamat datang, Dr. {{ auth()->user()->name }}
                </p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ now()->format('l, d F Y') }}</div>
                    <div class="text-xs text-gray-400 dark:text-gray-500">{{ now()->format('H:i') }} WIB</div>
                </div>
                <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                    <i class="fas fa-moon text-gray-600 dark:text-yellow-400" id="theme-icon"></i>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Today's Examinations -->
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-calendar-check text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Today's Examinations</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['today_examinations'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                                    {{ $stats['weekly_growth'] ?? 0 }}% this week
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Patients -->
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-user-injured text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Patients</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total_patients'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Active: {{ $stats['active_patients'] ?? 0 }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Prescriptions -->
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-clock text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending Prescriptions</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['pending_prescriptions'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Waiting for pharmacist
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completed Prescriptions -->
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-check-circle text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Completed</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['completed_prescriptions'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    This month
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Monthly Examinations Chart -->
                <div class="card">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Monthly Examinations</h3>
                            <div class="flex space-x-2">
                                <button class="text-xs px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 rounded-full">
                                    This Year
                                </button>
                                <button class="text-xs px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-full">
                                    Last Year
                                </button>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="examinationsChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Quick Actions</h3>
                        <div class="space-y-4">
                            <!-- New Examination -->
                            <a href="{{ route('doctor.examinations.create') }}"
                               class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-900/30 dark:hover:to-blue-800/30 transition-all duration-300 group">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-plus-circle text-white text-lg"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                        New Examination
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Create new patient examination
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-500 dark:group-hover:text-blue-400"></i>
                            </a>

                            <!-- Register New Patient -->
                            <a href="{{ route('doctor.patients.create') }}"
                               class="flex items-center p-4 bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg hover:from-green-100 hover:to-green-200 dark:hover:from-green-900/30 dark:hover:to-green-800/30 transition-all duration-300 group">
                                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user-plus text-white text-lg"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="font-medium text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400">
                                        Register New Patient
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Add new patient to system
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-green-500 dark:group-hover:text-green-400"></i>
                            </a>

                            <!-- View All Examinations -->
                            <a href="{{ route('doctor.examinations.index') }}"
                               class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg hover:from-purple-100 hover:to-purple-200 dark:hover:from-purple-900/30 dark:hover:to-purple-800/30 transition-all duration-300 group">
                                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-clipboard-list text-white text-lg"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="font-medium text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400">
                                        View All Examinations
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Browse examination history
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-purple-500 dark:group-hover:text-purple-400"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Examinations -->
            <div class="card">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Examinations</h3>
                        <a href="{{ route('doctor.examinations.index') }}" class="btn btn-outline text-sm px-4 py-2">
                            <i class="fas fa-eye mr-2"></i>
                            View All
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Patient
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Date & Time
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
                                @forelse ($recentExaminations as $examination)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
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
                                                        MR: {{ $examination->patient->medical_record_number }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                {{ $examination->formatted_examination_date }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $examination->created_at->format('H:i') }}
                                            </div>
                                        </td>
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
                                        <td class="px-4 py-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('doctor.examinations.edit', $examination->id) }}"
                                                   class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium">
                                                    <i class="fas fa-edit mr-1"></i> Edit
                                                </a>
                                                <a href="{{ route('doctor.examinations.show', $examination->id) }}"
                                                   class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 text-sm font-medium">
                                                    <i class="fas fa-eye mr-1"></i> View
                                                </a>
                                                @if($examination->status === 'pending')
                                                    <a href="{{ route('doctor.examinations.prescription', $examination->id) }}"
                                                       class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 text-sm font-medium">
                                                        <i class="fas fa-prescription-bottle-alt mr-1"></i> Prescribe
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center">
                                            <div class="text-gray-500 dark:text-gray-400">
                                                <i class="fas fa-clipboard-list text-3xl mb-2"></i>
                                                <p class="text-sm">No examinations found</p>
                                                <a href="{{ route('doctor.examinations.create') }}" class="btn btn-primary mt-4 text-sm px-4 py-2">
                                                    <i class="fas fa-plus mr-2"></i>
                                                    Create First Examination
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

                    // Update chart if exists
                    if (window.examinationsChart) {
                        window.examinationsChart.destroy();
                        initExaminationsChart();
                    }
                });
            }

            // Examinations Chart
            function initExaminationsChart() {
                const ctx = document.getElementById('examinationsChart');
                if (!ctx) return;

                const months = @json($monthlyData->pluck('month'));
                const counts = @json($monthlyData->pluck('count'));

                const isDark = document.documentElement.classList.contains('dark');
                const textColor = isDark ? '#d1d5db' : '#374151';
                const gridColor = isDark ? '#374151' : '#e5e7eb';

                window.examinationsChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: months.map(month => {
                            const [year, monthNum] = month.split('-');
                            return new Date(year, monthNum - 1).toLocaleDateString('en-US', {
                                month: 'short',
                                year: 'numeric'
                            });
                        }),
                        datasets: [{
                            label: 'Examinations',
                            data: counts,
                            borderColor: '#3b82f6',
                            backgroundColor: isDark ? 'rgba(59, 130, 246, 0.1)' : 'rgba(59, 130, 246, 0.05)',
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#3b82f6',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: isDark ? '#1f2937' : '#ffffff',
                                titleColor: isDark ? '#f3f4f6' : '#111827',
                                bodyColor: isDark ? '#d1d5db' : '#374151',
                                borderColor: isDark ? '#374151' : '#e5e7eb',
                                borderWidth: 1
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    color: gridColor,
                                    borderColor: gridColor,
                                },
                                ticks: {
                                    color: textColor,
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: gridColor,
                                    borderColor: gridColor,
                                },
                                ticks: {
                                    color: textColor,
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }

            // Initialize chart
            initExaminationsChart();
        });
    </script>
    @endpush
</x-app-layout>

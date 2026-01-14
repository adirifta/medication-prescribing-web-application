{{-- resources/views/pharmacist/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Pharmacist Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Manage prescriptions and pharmacy operations
                </p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden md:block">
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ now()->format('l, d F Y') }}</div>
                    <div class="text-xs text-gray-400 dark:text-gray-500">{{ now()->format('H:i') }} WIB</div>
                </div>
                <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                    <i class="fas fa-moon text-gray-600 dark:text-yellow-400" id="theme-icon"></i>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Waiting Prescriptions -->
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-600 dark:text-yellow-400 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Waiting Prescriptions</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                                    {{ $stats['waiting_prescriptions'] }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Needs processing
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Today Processed -->
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                                <i class="fas fa-capsules text-blue-600 dark:text-blue-400 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Today Processed</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                                    {{ $stats['today_processed'] }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Prescriptions today
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Processed -->
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Processed</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                                    {{ $stats['total_processed'] }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    All time
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                                <i class="fas fa-money-bill-wave text-purple-600 dark:text-purple-400 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Revenue</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                                    IDR {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    All time
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Daily Revenue Chart -->
                <div class="card">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daily Revenue (This Month)</h3>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Total: IDR {{ number_format($dailyRevenue->sum('revenue'), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $stats['waiting_prescriptions'] }} waiting
                            </span>
                        </div>
                        <div class="space-y-4">
                            <a href="{{ route('pharmacist.prescriptions.index', ['status' => 'waiting']) }}"
                               class="flex items-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-900/30 transition-colors group">
                                <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-800 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900 dark:text-white">Process Waiting Prescriptions</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $stats['waiting_prescriptions'] }} prescriptions waiting for processing
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-yellow-600 dark:group-hover:text-yellow-400"></i>
                            </a>

                            <a href="{{ route('pharmacist.prescriptions.index', ['status' => 'processed']) }}"
                               class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors group">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-800 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-capsules text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900 dark:text-white">View Processed Prescriptions</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Check prescriptions being processed
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400"></i>
                            </a>

                            <a href="{{ route('pharmacist.prescriptions.index', ['status' => 'completed']) }}"
                               class="flex items-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors group">
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-800 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900 dark:text-white">View Completed Prescriptions</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Browse completed prescriptions archive
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-green-600 dark:group-hover:text-green-400"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Processed Prescriptions -->
            <div class="card">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recently Processed Prescriptions</h3>
                        <a href="{{ route('pharmacist.prescriptions.index') }}" class="btn btn-outline text-sm px-4 py-2">
                            <i class="fas fa-eye mr-2"></i>
                            View All
                        </a>
                    </div>

                    @if($recentPrescriptions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Prescription
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Patient
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Total
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
                                    @foreach($recentPrescriptions as $prescription)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                        <td class="px-4 py-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                #{{ str_pad($prescription->id, 6, '0', STR_PAD_LEFT) }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                <i class="fas fa-calendar mr-1"></i>
                                                {{ $prescription->formatted_processed_at }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mr-3">
                                                    <span class="text-blue-600 dark:text-blue-400 text-xs font-semibold">
                                                        {{ substr($prescription->examination->patient->name, 0, 1) }}
                                                    </span>
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
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-sm font-bold text-gray-900 dark:text-white">
                                                {{ $prescription->formatted_total_price }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            @php
                                                $statusConfig = [
                                                    'waiting' => ['color' => 'yellow', 'icon' => 'fa-clock'],
                                                    'processed' => ['color' => 'blue', 'icon' => 'fa-capsules'],
                                                    'completed' => ['color' => 'green', 'icon' => 'fa-check-circle'],
                                                ];
                                                $config = $statusConfig[$prescription->status] ?? ['color' => 'gray', 'icon' => 'fa-circle'];
                                            @endphp
                                            <span class="badge bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800 dark:bg-{{ $config['color'] }}-900 dark:text-{{ $config['color'] }}-200 inline-flex items-center">
                                                <i class="fas {{ $config['icon'] }} mr-1 text-xs"></i>
                                                {{ ucfirst($prescription->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex items-center space-x-3">
                                                <a href="{{ route('pharmacist.prescriptions.show', $prescription->id) }}"
                                                   class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 p-2 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20"
                                                   title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($prescription->status === 'waiting')
                                                <a href="{{ route('pharmacist.prescriptions.process', $prescription->id) }}"
                                                   class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 p-2 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20"
                                                   title="Process Prescription">
                                                    <i class="fas fa-play-circle"></i>
                                                </a>
                                                @endif
                                                @if($prescription->status === 'processed')
                                                <a href="{{ route('pharmacist.prescriptions.complete', $prescription->id) }}"
                                                   class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 p-2 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20"
                                                   title="Complete Prescription">
                                                    <i class="fas fa-check-circle"></i>
                                                </a>
                                                @endif
                                                <a href="{{ route('pharmacist.prescriptions.export', $prescription->id) }}"
                                                   class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 p-2 rounded-lg hover:bg-purple-50 dark:hover:bg-purple-900/20"
                                                   title="Export PDF">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                <i class="fas fa-prescription-bottle-alt text-gray-400 dark:text-gray-600 text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No prescriptions processed yet</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                                Start by processing waiting prescriptions from doctors.
                            </p>
                            <a href="{{ route('pharmacist.prescriptions.index', ['status' => 'waiting']) }}"
                               class="btn btn-primary inline-flex items-center gap-2">
                                <i class="fas fa-clock"></i>
                                View Waiting Prescriptions
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Monthly Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Monthly Revenue</h4>
                            <i class="fas fa-chart-line text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                            IDR {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                            {{ now()->format('F Y') }}
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Average Processing Time</h4>
                            <i class="fas fa-stopwatch text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                            0.0 mins
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                            Per prescription
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Completion Rate</h4>
                            <i class="fas fa-percentage text-green-600 dark:text-green-400"></i>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                            0.0%
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                            This month
                        </div>
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

                    // Update chart if it exists
                    if (window.revenueChart) {
                        window.revenueChart.destroy();
                        initRevenueChart();
                    }
                });
            }

            // Revenue Chart
            function initRevenueChart() {
                const revenueCtx = document.getElementById('revenueChart');
                if (!revenueCtx) return;

                const dates = @json($dailyRevenue->pluck('date'));
                const revenues = @json($dailyRevenue->pluck('revenue'));

                const isDark = document.documentElement.classList.contains('dark');
                const textColor = isDark ? '#d1d5db' : '#374151';
                const gridColor = isDark ? '#374151' : '#e5e7eb';

                window.revenueChart = new Chart(revenueCtx, {
                    type: 'bar',
                    data: {
                        labels: dates.map(date => {
                            const d = new Date(date);
                            return `${d.getDate()} ${d.toLocaleDateString('en-US', { month: 'short' })}`;
                        }),
                        datasets: [{
                            label: 'Revenue (IDR)',
                            data: revenues,
                            backgroundColor: isDark ? 'rgba(139, 92, 246, 0.5)' : 'rgba(139, 92, 246, 0.3)',
                            borderColor: 'rgb(139, 92, 246)',
                            borderWidth: 1,
                            borderRadius: 4,
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
                                borderWidth: 1,
                                callbacks: {
                                    label: function(context) {
                                        return 'Revenue: IDR ' + context.parsed.y.toLocaleString('id-ID');
                                    }
                                }
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
                                    maxRotation: 45,
                                    minRotation: 45
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
                                    callback: function(value) {
                                        if (value >= 1000000) {
                                            return 'IDR ' + (value / 1000000).toFixed(1) + 'M';
                                        } else if (value >= 1000) {
                                            return 'IDR ' + (value / 1000).toFixed(0) + 'K';
                                        }
                                        return 'IDR ' + value;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Initialize chart
            initRevenueChart();
        });
    </script>
    @endpush
</x-app-layout>

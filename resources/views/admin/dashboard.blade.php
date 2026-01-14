{{-- resources/views/admin/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Admin Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Sistem Manajemen Peresepan Obat
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
                <!-- Total Users Card -->
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 gradient-primary rounded-xl flex items-center justify-center">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total_users'] }}</p>
                                <div class="flex space-x-3 mt-2">
                                    <span class="badge badge-primary">
                                        <i class="fas fa-user-md mr-1"></i>
                                        {{ $userStats['doctor'] ?? 0 }} Doctors
                                    </span>
                                    <span class="badge badge-medical">
                                        <i class="fas fa-prescription-bottle-alt mr-1"></i>
                                        {{ $userStats['pharmacist'] ?? 0 }} Pharmacists
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Patients Card -->
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 gradient-medical rounded-xl flex items-center justify-center">
                                <i class="fas fa-user-injured text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Patients</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total_patients'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Active this month: {{ $stats['active_patients'] ?? 0 }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Today's Revenue Card -->
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-money-bill-wave text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Today's Revenue</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                                    IDR {{ number_format($stats['revenue_today'], 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Weekly: IDR {{ number_format($stats['revenue_week'], 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Prescriptions Card -->
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-file-prescription text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Prescriptions</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total_prescriptions'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $stats['total_examinations'] }} Examinations
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Revenue Chart -->
                <div class="card">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Monthly Revenue</h3>
                            <div class="flex space-x-2">
                                <button class="text-xs px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 rounded-full">
                                    This Year
                                </button>
                                <button class="text-xs px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-full">
                                    Compare
                                </button>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- User Distribution Chart -->
                <div class="card">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">User Distribution</h3>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $stats['total_users'] }} Total Users
                            </span>
                        </div>
                        <div class="h-64">
                            <canvas id="userDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Data Tables -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Recent Users -->
                <div class="card">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Users</h3>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline text-sm px-4 py-2">
                                <i class="fas fa-eye mr-2"></i>
                                View All
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            User
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Role
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Joined
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($recentUsers as $user)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-user text-gray-600 dark:text-gray-400"></i>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $user->name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            @php
                                                $roleColors = [
                                                    'doctor' => 'badge-primary',
                                                    'pharmacist' => 'badge-medical',
                                                    'admin' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'
                                                ];
                                            @endphp
                                            <span class="badge {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                                {{ $user->formatted_role }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                            <div class="flex items-center">
                                                <i class="fas fa-clock mr-2 text-xs"></i>
                                                {{ $user->created_at->diffForHumans() }}
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Top Doctors -->
                <div class="card">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Top Doctors</h3>
                            <a href="{{ route('admin.users.index', ['role' => 'doctor']) }}" class="btn btn-outline text-sm px-4 py-2">
                                <i class="fas fa-user-md mr-2"></i>
                                View All
                            </a>
                        </div>

                        <div class="space-y-4">
                            @foreach($topDoctors as $doctor)
                            <div class="flex items-center justify-between p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-md text-white"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $doctor->name }}
                                        </div>
                                        <div class="text-xs text-gray-600 dark:text-gray-400 flex items-center mt-1">
                                            <i class="fas fa-file-medical-alt mr-1"></i>
                                            {{ $doctor->examinations_count }} examinations
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('admin.users.show', $doctor->id) }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 text-sm font-medium">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="card">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Activities</h3>
                        <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-outline text-sm px-4 py-2">
                            <i class="fas fa-history mr-2"></i>
                            View All Logs
                        </a>
                    </div>

                    <div class="space-y-3">
                        @foreach($recentActivities as $activity)
                        <div class="flex items-start p-4 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex-shrink-0">
                                @php
                                    $actionIcons = [
                                        'CREATE' => ['icon' => 'fa-plus-circle', 'color' => 'text-green-500'],
                                        'UPDATE' => ['icon' => 'fa-edit', 'color' => 'text-blue-500'],
                                        'DELETE' => ['icon' => 'fa-trash-alt', 'color' => 'text-red-500'],
                                        'LOGIN' => ['icon' => 'fa-sign-in-alt', 'color' => 'text-purple-500'],
                                        'LOGOUT' => ['icon' => 'fa-sign-out-alt', 'color' => 'text-gray-500'],
                                    ];
                                    $icon = $actionIcons[$activity->action] ?? ['icon' => 'fa-circle', 'color' => 'text-gray-500'];
                                @endphp
                                <div class="w-8 h-8 rounded-full bg-white dark:bg-gray-700 flex items-center justify-center">
                                    <i class="fas {{ $icon['icon'] }} {{ $icon['color'] }}"></i>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="text-sm">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $activity->user->name ?? 'System' }}</span>
                                    <span class="text-gray-600 dark:text-gray-400 mx-1">{{ strtolower($activity->action) }}d</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $activity->table_name }}</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ $activity->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <div>
                                @php
                                    $actionColors = [
                                        'CREATE' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'UPDATE' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                        'DELETE' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    ];
                                @endphp
                                <span class="text-xs px-2 py-1 rounded-full {{ $actionColors[$activity->action] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ $activity->action }}
                                </span>
                            </div>
                        </div>
                        @endforeach
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

                    // Update charts if they exist
                    if (window.revenueChart) {
                        window.revenueChart.destroy();
                        initRevenueChart();
                    }
                    if (window.userChart) {
                        window.userChart.destroy();
                        initUserChart();
                    }
                });
            }

            // Revenue Chart
            function initRevenueChart() {
                const revenueCtx = document.getElementById('revenueChart');
                if (!revenueCtx) return;

                const revenueMonths = @json($monthlyRevenue->pluck('month'));
                const revenueData = @json($monthlyRevenue->pluck('revenue'));

                const isDark = document.documentElement.classList.contains('dark');
                const textColor = isDark ? '#d1d5db' : '#374151';
                const gridColor = isDark ? '#374151' : '#e5e7eb';

                window.revenueChart = new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: revenueMonths.map(month => {
                            const [year, monthNum] = month.split('-');
                            return new Date(year, monthNum - 1).toLocaleDateString('en-US', { month: 'short' });
                        }),
                        datasets: [{
                            label: 'Revenue',
                            data: revenueData,
                            borderColor: '#22c55e',
                            backgroundColor: isDark ? 'rgba(34, 197, 94, 0.1)' : 'rgba(34, 197, 94, 0.05)',
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#22c55e',
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

            // User Distribution Chart
            function initUserChart() {
                const userCtx = document.getElementById('userDistributionChart');
                if (!userCtx) return;

                const isDark = document.documentElement.classList.contains('dark');
                const textColor = isDark ? '#d1d5db' : '#374151';

                window.userChart = new Chart(userCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Doctors', 'Pharmacists', 'Admins'],
                        datasets: [{
                            data: [
                                {{ $userStats['doctor'] ?? 0 }},
                                {{ $userStats['pharmacist'] ?? 0 }},
                                {{ $userStats['admin'] ?? 0 }}
                            ],
                            backgroundColor: [
                                '#3b82f6',  // Blue for Doctors
                                '#22c55e',  // Green for Pharmacists
                                '#8b5cf6'   // Purple for Admins
                            ],
                            borderWidth: 2,
                            borderColor: isDark ? '#1f2937' : '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    color: textColor,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: isDark ? '#1f2937' : '#ffffff',
                                titleColor: isDark ? '#f3f4f6' : '#111827',
                                bodyColor: isDark ? '#d1d5db' : '#374151',
                                borderColor: isDark ? '#374151' : '#e5e7eb',
                                borderWidth: 1,
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((context.parsed / total) * 100);
                                        return `${context.label}: ${context.parsed} users (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Initialize charts
            initRevenueChart();
            initUserChart();
        });
    </script>
    @endpush
</x-app-layout>

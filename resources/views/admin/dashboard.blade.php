{{-- resources/views/admin/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Admin Dashboard') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Overview of system statistics and recent activities
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-lg">
                        <i class="far fa-calendar mr-2"></i>
                        {{ now()->format('l, d F Y') }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-lg">
                        <i class="far fa-clock mr-2"></i>
                        {{ now()->format('H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users Card -->
        <div class="card hover-lift">
            <div class="flex items-center">
                <div class="w-12 h-12 gradient-primary rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total_users'] }}</p>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <div class="flex space-x-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300">
                        <i class="fas fa-user-md mr-1"></i>
                        {{ $userStats['doctor'] ?? 0 }} Doctors
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300">
                        <i class="fas fa-prescription-bottle-alt mr-1"></i>
                        {{ $userStats['pharmacist'] ?? 0 }} Pharmacists
                    </span>
                </div>
                <span class="text-sm text-green-600 dark:text-green-400">
                    <i class="fas fa-arrow-up mr-1"></i>
                    {{ $userGrowth }}%
                </span>
            </div>
        </div>

        <!-- Total Patients Card -->
        <div class="card hover-lift">
            <div class="flex items-center">
                <div class="w-12 h-12 gradient-medical rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-injured text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Patients</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total_patients'] }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        New today: {{ $stats['new_patients_today'] ?? 0 }}
                    </span>
                    <a href="{{ route('admin.patients.index') }}" class="text-primary-600 dark:text-primary-400 text-sm hover:underline">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="card hover-lift">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Today's Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                        IDR {{ number_format($stats['revenue_today'], 0, ',', '.') }}
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        Weekly: IDR {{ number_format($stats['revenue_week'], 0, ',', '.') }}
                    </span>
                    <span class="text-sm {{ $revenueGrowth >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        <i class="fas fa-arrow-{{ $revenueGrowth >= 0 ? 'up' : 'down' }} mr-1"></i>
                        {{ abs($revenueGrowth) }}%
                    </span>
                </div>
            </div>
        </div>

        <!-- Prescriptions Card -->
        <div class="card hover-lift">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-prescription text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Prescriptions</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total_prescriptions'] }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        Today: {{ $stats['prescriptions_today'] ?? 0 }}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-300">
                        {{ $stats['total_examinations'] ?? 0 }} Examinations
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Revenue Chart -->
        <div class="card">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Monthly Revenue</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Revenue trends over past months</p>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-1 text-sm rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                        Monthly
                    </button>
                    <button class="px-3 py-1 text-sm rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                        Quarterly
                    </button>
                </div>
            </div>
            <div class="h-72">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- User Distribution -->
        <div class="card">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">User Distribution</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">System users by role</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="text-primary-600 dark:text-primary-400 text-sm hover:underline">
                    Manage Users <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="h-72">
                <canvas id="userDistributionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Data Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Users -->
        <div class="card">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Users</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Newly registered users</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="text-primary-600 dark:text-primary-400 text-sm hover:underline">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="space-y-4">
                @foreach($recentUsers as $user)
                <div class="flex items-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center
                        {{ $user->role == 'doctor' ? 'bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400' :
                           ($user->role == 'pharmacist' ? 'bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400' :
                           'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400') }}">
                        <i class="{{ $user->role == 'doctor' ? 'fas fa-user-md' :
                                    ($user->role == 'pharmacist' ? 'fas fa-prescription-bottle-alt' : 'fas fa-user') }}"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $user->role == 'doctor' ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300' :
                                       ($user->role == 'pharmacist' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' :
                                       'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $user->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top Doctors -->
        <div class="card">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Top Doctors</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Most active doctors</p>
                </div>
                <a href="{{ route('admin.users.index', ['role' => 'doctor']) }}" class="text-primary-600 dark:text-primary-400 text-sm hover:underline">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="space-y-4">
                @foreach($topDoctors as $doctor)
                <div class="flex items-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    <div class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold">
                            {{ strtoupper(substr($doctor->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $doctor->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $doctor->examinations_count }} examinations
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300">
                                    <i class="fas fa-star mr-1 text-yellow-500"></i>
                                    {{ $doctor->average_rating ?? 'N/A' }}
                                </span>
                                <a href="{{ route('admin.users.show', $doctor->id) }}"
                                   class="text-primary-600 dark:text-primary-400 text-sm hover:underline mt-2 block">
                                    View Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="card">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Activities</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">System audit log</p>
            </div>
            <a href="{{ route('admin.audit-logs.index') }}" class="text-primary-600 dark:text-primary-400 text-sm hover:underline">
                View All Logs <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="space-y-3">
            @foreach($recentActivities as $activity)
            <div class="flex items-start p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                <div class="flex-shrink-0">
                    @php
                        $actionConfig = [
                            'CREATE' => ['icon' => 'fa-plus-circle', 'color' => 'text-green-500 bg-green-100 dark:bg-green-900'],
                            'UPDATE' => ['icon' => 'fa-edit', 'color' => 'text-blue-500 bg-blue-100 dark:bg-blue-900'],
                            'DELETE' => ['icon' => 'fa-trash-alt', 'color' => 'text-red-500 bg-red-100 dark:bg-red-900'],
                            'LOGIN' => ['icon' => 'fa-sign-in-alt', 'color' => 'text-purple-500 bg-purple-100 dark:bg-purple-900'],
                            'LOGOUT' => ['icon' => 'fa-sign-out-alt', 'color' => 'text-yellow-500 bg-yellow-100 dark:bg-yellow-900'],
                        ];
                        $config = $actionConfig[$activity->action] ?? ['icon' => 'fa-info-circle', 'color' => 'text-gray-500 bg-gray-100 dark:bg-gray-700'];
                    @endphp
                    <div class="w-10 h-10 rounded-lg {{ $config['color'] }} flex items-center justify-center">
                        <i class="fas {{ $config['icon'] }}"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $activity->user->name ?? 'System' }}
                                <span class="font-normal text-gray-600 dark:text-gray-400">
                                    {{ strtolower($activity->action) }}d
                                    <span class="font-medium">{{ $activity->table_name }}</span>
                                </span>
                            </p>
                            @if($activity->description)
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $activity->description }}
                                </p>
                            @endif
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $activity->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            const revenueMonths = @json($monthlyRevenue->pluck('month'));
            const revenueData = @json($monthlyRevenue->pluck('revenue'));

            const revenueChart = new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: revenueMonths.map(month => {
                        const [year, monthNum] = month.split('-');
                        return new Date(year, monthNum - 1).toLocaleDateString('en-US', { month: 'short', year: '2-digit' });
                    }),
                    datasets: [{
                        label: 'Revenue',
                        data: revenueData,
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2
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
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            callbacks: {
                                label: function(context) {
                                    return 'Revenue: IDR ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'IDR ' + (value / 1000000).toFixed(1) + 'M';
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // User Distribution Chart
            const userCtx = document.getElementById('userDistributionChart').getContext('2d');
            const userData = [
                {{ $userStats['doctor'] ?? 0 }},
                {{ $userStats['pharmacist'] ?? 0 }},
                {{ $userStats['admin'] ?? 0 }}
            ];

            const userChart = new Chart(userCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Doctors', 'Pharmacists', 'Admins'],
                    datasets: [{
                        data: userData,
                        backgroundColor: [
                            'rgb(59, 130, 246)',
                            'rgb(34, 197, 94)',
                            'rgb(139, 92, 246)'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff',
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                color: function(context) {
                                    return window.matchMedia('(prefers-color-scheme: dark)').matches ?
                                           '#fff' : '#000';
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = userData.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((context.parsed / total) * 100);
                                    return `${context.label}: ${context.parsed} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });

            // Update charts on theme change
            document.getElementById('theme-toggle').addEventListener('click', function() {
                setTimeout(() => {
                    revenueChart.update();
                    userChart.update();
                }, 100);
            });
        });
    </script>
    @endpush
</x-app-layout>

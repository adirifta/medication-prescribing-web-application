{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'MediScript Pro'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Sidebar Navigation -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0">
            <div class="flex flex-col flex-grow bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 pt-5 pb-4">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0 px-6">
                    <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center">
                        <i class="fas fa-pills text-white"></i>
                    </div>
                    <div class="ml-3">
                        <h1 class="text-xl font-bold text-gray-900 dark:text-white">MediScript</h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Admin Dashboard</p>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="mt-8 flex-1 flex flex-col overflow-y-auto">
                    <nav class="flex-1 px-4 space-y-2">
                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}"
                           class="{{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-tachometer-alt mr-3 text-lg"></i>
                            Dashboard
                        </a>

                        <!-- User Management -->
                        <a href="{{ route('admin.users.index') }}"
                           class="{{ request()->routeIs('admin.users.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-users mr-3 text-lg"></i>
                            User Management
                        </a>

                        <!-- Patients -->
                        <a href="{{ route('admin.patients.index') }}"
                           class="{{ request()->routeIs('admin.patients.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-user-injured mr-3 text-lg"></i>
                            Patients
                        </a>

                        <!-- Prescriptions -->
                        <a href="{{ route('admin.prescriptions.index') }}"
                           class="{{ request()->routeIs('admin.prescriptions.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-prescription mr-3 text-lg"></i>
                            Prescriptions
                        </a>

                        <!-- Examinations -->
                        <a href="{{ route('admin.examinations.index') }}"
                           class="{{ request()->routeIs('admin.examinations.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-stethoscope mr-3 text-lg"></i>
                            Examinations
                        </a>

                        <!-- Audit Logs -->
                        <a href="{{ route('admin.audit-logs.index') }}"
                           class="{{ request()->routeIs('admin.audit-logs.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-history mr-3 text-lg"></i>
                            Audit Logs
                        </a>

                        <!-- API Settings -->
                        <a href="{{ route('admin.api-settings') }}"
                           class="{{ request()->routeIs('admin.api-settings') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-plug mr-3 text-lg"></i>
                            API Settings
                        </a>

                        <!-- Reports -->
                        <a href="{{ route('admin.reports') }}"
                           class="{{ request()->routeIs('admin.reports') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-chart-bar mr-3 text-lg"></i>
                            Reports
                        </a>
                    </nav>

                    <!-- User Profile -->
                    <div class="mt-auto px-4 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ Auth::user()->name }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ ucfirst(Auth::user()->role) }}
                                </p>
                            </div>
                            <!-- Settings Dropdown -->
                            <div class="ml-auto relative">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <!-- Authentication -->
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                <i class="fas fa-sign-out-alt mr-2"></i>
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 lg:pl-64">
            <!-- Top Navigation Bar -->
            <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <!-- Mobile menu button -->
                <button type="button" class="px-4 border-r border-gray-200 dark:border-gray-700 text-gray-500 lg:hidden" id="sidebar-toggle">
                    <span class="sr-only">Open sidebar</span>
                    <i class="fas fa-bars h-6 w-6"></i>
                </button>

                <!-- Header Content -->
                <div class="flex-1 px-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            @yield('header')
                        </h2>
                        @hasSection('subheader')
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                @yield('subheader')
                            </p>
                        @endif
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Dark Mode Toggle -->
                        <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                            <i class="fas fa-moon text-gray-600 dark:text-yellow-400" id="theme-icon"></i>
                        </button>

                        <!-- Notifications -->
                        <button class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 relative">
                            <i class="fas fa-bell text-gray-600 dark:text-gray-400"></i>
                            @if($unreadNotifications > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ $unreadNotifications }}
                                </span>
                            @endif
                        </button>

                        <!-- Quick Actions -->
                        <div class="hidden md:flex items-center space-x-2">
                            <a href="{{ route('admin.prescriptions.create') }}" class="btn btn-primary text-sm">
                                <i class="fas fa-plus mr-2"></i>New Prescription
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <main class="flex-1">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <!-- Page Content -->
                        {{ $slot }}
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            &copy; {{ date('Y') }} MediScript Pro. All rights reserved.
                        </div>
                        <div class="flex items-center space-x-4 mt-2 md:mt-0">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-database mr-1"></i>
                                {{ $databaseSize }} MB
                            </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-server mr-1"></i>
                                v{{ config('app.version', '1.0.0') }}
                            </span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Mobile Sidebar -->
    <div class="fixed inset-0 flex z-40 lg:hidden" id="mobile-sidebar" style="display: none;">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75" id="sidebar-backdrop"></div>
        <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white dark:bg-gray-800">
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" id="mobile-sidebar-close">
                    <span class="sr-only">Close sidebar</span>
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>
            <!-- Mobile sidebar content -->
            <div class="pt-5 pb-4 flex-1">
                <!-- Mobile navigation items -->
                <!-- Reuse navigation items from desktop sidebar -->
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Theme toggle
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

        // Mobile sidebar toggle
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const sidebarBackdrop = document.getElementById('sidebar-backdrop');
        const mobileSidebarClose = document.getElementById('mobile-sidebar-close');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                mobileSidebar.style.display = 'flex';
            });
        }

        if (sidebarBackdrop) {
            sidebarBackdrop.addEventListener('click', () => {
                mobileSidebar.style.display = 'none';
            });
        }

        if (mobileSidebarClose) {
            mobileSidebarClose.addEventListener('click', () => {
                mobileSidebar.style.display = 'none';
            });
        }
    </script>

    @stack('scripts')
</body>
</html>

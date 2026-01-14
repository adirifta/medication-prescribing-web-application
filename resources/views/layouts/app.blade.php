<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MediScript Pro') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Sidebar for Desktop -->
    <div class="hidden lg:flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 min-h-screen">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center">
                        <i class="fas fa-pills text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900 dark:text-white">MediScript Pro</h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Admin Panel</p>
                    </div>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400' : '' }}">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span>Dashboard</span>
                </a>

                <div class="pt-2">
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider px-3 py-2">Manajemen</p>
                    <a href="{{ route('admin.users.index') }}" class="nav-link flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400' : '' }}">
                        <i class="fas fa-users w-5"></i>
                        <span>Users</span>
                    </a>
                    <a href="{{ route('admin.patients.index') }}" class="nav-link flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.patients.*') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400' : '' }}">
                        <i class="fas fa-user-injured w-5"></i>
                        <span>Patients</span>
                    </a>
                    <a href="{{ route('admin.reports') }}" class="nav-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-file-prescription w-5"></i>
                        <span>Reports</span>
                    </a>
                </div>

                <div class="pt-2">
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider px-3 py-2">Laporan</p>
                    <a href="{{ route('admin.reports') }}" class="nav-link group flex items-center px-2 py-2 text-base font-medium rounded-md">
                        <i class="fas fa-chart-line w-5"></i>
                        <span>Revenue Report</span>
                    </a>
                    <a href="{{ route('admin.audit-logs.index') }}" class="nav-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-history w-5"></i>
                        <span>Audit Logs</span>
                    </a>
                </div>

                <div class="pt-2">
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider px-3 py-2">Pengaturan</p>
                    <a href="" class="nav-link flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-cog w-5"></i>
                        <span>Settings</span>
                    </a>
                </div>
            </nav>

            <!-- User Profile -->
            <div class="absolute bottom-0 w-64 p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-circle text-gray-600 dark:text-gray-400 text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->role }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="px-8 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            @yield('header')
                        </div>

                        <!-- Mobile menu button (hidden on desktop) -->
                        <button id="mobile-menu-button" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </header>

            <main class="p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Mobile Layout -->
    <div class="lg:hidden">
        <!-- Mobile Header -->
        <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="px-4 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button id="mobile-menu-button" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 mr-2">
                            <i class="fas fa-bars"></i>
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                            <div class="w-8 h-8 gradient-primary rounded-lg flex items-center justify-center">
                                <i class="fas fa-pills text-white"></i>
                            </div>
                            <span class="text-lg font-bold text-gray-900 dark:text-white">MediScript</span>
                        </a>
                    </div>

                    <div class="flex items-center space-x-2">
                        <button id="theme-toggle-mobile" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700">
                            <i class="fas fa-moon text-gray-600 dark:text-yellow-400" id="theme-icon-mobile"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Mobile Sidebar -->
        <div id="mobile-sidebar" class="fixed inset-0 z-50 hidden">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75" onclick="toggleMobileMenu()"></div>
            <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white dark:bg-gray-800">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button onclick="toggleMobileMenu()" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <i class="fas fa-times text-white"></i>
                    </button>
                </div>

                <div class="pt-5 pb-4">
                    <div class="flex items-center px-4">
                        <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center">
                            <i class="fas fa-pills text-white"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-base font-medium text-gray-900 dark:text-white">MediScript Pro</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Admin Panel</p>
                        </div>
                    </div>

                    <nav class="mt-5 px-2 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link group flex items-center px-2 py-2 text-base font-medium rounded-md">
                            <i class="fas fa-tachometer-alt mr-4 text-gray-400 group-hover:text-gray-500"></i>
                            Dashboard
                        </a>

                        <a href="{{ route('admin.users.index') }}" class="nav-link group flex items-center px-2 py-2 text-base font-medium rounded-md">
                            <i class="fas fa-users mr-4 text-gray-400 group-hover:text-gray-500"></i>
                            Users
                        </a>

                        <a href="{{ route('admin.patients.index') }}" class="nav-link group flex items-center px-2 py-2 text-base font-medium rounded-md">
                            <i class="fas fa-user-injured mr-4 text-gray-400 group-hover:text-gray-500"></i>
                            Patients
                        </a>

                        <a href="" class="nav-link group flex items-center px-2 py-2 text-base font-medium rounded-md">
                            <i class="fas fa-file-prescription mr-4 text-gray-400 group-hover:text-gray-500"></i>
                            Prescriptions
                        </a>

                        <div class="pt-4">
                            <p class="px-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Laporan</p>
                            <a href="" class="nav-link group flex items-center px-2 py-2 text-base font-medium rounded-md">
                                <i class="fas fa-chart-line mr-4 text-gray-400 group-hover:text-gray-500"></i>
                                Revenue Report
                            </a>
                            <a href="{{ route('admin.audit-logs.index') }}" class="nav-link group flex items-center px-2 py-2 text-base font-medium rounded-md">
                                <i class="fas fa-history mr-4 text-gray-400 group-hover:text-gray-500"></i>
                                Audit Logs
                            </a>
                        </div>
                    </nav>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 pt-4 pb-3">
                    <div class="px-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-circle text-gray-600 dark:text-gray-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-base font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Administrator</p>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-2 text-base font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md">
                                    <i class="fas fa-sign-out-alt mr-3"></i>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Main Content -->
        <main class="p-4">
            {{ $slot }}
        </main>
    </div>

    <!-- Mobile Menu Script -->
    <script>
        function toggleMobileMenu() {
            const sidebar = document.getElementById('mobile-sidebar');
            sidebar.classList.toggle('hidden');
        }

        document.getElementById('mobile-menu-button').addEventListener('click', toggleMobileMenu);

        // Theme toggle for mobile
        const themeToggleMobile = document.getElementById('theme-toggle-mobile');
        const themeIconMobile = document.getElementById('theme-icon-mobile');

        if (themeToggleMobile) {
            themeToggleMobile.addEventListener('click', () => {
                document.documentElement.classList.toggle('dark');

                if (document.documentElement.classList.contains('dark')) {
                    localStorage.setItem('theme', 'dark');
                    themeIconMobile.classList.remove('fa-moon');
                    themeIconMobile.classList.add('fa-sun');
                } else {
                    localStorage.setItem('theme', 'light');
                    themeIconMobile.classList.remove('fa-sun');
                    themeIconMobile.classList.add('fa-moon');
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MediScript Pro</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Navbar -->
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center">
                        <i class="fas fa-pills text-white"></i>
                    </div>
                    <span class="ml-3 text-xl font-bold text-gray-900 dark:text-white">
                        MediScript
                    </span>
                </div>

                <!-- Navigation -->
                <div class="flex items-center space-x-4">
                    <a href="#features" class="nav-link">Fitur</a>
                    <a href="#about" class="nav-link">Tentang</a>

                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Daftar
                        </a>
                    @endauth

                    <!-- Dark Mode Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                        <i class="fas fa-moon text-gray-600 dark:text-yellow-400" id="theme-icon"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                    Sistem Peresepan Obat
                    <span class="block text-primary-600 dark:text-primary-400">Digital Modern</span>
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                    Solusi lengkap untuk dokter dan apoteker dengan integrasi API real-time.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('register') }}" class="btn btn-primary text-lg px-8 py-3">
                        <i class="fas fa-rocket mr-2"></i>Mulai Sekarang
                    </a>
                    <a href="#features" class="btn btn-secondary text-lg px-8 py-3">
                        <i class="fas fa-play-circle mr-2"></i>Lihat Fitur
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="card p-8">
                    <div class="w-16 h-16 gradient-primary rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-user-md text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Untuk Dokter</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Fitur lengkap untuk pemeriksaan pasien dan penulisan resep digital.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="card p-8">
                    <div class="w-16 h-16 gradient-medical rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-prescription-bottle-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Untuk Apoteker</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Proses resep, pembayaran, dan cetak resi dengan mudah.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="card p-8">
                    <div class="w-16 h-16 gradient-primary rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-database text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">API Integrasi</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Data obat real-time dengan harga fluktuatif dari API terpusat.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-primary-500 to-primary-700">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                Siap Menggunakan Sistem Digital?
            </h2>
            <p class="text-xl text-primary-100 mb-8">
                Bergabung dengan sistem peresepan modern yang efisien.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn bg-white text-primary-700 hover:bg-gray-100 text-lg px-8 py-3">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn bg-white text-primary-700 hover:bg-gray-100 text-lg px-8 py-3">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Gratis
                    </a>
                    <a href="{{ route('login') }}" class="btn bg-transparent border-2 border-white text-white hover:bg-white/10 text-lg px-8 py-3">
                        <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                    </a>
                @endauth
            </div>
        </div>
    </section>
</body>
</html>

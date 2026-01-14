<x-guest-layout>
    <div class="w-full max-w-md mx-auto">
        <!-- Card Container -->
        <div class="card p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 gradient-medical rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-plus text-white text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Buat Akun Baru</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Daftar untuk akses sistem peresepan
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="form-label">
                        <i class="fas fa-user mr-2 text-gray-500"></i>
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Nama lengkap"
                            class="form-input pl-10 @error('name') border-red-500 @enderror"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-id-card text-gray-400"></i>
                        </div>
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope mr-2 text-gray-500"></i>
                        Alamat Email
                    </label>
                    <div class="relative">
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            placeholder="nama@example.com"
                            class="form-input pl-10 @error('email') border-red-500 @enderror"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-at text-gray-400"></i>
                        </div>
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock mr-2 text-gray-500"></i>
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                            class="form-input pl-10 @error('password') border-red-500 @enderror"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-key text-gray-400"></i>
                        </div>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        Gunakan kombinasi huruf, angka, dan simbol untuk keamanan lebih baik.
                    </p>
                </div>

                <!-- Confirm Password -->
                <div class="mb-8">
                    <label for="password_confirmation" class="form-label">
                        <i class="fas fa-lock mr-2 text-gray-500"></i>
                        Konfirmasi Kata Sandi
                    </label>
                    <div class="relative">
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Ulangi kata sandi"
                            class="form-input pl-10"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-check-double text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-medical w-full py-3 text-lg font-semibold">
                    <i class="fas fa-user-plus mr-2"></i>
                    {{ __('Daftar Sekarang') }}
                </button>

                <!-- Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                            Sudah punya akun?
                        </span>
                    </div>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-gray-600 dark:text-gray-400">
                        Sudah terdaftar?
                        <a
                            href="{{ route('login') }}"
                            class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 font-semibold hover:underline ml-1"
                        >
                            Masuk di sini
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </p>
                </div>

                <!-- Back to Home -->
                <div class="text-center mt-6">
                    <a
                        href="{{ url('/') }}"
                        class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300 transition-colors"
                    >
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke beranda
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

<x-guest-layout>
    <div class="w-full max-w-md mx-auto">
        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200">
                {{ session('status') }}
            </div>
        @endif

        <!-- Card Container -->
        <div class="card p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-sign-in-alt text-white text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Masuk ke Akun</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Akses sistem peresepan obat digital
                </p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

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
                            autofocus
                            autocomplete="email"
                            placeholder="nama@example.com"
                            class="form-input pl-10 @error('email') border-red-500 @enderror"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
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
                            autocomplete="current-password"
                            placeholder="••••••••"
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
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-8">
                    <label class="flex items-center cursor-pointer">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded
                                   focus:ring-primary-500 dark:focus:ring-primary-600
                                   dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
                        >
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                            Ingat saya
                        </span>
                    </label>

                    @if (Route::has('password.request'))
                        <a
                            href="{{ route('password.request') }}"
                            class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 hover:underline transition-colors"
                        >
                            <i class="fas fa-question-circle mr-1"></i>
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-full py-3 text-lg font-semibold">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    {{ __('Masuk') }}
                </button>

                <!-- Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                            Atau
                        </span>
                    </div>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-gray-600 dark:text-gray-400">
                        Belum punya akun?
                        <a
                            href="{{ route('register') }}"
                            class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 font-semibold hover:underline ml-1"
                        >
                            Daftar sekarang
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

        <!-- Demo Credentials (Optional - hanya untuk development) -->
        @env('local')
            <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                <h4 class="font-semibold text-blue-800 dark:text-blue-300 mb-2 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Informasi Login Demo
                </h4>
                <div class="space-y-2 text-sm text-blue-700 dark:text-blue-400">
                    <p><span class="font-medium">Dokter:</span> dokter@example.com / password</p>
                    <p><span class="font-medium">Apoteker:</span> apoteker@example.com / password</p>
                </div>
            </div>
        @endenv
    </div>
</x-guest-layout>

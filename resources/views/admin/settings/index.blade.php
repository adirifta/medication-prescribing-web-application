{{-- resources/views/admin/settings/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('System Settings') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Configure application and system preferences
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <span class="text-red-800 dark:text-red-200">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Settings Tabs -->
            <div class="mb-8">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8">
                        <a href="{{ route('admin.settings.index') }}"
                           class="border-b-2 border-primary-500 text-primary-600 dark:text-primary-400 whitespace-nowrap py-4 px-1 text-sm font-medium">
                            General Settings
                        </a>
                        <a href="{{ route('admin.settings.logs') }}"
                           class="border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 whitespace-nowrap py-4 px-1 text-sm font-medium">
                            System Logs
                        </a>
                    </nav>
                </div>
            </div>

            <!-- System Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Cache Management -->
                <div class="card">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-broom mr-3 text-blue-500"></i>
                            Cache Management
                        </h3>
                        <div class="space-y-3">
                            <form action="{{ route('admin.settings.clear-cache') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('Clear all application cache?')"
                                        class="btn btn-primary w-full">
                                    <i class="fas fa-trash-alt mr-2"></i>
                                    Clear Application Cache
                                </button>
                            </form>
                            <form action="{{ route('admin.settings.optimize') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('Optimize the application?')"
                                        class="btn btn-medical w-full">
                                    <i class="fas fa-bolt mr-2"></i>
                                    Optimize Application
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Maintenance Mode -->
                <div class="card">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-tools mr-3 text-yellow-500"></i>
                            Maintenance Mode
                        </h3>
                        <div class="space-y-3">
                            <form action="{{ route('admin.settings.maintenance') }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="down">
                                <button type="submit"
                                        onclick="return confirm('Enable maintenance mode?')"
                                        class="btn btn-secondary w-full">
                                    <i class="fas fa-power-off mr-2"></i>
                                    Enable Maintenance Mode
                                </button>
                            </form>
                            <form action="{{ route('admin.settings.maintenance') }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="up">
                                <button type="submit"
                                        onclick="return confirm('Disable maintenance mode?')"
                                        class="btn btn-primary w-full">
                                    <i class="fas fa-play mr-2"></i>
                                    Disable Maintenance Mode
                                </button>
                            </form>
                        </div>
                        <div class="mt-4 text-sm {{ $settings['maintenance_mode'] ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                            <i class="fas fa-circle text-xs mr-2"></i>
                            {{ $settings['maintenance_mode'] ? 'Maintenance Mode Active' : 'Application Running Normally' }}
                        </div>
                    </div>
                </div>

                <!-- System Tools -->
                <div class="card">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-database mr-3 text-purple-500"></i>
                            System Tools
                        </h3>
                        <div class="space-y-3">
                            <form action="{{ route('admin.settings.backup') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('Create system backup?')"
                                        class="btn btn-secondary w-full">
                                    <i class="fas fa-save mr-2"></i>
                                    Create Backup
                                </button>
                            </form>
                            <a href="{{ route('admin.settings.logs') }}" class="btn btn-outline w-full">
                                <i class="fas fa-file-alt mr-2"></i>
                                View System Logs
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Settings Form -->
            <div class="card mb-8">
                <div class="p-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-8 flex items-center">
                        <i class="fas fa-cog mr-3 text-primary-500"></i>
                        Application Configuration
                    </h3>

                    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Application Name -->
                            <div>
                                <label for="app_name" class="form-label">Application Name</label>
                                <div class="relative">
                                    <input type="text"
                                           id="app_name"
                                           name="app_name"
                                           value="{{ old('app_name', $settings['app_name']) }}"
                                           required
                                           class="form-input pl-10"
                                           placeholder="MediScript Pro">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-tag text-gray-400"></i>
                                    </div>
                                </div>
                                @error('app_name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Application URL -->
                            <div>
                                <label for="app_url" class="form-label">Application URL</label>
                                <div class="relative">
                                    <input type="url"
                                           id="app_url"
                                           name="app_url"
                                           value="{{ old('app_url', $settings['app_url']) }}"
                                           required
                                           class="form-input pl-10"
                                           placeholder="https://example.com">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-globe text-gray-400"></i>
                                    </div>
                                </div>
                                @error('app_url')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Medicine API Email -->
                            <div>
                                <label for="medicine_api_email" class="form-label">Medicine API Email</label>
                                <div class="relative">
                                    <input type="email"
                                           id="medicine_api_email"
                                           name="medicine_api_email"
                                           value="{{ old('medicine_api_email', $settings['medicine_api_email']) }}"
                                           required
                                           class="form-input pl-10"
                                           placeholder="your-email@example.com">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                </div>
                                @error('medicine_api_email')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Medicine API Phone -->
                            <div>
                                <label for="medicine_api_phone" class="form-label">Medicine API Phone</label>
                                <div class="relative">
                                    <input type="text"
                                           id="medicine_api_phone"
                                           name="medicine_api_phone"
                                           value="{{ old('medicine_api_phone', $settings['medicine_api_phone']) }}"
                                           required
                                           class="form-input pl-10"
                                           placeholder="08xxxxxxxxxx"
                                           pattern="^08[0-9]{9,11}$">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </div>
                                </div>
                                @error('medicine_api_phone')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Session Lifetime -->
                            <div>
                                <label for="session_lifetime" class="form-label">Session Lifetime (minutes)</label>
                                <div class="relative">
                                    <input type="number"
                                           id="session_lifetime"
                                           name="session_lifetime"
                                           value="{{ old('session_lifetime', $settings['session_lifetime']) }}"
                                           required
                                           min="1"
                                           max="525600"
                                           class="form-input pl-10">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-clock text-gray-400"></i>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Maximum: 525600 (1 year)
                                </p>
                                @error('session_lifetime')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Cache Status -->
                            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                <div class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">
                                    <i class="fas fa-database mr-2"></i>
                                    Cache Status
                                </div>
                                <span class="badge {{ $settings['cache_enabled'] ? 'badge-medical' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ $settings['cache_enabled'] ? 'Enabled' : 'Disabled' }}
                                </span>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end pt-8 border-t border-gray-200 dark:border-gray-700">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- System Information -->
            <div class="card">
                <div class="p-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-info-circle mr-3 text-primary-500"></i>
                        System Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                            <div class="text-sm text-gray-500 dark:text-gray-400">PHP Version</div>
                            <div class="text-lg font-medium text-gray-900 dark:text-white mt-1">
                                {{ phpversion() }}
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                            <div class="text-sm text-gray-500 dark:text-gray-400">Laravel Version</div>
                            <div class="text-lg font-medium text-gray-900 dark:text-white mt-1">
                                {{ app()->version() }}
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                            <div class="text-sm text-gray-500 dark:text-gray-400">Server Software</div>
                            <div class="text-lg font-medium text-gray-900 dark:text-white mt-1">
                                {{ $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                            <div class="text-sm text-gray-500 dark:text-gray-400">Database</div>
                            <div class="text-lg font-medium text-gray-900 dark:text-white mt-1">
                                {{ config('database.default') }}
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                            <div class="text-sm text-gray-500 dark:text-gray-400">Environment</div>
                            <div class="text-lg font-medium text-gray-900 dark:text-white mt-1">
                                {{ app()->environment() }}
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                            <div class="text-sm text-gray-500 dark:text-gray-400">Debug Mode</div>
                            <div class="text-lg font-medium {{ config('app.debug') ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }} mt-1">
                                {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

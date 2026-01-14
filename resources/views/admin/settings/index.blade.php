<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('System Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- System Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Cache Management</h3>
                        <div class="space-y-3">
                            <form action="{{ route('admin.settings.clear-cache') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Clear Application Cache
                                </button>
                            </form>
                            <form action="{{ route('admin.settings.optimize') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    Optimize Application
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Maintenance Mode</h3>
                        <div class="space-y-3">
                            <form action="{{ route('admin.settings.maintenance') }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="down">
                                <button type="submit" class="w-full px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                                    Enable Maintenance Mode
                                </button>
                            </form>
                            <form action="{{ route('admin.settings.maintenance') }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="up">
                                <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    Disable Maintenance Mode
                                </button>
                            </form>
                        </div>
                        <div class="mt-4 text-sm text-gray-600">
                            Current status:
                            <span class="font-medium {{ $settings['maintenance_mode'] ? 'text-red-600' : 'text-green-600' }}">
                                {{ $settings['maintenance_mode'] ? 'Maintenance Mode Active' : 'Application Running' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">System Tools</h3>
                        <div class="space-y-3">
                            <form action="{{ route('admin.settings.backup') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                    Create Backup
                                </button>
                            </form>
                            <a href="{{ route('admin.settings.logs') }}" class="block w-full px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-center">
                                View System Logs
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Settings Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Application Configuration</h3>

                    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Application Name -->
                            <div>
                                <label for="app_name" class="block text-sm font-medium text-gray-700">Application Name</label>
                                <input type="text" id="app_name" name="app_name" value="{{ old('app_name', $settings['app_name']) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Application URL -->
                            <div>
                                <label for="app_url" class="block text-sm font-medium text-gray-700">Application URL</label>
                                <input type="url" id="app_url" name="app_url" value="{{ old('app_url', $settings['app_url']) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Medicine API Email -->
                            <div>
                                <label for="medicine_api_email" class="block text-sm font-medium text-gray-700">Medicine API Email</label>
                                <input type="email" id="medicine_api_email" name="medicine_api_email" value="{{ old('medicine_api_email', $settings['medicine_api_email']) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Medicine API Phone -->
                            <div>
                                <label for="medicine_api_phone" class="block text-sm font-medium text-gray-700">Medicine API Phone</label>
                                <input type="text" id="medicine_api_phone" name="medicine_api_phone" value="{{ old('medicine_api_phone', $settings['medicine_api_phone']) }}" required placeholder="08xxxxxxxxxx" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Session Lifetime -->
                            <div>
                                <label for="session_lifetime" class="block text-sm font-medium text-gray-700">Session Lifetime (minutes)</label>
                                <input type="number" id="session_lifetime" name="session_lifetime" value="{{ old('session_lifetime', $settings['session_lifetime']) }}" required min="1" max="525600" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <p class="mt-1 text-sm text-gray-500">Maximum: 525600 (1 year)</p>
                            </div>

                            <!-- Cache Status -->
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="text-sm font-medium text-gray-700">Cache Status</div>
                                <div class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $settings['cache_enabled'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $settings['cache_enabled'] ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- System Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">System Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="text-sm text-gray-500">PHP Version</div>
                            <div class="text-lg font-medium text-gray-900">{{ phpversion() }}</div>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="text-sm text-gray-500">Laravel Version</div>
                            <div class="text-lg font-medium text-gray-900">{{ app()->version() }}</div>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="text-sm text-gray-500">Server Software</div>
                            <div class="text-lg font-medium text-gray-900">{{ $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' }}</div>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="text-sm text-gray-500">Database</div>
                            <div class="text-lg font-medium text-gray-900">{{ config('database.default') }}</div>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="text-sm text-gray-500">Environment</div>
                            <div class="text-lg font-medium text-gray-900">{{ app()->environment() }}</div>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="text-sm text-gray-500">Debug Mode</div>
                            <div class="text-lg font-medium {{ config('app.debug') ? 'text-red-600' : 'text-green-600' }}">
                                {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

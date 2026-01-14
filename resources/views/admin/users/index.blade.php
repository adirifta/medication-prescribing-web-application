<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('User Management') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Manage system users and roles
                </p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus mr-2"></i>
                New User
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- User Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 gradient-primary rounded-xl flex items-center justify-center">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $userCounts['total'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-user-md text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Doctors</p>
                                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $userCounts['doctors'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-prescription-bottle-alt text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pharmacists</p>
                                <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">{{ $userCounts['pharmacists'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-user-shield text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Admins</p>
                                <p class="text-2xl font-bold text-purple-600 dark:text-purple-400 mt-1">{{ $userCounts['admins'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card mb-8">
                <div class="p-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="form-label">Search</label>
                            <input type="text" name="search" value="{{ $search }}"
                                   placeholder="Name, email, or phone" class="form-input">
                        </div>

                        <div>
                            <label class="form-label">Role</label>
                            <select name="role" class="form-input">
                                <option value="">All Roles</option>
                                <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="doctor" {{ $role == 'doctor' ? 'selected' : '' }}>Doctor</option>
                                <option value="pharmacist" {{ $role == 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                            </select>
                        </div>

                        <div class="flex items-end space-x-3">
                            <button type="submit" class="btn btn-primary flex-1">
                                <i class="fas fa-filter mr-2"></i>
                                Filter
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-2"></i>
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Users Table -->
            <div class="card">
                <div class="p-6">
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
                                        Contact
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Joined
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($users as $user)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                        <td class="px-4 py-4">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                                    <span class="text-gray-600 dark:text-gray-400 font-medium text-lg">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            @php
                                                $roleColors = [
                                                    'admin' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                                    'doctor' => 'badge-primary',
                                                    'pharmacist' => 'badge-medical'
                                                ];
                                            @endphp
                                            <span class="badge {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                                {{ $user->formatted_role }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                <i class="fas fa-phone mr-2 text-gray-400"></i>
                                                {{ $user->phone }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-400">
                                            <div class="flex items-center">
                                                <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                                                {{ $user->created_at->format('d M Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $user->created_at->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex items-center space-x-3">
                                                <a href="{{ route('admin.users.show', $user->id) }}"
                                                   class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300"
                                                   title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                   class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300"
                                                            title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                            <div class="flex flex-col items-center">
                                                <i class="fas fa-users text-gray-300 dark:text-gray-600 text-4xl mb-3"></i>
                                                <p class="text-lg font-medium text-gray-700 dark:text-gray-300">No users found</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                    Try adjusting your search filters
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($users->hasPages())
                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700 dark:text-gray-300">
                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                            </div>
                            <div class="flex space-x-2">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

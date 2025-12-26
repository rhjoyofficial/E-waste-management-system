@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-600">User Details & Activity</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.users.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Back to Users
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - User Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Full Name</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Email Address</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Phone Number</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->phone ?? 'Not provided' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Address</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->address ?? 'Not provided' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Account Status</label>
                                    <p class="mt-1">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Member Since</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M d, Y • h:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Role Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Role Information</h3>
                                <button onclick="showRoleModal()"
                                    class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-sm">
                                    Change Role
                                </button>
                            </div>

                            <div class="space-y-3">
                                @foreach ($user->roles as $role)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 rounded-full flex items-center justify-center 
                                            {{ $role->name == 'admin' ? 'bg-purple-100 text-purple-600' : '' }}
                                            {{ $role->name == 'collector' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                            {{ $role->name == 'user' ? 'bg-blue-100 text-blue-600' : '' }}">
                                                @if ($role->name == 'admin')
                                                    <i class="fas fa-crown"></i>
                                                @elseif($role->name == 'collector')
                                                    <i class="fas fa-truck"></i>
                                                @else
                                                    <i class="fas fa-user"></i>
                                                @endif
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">{{ ucfirst($role->name) }}</p>
                                                <p class="text-xs text-gray-500">{{ $role->display_name ?? '' }}</p>
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-500">Current Role</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Activity Stats -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Activity Statistics</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <!-- Submitted Requests -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900">
                                            {{ $requestStats['total_submitted'] }}</div>
                                        <div class="text-sm text-gray-500">Submitted Requests</div>
                                    </div>
                                </div>

                                <!-- Pending -->
                                <div class="bg-yellow-50 p-4 rounded-lg">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-yellow-800">{{ $requestStats['pending'] }}
                                        </div>
                                        <div class="text-sm text-yellow-600">Pending</div>
                                    </div>
                                </div>

                                <!-- Approved -->
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-blue-800">{{ $requestStats['approved'] }}</div>
                                        <div class="text-sm text-blue-600">Approved</div>
                                    </div>
                                </div>

                                <!-- Collected -->
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-green-800">{{ $requestStats['collected'] }}
                                        </div>
                                        <div class="text-sm text-green-600">Collected</div>
                                    </div>
                                </div>

                                <!-- Assigned as Collector -->
                                <div class="bg-purple-50 p-4 rounded-lg">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-purple-800">{{ $requestStats['assigned'] }}
                                        </div>
                                        <div class="text-sm text-purple-600">Assigned Pickups</div>
                                    </div>
                                </div>

                                <!-- Collected as Collector -->
                                <div class="bg-indigo-50 p-4 rounded-lg">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-indigo-800">
                                            {{ $requestStats['collected_as_collector'] }}</div>
                                        <div class="text-sm text-indigo-600">Completed Pickups</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Actions & Recent Activity -->
                <div class="space-y-6">
                    <!-- User Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">User Actions</h3>
                            <div class="space-y-3">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="block text-center px-4 py-2 border border-blue-300 text-blue-700 rounded-md hover:bg-blue-50 transition-colors">
                                    <i class="fas fa-edit mr-2"></i>Edit User
                                </a>

                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="w-full text-center px-4 py-2 border {{ $user->is_active ? 'border-yellow-300 text-yellow-700 hover:bg-yellow-50' : 'border-green-300 text-green-700 hover:bg-green-50' }} rounded-md transition-colors">
                                        <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }} mr-2"></i>
                                        {{ $user->is_active ? 'Deactivate User' : 'Activate User' }}
                                    </button>
                                </form>

                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')"
                                            class="w-full text-center px-4 py-2 border border-red-300 text-red-700 rounded-md hover:bg-red-50 transition-colors">
                                            <i class="fas fa-trash mr-2"></i>Delete User
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Recent Requests -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Requests</h3>
                            <div class="space-y-3">
                                @forelse($user->submittedRequests->take(5) as $request)
                                    <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">#{{ $request->id }}</p>
                                            <p class="text-xs text-gray-500">{{ $request->category->name }}</p>
                                        </div>
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $request->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $request->status == 'approved' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $request->status == 'collected' ? 'bg-green-100 text-green-800' : '' }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 text-center py-2">No requests submitted</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Last Updated</span>
                                    <span class="text-sm text-gray-900">{{ $user->updated_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Email Verified</span>
                                    <span class="text-sm text-gray-900">
                                        @if ($user->email_verified_at)
                                            {{ $user->email_verified_at->format('M d, Y') }}
                                        @else
                                            <span class="text-red-600">Not Verified</span>
                                        @endif
                                    </span>
                                </div>
                                @if ($user->isCollector())
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">Assigned Area</span>
                                        <span class="text-sm text-gray-900">All Areas</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Role Change Modal -->
    <div id="roleModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
                <form action="{{ route('admin.users.assign-role', $user) }}" method="POST">
                    @csrf
                    <div class="p-6">
                        <!-- Modal header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Change User Role</h3>
                            <button type="button" onclick="closeRoleModal()" class="text-gray-400 hover:text-gray-500">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <!-- Form content -->
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-3">Select a new role for {{ $user->name }}</p>
                            <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">
                                New Role *
                            </label>
                            <select name="role_id" id="role_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="">Select a role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }} - {{ $role->display_name ?? '' }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="mt-3 p-3 bg-yellow-50 rounded-lg">
                                <p class="text-xs text-yellow-800">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Changing roles will affect user permissions immediately.
                                </p>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="closeRoleModal()"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm font-medium">
                                Change Role
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showRoleModal() {
                document.getElementById('roleModal').classList.remove('hidden');
            }

            function closeRoleModal() {
                document.getElementById('roleModal').classList.add('hidden');
            }

            // Close modal on ESC key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeRoleModal();
                }
            });

            // Close modal when clicking outside
            document.getElementById('roleModal').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeRoleModal();
                }
            });
        </script>
    @endpush
@endsection

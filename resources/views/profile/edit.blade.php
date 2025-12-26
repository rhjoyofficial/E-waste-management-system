@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Profile Settings</h2>
                <p class="text-gray-600">Update your personal information and password</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Profile Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Update Profile Form -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>

                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="space-y-4">
                                    <!-- Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                            Full Name *
                                        </label>
                                        <input type="text" name="name" id="name"
                                            value="{{ old('name', $user->name) }}" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                            Email Address *
                                        </label>
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email', $user->email) }}" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                            Phone Number
                                        </label>
                                        <input type="tel" name="phone" id="phone"
                                            value="{{ old('phone', $user->phone) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Address -->
                                    <div>
                                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                                            Address
                                        </label>
                                        <textarea name="address" id="address" rows="3"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('address', $user->address) }}</textarea>
                                        @error('address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="mt-6 flex justify-end">
                                    <button type="submit"
                                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Change Password Form -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Change Password</h3>

                            <form action="{{ route('profile.password') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="space-y-4">
                                    <!-- Current Password -->
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                                            Current Password *
                                        </label>
                                        <input type="password" name="current_password" id="current_password" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        @error('current_password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- New Password -->
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                            New Password *
                                        </label>
                                        <input type="password" name="password" id="password" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Confirm Password -->
                                    <div>
                                        <label for="password_confirmation"
                                            class="block text-sm font-medium text-gray-700 mb-1">
                                            Confirm New Password *
                                        </label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="mt-6 flex justify-end">
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Change Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Account Info -->
                <div class="space-y-6">
                    <!-- Account Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h3>

                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Member Since</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
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
                                    <label class="text-sm font-medium text-gray-500">Role</label>
                                    <p class="mt-1">
                                        @foreach ($user->roles as $role)
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ ucfirst($role->name) }}
                                            </span>
                                        @endforeach
                                    </p>
                                </div>

                                @if ($user->isUser())
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Total Requests</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $user->submittedRequests()->count() }}</p>
                                    </div>
                                @endif

                                @if ($user->isCollector())
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Assigned Pickups</label>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $user->assignedRequests()->where('status', 'assigned')->count() }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Account Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Actions</h3>

                            <div class="space-y-3">
                                @if ($user->isUser())
                                    <a href="{{ route('user.dashboard') }}"
                                        class="block text-center px-4 py-2 border border-green-300 text-green-700 rounded-md hover:bg-green-50 transition-colors">
                                        <i class="fas fa-tachometer-alt mr-2"></i>My Dashboard
                                    </a>
                                @endif

                                @if ($user->isCollector())
                                    <a href="{{ route('collector.dashboard') }}"
                                        class="block text-center px-4 py-2 border border-blue-300 text-blue-700 rounded-md hover:bg-blue-50 transition-colors">
                                        <i class="fas fa-truck mr-2"></i>Collector Dashboard
                                    </a>
                                @endif

                                @if ($user->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="block text-center px-4 py-2 border border-purple-300 text-purple-700 rounded-md hover:bg-purple-50 transition-colors">
                                        <i class="fas fa-cog mr-2"></i>Admin Dashboard
                                    </a>
                                @endif

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-center px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Security Tips -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <h4 class="text-sm font-semibold text-yellow-800 mb-2">
                            <i class="fas fa-shield-alt mr-2"></i>Security Tips
                        </h4>
                        <ul class="text-xs text-yellow-700 space-y-1 list-disc list-inside">
                            <li>Use a strong, unique password</li>
                            <li>Never share your password</li>
                            <li>Log out after each session</li>
                            <li>Keep your contact information updated</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

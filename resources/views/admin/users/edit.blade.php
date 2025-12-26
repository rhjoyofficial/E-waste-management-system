@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header -->
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Edit User: {{ $user->name }}</h2>
                        <p class="text-gray-600">Update user information and settings</p>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Basic Information -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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

                                    <!-- Status -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Account Status</label>
                                        <div class="mt-2 space-y-2">
                                            <div class="flex items-center">
                                                <input type="radio" name="is_active" id="active" value="1"
                                                    {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                                <label for="active" class="ml-3 block text-sm font-medium text-gray-700">
                                                    <span class="flex items-center">
                                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                                        Active
                                                    </span>
                                                    <span class="text-xs text-gray-500">User can login and use the
                                                        system</span>
                                                </label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="radio" name="is_active" id="inactive" value="0"
                                                    {{ !old('is_active', $user->is_active) ? 'checked' : '' }}
                                                    class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300">
                                                <label for="inactive" class="ml-3 block text-sm font-medium text-gray-700">
                                                    <span class="flex items-center">
                                                        <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                                        Inactive
                                                    </span>
                                                    <span class="text-xs text-gray-500">User cannot login to the
                                                        system</span>
                                                </label>
                                            </div>
                                        </div>
                                        @error('is_active')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
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

                            <!-- Current Role -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-2">Current Role</h4>
                                <div class="flex items-center space-x-2">
                                    @foreach ($user->roles as $role)
                                        <span
                                            class="px-3 py-1 text-sm font-semibold rounded-full 
                                        {{ $role->name == 'admin' ? 'bg-purple-100 text-purple-800' : '' }}
                                        {{ $role->name == 'collector' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $role->name == 'user' ? 'bg-blue-100 text-blue-800' : '' }}">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                    <a href="{{ route('admin.users.show', $user) }}"
                                        class="text-sm text-green-600 hover:text-green-800">
                                        Change Role →
                                    </a>
                                </div>
                            </div>

                            <!-- User Statistics -->
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="font-medium text-gray-900 mb-3">User Statistics</h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-500">Joined:</span>
                                        <span class="font-medium ml-2">{{ $user->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Last Login:</span>
                                        <span class="font-medium ml-2">
                                            @if ($user->last_login_at)
                                                {{ $user->last_login_at->format('M d, Y') }}
                                            @else
                                                Never
                                            @endif
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Requests:</span>
                                        <span class="font-medium ml-2">{{ $user->submittedRequests()->count() }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Pickups:</span>
                                        <span class="font-medium ml-2">{{ $user->assignedRequests()->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('admin.users.show', $user) }}"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

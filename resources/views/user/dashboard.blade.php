@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}!</h2>
                            <p class="text-gray-600 mt-1">Track your e-waste disposal requests here</p>
                        </div>
                        <a href="{{ route('user.requests.create') }}"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>New Request
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Requests -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <i class="fas fa-list text-white text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Requests</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $stats['total_requests'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <i class="fas fa-clock text-white text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $stats['pending_requests'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Approved -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <i class="fas fa-check-circle text-white text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Approved</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $stats['approved_requests'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Collected -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <i class="fas fa-truck text-white text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Collected</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $stats['collected_requests'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Requests -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Requests</h3>
                        <a href="{{ route('user.requests.index') }}" class="text-sm text-green-600 hover:text-green-800">
                            View All →
                        </a>
                    </div>

                    @if ($recentRequests->count() > 0)
                        <div class="space-y-4">
                            @foreach ($recentRequests as $request)
                                <div
                                    class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-150">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <span class="font-medium text-gray-900">#{{ $request->id }}</span>
                                            <span class="mx-2">•</span>
                                            <span class="text-gray-600">{{ $request->category->name }}</span>
                                        </div>
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $request->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $request->status === 'collected' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $request->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500 mb-2">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ Str::limit($request->pickup_address, 60) }}
                                    </p>
                                    <div class="flex items-center justify-between text-sm text-gray-400">
                                        <span>{{ $request->created_at->format('M d, Y • h:i A') }}</span>
                                        <a href="{{ route('user.requests.show', $request->id) }}"
                                            class="text-green-600 hover:text-green-800">
                                            View Details →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                            <h4 class="text-lg font-medium text-gray-700 mb-2">No requests yet</h4>
                            <p class="text-gray-500 mb-4">Start by submitting your first e-waste pickup request.</p>
                            <a href="{{ route('user.requests.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md font-medium">
                                <i class="fas fa-plus mr-2"></i>Submit Request
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Guide -->
            <div class="bg-gradient-to-r from-green-50 to-blue-50 border border-green-100 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">How to Submit a Request</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 bg-white rounded-full p-3 shadow-sm">
                            <i class="fas fa-list text-green-500"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-gray-900">1. Fill Details</h4>
                            <p class="text-sm text-gray-600 mt-1">Enter device type, condition, and pickup details</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 bg-white rounded-full p-3 shadow-sm">
                            <i class="fas fa-clock text-blue-500"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-gray-900">2. Wait for Approval</h4>
                            <p class="text-sm text-gray-600 mt-1">Admin will review and approve your request</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 bg-white rounded-full p-3 shadow-sm">
                            <i class="fas fa-truck text-purple-500"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-gray-900">3. Get Pickup</h4>
                            <p class="text-sm text-gray-600 mt-1">Collector will pick up at scheduled time</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

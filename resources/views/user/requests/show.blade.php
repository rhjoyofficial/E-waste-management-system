@extends('layouts.app')

@section('title', 'Request Details')

@section('content')
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Request #{{ $request->id }}</h2>
                    <p class="text-gray-600">Submitted on {{ $request->created_at->format('M d, Y') }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span
                        class="px-3 py-1 rounded-full text-sm font-medium 
                    @if ($request->status == 'pending') bg-yellow-100 text-yellow-800
                    @elseif($request->status == 'approved') bg-blue-100 text-blue-800
                    @elseif($request->status == 'assigned') bg-purple-100 text-purple-800
                    @elseif($request->status == 'collected') bg-green-100 text-green-800
                    @elseif($request->status == 'rejected') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($request->status) }}
                    </span>
                    <a href="{{ route('user.requests.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Back to List
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Request Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Status Progress -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Request Status</h3>
                            <div class="relative">
                                <!-- Progress Bar -->
                                <div class="flex items-center justify-between mb-2">
                                    @php
                                        $steps = ['pending', 'approved', 'assigned', 'collected', 'recycled'];
                                        $currentStep = array_search($request->status, $steps);
                                        $currentStep = $currentStep !== false ? $currentStep : 0;
                                    @endphp

                                    @foreach ($steps as $index => $step)
                                        <div class="flex flex-col items-center flex-1">
                                            <div
                                                class="w-8 h-8 rounded-full flex items-center justify-center 
                                            {{ $index <= $currentStep ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-500' }}
                                            {{ $index == $currentStep ? 'ring-4 ring-green-100' : '' }}">
                                                {{ $index + 1 }}
                                            </div>
                                            <span
                                                class="mt-2 text-xs font-medium {{ $index <= $currentStep ? 'text-green-600' : 'text-gray-500' }}">
                                                {{ ucfirst($step) }}
                                            </span>
                                        </div>

                                        @if ($index < count($steps) - 1)
                                            <div
                                                class="flex-1 h-1 {{ $index < $currentStep ? 'bg-green-600' : 'bg-gray-200' }}">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Request Details Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Request Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Category</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $request->category->name }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Device Condition</label>
                                    <p class="mt-1 text-sm text-gray-900 capitalize">{{ $request->device_condition }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Quantity</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $request->quantity }} item(s)</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Preferred Pickup Date</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $request->preferred_pickup_date ? $request->preferred_pickup_date->format('M d, Y') : 'Not specified' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pickup Address Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pickup Address</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-900 whitespace-pre-line">{{ $request->pickup_address }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- User Notes Card -->
                    @if ($request->user_note)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Notes</h3>
                                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $request->user_note }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Admin Remarks Card -->
                    @if ($request->admin_remark)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Admin Remarks</h3>
                                <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $request->admin_remark }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Collector Remarks Card -->
                    @if ($request->collector_remark)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Collector Remarks</h3>
                                <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
                                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $request->collector_remark }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column - Actions & Info -->
                <div class="space-y-6">
                    <!-- Collector Information Card -->
                    @if ($request->collector)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Assigned Collector</h3>
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Name</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $request->collector->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Assigned On</label>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $request->updated_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                    @if ($request->isAssigned() || $request->isCollected())
                                        <div class="pt-3 border-t border-gray-200">
                                            <p class="text-sm text-gray-600">
                                                <i class="fas fa-info-circle mr-2"></i>
                                                The collector will contact you for pickup details.
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Actions Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                            <div class="space-y-3">
                                @if ($request->isPending())
                                    <a href="{{ route('user.requests.edit', $request) }}"
                                        class="w-full block text-center px-4 py-2 border border-blue-300 text-blue-700 rounded-md hover:bg-blue-50 transition-colors">
                                        <i class="fas fa-edit mr-2"></i>Edit Request
                                    </a>
                                    <form action="{{ route('user.requests.destroy', $request) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to cancel this request?')"
                                            class="w-full px-4 py-2 border border-red-300 text-red-700 rounded-md hover:bg-red-50 transition-colors">
                                            <i class="fas fa-times mr-2"></i>Cancel Request
                                        </button>
                                    </form>
                                @elseif($request->isApproved())
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                        <span class="text-sm text-blue-700">
                                            Your request has been approved. A collector will be assigned soon.
                                        </span>
                                    </div>
                                @elseif($request->isAssigned())
                                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                        <i class="fas fa-truck text-purple-500 mr-2"></i>
                                        <span class="text-sm text-purple-700">
                                            Collector assigned. Expect pickup on scheduled date.
                                        </span>
                                    </div>
                                @elseif($request->isCollected())
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <span class="text-sm text-green-700">
                                            Items collected successfully. Thank you for recycling!
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Status History Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status History</h3>
                            <div class="space-y-3">
                                @forelse($request->statusLogs->sortByDesc('created_at') as $log)
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0 mt-1">
                                            <div
                                                class="w-2 h-2 rounded-full 
                                            @if ($log->status == 'pending') bg-yellow-400
                                            @elseif($log->status == 'approved') bg-blue-400
                                            @elseif($log->status == 'assigned') bg-purple-400
                                            @elseif($log->status == 'collected') bg-green-400
                                            @elseif($log->status == 'rejected') bg-red-400
                                            @else bg-gray-400 @endif">
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between">
                                                <span class="text-sm font-medium text-gray-900">
                                                    {{ ucfirst($log->status) }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    {{ $log->created_at->format('M d, h:i A') }}
                                                </span>
                                            </div>
                                            @if ($log->remarks)
                                                <p class="text-xs text-gray-600 mt-1">{{ $log->remarks }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 text-center py-2">No status history available</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

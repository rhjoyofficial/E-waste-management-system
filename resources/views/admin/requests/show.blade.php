@extends('layouts.app')

@section('title', 'Request Details')

@section('content')
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Request #{{ $ewaste_request->id }}</h2>
                    <p class="text-gray-600">Submitted by {{ $ewaste_request->user->name }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span
                        class="px-3 py-1 rounded-full text-sm font-medium 
                    @if ($ewaste_request->status == 'pending') bg-yellow-100 text-yellow-800
                    @elseif($ewaste_request->status == 'approved') bg-blue-100 text-blue-800
                    @elseif($ewaste_request->status == 'assigned') bg-purple-100 text-purple-800
                    @elseif($ewaste_request->status == 'collected') bg-green-100 text-green-800
                    @elseif($ewaste_request->status == 'rejected') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($ewaste_request->status) }}
                    </span>
                    <a href="{{ route('admin.requests.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Back to List
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Request Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Request Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Category</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $ewaste_request->category->name }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Device Condition</label>
                                    <p class="mt-1 text-sm text-gray-900 capitalize">{{ $ewaste_request->device_condition }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Quantity</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $ewaste_request->quantity }} item(s)</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Preferred Pickup Date</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $ewaste_request->preferred_pickup_date ? $ewaste_request->preferred_pickup_date->format('M d, Y') : 'Not specified' }}
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
                                <p class="text-sm text-gray-900 whitespace-pre-line">{{ $ewaste_request->pickup_address }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- User Notes Card -->
                    @if ($ewaste_request->user_note)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">User Notes</h3>
                                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $ewaste_request->user_note }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Admin Remarks Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Admin Remarks</h3>
                            <form action="{{ route('admin.requests.remark', $ewaste_request) }}" method="POST">
                                @csrf
                                <textarea name="admin_remark" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('admin_remark', $ewaste_request->admin_remark) }}</textarea>
                                <div class="mt-3 flex justify-end">
                                    <button type="submit"
                                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm font-medium">
                                        Update Remarks
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Status History Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status History</h3>
                            <div class="space-y-4">
                                @forelse($ewaste_request->statusLogs->sortByDesc('created_at') as $log)
                                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                <i class="fas fa-history text-blue-600 text-sm"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between">
                                                <span class="text-sm font-medium text-gray-900">
                                                    {{ ucfirst($log->status) }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    {{ $log->created_at->format('M d, Y h:i A') }}
                                                </span>
                                            </div>
                                            @if ($log->remarks)
                                                <p class="text-sm text-gray-600 mt-1">{{ $log->remarks }}</p>
                                            @endif
                                            @if ($log->changedBy)
                                                <p class="text-xs text-gray-500 mt-1">
                                                    By: {{ $log->changedBy->name }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 text-center py-4">No status history available</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Actions & Info -->
                <div class="space-y-6">
                    <!-- User Information Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">User Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Name</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $ewaste_request->user->name }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Email</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $ewaste_request->user->email }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Total Requests</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $ewaste_request->user->submittedRequests()->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Collector Assignment Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                @if ($ewaste_request->collector)
                                    Assigned Collector
                                @else
                                    Assign Collector
                                @endif
                            </h3>

                            @if ($ewaste_request->collector)
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Name</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $ewaste_request->collector->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Email</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $ewaste_request->collector->email }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Assigned On</label>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $ewaste_request->updated_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                            @elseif($ewaste_request->isApproved())
                                <form action="{{ route('admin.requests.assign', $ewaste_request) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Select Collector</label>
                                        <select name="collector_id" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                            <option value="">Choose a collector</option>
                                            @foreach ($collectors as $collector)
                                                <option value="{{ $collector->id }}">{{ $collector->name }}
                                                    ({{ $collector->assignedRequests()->where('status', 'assigned')->count() }}
                                                    assigned)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit"
                                        class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm font-medium">
                                        Assign Collector
                                    </button>
                                </form>
                            @else
                                <p class="text-sm text-gray-500 text-center py-4">
                                    Request must be approved before assigning a collector
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Status Actions Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Status</h3>
                            <form action="{{ route('admin.requests.status', $ewaste_request) }}" method="POST">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">New Status</label>
                                        <select name="status"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                            <option value="pending"
                                                {{ $ewaste_request->status == 'pending' ? 'selected disabled' : '' }}>
                                                Pending</option>
                                            <option value="approved"
                                                {{ $ewaste_request->status == 'approved' ? 'selected disabled' : '' }}>
                                                Approved</option>
                                            <option value="rejected"
                                                {{ $ewaste_request->status == 'rejected' ? 'selected disabled' : '' }}>
                                                Rejected</option>
                                            <option value="collected"
                                                {{ $ewaste_request->status == 'collected' ? 'selected disabled' : '' }}>
                                                Collected</option>
                                            <option value="recycled"
                                                {{ $ewaste_request->status == 'recycled' ? 'selected disabled' : '' }}>
                                                Recycled</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Remarks
                                            (Optional)</label>
                                        <textarea name="remarks" rows="2" placeholder="Add remarks for status change..."
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"></textarea>
                                    </div>
                                    <button type="submit"
                                        class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm font-medium">
                                        Update Status
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Request Meta Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Request Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Request ID</label>
                                    <p class="mt-1 text-sm text-gray-900">#{{ $ewaste_request->id }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Submitted On</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $ewaste_request->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Last Updated</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $ewaste_request->updated_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

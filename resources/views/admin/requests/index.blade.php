@extends('layouts.app')

@section('title', 'Manage Requests')

@section('content')
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">E-Waste Requests</h2>
                <p class="text-gray-600">Manage all pickup requests</p>
            </div>

            <!-- Stats Tabs -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3 mb-6">
                @foreach ($statusCounts as $status => $count)
                    <a href="{{ route('admin.requests.index', ['status' => $status]) }}"
                        class="bg-white rounded-lg shadow-sm p-4 text-center hover:shadow-md transition-shadow {{ request('status', 'all') == $status ? 'ring-2 ring-green-500' : '' }}">
                        <div class="text-2xl font-bold text-gray-900">{{ $count }}</div>
                        <div class="text-sm font-medium text-gray-500 capitalize">{{ $status }}</div>
                    </a>
                @endforeach
            </div>

            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" action="{{ route('admin.requests.index') }}"
                        class="space-y-4 md:space-y-0 md:flex md:space-x-4">
                        <!-- Status Filter -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status
                                </option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                                </option>
                                <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>Assigned
                                </option>
                                <option value="collected" {{ request('status') == 'collected' ? 'selected' : '' }}>Collected
                                </option>
                                <option value="recycled" {{ request('status') == 'recycled' ? 'selected' : '' }}>Recycled
                                </option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>
                        </div>

                        <!-- Category Filter -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="all">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date From -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        </div>

                        <!-- Date To -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        </div>

                        <!-- Filter Buttons -->
                        <div class="flex items-end space-x-2">
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm font-medium">
                                Filter
                            </button>
                            <a href="{{ route('admin.requests.index') }}"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Requests Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($requests->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            User</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Category</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pickup Date</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Created</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($requests as $request)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #{{ $request->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $request->user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">{{ $request->user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $request->category->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $request->preferred_pickup_date ? $request->preferred_pickup_date->format('M d, Y') : 'Not set' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'yellow',
                                                        'approved' => 'blue',
                                                        'assigned' => 'purple',
                                                        'collected' => 'green',
                                                        'recycled' => 'gray',
                                                        'rejected' => 'red',
                                                    ];
                                                    $color = $statusColors[$request->status] ?? 'gray';
                                                @endphp
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $request->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.requests.show', $request) }}"
                                                    class="text-green-600 hover:text-green-900 mr-3">
                                                    View
                                                </a>
                                                @if ($request->isPending())
                                                    <form action="{{ route('admin.requests.status', $request) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="text-blue-600 hover:text-blue-900">
                                                            Approve
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $requests->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                            <h4 class="text-lg font-medium text-gray-700 mb-2">No requests found</h4>
                            <p class="text-gray-500">No e-waste requests match your filters.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

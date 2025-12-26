@extends('layouts.app')

@section('title', 'My Requests')

@section('content')
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">My E-Waste Requests</h2>
                    <p class="text-gray-600">Track your pickup requests</p>
                </div>
                <a href="{{ route('user.requests.create') }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium">
                    <i class="fas fa-plus mr-2"></i>New Request
                </a>
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
                                            Category</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Condition</th>
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $request->category->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">
                                                {{ $request->device_condition }}
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <a href="{{ route('user.requests.show', $request) }}"
                                                    class="text-green-600 hover:text-green-900">
                                                    View
                                                </a>
                                                @if ($request->isPending())
                                                    <a href="{{ route('user.requests.edit', $request) }}"
                                                        class="text-blue-600 hover:text-blue-900">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('user.requests.destroy', $request) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            onclick="return confirm('Are you sure you want to cancel this request?')"
                                                            class="text-red-600 hover:text-red-900">
                                                            Cancel
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
        </div>
    </div>
@endsection

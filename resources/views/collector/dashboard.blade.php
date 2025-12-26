@extends('layouts.app')

@section('title', 'Collector Dashboard')

@section('content')
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Welcome, {{ auth()->user()->name }}!</h2>
                            <p class="text-gray-600 mt-1">Here's your daily pickup overview</p>
                        </div>
                        <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg">
                            <i class="fas fa-truck mr-2"></i>
                            Collector
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Pickups -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Today's Pickups</h3>
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                        {{ $todaysPickups->count() }} scheduled
                    </span>
                </div>

                @if ($todaysPickups->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($todaysPickups as $pickup)
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">
                                            {{ $pickup->category->name }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            #{{ $pickup->id }}
                                        </span>
                                    </div>

                                    <h4 class="font-medium text-gray-900 mb-2">{{ $pickup->user->name }}</h4>
                                    <p class="text-sm text-gray-600 mb-3">
                                        <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                                        {{ Str::limit($pickup->pickup_address, 50) }}
                                    </p>

                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500">
                                            <i class="far fa-clock mr-1"></i>
                                            {{ $pickup->preferred_pickup_date->format('h:i A') }}
                                        </span>
                                        <span class="font-medium text-green-600">
                                            {{ $pickup->quantity }} item(s)
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-8 text-center">
                            <i class="fas fa-calendar-check text-4xl text-gray-300 mb-4"></i>
                            <h4 class="text-lg font-medium text-gray-700 mb-2">No pickups scheduled for today</h4>
                            <p class="text-gray-500">Check your assigned requests for upcoming pickups.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Assigned Requests -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Assigned Requests</h3>
                    @if ($assignedRequests->count() > 0)
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
                                            Address</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pickup Date</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($assignedRequests as $request)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #{{ $request->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $request->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ Str::limit($request->pickup_address, 30) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $request->preferred_pickup_date ? $request->preferred_pickup_date->format('M d, Y') : 'Not set' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $request->status === 'assigned' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if ($request->status === 'assigned')
                                                    <form action="{{ route('collector.requests.collect', $request->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-3 py-1 rounded text-sm">
                                                            Mark Collected
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-400">Completed</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                            <h4 class="text-lg font-medium text-gray-700 mb-2">No assigned requests</h4>
                            <p class="text-gray-500">You haven't been assigned any requests yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

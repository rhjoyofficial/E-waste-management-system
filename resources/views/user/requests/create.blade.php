@extends('layouts.app')

@section('title', 'New Request')

@section('content')
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header -->
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">New Pickup Request</h2>
                        <p class="text-gray-600">Submit a request for e-waste collection</p>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('user.requests.store') }}" method="POST">
                        @csrf

                        <div class="space-y-6">
                            <!-- Device Category -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Device Category *
                                </label>
                                <select name="category_id" id="category_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="">Select a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Device Condition -->
                            <div>
                                <label for="device_condition" class="block text-sm font-medium text-gray-700 mb-1">
                                    Device Condition *
                                </label>
                                <select name="device_condition" id="device_condition" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="">Select condition</option>
                                    @foreach ($deviceConditions as $condition)
                                        <option value="{{ $condition }}"
                                            {{ old('device_condition') == $condition ? 'selected' : '' }}>
                                            {{ ucfirst($condition) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('device_condition')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">
                                    Quantity *
                                </label>
                                <input type="number" name="quantity" id="quantity" min="1" max="100"
                                    value="{{ old('quantity', 1) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                @error('quantity')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Pickup Address -->
                            <div>
                                <label for="pickup_address" class="block text-sm font-medium text-gray-700 mb-1">
                                    Pickup Address *
                                </label>
                                <textarea name="pickup_address" id="pickup_address" rows="4" required
                                    placeholder="Enter complete address including landmarks..."
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('pickup_address') }}</textarea>
                                @error('pickup_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Preferred Pickup Date -->
                            <div>
                                <label for="preferred_pickup_date" class="block text-sm font-medium text-gray-700 mb-1">
                                    Preferred Pickup Date
                                </label>
                                <input type="date" name="preferred_pickup_date" id="preferred_pickup_date"
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    value="{{ old('preferred_pickup_date') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <p class="mt-1 text-sm text-gray-500">Leave empty for no preference</p>
                                @error('preferred_pickup_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Additional Notes -->
                            <div>
                                <label for="user_note" class="block text-sm font-medium text-gray-700 mb-1">
                                    Additional Notes (Optional)
                                </label>
                                <textarea name="user_note" id="user_note" rows="3"
                                    placeholder="Any special instructions or additional information..."
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('user_note') }}</textarea>
                                @error('user_note')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('user.requests.index') }}"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Submit Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Add Category')

@section('content')
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header -->
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Add New Category</h2>
                        <p class="text-gray-600">Create a new device category for e-waste</p>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf

                        <div class="space-y-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Category Name *
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                    Description
                                </label>
                                <textarea name="description" id="description" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active"
                                    {{ old('is_active', true) ? 'checked' : '' }}
                                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                    Active (Category will be available for selection)
                                </label>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('admin.categories.index') }}"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

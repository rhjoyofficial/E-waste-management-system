@extends('layouts.app')

@section('title', 'Manage Categories')

@section('content')
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Device Categories</h2>
                    <p class="text-gray-600">Manage e-waste device categories</p>
                </div>
                <a href="{{ route('admin.categories.create') }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium">
                    <i class="fas fa-plus mr-2"></i>Add Category
                </a>
            </div>

            <!-- Categories Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($categories->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Description</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Requests</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($categories as $category)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                #{{ $category->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="font-medium text-gray-900">{{ $category->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $category->slug }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $category->description ? Str::limit($category->description, 50) : 'No description' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $category->ewasteRequests()->count() }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <form action="{{ route('admin.categories.toggle-status', $category) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="text-{{ $category->is_active ? 'yellow' : 'green' }}-600 hover:text-{{ $category->is_active ? 'yellow' : 'green' }}-900">
                                                        {{ $category->is_active ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                                </form>
                                                <a href="{{ route('admin.categories.edit', $category) }}"
                                                    class="text-blue-600 hover:text-blue-900">Edit</a>
                                                <form action="{{ route('admin.categories.destroy', $category) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure you want to delete this category?')"
                                                        class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $categories->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-tags text-4xl text-gray-300 mb-4"></i>
                            <h4 class="text-lg font-medium text-gray-700 mb-2">No categories found</h4>
                            <p class="text-gray-500 mb-4">Start by adding your first device category.</p>
                            <a href="{{ route('admin.categories.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md font-medium">
                                <i class="fas fa-plus mr-2"></i>Add Category
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

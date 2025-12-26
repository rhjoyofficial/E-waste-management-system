@extends('layouts.app')

@section('title', 'My Pickups')

@section('content')
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">My Pickup Requests</h2>
                <p class="text-gray-600">Manage your assigned e-waste pickups</p>
            </div>

            <!-- Requests Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
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
                                            Category</th>
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
                                                {{ Str::limit($request->pickup_address, 30) }}
                                            </td>
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
                                                <button onclick="showRequestDetails({{ $request->id }})"
                                                    class="text-green-600 hover:text-green-900 mr-3">
                                                    View
                                                </button>
                                                @if ($request->isAssigned())
                                                    <button onclick="showCollectModal({{ $request->id }})"
                                                        class="text-blue-600 hover:text-blue-900">
                                                        Mark Collected
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $assignedRequests->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                            <h4 class="text-lg font-medium text-gray-700 mb-2">No assigned requests</h4>
                            <p class="text-gray-500">You haven't been assigned any pickup requests yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Request Details Modal -->
    <div id="requestDetailsModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
                <div class="p-6">
                    <!-- Modal header -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-900">Request Details</h3>
                        <button onclick="closeRequestDetails()" class="text-gray-400 hover:text-gray-500">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <!-- Content will be loaded via AJAX -->
                    <div id="requestDetailsContent"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Collect Modal -->
    <div id="collectModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
                <form id="collectForm" method="POST">
                    @csrf
                    <div class="p-6">
                        <!-- Modal header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Mark as Collected</h3>
                            <button type="button" onclick="closeCollectModal()" class="text-gray-400 hover:text-gray-500">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <!-- Form content -->
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-3">Are you sure you have collected the items?</p>
                            <label for="collector_remark" class="block text-sm font-medium text-gray-700 mb-1">
                                Remarks (Optional)
                            </label>
                            <textarea name="collector_remark" id="collector_remark" rows="3"
                                placeholder="Add any remarks about the collection..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"></textarea>
                        </div>

                        <!-- Modal footer -->
                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="closeCollectModal()"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm font-medium">
                                Mark Collected
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let currentRequestId = null;

            function showRequestDetails(requestId) {
                currentRequestId = requestId;

                // Show loading
                document.getElementById('requestDetailsContent').innerHTML = `
            <div class="text-center py-8">
                <i class="fas fa-spinner fa-spin text-2xl text-gray-400"></i>
                <p class="mt-2 text-gray-500">Loading details...</p>
            </div>
        `;

                // Show modal
                document.getElementById('requestDetailsModal').classList.remove('hidden');

                // Fetch request details
                fetch(`/collector/requests/${requestId}/details`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('requestDetailsContent').innerHTML = `
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500">User</label>
                                <p class="mt-1 text-sm text-gray-900">${data.user.name}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Contact</label>
                                <p class="mt-1 text-sm text-gray-900">${data.user.email}</p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-500">Category</label>
                            <p class="mt-1 text-sm text-gray-900">${data.category.name}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-500">Device Condition</label>
                            <p class="mt-1 text-sm text-gray-900 capitalize">${data.device_condition}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-500">Quantity</label>
                            <p class="mt-1 text-sm text-gray-900">${data.quantity} item(s)</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-500">Pickup Address</label>
                            <div class="mt-1 p-3 bg-gray-50 rounded">
                                <p class="text-sm text-gray-900 whitespace-pre-line">${data.pickup_address}</p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-500">Preferred Pickup Date</label>
                            <p class="mt-1 text-sm text-gray-900">${data.preferred_pickup_date || 'Not specified'}</p>
                        </div>
                        
                        ${data.user_note ? `
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">User Notes</label>
                                        <div class="mt-1 p-3 bg-blue-50 rounded border border-blue-100">
                                            <p class="text-sm text-gray-700">${data.user_note}</p>
                                        </div>
                                    </div>
                                ` : ''}
                    </div>
                `;
                    })
                    .catch(error => {
                        document.getElementById('requestDetailsContent').innerHTML = `
                    <div class="text-center py-8">
                        <i class="fas fa-exclamation-triangle text-2xl text-red-400"></i>
                        <p class="mt-2 text-gray-500">Failed to load details. Please try again.</p>
                    </div>
                `;
                    });
            }

            function closeRequestDetails() {
                document.getElementById('requestDetailsModal').classList.add('hidden');
                currentRequestId = null;
            }

            function showCollectModal(requestId) {
                currentRequestId = requestId;
                document.getElementById('collectForm').action = `/collector/requests/${requestId}/collect`;
                document.getElementById('collectModal').classList.remove('hidden');
            }

            function closeCollectModal() {
                document.getElementById('collectModal').classList.add('hidden');
                currentRequestId = null;
            }

            // Close modals on ESC key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeRequestDetails();
                    closeCollectModal();
                }
            });

            // Close modals when clicking outside
            document.getElementById('requestDetailsModal').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeRequestDetails();
                }
            });

            document.getElementById('collectModal').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeCollectModal();
                }
            });
        </script>
    @endpush
@endsection

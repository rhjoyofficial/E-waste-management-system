@extends('layouts.app')

@section('title', 'E-Waste Awareness')

@section('content')
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg mb-8 overflow-hidden">
                <div class="px-6 py-12 md:px-12 text-white">
                    <div class="max-w-3xl">
                        <h1 class="text-3xl md:text-4xl font-bold mb-4">E-Waste Awareness & Guidelines</h1>
                        <p class="text-lg md:text-xl opacity-90">Learn how to properly dispose of electronic waste and
                            protect our environment</p>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="space-y-8">
                <!-- What is E-Waste? -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 p-3 rounded-lg mr-4">
                                <i class="fas fa-recycle text-green-600 text-2xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">What is E-Waste?</h2>
                        </div>
                        <div class="prose max-w-none">
                            <p class="text-gray-600 mb-4">
                                Electronic waste (e-waste) refers to discarded electrical or electronic devices.
                                Used electronics which are destined for refurbishment, reuse, resale, salvage recycling
                                through material recovery, or disposal are also considered e-waste.
                            </p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <h4 class="font-semibold text-green-800 mb-2">Common E-Waste Items:</h4>
                                    <ul class="text-sm text-gray-700 space-y-1">
                                        <li><i class="fas fa-mobile-alt text-green-500 mr-2"></i>Mobile phones & tablets
                                        </li>
                                        <li><i class="fas fa-laptop text-green-500 mr-2"></i>Laptops & computers</li>
                                        <li><i class="fas fa-tv text-green-500 mr-2"></i>Televisions & monitors</li>
                                        <li><i class="fas fa-battery-full text-green-500 mr-2"></i>Batteries & chargers</li>
                                        <li><i class="fas fa-print text-green-500 mr-2"></i>Printers & scanners</li>
                                        <li><i class="fas fa-headphones text-green-500 mr-2"></i>Audio equipment</li>
                                    </ul>
                                </div>
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h4 class="font-semibold text-blue-800 mb-2">Why Recycle E-Waste?</h4>
                                    <ul class="text-sm text-gray-700 space-y-1">
                                        <li><i class="fas fa-shield-alt text-blue-500 mr-2"></i>Prevents toxic materials
                                            from landfills</li>
                                        <li><i class="fas fa-leaf text-blue-500 mr-2"></i>Conserves natural resources</li>
                                        <li><i class="fas fa-bolt text-blue-500 mr-2"></i>Saves energy in production</li>
                                        <li><i class="fas fa-heart text-blue-500 mr-2"></i>Protects human health</li>
                                        <li><i class="fas fa-industry text-blue-500 mr-2"></i>Creates green jobs</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Proper Disposal Guidelines -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                <i class="fas fa-book text-blue-600 text-2xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Proper Disposal Guidelines</h2>
                        </div>

                        <div class="space-y-6">
                            <!-- Step 1 -->
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center font-bold">
                                        1
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Data Security First</h4>
                                    <p class="text-gray-600">
                                        Before disposing of any device, ensure all personal data is completely erased.
                                        Perform factory reset and remove all storage media.
                                    </p>
                                    <div class="mt-2 text-sm text-gray-500">
                                        <i class="fas fa-exclamation-triangle text-yellow-500 mr-1"></i>
                                        Important: Backup important data before wiping
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center font-bold">
                                        2
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Device Condition Assessment</h4>
                                    <p class="text-gray-600">
                                        Assess the condition of your device. Let us know if it's working, damaged, or
                                        completely dead.
                                        This helps in proper sorting and recycling.
                                    </p>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center font-bold">
                                        3
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Schedule Pickup</h4>
                                    <p class="text-gray-600">
                                        Use our pickup request system to schedule collection at your convenience.
                                        Provide accurate address details and preferred pickup time.
                                    </p>
                                </div>
                            </div>

                            <!-- Step 4 -->
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center font-bold">
                                        4
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Prepare for Collection</h4>
                                    <p class="text-gray-600">
                                        Package your devices securely. Include all cables and accessories.
                                        Keep them ready for the collector's visit.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Do's and Don'ts -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Do's -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-green-100 p-3 rounded-lg mr-4">
                                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900">Do's</h2>
                            </div>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                                    <span class="text-gray-700">Do erase all personal data from devices</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                                    <span class="text-gray-700">Do keep devices in original packaging if possible</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                                    <span class="text-gray-700">Do include all cables and accessories</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                                    <span class="text-gray-700">Do schedule pickups during working hours</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                                    <span class="text-gray-700">Do provide accurate pickup address details</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                                    <span class="text-gray-700">Do separate batteries from devices if possible</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Don'ts -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-red-100 p-3 rounded-lg mr-4">
                                    <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900">Don'ts</h2>
                            </div>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <i class="fas fa-times text-red-500 mt-1 mr-3"></i>
                                    <span class="text-gray-700">Don't throw e-waste in regular trash</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-times text-red-500 mt-1 mr-3"></i>
                                    <span class="text-gray-700">Don't attempt to dismantle devices yourself</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-times text-red-500 mt-1 mr-3"></i>
                                    <span class="text-gray-700">Don't include non-electronic waste</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-times text-red-500 mt-1 mr-3"></i>
                                    <span class="text-gray-700">Don't forget to remove SIM cards and memory cards</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-times text-red-500 mt-1 mr-3"></i>
                                    <span class="text-gray-700">Don't dispose of leaking or damaged batteries</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-times text-red-500 mt-1 mr-3"></i>
                                    <span class="text-gray-700">Don't mix different types of e-waste together</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Environmental Impact -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 p-3 rounded-lg mr-4">
                                <i class="fas fa-globe-americas text-green-600 text-2xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Environmental Impact</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Card 1 -->
                            <div class="bg-green-50 p-6 rounded-lg border border-green-100">
                                <div class="text-center mb-4">
                                    <i class="fas fa-leaf text-green-500 text-3xl"></i>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 text-center mb-2">Resource Conservation</h4>
                                <p class="text-gray-600 text-center text-sm">
                                    Recycling 1 million laptops saves energy equivalent to electricity used by 3,500 homes
                                    in a year
                                </p>
                            </div>

                            <!-- Card 2 -->
                            <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                                <div class="text-center mb-4">
                                    <i class="fas fa-tint text-blue-500 text-3xl"></i>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 text-center mb-2">Water Protection</h4>
                                <p class="text-gray-600 text-center text-sm">
                                    Proper e-waste disposal prevents heavy metals from contaminating water sources
                                </p>
                            </div>

                            <!-- Card 3 -->
                            <div class="bg-purple-50 p-6 rounded-lg border border-purple-100">
                                <div class="text-center mb-4">
                                    <i class="fas fa-cloud text-purple-500 text-3xl"></i>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 text-center mb-2">Air Quality</h4>
                                <p class="text-gray-600 text-center text-sm">
                                    Reduces greenhouse gas emissions by decreasing the need for raw material extraction
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="bg-gradient-to-r from-green-400 to-green-500 rounded-lg shadow-lg overflow-hidden">
                    <div class="px-6 py-8 md:px-12 text-white text-center">
                        <h3 class="text-2xl font-bold mb-4">Ready to Dispose Your E-Waste Responsibly?</h3>
                        <p class="text-lg mb-6 opacity-90">Join thousands of responsible citizens in protecting our
                            environment</p>
                        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                            <a href="{{ route('user.requests.create') }}"
                                class="bg-white text-green-600 hover:bg-green-50 px-6 py-3 rounded-lg font-semibold transition-colors duration-200">
                                <i class="fas fa-plus mr-2"></i>Schedule Pickup
                            </a>
                            <a href="{{ route('user.dashboard') }}"
                                class="bg-transparent border-2 border-white hover:bg-white/10 px-6 py-3 rounded-lg font-semibold transition-colors duration-200">
                                <i class="fas fa-tachometer-alt mr-2"></i>View Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

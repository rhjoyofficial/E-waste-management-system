<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <title>
        @hasSection('title')
            @yield('title') - {{ config('app.name', 'WMS') }}
        @else
            {{ config('app.name', 'WMS') }}
        @endif
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- Logo -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-4">
            <a href="{{ url('/') }}" class="flex justify-center">
                <div class="flex flex-col items-center space-y-2">
                    <img src="{{ asset('images/recycle.png') }}" alt="E-Waste Logo" class="h-20 w-20 object-cover">
                    <span class="text-2xl font-bold text-gray-800 text-center">E-Waste Management</span>
                </div>
            </a>
        </div>

        <!-- Card Container -->
        <div class="w-full sm:max-w-lg mt-2 px-6 py-4">
            <!-- Authentication Card -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Card Header -->
                @hasSection('card-header')
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 text-center">
                            @yield('card-header')
                        </h2>
                    </div>
                @endif

                <!-- Card Content -->
                <div class="px-6 py-8">
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600">
                                {{ __('Whoops! Something went wrong.') }}
                            </div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Main Content -->
                    @yield('content')
                </div>

                <!-- Card Footer -->
                @hasSection('card-footer')
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        <div class="text-center text-sm text-gray-600">
                            @yield('card-footer')
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Back to Home -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 text-center">
            <a href="{{ url('/') }}"
                class="text-sm text-gray-600 hover:text-green-600 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Home
            </a>
        </div>
    </div>

    @stack('scripts')
</body>

</html>

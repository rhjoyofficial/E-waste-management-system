<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <div class="min-h-screen">
        <!-- Navigation for authenticated users -->
        @auth
            @include('layouts.navigation')
        @endauth

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <!-- Flash Messages -->
        @if (session('success') || session('error') || session('status'))
            <div class="fixed bottom-4 right-4 z-50">
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg shadow-lg mb-2">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg shadow-lg mb-2">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('status'))
                    <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg shadow-lg mb-2">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                            <span>{{ session('status') }}</span>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
    
    <!-- Flash System Initialization -->
    <script>
        // Handle any queued flash messages
        document.addEventListener('DOMContentLoaded', function() {
            if (window.queuedFlashMessages && window.queuedFlashMessages.length > 0) {
                setTimeout(() => {
                    if (window.flashSystem && window.flashSystem.add) {
                        window.queuedFlashMessages.forEach(msg => {
                            window.flashSystem.add(msg);
                        });
                        window.queuedFlashMessages = [];
                    }
                }, 500);
            }
        });
    </script>
    <!-- Scripts -->
    @stack('scripts')
</body>

</html>

<nav class="bg-green-600 shadow-lg">
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-white font-bold text-xl">
                        <i class="fas fa-recycle mr-2"></i>E-Waste Admin
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'border-green-300 text-white' : 'border-transparent text-green-100 hover:text-white' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.requests.index') }}"
                        class="{{ request()->routeIs('admin.requests.*') ? 'border-green-300 text-white' : 'border-transparent text-green-100 hover:text-white' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        <i class="fas fa-list mr-2"></i>Requests
                    </a>
                    <a href="{{ route('admin.categories.index') }}"
                        class="{{ request()->routeIs('admin.categories.*') ? 'border-green-300 text-white' : 'border-transparent text-green-100 hover:text-white' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        <i class="fas fa-tags mr-2"></i>Categories
                    </a>
                    <!-- user management link -->
                    <a href="{{ route('admin.users.index') }}"
                        class="{{ request()->routeIs('admin.users.*') ? 'border-green-300 text-white' : 'border-transparent text-green-100 hover:text-white' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        <i class="fas fa-users mr-2"></i>Users
                    </a>

                </div>
            </div>

            <!-- User Menu -->
            <div class="flex items-center">
                <div class="ml-3 relative">
                    <div class="flex items-center space-x-4">
                        <span class="text-green-100 text-sm">{{ auth()->user()->name }}</span>

                        <!-- Settings Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center text-green-100 hover:text-white focus:outline-none">
                                <i class="fas fa-user-circle text-xl"></i>
                                <i class="fas fa-chevron-down ml-1 text-xs"></i>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10">
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Mirvan Properties - Premium Real Estate')</title>
    <meta name="description"
        content="@yield('meta_description', 'Discover exceptional commercial and residential properties with Mirvan Properties. Your gateway to premium real estate investments.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- HTMX -->
    <script src="https://unpkg.com/htmx.org@1.9.9"></script>

    @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg sticky top-0 z-50" x-data="{ open: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo and Primary Navigation -->
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="flex items-center">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">MP</span>
                                </div>
                                <span class="text-xl font-bold text-gray-900">Mirvan Properties</span>
                            </a>
                        </div>

                        <!-- Primary Navigation Links -->
                        <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                            <a href="{{ route('home') }}"
                                class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('home') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                                Home
                            </a>
                            <a href="{{ route('properties.index') }}"
                                class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('properties.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                                Properties
                            </a>
                            <a href="{{ route('blog.index') }}"
                                class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('blog.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                                Blog
                            </a>
                            <a href="{{ route('about') }}"
                                class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('about') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                                About
                            </a>
                            <a href="{{ route('contact') }}"
                                class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('contact') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                                Contact
                            </a>
                        </div>
                    </div>

                    <!-- Right side navigation -->
                    <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">
                        @auth
                            <!-- Authenticated User Menu -->
                            <div class="relative" x-data="{ userMenuOpen: false }">
                                <button @click="userMenuOpen = !userMenuOpen"
                                    class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="userMenuOpen" @click.outside="userMenuOpen = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                    <a href="{{ route('submissions.index') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Submissions</a>
                                    <a href="{{ route('profile.edit') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                    @if(Auth::user()->is_admin)
                                        <div class="border-t border-gray-100"></div>
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Panel</a>
                                    @endif
                                    <div class="border-t border-gray-100"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- Guest Links -->
                            <a href="{{ route('login') }}"
                                class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                                Login
                            </a>
                            <a href="{{ route('register') }}"
                                class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Register
                            </a>
                        @endauth

                        <!-- List Property Button -->
                        <a href="{{ route('submissions.create') }}"
                            class="bg-gradient-to-r from-blue-600 to-purple-600 text-white hover:from-blue-700 hover:to-purple-700 px-4 py-2 rounded-md text-sm font-medium transition-all">
                            List Property
                        </a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="sm:hidden flex items-center">
                        <button @click="open = !open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1 bg-white border-t border-gray-200">
                    <a href="{{ route('home') }}"
                        class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50 border-r-4 border-blue-600' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        Home
                    </a>
                    <a href="{{ route('properties.index') }}"
                        class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('properties.*') ? 'text-blue-600 bg-blue-50 border-r-4 border-blue-600' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        Properties
                    </a>
                    <a href="{{ route('blog.index') }}"
                        class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('blog.*') ? 'text-blue-600 bg-blue-50 border-r-4 border-blue-600' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        Blog
                    </a>
                    <a href="{{ route('about') }}"
                        class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('about') ? 'text-blue-600 bg-blue-50 border-r-4 border-blue-600' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        About
                    </a>
                    <a href="{{ route('contact') }}"
                        class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('contact') ? 'text-blue-600 bg-blue-50 border-r-4 border-blue-600' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        Contact
                    </a>
                </div>

                <!-- Mobile User Menu -->
                <div class="pt-4 pb-3 border-t border-gray-200">
                    @auth
                        <div class="px-4">
                            <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="mt-3 space-y-1">
                            <a href="{{ route('dashboard') }}"
                                class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                Dashboard
                            </a>
                            <a href="{{ route('submissions.index') }}"
                                class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                My Submissions
                            </a>
                            @if(Auth::user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                    Admin Panel
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="space-y-1">
                            <a href="{{ route('login') }}"
                                class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                Login
                            </a>
                            <a href="{{ route('register') }}"
                                class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                Register
                            </a>
                        </div>
                    @endauth

                    <div class="px-4 mt-3">
                        <a href="{{ route('submissions.create') }}"
                            class="block w-full text-center bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2 px-4 rounded-md text-base font-medium">
                            List Property
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Company Info -->
                    <div class="md:col-span-1">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                <span class="text-white font-bold text-sm">MP</span>
                            </div>
                            <span class="text-xl font-bold">Mirvan Properties</span>
                        </div>
                        <p class="text-gray-400 text-sm mb-4">
                            Your trusted partner in premium real estate for over two decades.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('properties.index') }}"
                                    class="text-gray-400 hover:text-white transition-colors">Properties</a></li>
                            <li><a href="{{ route('blog.index') }}"
                                    class="text-gray-400 hover:text-white transition-colors">Blog</a></li>
                            <li><a href="{{ route('about') }}"
                                    class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                            <li><a href="{{ route('contact') }}"
                                    class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                            <li><a href="{{ route('submissions.create') }}"
                                    class="text-gray-400 hover:text-white transition-colors">List Property</a></li>
                        </ul>
                    </div>

                    <!-- Services -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Services</h3>
                        <ul class="space-y-2 text-sm">
                            <li><span class="text-gray-400">Commercial Real Estate</span></li>
                            <li><span class="text-gray-400">Residential Properties</span></li>
                            <li><span class="text-gray-400">Investment Advisory</span></li>
                            <li><span class="text-gray-400">Property Management</span></li>
                            <li><span class="text-gray-400">Market Analysis</span></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Contact Info</h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                123 Real Estate Blvd, Suite 500<br>Los Angeles, CA 90210
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                (555) 123-4567
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                info@mirvanproperties.com
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                    <p class="text-gray-400 text-sm">
                        © {{ date('Y') }} Mirvan Properties. All rights reserved. |
                        <a href="#" class="hover:text-white transition-colors">Privacy Policy</a> |
                        <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                    </p>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>

</html>
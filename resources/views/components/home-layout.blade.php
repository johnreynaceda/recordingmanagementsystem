<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @filamentStyles
    @vite('resources/css/app.css')
</head>

<body
    class="font-sans text-main antialiased {{ request()->routeIs('home') ? 'overflow-hidden' : '' }} bg-gray-300 min-h-screen relative">

    <!-- Background -->
    <img src="{{ asset('images/bg.jpg') }}"
        class="fixed top-0 bottom-0 left-0 w-full h-full object-cover opacity-20 -z-10" alt="">

    <div class="relative">

        <!-- Top Contact Info -->
        <div class="bg-main relative">
            <div
                class="mx-auto py-3 text-white max-w-7xl flex flex-col md:flex-row md:space-x-6 space-y-2 md:space-y-0 items-center justify-center md:justify-start px-4">
                <div class="flex space-x-2 items-center text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-at-sign-icon lucide-at-sign">
                        <circle cx="12" cy="12" r="4" />
                        <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-4 8" />
                    </svg>
                    <span>tmcnhs@gmail.com</span>
                </div>
                <div class="flex space-x-2 items-center text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-phone-icon lucide-phone">
                        <path
                            d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                    </svg>
                    <span>4432-3524-6754</span>
                </div>
                <div class="flex space-x-2 items-center text-sm text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin">
                        <path
                            d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                    <span class="truncate">Trece Martires City National Highschool</span>
                </div>
            </div>
        </div>

        <!-- Navbar -->
        <section class="w-full px-4 md:px-8 relative sticky top-0 text-gray-700 border-b bg-white"
            {!! $attributes ?? '' !!}>
            <div class="container flex flex-wrap items-center justify-between py-2 mx-auto max-w-7xl">

                <!-- Logo -->
                <a href="{{ route('home') }}"
                    class="flex items-center 2xl:mb-3 :mb-0 font-medium text-main lg:w-auto lg:items-center lg:justify-center">
                    <img src="{{ asset('images/tmcnhs_logo.png') }}" class="h-12" alt="">
                </a>

                <!-- Mobile Menu Button -->
                <button class="md:hidden p-2 rounded-lg border border-gray-300"
                    onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex flex-wrap items-center text-base space-x-6">
                    <a href="{{ route('home') }}" class="font-medium leading-6 text-gray-600 hover:text-main">Home</a>
                    <a href="{{ route('about') }}" class="font-medium leading-6 text-gray-600 hover:text-main">About
                        Us</a>
                    <a href="#_" class="font-medium leading-6 text-gray-600 hover:text-main">How to Enroll</a>
                    <a href="#_" class="font-medium leading-6 text-gray-600 hover:text-main">K-12 Program</a>
                </nav>

                <!-- Login -->
                <div class="hidden md:flex items-center space-x-2">
                    {{-- <a href="{{ route('login') }}" class="flex items-center font-medium leading-6 text-gray-600 hover:text-main">
                        <span>Login</span>
                       <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-in-icon lucide-log-in"><path d="m10 17 5-5-5-5"/><path d="M15 12H3"/><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/></svg>
                    </a> --}}
                </div>
            </div>

            <!-- Mobile Nav -->
            <div id="mobileMenu" class="hidden md:hidden flex flex-col space-y-3 mt-3 px-4 pb-4 border-t">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-main">Home</a>
                <a href="{{ route('about') }}" class="text-gray-600 hover:text-main">About Us</a>
                <a href="#_" class="text-gray-600 hover:text-main">How to Enroll</a>
                <a href="#_" class="text-gray-600 hover:text-main">K-12 Program</a>
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-main flex items-center space-x-1">
                    <span>Login</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-log-in-icon lucide-log-in">
                        <path d="m10 17 5-5-5-5" />
                        <path d="M15 12H3" />
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                    </svg>
                </a>
            </div>
        </section>

        <!-- Main Content -->
        <main class="p-4 md:p-6">
            {{ $slot }}
        </main>

    </div>

    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>

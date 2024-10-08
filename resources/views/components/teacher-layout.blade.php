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
    <tallstackui:script />
    @filamentStyles
    @vite('resources/css/app.css')
</head>

<body>
    <div class="flex flex-col h-screen overflow-hidden bg-gray-100">
        <!-- Top Navigation Bar -->
        <div class="bg-gradient-to-bl from-red-500 to-main border-b border-main">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="text-lg font-semibold tracking-tighter text-black relative focus:outline-none focus:ring">
                            <img src="{{ asset('images/tmcnhs_logo.png') }}" class="h-12" alt="Logo">
                        </a>
                    </div>
                    <div class="hidden md:flex md:space-x-4">
                        <!-- Navigation Links -->
                        <a href="" class="{{ request()->routeIs('') ? 'text-main bg-white' : 'text-white' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Attendance</a>
                        <a href="" class="{{ request()->routeIs('') ? 'text-main bg-white' : 'text-white' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Grades</a>
                        <a href="" class="{{ request()->routeIs('') ? 'text-main bg-white' : 'text-white' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Profile</a>
                    </div>
                    <!-- Logout Button -->
                    <div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-white px-4 py-2 rounded-lg hover:bg-white hover:text-main">Logout</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="flex-1 overflow-y-auto">
            <main class="py-6">
                {{-- <div class="px-4 mx-auto 2xl:max-w-7xl bg-gradient-to-bl from-main to-gray-500 rounded-3xl py-2 sm:px-6 md:px-8 relative">
                    <img src="{{ asset('images/bg.jpg') }}" class="object-cover absolute top-0 left-0 w-full h-full opacity-20 rounded-3xl" alt="">
                    <div class="py-4 flex justify-between items-center text-white relative">
                        <div class="text-xl">Hello {{ auth()->user()->name ?? '' }},</div>
                        <div class="text-lg">{{ now()->format('F d, Y') }}</div>
                    </div>
                </div> --}}
                <div class="px-4 mx-auto 2xl:max-w-7xl sm:px-6 md:px-8">
                    <div class="py-2">

                        <div class="">{{ $slot }}</div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>

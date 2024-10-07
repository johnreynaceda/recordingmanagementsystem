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
    class="font-sans text-main antialiased {{ request()->routeIs('home') ? 'overflow-hidden' : '' }} bg-gray-300 h-screen relative">
    <img src="{{ asset('images/bg.jpg') }}" class="fixed top-0 bottom-0 left-0 w-full h-full object-cover opacity-20"
        alt="">
    <div class="relative ">

        <div class="bg-main relative">
            <div class="mx-auto py-3 text-white max-w-7xl flex space-x-4 items-center">
                <div class="flex space-x-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-mail">
                        <rect width="20" height="16" x="2" y="4" rx="2" />
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                    </svg>
                    <span>tmcnhs@gmail.com</span>
                </div>
                <div class="flex space-x-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-phone">
                        <path
                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                    </svg>
                    <span>4432-3524-6754</span>
                </div>
                <div class="flex space-x-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-map-pin">
                        <path
                            d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                    <span>Trece Martires City National Highschool</span>
                </div>
            </div>
        </div>
        <section class="w-full px-8 relative sticky top-0 text-gray-700 border-b bg-white" {!! $attributes ?? '' !!}>
            <div
                class="container flex flex-col flex-wrap items-center justify-between py-2 mx-auto md:flex-row max-w-7xl">
                <div class="relative flex flex-col md:flex-row">
                    <a href="#_"
                        class="flex items-center mb-5 font-medium text-main lg:w-auto lg:items-center lg:justify-center md:mb-0">
                        <img src="{{ asset('images/tmcnhs_logo.png') }}" class="h-12" alt="">
                    </a>
                    <nav
                        class="flex flex-wrap items-center mb-5 text-base md:mb-0 md:pl-8 md:ml-8 md:border-l md:border-gray-200">
                        <a href="{{ route('home') }}"
                            class="mr-5 font-medium leading-6 text-gray-600 hover:text-main">Home</a>

                        <a href="{{ route('about') }}"
                            class="mr-5 font-medium leading-6 text-gray-600 hover:text-main">About
                            Us</a>
                        <a href="#_" class="mr-5 font-medium leading-6 text-gray-600 hover:text-main">How to
                            Enroll</a>
                        <a href="#_" class="mr-5 font-medium leading-6 text-gray-600 hover:text-main">K-12
                            Program</a>
                    </nav>
                </div>

                <div class="inline-flex items-center ml-5 space-x-6 lg:justify-end">

                    <a href="{{ route('login') }}"
                        class="mr-5 flex space-x-2 font-medium leading-6 text-gray-600 hover:text-main">
                        <span>
                            Login
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-log-in">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                            <polyline points="10 17 15 12 10 7" />
                            <line x1="15" x2="3" y1="12" y2="12" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
        <main>
            {{ $slot }}
        </main>


    </div>
    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>

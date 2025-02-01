{{-- <!DOCTYPE html>
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


        <div class="bg-gradient-to-bl from-red-500 to-main border-b border-main">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <a href="/"
                            class="text-lg font-semibold tracking-tighter text-black relative focus:outline-none focus:ring">
                            <img src="{{ asset('images/tmcnhs_logo.png') }}" class="h-12" alt="Logo">
                        </a>
                    </div>
                    <div class="hidden md:flex md:space-x-4">

                        <a href="{{ route('dashboard') }}"
                            class="{{ request()->routeIs('dashboard') ? 'text-main bg-white' : 'text-gray-700' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Dashboard</a>
                        <a href=""
                            class="{{ request()->routeIs('enrollment.form') ? 'text-main bg-white' : 'text-gray-700' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Enrollment
                            Form</a>
                        <a href=""
                            class="{{ request()->routeIs('subjects') ? 'text-main bg-white' : 'text-gray-700' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Subjects</a>
                        <a href=""
                            class="{{ request()->routeIs('grades') ? 'text-main bg-white' : 'text-gray-700' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Grades</a>
                        <a href=""
                            class="{{ request()->routeIs('payments') ? 'text-main bg-white' : 'text-gray-700' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Payments</a>
                        <a href=""
                            class="{{ request()->routeIs('billing.statement') ? 'text-main bg-white' : 'text-gray-700' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Billing
                            Statement</a>
                        <a href="{{ route('student.request') }}"
                            class="{{ request()->routeIs('requests') ? 'text-main bg-white' : 'text-gray-700' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Requests</a>
                    </div>

                    <div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-white px-4 py-2 rounded-lg hover:bg-white hover:text-main">Logout</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="flex-1 overflow-y-auto">
            <main class="py-6">

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

</html> --}}

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
    @wireUiScripts

    <tallstackui:script />
    @filamentStyles
    @vite('resources/css/app.css')
</head>

<body>

    <div class="flex flex-col h-screen overflow-hidden bg-gray-100">
        <div class="bg-main h-5 w-full">
        </div>
        <section class="w-full px-8 relative sticky top-0 text-gray-700 border-b border-main bg-white"
            {!! $attributes ?? '' !!}>
            <div
                class="container flex flex-col flex-wrap items-center justify-between py-4 mx-auto md:flex-row max-w-7xl">
                <div class="relative flex flex-col md:flex-row">
                    <a href="#_"
                        class="flex items-center mb-5 font-medium text-main lg:w-auto lg:items-center lg:justify-center md:mb-0">
                        <img src="{{ asset('images/tmcnhs_logo.png') }}" class="h-12" alt="">
                    </a>
                    <nav
                        class="flex flex-wrap items-center mb-5 text-base md:mb-0 md:pl-8 md:ml-8 md:border-l md:border-gray-200">
                        <a href="{{ route('student.index') }}"
                            class="{{ request()->routeIs('student.index') ? 'text-main bg-white' : 'text-gray-700' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Dashboard</a>
                        {{-- <a href=""
                            class="{{ request()->routeIs('enrollment.form') ? 'text-main bg-white' : 'text-gray-700' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Enrollment
                            Form</a>
                        <a href=""
                            class="{{ request()->routeIs('subjects') ? 'text-main bg-white' : 'text-gray-700' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Subjects</a>
                        <a href=""
                            class="{{ request()->routeIs('grades') ? 'text-main bg-white' : 'text-gray-700' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Grades</a>
                        <a href=""
                            class="{{ request()->routeIs('payments') ? 'text-main bg-white' : 'text-gray-700' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Payments</a>
                        <a href=""
                            class="{{ request()->routeIs('billing.statement') ? 'text-main bg-white' : 'text-gray-700' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Billing
                            Statement</a> --}}
                        <a href="{{ route('student.request') }}"
                            class="{{ request()->routeIs('student.request') ? 'text-main bg-white' : 'text-gray-700' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Requests</a>
                        <a href="{{ route('student.calendar') }}"
                            class="{{ request()->routeIs('student.calendar') ? 'text-main bg-white' : 'text-gray-700' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Calendar</a>
                    </nav>
                </div>

                <div class="inline-flex items-center ml-5 space-x-6 lg:justify-end">
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="mr-5 flex space-x-2 font-medium leading-6 text-gray-600 hover:text-main">
                            <span>
                                Logout
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-log-out">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" x2="9" y1="12" y2="12" />
                            </svg>
                        </a>
                    </form>
                </div>
            </div>
        </section>



        <div class="flex-1 overflow-y-auto">
            <main class="py-10">

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



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

<body class="antialiased">

    <div class="flex min-h-screen min-h-[100dvh] flex-col bg-gray-100" x-data="{ mobileMenuOpen: false }">
        <div class="h-2 w-full shrink-0 bg-main sm:h-3"></div>
        <header class="sticky top-0 z-40 w-full border-b border-main/20 bg-white text-gray-700 shadow-sm"
            {!! $attributes ?? '' !!}>
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
                <div class="flex min-w-0 items-center">
                    <a href="{{ route('student.index') }}" class="flex shrink-0 items-center font-medium text-main">
                        <img src="{{ asset('images/tmcnhs_logo.png') }}" class="h-10 w-auto sm:h-12"
                            alt="Trece Martires City National High School">
                    </a>
                    <nav class="ml-6 hidden items-center border-l border-gray-200 pl-6 text-sm font-medium lg:flex xl:text-base">
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
                        <a href="{{ route('student.grade') }}"
                            class="{{ request()->routeIs('student.grade') ? 'text-main bg-white' : 'text-gray-700' }} px-4 py-2 rounded-lg hover:bg-white hover:text-main">Grade</a>
                    </nav>
                </div>

                <div class="hidden items-center lg:inline-flex">
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 rounded-lg px-3 py-2 font-medium leading-6 text-gray-600 transition hover:bg-red-50 hover:text-main">
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
                        </button>
                    </form>
                </div>

                <button type="button" @click="mobileMenuOpen = ! mobileMenuOpen"
                    :aria-expanded="mobileMenuOpen.toString()" aria-controls="student-mobile-menu"
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-gray-200 text-gray-600 transition hover:border-red-200 hover:bg-red-50 hover:text-main focus:outline-none focus:ring-2 focus:ring-red-200 lg:hidden">
                    <span class="sr-only">Toggle navigation</span>
                    <svg x-show="! mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav id="student-mobile-menu" x-show="mobileMenuOpen" x-cloak x-transition.origin.top
                @click.outside="mobileMenuOpen = false"
                class="border-t border-gray-100 bg-white px-4 py-3 shadow-lg sm:px-6 lg:hidden">
                <div class="mx-auto grid max-w-7xl gap-1 sm:grid-cols-2">
                    <a href="{{ route('student.index') }}"
                        class="{{ request()->routeIs('student.index') ? 'bg-red-50 text-main' : 'text-gray-700' }} rounded-lg px-4 py-3 font-medium hover:bg-red-50 hover:text-main">Dashboard</a>
                    <a href="{{ route('student.request') }}"
                        class="{{ request()->routeIs('student.request') ? 'bg-red-50 text-main' : 'text-gray-700' }} rounded-lg px-4 py-3 font-medium hover:bg-red-50 hover:text-main">Requests</a>
                    <a href="{{ route('student.calendar') }}"
                        class="{{ request()->routeIs('student.calendar') ? 'bg-red-50 text-main' : 'text-gray-700' }} rounded-lg px-4 py-3 font-medium hover:bg-red-50 hover:text-main">Calendar</a>
                    <a href="{{ route('student.grade') }}"
                        class="{{ request()->routeIs('student.grade') ? 'bg-red-50 text-main' : 'text-gray-700' }} rounded-lg px-4 py-3 font-medium hover:bg-red-50 hover:text-main">Grade</a>
                    <form method="POST" action="{{ route('logout') }}" class="sm:col-span-2">
                        @csrf
                        <button type="submit"
                            class="flex w-full items-center gap-2 rounded-lg px-4 py-3 text-left font-medium text-gray-700 hover:bg-red-50 hover:text-main">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" x2="9" y1="12" y2="12" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </nav>
        </header>

        <main class="w-full flex-1 py-5 sm:py-7 lg:py-10">
            <div class="mx-auto w-full max-w-7xl px-3 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>

    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>

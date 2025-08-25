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

    <!-- Alpine.js for click-away + toggle -->

    <tallstackui:script />
    @filamentStyles
    @vite('resources/css/app.css')

</head>

<body class="bg-gray-100">
    <div x-data="{ open: false }" class="flex h-screen overflow-hidden">

        <!-- Sidebar with overlay -->
        <div>
            <!-- Overlay (mobile only) -->
            <div x-show="open" x-transition.opacity x-cloak @click="open = false"
                class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"></div>

            <!-- Sidebar -->
            <!-- Sidebar -->
            <div class="flex h-screen">
                <div class="fixed inset-y-0 left-0 z-40 w-64 transform transition-transform duration-300 md:relative md:translate-x-0 md:flex md:flex-shrink-0"
                    :class="{ '-translate-x-full': !open, 'translate-x-0': open }">

                    <div class="flex flex-col h-full w-64 bg-gradient-to-bl from-red-500 to-main relative">
                        <!-- Background -->
                        <img src="{{ asset('images/bg.jpg') }}"
                            class="absolute inset-0 w-full h-full object-cover opacity-10" alt="">

                        <!-- Logo -->
                        <div class="flex flex-col items-center py-6 z-10">
                            <img src="{{ asset('images/tmcnhs_logo.png') }}" class="h-32 md:h-40" alt="Logo">
                        </div>

                        <!-- Nav -->
                        <div class="flex-1 px-4 overflow-y-auto z-10">
                            <nav class="space-y-1">
                                <p class="px-4 text-xs font-semibold text-gray-100 uppercase">Analytics</p>
                                <ul>
                                    <li>
                                        <a href="#_"
                                            class="inline-flex items-center w-full px-4 py-2 mt-1 text-white rounded-lg hover:bg-white hover:text-main transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <rect width="7" height="9" x="3" y="3" rx="1" />
                                                <rect width="7" height="5" x="14" y="3" rx="1" />
                                                <rect width="7" height="9" x="14" y="12" rx="1" />
                                                <rect width="7" height="5" x="3" y="16" rx="1" />
                                            </svg>
                                            <span class="ml-4">Dashboard</span>
                                        </a>
                                    </li>
                                </ul>

                                <p class="px-4 pt-6 text-xs font-semibold text-gray-100 uppercase">Manage</p>
                              <ul> <li> <a class="{{ request()->routeIs('admin.staffs') ? 'bg-white text-main' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-white hover:scale-95 hover:text-main" href="{{ route('admin.staffs') }}"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-user-round"> <path d="M18 20a6 6 0 0 0-12 0" /> <circle cx="12" cy="10" r="4" /> <circle cx="12" cy="12" r="10" /> </svg> <span class="ml-4"> Staffs </span> </a> </li> <li> <a class="{{ request()->routeIs('admin.students') ? 'bg-white text-main' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-white hover:scale-95 hover:text-main" href="{{ route('admin.students') }}"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round"> <circle cx="12" cy="8" r="5" /> <path d="M20 21a8 8 0 0 0-16 0" /> </svg> <span class="ml-4"> Students </span> </a> </li> <li> <a class="{{ request()->routeIs('admin.grade-level') ? 'bg-white text-main' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-white hover:scale-95 hover:text-main" href="{{ route('admin.grade-level') }}"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-spreadsheet"> <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" /> <path d="M14 2v4a2 2 0 0 0 2 2h4" /> <path d="M8 13h2" /> <path d="M14 13h2" /> <path d="M8 17h2" /> <path d="M14 17h2" /> </svg> <span class="ml-4"> Grade Levels </span> </a> </li> {{-- <li> <a class="inline-flex items-center w-full px-4 py-2 mt-1 text-white transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-white hover:scale-95 hover:text-main" href="#_"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-spreadsheet"> <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" /> <path d="M14 2v4a2 2 0 0 0 2 2h4" /> <path d="M8 13h2" /> <path d="M14 13h2" /> <path d="M8 17h2" /> <path d="M14 17h2" /> </svg> <span class="ml-4"> Sections </span> </a> </li> --}} <li> <a class="{{ request()->routeIs('admin.request') ? 'bg-white text-main' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-white hover:scale-95 hover:text-main" href="{{ route('admin.request') }}"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-spreadsheet"> <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" /> <path d="M14 2v4a2 2 0 0 0 2 2h4" /> <path d="M8 13h2" /> <path d="M14 13h2" /> <path d="M8 17h2" /> <path d="M14 17h2" /> </svg> <span class="ml-4"> Requests </span> </a> </li> <li> <a class="{{ request()->routeIs('admin.calendar') ? 'bg-white text-main' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-white hover:scale-95 hover:text-main" href="{{ route('admin.calendar') }}"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-range"> <rect width="18" height="18" x="3" y="4" rx="2" /> <path d="M16 2v4" /> <path d="M3 10h18" /> <path d="M8 2v4" /> <path d="M17 14h-6" /> <path d="M13 18H7" /> <path d="M7 14h.01" /> <path d="M17 18h.01" /> </svg> <span class="ml-4"> Calendar </span> </a> </li> </ul> <p class="px-4 pt-20 text-xs font-semibold text-gray-100 uppercase"> </p> <ul> <li> <a class="inline-flex items-center w-full px-4 py-2 mt-1 text-white transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-white hover:scale-95 hover:text-main" href="#_"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cog"> <path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z" /> <path d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" /> <path d="M12 2v2" /> <path d="M12 22v-2" /> <path d="m17 20.66-1-1.73" /> <path d="M11 10.27 7 3.34" /> <path d="m20.66 17-1.73-1" /> <path d="m3.34 7 1.73 1" /> <path d="M14 12h8" /> <path d="M2 12h2" /> <path d="m20.66 7-1.73 1" /> <path d="m3.34 17 1.73-1" /> <path d="m17 3.34-1 1.73" /> <path d="m11 13.73-4 6.93" /> </svg> <span class="ml-4"> Settings </span> </a> </li> <li> <form method="POST" action="{{ route('logout') }}"> @csrf <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="inline-flex items-center w-full px-4 py-2 mt-1 text-white transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-white hover:scale-95 hover:text-main"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out"> <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" /> <polyline points="16 17 21 12 16 7" /> <line x1="21" x2="9" y1="12" y2="12" /> </svg> <span class="ml-4"> Logout </span> </a> </form> </li> </ul>
                            </nav>
                        </div>

                        <!-- Bottom buttons (sticks to bottom) -->
                        {{-- <div class="px-4 py-6 border-t border-white/20 z-10 mt-auto">
                            <a href="#_"
                                class="flex items-center w-full px-4 py-2 text-white rounded-lg hover:bg-white hover:text-main transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z" />
                                    <path d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" />
                                </svg>
                                <span class="ml-4">Settings</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                @csrf
                                <button type="submit"
                                    class="flex items-center w-full px-4 py-2 text-white rounded-lg hover:bg-white hover:text-main transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        <polyline points="16 17 21 12 16 7" />
                                        <line x1="21" x2="9" y1="12" y2="12" />
                                    </svg>
                                    <span class="ml-4">Logout</span>
                                </button>
                            </form>
                        </div> --}}
                    </div>
                </div>
            </div>

        </div>

        <!-- Main content -->
        <div class="flex flex-col flex-1 w-0">
            <!-- Top bar (mobile menu button) -->
            <div class="flex items-center bg-main text-white px-4 py-3 md:hidden">
                <button @click="open = !open"
                    class="mr-3 p-2 rounded-md bg-white/20 hover:bg-white/30 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <span class="font-semibold">Menu</span>
            </div>

            <!-- Page Content -->
            <main class="relative flex-1 overflow-y-auto">
                <div class="py-6 px-2 2xl:px-0">
                    <!-- Header -->
                    <div
                        class="px-4 mx-auto 2xl:max-w-7xl bg-gradient-to-bl from-main to-gray-500 relative rounded-3xl py-4 sm:px-6 md:px-8 text-white">
                        <img src="{{ asset('images/bg.jpg') }}"
                            class="absolute inset-0 w-full h-full object-cover opacity-20 rounded-3xl" alt="">
                        <div class="flex justify-between items-center relative">
                            <div class="text-lg md:text-xl">Hello {{ auth()->user()->name ?? '' }},</div>
                            <div class="text-sm md:text-lg">{{ now()->format('F d, Y') }}</div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="px-4 mx-auto 2xl:max-w-7xl sm:px-6 md:px-8">
                        <div class="py-10">
                            <nav class="text-lg font-medium text-slate-700" aria-label="breadcrumb">
                                <ol class="flex flex-wrap items-center gap-2">
                                    <li class="flex items-center gap-2">
                                        <a href="#" class="hover:text-black">Home</a>
                                        <span aria-hidden="true">/</span>
                                    </li>
                                    <li class="text-main font-bold" aria-current="page">@yield('title')</li>
                                </ol>
                            </nav>

                            <div class="mt-10">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>

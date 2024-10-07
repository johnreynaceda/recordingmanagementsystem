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
    <div class="flex h-screen overflow-hidden bg-gray-100">
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64">
                <div
                    class="flex flex-col flex-grow pt-5 overflow-y-auto relative bg-gradient-to-bl from-red-500 to-main border-main">
                    <img src="{{ asset('images/bg.jpg') }}"
                        class="object-cover absolute top-0 left-0 w-full h-full opacity-10" alt="">
                    <div class="flex flex-col items-center flex-shrink-0 px-4">
                        <a class="text-lg font-semibold tracking-tighter relative text-black focus:outline-none focus:ring"
                            href="/">
                            <img src="{{ asset('images/tmcnhs_logo.png') }}" class="  h-40" alt="">
                        </a>
                        <button class="hidden rounded-lg focus:outline-none focus:shadow-outline">
                            <svg fill="currentColor" viewBox="0 0 20 20" class="size-6">
                                <path fill-rule="evenodd"
                                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
                                    clip-rule="evenodd"></path>
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex flex-col flex-grow px-4 relative mt-10">
                        <nav class="flex-1 space-y-1 ">
                            <p class="px-4 pt-4 text-xs font-semibold text-gray-100 uppercase">
                                Analytics
                            </p>
                            <ul>
                                <li>
                                    <a class="inline-flex items-center w-full px-4 py-2 mt-1  text-white transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-white hover:scale-95 hover:text-main"
                                        href="#_">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-layout-dashboard">
                                            <rect width="7" height="9" x="3" y="3" rx="1" />
                                            <rect width="7" height="5" x="14" y="3" rx="1" />
                                            <rect width="7" height="9" x="14" y="12" rx="1" />
                                            <rect width="7" height="5" x="3" y="16" rx="1" />
                                        </svg>
                                        <span class="ml-4"> Dashboard </span>
                                    </a>
                                </li>

                            </ul>
                            <p class="px-4 pt-10 text-xs font-semibold text-gray-100 uppercase">
                                Manage
                            </p>
                            <ul>
                                <li>
                                    <a class="{{ request()->routeIs('admin.staffs') ? 'bg-white text-main' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-white hover:scale-95 hover:text-main"
                                        href="{{ route('admin.staffs') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-circle-user-round">
                                            <path d="M18 20a6 6 0 0 0-12 0" />
                                            <circle cx="12" cy="10" r="4" />
                                            <circle cx="12" cy="12" r="10" />
                                        </svg>
                                        <span class="ml-4"> Staffs </span>
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ request()->routeIs('admin.students') ? 'bg-white text-main' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-white hover:scale-95 hover:text-main"
                                        href="{{ route('admin.students') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-user-round">
                                            <circle cx="12" cy="8" r="5" />
                                            <path d="M20 21a8 8 0 0 0-16 0" />
                                        </svg>
                                        <span class="ml-4"> Students </span>
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ request()->routeIs('admin.grade-level') ? 'bg-white text-main' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-white hover:scale-95 hover:text-main"
                                        href="{{ route('admin.grade-level') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-file-spreadsheet">
                                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                            <path d="M8 13h2" />
                                            <path d="M14 13h2" />
                                            <path d="M8 17h2" />
                                            <path d="M14 17h2" />
                                        </svg>
                                        <span class="ml-4"> Grade Levels </span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a class="inline-flex items-center w-full px-4 py-2 mt-1  text-white transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-white hover:scale-95 hover:text-main"
                                        href="#_">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-file-spreadsheet">
                                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                            <path d="M8 13h2" />
                                            <path d="M14 13h2" />
                                            <path d="M8 17h2" />
                                            <path d="M14 17h2" />
                                        </svg>
                                        <span class="ml-4"> Sections </span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a class="inline-flex items-center w-full px-4 py-2 mt-1  text-white transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-white hover:scale-95 hover:text-main"
                                        href="#_">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-file-spreadsheet">
                                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                            <path d="M8 13h2" />
                                            <path d="M14 13h2" />
                                            <path d="M8 17h2" />
                                            <path d="M14 17h2" />
                                        </svg>
                                        <span class="ml-4"> Requests </span>
                                    </a>
                                </li>
                                <li>
                                    <a class="inline-flex items-center w-full px-4 py-2 mt-1  text-white transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-white hover:scale-95 hover:text-main"
                                        href="#_">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-calendar-range">
                                            <rect width="18" height="18" x="3" y="4" rx="2" />
                                            <path d="M16 2v4" />
                                            <path d="M3 10h18" />
                                            <path d="M8 2v4" />
                                            <path d="M17 14h-6" />
                                            <path d="M13 18H7" />
                                            <path d="M7 14h.01" />
                                            <path d="M17 18h.01" />
                                        </svg>
                                        <span class="ml-4"> Calendar </span>
                                    </a>
                                </li>

                            </ul>
                            <p class="px-4 pt-20 text-xs font-semibold text-gray-100 uppercase">

                            </p>
                            <ul>
                                <li>
                                    <a class="inline-flex items-center w-full px-4 py-2 mt-1  text-white transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-white hover:scale-95 hover:text-main"
                                        href="#_">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-cog">
                                            <path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z" />
                                            <path d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" />
                                            <path d="M12 2v2" />
                                            <path d="M12 22v-2" />
                                            <path d="m17 20.66-1-1.73" />
                                            <path d="M11 10.27 7 3.34" />
                                            <path d="m20.66 17-1.73-1" />
                                            <path d="m3.34 7 1.73 1" />
                                            <path d="M14 12h8" />
                                            <path d="M2 12h2" />
                                            <path d="m20.66 7-1.73 1" />
                                            <path d="m3.34 17 1.73-1" />
                                            <path d="m17 3.34-1 1.73" />
                                            <path d="m11 13.73-4 6.93" />
                                        </svg>
                                        <span class="ml-4"> Settings </span>
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="route('logout')"
                                            onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                            class="inline-flex items-center w-full px-4 py-2 mt-1  text-white transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-white hover:scale-95 hover:text-main">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-log-out">
                                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                                <polyline points="16 17 21 12 16 7" />
                                                <line x1="21" x2="9" y1="12" y2="12" />
                                            </svg>
                                            <span class="ml-4"> Logout </span>
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
        <div class="flex flex-col flex-1 w-0 overflow-hidden">
            <main class="relative flex-1 overflow-y-auto focus:outline-none">
                <div class="py-6">
                    <div
                        class="px-4 mx-auto 2xl:max-w-7xl   bg-gradient-to-bl from-main relative to-gray-500 rounded-3xl py-2 sm:px-6 md:px-8">
                        <img src="{{ asset('images/bg.jpg') }}"
                            class="object-cover absolute top-0 left-0 w-full h-full opacity-20 rounded-3xl"
                            alt="">
                        <div class="py-4 flex relative justify-between items-center text-white">
                            <div class="text-xl">Hello {{ auth()->user()->name ?? '' }},</div>
                            <div class="text-lg">{{ now()->format('F d, Y') }}</div>
                        </div>
                    </div>
                    <div class="px-4 mx-auto 2xl:max-w-7xl sm:px-6 md:px-8">
                        <!-- === Remove and replace with your own content... === -->
                        <div class="py-10">
                            <nav class="text-xl font-medium text-slate-700" aria-label="breadcrumb">
                                <ol class="flex flex-wrap items-center gap-2">
                                    <li class="flex items-center gap-2">
                                        <a href="#" class="hover:text-black">Home</a>
                                        <span aria-hidden="true">/</span>
                                    </li>

                                    <li class="text-main font-bold" aria-current="page">@yield('title')
                                    </li>
                                </ol>
                            </nav>

                            <div class="mt-10">
                                {{ $slot }}
                            </div>
                        </div>
                        <!-- === End ===  -->
                    </div>
                </div>
            </main>
        </div>
    </div>
    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TMCNHS | @yield('title', 'Student Portal')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800&display=swap" rel="stylesheet" />

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Manrope', sans-serif; }
        .student-scrollbar { scrollbar-color: rgba(148, 163, 184, .45) transparent; scrollbar-width: thin; }
        .student-scrollbar::-webkit-scrollbar { width: 6px; }
        .student-scrollbar::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, .45); border-radius: 999px; }
    </style>

    @wireUiScripts
    <tallstackui:script />
    @filamentStyles
    @vite('resources/css/app.css')
</head>

@php
    $studentName = auth()->user()?->name ?? 'Student';
    $studentLrn = auth()->user()?->student?->lrn;
    $studentInitials = collect(preg_split('/\s+/', trim($studentName)))
        ->filter()
        ->take(2)
        ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
        ->implode('');

    $pageTitle = match (true) {
        request()->routeIs('student.index') => 'My Profile',
        request()->routeIs('student.request') => 'Requests',
        request()->routeIs('student.calendar') => 'School Calendar',
        request()->routeIs('student.grade') => 'My Grades',
        default => trim($__env->yieldContent('title')) ?: 'Student Portal',
    };

    $studentNavigation = [
        ['label' => 'My Profile', 'route' => 'student.index', 'active' => 'student.index', 'icon' => 'user'],
        ['label' => 'Requests', 'route' => 'student.request', 'active' => 'student.request', 'icon' => 'document'],
        ['label' => 'Calendar', 'route' => 'student.calendar', 'active' => 'student.calendar', 'icon' => 'calendar'],
        ['label' => 'My Grades', 'route' => 'student.grade', 'active' => 'student.grade', 'icon' => 'grades'],
    ];
@endphp

<body class="min-h-screen bg-[#fbfaf8] text-slate-800 antialiased">
    <a href="#student-content" class="sr-only z-[100] rounded-lg bg-white px-4 py-3 font-bold text-[#a71930] shadow-lg focus:not-sr-only focus:fixed focus:left-4 focus:top-4">Skip to main content</a>

    <div x-data="{ mobileOpen: false, profileOpen: false }" class="flex min-h-screen min-h-[100dvh] flex-col">
        <div class="h-1.5 shrink-0 bg-gradient-to-r from-[#8d1429] via-[#c52a45] to-[#e56a79]" aria-hidden="true"></div>

        <header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/95 shadow-[0_4px_18px_rgba(15,23,42,0.035)] backdrop-blur-md">
            <div class="mx-auto flex h-[76px] max-w-7xl items-center gap-4 px-4 sm:px-6 lg:px-8">
                <a href="{{ route('student.index') }}" class="group flex min-w-0 items-center gap-3 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-4" aria-label="Student portal home">
                    <img src="{{ asset('images/tmcnhs_logo.png') }}" class="h-[52px] w-[52px] shrink-0 object-contain transition duration-300 group-hover:scale-[1.03]" alt="Trece Martires City National High School seal">
                    <span class="hidden min-w-0 sm:block">
                        <span class="block text-[10px] font-extrabold uppercase tracking-[0.18em] text-[#a71930]">Student Portal</span>
                        <span class="mt-0.5 block truncate text-sm font-extrabold tracking-tight text-[#101928]">Trece Martires City NHS</span>
                    </span>
                </a>

                <div class="hidden h-9 w-px bg-slate-200 xl:block" aria-hidden="true"></div>

                <nav class="hidden items-center gap-1 xl:flex" aria-label="Student navigation">
                    @foreach ($studentNavigation as $item)
                        @php($isActive = request()->routeIs($item['active']))
                        <a href="{{ route($item['route']) }}" @if ($isActive) aria-current="page" @endif
                            class="inline-flex min-h-11 items-center gap-2 rounded-xl px-3.5 text-sm font-bold transition duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] {{ $isActive ? 'bg-red-50 text-[#a71930]' : 'text-slate-600 hover:bg-[#fdfcfb] hover:text-[#101928]' }}">
                            @if ($item['icon'] === 'user')
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="3.75"/><path stroke-linecap="round" d="M4.5 20a7.5 7.5 0 0 1 15 0"/></svg>
                            @elseif ($item['icon'] === 'document')
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 3.5h7l4 4V20H7V3.5Zm7 0V8h4M10 12h5M10 15.5h5"/></svg>
                            @elseif ($item['icon'] === 'calendar')
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z"/></svg>
                            @else
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3.5h12A2.5 2.5 0 0 1 19.5 6v14.5H7.25A2.75 2.75 0 0 1 4.5 17.75V4A.5.5 0 0 1 5 3.5Zm2.25 13H19.5M9 8h6M9 11.5h4"/></svg>
                            @endif
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                <div class="ml-auto flex items-center gap-2 sm:gap-3">
                    {{-- <a href="{{ route('home') }}" target="_blank" rel="noopener"
                        class="hidden min-h-11 items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 text-xs font-bold text-slate-600 shadow-sm transition duration-300 hover:border-red-200 hover:bg-red-50 hover:text-[#a71930] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] lg:inline-flex">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12s3-5.25 8.25-5.25S20.25 12 20.25 12 17.25 17.25 12 17.25 3.75 12 3.75 12Z"/><circle cx="12" cy="12" r="2.25"/></svg>
                        School website
                    </a> --}}

                    <div class="relative hidden sm:block" @click.outside="profileOpen = false">
                        <button type="button" @click="profileOpen = ! profileOpen" :aria-expanded="profileOpen"
                            class="group flex min-h-11 items-center gap-2 rounded-xl border border-slate-200 bg-white p-1.5 pr-2 shadow-sm transition duration-300 hover:border-red-200 hover:bg-red-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b]"
                            aria-haspopup="menu" aria-label="Open student menu">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#101928] text-[10px] font-extrabold text-white">{{ $studentInitials ?: 'ST' }}</span>
                            <span class="hidden max-w-28 text-left lg:block">
                                <span class="block truncate text-xs font-bold leading-4 text-[#101928]">{{ $studentName }}</span>
                                <span class="block text-[10px] font-semibold leading-4 text-slate-400">Student</span>
                            </span>
                            <svg class="hidden h-4 w-4 text-slate-400 transition duration-300 group-hover:text-[#a71930] lg:block" :class="profileOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
                        </button>

                        <div x-show="profileOpen" x-transition.origin.top.right x-cloak role="menu"
                            class="absolute right-0 mt-2 w-64 overflow-hidden rounded-2xl border border-slate-200 bg-white p-2 shadow-[0_20px_50px_-20px_rgba(15,23,42,0.35)]">
                            <div class="border-b border-slate-100 px-3 py-3">
                                <p class="truncate text-sm font-extrabold text-[#101928]">{{ $studentName }}</p>
                                <p class="mt-0.5 truncate text-xs font-medium text-slate-500">{{ $studentLrn ? 'LRN '.$studentLrn : auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('student.index') }}" role="menuitem" class="mt-1 flex min-h-10 items-center gap-3 rounded-xl px-3 text-sm font-bold text-slate-600 transition duration-300 hover:bg-red-50 hover:text-[#a71930] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b]">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="3.75"/><path stroke-linecap="round" d="M4.5 20a7.5 7.5 0 0 1 15 0"/></svg>
                                My profile
                            </a>
                            {{-- <a href="{{ route('home') }}" target="_blank" rel="noopener" role="menuitem" class="flex min-h-10 items-center gap-3 rounded-xl px-3 text-sm font-bold text-slate-600 transition duration-300 hover:bg-red-50 hover:text-[#a71930] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b]">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12s3-5.25 8.25-5.25S20.25 12 20.25 12 17.25 17.25 12 17.25 3.75 12 3.75 12Z"/><circle cx="12" cy="12" r="2.25"/></svg>
                                View school website
                            </a> --}}
                            <form method="POST" action="{{ route('logout') }}" class="mt-1 border-t border-slate-100 pt-1">
                                @csrf
                                <button type="submit" role="menuitem" class="flex min-h-10 w-full items-center gap-3 rounded-xl px-3 text-sm font-bold text-slate-600 transition duration-300 hover:bg-red-50 hover:text-[#a71930] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b]">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 8.25 18 12m0 0-3.75 3.75M18 12H7.5M10.5 4.5H5.25a1.5 1.5 0 0 0-1.5 1.5v12a1.5 1.5 0 0 0 1.5 1.5h5.25"/></svg>
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>

                    <button type="button" @click="mobileOpen = ! mobileOpen" :aria-expanded="mobileOpen"
                        class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition duration-300 hover:border-red-200 hover:bg-red-50 hover:text-[#a71930] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] xl:hidden"
                        aria-controls="student-mobile-menu" aria-label="Toggle student navigation">
                        <svg x-show="! mobileOpen" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                        <svg x-show="mobileOpen" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18"/></svg>
                    </button>
                </div>
            </div>

            <nav id="student-mobile-menu" x-show="mobileOpen" x-transition x-cloak @click.outside="mobileOpen = false" class="border-t border-slate-200 bg-white px-4 py-4 shadow-lg xl:hidden" aria-label="Mobile student navigation">
                <div class="mx-auto grid max-w-7xl gap-1 sm:grid-cols-2">
                    @foreach ($studentNavigation as $item)
                        @php($isMobileActive = request()->routeIs($item['active']))
                        <a href="{{ route($item['route']) }}" @click="mobileOpen = false" @if ($isMobileActive) aria-current="page" @endif
                            class="flex min-h-11 items-center rounded-xl px-4 text-sm font-bold {{ $isMobileActive ? 'bg-red-50 text-[#a71930]' : 'text-slate-700 hover:bg-red-50 hover:text-[#a71930]' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                    <div class="mt-3 border-t border-slate-200 pt-3 sm:col-span-2">
                        <div class="mb-2 flex items-center gap-3 px-3 py-2 sm:hidden">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#101928] text-[10px] font-extrabold text-white">{{ $studentInitials ?: 'ST' }}</span>
                            <span class="min-w-0"><span class="block truncate text-sm font-bold text-[#101928]">{{ $studentName }}</span><span class="block truncate text-xs text-slate-400">{{ $studentLrn ? 'LRN '.$studentLrn : 'Student account' }}</span></span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex min-h-11 w-full items-center gap-3 rounded-xl px-4 text-sm font-bold text-slate-600 transition hover:bg-red-50 hover:text-[#a71930] sm:w-auto">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 8.25 18 12m0 0-3.75 3.75M18 12H7.5M10.5 4.5H5.25a1.5 1.5 0 0 0-1.5 1.5v12a1.5 1.5 0 0 0 1.5 1.5h5.25"/></svg>
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </header>

        <main id="student-content" class="student-scrollbar relative flex-1 overflow-y-auto bg-[#fbfaf8]" {!! $attributes ?? '' !!}>
            <div class="pointer-events-none absolute inset-x-0 top-0 h-72 overflow-hidden" aria-hidden="true">
                <div class="absolute -right-28 -top-36 h-80 w-80 rounded-full bg-red-100/45 blur-3xl"></div>
                <div class="absolute left-1/3 -top-52 h-80 w-80 rounded-full bg-slate-200/45 blur-3xl"></div>
            </div>

            <div class="relative mx-auto w-full max-w-7xl px-3 py-6 sm:px-6 sm:py-9 lg:px-8">
                <section class="mb-7 flex flex-col gap-4 rounded-[20px] border border-slate-200 bg-white px-5 py-5 shadow-sm sm:flex-row sm:items-center sm:justify-between sm:px-7" aria-labelledby="student-page-title">
                    <div class="relative pl-4">
                        <span class="absolute inset-y-0 left-0 w-1 rounded-full bg-[#a71930]" aria-hidden="true"></span>
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.18em] text-[#a71930]">Student workspace</p>
                        <h1 id="student-page-title" class="mt-1 text-xl font-extrabold tracking-[-0.025em] text-[#101928] sm:text-2xl">{{ $pageTitle }}</h1>
                    </div>
                    <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-[#fdfcfb] px-3.5 py-2.5">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-[#a71930] ring-1 ring-red-100">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z"/></svg>
                        </span>
                        <span><span class="block text-xs font-bold text-slate-700">{{ now()->format('D, M j') }}</span><span class="block text-[10px] font-semibold text-slate-400">{{ now()->format('Y') }}</span></span>
                    </div>
                </section>

                {{ $slot }}
            </div>
        </main>
    </div>

    @filamentScripts
    @vite('resources/js/app.js')
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700&display=swap" rel="stylesheet" />

    <style>
        [x-cloak] { display: none !important; }
        .admin-scrollbar { scrollbar-color: rgba(255, 255, 255, .16) transparent; scrollbar-width: thin; }
        .admin-scrollbar::-webkit-scrollbar { width: 5px; }
        .admin-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, .16); border-radius: 999px; }
    </style>

    <tallstackui:script />
    @filamentStyles
    @vite('resources/css/app.css')
</head>

@php
    $requestCount = \App\Models\Notification::where('is_read', 0)->count();
    $pageTitle = trim($__env->yieldContent('title')) ?: 'Administration';
    $adminName = auth()->user()->name ?? 'Administrator';
    $adminInitials = collect(preg_split('/\s+/', trim($adminName)))
        ->filter()
        ->take(2)
        ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
        ->implode('');

    $navigationGroups = [
        [
            'label' => 'School setup',
            'items' => [
                ['label' => 'Academic Year', 'route' => 'admin.academic-year', 'active' => 'admin.academic-year', 'icon' => 'calendar-days'],
                ['label' => 'Grade Levels', 'route' => 'admin.grade-level', 'active' => 'admin.grade-level*', 'icon' => 'layers'],
            ],
        ],
        [
            'label' => 'People & records',
            'items' => [
                ['label' => 'Teachers', 'route' => 'admin.staffs', 'active' => 'admin.staffs', 'icon' => 'users'],
                ['label' => 'Students', 'route' => 'admin.students', 'active' => 'admin.students*', 'icon' => 'graduation-cap'],
                ['label' => 'Records', 'route' => 'admin.record', 'active' => 'admin.record', 'icon' => 'archive'],
            ],
        ],
        [
            'label' => 'Communication',
            'items' => [
                ['label' => 'Requests', 'route' => 'admin.request', 'active' => 'admin.request', 'icon' => 'inbox', 'badge' => $requestCount],
                ['label' => 'Calendar', 'route' => 'admin.calendar', 'active' => 'admin.calendar', 'icon' => 'calendar'],
                ['label' => 'Announcements', 'route' => 'admin.announcements', 'active' => 'admin.announcements', 'icon' => 'megaphone'],
            ],
        ],
    ];
@endphp

<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    <div
        x-data="{
            sidebarOpen: false,
            sidebarCollapsed: localStorage.getItem('admin-sidebar-collapsed') === 'true',
            shortDate: '',
            timeWithSeconds: '',
            init() {
                this.updateClock();
                setInterval(() => this.updateClock(), 1000);
            },
            updateClock() {
                const now = new Date();
                this.shortDate = new Intl.DateTimeFormat('en-US', {
                    weekday: 'short',
                    month: 'short',
                    day: 'numeric'
                }).format(now);
                this.timeWithSeconds = new Intl.DateTimeFormat('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    second: '2-digit'
                }).format(now);
            },
            toggleSidebar() {
                this.sidebarCollapsed = ! this.sidebarCollapsed;
                localStorage.setItem('admin-sidebar-collapsed', this.sidebarCollapsed);
            }
        }"
        class="flex min-h-screen overflow-x-hidden"
    >
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            x-cloak
            @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-sm lg:hidden"
        ></div>

        <aside
            class="fixed inset-y-0 left-0 z-50 flex w-72 shrink-0 -translate-x-full flex-col bg-gradient-to-b from-red-600 via-red-600 to-main text-white shadow-2xl shadow-red-950/30 transition-all duration-300 ease-out lg:static lg:translate-x-0 lg:shadow-none"
            :class="{
                'translate-x-0': sidebarOpen,
                '-translate-x-full': ! sidebarOpen,
                'lg:w-20': sidebarCollapsed,
                'lg:w-72': ! sidebarCollapsed
            }"
            aria-label="Admin navigation"
        >
            <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden">
                <img src="{{ asset('images/bg.jpg') }}" class="h-full w-full object-cover opacity-10" alt="">
                <div class="absolute -left-12 -top-16 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
            </div>

            <div class="relative z-10 flex h-20 shrink-0 items-center border-b border-white/20 px-5">
                <a href="{{ route('admin.dashboard') }}" class="relative flex min-w-0 items-center gap-3">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white p-1.5 shadow-lg shadow-black/20">
                        <img src="{{ asset('images/tmcnhs_logo.png') }}" class="h-full w-full object-contain" alt="School logo">
                    </span>
                    <span class="min-w-0 leading-tight" :class="sidebarCollapsed ? 'lg:hidden' : ''">
                        <span class="block truncate text-sm font-bold tracking-wide">TMCNHS</span>
                        <span class="block truncate text-[11px] font-medium text-white/70">Records Management</span>
                    </span>
                </a>

                <button type="button" @click="sidebarOpen = false"
                    class="relative ml-auto rounded-xl p-2 text-white/70 transition hover:bg-white/15 hover:text-white lg:hidden"
                    aria-label="Close navigation">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M6 6l12 12M18 6 6 18" />
                    </svg>
                </button>
            </div>

            <nav class="admin-scrollbar relative z-10 flex-1 space-y-6 overflow-y-auto overflow-x-hidden px-3 py-6">
                @foreach ($navigationGroups as $group)
                    <section>
                        <div class="mb-2 px-3" :class="sidebarCollapsed ? 'lg:px-1' : ''">
                            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-white/60"
                                :class="sidebarCollapsed ? 'lg:hidden' : ''">{{ $group['label'] }}</p>
                            <span class="hidden h-px bg-white/20" :class="sidebarCollapsed ? 'lg:block' : ''"></span>
                        </div>

                        <ul class="space-y-1">
                            @foreach ($group['items'] as $item)
                                @php($isActive = request()->routeIs($item['active']))
                                <li>
                                    <a href="{{ route($item['route']) }}" title="{{ $item['label'] }}"
                                        @click="sidebarOpen = false"
                                        class="group relative flex min-h-11 items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition duration-200 {{ $isActive ? 'bg-white text-main shadow-lg shadow-red-950/15' : 'text-white/80 hover:bg-white/15 hover:text-white' }}"
                                        :class="sidebarCollapsed ? 'lg:justify-center lg:px-2' : ''"
                                        @if ($isActive) aria-current="page" @endif>
                                        <span class="flex h-5 w-5 shrink-0 items-center justify-center">
                                            @switch($item['icon'])
                                                @case('calendar-days')
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z" />
                                                    </svg>
                                                    @break
                                                @case('layers')
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 7.5 8.25-4.5 8.25 4.5L12 12 3.75 7.5Zm0 4.5L12 16.5l8.25-4.5M3.75 16.5 12 21l8.25-4.5" />
                                                    </svg>
                                                    @break
                                                @case('users')
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.1a7.5 7.5 0 0 1 15 0A17.9 17.9 0 0 1 12 21.75a17.9 17.9 0 0 1-7.5-1.65Z" />
                                                    </svg>
                                                    @break
                                                @case('graduation-cap')
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m3 9 9-5 9 5-9 5-9-5Zm3 2.25V16c3.5 2.4 8.5 2.4 12 0v-4.75M21 9v6" />
                                                    </svg>
                                                    @break
                                                @case('archive')
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5v3H3.75v-3Zm1.5 3v11.25h13.5V8.25M9.75 12h4.5" />
                                                    </svg>
                                                    @break
                                                @case('inbox')
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.5h16.5v15H3.75v-15Zm0 9h4.5l1.5 2.25h4.5l1.5-2.25h4.5" />
                                                    </svg>
                                                    @break
                                                @case('calendar')
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 9h16.5M5.25 4.5h13.5a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z" />
                                                    </svg>
                                                    @break
                                                @case('megaphone')
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 11.25v3h3l9 4.5V6.75l-9 4.5h-3Zm12-1.5a4.5 4.5 0 0 1 0 6M6.75 14.25l1.5 5.25h3" />
                                                    </svg>
                                                    @break
                                            @endswitch
                                        </span>
                                        <span class="min-w-0 flex-1 truncate" :class="sidebarCollapsed ? 'lg:hidden' : ''">{{ $item['label'] }}</span>

                                        @if (isset($item['badge']) && $item['badge'] > 0)
                                            <span
                                                class="flex h-5 min-w-5 items-center justify-center rounded-full px-1.5 text-[10px] font-bold {{ $isActive ? 'bg-main text-white' : 'bg-white text-main' }}"
                                                :class="sidebarCollapsed ? 'lg:absolute lg:-right-1 lg:-top-1' : ''">
                                                {{ $item['badge'] > 99 ? '99+' : $item['badge'] }}
                                            </span>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endforeach
            </nav>

            <div class="relative z-10 shrink-0 border-t border-white/20 p-3">
                <div class="mb-2 flex items-center gap-3 rounded-xl bg-white/10 p-2.5"
                    :class="sidebarCollapsed ? 'lg:justify-center lg:px-2' : ''">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-xs font-bold text-main shadow-sm">
                        {{ $adminInitials ?: 'AD' }}
                    </span>
                    <span class="min-w-0" :class="sidebarCollapsed ? 'lg:hidden' : ''">
                        <span class="block truncate text-sm font-semibold text-white">{{ $adminName }}</span>
                        <span class="block text-[11px] font-medium capitalize text-white/60">{{ auth()->user()->user_type ?? 'Admin' }}</span>
                    </span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Sign out"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-white/80 transition hover:bg-white/15 hover:text-white"
                        :class="sidebarCollapsed ? 'lg:justify-center lg:px-2' : ''">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 8.25 18 12m0 0-3.75 3.75M18 12H7.5M10.5 4.5H5.25a1.5 1.5 0 0 0-1.5 1.5v12a1.5 1.5 0 0 0 1.5 1.5h5.25" />
                        </svg>
                        <span :class="sidebarCollapsed ? 'lg:hidden' : ''">Sign out</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
                <div class="flex h-20 items-center gap-3 px-4 sm:px-6 lg:px-8">
                    <button type="button" @click="sidebarOpen = true"
                        class="rounded-xl border border-slate-200 bg-white p-2.5 text-slate-600 shadow-sm transition hover:border-slate-300 hover:text-slate-950 lg:hidden"
                        aria-label="Open navigation">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                        </svg>
                    </button>

                    <button type="button" @click="toggleSidebar()"
                        class="hidden rounded-xl p-2.5 text-slate-400 transition hover:bg-slate-100 hover:text-slate-800 lg:block"
                        :aria-label="sidebarCollapsed ? 'Expand navigation' : 'Collapse navigation'">
                        <svg class="h-5 w-5 transition-transform duration-300" :class="sidebarCollapsed ? 'rotate-180' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                            <span>Admin</span>
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" />
                            </svg>
                            <span class="truncate text-main">{{ $pageTitle }}</span>
                        </div>
                        <h1 class="mt-0.5 truncate text-lg font-bold tracking-tight text-slate-950 sm:text-xl">{{ $pageTitle }}</h1>
                    </div>

                    <div class="ml-auto flex items-center gap-3">
                        <div class="flex items-center gap-2 rounded-xl px-1.5 py-1 sm:gap-3 sm:px-3" aria-label="Current date and time">
                                <span class="hidden h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-50 text-main md:flex">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z" />
                                    </svg>
                                </span>
                                <span class="text-right">
                                    <span class="block whitespace-nowrap text-xs font-semibold leading-4 text-slate-700 sm:text-sm sm:leading-5" x-text="shortDate"></span>
                                    <span class="block whitespace-nowrap text-[11px] font-medium leading-4 text-slate-400 sm:text-xs" x-text="timeWithSeconds"></span>
                                </span>
                        </div>
                        <div class="hidden h-9 w-px bg-slate-200 sm:block"></div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-950 text-xs font-bold text-white shadow-sm">
                            {{ $adminInitials ?: 'AD' }}
                        </div>
                    </div>
                </div>
            </header>

            <main class="relative flex-1 overflow-y-auto">
                <div class="pointer-events-none absolute inset-x-0 top-0 h-72 overflow-hidden">
                    <div class="absolute -right-28 -top-36 h-80 w-80 rounded-full bg-red-100/70 blur-3xl"></div>
                    <div class="absolute left-1/3 -top-52 h-80 w-80 rounded-full bg-slate-200/60 blur-3xl"></div>
                </div>

                <div class="relative mx-auto w-full max-w-[1600px] px-4 py-7 sm:px-6 sm:py-9 lg:px-8">
                    <section class="mb-7 overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm shadow-slate-200/50">
                        <div class="relative flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
                            <div class="absolute inset-y-0 left-0 w-1 bg-main"></div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.16em] text-main">Administration workspace</p>
                                <p class="mt-1 text-lg font-semibold text-slate-900">Welcome back, {{ $adminName }}</p>
                            </div>
                            <div class="flex items-center gap-2 text-sm font-medium text-slate-500">
                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-50"></span>
                                    <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                </span>
                                System ready
                            </div>
                        </div>
                    </section>

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>

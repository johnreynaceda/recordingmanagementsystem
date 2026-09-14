<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TMCNHS | @yield('title', 'Administration')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800&display=swap" rel="stylesheet" />

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Manrope', sans-serif; }
        .admin-scrollbar { scrollbar-color: rgba(255, 255, 255, .28) transparent; scrollbar-width: thin; }
        .admin-scrollbar::-webkit-scrollbar { width: 5px; }
        .admin-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, .28); border-radius: 999px; }
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

<body class="min-h-screen bg-[#fbfaf8] text-slate-800 antialiased">
    <a href="#admin-content" class="sr-only z-[100] rounded-lg bg-white px-4 py-3 font-bold text-[#a71930] shadow-lg focus:not-sr-only focus:fixed focus:left-4 focus:top-4">Skip to main content</a>
    <div
        x-data="{
            sidebarOpen: false,
            sidebarCollapsed: localStorage.getItem('admin-sidebar-collapsed') === 'true',
            profileOpen: false,
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
            class="fixed inset-0 z-40 bg-[#101928]/45 backdrop-blur-sm lg:hidden"
        ></div>

        <aside
            class="fixed inset-y-0 left-0 z-50 flex w-72 shrink-0 -translate-x-full flex-col bg-gradient-to-b from-[#8f142a] via-[#a71930] to-[#861326] text-white shadow-2xl shadow-red-950/25 transition-all duration-300 ease-out lg:static lg:translate-x-0 lg:shadow-none"
            :class="{
                'translate-x-0': sidebarOpen,
                '-translate-x-full': ! sidebarOpen,
                'lg:w-20': sidebarCollapsed,
                'lg:w-72': ! sidebarCollapsed
            }"
            aria-label="Admin navigation"
        >
            <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
                <img src="{{ asset('images/bg.jpg') }}" class="h-full w-full object-cover object-center opacity-[0.14]" alt="">
                <div class="absolute inset-0 bg-gradient-to-b from-[#8f142a]/45 via-[#a71930]/65 to-[#861326]/85"></div>
            </div>
            <div class="absolute inset-x-0 top-0 z-20 h-1 bg-gradient-to-r from-[#8d1429] via-[#c52a45] to-[#e56a79]" aria-hidden="true"></div>

            <div class="relative z-10 flex h-20 shrink-0 items-center border-b border-white/15 px-5">
                <a href="{{ route('admin.dashboard') }}" class="relative flex min-w-0 items-center gap-3 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-2">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-white p-1 shadow-sm ring-1 ring-slate-200">
                        <img src="{{ asset('images/tmcnhs_logo.png') }}" class="h-full w-full object-contain" alt="School logo">
                    </span>
                    <span class="min-w-0 leading-tight" :class="sidebarCollapsed ? 'lg:hidden' : ''">
                        <span class="block truncate text-sm font-extrabold tracking-wide text-white">TMCNHS</span>
                        <span class="block truncate text-[11px] font-semibold text-white/65">Records Management</span>
                    </span>
                </a>

                <button type="button" @click="sidebarOpen = false"
                    class="relative ml-auto rounded-xl p-2 text-white/70 transition duration-300 hover:bg-white/10 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white lg:hidden"
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
                            <p class="text-[10px] font-extrabold uppercase tracking-[0.18em] text-white/55"
                                :class="sidebarCollapsed ? 'lg:hidden' : ''">{{ $group['label'] }}</p>
                            <span class="hidden h-px bg-white/15" :class="sidebarCollapsed ? 'lg:block' : ''"></span>
                        </div>

                        <ul class="space-y-1">
                            @foreach ($group['items'] as $item)
                                @php($isActive = request()->routeIs($item['active']))
                                <li>
                                    <a href="{{ route($item['route']) }}" title="{{ $item['label'] }}"
                                        @click="sidebarOpen = false"
                                        class="group relative flex min-h-11 items-center gap-3 rounded-xl border px-3 py-2.5 text-sm font-bold transition duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-[#a71930] {{ $isActive ? 'border-white bg-white text-[#a71930] shadow-lg shadow-red-950/15' : 'border-transparent text-white/80 hover:border-white/10 hover:bg-white/10 hover:text-white' }}"
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
                                                class="flex h-5 min-w-5 items-center justify-center rounded-full px-1.5 text-[10px] font-extrabold {{ $isActive ? 'bg-[#a71930] text-white' : 'bg-white text-[#a71930]' }}"
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

            <div class="relative z-10 shrink-0 border-t border-white/15 bg-red-950/10 p-3">
                <div class="mb-2 flex items-center gap-3 rounded-xl border border-white/10 bg-white/10 p-2.5"
                    :class="sidebarCollapsed ? 'lg:justify-center lg:px-2' : ''">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-xs font-extrabold text-[#a71930] shadow-sm">
                        {{ $adminInitials ?: 'AD' }}
                    </span>
                    <span class="min-w-0" :class="sidebarCollapsed ? 'lg:hidden' : ''">
                        <span class="block truncate text-sm font-bold text-white">{{ $adminName }}</span>
                        <span class="block text-[11px] font-semibold capitalize text-white/55">{{ auth()->user()->user_type ?? 'Admin' }}</span>
                    </span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Sign out"
                        class="flex min-h-11 w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-bold text-white/75 transition duration-300 hover:bg-white/10 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-[#a71930]"
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
            <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/95 shadow-[0_4px_18px_rgba(15,23,42,0.035)] backdrop-blur-md">
                <div class="mx-auto flex h-[76px] w-full max-w-[1600px] items-center gap-3 px-4 sm:px-6 lg:px-8">
                    <button type="button" @click="sidebarOpen = true"
                        class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition duration-300 hover:border-red-200 hover:bg-red-50 hover:text-[#a71930] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] lg:hidden"
                        aria-label="Open navigation">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                        </svg>
                    </button>

                    <button type="button" @click="toggleSidebar()"
                        class="hidden h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-400 shadow-sm transition duration-300 hover:border-red-200 hover:bg-red-50 hover:text-[#a71930] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] lg:inline-flex"
                        :aria-label="sidebarCollapsed ? 'Expand navigation' : 'Collapse navigation'">
                        <svg class="h-5 w-5 transition-transform duration-300" :class="sidebarCollapsed ? 'rotate-180' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                        </svg>
                    </button>

                    <div class="hidden h-9 w-px bg-slate-200 lg:block" aria-hidden="true"></div>

                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-[10px] font-extrabold uppercase tracking-[0.16em] text-slate-400">
                            <span>Administration</span>
                            <span class="h-1 w-1 rounded-full bg-[#b4233b]" aria-hidden="true"></span>
                            <span class="hidden truncate text-[#a71930] sm:inline">School Management Portal</span>
                        </div>
                        <h1 class="mt-0.5 truncate text-lg font-extrabold tracking-[-0.025em] text-[#101928] sm:text-xl">{{ $pageTitle }}</h1>
                    </div>

                    <div class="ml-auto flex items-center gap-2 sm:gap-3">
                     

                        <div class="hidden items-center gap-3 rounded-xl border border-slate-200 bg-[#fdfcfb] px-3 py-2 md:flex" aria-label="Current date and time">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-50 text-[#a71930] ring-1 ring-red-100">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z" /></svg>
                            </span>
                            <span>
                                <span class="block whitespace-nowrap text-xs font-bold leading-4 text-slate-700" x-text="shortDate"></span>
                                <span class="block whitespace-nowrap text-[10px] font-semibold leading-4 text-slate-400" x-text="timeWithSeconds"></span>
                            </span>
                        </div>

                        <div class="relative" @click.outside="profileOpen = false">
                            <button type="button" @click="profileOpen = ! profileOpen" :aria-expanded="profileOpen"
                                class="group flex min-h-11 items-center gap-2 rounded-xl border border-slate-200 bg-white p-1.5 pr-2 shadow-sm transition duration-300 hover:border-red-200 hover:bg-red-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b]"
                                aria-haspopup="menu" aria-label="Open administrator menu">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#101928] text-[10px] font-extrabold text-white">{{ $adminInitials ?: 'AD' }}</span>
                                <span class="hidden max-w-32 text-left sm:block">
                                    <span class="block truncate text-xs font-bold leading-4 text-[#101928]">{{ $adminName }}</span>
                                    <span class="block text-[10px] font-semibold capitalize leading-4 text-slate-400">{{ auth()->user()->user_type ?? 'Admin' }}</span>
                                </span>
                                <svg class="hidden h-4 w-4 text-slate-400 transition duration-300 group-hover:text-[#a71930] sm:block" :class="profileOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
                            </button>

                            <div x-show="profileOpen" x-transition.origin.top.right x-cloak
                                class="absolute right-0 mt-2 w-64 overflow-hidden rounded-2xl border border-slate-200 bg-white p-2 shadow-[0_20px_50px_-20px_rgba(15,23,42,0.35)]"
                                role="menu">
                                <div class="border-b border-slate-100 px-3 py-3">
                                    <p class="truncate text-sm font-extrabold text-[#101928]">{{ $adminName }}</p>
                                    <p class="mt-0.5 truncate text-xs font-medium text-slate-500">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" role="menuitem"
                                    class="mt-1 flex min-h-10 items-center gap-3 rounded-xl px-3 text-sm font-bold text-slate-600 transition duration-300 hover:bg-red-50 hover:text-[#a71930] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b]">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="3.75"/><path stroke-linecap="round" d="M4.5 20a7.5 7.5 0 0 1 15 0"/></svg>
                                    Account settings
                                </a>
                                <a href="{{ route('home') }}" target="_blank" rel="noopener" role="menuitem"
                                    class="flex min-h-10 items-center gap-3 rounded-xl px-3 text-sm font-bold text-slate-600 transition duration-300 hover:bg-red-50 hover:text-[#a71930] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] xl:hidden">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12s3-5.25 8.25-5.25S20.25 12 20.25 12 17.25 17.25 12 17.25 3.75 12 3.75 12Z"/><circle cx="12" cy="12" r="2.25"/></svg>
                                    View school website
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="mt-1 border-t border-slate-100 pt-1">
                                    @csrf
                                    <button type="submit" role="menuitem" class="flex min-h-10 w-full items-center gap-3 rounded-xl px-3 text-sm font-bold text-slate-600 transition duration-300 hover:bg-red-50 hover:text-[#a71930] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b]">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 8.25 18 12m0 0-3.75 3.75M18 12H7.5M10.5 4.5H5.25a1.5 1.5 0 0 0-1.5 1.5v12a1.5 1.5 0 0 0 1.5 1.5h5.25"/></svg>
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main id="admin-content" class="relative flex-1 overflow-y-auto bg-[#fbfaf8]">
                <div class="pointer-events-none absolute inset-x-0 top-0 h-72 overflow-hidden">
                    <div class="absolute -right-28 -top-36 h-80 w-80 rounded-full bg-red-100/45 blur-3xl"></div>
                    <div class="absolute left-1/3 -top-52 h-80 w-80 rounded-full bg-slate-200/45 blur-3xl"></div>
                </div>

                <div class="relative mx-auto w-full max-w-[1600px] px-4 py-7 sm:px-6 sm:py-9 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>

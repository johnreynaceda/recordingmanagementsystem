<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Official website of Trece Martires City National High School — school information, enrollment guidance, announcements, and secure portal access.">
    <title>TMCNHS | @yield('title', 'Official School Portal')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800" rel="stylesheet" />
    <style>[x-cloak]{display:none!important} body{font-family:'Manrope',sans-serif}</style>
    @filamentStyles
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-[#fbfaf8] text-slate-800 antialiased">
    <a href="#main-content" class="sr-only z-[100] rounded-lg bg-white px-4 py-3 font-bold text-[#a71930] shadow-lg focus:not-sr-only focus:fixed focus:left-4 focus:top-4">Skip to main content</a>

    <div class="border-b border-red-950/10 bg-[#9f1830] text-white">
        <div class="mx-auto flex min-h-10 max-w-7xl flex-wrap items-center justify-center gap-x-6 gap-y-2 px-4 py-2 text-[11px] font-semibold sm:px-6 sm:text-xs lg:justify-start lg:px-8">
            <a href="mailto:301222@deped.gov.ph" class="inline-flex items-center gap-2 text-white/90 transition hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white/70">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6.75 10.64 12a2.4 2.4 0 0 0 2.72 0L21 6.75M5.25 19.5h13.5A2.25 2.25 0 0 0 21 17.25V6.75a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6.75v10.5a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>301222@deped.gov.ph
            </a>
            <span class="hidden h-3.5 w-px bg-white/25 sm:block" aria-hidden="true"></span>
            <a href="tel:0466931" class="inline-flex items-center gap-2 text-white/90 transition hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white/70">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106a1.125 1.125 0 0 0-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.04 12.04 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.272.526-.736.417-1.173L6.963 3.102A1.125 1.125 0 0 0 5.872 2.25H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>(046) 6931
            </a>
            <span class="hidden h-3.5 w-px bg-white/25 sm:block" aria-hidden="true"></span>
            <span class="inline-flex items-center gap-2 text-center text-white/90">
                <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7.5-4.35 7.5-11.25a7.5 7.5 0 1 0-15 0C4.5 16.65 12 21 12 21Z"/><circle cx="12" cy="9.75" r="2.25"/></svg>Brgy. San Agustin, Trece Martires City, Cavite
            </span>
        </div>
    </div>

    <header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/95 shadow-[0_4px_18px_rgba(15,23,42,0.035)] backdrop-blur-md">
        <div class="mx-auto flex h-[76px] max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="group flex min-w-0 items-center gap-3 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-4" aria-label="TMCNHS home">
                <img src="{{ asset('images/tmcnhs_logo.png') }}" class="h-[54px] w-[54px] shrink-0 object-contain transition duration-300 group-hover:scale-[1.03]" alt="Trece Martires City National High School seal">
                <span class="hidden min-w-0 sm:block"><span class="block text-[10px] font-extrabold uppercase tracking-[0.18em] text-[#b4233b]">Official School Website</span><span class="mt-0.5 block truncate text-sm font-extrabold tracking-tight text-slate-900 lg:text-[15px]">Trece Martires City National High School</span></span>
            </a>
            <nav class="hidden items-center gap-7 lg:flex" aria-label="Primary navigation">
                <a href="{{ route('home') }}" class="border-b-2 py-7 text-sm font-bold transition {{ request()->routeIs('home') ? 'border-[#b4233b] text-[#a71930]' : 'border-transparent text-slate-600 hover:text-[#a71930]' }}">Home</a>
                <a href="{{ route('about') }}" class="border-b-2 py-7 text-sm font-bold transition {{ request()->routeIs('about') ? 'border-[#b4233b] text-[#a71930]' : 'border-transparent text-slate-600 hover:text-[#a71930]' }}">About Us</a>
                <a href="{{ route('how-to-enroll') }}" class="border-b-2 py-7 text-sm font-bold transition {{ request()->routeIs('how-to-enroll') ? 'border-[#b4233b] text-[#a71930]' : 'border-transparent text-slate-600 hover:text-[#a71930]' }}">How to Enroll</a>
                <a href="{{ route('home') }}#programs" class="border-b-2 border-transparent py-7 text-sm font-bold text-slate-600 transition hover:text-[#a71930]">K–12 Program</a>
                <a href="{{ route('announcements') }}" class="border-b-2 py-7 text-sm font-bold transition {{ request()->routeIs('announcements') ? 'border-[#b4233b] text-[#a71930]' : 'border-transparent text-slate-600 hover:text-[#a71930]' }}">Announcements</a>
            </nav>
            <button id="menu-button" type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-800 transition hover:border-red-200 hover:text-[#a71930] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] lg:hidden" aria-controls="mobile-menu" aria-expanded="false" aria-label="Open navigation menu">
                <svg id="menu-open-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg><svg id="menu-close-icon" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
        </div>
        <nav id="mobile-menu" class="hidden border-t border-slate-200 bg-white px-4 py-4 shadow-lg lg:hidden" aria-label="Mobile navigation">
            <div class="mx-auto grid max-w-7xl gap-1">
                <a href="{{ route('home') }}" class="rounded-xl px-4 py-3 text-sm font-bold {{ request()->routeIs('home') ? 'bg-red-50 text-[#a71930]' : 'text-slate-700 hover:bg-red-50 hover:text-[#a71930]' }}">Home</a>
                <a href="{{ route('about') }}" class="rounded-xl px-4 py-3 text-sm font-bold {{ request()->routeIs('about') ? 'bg-red-50 text-[#a71930]' : 'text-slate-700 hover:bg-red-50 hover:text-[#a71930]' }}">About Us</a>
                <a href="{{ route('how-to-enroll') }}" class="rounded-xl px-4 py-3 text-sm font-bold {{ request()->routeIs('how-to-enroll') ? 'bg-red-50 text-[#a71930]' : 'text-slate-700 hover:bg-red-50 hover:text-[#a71930]' }}">How to Enroll</a>
                <a href="{{ route('home') }}#programs" class="rounded-xl px-4 py-3 text-sm font-bold text-slate-700 hover:bg-red-50 hover:text-[#a71930]">K–12 Program</a>
                <a href="{{ route('announcements') }}" class="rounded-xl px-4 py-3 text-sm font-bold {{ request()->routeIs('announcements') ? 'bg-red-50 text-[#a71930]' : 'text-slate-700 hover:bg-red-50 hover:text-[#a71930]' }}">Announcements</a>
            </div>
        </nav>
    </header>

    <main id="main-content">{{ $slot }}</main>

    <footer class="border-t border-slate-200 bg-[#101928] text-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-2 lg:grid-cols-12 lg:px-8 lg:py-16">
            <div class="lg:col-span-5">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-4 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
                    <span class="flex h-16 w-16 items-center justify-center rounded-full bg-white p-1.5"><img src="{{ asset('images/tmcnhs_logo.png') }}" class="h-full w-full object-contain" alt=""></span>
                    <span><span class="block text-lg font-extrabold leading-tight">Trece Martires City</span><span class="block text-sm font-semibold text-slate-300">National High School</span></span>
                </a>
                <p class="mt-5 max-w-md text-sm leading-7 text-slate-400">Committed to quality education, strong character, and meaningful opportunities for every learner.</p>
                <div class="mt-6 flex gap-3" aria-label="Social media links">
                    <a href="#" aria-label="Facebook" class="flex h-10 w-10 items-center justify-center rounded-full border border-white/15 text-slate-300 transition hover:border-white/40 hover:bg-white/10 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-8h2.75l.41-3.15H13.5V7.84c0-.91.26-1.53 1.58-1.53h1.69V3.5a22.8 22.8 0 0 0-2.46-.13c-2.43 0-4.1 1.45-4.1 4.13v2.35H7.45V13h2.76v8h3.29Z"/></svg></a>
                    <a href="mailto:301222@deped.gov.ph" aria-label="Email the school" class="flex h-10 w-10 items-center justify-center rounded-full border border-white/15 text-slate-300 transition hover:border-white/40 hover:bg-white/10 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 7 7.6 5.2a2.5 2.5 0 0 0 2.8 0L21 7M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z"/></svg></a>
                </div>
            </div>
            <div class="lg:col-span-3">
                <h2 class="text-xs font-extrabold uppercase tracking-[0.18em] text-white">Quick Links</h2>
                <ul class="mt-5 space-y-3 text-sm text-slate-400">
                    <li><a href="{{ route('about') }}" class="transition hover:text-white">About the school</a></li><li><a href="{{ route('how-to-enroll') }}" class="transition hover:text-white">Enrollment guide</a></li><li><a href="{{ route('announcements') }}" class="transition hover:text-white">Latest announcements</a></li><li><a href="{{ route('student-login') }}" class="transition hover:text-white">Student portal</a></li><li><a href="{{ route('faculty-staff-login') }}" class="transition hover:text-white">Faculty &amp; staff portal</a></li>
                </ul>
            </div>
            <div class="lg:col-span-4">
                <h2 class="text-xs font-extrabold uppercase tracking-[0.18em] text-white">Contact Information</h2>
                <ul class="mt-5 space-y-4 text-sm leading-6 text-slate-400">
                    <li class="flex gap-3"><svg class="mt-1 h-4 w-4 shrink-0 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7.5-4.35 7.5-11.25a7.5 7.5 0 1 0-15 0C4.5 16.65 12 21 12 21Z"/><circle cx="12" cy="9.75" r="2.25"/></svg><span>Brgy. San Agustin, Trece Martires City, Cavite, Philippines</span></li>
                    <li class="flex gap-3"><svg class="mt-1 h-4 w-4 shrink-0 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 10.6 12.7a2.5 2.5 0 0 0 2.8 0L21 7.5M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z"/></svg><a href="mailto:301222@deped.gov.ph" class="transition hover:text-white">301222@deped.gov.ph</a></li>
                    <li class="flex gap-3"><svg class="mt-1 h-4 w-4 shrink-0 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5.25c0 8.7 7.05 15.75 15.75 15.75h1.5a.75.75 0 0 0 .75-.75v-3.1l-4.4-1.1-1.7 1.7a13.1 13.1 0 0 1-8.65-8.65l1.7-1.7-1.1-4.4h-3.1a.75.75 0 0 0-.75.75v1.5Z"/></svg><a href="tel:0466931" class="transition hover:text-white">(046) 6931</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10"><div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-5 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8"><p>&copy; {{ date('Y') }} Trece Martires City National High School. All rights reserved.</p><p>Official School Portal</p></div></div>
    </footer>

    @filamentScripts
    @vite('resources/js/app.js')
    <script>
        (() => {
            const button = document.getElementById('menu-button'), menu = document.getElementById('mobile-menu'), openIcon = document.getElementById('menu-open-icon'), closeIcon = document.getElementById('menu-close-icon');
            if (!button || !menu) return;
            button.addEventListener('click', () => {
                const isOpen = button.getAttribute('aria-expanded') === 'true';
                button.setAttribute('aria-expanded', String(!isOpen));
                button.setAttribute('aria-label', isOpen ? 'Open navigation menu' : 'Close navigation menu');
                menu.classList.toggle('hidden', isOpen); openIcon.classList.toggle('hidden', !isOpen); closeIcon.classList.toggle('hidden', isOpen);
            });
        })();
    </script>
</body>
</html>

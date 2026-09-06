<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Access Denied | {{ config('app.name', 'TMCNHS') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700&display=swap" rel="stylesheet" />

    @vite('resources/css/app.css')
</head>

@php
    $user = auth()->user();
    $dashboardRoute = match ($user?->user_type) {
        'admin' => 'admin.dashboard',
        'teacher' => 'teacher.dashboard',
        'student' => 'student.index',
        default => 'home',
    };
    $dashboardLabel = $user ? 'Return to my dashboard' : 'Return to homepage';
@endphp

<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    <main class="relative isolate flex min-h-screen items-center justify-center overflow-hidden px-5 py-12 sm:px-8">
        <div class="pointer-events-none absolute inset-0 -z-10">
            <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full bg-red-100/80 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-24 h-96 w-96 rounded-full bg-slate-200/80 blur-3xl"></div>
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-red-700 via-main to-red-400"></div>
        </div>

        <section class="w-full max-w-3xl overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl shadow-slate-300/40">
            <div class="grid lg:grid-cols-[.9fr_1.1fr]">
                <div class="relative flex min-h-64 items-center justify-center overflow-hidden bg-gradient-to-br from-red-600 to-main px-8 py-10 text-white lg:min-h-[500px]">
                    <img src="{{ asset('images/bg.jpg') }}" class="absolute inset-0 h-full w-full object-cover opacity-10" alt="">
                    <div class="absolute -right-20 -top-20 h-56 w-56 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="absolute -bottom-24 -left-20 h-64 w-64 rounded-full bg-red-950/20 blur-3xl"></div>

                    <div class="relative text-center">
                        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-white/15 ring-1 ring-white/25 backdrop-blur-sm">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.25 4.5 6.5v5.25c0 4.25 3.1 7.8 7.5 9 4.4-1.2 7.5-4.75 7.5-9V6.5L12 3.25Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.5 11V9.75a2.5 2.5 0 0 1 5 0V11m-5.75 0h6.5v5h-6.5v-5Z" />
                            </svg>
                        </div>
                        <p class="mt-7 text-7xl font-bold tracking-tighter sm:text-8xl">403</p>
                        <p class="mt-1 text-xs font-bold uppercase tracking-[0.22em] text-white/70">Restricted area</p>
                    </div>
                </div>

                <div class="flex flex-col justify-center px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                    <a href="{{ route('home') }}" class="mb-9 inline-flex w-fit items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white p-1.5 shadow-sm">
                            <img src="{{ asset('images/tmcnhs_logo.png') }}" class="h-full w-full object-contain" alt="TMCNHS logo">
                        </span>
                        <span class="leading-tight">
                            <span class="block text-sm font-bold tracking-wide text-slate-950">TMCNHS</span>
                            <span class="block text-[11px] font-medium text-slate-500">Records Management</span>
                        </span>
                    </a>

                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-main">Access denied</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">This page isn't available to your account.</h1>
                    <p class="mt-4 text-base font-medium leading-7 text-slate-600">
                        You're signed in, but your role does not have permission to access this area. Return to your dashboard to continue safely.
                    </p>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route($dashboardRoute) }}"
                            class="inline-flex min-h-12 items-center justify-center gap-2 rounded-xl bg-slate-950 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-slate-800 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-slate-950 focus:ring-offset-2">
                            {{ $dashboardLabel }}
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" />
                            </svg>
                        </a>

                        <button type="button" onclick="history.back()"
                            class="inline-flex min-h-12 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 shadow-sm transition hover:border-red-200 hover:text-main focus:outline-none focus:ring-2 focus:ring-main focus:ring-offset-2">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                            </svg>
                            Go back
                        </button>
                    </div>

                    <div class="mt-9 border-t border-slate-100 pt-5">
                        <p class="text-xs font-medium leading-5 text-slate-400">
                            If you believe you should have access, please contact the system administrator.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

</html>

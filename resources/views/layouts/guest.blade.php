<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TMCNHS | @yield('title', 'Secure Portal')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800&display=swap" rel="stylesheet" />

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Manrope', sans-serif;
        }
    </style>

    @filamentStyles
    @vite('resources/css/app.css')
</head>

<body class="bg-[#fbfaf8] text-slate-800 antialiased">
    <main class="relative isolate flex min-h-screen items-center justify-center overflow-hidden px-4 py-8 sm:px-6 sm:py-12">
        <img src="{{ asset('images/bg.jpg') }}" alt="" class="absolute inset-0 -z-30 h-full w-full object-cover object-center opacity-25" aria-hidden="true">
        <div class="absolute inset-0 -z-20 bg-gradient-to-r from-white/95 via-[#fbfaf8]/95 to-white/75"></div>
        <div class="absolute inset-0 -z-10 bg-gradient-to-t from-[#fbfaf8] via-transparent to-white/60"></div>
        <div class="absolute -left-24 -top-24 -z-10 h-80 w-80 rounded-full bg-red-100/50 blur-3xl" aria-hidden="true"></div>
        <div class="absolute -bottom-28 -right-20 -z-10 h-80 w-80 rounded-full bg-slate-200/60 blur-3xl" aria-hidden="true"></div>

        <div @class([
            'w-full overflow-hidden rounded-[24px] border border-slate-200/90 bg-white shadow-[0_24px_70px_-28px_rgba(15,23,42,0.35)]',
            'sm:max-w-4xl' => $wide ?? false,
            'sm:max-w-lg' => ! ($wide ?? false),
        ])>
            <div class="h-1.5 bg-gradient-to-r from-[#8d1429] via-[#c52a45] to-[#e56a79]"></div>
            <div class="px-5 py-6 sm:px-8 sm:py-8">
                {{ $slot }}
            </div>
        </div>
    </main>
    @livewire('notifications')

    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>

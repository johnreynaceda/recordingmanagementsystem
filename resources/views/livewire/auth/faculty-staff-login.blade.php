@section('title', 'Faculty and Staff Login')

<div>
    <div class="flex items-center justify-between gap-4">
    <a href="{{ route('home') }}"
        class="inline-flex min-h-11 items-center gap-2 rounded-lg px-1 text-sm font-bold text-slate-500 transition duration-300 hover:text-[#a71930] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-2">
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd"
                d="M17 10a.75.75 0 0 1-.75.75H5.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 0 1 1.06 1.06L5.56 9.25h10.69A.75.75 0 0 1 17 10Z"
                clip-rule="evenodd" />
        </svg>
        Back to home
    </a>
        <span class="hidden items-center gap-1.5 text-[10px] font-extrabold uppercase tracking-[0.14em] text-slate-400 sm:inline-flex">
            <svg class="h-3.5 w-3.5 text-[#a71930]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4m5.5-2c0 5.2-3.6 8-8.5 9.5C7.1 20 3.5 17.2 3.5 12V5.5L12 2l8.5 3.5V12Z"/></svg>
            Secure access
        </span>
    </div>

    <div class="mt-5 text-center">
        <a href="{{ route('home') }}" class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-[#fdfcfb] p-1.5 ring-1 ring-slate-200 transition duration-300 hover:scale-[1.03] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-2" aria-label="TMCNHS home">
            <img class="h-full w-full object-contain" src="{{ asset('images/tmcnhs_logo.png') }}" alt="TMCNHS seal">
        </a>
        <span class="mt-5 inline-flex items-center gap-2 rounded-full border border-red-100 bg-red-50 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-[0.16em] text-[#a71930]">
            <span class="h-1.5 w-1.5 rounded-full bg-[#b4233b]"></span>
            Faculty &amp; Staff Portal
        </span>
        <h1 class="mt-3 text-2xl font-extrabold tracking-[-0.025em] text-[#101928] sm:text-3xl">Welcome back</h1>
        <p class="mx-auto mt-2 max-w-sm text-sm font-medium leading-6 text-slate-500">
            Enter your registered school email and password to access faculty and administrative services.
        </p>
    </div>

    @if ($error)
        <div class="mt-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700"
            role="alert">
            <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z"
                    clip-rule="evenodd" />
            </svg>
            <span>{{ $error }}</span>
        </div>
    @endif

    <form wire:submit.prevent="login" class="mt-7" aria-label="Faculty and staff portal sign in">
        {{ $this->form }}

        <div class="mt-5 flex items-center justify-between gap-4">
            <label class="inline-flex cursor-pointer items-center">
                <input type="checkbox" wire:model="remember"
                    class="rounded border-slate-300 text-[#a71930] shadow-sm focus:ring-[#b4233b]">
                <span class="ms-2 text-sm font-medium text-slate-600">Remember me</span>
            </label>

            <a href="{{ route('password.request', ['portal' => 'staff']) }}"
                class="rounded text-sm font-bold text-[#a71930] transition duration-300 hover:text-[#861326] hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-2">
                Forgot password?
            </a>
        </div>

        <button type="submit" wire:loading.attr="disabled" wire:target="login"
            class="mt-6 flex min-h-12 w-full items-center justify-center rounded-xl bg-[#a71930] px-4 py-3 text-sm font-extrabold text-white shadow-lg shadow-red-950/15 transition duration-300 hover:-translate-y-0.5 hover:bg-[#861326] hover:shadow-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-2 active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-60 disabled:hover:translate-y-0">
            <svg wire:loading wire:target="login" class="mr-2 h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none"
                aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0A12 12 0 0 0 0 12h4Z" />
            </svg>
            <span wire:loading.remove wire:target="login">Sign in to portal</span>
            <span wire:loading wire:target="login">Signing in...</span>
        </button>
    </form>

    <div class="mt-7 rounded-2xl border border-slate-200 bg-[#fdfcfb] p-5 text-center text-sm font-medium text-slate-600">
        Signing in as a student?
        <a href="{{ route('student-login') }}" class="rounded font-extrabold text-[#a71930] transition hover:text-[#861326] hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-2">
            Use the student portal
        </a>
    </div>

    <p class="mt-5 flex items-center justify-center gap-2 text-center text-[11px] font-semibold leading-5 text-slate-400">
        <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10V7.5a4 4 0 0 1 8 0V10m-9.25 0h10.5A1.75 1.75 0 0 1 19 11.75v7.5A1.75 1.75 0 0 1 17.25 21H6.75A1.75 1.75 0 0 1 5 19.25v-7.5A1.75 1.75 0 0 1 6.75 10Z"/></svg>
        Authorized faculty and staff access only.
    </p>
</div>

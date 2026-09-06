@section('title', 'Student Login')

<div class="px-1 py-2 sm:px-2">
    <a href="{{ route('home') }}"
        class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 transition hover:text-main focus:outline-none focus:ring-2 focus:ring-main focus:ring-offset-2">
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd"
                d="M17 10a.75.75 0 0 1-.75.75H5.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 0 1 1.06 1.06L5.56 9.25h10.69A.75.75 0 0 1 17 10Z"
                clip-rule="evenodd" />
        </svg>
        Back to home
    </a>

    <div class="mt-6 text-center">
        <img class="mx-auto h-20 w-20 object-contain" src="{{ asset('images/tmcnhs_logo.png') }}"
            alt="TMCNHS logo">
        <span class="mt-4 inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-bold uppercase tracking-wider text-main">
            Student Portal
        </span>
        <h1 class="mt-3 text-2xl font-bold tracking-tight text-gray-900">Welcome back</h1>
        <p class="mt-2 text-sm leading-6 text-gray-600">
            Sign in using your learner reference number.
        </p>
    </div>

    @if (session('status'))
        <div class="mt-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800"
            role="status">
            <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.236 4.45L7.53 9.884a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.137-.089l3.75-5.164Z"
                    clip-rule="evenodd" />
            </svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="mt-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700"
            role="alert">
            <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z"
                    clip-rule="evenodd" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <form wire:submit.prevent="login" class="mt-7">
        {{ $this->form }}

        <div class="mt-5 flex items-center justify-between gap-4">
            <label class="inline-flex cursor-pointer items-center">
                <input type="checkbox" wire:model="remember"
                    class="rounded border-gray-300 text-main shadow-sm focus:ring-main">
                <span class="ms-2 text-sm text-gray-600">Remember me</span>
            </label>

            <a href="{{ route('password.request') }}"
                class="text-sm font-semibold text-main transition hover:text-red-700 hover:underline">
                Forgot password?
            </a>
        </div>

        <button type="submit" wire:loading.attr="disabled" wire:target="login"
            class="mt-6 flex w-full items-center justify-center rounded-xl bg-main px-4 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-main focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60">
            <svg wire:loading wire:target="login" class="mr-2 h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none"
                aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0A12 12 0 0 0 0 12h4Z" />
            </svg>
            <span wire:loading.remove wire:target="login">Sign in as student</span>
            <span wire:loading wire:target="login">Signing in...</span>
        </button>
    </form>

    <div class="mt-7 border-t border-gray-200 pt-6 text-center text-sm text-gray-600">
        Faculty or staff member?
        <a href="{{ route('faculty-staff-login') }}" class="font-semibold text-main hover:text-red-700 hover:underline">
            Use the faculty portal
        </a>
    </div>
</div>

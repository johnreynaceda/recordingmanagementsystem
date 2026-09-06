@section('title', 'Forgot Password')

<div class="px-1 py-2 sm:px-2">
    <div class="text-center">
        <a href="{{ route('home') }}" class="inline-block rounded-full focus:outline-none focus:ring-2 focus:ring-main focus:ring-offset-2">
            <img class="mx-auto h-20 w-20 object-contain" src="{{ asset('images/tmcnhs_logo.png') }}"
                alt="TMCNHS logo">
        </a>

        <h1 class="mt-5 text-2xl font-bold tracking-tight text-gray-900">
            Forgot your password?
        </h1>
        <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-gray-600">
            Enter the email address linked to your account and we'll send you a secure password reset link.
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

    <form wire:submit.prevent="sendResetLink" class="mt-7 space-y-5">
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700">
                Email address
            </label>
            <div class="relative mt-2">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M3 4a2 2 0 0 0-2 2v.217l8.5 4.722a1 1 0 0 0 .971 0L19 6.2V6a2 2 0 0 0-2-2H3Z" />
                        <path d="m19 8.494-7.558 4.199a3 3 0 0 1-2.913 0L1 8.51V14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.494Z" />
                    </svg>
                </div>
                <input id="email" type="email" wire:model.defer="email" autocomplete="email" autofocus required
                    placeholder="you@example.com"
                    class="block w-full rounded-xl border-gray-300 py-3 pl-11 pr-4 text-sm shadow-sm transition placeholder:text-gray-400 focus:border-main focus:ring-main @error('email') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
            </div>

            @error('email')
                <p class="mt-2 text-sm text-red-600" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" wire:loading.attr="disabled" wire:target="sendResetLink"
            class="flex w-full items-center justify-center rounded-xl bg-main px-4 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-main focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60">
            <svg wire:loading wire:target="sendResetLink" class="mr-2 h-4 w-4 animate-spin" viewBox="0 0 24 24"
                fill="none" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0A12 12 0 0 0 0 12h4Z" />
            </svg>
            <span wire:loading.remove wire:target="sendResetLink">Send reset link</span>
            <span wire:loading wire:target="sendResetLink">Sending link...</span>
        </button>
    </form>

    <div class="mt-7 border-t border-gray-200 pt-6 text-center">
        <a href="{{ $portal === 'staff' ? route('faculty-staff-login') : route('student-login') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 transition hover:text-main focus:outline-none focus:ring-2 focus:ring-main focus:ring-offset-2">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M17 10a.75.75 0 0 1-.75.75H5.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 0 1 1.06 1.06L5.56 9.25h10.69A.75.75 0 0 1 17 10Z"
                    clip-rule="evenodd" />
            </svg>
            {{ $portal === 'staff' ? 'Back to faculty and staff login' : 'Back to student login' }}
        </a>
    </div>
</div>

<x-guest-layout>
    <div class="px-1 py-2 sm:px-2">
        <div class="text-center">
            <a href="{{ route('home') }}"
                class="inline-block rounded-full focus:outline-none focus:ring-2 focus:ring-main focus:ring-offset-2">
                <img class="mx-auto h-20 w-20 object-contain" src="{{ asset('images/tmcnhs_logo.png') }}"
                    alt="TMCNHS logo">
            </a>

            <h1 class="mt-5 text-2xl font-bold tracking-tight text-gray-900">
                Create a new password
            </h1>
            <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-gray-600">
                Choose a strong password that you haven't used for this account before.
            </p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="mt-7 space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required
                    autofocus autocomplete="username"
                    class="mt-2 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition focus:border-main focus:ring-main @error('email') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700">New password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="Enter your new password"
                    class="mt-2 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition placeholder:text-gray-400 focus:border-main focus:ring-main @error('password') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                <p class="mt-2 text-xs leading-5 text-gray-500">
                    Use at least 8 characters. A mix of letters, numbers, and symbols is recommended.
                </p>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">
                    Confirm new password
                </label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password" placeholder="Re-enter your new password"
                    class="mt-2 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition placeholder:text-gray-400 focus:border-main focus:ring-main @error('password_confirmation') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button type="submit"
                class="flex w-full items-center justify-center rounded-xl bg-main px-4 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-main focus:ring-offset-2">
                Reset password
            </button>
        </form>

        <div class="mt-7 border-t border-gray-200 pt-6 text-center">
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 transition hover:text-main focus:outline-none focus:ring-2 focus:ring-main focus:ring-offset-2">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M17 10a.75.75 0 0 1-.75.75H5.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 0 1 1.06 1.06L5.56 9.25h10.69A.75.75 0 0 1 17 10Z"
                        clip-rule="evenodd" />
                </svg>
                Back to home
            </a>
        </div>
    </div>
</x-guest-layout>

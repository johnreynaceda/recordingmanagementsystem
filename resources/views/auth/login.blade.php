{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

@section('title', 'Login')
<x-home-layout>
    <div>
        <section class="w-full  py-40  ">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col items-center md:flex-row">

                    <div class="w-full space-y-5 md:w-3/5 md:pr-16">
                        <h1 class="text-center flex flex-col">
                            <span
                                class="block xl:inline text-4xl font-extrabold  tracking-tight text-main sm:text-5xl md:text-4xl lg:text-5xl xl:text-5xl">TRECE
                                MARTIRES CITY</span>
                            <span class="block xl:inline text-2xl text-gray-700">National High School</span>

                        </h1>

                        <p class="mx-auto  text-base text-gray-600 sm:max-w-md lg:text-xl md:max-w-3xl">It's
                            never
                            been easier to build beautiful websites that convey your message and tell your
                            story.
                        </p>
                    </div>

                    <div class="w-full mt-16 md:mt-0 md:w-2/5">
                        <section class="bg-white/90 rounded-3xl">
                            <div class="px-20 py-10 mx-auto   relative">
                                <div class="max-w-lg mx-auto">
                                    <div class="text-center ">
                                        <img class="h-20 mx-auto" src="{{ asset('images/tmcnhs_logo.png') }}"
                                            alt="#_" />
                                        <h1 class="text-2xl font-semibold tracking-tight  mt-4">
                                            Sign in to your account
                                        </h1>

                                    </div>
                                    <!-- Session Status -->
                                    <div class="mt-10">
                                        <x-auth-session-status class="mb-4" :status="session('status')" />

                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf

                                            <!-- Email Address -->
                                            <div>
                                                <x-input-label for="email" :value="__('Email')" />
                                                <x-text-input id="email" class="block mt-1 w-full" type="email"
                                                    name="email" :value="old('email')" required autofocus
                                                    autocomplete="username" />
                                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                            </div>

                                            <!-- Password -->
                                            <div class="mt-4">
                                                <x-input-label for="password" :value="__('Password')" />

                                                <x-text-input id="password" class="block mt-1 w-full" type="password"
                                                    name="password" required autocomplete="current-password" />

                                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                            </div>

                                            <!-- Remember Me -->
                                            <div class="block mt-4">
                                                <label for="remember_me" class="inline-flex items-center">
                                                    <input id="remember_me" type="checkbox"
                                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                                        name="remember">
                                                    <span
                                                        class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                                </label>
                                            </div>

                                            <div class="flex items-center justify-end mt-4">
                                                @if (Route::has('password.request'))
                                                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                        href="{{ route('password.request') }}">
                                                        {{ __('Forgot your password?') }}
                                                    </a>
                                                @endif

                                                <x-primary-button class="ms-3">
                                                    {{ __('Log in') }}
                                                </x-primary-button>
                                            </div>
                                        </form>
                                        <div class="mt-5 text-center text-gray-600">
                                            <span>Doesn't have account yet? <a href=""
                                                    class="text-main hover:underline">Sign
                                                    Up</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>

                </div>
            </div>
        </section>

    </div>
</x-home-layout>

@section('title', 'Login')
<x-home-layout>
    <div>
        <section class="w-full py-20 md:py-32 lg:py-40 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col md:flex-row items-center gap-12 md:gap-20">

                    <!-- Left Content -->
                    <div class="w-full md:w-3/5 space-y-6 text-center md:text-left">
                        <h1>
                            <span class="block text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-main">
                                TRECE MARTIRES CITY
                            </span>
                            <span class="block text-xl sm:text-2xl md:text-3xl text-gray-700">
                                National High School
                            </span>
                        </h1>

                        <p class="mx-auto md:mx-0 text-base sm:text-lg lg:text-xl text-gray-600 max-w-md md:max-w-2xl">
                            It's never been easier to build beautiful websites that convey your message and tell your story.
                        </p>
                    </div>

                    <!-- Right Form -->
                    <div class="w-full md:w-2/5">
                        <section class="bg-white/90 rounded-2xl shadow-lg">
                            <div class="px-6 sm:px-12 md:px-10 lg:px-14 py-10">
                                <div class="max-w-md mx-auto">
                                    <!-- Logo + Title -->
                                    <div class="text-center">
                                        <img class="h-20 mx-auto" src="{{ asset('images/tmcnhs_logo.png') }}" alt="TMCNHS Logo" />
                                        <h1 class="text-xl sm:text-2xl font-semibold tracking-tight mt-4">
                                            Sign in to your account
                                        </h1>
                                    </div>

                                    <!-- Session Status -->
                                    <div class="mt-8">
                                        <x-auth-session-status class="mb-4" :status="session('status')" />

                                        <!-- Login Form -->
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf

                                            <!-- Email Address -->
                                            <div>
                                                <x-input-label for="email" :value="__('Email')" />
                                                <x-text-input id="email" class="block mt-1 w-full"
                                                    type="email" name="email" :value="old('email')" required autofocus
                                                    autocomplete="username" />
                                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                            </div>

                                            <!-- Password -->
                                            <div class="mt-4">
                                                <x-input-label for="password" :value="__('Password')" />
                                                <x-text-input id="password" class="block mt-1 w-full"
                                                    type="password" name="password" required
                                                    autocomplete="current-password" />
                                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                            </div>

                                            <!-- Remember Me -->
                                            <div class="block mt-4">
                                                <label for="remember_me" class="inline-flex items-center">
                                                    <input id="remember_me" type="checkbox"
                                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                                        name="remember">
                                                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                                </label>
                                            </div>

                                            <!-- Actions -->
                                            <div class="flex flex-col sm:flex-row sm:items-center  sm:justify-between gap-4 mt-6">
                                                @if (Route::has('password.request'))
                                                    <a class="text-sm text-gray-600 hover:text-gray-900 underline"
                                                        href="{{ route('password.request') }}">
                                                        {{ __('Forgot your password?') }}
                                                    </a>
                                                @endif

                                                <x-filament::button type="submit" size="sm">
                                                    LOG IN
                                                </x-filament::button>
                                            </div>
                                        </form>

                                        <!-- Sign Up Link -->
                                        <div class="mt-6 text-center text-gray-600">
                                            <span>
                                                Doesn't have an account yet? 
                                                <a href="" class="text-main hover:underline">Sign Up</a>
                                            </span>
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

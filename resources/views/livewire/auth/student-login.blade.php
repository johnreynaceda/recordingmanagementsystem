@section('title', 'Login')
<div>
    <x-filament::button icon="heroicon-m-arrow-long-left" color="gray" href="{{ route('home') }}" tag="a">
        Back to Home
    </x-filament::button>
    <div class="max-w-md mx-auto py-6">

        <div class="text-center">
            <img class="h-20 mx-auto" src="{{ asset('images/tmcnhs_logo.png') }}">
            <h1 class="text-xl sm:text-2xl font-semibold mt-4">
                Sign in to your account
            </h1>
        </div>

        <div class="mt-8">
            @if ($error)
                <div class="bg-red-100 text-red-700 p-2 mb-3 rounded">
                    {{ $error }}
                </div>
            @endif

            <!-- LIVEWIRE FORM -->
            <form wire:submit.prevent="login">

                {{-- <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" wire:model.defer="email"
                        required />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" value="Password" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" wire:model.defer="password"
                        required />
                </div> --}}
                {{ $this->form }}

                <div class="block mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="rounded border-gray-300">
                        <span class="ms-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <div class="flex justify-end mt-6">
                    <x-filament::button type="submit" size="sm" wire:loading.attr="disabled" wire:target="login">
                        LOG IN
                    </x-filament::button>
                </div>
            </form>

            <div class="mt-6 text-center text-gray-600">
                Doesn't have an account yet?
                <a href="#" class="text-main hover:underline">Sign Up</a>
            </div>
        </div>
    </div>
</div>

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
            @if (session('status'))
                <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- LIVEWIRE FORM -->
            <form wire:submit.prevent="login">

                {{ $this->form }}

                <div class="block mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" wire:model="remember" class="rounded border-gray-300">
                        <span class="ms-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <div class="flex justify-end mt-6">
                    <x-filament::button type="submit" size="sm" wire:loading.attr="disabled" wire:target="login">
                        LOG IN
                    </x-filament::button>
                </div>
            </form>

        </div>
    </div>
</div>

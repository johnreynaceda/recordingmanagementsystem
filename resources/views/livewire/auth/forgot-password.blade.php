<div class="max-w-md mx-auto mt-20 p-6 bg-white rounded-xl shadow">
    <h2 class="text-xl font-semibold text-gray-700 mb-4">
        Forgot Password
    </h2>

    @if (session('status'))
        <div class="mb-4 text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit.prevent="sendResetLink" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-600">
                Email Address
            </label>
            <input
                type="email"
                wire:model.defer="email"
                class="w-full rounded-lg border-gray-300 focus:ring focus:ring-blue-200"
            />

            @error('email')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>Send Reset Link</span>
            <span wire:loading>Sending...</span>
        </button>
    </form>
</div>

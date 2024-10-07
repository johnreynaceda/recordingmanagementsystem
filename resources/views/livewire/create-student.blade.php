<div>
    <div class="bg-white p-10 rounded-xl">
        {{ $this->form }}
    </div>
    <div class="mt-5 flex space-x-2 justify-end">
        <x-button href="{{ route('admin.students') }}" icon="x-mark" color="gray" position="left">Cancel</x-button>
        <x-button icon="arrow-right" color="red" position="right" wire:click="submitRecord">Submit</x-button>
    </div>
</div>

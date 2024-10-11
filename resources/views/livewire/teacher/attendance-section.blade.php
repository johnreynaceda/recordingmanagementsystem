<div>
    <div class="flex space-x-3">
        @forelse ($sections as $item)
            <x-button wire:click="$set('section_id', {{ $item->id }})" text="{{ strtoupper($item->name) }}"
                color="secondary" class="font-semibold" outline />
        @empty
            <p>No sections available.</p>
        @endforelse
    </div>

    <div class="mt-5 border-t border-red-600 pt-5">
        <div class="bg-white p-5 rounded-xl shadow">
            {{ $this->table }}
        </div>
    </div>
</div>

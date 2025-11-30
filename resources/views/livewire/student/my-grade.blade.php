<div>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Grades</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- File Card -->
            @foreach ($grade as $item)
                <div class="group border rounded-2xl p-4 shadow-sm hover:shadow-md transition-all bg-white">
                    <div class="flex items-center justify-between mb-3">
                        <div class="p-3 rounded-xl bg-red-100 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-file-digit-icon lucide-file-digit">
                                <path
                                    d="M4 12V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2" />
                                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                <path d="M10 16h2v6" />
                                <path d="M10 22h4" />
                                <rect x="2" y="16" width="4" height="6" rx="2" />
                            </svg>
                        </div>
                        
                    </div>

                    <p class="font-semibold text-gray-800 truncate">
                        {{ $item->name }}
                    </p>

                    <p class="text-sm text-gray-500 mt-1"> {{ $item->created_at }} </p>

                    <div class="mt-4 flex items-center justify-between">
                        <a href="#" class="text-red-600 text-sm font-medium hover:underline" wire:click="download({{ $item->id }})">Download</a>
                    </div>
                </div>
            @endforeach

            <!-- Copy the card above and loop with Livewire -->
        </div>
    </div>

</div>

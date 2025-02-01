<div>
    <label for="uploadFile1"
        class="bg-white text-gray-500 font-semibold text-base rounded  h-52 flex flex-col items-center justify-center cursor-pointer border-2 border-gray-300 border-dashed mx-auto font-[sans-serif]">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-11 mb-2 fill-gray-500" viewBox="0 0 32 32">
            <path
                d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956z"
                data-original="#000000" />
            <path
                d="M20.293 19.707a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z"
                data-original="#000000" />
        </svg>
        Upload file

        <input type="file" id='uploadFile1' class="hidden" wire:model.live="grade" />
        <p class="text-xs font-medium text-gray-400 mt-2">PDF and Docs are Allowed.</p>
    </label>
    <div class="mt-5">
        <ul>
            @forelse ($this->grade as $item)
                <li class="flex justify-between items-center">
                    <div class="flex space-x-1 item-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-green-600" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-check-2">
                            <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                            <path d="m3 15 2 2 4-4" />
                        </svg>
                        <h1>{{ $item->getClientOriginalName() }}</h1>
                    </div>
                    <div>
                        <button class="text-red-600 hover:text-red-800 text-sm">delete</button>
                    </div>
                </li>
            @empty
            @endforelse
        </ul>
    </div>
</div>

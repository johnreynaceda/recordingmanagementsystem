<div>
    <div class="flex space-x-2 item-center">
        <a href="{{ route('admin.grade-level') }}" class="hover:text-main text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-circle-arrow-left">
                <circle cx="12" cy="12" r="10" />
                <path d="M16 12H8" />
                <path d="m12 8-4 4 4 4" />
            </svg>
        </a>
        <h1 class="text-xl font-bold uppercase text-gray-600">{{ $name }}</h1>
    </div>
    <div class="bg-white p-5 rounded-xl mt-5">
        {{ $this->table }}
    </div>
</div>

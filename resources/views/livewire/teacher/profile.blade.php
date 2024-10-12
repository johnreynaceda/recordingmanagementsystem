<div class="max-w-6xl mx-auto bg-white border rounded-lg shadow-lg p-6">
    @if (session()->has('message'))
    <div class="mt-4 text-green-500 text-center">
        {{ session('message') }}
    </div>
@endif
    <div class="flex items-start">
        <div class="ml-6">
            <h2 class="text-2xl font-bold text-gray-800">{{ $record->firstname . ' ' . $record->lastname }}</h2>
            <p class="text-sm text-gray-600">Address: {{ $record->address }}</p>
            @php
                $grade_levels = $record->sections->pluck('grade_level_id')->toArray();
                $sections = \App\Models\GradeLevelSubject::whereIn('grade_level_id', $grade_levels)->get();
            @endphp
            <p class="text-sm text-gray-700">Subjects: {{ $sections->count() }}</p>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <button wire:click="$set('showModal', true)"
        class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition duration-300 shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l2 2m-4 4l2 2m-4 4l4-4m6-10.5L20.5 3.5l-1-1L5 16.5 4 20l3.5-1.5L15.5 8.5z" />
        </svg>
    </button>

    </div>


    <div x-data="{ open: @entangle('showModal') }" x-show="open"
         class="fixed inset-0 flex items-center justify-center z-50"
         style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="bg-white rounded-lg shadow-lg w-1/3">
            <div class="p-6">
                <h2 class="text-lg font-bold mb-4">Update Teacher Profile</h2>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" wire:model.defer="firstname" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" wire:model.defer="lastname" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" wire:model.defer="address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                </div>
            </div>
            <div class="flex justify-end p-4">
                <button @click="open = false" class="bg-gray-300 text-gray-800 py-2 px-4 rounded-lg mr-2">
                    Cancel
                </button>
                <button wire:click="update" class="bg-blue-600 text-white py-2 px-4 rounded-lg">
                    Save
                </button>
            </div>
        </div>
    </div>



</div>

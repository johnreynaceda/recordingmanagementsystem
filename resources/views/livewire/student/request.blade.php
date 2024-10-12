<div class="max-w-6xl mx-auto bg-white border rounded-lg shadow-lg p-6">
    <div class="flex justify-end mb-4">
        <button wire:click="$set('showModal', true)"
        class="flex items-center bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>
    Add Request
</button>

    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
            <thead>
                <tr class="bg-gray-100 text-gray-600">
                    <th class="py-3 px-4 text-left">Name</th>
                    <th class="py-3 px-4 text-left">Email Address</th>
                    <th class="py-3 px-4 text-left">Phone Number</th>
                    <th class="py-3 px-4 text-left">Option</th>
                    <th class="py-3 px-4 text-left">Additional Information</th>
                    <th class="py-3 px-4 text-left">Requested At</th>
                    <th class="py-3 px-4 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $request)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-4">{{ $request->name }}</td>
                        <td class="py-3 px-4">{{ $request->email_address }}</td>
                        <td class="py-3 px-4">{{ $request->phone_number }}</td>
                        <td class="py-3 px-4">{{ $request->option }}</td>
                        <td class="py-3 px-4">{{ $request->additional_information }}</td>
                        <td class="py-3 px-4">{{ $request->created_at->format('F j, Y, g:i a') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div x-data="{ open: @entangle('showModal') }" x-show="open"
         class="fixed inset-0 flex items-center justify-center z-50"
         style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="bg-white rounded-lg shadow-lg w-1/2">
            <div class="p-6">
                <h2 class="text-lg font-bold mb-4">Request Form</h2>
                <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" id="name" wire:model="name"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                               placeholder="Enter your full name" required>
                        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" id="email" wire:model="email_address"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                               placeholder="Enter your email" required>
                        @error('email_address') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="tel" id="phone" wire:model="phone_number"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                               placeholder="Enter your phone number" required>
                        @error('phone_number') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="options" class="block text-sm font-medium text-gray-700">Select Option</label>
                        <select id="options" wire:model="option"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                                required>
                            <option value="" disabled selected>Select an option</option>
                            <option value="137">Option 137</option>
                            <option value="138">Option 138</option>
                        </select>
                        @error('option') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4 md:col-span-2">
                        <label for="message" class="block text-sm font-medium text-gray-700">Additional Information</label>
                        <textarea id="message" wire:model="additional_information" rows="4"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                                  placeholder="Provide any additional information"></textarea>
                        @error('additional_information') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="flex justify-end p-4">
                <button @click="open = false" class="bg-gray-300 text-gray-800 py-2 px-4 rounded-lg mr-2">
                    Cancel
                </button>
                <button wire:click="save" class="bg-blue-600 text-white py-2 px-4 rounded-lg">
                    Submit Request
                </button>
            </div>
        </div>
    </div>
</div>

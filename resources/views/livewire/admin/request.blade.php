<div class="max-w-6xl mx-auto p-8 bg-white shadow-lg rounded-lg mt-10">


    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
            <thead>
                <tr class="bg-gray-100 text-gray-600">
                    <th class="py-3 px-4 text-left">Email Address</th>
                    <th class="py-3 px-4 text-left">Phone Number</th>
                    <th class="py-3 px-4 text-left">Option</th>
                    <th class="py-3 px-4 text-left">Additional Information</th>
                    <th class="py-3 px-4 text-left">Requested At</th>
                    <th class="py-3 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $request)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-4">{{ $request->email_address }}</td>
                        <td class="py-3 px-4">{{ $request->phone_number }}</td>
                        <td class="py-3 px-4">{{ $request->option }}</td>
                        <td class="py-3 px-4">{{ $request->additional_information }}</td>
                        <td class="py-3 px-4">{{ $request->created_at->format('F j, Y, g:i a') }}</td>
                        <td class="py-3 px-4 flex space-x-2">
                            <button wire:click="approveRequest({{ $request->id }})" class="bg-green-600 text-white py-1 px-3 rounded-md hover:bg-green-700 transition duration-300">
                                Approve
                            </button>
                            <button wire:click="declineRequest({{ $request->id }})" class="bg-red-600 text-white py-1 px-3 rounded-md hover:bg-red-700 transition duration-300">
                                Decline
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $requests->links() }}
    </div>
</div>

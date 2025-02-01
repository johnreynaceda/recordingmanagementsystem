<div x-data>
    <div class="bg-gray-200 p-5 ">
        <div class="flex space-x-1 text-main items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-filter">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
            </svg>
            <h1 class="text-lg font-bold text-main">FILTERS</h1>
        </div>
        <div class="flex justify-between items-end">
            <div class="mt-3 flex space-x-3 items-end">
                <div class="w-64">
                    <x-datetime-picker wire:model.live="date" without-timezone without-time label="Select Date"
                        placeholder="Select Date" />
                </div>
                <div class="w-64">
                    <x-native-select label="Section" wire:model.live="section_id">
                        <option>Select an Option</option>
                        @foreach ($sections as $item)
                            <option value="{{ $item->id }}">{{ strtoupper($item->name) }}</option>
                        @endforeach

                    </x-native-select>
                </div>
            </div>
            <div>
                <x-button label="PRINT" class="font-semibold" icon="printer" slate
                    @click="printOut($refs.printContainer.outerHTML);" />
            </div>
        </div>
    </div>
    <div class="mt-5 bg-white p-5">
        @if ($section_id)
            <div x-ref="printContainer">
                <div class=" mt-5">
                    <div class="flex justify-between items-center">
                        <h1 class="text-xl font-semibold uppercase text-main">Attendance Report</h1>
                    </div>
                    <div class="flex justify-between items-center mt-3">
                        <h1 class="text-sm font-semibold uppercase text-gray-600">Section:
                            {{ $sections[$section_id]->name }}</h1>
                    </div>
                    <div class="flex justify-between items-center mt-3">
                        <h1 class="text-sm font-semibold uppercase text-gray-600">Date:
                            {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</h1>
                    </div>
                </div>
                <table id="example" class="table-auto " style="width:100%">
                    <thead class="font-normal">
                        <tr>
                            <th class="border text-center border-gray-600 px-2 font-bold text-gray-700  py-2">STUDENT
                                NAME
                            </th>

                            <th class="border text-center border-gray-600 px-2 font-bold text-gray-700  py-2">SECTION
                            </th>


                        </tr>
                    </thead>
                    <tbody class="">
                        @forelse ($attendances as $item)
                            <tr>
                                <td class="border text-gray-700   font-medium text-center border-gray-600 px-3 ">
                                    {{ $item->studentRecord->student->firstname . ' ' . $item->studentRecord->student->lastname }}
                                </td>

                                <td class="border text-gray-700  font-medium text-center border-gray-600 px-3 ">
                                    {{ $item->studentRecord->section->name }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="border text-gray-700  font-medium text-center border-gray-600 px-3 "
                                    colspan="2">No Records Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

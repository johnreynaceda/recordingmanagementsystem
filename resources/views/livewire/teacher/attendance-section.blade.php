<div class="max-w-7xl mx-auto space-y-6">
    <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-2xl shadow-lg p-8 text-white flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold tracking-tight">Attendance Management</h2>
            <p class="text-red-100 mt-2">Select a section to manage student attendance records.</p>
        </div>
        <div class="hidden md:block">
            <svg class="w-16 h-16 text-red-200 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
        </div>
    </div>

    @if (session()->has('attendance_message'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('attendance_message') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            Filters
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Academic Year</label>
                <select wire:model.live="selected_academic_year_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-2 px-3 border">
                    @foreach($academic_years as $year)
                        <option value="{{ $year->id }}">{{ $year->name }} {{ $year->is_active ? '(Active)' : '' }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Section</label>
                <select wire:model.live="section_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-2 px-3 border">
                    <option value="">Select Section</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Attendance Date</label>
                <input type="date" wire:model.live="selected_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-2 px-3 border">
                @error('selected_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    @if($section_id)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-red-500"></div>
            <div class="flex flex-col gap-4 border-b border-gray-100 px-6 pb-4 pt-6 sm:flex-row sm:items-center sm:justify-between">
                @php
                    $selectedSection = $sections->firstWhere('id', $section_id);
                @endphp
                <div>
                    <span class="inline-block rounded-full bg-red-50 px-3 py-1 text-xs font-bold uppercase tracking-widest text-red-700">Section</span>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-gray-800">
                        {{ $selectedSection ? strtoupper($selectedSection->name) : '' }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ $studentRecords->count() }} {{ Str::plural('student', $studentRecords->count()) }} found
                    </p>
                </div>

                <button type="button"
                    wire:click="markSelectedPresent"
                    wire:confirm="Mark the selected students as present for {{ $selected_date }}?"
                    wire:loading.attr="disabled"
                    wire:target="markSelectedPresent"
                    @disabled($selectedStudentRecordIds === [])
                    class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-50">
                    <svg wire:loading.remove wire:target="markSelectedPresent" class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <svg wire:loading wire:target="markSelectedPresent" class="mr-2 h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Mark as Present
                </button>
            </div>

            @error('selectedStudentRecordIds')
                <div class="border-b border-red-100 bg-red-50 px-6 py-3 text-sm font-medium text-red-700">{{ $message }}</div>
            @enderror

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="w-14 px-6 py-3 text-left">
                                <input type="checkbox"
                                    wire:click="toggleSelectAll"
                                    @checked($allStudentsSelected)
                                    aria-label="Select all students"
                                    class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Student Name</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-600">LRN</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Section</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Attendance Record</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($studentRecords as $record)
                            @php($attendance = $record->attendanceRecords->first())
                            <tr wire:key="attendance-student-{{ $record->id }}" class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <input type="checkbox"
                                        wire:model.live="selectedStudentRecordIds"
                                        value="{{ $record->id }}"
                                        aria-label="Select {{ $record->student->firstname }} {{ $record->student->lastname }}"
                                        class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                </td>
                                <td class="whitespace-nowrap px-4 py-4 text-sm font-semibold text-gray-900">
                                    {{ strtoupper($record->student->lastname.', '.$record->student->firstname.' '.($record->student->middlename ? substr($record->student->middlename, 0, 1).'.' : '')) }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">{{ $record->student->lrn ?: '—' }}</td>
                                <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">{{ strtoupper($record->section->name) }}</td>
                                <td class="whitespace-nowrap px-4 py-4 text-sm">
                                    @if ($attendance)
                                        <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-800">
                                            Present · {{ $attendance->created_at->format('h:i A') }}
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">No record</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <p class="text-base font-semibold text-gray-700">No students found</p>
                                    <p class="mt-1 text-sm text-gray-500">There are no active student records in this section for the selected academic year.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl p-12 text-center flex flex-col items-center justify-center transition-all duration-300">
            <div class="bg-white p-4 rounded-full shadow-sm mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-700">No Section Selected</h3>
            <p class="text-gray-500 mt-2 max-w-sm mx-auto">Please select a section from the dropdown above to view and manage student attendance.</p>
        </div>
    @endif
</div>

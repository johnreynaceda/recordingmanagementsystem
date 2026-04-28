<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-2xl shadow-lg p-8 text-white flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold tracking-tight">Grade Management</h2>
            <p class="text-red-100 mt-2">Select a section and subject to manage your students' grades.</p>
        </div>
        <div class="hidden md:block">
            <svg class="w-16 h-16 text-red-200 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        </div>
    </div>



    <!-- Selection Controls -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            Filters
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Academic Year -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Academic Year</label>
                <select wire:model.live="selected_academic_year_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-2 px-3 border">
                    <option value="">Choose an academic year...</option>
                    @foreach($academic_years as $year)
                        <option value="{{ $year->id }}">{{ $year->name }} {{ $year->is_active ? '(Active)' : '' }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Section -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Section</label>
                <select wire:model.live="selected_section_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-2 px-3 border">
                    <option value="">Choose a section...</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Subject (only shows subjects assigned to this teacher in the chosen section's grade level) -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Subject</label>
                <select wire:model.live="selected_subject_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-2 px-3 border {{ !$selected_section_id ? 'opacity-50 cursor-not-allowed' : '' }}"
                    {{ !$selected_section_id ? 'disabled' : '' }}>
                    <option value="">{{ $selected_section_id ? 'Choose a subject...' : 'Select a section first' }}</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                    @endforeach
                </select>
                @if($selected_section_id && $subjects->isEmpty())
                    <p class="mt-1 text-xs text-red-500">No subjects assigned to you for this section's grade level.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Grades Table -->
    @if($selected_section_id && $selected_subject_id)
        @php
            $currentSubject = $subjects->firstWhere('id', $selected_subject_id);
        @endphp
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-red-500"></div>

            <!-- Subject Name Heading -->
            <div class="px-6 pt-6 pb-4 border-b border-gray-100 text-center">
                <span class="inline-block bg-red-50 text-red-700 text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-2">Subject</span>
                <h2 class="text-2xl font-bold text-gray-800 tracking-tight">
                    {{ $currentSubject ? strtoupper($currentSubject->subject_name) : '' }}
                </h2>
            </div>

            @if(count($students) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student LRN</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">1st Grading</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">2nd Grading</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">3rd Grading</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">4th Grading</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Final Average</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($students as $index => $record)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-500">{{ strtoupper($record->student->lastname) }} , {{ strtoupper($record->student->firstname) }} {{ strtoupper($record->student->middlename) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" readonly class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm bg-gray-50 sm:text-sm py-2 px-3 focus:outline-none focus:ring-0 focus:border-gray-300 min-w-[140px]" value="{{ $record->student->lrn ?? 'N/A' }}">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" wire:model="termGrades.{{ $record->student_id }}.first_grading" class="mt-1 block w-20 rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-2 px-3 border text-center">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" wire:model="termGrades.{{ $record->student_id }}.second_grading" class="mt-1 block w-20 rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-2 px-3 border text-center">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" wire:model="termGrades.{{ $record->student_id }}.third_grading" class="mt-1 block w-20 rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-2 px-3 border text-center">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" wire:model="termGrades.{{ $record->student_id }}.fourth_grading" class="mt-1 block w-20 rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-2 px-3 border text-center">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" wire:model="termGrades.{{ $record->student_id }}.final_rating" class="mt-1 block w-24 rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-2 px-3 border text-center">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" wire:model="termGrades.{{ $record->student_id }}.remarks" class="mt-1 block w-full min-w-[120px] rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-2 px-3 border">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3 items-center">
                    <div wire:loading wire:target="gradeFile" class="text-sm text-blue-600 font-medium">
                        Importing...
                    </div>
                    
                    <input type="file" id="gradeFileUpload" class="hidden" wire:model="gradeFile" accept=".csv">
                    <label for="gradeFileUpload" class="cursor-pointer inline-flex items-center px-4 py-2 border border-blue-300 text-sm font-medium rounded-md shadow-sm text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mb-0">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Import Excel
                    </label>

                    <button wire:click="exportExcel" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                        Export Excel
                    </button>
                    
                    <button wire:click="saveGrades" wire:loading.attr="disabled" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Save Grades
                    </button>
                    <div wire:loading wire:target="saveGrades" class="ml-3 self-center text-sm text-red-600 font-medium">
                        Saving...
                    </div>
                </div>
            @else
                <div class="p-12 text-center text-gray-500">
                    <p>No students found in this section.</p>
                </div>
            @endif
        </div>
    @else
        <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl p-12 text-center flex flex-col items-center justify-center transition-all duration-300">
            <div class="bg-white p-4 rounded-full shadow-sm mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-700">
                {{ $selected_section_id ? 'No Subject Selected' : 'No Section Selected' }}
            </h3>
            <p class="text-gray-500 mt-2 max-w-sm mx-auto">
                {{ $selected_section_id ? 'Please choose a subject from the dropdown above to view and manage grades.' : 'Please choose a section from the dropdown above to get started.' }}
            </p>
        </div>
    @endif


</div>

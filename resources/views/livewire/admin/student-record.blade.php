<div>
    <div class="bg-white p-10 rounded-xl">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="font-bold text-xl text-main">STUDENT'S INFORMATION</h1>
            </div>
            <div class="flex items-end gap-4">
                @if ($selected_academic_year_id && $this->canPromote)
                    <button wire:click="promoteStudent"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
                        </svg>
                        Promote Student
                    </button>
                @endif

            </div>
        </div>

        <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="p-8 flex items-center gap-8">
                <div class="flex-shrink-0">
                    <img src="{{ Storage::url($student->image_path ?? '') }}" alt=""
                        class="rounded-full object-cover h-28 w-28 border-4 border-white/30 shadow-lg">
                </div>
                <div class="text-white">
                    <h2 class="text-2xl font-bold tracking-tight">
                        {{ $student->firstname }} {{ $student->middlename }} {{ $student->lastname }}
                        @if ($student->status === 'Graduated')
                            <span
                                class="inline-flex items-center ml-2 px-2 py-0.5 rounded-full text-xs font-bold bg-purple-300 text-purple-900 uppercase tracking-wider">Graduated</span>
                        @endif
                        @if ($this->isPromoted)
                            <span
                                class="inline-flex items-center ml-2 px-2 py-0.5 rounded-full text-xs font-bold bg-green-300 text-green-900 uppercase tracking-wider">Promoted</span>
                        @endif
                    </h2>
                    @if ($student->lrn)
                        <p class="text-red-100 mt-1 text-sm">LRN: {{ $student->lrn }}</p>
                    @endif
                    @php
                        $currentRecord =
                            $student_records->where('is_active', true)->sortByDesc('grade_level_id')->first() ??
                            $student_records->sortByDesc('grade_level_id')->first();
                    @endphp
                    @if ($currentRecord)
                        <p class="text-red-100 mt-1 text-sm">
                            {{ $currentRecord->gradeLevel->name ?? 'N/A' }}{{ $currentRecord->section ? ' - ' . $currentRecord->section->name : '' }}
                            <span class="text-red-200/60 mx-1">|</span>
                            {{ $currentRecord->academicYear->name ?? 'N/A' }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-main" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Personal Information
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Full Name</p>
                        <p class="font-semibold text-gray-800">{{ $student->firstname }} {{ $student->middlename }}
                            {{ $student->lastname }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Birthday</p>
                        <p class="font-semibold text-gray-800">{{ $student->birthdate }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Address</p>
                        <p class="font-semibold text-gray-800">{{ $student->address }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">LRN</p>
                        <p class="font-semibold text-gray-800">{{ $student->lrn ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-main" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    Contact Information
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Contact Number</p>
                        <p class="font-semibold text-gray-800">{{ $student->contact_number ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-main" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Parent / Guardian
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Parent Name</p>
                        <p class="font-semibold text-gray-800">{{ $student->parent_name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Parent Contact</p>
                        <p class="font-semibold text-gray-800">{{ $student->parent_contact ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if ($student_records->count() > 0)
            <div class="mt-8 border-t pt-6">
                <section>
                    <div x-data="{ tab: '{{ $activeRecordId ?? $student_records->first()->id }}' }" wire:key="tabs-{{ $selected_academic_year_id }}">
                        <ul class="flex gap-1 text-sm border-b border-gray-200">
                            @foreach ($student_records as $item)
                                <li class="-mb-px">
                                    <button @click.prevent="tab = '{{ $item->id }}'"
                                        class="inline-block px-5 py-3 font-medium cursor-pointer transition-colors rounded-t-lg"
                                        :class="tab === '{{ $item->id }}' ?
                                            'bg-blue-50 text-blue-700 border-b-2 border-blue-500' :
                                            'text-gray-500 hover:text-gray-700 hover:bg-gray-50'">
                                        {{ $item->gradeLevel->name }}{{ $item->section ? ' - ' . $item->section->name : '' }}
                                        <span
                                            class="text-xs text-gray-400 ml-1">({{ $item->academicYear->name ?? 'N/A' }})</span>
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <div class="pt-6 text-left bg-white">
                            @foreach ($student_records as $item)
                                <div x-show="tab === '{{ $item->id }}'" class="text-gray-700" x-transition>
                                    <main class="py-2">
                                        <div class="flex items-center gap-2 mb-4">
                                            <span
                                                class="inline-block bg-red-50 text-red-700 text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full">
                                                {{ $item->gradeLevel->name }}
                                            </span>
                                            <span
                                                class="text-gray-400 text-sm">{{ $item->academicYear->name ?? 'N/A' }}</span>

                                            @if ($edit_record_id == $item->id)
                                                <button wire:click="cancelEdit"
                                                    class="ml-auto text-sm text-gray-500 hover:text-gray-700 font-medium">Cancel</button>
                                            @else
                                                <button wire:click="exportGrades({{ $item->academic_year_id }})"
                                                    class="ml-auto inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 font-medium">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    Export
                                                </button>
                                                <button wire:click="editRecord({{ $item->id }})"
                                                    class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 font-medium">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                    Edit
                                                </button>
                                            @endif
                                        </div>

                                        @if ($edit_record_id == $item->id)
                                            <div class="bg-blue-50 rounded-2xl border border-blue-200 p-6 mb-4">
                                                <h4
                                                    class="text-sm font-bold text-blue-800 uppercase tracking-wider mb-4">
                                                    Edit Enrollment Record</h4>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label
                                                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Grade
                                                            Level</label>
                                                        <select wire:model.live="edit_grade_level_id"
                                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2 px-3 border">
                                                            @foreach ($grade_levels as $gl)
                                                                <option value="{{ $gl->id }}">
                                                                    {{ $gl->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('edit_grade_level_id')
                                                            <span
                                                                class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Section</label>
                                                        <select wire:model="edit_section_id"
                                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2 px-3 border">
                                                            <option value="">— No Section —</option>
                                                            @foreach ($this->editSections as $sec)
                                                                <option value="{{ $sec->id }}">
                                                                    {{ $sec->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('edit_section_id')
                                                            <span
                                                                class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="mt-4 flex justify-end">
                                                    <button wire:click="updateRecord"
                                                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        Save Changes
                                                    </button>
                                                </div>
                                            </div>
                                        @elseif(!$item->section_id)
                                            <div
                                                class="bg-amber-50 rounded-2xl border border-amber-200 p-4 mb-4 flex items-center gap-3">
                                                <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none"
                                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                <span class="text-sm text-amber-800 font-medium">No section assigned.
                                                    Click "Edit" to assign a section.</span>
                                            </div>
                                        @endif

                                        @php
                                            $termGrades = \App\Models\TermGrade::where('student_id', $student->id)
                                                ->where('academic_year_id', $item->academic_year_id)
                                                ->with('subject')
                                                ->get();
                                        @endphp

                                        @if ($termGrades->count() > 0)
                                            <div
                                                class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mt-4">
                                                <div
                                                    class="grid grid-cols-12 bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-widest">
                                                    <div class="col-span-5 px-6 py-4 flex items-center">Learning Area
                                                    </div>
                                                    @foreach (['1st', '2nd', '3rd', '4th'] as $q)
                                                        <div
                                                            class="col-span-1 px-2 py-4 text-center flex items-center justify-center">
                                                            {{ $q }}</div>
                                                    @endforeach
                                                    <div
                                                        class="col-span-3 px-4 py-4 text-center flex items-center justify-center">
                                                        Final Rating</div>
                                                </div>

                                                @foreach ($termGrades as $index => $row)
                                                    <div
                                                        class="grid grid-cols-12 items-center
                                                    {{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}
                                                    border-b border-gray-100 hover:bg-blue-50 transition-colors group">
                                                        <div class="col-span-5 px-6 py-4 flex items-center gap-3">
                                                            <div
                                                                class="w-2 h-2 rounded-full bg-blue-400 flex-shrink-0 group-hover:bg-blue-600 transition-colors">
                                                            </div>
                                                            <span
                                                                class="font-semibold text-gray-700 text-sm">{{ $row->subject->subject_name ?? '' }}</span>
                                                        </div>

                                                        @foreach (['first_grading', 'second_grading', 'third_grading', 'fourth_grading'] as $period)
                                                            <div class="col-span-1 px-2 py-4 text-center">
                                                                @if (!empty($row->$period))
                                                                    <span
                                                                        class="inline-block px-2 py-1 rounded-lg text-sm font-medium {{ (float) $row->$period >= 75 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                                        {{ $row->$period }}
                                                                    </span>
                                                                @else
                                                                    <span
                                                                        class="text-gray-300 text-lg font-light">—</span>
                                                                @endif
                                                            </div>
                                                        @endforeach

                                                        <div class="col-span-3 px-4 py-4 text-center">
                                                            @if (!empty($row->final_rating))
                                                                <span
                                                                    class="inline-flex items-center justify-center w-14 h-10 rounded-xl text-base font-extrabold shadow-sm {{ (float) $row->final_rating >= 75 ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                                                    {{ $row->final_rating }}
                                                                </span>
                                                            @else
                                                                <span class="text-gray-300 text-lg">—</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach

                                                @php
                                                    $allFinals = $termGrades
                                                        ->pluck('final_rating')
                                                        ->filter(function ($value) {
                                                            return is_numeric($value);
                                                        })
                                                        ->toArray();
                                                    $generalAverage =
                                                        count($allFinals) > 0
                                                            ? round(array_sum($allFinals) / count($allFinals), 0)
                                                            : null;
                                                @endphp
                                                <div class="grid grid-cols-12 items-center bg-blue-100 text-blue-800">
                                                    <div
                                                        class="col-span-9 px-6 py-5 font-bold text-sm uppercase tracking-wider">
                                                        General Average
                                                    </div>
                                                    <div class="col-span-3 px-4 py-5 text-center">
                                                        @if ($generalAverage)
                                                            <span
                                                                class="inline-flex items-center justify-center w-16 h-10 rounded-xl text-lg font-extrabold shadow {{ $generalAverage >= 75 ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                                                {{ $generalAverage }}
                                                            </span>
                                                        @else
                                                            <span class="text-gray-400">—</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div
                                                class="bg-gray-50 rounded-2xl border border-gray-200 p-8 text-center mt-4">
                                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                                </svg>
                                                <p class="text-gray-400 text-sm font-medium">No grades record found for
                                                    this academic year</p>
                                            </div>
                                        @endif
                                    </main>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
        @else
            <div class="mt-8 border-t pt-6">
                <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                    <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <p class="text-sm italic">No student records found for the selected academic year.</p>
                </div>
            </div>
        @endif
    </div>

    {{-- Promote Modal --}}
    @if ($showPromoteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
            wire:click.self="$set('showPromoteModal', false)">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Promote Student</h3>
                        <p class="text-sm text-gray-500">Assign a section for the next grade level.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Section
                            (optional)</label>
                        <select wire:model="promote_section_id"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2 px-3 border">
                            <option value="">— No Section —</option>
                            @foreach ($this->promoteSections as $sec)
                                <option value="{{ $sec->id }}">{{ $sec->name }}</option>
                            @endforeach
                        </select>
                        @error('promote_section_id')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="$set('showPromoteModal', false)"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Cancel</button>
                    <button wire:click="confirmPromote"
                        class="px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg shadow-sm hover:bg-green-700 transition-colors">
                        Confirm Promotion
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

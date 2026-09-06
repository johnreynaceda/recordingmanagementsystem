<div class="mx-auto max-w-5xl space-y-5 sm:space-y-8">

    {{-- ===== HEADER CARD ===== --}}
    <div class="flex items-center justify-between rounded-2xl border border-gray-200 bg-white p-5 shadow-md sm:p-8">
        <div>
            <p class="text-blue-400 text-xs font-semibold uppercase tracking-widest mb-1">DepEd Form 138 – E</p>
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-800 sm:text-3xl">Periodic Rating</h1>
            @if ($studentGradeLevel)
                <p class="text-gray-400 mt-1 text-sm"> {{ $studentGradeLevel }}</p>
            @else
                <p class="text-gray-400 mt-1 text-sm">No enrollment for selected academic year</p>
            @endif
        </div>
        <div class="flex items-center gap-4">
            <div class="hidden md:flex items-center justify-center bg-blue-50 rounded-2xl p-4">
                <svg class="w-14 h-14 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
        </div>
    </div>

    @if ($academic_years->count() > 0)
        <div class="rounded-2xl border border-gray-200 bg-white px-2 shadow-sm sm:px-4">
            <div class="flex snap-x overflow-x-auto border-b border-gray-200">
                @foreach ($academic_years as $year)
                    @php
                        $yearRecord = $student_records_by_academic_year->get($year->id);
                    @endphp
                    <button type="button"
                        wire:click="selectAcademicYear({{ $year->id }})"
                        class="snap-start whitespace-nowrap border-b-2 px-4 py-3 text-sm font-medium transition-colors sm:px-6 {{ (int) $selected_academic_year_id === (int) $year->id ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 inline-block mr-2 -mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $year->name }}
                            @if ($year->is_active)
                                <span class="ml-1 text-xs font-semibold">(Active)</span>
                            @endif
                        </span>
                        <span class="mt-1 block text-xs font-medium text-gray-400">
                            {{ $yearRecord?->gradeLevel?->name ?? 'No Grade Level' }}{{ $yearRecord?->section ? ' - ' . $yearRecord->section->name : '' }}
                        </span>
                    </button>
                @endforeach
            </div>
        </div>
    @else
        <div class="rounded-2xl border border-dashed border-gray-200 bg-gray-50 px-6 py-5 text-sm font-medium text-gray-500">
            No academic year records found.
        </div>
    @endif

    {{-- ===== GRADES TABLE ===== --}}
    <div class="hidden overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm lg:block">

        {{-- Column Headers --}}
        <div class="grid grid-cols-12 bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-widest">
            <div class="col-span-5 px-6 py-4 flex items-center">Learning Area</div>
            @foreach (['1st Term', '2nd Term', '3rd Term'] as $q)
                <div class="col-span-1 px-2 py-4 text-center flex items-center justify-center">{{ $q }}</div>
            @endforeach
            <div class="col-span-2 px-4 py-4 text-center flex items-center justify-center">Final Average</div>
            <div class="col-span-2 px-4 py-4 text-left flex items-center">Remarks</div>
        </div>

        {{-- Grade Rows --}}
        @forelse($termGrades as $index => $row)
            <div
                class="grid grid-cols-12 items-center
                {{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}
                border-b border-gray-100 hover:bg-blue-50 transition-colors group">

                {{-- Subject Name --}}
                <div class="col-span-5 px-6 py-4 flex items-center gap-3">
                    <div
                        class="w-2 h-2 rounded-full bg-blue-400 flex-shrink-0 group-hover:bg-blue-600 transition-colors">
                    </div>
                    <span class="font-semibold text-gray-700 text-sm">{{ $row['subject_name'] }}</span>
                </div>

                {{-- Grading Periods --}}
                @foreach (['first_grading', 'second_grading', 'third_grading'] as $period)
                    <div class="col-span-1 px-2 py-4 text-center">
                        @if (!empty($row[$period]))
                            <span
                                class="inline-block px-2 py-1 rounded-lg text-sm font-medium
                                {{ (int) $row[$period] >= 75 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $row[$period] }}
                            </span>
                        @else
                            <span class="text-gray-300 text-lg font-light">—</span>
                        @endif
                    </div>
                @endforeach

                {{-- Final Average --}}
                <div class="col-span-2 px-4 py-4 text-center">
                    @if (!empty($row['final_rating']))
                        <span
                            class="inline-flex items-center justify-center w-14 h-10 rounded-xl text-base font-extrabold shadow-sm
                            {{ (int) $row['final_rating'] >= 75 ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                            {{ $row['final_rating'] }}
                        </span>
                    @else
                        <span class="text-gray-300 text-lg">—</span>
                    @endif
                </div>
                <div class="col-span-2 px-4 py-4 text-sm text-gray-600">
                    {{ $row['remarks'] ?: '—' }}
                </div>
            </div>
        @empty
            <div class="col-span-12 py-16 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <p class="text-gray-400 text-sm font-medium">No grades record found for this academic year</p>
                <p class="text-gray-300 text-xs mt-1">Grades will appear here once submitted by your teacher</p>
            </div>
        @endforelse

        {{-- General Average Row --}}
        @php
            $allFinals = array_filter(array_column($termGrades, 'final_rating'), fn($v) => $v !== null);
            $generalAverage = count($allFinals) > 0 ? round(array_sum($allFinals) / count($allFinals), 0) : null;
        @endphp
        <div class="grid grid-cols-12 items-center bg-blue-100 text-blue-800">
            <div class="col-span-8 px-6 py-5 font-bold text-sm uppercase tracking-wider">
                General Average
            </div>
            <div class="col-span-2 px-4 py-5 text-center">
                @if ($generalAverage)
                    <span
                        class="inline-flex items-center justify-center w-16 h-10 rounded-xl text-lg font-extrabold shadow
                        {{ $generalAverage >= 75 ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                        {{ $generalAverage }}
                    </span>
                @else
                    <span class="text-gray-400">—</span>
                @endif
            </div>
            <div class="col-span-2 px-4 py-5"></div>
        </div>
    </div>

    {{-- Mobile grade cards --}}
    <div class="space-y-3 lg:hidden">
        @forelse($termGrades as $row)
            <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="flex items-start justify-between gap-3 border-b border-gray-100 bg-blue-50 px-4 py-3">
                    <h2 class="min-w-0 break-words text-sm font-bold text-gray-800">{{ $row['subject_name'] }}</h2>
                    @if (!empty($row['final_rating']))
                        <span class="inline-flex h-9 min-w-12 shrink-0 items-center justify-center rounded-xl px-2 text-base font-extrabold text-white shadow-sm {{ (int) $row['final_rating'] >= 75 ? 'bg-green-500' : 'bg-red-500' }}">
                            {{ $row['final_rating'] }}
                        </span>
                    @else
                        <span class="shrink-0 text-gray-400">&mdash;</span>
                    @endif
                </div>
                <div class="grid grid-cols-3 divide-x divide-gray-100 px-2 py-4 text-center">
                    @foreach ([
                        'first_grading' => '1st Term',
                        'second_grading' => '2nd Term',
                        'third_grading' => '3rd Term',
                    ] as $period => $label)
                        <div class="px-1">
                            <p class="text-[0.65rem] font-bold uppercase tracking-wide text-gray-400">{{ $label }}</p>
                            @if (!empty($row[$period]))
                                <span class="mt-2 inline-block rounded-lg px-2 py-1 text-sm font-bold {{ (int) $row[$period] >= 75 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $row[$period] }}
                                </span>
                            @else
                                <span class="mt-2 block text-gray-300">&mdash;</span>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="flex items-center justify-between gap-3 border-t border-gray-100 px-4 py-3 text-sm">
                    <span class="font-medium text-gray-500">Remarks</span>
                    <span class="break-words text-right font-semibold text-gray-700">{{ $row['remarks'] ?: '—' }}</span>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-gray-200 bg-gray-50 px-5 py-10 text-center">
                <p class="text-sm font-medium text-gray-500">No grades record found for this academic year.</p>
                <p class="mt-1 text-xs text-gray-400">Grades will appear here once submitted by your teacher.</p>
            </div>
        @endforelse

        @php
            $mobileFinals = array_filter(array_column($termGrades, 'final_rating'), fn($v) => $v !== null);
            $mobileGeneralAverage = count($mobileFinals) > 0 ? round(array_sum($mobileFinals) / count($mobileFinals), 0) : null;
        @endphp
        <div class="flex items-center justify-between rounded-2xl bg-blue-100 px-4 py-4 text-blue-800 shadow-sm">
            <span class="text-sm font-bold uppercase tracking-wide">General Average</span>
            @if ($mobileGeneralAverage)
                <span class="inline-flex h-10 min-w-16 items-center justify-center rounded-xl px-3 text-lg font-extrabold text-white shadow {{ $mobileGeneralAverage >= 75 ? 'bg-green-500' : 'bg-red-500' }}">
                    {{ $mobileGeneralAverage }}
                </span>
            @else
                <span class="text-gray-400">&mdash;</span>
            @endif
        </div>
    </div>

    {{-- ===== ATTENDANCE SECTION ===== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="flex items-center justify-between bg-blue-50 px-4 py-4 sm:px-6 sm:py-5">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h2 class="text-lg font-bold text-blue-800">Attendance Report</h2>
            </div>
        </div>

        @if (count($attendance) > 0)
            <div class="overflow-x-auto">
                <table class="w-full min-w-[38rem] text-sm">
                    <thead>
                        <tr class="bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-widest">
                            <th class="px-6 py-3 text-left">Month</th>
                            <th class="px-4 py-3 text-center">School Days</th>
                            <th class="px-4 py-3 text-center">Present</th>
                            <th class="px-4 py-3 text-center">Absent</th>
                            <th class="px-4 py-3 text-center">% Attendance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendance as $index => $row)
                            <tr
                                class="border-b border-gray-100 hover:bg-blue-50 transition-colors {{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-6 py-4 font-semibold text-gray-700">{{ $row['month'] }}
                                    {{ $row['year'] }}</td>
                                <td class="px-4 py-4 text-center text-gray-600">{{ $row['school_days'] }}</td>
                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="inline-flex items-center justify-center px-2 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-700">
                                        {{ $row['present'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if ($row['absent'] > 0)
                                        <span
                                            class="inline-flex items-center justify-center px-2 py-1 rounded-lg text-xs font-semibold bg-red-100 text-red-700">
                                            {{ $row['absent'] }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @php
                                        $rateColor =
                                            $row['rate'] >= 90
                                                ? 'text-green-600'
                                                : ($row['rate'] >= 75
                                                    ? 'text-yellow-600'
                                                    : 'text-red-600');
                                    @endphp
                                    <span class="font-bold {{ $rateColor }}">{{ $row['rate'] }}%</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @php
                            $totalSchoolDays = array_sum(array_column($attendance, 'school_days'));
                            $totalPresent = array_sum(array_column($attendance, 'present'));
                            $totalAbsent = array_sum(array_column($attendance, 'absent'));
                            $overallRate =
                                $totalSchoolDays > 0 ? round(($totalPresent / $totalSchoolDays) * 100, 1) : 0;
                        @endphp
                        <tr class="bg-blue-100 text-blue-800 font-bold">
                            <td class="px-6 py-4 text-sm uppercase tracking-wider">Overall</td>
                            <td class="px-4 py-4 text-center">{{ $totalSchoolDays }}</td>
                            <td class="px-4 py-4 text-center">
                                <span
                                    class="inline-flex items-center justify-center px-2 py-1 rounded-lg text-xs font-bold bg-green-500 text-white">
                                    {{ $totalPresent }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                @if ($totalAbsent > 0)
                                    <span
                                        class="inline-flex items-center justify-center px-2 py-1 rounded-lg text-xs font-bold bg-red-500 text-white">
                                        {{ $totalAbsent }}
                                    </span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-center text-base">
                                @php
                                    $overallColor =
                                        $overallRate >= 90
                                            ? 'text-green-600'
                                            : ($overallRate >= 75
                                                ? 'text-yellow-600'
                                                : 'text-red-600');
                                @endphp
                                <span class="{{ $overallColor }}">{{ $overallRate }}%</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-sm italic">No attendance records found.</p>
            </div>
        @endif
    </div>

    {{-- ===== LEGEND ===== --}}
    <div class="flex flex-wrap gap-4 justify-center text-xs text-gray-500">
        <div class="flex items-center gap-1.5">
            <span class="inline-block w-3 h-3 rounded bg-green-100 border border-green-300"></span>
            Passing (75 and above)
        </div>
        <div class="flex items-center gap-1.5">
            <span class="inline-block w-3 h-3 rounded bg-red-100 border border-red-300"></span>
            Failed (below 75)
        </div>
    </div>

    {{-- ===== UPLOADED GRADE FILES ===== --}}
    @if ($studentFiles && count($studentFiles) > 0)
        <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm sm:p-6">
            <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Grade Files
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($studentFiles as $item)
                    <div class="border rounded-2xl p-4 shadow-sm hover:shadow-md transition-all bg-white group">
                        <div class="mb-3">
                            <div class="p-3 rounded-xl bg-blue-50 text-blue-500 inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M4 12V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2" />
                                    <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                    <path d="M10 16h2v6" />
                                    <path d="M10 22h4" />
                                    <rect x="2" y="16" width="4" height="6" rx="2" />
                                </svg>
                            </div>
                        </div>
                        <p class="font-semibold text-gray-800 truncate text-sm">{{ $item['name'] }}</p>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ \Carbon\Carbon::parse($item['created_at'])->format('M d, Y') }}</p>
                        <div class="mt-3">
                            <a href="#" wire:click.prevent="download({{ $item['id'] }})"
                                class="text-blue-600 text-sm font-semibold hover:underline">↓ Download</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

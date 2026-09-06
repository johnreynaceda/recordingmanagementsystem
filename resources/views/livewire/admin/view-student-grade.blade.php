@section('title', 'Student Grades')

<div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-main via-red-600 to-red-800 p-6 text-white shadow-xl shadow-red-100 sm:p-8">
        <div class="pointer-events-none absolute -right-20 -top-24 h-64 w-64 rounded-full bg-white/10"></div>
        <div class="pointer-events-none absolute -bottom-24 right-24 h-48 w-48 rounded-full bg-black/5"></div>

        <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-start gap-4">
                <div class="hidden rounded-2xl bg-white/15 p-3 ring-1 ring-white/20 backdrop-blur sm:block">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2m-6 0a3 3 0 0 1 6 0m-6 0a3 3 0 0 0 6 0m-6 7h6m-6 4h4" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-red-100">Academic Records</p>
                    <h1 class="mt-1 text-2xl font-extrabold tracking-tight sm:text-3xl">Student Grades</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-red-100">
                        Review grading-period results, final ratings, and uploaded grade documents.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.students') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-red-950/25 px-4 py-2.5 text-sm font-bold text-white ring-1 ring-white/30 backdrop-blur transition hover:bg-red-950/40 focus:outline-none focus:ring-2 focus:ring-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0 7-7m-7 7h18" />
                    </svg>
                    Back
                </a>

                @if ($selectedStudentId && $studentInfo && $currentStudent)
                    <a href="{{ route('admin.student-attendance', $currentStudent) }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-red-950/25 px-4 py-2.5 text-sm font-bold text-white ring-1 ring-white/30 backdrop-blur transition hover:bg-red-950/40 focus:outline-none focus:ring-2 focus:ring-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                        </svg>
                        View Attendance
                    </a>

                    @if ($this->canPromote)
                        <button type="button" wire:click="promoteStudent"
                            wire:confirm="Are you sure you want to promote this student to the next school year?"
                            wire:loading.attr="disabled" wire:target="promoteStudent"
                            class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-main shadow-sm transition hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-red-700 disabled:opacity-60">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 7-7 7 7M12 5v14" />
                            </svg>
                            <span wire:loading.remove wire:target="promoteStudent">Promote Student</span>
                            <span wire:loading wire:target="promoteStudent">Promoting...</span>
                        </button>
                    @endif

                    <button type="button" wire:click="exportGrades" wire:loading.attr="disabled" wire:target="exportGrades"
                        class="inline-flex items-center gap-2 rounded-xl bg-red-950/25 px-4 py-2.5 text-sm font-bold text-white ring-1 ring-white/30 backdrop-blur transition hover:bg-red-950/40 focus:outline-none focus:ring-2 focus:ring-white disabled:opacity-60">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0-4-4m4 4 4-4M5 21h14" />
                        </svg>
                        <span wire:loading.remove wire:target="exportGrades">Export Grades</span>
                        <span wire:loading wire:target="exportGrades">Preparing...</span>
                    </button>
                @endif
            </div>
        </div>
    </section>

    @if ($selectedStudentId && $studentInfo)
        @php
            $allFinals = array_filter(
                array_column($termGrades, 'final_rating'),
                fn ($value) => $value !== null && $value !== '',
            );
            $generalAverage = count($allFinals) > 0 ? round(array_sum($allFinals) / count($allFinals), 0) : null;
        @endphp

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-red-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Student</p>
                        <p class="mt-2 text-lg font-bold text-gray-900">{{ $studentInfo['name'] }}</p>
                        <p class="mt-1 text-sm text-gray-500">LRN {{ $studentInfo['lrn'] }}</p>
                    </div>
                    <span class="rounded-xl bg-red-50 p-2.5 text-main">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM5 21a7 7 0 0 1 14 0" />
                        </svg>
                    </span>
                </div>
            </div>

            <div class="rounded-2xl border border-red-100 bg-white p-5 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Enrollment</p>
                <p class="mt-2 text-lg font-bold text-gray-900">{{ $studentRecordInfo['grade_level'] ?? 'Not enrolled' }}</p>
                <p class="mt-1 text-sm text-gray-500">Section {{ $studentRecordInfo['section'] ?? 'N/A' }}</p>
            </div>

            <div class="rounded-2xl border border-red-100 bg-white p-5 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Academic Year</p>
                <p class="mt-2 text-lg font-bold text-gray-900">{{ $studentRecordInfo['academic_year'] ?? 'N/A' }}</p>
                <div class="mt-2 flex flex-wrap gap-2">
                    @if ($currentStudent && $currentStudent->status === 'Graduated')
                        <span class="rounded-full bg-purple-100 px-2.5 py-1 text-xs font-bold text-purple-700">Graduated</span>
                    @elseif ($this->isPromoted)
                        <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-bold text-emerald-700">Promoted</span>
                    @else
                        <span class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-bold text-main">Current Record</span>
                    @endif
                </div>
            </div>

            <div class="rounded-2xl bg-main p-5 text-white shadow-lg shadow-red-100">
                <p class="text-xs font-bold uppercase tracking-wider text-red-100">General Average</p>
                <div class="mt-2 flex items-end justify-between gap-3">
                    <p class="text-4xl font-black">{{ $generalAverage ?? '—' }}</p>
                    @if ($generalAverage !== null)
                        <span class="mb-1 rounded-full bg-white/15 px-2.5 py-1 text-xs font-bold ring-1 ring-white/20">
                            {{ $generalAverage >= 75 ? 'Passing' : 'Needs Improvement' }}
                        </span>
                    @endif
                </div>
            </div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-red-100 bg-white shadow-sm">
            <div class="flex flex-col gap-2 border-b border-red-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Grade Summary</h2>
                    <p class="mt-1 text-sm text-gray-500">Grades for each learning area and grading period.</p>
                </div>
                <div class="flex gap-4 text-xs text-gray-500">
                    <span class="inline-flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>Passing</span>
                    <span class="inline-flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-main"></span>Below 75</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-[850px] w-full text-sm">
                    <thead class="bg-red-50 text-xs font-bold uppercase tracking-wider text-red-800">
                        <tr>
                            <th class="px-6 py-4 text-left">Learning Area</th>
                            <th class="px-4 py-4 text-center">1st Term</th>
                            <th class="px-4 py-4 text-center">2nd Term</th>
                            <th class="px-4 py-4 text-center">3rd Term</th>
                            <th class="px-4 py-4 text-center">Final Average</th>
                            <th class="px-6 py-4 text-left">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($termGrades as $row)
                            <tr class="transition hover:bg-red-50/40">
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $row['subject_name'] }}</td>
                                @foreach (['first_grading', 'second_grading', 'third_grading'] as $period)
                                    <td class="px-4 py-4 text-center">
                                        @if ($row[$period] !== null && $row[$period] !== '')
                                            <span class="inline-flex min-w-10 justify-center rounded-lg px-2.5 py-1.5 font-bold {{ (int) $row[$period] >= 75 ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-main' }}">
                                                {{ $row[$period] }}
                                            </span>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="px-4 py-4 text-center">
                                    @if ($row['final_rating'] !== null && $row['final_rating'] !== '')
                                        <span class="inline-flex min-w-12 justify-center rounded-xl px-3 py-2 font-extrabold text-white {{ (int) $row['final_rating'] >= 75 ? 'bg-emerald-500' : 'bg-main' }}">
                                            {{ $row['final_rating'] }}
                                        </span>
                                    @else
                                        <span class="text-gray-300">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $row['remarks'] ?: '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <svg class="mx-auto h-12 w-12 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2m-6 0a3 3 0 0 1 6 0m-6 0a3 3 0 0 0 6 0m-6 7h6m-6 4h4" />
                                    </svg>
                                    <p class="mt-3 font-semibold text-gray-600">No grades recorded</p>
                                    <p class="mt-1 text-xs text-gray-400">There are no grades for the selected academic year.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if (count($termGrades) > 0)
                        <tfoot class="border-t border-red-100 bg-red-50">
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-red-800">General Average</td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex min-w-12 justify-center rounded-xl bg-main px-3 py-2 text-base font-black text-white">
                                        {{ $generalAverage ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4"></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </section>

        @if ($studentFiles && count($studentFiles) > 0)
            <section class="rounded-2xl border border-red-100 bg-white p-5 shadow-sm sm:p-6">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Grade Files</h2>
                    <p class="mt-1 text-sm text-gray-500">Uploaded documents associated with this student.</p>
                </div>

                <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    @foreach ($studentFiles as $item)
                        <article class="group rounded-2xl border border-gray-200 p-4 transition hover:-translate-y-0.5 hover:border-red-200 hover:shadow-md">
                            <div class="flex items-start justify-between gap-3">
                                <span class="rounded-xl bg-red-50 p-3 text-main transition group-hover:bg-main group-hover:text-white">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8m-6-6 6 6m-6-6v6h6M8 14h8m-8 4h5" />
                                    </svg>
                                </span>
                                <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($item['created_at'])->format('M d, Y') }}</span>
                            </div>
                            <p class="mt-4 truncate text-sm font-bold text-gray-800" title="{{ $item['name'] }}">{{ $item['name'] }}</p>
                            <button type="button" wire:click="download({{ $item['id'] }})"
                                class="mt-4 inline-flex items-center gap-1.5 text-sm font-bold text-main transition hover:text-red-700 hover:underline">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0-4-4m4 4 4-4M5 21h14" />
                                </svg>
                                Download
                            </button>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    @else
        <section class="rounded-2xl border border-dashed border-red-200 bg-white px-6 py-20 text-center shadow-sm">
            <span class="mx-auto inline-flex rounded-2xl bg-red-50 p-4 text-main">
                <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM5 21a7 7 0 0 1 14 0" />
                </svg>
            </span>
            <h2 class="mt-4 text-lg font-bold text-gray-800">No student selected</h2>
            <p class="mx-auto mt-2 max-w-md text-sm text-gray-500">
                Open a student from the student records page to review their grades and files.
            </p>
            <a href="{{ route('admin.students') }}"
                class="mt-5 inline-flex items-center rounded-xl bg-main px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-main focus:ring-offset-2">
                View Student Records
            </a>
        </section>
    @endif
</div>

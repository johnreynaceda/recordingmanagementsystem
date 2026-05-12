@php
    $student = $getRecord();
    $imageUrl = filled($student->image_path) ? Storage::url($student->image_path) : asset('images/no.jpg');
    $displayRecord = $student->studentRecords->where('is_active', true)->sortByDesc('grade_level_id')->first();

    if (!$displayRecord) {
        $displayRecord = $student->studentRecords->sortByDesc('grade_level_id')->first();
    }

    $middleInitial = filled($student->middlename) ? strtoupper(substr($student->middlename, 0, 1)) . '.' : '';
    $fullName = trim($student->firstname . ' ' . $middleInitial . ' ' . $student->lastname);
    $sectionName = $displayRecord?->section?->name;
    $gradeName = $displayRecord?->gradeLevel?->name ?? 'Not Assigned';
    $yearName = $displayRecord?->academicYear?->name ?? 'No academic year';
    $isGraduated = $student->status === 'Graduated';
@endphp

<div class="group relative min-h-[18rem] overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-red-200 hover:shadow-lg">
    <div class="absolute inset-x-0 top-0 h-20 bg-gradient-to-r from-slate-900 via-slate-800 to-main"></div>

    <div class="relative flex h-full flex-col p-5">
        <div class="flex items-start justify-between gap-3">
            <div class="relative">
                <img src="{{ $imageUrl }}" alt="Student profile photo"
                    class="h-24 w-24 rounded-2xl border-4 border-white object-cover shadow-md">
                <span
                    class="absolute -bottom-2 left-3 rounded-full border border-white bg-white px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide {{ $isGraduated ? 'text-purple-700' : 'text-emerald-700' }}">
                    {{ $isGraduated ? 'Graduated' : 'Active' }}
                </span>
            </div>

            <div class="rounded-full bg-white/15 px-3 py-1 text-xs font-semibold text-white ring-1 ring-white/20">
                LRN {{ $student->lrn ?? 'N/A' }}
            </div>
        </div>

        <div class="mt-5 min-w-0">
            <h3 class="line-clamp-2 text-lg font-bold leading-tight text-slate-950">
                {{ $fullName }}
            </h3>
            <p class="mt-1 text-sm font-semibold uppercase tracking-wide text-main">
                {{ strtoupper($student->lastname . ', ' . $student->firstname) }}
            </p>
        </div>

        <div class="mt-5 grid grid-cols-2 gap-3 text-sm">
            <div class="rounded-lg border border-slate-100 bg-slate-50 p-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Grade</p>
                <p class="mt-1 truncate font-bold text-slate-800">{{ $gradeName }}</p>
            </div>
            <div class="rounded-lg border border-slate-100 bg-slate-50 p-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Section</p>
                <p class="mt-1 truncate font-bold text-slate-800">{{ $sectionName ?? 'Unassigned' }}</p>
            </div>
        </div>

        <div class="mt-auto pt-5">
            <div class="flex items-center justify-between gap-3 border-t border-slate-100 pt-4">
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">School Year</p>
                    <p class="mt-0.5 truncate text-sm font-semibold text-slate-700">{{ $yearName }}</p>
                </div>
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-50 text-main transition group-hover:bg-main group-hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

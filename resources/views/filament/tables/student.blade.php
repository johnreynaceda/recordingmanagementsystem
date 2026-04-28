<div class="flex flex-col justify-center items-center w-full mb-5">
    @php
        $imageUrl = filled($getRecord()->image_path) ? Storage::url($getRecord()->image_path) : asset('images/no.jpg');
    @endphp

    <div class="">
        <img src="{{ $imageUrl }}" alt="Student profile photo"
            class="h-32 object-cover  w-32 rounded-full border-gray-400 border-4 ">

    </div>
    <div class="mt-2 text-center">
        <h1 class="font-bold text-lg uppercase">
            {{ $getRecord()->lastname . ', ' . $getRecord()->firstname . ' ' . ($getRecord()->middlename == null ? '' : $getRecord()->middlename[0] . '.') }}
        </h1>

        <h1 class="font-semibold text-main">
            {{ $getRecord()->lrn }}
        </h1>
        @php
            $displayRecord = $getRecord()
                ->studentRecords->where('is_active', true)
                ->sortByDesc('grade_level_id')
                ->first();
            if (!$displayRecord) {
                $displayRecord = $getRecord()->studentRecords->sortByDesc('grade_level_id')->first();
            }
        @endphp
        @if ($displayRecord)
            <p class="text-sm text-gray-600 font-medium">
                {{ $displayRecord->gradeLevel->name ?? 'Not Assigned' }}{{ $displayRecord->section ? ' - ' . $displayRecord->section->name : '' }}
            </p>
            @if ($displayRecord->academicYear)
                <p class="text-xs text-gray-400">{{ $displayRecord->academicYear->name }}</p>
            @endif
        @else
            <p class="text-sm text-gray-600 font-medium">Not Assigned</p>
        @endif
        @if ($getRecord()->status === 'Graduated')
            <span
                class="inline-flex items-center mt-1 px-2 py-0.5 rounded-full text-xs font-bold bg-purple-100 text-purple-700 uppercase tracking-wider">Graduated</span>
        @endif


    </div>

</div>

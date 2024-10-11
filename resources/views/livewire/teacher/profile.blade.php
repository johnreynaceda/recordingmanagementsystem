<div class="max-w-6xl mx-auto bg-white border rounded-lg shadow-lg p-6">
    <!-- Teacher Information -->
    <div class="flex items-start">
        <!-- Photo -->
        <div class="flex-shrink-0 w-32 h-32 rounded overflow-hidden border border-gray-200">
            <img src="path-to-teacher-photo.jpg" alt="Teacher Photo" class="w-full h-full object-cover">
        </div>

        <!-- Details -->
        <div class="ml-6">
            <h2 class="text-2xl font-bold text-gray-800">{{ $record->firstname . ' ' . $record->lastname }}</h2>
            <p class="text-sm text-gray-600">Address: {{ $record->address }}</p>
            <p class="mt-2 text-sm text-gray-700">Experience: 2 Years</p>
            @php
                $grade_levels = $record->sections->pluck('grade_level_id')->toArray();
                $sections = \App\Models\GradeLevelSubject::whereIn('grade_level_id', $grade_levels)->get();
            @endphp
            <p class="text-sm text-gray-700">Subjects: {{ $sections->count() }}</p>

            <p class="mt-4 text-gray-600">
                Test description ashajkhsjkahsjkahsjkhajkshakj.
            </p>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <button
            class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Update
        </button>
    </div>



</div>

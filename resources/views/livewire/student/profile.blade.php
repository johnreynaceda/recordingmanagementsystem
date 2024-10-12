<div>
    <div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <div class="flex flex-col md:flex-row items-center md:space-x-6">
            <div class="flex-shrink-0 mb-4 md:mb-0">
                @if ($student->image_path)
                    <img src="{{ asset('storage/' . $student->image_path) }}" alt="Student Photo" class="w-32 h-32 rounded-full object-cover shadow-md">
                @else
                    <span>No Image</span>
                @endif
            </div>
            <div class="flex-grow space-y-4 text-gray-700">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">Student Information</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-sm font-semibold text-gray-500">First Name:</span>
                        <p class="text-lg font-medium">{{ $student->firstname }}</p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-500">Middle Name:</span>
                        <p class="text-lg font-medium">{{ $student->middlename }}</p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-500">Last Name:</span>
                        <p class="text-lg font-medium">{{ $student->lastname }}</p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-500">Birthdate:</span>
                        <p class="text-lg font-medium">{{ date('F j, Y', strtotime($student->birthdate)) }}</p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-500">Address:</span>
                        <p class="text-lg font-medium">{{ $student->address }}</p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-500">Section:</span>
                        <p class="text-lg font-medium">{{ $section }}</p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-500">Grade Level:</span>
                        <p class="text-lg font-medium">{{ $gradeLevel }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('title', 'Index')
<x-student-layout>
    <div>
        <div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
            <div class="flex flex-col md:flex-row items-center md:space-x-6">

                <div class="flex-shrink-0 mb-4 md:mb-0">
                    <img src="path/to/student-photo.jpg" alt="Student Photo" class="w-32 h-32 rounded-full object-cover shadow-md">
                </div>


                <div class="flex-grow space-y-4 text-gray-700">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">Student Information</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <span class="block text-sm font-semibold text-gray-500">Name:</span>
                            <p class="text-lg font-medium">John Doe</p>
                        </div>
                        <div>
                            <span class="block text-sm font-semibold text-gray-500">Birthdate:</span>
                            <p class="text-lg font-medium">January 1, 2008</p>
                        </div>
                        <div>
                            <span class="block text-sm font-semibold text-gray-500">Age:</span>
                            <p class="text-lg font-medium">16</p>
                        </div>
                        <div>
                            <span class="block text-sm font-semibold text-gray-500">Grade:</span>
                            <p class="text-lg font-medium">10th Grade</p>
                        </div>
                        <div>
                            <span class="block text-sm font-semibold text-gray-500">LRN:</span>
                            <p class="text-lg font-medium">1234567890</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-student-layout>



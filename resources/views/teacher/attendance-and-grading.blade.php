@section('title', 'Attendance & Grades')
<x-teacher-layout>
    <div x-data="{ activeTab: 'attendance' }">
        <div class="flex border-b border-gray-200 mb-6">
            <button @click="activeTab = 'attendance'"
                :class="activeTab === 'attendance' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="whitespace-nowrap py-4 px-6 font-medium text-sm border-b-2 transition-colors">
                <svg class="w-5 h-5 inline-block mr-2 -mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Attendance
            </button>
            <button @click="activeTab = 'grading'"
                :class="activeTab === 'grading' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="whitespace-nowrap py-4 px-6 font-medium text-sm border-b-2 transition-colors">
                <svg class="w-5 h-5 inline-block mr-2 -mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Grades
            </button>
        </div>

        <div x-show="activeTab === 'attendance'" x-transition>
            <div class="flex justify-between items-end">
                <h1 class="text-2xl font-semibold uppercase text-main">Attendance</h1>
                <x-button label="View Records" class="uppercase" right-icon="document-text" slate sm
                    href="{{ route('teacher.view-records') }}" />
            </div>
            <div class="mt-10">
                <livewire:teacher.attendance-section />
            </div>
        </div>

        <div x-show="activeTab === 'grading'" x-transition>
            <livewire:teacher.grading />
        </div>
    </div>
</x-teacher-layout>

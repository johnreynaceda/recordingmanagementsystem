@section('title', 'Attendance')
<x-teacher-layout>
    <div>
        <div class="flex justify-between items-end">
            <h1 class="text-2xl font-semibold uppercase text-main">Attendance</h1>
            <x-button label="View Records" class="uppercase" right-icon="document-text" slate sm
                href="{{ route('teacher.view-records') }}" />
        </div>
        <div class="mt-10">
            <livewire:teacher.attendance-section />
        </div>
    </div>

</x-teacher-layout>

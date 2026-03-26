@section('title', 'View Student Grades')
<x-admin-layout>
    <div>
        <livewire:admin.view-student-grade :studentId="$studentId ?? null" />
    </div>
</x-admin-layout>

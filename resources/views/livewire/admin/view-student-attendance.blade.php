@section('title', 'Student Attendance')

<div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
    <div class="overflow-hidden rounded-2xl bg-gradient-to-r from-red-700 to-red-500 p-6 text-white shadow-lg">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <a href="{{ route('admin.students') }}"
                    class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-red-100 transition hover:text-white">
                    <x-heroicon-o-arrow-left class="h-4 w-4" />
                    Back to students
                </a>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-red-100">Attendance Report</p>
                <h1 class="mt-1 text-2xl font-bold sm:text-3xl">
                    {{ $student->lastname }}, {{ $student->firstname }} {{ $student->middlename }}
                </h1>
                <p class="mt-2 text-sm text-red-100">LRN: {{ $student->lrn ?? 'N/A' }}</p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.student-attendance.export', [
                    'student' => $student,
                    'format' => 'pdf',
                    'academic_year_id' => $academic_year_id,
                    'date_from' => $date_from,
                    'date_to' => $date_to,
                ]) }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-red-700 shadow-sm transition hover:-translate-y-0.5 hover:bg-red-50 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-white/70">
                    <x-heroicon-o-document-arrow-down class="h-5 w-5" />
                    Export PDF
                </a>
                <a href="{{ route('admin.student-attendance.export', [
                    'student' => $student,
                    'format' => 'excel',
                    'academic_year_id' => $academic_year_id,
                    'date_from' => $date_from,
                    'date_to' => $date_to,
                ]) }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-emerald-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-emerald-300">
                    <x-heroicon-o-table-cells class="h-5 w-5" />
                    Export Excel
                </a>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-100 px-6 py-4">
            <h2 class="font-semibold text-gray-900">Attendance Records</h2>
            <p class="mt-1 text-sm text-gray-500">
                {{ \Carbon\Carbon::parse($report['date_from'])->format('M d, Y') }} –
                {{ \Carbon\Carbon::parse($report['date_to'])->format('M d, Y') }}
            </p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Day</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Grade Level</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Section</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($report['details'] as $detail)
                        <tr class="transition hover:bg-red-50/50">
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{{ $detail['formatted_date'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $detail['day'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $detail['grade_level'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $detail['section'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    {{ $detail['status'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center">
                                <x-heroicon-o-calendar-days class="mx-auto h-10 w-10 text-gray-300" />
                                <p class="mt-3 text-sm font-medium text-gray-600">No attendance records found</p>
                                <p class="mt-1 text-xs text-gray-400">No attendance has been recorded for this student.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

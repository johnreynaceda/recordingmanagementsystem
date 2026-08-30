<?php

namespace App\Services;

use App\Models\AcademicYear;
use App\Models\AttendanceRecord;
use App\Models\Student;
use Carbon\Carbon;

class StudentAttendanceReportService
{
    public function build(
        Student $student,
        ?int $academicYearId = null,
        ?string $dateFrom = null,
        ?string $dateTo = null,
    ): array {
        $academicYear = AcademicYear::find($academicYearId)
            ?? AcademicYear::getActiveYear()
            ?? AcademicYear::orderByDesc('start_date')->first();

        $from = Carbon::parse($dateFrom ?: ($academicYear?->start_date ?? now()->startOfYear()))->startOfDay();
        $to = Carbon::parse($dateTo ?: ($academicYear?->end_date ?? now()->endOfYear()))->endOfDay();

        $records = AttendanceRecord::query()
            ->with(['studentRecord.gradeLevel', 'studentRecord.section'])
            ->whereHas('studentRecord', function ($query) use ($student, $academicYear) {
                $query->where('student_id', $student->id)
                    ->when($academicYear, fn ($query) => $query->where('academic_year_id', $academicYear->id));
            })
            ->when($academicYear, function ($query) use ($academicYear) {
                $query->where(function ($query) use ($academicYear) {
                    $query->where('academic_year_id', $academicYear->id)
                        ->orWhereNull('academic_year_id');
                });
            })
            ->whereBetween('created_at', [$from, $to])
            ->orderBy('created_at')
            ->get();

        $details = $records
            ->unique(fn (AttendanceRecord $record) => $record->created_at->toDateString())
            ->map(fn (AttendanceRecord $record): array => [
                'date' => $record->created_at->format('Y-m-d'),
                'formatted_date' => $record->created_at->format('F d, Y'),
                'day' => $record->created_at->format('l'),
                'status' => 'Present',
                'grade_level' => $record->studentRecord?->gradeLevel?->name ?? 'N/A',
                'section' => $record->studentRecord?->section?->name ?? 'N/A',
            ])
            ->values()
            ->all();

        $schoolDays = $this->weekdaysBetween($from, $to);
        $present = count($details);
        $absent = max(0, $schoolDays - $present);

        return [
            'student' => $student,
            'academic_year' => $academicYear,
            'date_from' => $from->toDateString(),
            'date_to' => $to->toDateString(),
            'details' => $details,
            'summary' => [
                'school_days' => $schoolDays,
                'present' => $present,
                'absent' => $absent,
                'rate' => $schoolDays > 0 ? round(($present / $schoolDays) * 100, 1) : 0,
            ],
        ];
    }

    private function weekdaysBetween(Carbon $from, Carbon $to): int
    {
        $days = 0;

        for ($date = $from->copy()->startOfDay(); $date->lte($to); $date->addDay()) {
            if (! $date->isWeekend()) {
                $days++;
            }
        }

        return $days;
    }
}

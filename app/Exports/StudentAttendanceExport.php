<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentAttendanceExport implements FromArray, ShouldAutoSize, WithStyles
{
    public function __construct(private readonly array $report) {}

    public function array(): array
    {
        $student = $this->report['student'];
        $summary = $this->report['summary'];

        $rows = [
            ['STUDENT ATTENDANCE REPORT'],
            ['Student', trim($student->lastname.', '.$student->firstname.' '.$student->middlename)],
            ['LRN', $student->lrn ?? 'N/A'],
            ['Academic Year', $this->report['academic_year']?->name ?? 'N/A'],
            ['Date Range', $this->report['date_from'].' to '.$this->report['date_to']],
            [],
            ['Date', 'Day', 'Status', 'Grade Level', 'Section'],
        ];

        foreach ($this->report['details'] as $detail) {
            $rows[] = [
                $detail['formatted_date'],
                $detail['day'],
                $detail['status'],
                $detail['grade_level'],
                $detail['section'],
            ];
        }

        $rows[] = [];
        $rows[] = ['Summary', 'School Days', 'Present', 'Absent', 'Attendance Rate'];
        $rows[] = ['', $summary['school_days'], $summary['present'], $summary['absent'], $summary['rate'].'%'];

        return $rows;
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            7 => ['font' => ['bold' => true]],
            count($this->report['details']) + 9 => ['font' => ['bold' => true]],
        ];
    }
}

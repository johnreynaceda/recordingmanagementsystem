<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Seeder;

class CreateDefaultAcademicYearSeeder extends Seeder
{
    public function run(): void
    {
        $year = AcademicYear::create([
            'name' => '2024-2025',
            'start_date' => '2024-06-01',
            'end_date' => '2025-03-31',
            'is_active' => true,
        ]);

        $studentRecords = \App\Models\StudentRecord::whereNull('academic_year_id')->update(['academic_year_id' => $year->id]);
        $attendanceRecords = \App\Models\AttendanceRecord::whereNull('academic_year_id')->update(['academic_year_id' => $year->id]);
        $termGrades = \App\Models\TermGrade::whereNull('academic_year_id')->update(['academic_year_id' => $year->id]);
        $studentGrades = \App\Models\StudentGrade::whereNull('academic_year_id')->update(['academic_year_id' => $year->id]);
        $requests = \App\Models\Request::whereNull('academic_year_id')->update(['academic_year_id' => $year->id]);
    }
}

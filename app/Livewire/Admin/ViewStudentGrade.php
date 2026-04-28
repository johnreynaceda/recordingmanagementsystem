<?php

namespace App\Livewire\Admin;

use App\Models\AcademicYear;
use App\Models\AttendanceRecord;
use App\Models\GradeLevel;
use App\Models\Student;
use App\Models\StudentGrade;
use App\Models\StudentRecord;
use App\Models\TermGrade;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class ViewStudentGrade extends Component
{
    public $studentFiles = [];

    public $termGrades = [];

    public $attendance = [];

    public $selected_academic_year_id;

    public $studentGradeLevel = null;

    public $studentRecordInfo = null;

    public $selectedStudentId;

    public $studentInfo = null;

    public $currentStudent = null;

    public function mount($studentId = null)
    {
        $this->selected_academic_year_id = AcademicYear::getActiveYearId();

        $passedId = $studentId ?? request('studentId');

        if ($passedId) {
            $this->selectedStudentId = $passedId;
            $this->loadStudent();
            $this->loadData();
        }
    }

    public function loadStudent()
    {
        if (! $this->selectedStudentId) {
            return;
        }

        $this->currentStudent = Student::with('user')->find($this->selectedStudentId);

        if (! $this->currentStudent) {
            $user = User::with('student')->find($this->selectedStudentId);
            $this->currentStudent = $user?->student;
        }

        if ($this->currentStudent) {
            $this->studentInfo = [
                'name' => $this->currentStudent->firstname.' '.$this->currentStudent->lastname,
                'lrn' => $this->currentStudent->lrn ?? 'N/A',
                'email' => $this->currentStudent->user->email ?? 'N/A',
            ];
        }
    }

    public function updatedSelectedStudentId()
    {
        $this->loadStudent();
        $this->loadData();
    }

    public function download($fileId)
    {
        $file = StudentGrade::findOrFail($fileId);
        $path = storage_path('app/public/'.$file->file_path);

        if (! file_exists($path)) {
            abort(404, 'File not found.');
        }

        return response()->download($path, basename($path));
    }

    public function loadData()
    {
        if (! $this->currentStudent || ! $this->selected_academic_year_id) {
            $this->studentFiles = [];
            $this->termGrades = [];
            $this->attendance = [];
            $this->studentGradeLevel = null;
            $this->studentRecordInfo = null;

            return;
        }

        $studentId = $this->currentStudent->id;

        $studentRecord = StudentRecord::where('student_id', $studentId)
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->with(['academicYear', 'gradeLevel', 'section'])
            ->first();

        $this->studentGradeLevel = $studentRecord?->gradeLevel?->name ?? null;
        $this->studentRecordInfo = $studentRecord ? [
            'academic_year' => $studentRecord->academicYear->name ?? 'N/A',
            'grade_level' => $studentRecord->gradeLevel->name ?? 'N/A',
            'section' => $studentRecord->section->name ?? 'N/A',
        ] : null;

        $this->studentFiles = StudentGrade::where('student_id', $studentId)
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->get()
            ->toArray();

        $grouped = TermGrade::where('student_id', $studentId)
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->with('subject')
            ->get()
            ->groupBy('subject_id');

        $this->termGrades = $grouped->map(function ($group) {
            $first = $group->first();
            $grades = array_filter([
                $first->first_grading,
                $first->second_grading,
                $first->third_grading,
                $first->fourth_grading,
            ], fn ($v) => $v !== null && $v !== '');

            $final = $first->final_rating !== null && $first->final_rating !== ''
                ? $first->final_rating
                : (count($grades) > 0
                    ? round(array_sum($grades) / count($grades), 0)
                    : null);

            return [
                'subject_name' => $first->subject->subject_name ?? 'Unknown',
                'first_grading' => $first->first_grading,
                'second_grading' => $first->second_grading,
                'third_grading' => $first->third_grading,
                'fourth_grading' => $first->fourth_grading,
                'final_rating' => $final,
            ];
        })->values()->toArray();

        $enrollmentRecords = StudentRecord::where('student_id', $studentId)
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->get();
        $this->attendance = [];
        if ($enrollmentRecords->count() > 0) {
            $recordIds = $enrollmentRecords->pluck('id');
            $records = AttendanceRecord::whereIn('student_record_id', $recordIds)
                ->get()
                ->groupBy(fn ($r) => Carbon::parse($r->created_at)->format('Y-m'));

            $this->attendance = $records->map(function ($group, $ym) {
                $first = $group->first();
                $monthDate = Carbon::parse($first->created_at);
                $monthName = $monthDate->format('F');
                $year = $monthDate->format('Y');

                $schoolDays = $this->getSchoolDays($monthDate);
                $present = $group->count();
                $absent = max(0, $schoolDays - $present);
                $rate = $schoolDays > 0 ? round(($present / $schoolDays) * 100, 1) : 0;

                return [
                    'month' => $monthName,
                    'year' => $year,
                    'school_days' => $schoolDays,
                    'present' => $present,
                    'absent' => $absent,
                    'rate' => $rate,
                ];
            })->values()->toArray();
        }
    }

    public function exportGrades()
    {
        $this->ensureCurrentExportData();

        $rows = [
            ['Student Grades'],
            ['Student Name', $this->studentInfo['name'] ?? 'N/A'],
            ['LRN', $this->studentInfo['lrn'] ?? 'N/A'],
            ['Academic Year', $this->studentRecordInfo['academic_year'] ?? 'N/A'],
            ['Grade Level', $this->studentRecordInfo['grade_level'] ?? $this->studentGradeLevel ?? 'N/A'],
            ['Section', $this->studentRecordInfo['section'] ?? 'N/A'],
            [],
            ['Learning Area', '1st Grading', '2nd Grading', '3rd Grading', '4th Grading', 'Final Rating'],
        ];

        foreach ($this->termGrades as $row) {
            $rows[] = [
                $row['subject_name'] ?? '',
                $row['first_grading'] ?? '',
                $row['second_grading'] ?? '',
                $row['third_grading'] ?? '',
                $row['fourth_grading'] ?? '',
                $row['final_rating'] ?? '',
            ];
        }

        $finals = array_filter(array_column($this->termGrades, 'final_rating'), fn ($value) => $value !== null && $value !== '');
        $generalAverage = count($finals) > 0 ? round(array_sum($finals) / count($finals), 0) : '';
        $rows[] = [];
        $rows[] = ['General Average', '', '', '', '', $generalAverage];

        return $this->downloadCsv($this->exportFilename('student-grades'), $rows);
    }

    public function exportAttendance()
    {
        $this->ensureCurrentExportData();

        $rows = [
            ['Student Attendance'],
            ['Student Name', $this->studentInfo['name'] ?? 'N/A'],
            ['LRN', $this->studentInfo['lrn'] ?? 'N/A'],
            ['Academic Year', $this->studentRecordInfo['academic_year'] ?? 'N/A'],
            ['Grade Level', $this->studentRecordInfo['grade_level'] ?? $this->studentGradeLevel ?? 'N/A'],
            ['Section', $this->studentRecordInfo['section'] ?? 'N/A'],
            [],
            ['Month', 'School Days', 'Present', 'Absent', '% Attendance'],
        ];

        foreach ($this->attendance as $row) {
            $rows[] = [
                trim(($row['month'] ?? '').' '.($row['year'] ?? '')),
                $row['school_days'] ?? 0,
                $row['present'] ?? 0,
                $row['absent'] ?? 0,
                isset($row['rate']) ? $row['rate'].'%' : '0%',
            ];
        }

        $totalSchoolDays = array_sum(array_column($this->attendance, 'school_days'));
        $totalPresent = array_sum(array_column($this->attendance, 'present'));
        $totalAbsent = array_sum(array_column($this->attendance, 'absent'));
        $overallRate = $totalSchoolDays > 0 ? round(($totalPresent / $totalSchoolDays) * 100, 1) : 0;
        $rows[] = [];
        $rows[] = ['Overall', $totalSchoolDays, $totalPresent, $totalAbsent, $overallRate.'%'];

        return $this->downloadCsv($this->exportFilename('student-attendance'), $rows);
    }

    public function updatedSelectedAcademicYearId()
    {
        $this->loadData();
    }

    public function promoteStudent()
    {
        if (!$this->currentStudent || !$this->selected_academic_year_id) {
            sweetalert()->error('Please select a student and academic year first.');
            return;
        }

        $currentRecord = StudentRecord::where('student_id', $this->currentStudent->id)
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->first();

        if (!$currentRecord) {
            sweetalert()->error('No enrollment record found for this student in the selected academic year.');
            return;
        }

        $nextGradeLevel = GradeLevel::where('id', '>', $currentRecord->grade_level_id)
            ->orderBy('id')
            ->first();

        if (!$nextGradeLevel) {
            $this->currentStudent->status = 'Graduated';
            $this->currentStudent->save();
            sweetalert()->success('Student has been marked as Graduated!');
            $this->loadStudent();
            $this->loadData();
            return;
        }

        $currentAcademicYear = AcademicYear::find($this->selected_academic_year_id);

        $nextAcademicYear = AcademicYear::where('start_date', '>', $currentAcademicYear->start_date)
            ->orderBy('start_date')
            ->first();

        if (!$nextAcademicYear) {
            sweetalert()->error('No next academic year configured. Please create one first.');
            return;
        }

        $existingRecord = StudentRecord::where('student_id', $this->currentStudent->id)
            ->where('grade_level_id', $nextGradeLevel->id)
            ->where('academic_year_id', $nextAcademicYear->id)
            ->first();

        if ($existingRecord) {
            sweetalert()->error('Student already has a record for the next grade level and academic year.');
            return;
        }

        StudentRecord::create([
            'student_id' => $this->currentStudent->id,
            'grade_level_id' => $nextGradeLevel->id,
            'section_id' => null,
            'academic_year_id' => $nextAcademicYear->id,
            'is_active' => true,
        ]);

        $currentRecord->update(['is_active' => false]);

        sweetalert()->success('Student promoted to ' . $nextGradeLevel->name . ' for ' . $nextAcademicYear->name . '!');
        $this->loadData();
    }

    public function getCanPromoteProperty()
    {
        if (!$this->currentStudent || !$this->selected_academic_year_id) {
            return false;
        }

        if ($this->currentStudent->status === 'Graduated') {
            return false;
        }

        $currentRecord = StudentRecord::where('student_id', $this->currentStudent->id)
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->first();

        if (!$currentRecord) {
            return false;
        }

        $nextGradeLevel = GradeLevel::where('id', '>', $currentRecord->grade_level_id)
            ->orderBy('id')
            ->first();

        if (!$nextGradeLevel) {
            return true;
        }

        $currentAcademicYear = AcademicYear::find($this->selected_academic_year_id);

        $nextAcademicYear = AcademicYear::where('start_date', '>', $currentAcademicYear->start_date)
            ->orderBy('start_date')
            ->first();

        if (!$nextAcademicYear) {
            return false;
        }

        $existingRecord = StudentRecord::where('student_id', $this->currentStudent->id)
            ->where('grade_level_id', $nextGradeLevel->id)
            ->where('academic_year_id', $nextAcademicYear->id)
            ->exists();

        return !$existingRecord;
    }

    public function getIsPromotedProperty()
    {
        if (!$this->currentStudent || !$this->selected_academic_year_id) {
            return false;
        }

        $currentRecord = StudentRecord::where('student_id', $this->currentStudent->id)
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->first();

        if (!$currentRecord) {
            return false;
        }

        $currentAcademicYear = AcademicYear::find($this->selected_academic_year_id);

        $nextAcademicYear = AcademicYear::where('start_date', '>', $currentAcademicYear->start_date)
            ->orderBy('start_date')
            ->first();

        if (!$nextAcademicYear) {
            return false;
        }

        $nextGradeLevel = GradeLevel::where('id', '>', $currentRecord->grade_level_id)
            ->orderBy('id')
            ->first();

        if (!$nextGradeLevel) {
            return StudentRecord::where('student_id', $this->currentStudent->id)
                ->where('academic_year_id', $nextAcademicYear->id)
                ->exists();
        }

        return StudentRecord::where('student_id', $this->currentStudent->id)
            ->where('grade_level_id', $nextGradeLevel->id)
            ->where('academic_year_id', $nextAcademicYear->id)
            ->exists();
    }

    private function getSchoolDays(Carbon $date)
    {
        $start = $date->copy()->startOfMonth();
        $end = $date->copy()->endOfMonth();
        $days = 0;
        $current = $start->copy();
        while ($current <= $end) {
            if (! $current->isWeekend()) {
                $days++;
            }
            $current->addDay();
        }

        return $days;
    }

    private function ensureCurrentExportData()
    {
        if (! $this->currentStudent && $this->selectedStudentId) {
            $this->loadStudent();
        }

        $this->loadData();
    }

    private function exportFilename(string $prefix): string
    {
        $studentName = $this->studentInfo['name'] ?? 'student';
        $safeName = str($studentName)->lower()->replaceMatches('/[^a-z0-9]+/', '-')->trim('-');

        return $prefix.'-'.$safeName.'.csv';
    }

    private function downloadCsv(string $filename, array $rows)
    {
        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');

            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function render()
    {
        $students = Student::with('user')
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->firstname.' '.$student->lastname,
                    'lrn' => $student->lrn ?? 'N/A',
                ];
            });

        return view('livewire.admin.view-student-grade', [
            'academic_years' => AcademicYear::orderByDesc('is_active')->orderBy('name', 'desc')->get(),
            'students' => $students,
        ])->layout('components.admin-layout');
    }
}

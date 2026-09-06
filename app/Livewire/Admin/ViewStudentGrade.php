<?php

namespace App\Livewire\Admin;

use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\Student;
use App\Models\StudentGrade;
use App\Models\StudentRecord;
use App\Models\TermGrade;
use App\Models\User;
use Livewire\Component;

class ViewStudentGrade extends Component
{
    public $studentFiles = [];

    public $termGrades = [];

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
        $this->currentStudent = null;
        $this->studentInfo = null;

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
                'final_rating' => $final,
                'remarks' => $first->remarks,
            ];
        })->values()->toArray();
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
            ['Learning Area', '1st Term', '2nd Term', '3rd Term', 'Final Average', 'Remarks'],
        ];

        foreach ($this->termGrades as $row) {
            $rows[] = [
                $row['subject_name'] ?? '',
                $row['first_grading'] ?? '',
                $row['second_grading'] ?? '',
                $row['third_grading'] ?? '',
                $row['final_rating'] ?? '',
                $row['remarks'] ?? '',
            ];
        }

        $finals = array_filter(array_column($this->termGrades, 'final_rating'), fn ($value) => $value !== null && $value !== '');
        $generalAverage = count($finals) > 0 ? round(array_sum($finals) / count($finals), 0) : '';
        $rows[] = [];
        $rows[] = ['General Average', '', '', '', $generalAverage, ''];

        return $this->downloadCsv($this->exportFilename('student-grades'), $rows);
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
        return view('livewire.admin.view-student-grade')->layout('components.admin-layout');
    }
}

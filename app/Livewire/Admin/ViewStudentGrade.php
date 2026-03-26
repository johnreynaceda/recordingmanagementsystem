<?php

namespace App\Livewire\Admin;

use App\Models\AcademicYear;
use App\Models\AttendanceRecord;
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

            return;
        }

        $studentId = $this->currentStudent->id;

        $studentRecord = StudentRecord::where('student_id', $studentId)
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->with('gradeLevel')
            ->first();

        $this->studentGradeLevel = $studentRecord?->gradeLevel?->name ?? null;

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

            $final = count($grades) > 0
                ? round(array_sum($grades) / count($grades), 0)
                : null;

            return [
                'subject_name' => $first->subject->subject_name ?? 'Unknown',
                'first_grading' => $first->first_grading,
                'second_grading' => $first->second_grading,
                'third_grading' => $first->third_grading,
                'fourth_grading' => $first->fourth_grading,
                'final_rating' => $final,
            ];
        })->values()->toArray();

        $enrollmentRecord = StudentRecord::where('student_id', $studentId)
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->first();
        $this->attendance = [];
        if ($enrollmentRecord) {
            $records = AttendanceRecord::where('student_record_id', $enrollmentRecord->id)
                ->where('academic_year_id', $this->selected_academic_year_id)
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

    public function updatedSelectedAcademicYearId()
    {
        $this->loadData();
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

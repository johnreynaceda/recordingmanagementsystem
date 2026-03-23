<?php
namespace App\Livewire\Student;

use App\Models\AcademicYear;
use App\Models\AttendanceRecord;
use App\Models\StudentGrade;
use App\Models\StudentRecord;
use App\Models\TermGrade;
use Carbon\Carbon;
use Livewire\Component;

class MyGrade extends Component
{
    public $studentFiles = [];
    public $termGrades = [];
    public $attendance = [];
    public $selected_academic_year_id;
    public $studentGradeLevel = null;

    public function download($fileId)
    {
        $file = StudentGrade::findOrFail($fileId);
        $path = storage_path('app/public/' . $file->file_path);

        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }

        return response()->download($path, basename($path));
    }

    public function mount()
    {
        $this->selected_academic_year_id = AcademicYear::getActiveYearId();
        $this->loadData();
    }

    public function loadData()
    {
        $student = auth()->user()->student;

        // Get student's grade level for the selected academic year
        $studentRecord = StudentRecord::where('student_id', $student->id)
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->with('gradeLevel')
            ->first();
        
        $this->studentGradeLevel = $studentRecord?->gradeLevel?->name ?? null;

        // Uploaded grade files
        $this->studentFiles = StudentGrade::where('student_id', $student->id)
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->get()
            ->toArray();

        // TermGrades: convert to plain array grouped by subject so Livewire can serialize
        $grouped = TermGrade::where('student_id', $student->id)
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
            ], fn($v) => $v !== null && $v !== '');

            $final = count($grades) > 0
                ? round(array_sum($grades) / count($grades), 0)
                : null;

            return [
                'subject_name'    => $first->subject->subject_name ?? 'Unknown',
                'first_grading'   => $first->first_grading,
                'second_grading'  => $first->second_grading,
                'third_grading'   => $first->third_grading,
                'fourth_grading'  => $first->fourth_grading,
                'final_rating'    => $final,
            ];
        })->values()->toArray();

        // Attendance: monthly summary
        $enrollmentRecord = StudentRecord::where('student_id', $student->id)
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->first();
        $this->attendance = [];
        if ($enrollmentRecord) {
            $records = AttendanceRecord::where('student_record_id', $enrollmentRecord->id)
                ->where('academic_year_id', $this->selected_academic_year_id)
                ->get()
                ->groupBy(fn($r) => Carbon::parse($r->created_at)->format('Y-m'));

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
                    'month'       => $monthName,
                    'year'        => $year,
                    'school_days' => $schoolDays,
                    'present'     => $present,
                    'absent'      => $absent,
                    'rate'        => $rate,
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
            if (!$current->isWeekend()) {
                $days++;
            }
            $current->addDay();
        }
        return $days;
    }

    public function render()
    {
        return view('livewire.student.my-grade', [
            'academic_years' => AcademicYear::orderByDesc('is_active')->orderBy('name', 'desc')->get(),
        ])->layout('components.student-layout');
    }
}

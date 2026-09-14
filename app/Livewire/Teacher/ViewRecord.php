<?php

namespace App\Livewire\Teacher;

use App\Models\AcademicYear;
use App\Models\Section;
use App\Models\StudentRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ViewRecord extends Component
{
    public $date;

    public $section_id;

    public $selected_academic_year_id;

    public function mount(): void
    {
        $this->selected_academic_year_id = AcademicYear::getActiveYearId();
        $this->date = now()->toDateString();
    }

    public function render(): View
    {
        $sections = Section::where('staff_id', auth()->user()->staff->id)
            ->forAcademicYear($this->selected_academic_year_id)
            ->orderBy('name')
            ->get();

        $studentRecords = collect();

        if (filled($this->section_id) && filled($this->selected_academic_year_id)) {
            $studentRecords = StudentRecord::query()
                ->with([
                    'student',
                    'attendanceRecords' => fn ($query) => $query
                        ->when($this->date, fn ($query) => $query->whereDate('created_at', $this->date))
                        ->oldest('created_at'),
                ])
                ->join('students', 'students.id', '=', 'student_records.student_id')
                ->where('student_records.section_id', $this->section_id)
                ->where('student_records.academic_year_id', $this->selected_academic_year_id)
                ->whereHas('section', function (Builder $query) {
                    $query->where('staff_id', auth()->user()->staff->id);
                })
                ->where(function (Builder $query) {
                    $query->whereNull('students.status')
                        ->orWhere('students.status', '!=', 'Rejected');
                })
                ->orderBy('students.lastname')
                ->orderBy('students.firstname')
                ->select('student_records.*')
                ->get();
        }

        return view('livewire.teacher.view-record', [
            'sections' => $sections,
            'academic_years' => AcademicYear::orderByDesc('is_active')->orderBy('name', 'desc')->get(),
            'student_records' => $studentRecords,
        ]);
    }
}

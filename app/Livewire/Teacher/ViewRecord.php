<?php

namespace App\Livewire\Teacher;

use App\Models\AcademicYear;
use App\Models\AttendanceRecord;
use App\Models\Section;
use Livewire\Component;

class ViewRecord extends Component
{
    public $date, $section_id;
    public $selected_academic_year_id;

    public function mount()
    {
        $this->selected_academic_year_id = AcademicYear::getActiveYearId();
    }

    public function render()
    {
        $query = AttendanceRecord::query()
            ->where('academic_year_id', $this->selected_academic_year_id);

        if ($this->date) {
            $query->whereDate('created_at', $this->date);
        }

        if ($this->section_id) {
            $query->whereHas('studentRecord', function($student) {
                $student->where('section_id', $this->section_id);
            });
        }

        return view('livewire.teacher.view-record',[
           'sections' => Section::where('staff_id', auth()->user()->staff->id)->get(),
           'academic_years' => AcademicYear::orderByDesc('is_active')->orderBy('name', 'desc')->get(),
           'attendances' => $query->get(),
        ]);
    }
}

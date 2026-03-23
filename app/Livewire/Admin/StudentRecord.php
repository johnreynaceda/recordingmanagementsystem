<?php

namespace App\Livewire\Admin;

use App\Models\AcademicYear;
use App\Models\Student;
use Livewire\Component;

class StudentRecord extends Component
{
    public $student_id;
    public $selected_academic_year_id;

    public function mount(){
        $this->student_id = request('id');
        $this->selected_academic_year_id = AcademicYear::getActiveYearId();
    }

    public function render()
    {
        $query = \App\Models\StudentRecord::where('student_id', $this->student_id);
        
        if ($this->selected_academic_year_id) {
            $query->where('academic_year_id', $this->selected_academic_year_id);
        }

        return view('livewire.admin.student-record',[
            'student' => Student::where('id', $this->student_id)->first(),
            'student_records' => $query->get(),
            'academic_years' => AcademicYear::orderByDesc('is_active')->orderBy('name', 'desc')->get(),
        ]);
    }
}

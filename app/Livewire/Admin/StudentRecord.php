<?php

namespace App\Livewire\Admin;

use App\Models\Student;
use Livewire\Component;

class StudentRecord extends Component
{
    public $student_id;

    public function mount(){
        $this->student_id = request('id');
    }
    public function render()
    {
        return view('livewire.admin.student-record',[
            'student' => Student::where('id', $this->student_id)->first(),
            'student_records' => \App\Models\StudentRecord::where('student_id', $this->student_id)->get(),
        ]);
    }
}

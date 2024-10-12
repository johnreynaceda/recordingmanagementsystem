<?php

namespace App\Livewire\Student;

use App\Models\Student;
use Livewire\Component;

class Profile extends Component
{
    public $student;
    public $section;
    public $gradeLevel;

    public function mount()
    {

        $this->student = Student::with(['studentRecords.section', 'studentRecords.gradeLevel'])
            ->where('user_id', auth()->id())
            ->first();

        $latestRecord = $this->student->studentRecords->last();


        if ($latestRecord) {
            $this->section = $latestRecord->section->name ?? 'N/A';
            $this->gradeLevel = $latestRecord->gradeLevel->name ?? 'N/A';
        } else {
            $this->section = 'N/A';
            $this->gradeLevel = 'N/A';
        }
    }

    public function render()
    {
        return view('livewire.student.profile', [
            'student' => $this->student,
            'section' => $this->section,
            'gradeLevel' => $this->gradeLevel,
        ]);
    }
}

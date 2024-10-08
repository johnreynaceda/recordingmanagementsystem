<?php

namespace App\Livewire\Student;

use App\Models\Student;
use Livewire\Component;

class Profile extends Component
{
    public $student;
    public function mount()
    {
        $this->student = Student::with(['section', 'gradeLevel'])
            ->where('user_id', auth()->id())
            ->select('firstname', 'middlename', 'lastname', 'birthdate', 'address', 'image_path', 'section_id', 'grade_level_id') // Include foreign keys for relationships
            ->first();
    }

    public function render()
    {
        return view('livewire.student.profile', [
            'student' => $this->student,
        ]);
    }
}

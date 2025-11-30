<?php
namespace App\Livewire\Student;

use App\Models\StudentGrade;
use Livewire\Component;

class MyGrade extends Component
{
    public $grade;

 public function download($fileId)
{
    $file = StudentGrade::findOrFail($fileId);

    // Make sure the path is absolute
    $path = storage_path('app/public/' . $file->file_path);

    if (!file_exists($path)) {
        abort(404, 'File not found.');
    }

    return response()->download($path, basename($path));
}

    public function mount()
    {
        $this->grade = auth()->user()->student->studentGrades;
    }
    public function render()
    {
        return view('livewire.student.my-grade')->layout('components.student-layout');
    }
}

<?php

namespace App\Livewire\Student;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Profile extends Component
{
    use WithFileUploads;

    public $student;
    public $section;
    public $gradeLevel;

    public $isEditing = false;

    // Editable fields
    public $firstname;
    public $middlename;
    public $lastname;
    public $contact_number;
    public $birthdate;
    public $address;
    
    public $new_image;

    public function mount()
    {
        $this->loadStudentData();
    }

    public function loadStudentData()
    {
        /** @var \App\Models\Student|null $student */
        $student = Student::with(['studentRecords.section', 'studentRecords.gradeLevel'])
            ->where('user_id', auth()->id())
            ->first();

        $this->student = $student;

        $latestRecord = $student ? $student->studentRecords->last() : null;

        if ($latestRecord) {
            $this->section = $latestRecord->section->name ?? 'N/A';
            $this->gradeLevel = $latestRecord->gradeLevel->name ?? 'N/A';
        } else {
            $this->section = 'N/A';
            $this->gradeLevel = 'N/A';
        }
    }

    public function edit()
    {
        /** @var \App\Models\Student|null $student */
        $student = $this->student;
        if (!$student) return;
        
        $this->isEditing = true;
        $this->firstname = $student->firstname;
        $this->middlename = $student->middlename;
        $this->lastname = $student->lastname;
        $this->contact_number = $student->contact_number;
        $this->birthdate = $student->birthdate;
        $this->address = $student->address;
        $this->new_image = null;
    }

    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->new_image = null;
    }

    public function save()
    {
        /** @var \App\Models\Student|null $student */
        $student = $this->student;
        if (!$student) return;

        $this->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'birthdate' => 'required|date',
            'address' => 'required|string|max:500',
            'new_image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        if ($this->new_image) {
            if ($student->image_path) {
                Storage::disk('public')->delete($student->image_path);
            }
            /** @var \Illuminate\Http\UploadedFile $image */
            $image = $this->new_image;
            $imagePath = $image->store('students/profiles', 'public');
            $student->image_path = $imagePath;
            $student->save();
        }

        $student->update([
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'contact_number' => $this->contact_number,
            'birthdate' => $this->birthdate,
            'address' => $this->address,
        ]);

        $this->loadStudentData();
        $this->isEditing = false;
        $this->new_image = null;

        session()->flash('success', 'Profile updated successfully.');
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

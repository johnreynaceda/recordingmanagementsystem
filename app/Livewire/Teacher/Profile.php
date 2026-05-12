<?php

namespace App\Livewire\Teacher;

use App\Models\AcademicYear;
use App\Models\GradeLevelSubject;
use App\Models\Staff;
use App\Models\StudentRecord;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Profile extends Component
{
    use WireUiActions;

    public $record;
    public $firstname;
    public $lastname;
    public $address;
    public $showModal = false;
    public $assignedSections = [];
    public $assignedSubjects = [];
    public $activeAcademicYearName;

    public function mount()
    {
        $activeAcademicYearId = AcademicYear::getActiveYearId();
        $this->activeAcademicYearName = AcademicYear::whereKey($activeAcademicYearId)->value('name');

        $this->record = Staff::where('user_id', auth()->user()->id)
            ->with(['sections.gradeLevel'])
            ->first();

        if ($this->record) {
            $this->firstname = $this->record->firstname;
            $this->lastname = $this->record->lastname;
            $this->address = $this->record->address;

            $activeSectionIds = StudentRecord::query()
                ->where('academic_year_id', $activeAcademicYearId)
                ->whereIn('section_id', $this->record->sections->pluck('id'))
                ->pluck('section_id')
                ->unique();

            $this->assignedSections = $this->record->sections
                ->whereIn('id', $activeSectionIds)
                ->values();

            $this->assignedSubjects = GradeLevelSubject::query()
                ->where('teacher_id', $this->record->id)
                ->with(['academicYear', 'gradeLevel'])
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.teacher.profile');
    }

    public function update()
    {
        $this->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);


        $this->record->update([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'address' => $this->address,
        ]);


        session()->flash('message', 'Profile updated successfully.');

        $this->showModal = false;
    }
}

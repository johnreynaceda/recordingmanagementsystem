<?php

namespace App\Livewire\Teacher;

use App\Models\Staff;
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

    public function mount()
    {
        // Fetch teacher record with their sections and associated grade limits
        $this->record = Staff::where('user_id', auth()->user()->id)
            ->with(['sections.gradeLevel'])
            ->first();

        if ($this->record) {
            $this->firstname = $this->record->firstname;
            $this->lastname = $this->record->lastname;
            $this->address = $this->record->address;

            $this->assignedSections = $this->record->sections;
            $grade_levels = $this->assignedSections->pluck('grade_level_id')->unique()->toArray();
            
            // Get detailed subject rows
            $this->assignedSubjects = \App\Models\GradeLevelSubject::whereIn('grade_level_id', $grade_levels)->get();
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

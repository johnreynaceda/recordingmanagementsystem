<?php

namespace App\Livewire\Teacher;

use App\Models\AcademicYear;
use App\Models\GradeLevelSubject;
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

    public $activeAcademicYearName;

    public $assignmentGroups = [];

    public function mount()
    {
        $activeAcademicYearId = AcademicYear::getActiveYearId();
        $this->activeAcademicYearName = AcademicYear::whereKey($activeAcademicYearId)->value('name');

        $this->record = Staff::where('user_id', auth()->user()->id)
            ->first();

        if ($this->record) {
            $this->firstname = $this->record->firstname;
            $this->lastname = $this->record->lastname;
            $this->address = $this->record->address;

            $this->loadAssignments($activeAcademicYearId);
        }
    }

    private function loadAssignments(?int $academicYearId): void
    {
        if (! $academicYearId || ! $this->record) {
            $this->assignedSections = [];
            $this->assignedSubjects = [];
            $this->assignmentGroups = [];

            return;
        }

        $sections = $this->record->sections()
            ->where('academic_year_id', $academicYearId)
            ->with('gradeLevel')
            ->orderBy('name')
            ->get();

        $subjects = GradeLevelSubject::query()
            ->where('teacher_id', $this->record->id)
            ->where('academic_year_id', $academicYearId)
            ->with('gradeLevel')
            ->orderBy('subject_name')
            ->get();

        $this->assignedSections = $sections->map(fn ($section) => [
            'id' => $section->id,
            'name' => $section->name ?: 'Unnamed section',
            'grade_level_id' => $section->grade_level_id,
            'grade_level_name' => $section->gradeLevel?->name ?: 'Unspecified grade level',
        ])->all();

        $this->assignedSubjects = $subjects->map(fn ($subject) => [
            'id' => $subject->id,
            'name' => $subject->subject_name ?: 'Unnamed subject',
            'grade_level_id' => $subject->grade_level_id,
            'grade_level_name' => $subject->gradeLevel?->name ?: 'Unspecified grade level',
        ])->all();

        $groups = [];

        foreach ($this->assignedSections as $section) {
            $key = (string) ($section['grade_level_id'] ?? 'unassigned');
            $groups[$key] ??= [
                'id' => $section['grade_level_id'],
                'name' => $section['grade_level_name'],
                'sections' => [],
                'subjects' => [],
            ];
            $groups[$key]['sections'][] = $section;
        }

        foreach ($this->assignedSubjects as $subject) {
            $key = (string) ($subject['grade_level_id'] ?? 'unassigned');
            $groups[$key] ??= [
                'id' => $subject['grade_level_id'],
                'name' => $subject['grade_level_name'],
                'sections' => [],
                'subjects' => [],
            ];
            $groups[$key]['subjects'][] = $subject;
        }

        $this->assignmentGroups = collect($groups)
            ->sort(fn (array $first, array $second) => strnatcasecmp($first['name'], $second['name']))
            ->values()
            ->all();
    }

    public function render()
    {
        return view('livewire.teacher.profile');
    }

    public function openEditModal(): void
    {
        if (! $this->record) {
            return;
        }

        $this->resetValidation();
        $this->firstname = $this->record->firstname;
        $this->lastname = $this->record->lastname;
        $this->address = $this->record->address;
        $this->showModal = true;
    }

    public function cancelEdit(): void
    {
        $this->resetValidation();
        $this->showModal = false;
    }

    public function update()
    {
        if (! $this->record) {
            return;
        }

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

        $this->record->refresh();

        sweetalert()->success('Profile updated successfully!');
        session()->flash('message', 'Profile updated successfully.');

        $this->showModal = false;
    }
}

<?php

namespace App\Livewire\Teacher;

use App\Models\AcademicYear;
use App\Models\GradeLevelSubject;
use App\Models\StudentRecord;
use App\Models\TermGrade;
use Livewire\Component;

class Grading extends Component
{
    public $selected_section_id = null;
    public $selected_subject_id = null;
    public $selected_academic_year_id;
    public $termGrades = [];

    public function mount()
    {
        $this->selected_academic_year_id = AcademicYear::getActiveYearId();
    }

    public function getSectionsProperty()
    {
        return auth()->user()->staff->sections()
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->get();
    }

    public function getSubjectsProperty()
    {
        if (!$this->selected_section_id) {
            return collect();
        }

        $staff = auth()->user()->staff;

        $section = \App\Models\Section::find($this->selected_section_id);
        if (!$section) return collect();

        return GradeLevelSubject::where('grade_level_id', $section->grade_level_id)
            ->where('teacher_id', $staff->id)
            ->get();
    }

    public function getStudentsProperty()
    {
        if (!$this->selected_section_id || !$this->selected_subject_id) {
            return [];
        }
        return StudentRecord::with(['student', 'section'])
            ->where('section_id', $this->selected_section_id)
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->get();
    }

    public function updatedSelectedSectionId($value)
    {
        $this->selected_subject_id = null;
        $this->termGrades = [];
    }

    public function updatedSelectedSubjectId($value)
    {
        $this->termGrades = [];
        if ($value && $this->selected_section_id) {
            $grades = TermGrade::where('section_id', $this->selected_section_id)
                ->where('subject_id', $value)
                ->where('academic_year_id', $this->selected_academic_year_id)
                ->get();
            foreach ($grades as $grade) {
                $this->termGrades[$grade->student_id] = [
                    'first_grading'   => $grade->first_grading,
                    'second_grading'  => $grade->second_grading,
                    'third_grading'   => $grade->third_grading,
                    'fourth_grading'  => $grade->fourth_grading,
                    'remarks'         => $grade->remarks,
                ];
            }
        }
    }

    public function saveGrades()
    {
        if (!$this->selected_section_id || !$this->selected_subject_id) {
            return;
        }

        $activeYearId = AcademicYear::getActiveYearId();

        foreach ($this->termGrades as $studentId => $data) {
            if (isset($data['first_grading']) || isset($data['second_grading']) || isset($data['third_grading']) || isset($data['fourth_grading']) || isset($data['remarks'])) {
                TermGrade::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'section_id' => $this->selected_section_id,
                        'subject_id' => $this->selected_subject_id,
                        'academic_year_id' => $activeYearId,
                    ],
                    [
                        'first_grading'  => $data['first_grading'] ?? null,
                        'second_grading' => $data['second_grading'] ?? null,
                        'third_grading'  => $data['third_grading'] ?? null,
                        'fourth_grading' => $data['fourth_grading'] ?? null,
                        'remarks'        => $data['remarks'] ?? null,
                        'academic_year_id' => $activeYearId,
                    ]
                );
            }
        }

        session()->flash('success', 'Grades have been saved successfully.');
    }

    public function render()
    {
        return view('livewire.teacher.grading', [
            'sections' => $this->sections,
            'subjects' => $this->subjects,
            'students' => $this->students,
            'academic_years' => AcademicYear::orderByDesc('is_active')->orderBy('name', 'desc')->get(),
        ]);
    }
}

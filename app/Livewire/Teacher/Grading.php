<?php

namespace App\Livewire\Teacher;

use App\Models\AcademicYear;
use App\Models\GradeLevelSubject;
use App\Models\StudentRecord;
use App\Models\TermGrade;
use Livewire\Component;
use Livewire\WithFileUploads;

class Grading extends Component
{
    use WithFileUploads;

    public $selected_section_id = null;
    public $selected_subject_id = null;
    public $selected_academic_year_id;
    public $termGrades = [];
    public $gradeFile = null;

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
                TermGrade::where('student_id', $studentId)
                    ->where('section_id', $this->selected_section_id)
                    ->where('subject_id', $this->selected_subject_id)
                    ->where('academic_year_id', $activeYearId)
                    ->delete();

                TermGrade::create([
                    'student_id' => $studentId,
                    'section_id' => $this->selected_section_id,
                    'subject_id' => $this->selected_subject_id,
                    'academic_year_id' => $activeYearId,
                    'first_grading'  => $data['first_grading'] ?? null,
                    'second_grading' => $data['second_grading'] ?? null,
                    'third_grading'  => $data['third_grading'] ?? null,
                    'fourth_grading' => $data['fourth_grading'] ?? null,
                    'remarks'        => $data['remarks'] ?? null,
                ]);
            }
        }

        sweetalert()->success('Grades have been saved successfully!');
    }

    public function exportExcel()
    {
        if (!$this->selected_section_id || !$this->selected_subject_id) {
            return;
        }

        $subject = $this->subjects->firstWhere('id', $this->selected_subject_id);
        $section = $this->sections->firstWhere('id', $this->selected_section_id);
        
        $sectionName = $section ? $section->name : 'Section';
        $subjectName = $subject ? $subject->subject_name : 'Subject';

        $fileName = 'Grades_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $sectionName) . '_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $subjectName) . '.csv';

        $students = $this->students;
        $termGrades = $this->termGrades;

        return response()->streamDownload(function () use ($students, $termGrades) {
            $file = fopen('php://output', 'w');
            
            $columns = ['#', 'Name', 'Student LRN', '1st Grading', '2nd Grading', '3rd Grading', '4th Grading', 'Remarks'];
            fputcsv($file, $columns);
            
            foreach ($students as $index => $record) {
                $studentId = $record->student_id;
                $gradeData = $termGrades[$studentId] ?? [];
                
                $row = [
                    $index + 1,
                    strtoupper($record->student->lastname) . ' , ' . strtoupper($record->student->firstname) . ' ' . strtoupper($record->student->middlename),
                    $record->student->lrn ?? 'N/A',
                    $gradeData['first_grading'] ?? '',
                    $gradeData['second_grading'] ?? '',
                    $gradeData['third_grading'] ?? '',
                    $gradeData['fourth_grading'] ?? '',
                    $gradeData['remarks'] ?? '',
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        }, $fileName);
    }

    public function updatedGradeFile()
    {
        if (!$this->gradeFile) {
            return;
        }

        $path = $this->gradeFile->getRealPath();
        if (($file = fopen($path, 'r')) !== false) {
            $header = fgetcsv($file); // Skip header

            $lrnMap = [];
            $nameMap = [];
            foreach ($this->students as $record) {
                if ($record->student) {
                    if ($record->student->lrn && $record->student->lrn !== 'N/A') {
                        $lrnMap[$record->student->lrn] = $record->student_id;
                    }
                    $name = strtoupper($record->student->lastname) . ' , ' . strtoupper($record->student->firstname) . ' ' . strtoupper($record->student->middlename);
                    $nameMap[$name] = $record->student_id;
                }
            }

            while (($row = fgetcsv($file)) !== false) {
                if (count($row) >= 8) {
                    $name = $row[1];
                    $lrn = $row[2];
                    
                    $studentId = null;
                    if ($lrn && $lrn !== 'N/A' && isset($lrnMap[$lrn])) {
                        $studentId = $lrnMap[$lrn];
                    } elseif (isset($nameMap[$name])) {
                        $studentId = $nameMap[$name];
                    }

                    if ($studentId) {
                        $this->termGrades[$studentId] = [
                            'first_grading' => $row[3] !== '' ? $row[3] : null,
                            'second_grading' => $row[4] !== '' ? $row[4] : null,
                            'third_grading' => $row[5] !== '' ? $row[5] : null,
                            'fourth_grading' => $row[6] !== '' ? $row[6] : null,
                            'remarks' => $row[7] !== '' ? $row[7] : null,
                        ];
                    }
                }
            }
            fclose($file);
        }

        $this->gradeFile = null;
        sweetalert()->success('Grades imported from file. Please review and click "Save Grades" to apply changes.');
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

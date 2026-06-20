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

    public function updatedSelectedAcademicYearId($value)
    {
        $this->selected_academic_year_id = AcademicYear::where('id', $value)->first()->id;
    }

    public function getSectionsProperty()
    {
        return auth()->user()->staff->sections()
            ->get();
    }

    public function getSubjectsProperty()
    {
        if (!$this->selected_section_id) {
            return collect();
        }

        $section = \App\Models\Section::find($this->selected_section_id);
        if (!$section) return collect();

        return GradeLevelSubject::where('grade_level_id', $section->grade_level_id)
            ->get();
    }

    public function getStudentsProperty()
    {
        if (!$this->selected_section_id || !$this->selected_subject_id) {
            return [];
        }
        return StudentRecord::with(['student', 'section'])
            ->join('students', 'students.id', '=', 'student_records.student_id')
            ->where('student_records.section_id', $this->selected_section_id)
            ->where('student_records.academic_year_id', $this->selected_academic_year_id)
            ->orderBy('students.lastname', 'asc')
            ->select('student_records.*')
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
                    'final_rating'    => $this->calculateFinalAverage([
                        'first_grading' => $grade->first_grading,
                        'second_grading' => $grade->second_grading,
                        'third_grading' => $grade->third_grading,
                    ]),
                    'remarks'         => $grade->remarks,
                ];
            }
        }
    }

    public function saveGrades()
    {
        if (!$this->selected_section_id || !$this->selected_subject_id || !$this->selected_academic_year_id) {
            return;
        }

        $academicYearId = $this->selected_academic_year_id;

        foreach ($this->termGrades as $studentId => $data) {
            if (isset($data['first_grading']) || isset($data['second_grading']) || isset($data['third_grading']) || isset($data['remarks'])) {
                $finalAverage = $this->calculateFinalAverage($data);

                TermGrade::where('student_id', $studentId)
                    ->where('section_id', $this->selected_section_id)
                    ->where('subject_id', $this->selected_subject_id)
                    ->where('academic_year_id', $academicYearId)
                    ->delete();

                TermGrade::create([
                    'student_id' => $studentId,
                    'section_id' => $this->selected_section_id,
                    'subject_id' => $this->selected_subject_id,
                    'academic_year_id' => $academicYearId,
                    'first_grading'  => $data['first_grading'] ?? null,
                    'second_grading' => $data['second_grading'] ?? null,
                    'third_grading'  => $data['third_grading'] ?? null,
                    'fourth_grading' => null,
                    'final_rating'   => $finalAverage,
                    'remarks'        => $data['remarks'] ?? null,
                ]);

                $this->termGrades[$studentId]['final_rating'] = $finalAverage;
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

            $columns = ['#', 'Name', 'Student LRN', '1st Term', '2nd Term', '3rd Term', 'Final Average', 'Remarks'];
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
                    $this->calculateFinalAverage($gradeData) ?? '',
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
            $remarksIndex = count($header ?? []) >= 9 ? 8 : 7;

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
                if (count($row) >= 6) {
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
                            'final_rating' => $this->calculateFinalAverage([
                                'first_grading' => $row[3] !== '' ? $row[3] : null,
                                'second_grading' => $row[4] !== '' ? $row[4] : null,
                                'third_grading' => $row[5] !== '' ? $row[5] : null,
                            ]),
                            'remarks' => isset($row[$remarksIndex]) && $row[$remarksIndex] !== ''
                                ? $row[$remarksIndex]
                                : null,
                        ];
                    }
                }
            }
            fclose($file);
        }

        $this->gradeFile = null;
        sweetalert()->success('Grades imported from file. Please review and click "Save Grades" to apply changes.');
    }

    public function calculateFinalAverage(array $data): ?int
    {
        $grades = array_filter([
            $data['first_grading'] ?? null,
            $data['second_grading'] ?? null,
            $data['third_grading'] ?? null,
        ], fn($value) => is_numeric($value));

        if (count($grades) === 0) {
            return null;
        }

        return (int) round(array_sum($grades) / count($grades), 0);
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

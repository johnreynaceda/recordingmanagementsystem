<?php

namespace App\Livewire\Admin;

use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentRecord as StudentRecordModel;
use App\Models\TermGrade;
use Livewire\Component;

class StudentRecord extends Component
{
    public $student_id;
    public $selected_academic_year_id;

    public $edit_record_id = null;
    public $edit_grade_level_id = null;
    public $edit_section_id = null;

    public $currentStudent = null;

    public $showPromoteModal = false;
    public $promote_section_id = null;

    protected $rules = [
        'edit_grade_level_id' => 'required|exists:grade_levels,id',
        'edit_section_id' => 'nullable|exists:sections,id',
        'promote_section_id' => 'nullable|exists:sections,id',
    ];

    public function mount()
    {
        $this->student_id = request('id');
        $this->selected_academic_year_id = AcademicYear::getActiveYearId();
    }

    public function promoteStudent()
    {
        $student = Student::find($this->student_id);
        if (!$student || !$this->selected_academic_year_id) {
            sweetalert()->error('Please select an academic year first.');
            return;
        }

        $currentRecord = StudentRecordModel::where('student_id', $student->id)
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->first();

        if (!$currentRecord) {
            sweetalert()->error('No enrollment record found for this student in the selected academic year.');
            return;
        }

        $nextGradeLevel = GradeLevel::where('id', '>', $currentRecord->grade_level_id)
            ->orderBy('id')
            ->first();

        if (!$nextGradeLevel) {
            $student->status = 'Graduated';
            $student->save();
            sweetalert()->success('Student has been marked as Graduated!');
            return;
        }

        $currentAcademicYear = AcademicYear::find($this->selected_academic_year_id);

        $nextAcademicYear = AcademicYear::where('start_date', '>', $currentAcademicYear->start_date)
            ->orderBy('start_date')
            ->first();

        if (!$nextAcademicYear) {
            sweetalert()->error('No next academic year configured. Please create one first.');
            return;
        }

        $existingRecord = StudentRecordModel::where('student_id', $student->id)
            ->where('grade_level_id', $nextGradeLevel->id)
            ->where('academic_year_id', $nextAcademicYear->id)
            ->exists();

        if ($existingRecord) {
            sweetalert()->error('Student already has a record for the next grade level and academic year.');
            return;
        }

        $this->promote_section_id = null;
        $this->showPromoteModal = true;
    }

    public function confirmPromote()
    {
        $student = Student::find($this->student_id);
        if (!$student || !$this->selected_academic_year_id) {
            return;
        }

        $currentRecord = StudentRecordModel::where('student_id', $student->id)
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->first();

        if (!$currentRecord) {
            return;
        }

        $nextGradeLevel = GradeLevel::where('id', '>', $currentRecord->grade_level_id)
            ->orderBy('id')
            ->first();

        $currentAcademicYear = AcademicYear::find($this->selected_academic_year_id);
        $nextAcademicYear = AcademicYear::where('start_date', '>', $currentAcademicYear->start_date)
            ->orderBy('start_date')
            ->first();

        StudentRecordModel::create([
            'student_id' => $student->id,
            'grade_level_id' => $nextGradeLevel->id,
            'section_id' => $this->promote_section_id ?: null,
            'academic_year_id' => $nextAcademicYear->id,
            'is_active' => true,
        ]);

        $currentRecord->update(['is_active' => false]);

        $this->showPromoteModal = false;
        $this->promote_section_id = null;

        sweetalert()->success('Student promoted to ' . $nextGradeLevel->name . ' for ' . $nextAcademicYear->name . '!');
    }

    public function getPromoteSectionsProperty()
    {
        $student = Student::find($this->student_id);
        if (!$student || !$this->selected_academic_year_id) {
            return collect();
        }

        $currentRecord = StudentRecordModel::where('student_id', $student->id)
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->first();

        if (!$currentRecord) {
            return collect();
        }

        $nextGradeLevel = GradeLevel::where('id', '>', $currentRecord->grade_level_id)
            ->orderBy('id')
            ->first();

        if (!$nextGradeLevel) {
            return collect();
        }

        return Section::where('grade_level_id', $nextGradeLevel->id)->get();
    }

    public function getCanPromoteProperty()
    {
        $student = Student::find($this->student_id);
        if (!$student || !$this->selected_academic_year_id) {
            return false;
        }

        if ($student->status === 'Graduated') {
            return false;
        }

        $currentRecord = StudentRecordModel::where('student_id', $student->id)
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->first();

        if (!$currentRecord) {
            return false;
        }

        return true;
    }

    public function getIsPromotedProperty()
    {
        $student = Student::find($this->student_id);
        if (!$student || !$this->selected_academic_year_id) {
            return false;
        }

        $currentRecord = StudentRecordModel::where('student_id', $student->id)
            ->where('academic_year_id', $this->selected_academic_year_id)
            ->first();

        if (!$currentRecord) {
            return false;
        }

        $currentAcademicYear = AcademicYear::find($this->selected_academic_year_id);

        $nextAcademicYear = AcademicYear::where('start_date', '>', $currentAcademicYear->start_date)
            ->orderBy('start_date')
            ->first();

        if (!$nextAcademicYear) {
            return false;
        }

        $nextGradeLevel = GradeLevel::where('id', '>', $currentRecord->grade_level_id)
            ->orderBy('id')
            ->first();

        if (!$nextGradeLevel) {
            return StudentRecordModel::where('student_id', $student->id)
                ->where('academic_year_id', $nextAcademicYear->id)
                ->exists();
        }

        return StudentRecordModel::where('student_id', $student->id)
            ->where('grade_level_id', $nextGradeLevel->id)
            ->where('academic_year_id', $nextAcademicYear->id)
            ->exists();
    }

    public function editRecord($recordId)
    {
        $record = StudentRecordModel::find($recordId);
        if (!$record) {
            return;
        }

        $this->edit_record_id = $recordId;
        $this->edit_grade_level_id = $record->grade_level_id;
        $this->edit_section_id = $record->section_id;
    }

    public function updateRecord()
    {
        $this->validate();

        $record = StudentRecordModel::find($this->edit_record_id);
        if (!$record) {
            return;
        }

        $record->update([
            'grade_level_id' => $this->edit_grade_level_id,
            'section_id' => $this->edit_section_id,
        ]);

        $this->cancelEdit();
        sweetalert()->success('Student record updated successfully!');
    }

    public function cancelEdit()
    {
        $this->edit_record_id = null;
        $this->edit_grade_level_id = null;
        $this->edit_section_id = null;
    }

    public function getEditSectionsProperty()
    {
        return Section::all();
    }

    public function exportGrades($academicYearId = null)
    {
        $academicYearId = $academicYearId ?: $this->selected_academic_year_id;

        if (!$academicYearId || !$this->student_id) {
            sweetalert()->error('Please select an academic year first.');
            return;
        }

        $student = Student::find($this->student_id);
        $academicYear = AcademicYear::find($academicYearId);

        if (!$student || !$academicYear) {
            sweetalert()->error('Invalid student or academic year.');
            return;
        }

        $termGrades = TermGrade::where('student_id', $student->id)
            ->where('academic_year_id', $academicYearId)
            ->with('subject')
            ->get();

        if ($termGrades->isEmpty()) {
            sweetalert()->error('No grades found for this academic year.');
            return;
        }

        $studentName = strtoupper($student->lastname) . ', ' . strtoupper($student->firstname) . ' ' . strtoupper($student->middlename ?? '');
        $fileName = 'Grades_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $student->lastname . '_' . $student->firstname) . '_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $academicYear->name) . '.csv';

        return response()->streamDownload(function () use ($termGrades, $studentName) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [$studentName]);
            fputcsv($file, []);

            $columns = ['#', 'Learning Area', '1st Grading', '2nd Grading', '3rd Grading', '4th Grading', 'Final Rating', 'Remarks'];
            fputcsv($file, $columns);

            foreach ($termGrades as $index => $row) {
                fputcsv($file, [
                    $index + 1,
                    $row->subject->subject_name ?? '',
                    $row->first_grading ?? '',
                    $row->second_grading ?? '',
                    $row->third_grading ?? '',
                    $row->fourth_grading ?? '',
                    $row->final_rating ?? '',
                    $row->remarks ?? '',
                ]);
            }

            $allFinals = $termGrades->pluck('final_rating')->filter(fn($v) => is_numeric($v))->toArray();
            $generalAverage = count($allFinals) > 0 ? round(array_sum($allFinals) / count($allFinals), 0) : null;

            fputcsv($file, []);
            fputcsv($file, ['', 'General Average', '', '', '', '', $generalAverage ?? '']);

            fclose($file);
        }, $fileName);
    }

    public function render()
    {
        $student_records = StudentRecordModel::where('student_id', $this->student_id)
            ->with(['gradeLevel', 'section', 'academicYear'])
            ->orderBy('academic_year_id')
            ->orderBy('grade_level_id')
            ->get();

        $activeRecord = $student_records->first();

        if ($this->selected_academic_year_id) {
            $activeRecord = $student_records->where('academic_year_id', $this->selected_academic_year_id)->first() ?? $activeRecord;
        }

        return view('livewire.admin.student-record', [
            'student' => Student::where('id', $this->student_id)->first(),
            'student_records' => $student_records,
            'academic_years' => AcademicYear::orderByDesc('is_active')->orderBy('name', 'desc')->get(),
            'grade_levels' => GradeLevel::orderBy('id')->get(),
            'activeRecordId' => $activeRecord?->id,
        ]);
    }
}

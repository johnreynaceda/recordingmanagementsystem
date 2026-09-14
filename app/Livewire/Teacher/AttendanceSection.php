<?php

namespace App\Livewire\Teacher;

use App\Models\AcademicYear;
use App\Models\AttendanceRecord;
use App\Models\Section;
use App\Models\StudentRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Livewire\Component;

class AttendanceSection extends Component
{
    public $section_id;

    public $selected_academic_year_id;

    public $selected_date;

    public array $selectedStudentRecordIds = [];

    public function mount(): void
    {
        $this->selected_academic_year_id = AcademicYear::getActiveYearId();
        $this->selected_date = now()->toDateString();
    }

    public function toggleSelectAll(): void
    {
        $recordIds = $this->studentRecordsQuery()->pluck('student_records.id')->map(fn ($id) => (string) $id)->all();
        $selectedIds = array_map('strval', $this->selectedStudentRecordIds);

        $this->selectedStudentRecordIds = count(array_intersect($recordIds, $selectedIds)) === count($recordIds)
            ? []
            : $recordIds;
    }

    public function markSelectedPresent(): void
    {
        $this->validate([
            'selected_academic_year_id' => ['required', 'exists:academic_years,id'],
            'selected_date' => ['required', 'date'],
            'selectedStudentRecordIds' => ['required', 'array', 'min:1'],
            'selectedStudentRecordIds.*' => ['integer', 'distinct', 'exists:student_records,id'],
        ], [
            'selectedStudentRecordIds.required' => 'Select at least one student.',
            'selectedStudentRecordIds.min' => 'Select at least one student.',
        ]);

        $records = $this->studentRecordsQuery()
            ->whereIn('student_records.id', $this->selectedStudentRecordIds)
            ->get();

        if ($records->isEmpty()) {
            $this->addError('selectedStudentRecordIds', 'No valid students were selected.');

            return;
        }

        $attendanceDate = Carbon::parse($this->selected_date);
        $attendanceTimestamp = $attendanceDate->copy()->setTimeFrom(now());
        $alreadyPresent = [];
        $addedAttendance = [];

        foreach ($records as $record) {
            $studentName = strtoupper($record->student->lastname.', '.$record->student->firstname);
            $existingAttendance = AttendanceRecord::where('student_record_id', $record->id)
                ->whereDate('created_at', $attendanceDate->toDateString())
                ->exists();

            if ($existingAttendance) {
                $alreadyPresent[] = $studentName;

                continue;
            }

            AttendanceRecord::create([
                'student_record_id' => $record->id,
                'academic_year_id' => $record->academic_year_id ?? $this->selected_academic_year_id,
                'created_at' => $attendanceTimestamp,
                'updated_at' => $attendanceTimestamp,
            ]);
            $addedAttendance[] = $studentName;
        }

        $messages = [];

        if ($alreadyPresent !== []) {
            $messages[] = count($alreadyPresent).' student(s) already marked present: '.implode(', ', $alreadyPresent);
        }

        if ($addedAttendance !== []) {
            $messages[] = count($addedAttendance).' student(s) marked present: '.implode(', ', $addedAttendance);
        }

        $message = implode(' | ', $messages);

        if ($addedAttendance !== []) {
            sweetalert()->success($message);
        } else {
            sweetalert()->info($message);
        }

        session()->flash('attendance_message', $message);
        $this->selectedStudentRecordIds = [];
    }

    public function updatedSectionId(): void
    {
        $this->selectedStudentRecordIds = [];
        $this->resetValidation();
    }

    public function updatedSelectedAcademicYearId(): void
    {
        $this->section_id = null;
        $this->selectedStudentRecordIds = [];
        $this->resetValidation();
    }

    public function updatedSelectedDate(): void
    {
        $this->selectedStudentRecordIds = [];
        $this->resetValidation();
    }

    public function render(): View
    {
        $sections = Section::where('staff_id', auth()->user()->staff->id)
            ->forAcademicYear($this->selected_academic_year_id)
            ->orderBy('name')
            ->get();
        $studentRecords = filled($this->section_id)
            ? $this->studentRecordsQuery()->get()
            : collect();
        $visibleRecordIds = $studentRecords->pluck('id')->map(fn ($id) => (string) $id)->all();
        $selectedIds = array_map('strval', $this->selectedStudentRecordIds);

        return view('livewire.teacher.attendance-section', [
            'sections' => $sections,
            'academic_years' => AcademicYear::orderByDesc('is_active')->orderBy('name', 'desc')->get(),
            'studentRecords' => $studentRecords,
            'allStudentsSelected' => $visibleRecordIds !== []
                && count(array_intersect($visibleRecordIds, $selectedIds)) === count($visibleRecordIds),
        ]);
    }

    private function studentRecordsQuery(): Builder
    {
        $activeAcademicYearId = AcademicYear::getActiveYearId();

        return StudentRecord::query()
            ->with([
                'student',
                'section',
                'attendanceRecords' => fn ($query) => $query
                    ->when(
                        $this->selected_date,
                        fn ($query) => $query->whereDate('created_at', $this->selected_date)
                    )
                    ->oldest('created_at'),
            ])
            ->join('students', 'students.id', '=', 'student_records.student_id')
            ->where('student_records.is_active', true)
            ->where('student_records.section_id', $this->section_id)
            ->whereHas('section', function ($query) {
                $query->where('staff_id', auth()->user()->staff->id);
            })
            ->when(
                filled($this->selected_academic_year_id),
                function ($query) use ($activeAcademicYearId) {
                    $query->where(function ($query) use ($activeAcademicYearId) {
                        $query->where('student_records.academic_year_id', $this->selected_academic_year_id);

                        if ((string) $this->selected_academic_year_id === (string) $activeAcademicYearId) {
                            $query->orWhereNull('student_records.academic_year_id');
                        }
                    });
                }
            )
            ->orderBy('students.lastname')
            ->orderBy('students.firstname')
            ->select('student_records.*');
    }
}

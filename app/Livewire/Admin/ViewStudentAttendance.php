<?php

namespace App\Livewire\Admin;

use App\Models\AcademicYear;
use App\Models\Student;
use App\Services\StudentAttendanceReportService;
use Livewire\Component;

class ViewStudentAttendance extends Component
{
    public Student $student;

    public ?int $academic_year_id = null;

    public ?string $date_from = null;

    public ?string $date_to = null;

    public function mount(Student $student): void
    {
        $this->student = $student;
        $this->academic_year_id = request()->integer('academic_year_id') ?: AcademicYear::getActiveYearId();
        $this->setAcademicYearDates();
    }

    public function updatedAcademicYearId(): void
    {
        $this->setAcademicYearDates();
    }

    private function setAcademicYearDates(): void
    {
        $academicYear = AcademicYear::find($this->academic_year_id);
        $this->date_from = $academicYear?->start_date;
        $this->date_to = $academicYear?->end_date;
    }

    public function render(StudentAttendanceReportService $reportService)
    {
        $this->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        return view('livewire.admin.view-student-attendance', [
            'report' => $reportService->build(
                $this->student,
                $this->academic_year_id,
                $this->date_from,
                $this->date_to,
            ),
        ])->layout('components.admin-layout');
    }
}

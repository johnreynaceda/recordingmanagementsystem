<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\StudentList;
use App\Models\AcademicYear;
use App\Models\AttendanceRecord;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StudentAttendanceReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_action_group_contains_view_attendance_action(): void
    {
        [$admin] = $this->createAttendanceData();

        Livewire::actingAs($admin)
            ->test(StudentList::class)
            ->assertTableActionExists('attendance');
    }

    public function test_admin_can_view_and_export_student_attendance(): void
    {
        [$admin, $student, $academicYear] = $this->createAttendanceData();
        $query = [
            'academic_year_id' => $academicYear->id,
            'date_from' => '2026-08-03',
            'date_to' => '2026-08-07',
        ];

        $this->actingAs($admin)
            ->get(route('admin.student-attendance', ['student' => $student, ...$query]))
            ->assertOk()
            ->assertSee('Attendance Report')
            ->assertSee('August 03, 2026')
            ->assertSee('August 04, 2026')
            ->assertDontSee('Filter attendance records')
            ->assertDontSee('School Days');

        $this->actingAs($admin)
            ->get(route('admin.student-attendance.export', [
                'student' => $student,
                'format' => 'pdf',
                ...$query,
            ]))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');

        $this->actingAs($admin)
            ->get(route('admin.student-attendance.export', [
                'student' => $student,
                'format' => 'excel',
                ...$query,
            ]))
            ->assertOk()
            ->assertDownload('attendance-dela-cruz-juan.xlsx');
    }

    private function createAttendanceData(): array
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        $studentUser = User::factory()->create(['user_type' => 'student']);
        $academicYear = AcademicYear::create([
            'name' => '2026-2027',
            'start_date' => '2026-08-03',
            'end_date' => '2026-08-07',
            'is_active' => true,
        ]);
        $gradeLevel = GradeLevel::create(['name' => 'Grade 10']);
        $section = Section::create([
            'name' => 'Integrity',
            'grade_level_id' => $gradeLevel->id,
        ]);
        $student = Student::create([
            'firstname' => 'Juan',
            'lastname' => 'Dela Cruz',
            'birthdate' => '2010-01-01',
            'address' => 'Test Address',
            'lrn' => '123456789012',
            'user_id' => $studentUser->id,
        ]);
        $studentRecord = StudentRecord::create([
            'student_id' => $student->id,
            'grade_level_id' => $gradeLevel->id,
            'section_id' => $section->id,
            'academic_year_id' => $academicYear->id,
            'is_active' => true,
        ]);

        foreach (['2026-08-03 08:00:00', '2026-08-04 08:00:00'] as $date) {
            AttendanceRecord::create([
                'student_record_id' => $studentRecord->id,
                'academic_year_id' => $academicYear->id,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }

        return [$admin, $student, $academicYear];
    }
}

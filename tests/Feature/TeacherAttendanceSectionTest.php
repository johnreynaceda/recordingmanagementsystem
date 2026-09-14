<?php

namespace Tests\Feature;

use App\Livewire\Teacher\AttendanceSection;
use App\Models\AcademicYear;
use App\Models\AttendanceRecord;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Staff;
use App\Models\Student;
use App\Models\StudentRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TeacherAttendanceSectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_attendance_record_is_shown_for_the_selected_date(): void
    {
        [$teacher, $academicYear, $section, $studentRecord] = $this->createAttendanceContext();

        AttendanceRecord::create([
            'student_record_id' => $studentRecord->id,
            'academic_year_id' => null,
            'created_at' => '2026-09-14 08:15:00',
            'updated_at' => '2026-09-14 08:15:00',
        ]);

        Livewire::actingAs($teacher)
            ->test(AttendanceSection::class)
            ->set('selected_academic_year_id', $academicYear->id)
            ->set('section_id', $section->id)
            ->set('selected_date', '2026-09-14')
            ->assertSee('1 student found')
            ->assertSee('DELA CRUZ, JUAN')
            ->assertSee('Present')
            ->assertSee('08:15 AM')
            ->set('selected_date', '2026-09-15')
            ->assertSee('No record')
            ->assertDontSee('08:15 AM');
    }

    public function test_active_year_shows_legacy_student_record_without_an_academic_year(): void
    {
        [$teacher, $academicYear, $section, $studentRecord] = $this->createAttendanceContext();
        $studentRecord->update(['academic_year_id' => null]);

        Livewire::actingAs($teacher)
            ->test(AttendanceSection::class)
            ->set('selected_academic_year_id', $academicYear->id)
            ->set('section_id', $section->id)
            ->assertSee('1 student found')
            ->assertSee('DELA CRUZ, JUAN');
    }

    public function test_marking_attendance_uses_the_selected_student_record_academic_year(): void
    {
        [$teacher, $academicYear, $section, $studentRecord] = $this->createAttendanceContext(false);

        AcademicYear::create([
            'name' => '2026-2027',
            'start_date' => '2026-06-01',
            'end_date' => '2027-03-31',
            'is_active' => true,
        ]);

        Livewire::actingAs($teacher)
            ->test(AttendanceSection::class)
            ->set('selected_academic_year_id', $academicYear->id)
            ->set('section_id', $section->id)
            ->set('selected_date', '2025-09-14')
            ->set('selectedStudentRecordIds', [$studentRecord->id])
            ->call('markSelectedPresent')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('attendance_records', [
            'student_record_id' => $studentRecord->id,
            'academic_year_id' => $academicYear->id,
        ]);
    }

    private function createAttendanceContext(bool $activeYear = true): array
    {
        $teacher = User::factory()->create(['user_type' => 'teacher']);
        $staff = Staff::create([
            'firstname' => 'Test',
            'lastname' => 'Teacher',
            'address' => 'Test address',
            'user_id' => $teacher->id,
        ]);
        $academicYear = AcademicYear::create([
            'name' => '2025-2026',
            'start_date' => '2025-06-01',
            'end_date' => '2026-03-31',
            'is_active' => $activeYear,
        ]);
        $gradeLevel = GradeLevel::create(['name' => 'Grade 10']);
        $section = Section::create([
            'grade_level_id' => $gradeLevel->id,
            'name' => 'Integrity',
            'staff_id' => $staff->id,
        ]);
        $studentUser = User::factory()->create(['user_type' => 'student']);
        $student = Student::create([
            'firstname' => 'Juan',
            'lastname' => 'Dela Cruz',
            'birthdate' => '2010-01-01',
            'address' => 'Test address',
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

        return [$teacher, $academicYear, $section, $studentRecord];
    }
}

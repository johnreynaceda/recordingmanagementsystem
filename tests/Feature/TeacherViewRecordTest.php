<?php

namespace Tests\Feature;

use App\Livewire\Teacher\ViewRecord;
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

class TeacherViewRecordTest extends TestCase
{
    use RefreshDatabase;

    public function test_section_report_shows_present_and_absent_students_for_the_selected_date(): void
    {
        $teacher = User::factory()->create(['user_type' => 'teacher']);
        $staff = Staff::create([
            'firstname' => 'Test',
            'lastname' => 'Teacher',
            'address' => 'Test address',
            'user_id' => $teacher->id,
        ]);
        $academicYear = AcademicYear::create([
            'name' => '2026-2027',
            'start_date' => '2026-06-01',
            'end_date' => '2027-03-31',
            'is_active' => true,
        ]);
        $gradeLevel = GradeLevel::create(['name' => 'Grade 8']);
        $section = Section::create([
            'name' => 'Integrity',
            'grade_level_id' => $gradeLevel->id,
            'staff_id' => $staff->id,
        ]);
        $presentRecord = $this->createStudentRecord('Juan', 'Dela Cruz', '123456789012', $academicYear, $gradeLevel, $section, false);
        $absentRecord = $this->createStudentRecord('Maria', 'Santos', '123456789013', $academicYear, $gradeLevel, $section, true);

        AttendanceRecord::create([
            'student_record_id' => $presentRecord->id,
            'academic_year_id' => $academicYear->id,
            'created_at' => '2026-09-14 08:00:00',
            'updated_at' => '2026-09-14 08:00:00',
        ]);

        Livewire::actingAs($teacher)
            ->test(ViewRecord::class)
            ->set('selected_academic_year_id', $academicYear->id)
            ->set('section_id', $section->id)
            ->set('date', '2026-09-14')
            ->assertViewHas('student_records', function ($records) use ($presentRecord, $absentRecord): bool {
                return $records->pluck('id')->all() === [$presentRecord->id, $absentRecord->id];
            })
            ->assertSee('Dela Cruz, Juan')
            ->assertSee('Santos, Maria')
            ->assertSee('PRESENT')
            ->assertSee('ABSENT')
            ->assertDontSee('>SECTION</th>', false);
    }

    private function createStudentRecord(
        string $firstname,
        string $lastname,
        string $lrn,
        AcademicYear $academicYear,
        GradeLevel $gradeLevel,
        Section $section,
        bool $active,
    ): StudentRecord {
        $studentUser = User::factory()->create(['user_type' => 'student']);
        $student = Student::create([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'birthdate' => '2010-01-01',
            'address' => 'Test address',
            'lrn' => $lrn,
            'user_id' => $studentUser->id,
        ]);

        return StudentRecord::create([
            'student_id' => $student->id,
            'grade_level_id' => $gradeLevel->id,
            'section_id' => $section->id,
            'academic_year_id' => $academicYear->id,
            'is_active' => $active,
        ]);
    }
}

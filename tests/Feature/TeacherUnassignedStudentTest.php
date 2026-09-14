<?php

namespace Tests\Feature;

use App\Livewire\CreateStudent;
use App\Livewire\Teacher\UnassignedStudentList;
use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TeacherUnassignedStudentTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_can_see_unassigned_student_and_decision_actions(): void
    {
        [$teacher, $record] = $this->createUnassignedStudent();

        Livewire::actingAs($teacher)
            ->test(UnassignedStudentList::class)
            ->assertSee('Unassigned student registrations')
            ->assertSee('DELA CRUZ, JUAN')
            ->assertTableActionVisible('proceed_registration', $record)
            ->assertTableActionHasUrl(
                'proceed_registration',
                route('teacher.students-create', ['student_record' => $record->id]),
                $record,
            )
            ->assertTableActionVisible('reject_registration', $record);
    }

    public function test_teacher_can_proceed_with_student_placement(): void
    {
        [$teacher, $record] = $this->createUnassignedStudent();
        $gradeLevel = GradeLevel::create(['name' => 'Grade 7']);
        $section = Section::create([
            'name' => 'Integrity',
            'grade_level_id' => $gradeLevel->id,
        ]);

        Livewire::withQueryParams(['student_record' => $record->id])
            ->actingAs($teacher)
            ->test(CreateStudent::class)
            ->assertSet('isCompletingRegistration', true)
            ->assertSet('student_record_id', $record->id)
            ->assertSet('firstname', 'Juan')
            ->assertSet('lrn', '123456789012')
            ->set('grade_level', $gradeLevel->id)
            ->set('section', $section->id)
            ->call('submitRecord')
            ->assertHasNoErrors()
            ->assertRedirect(route('teacher.dashboard'));

        $this->assertSame(1, Student::count());
        $this->assertSame(2, User::count());

        $record->refresh();

        $this->assertSame($gradeLevel->id, $record->grade_level_id);
        $this->assertSame($section->id, $record->section_id);
    }

    public function test_proceed_page_does_not_require_a_new_password(): void
    {
        [$teacher, $record] = $this->createUnassignedStudent();
        $gradeLevel = GradeLevel::create(['name' => 'Grade 7']);
        $section = Section::create([
            'name' => 'Integrity',
            'grade_level_id' => $gradeLevel->id,
        ]);

        Livewire::withQueryParams(['student_record' => $record->id])
            ->actingAs($teacher)
            ->test(CreateStudent::class)
            ->set('grade_level', $gradeLevel->id)
            ->set('section', $section->id)
            ->set('password', null)
            ->set('confirm_password', null)
            ->call('submitRecord')
            ->assertHasNoErrors(['password', 'confirm_password']);
    }

    public function test_teacher_can_reject_student_registration(): void
    {
        [$teacher, $record] = $this->createUnassignedStudent();

        Livewire::actingAs($teacher)
            ->test(UnassignedStudentList::class)
            ->callTableAction('reject_registration', $record)
            ->assertHasNoTableActionErrors();

        $this->assertSame('Rejected', $record->student->fresh()->status);
        $this->assertFalse((bool) $record->fresh()->is_active);
    }

    public function test_non_teacher_cannot_open_teacher_registration_queue(): void
    {
        $admin = User::factory()->create(['user_type' => 'admin']);

        Livewire::actingAs($admin)
            ->test(UnassignedStudentList::class)
            ->assertForbidden();
    }

    private function createUnassignedStudent(): array
    {
        $teacher = User::factory()->create(['user_type' => 'teacher']);
        $studentUser = User::factory()->create(['user_type' => 'student']);
        $academicYear = AcademicYear::create([
            'name' => '2026-2027',
            'start_date' => '2026-06-01',
            'end_date' => '2027-03-31',
            'is_active' => true,
        ]);
        $student = Student::create([
            'firstname' => 'Juan',
            'lastname' => 'Dela Cruz',
            'birthdate' => '2010-01-01',
            'address' => 'Test Address',
            'contact_number' => '+639171234567',
            'lrn' => '123456789012',
            'user_id' => $studentUser->id,
        ]);
        $record = StudentRecord::create([
            'student_id' => $student->id,
            'grade_level_id' => null,
            'section_id' => null,
            'academic_year_id' => $academicYear->id,
            'is_active' => true,
        ]);

        return [$teacher, $record];
    }
}

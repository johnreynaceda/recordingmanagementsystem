<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\StudentList;
use App\Livewire\CreateStudent;
use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StudentPlacementTest extends TestCase
{
    use RefreshDatabase;

    public function test_unassigned_students_are_highlighted_on_the_student_list(): void
    {
        [$admin, $student, $record] = $this->createUnassignedStudent();

        Livewire::actingAs($admin)
            ->test(StudentList::class)
            ->assertSee('1 student needs placement')
            ->assertSee('Needs placement')
            ->assertTableActionVisible('proceed_registration', $student)
            ->assertTableActionHasUrl(
                'proceed_registration',
                route('admin.students-create', ['student_record' => $record->id]),
                $student,
            )
            ->assertTableActionVisible('reject_registration', $student)
            ->assertTableActionHidden('edit', $student)
            ->assertTableActionHidden('view', $student);
    }

    public function test_admin_can_assign_an_unassigned_student_to_a_grade_and_section(): void
    {
        [$admin, $student, $record] = $this->createUnassignedStudent();
        $gradeLevel = GradeLevel::create(['name' => 'Grade 7']);
        $section = Section::create([
            'name' => 'Integrity',
            'grade_level_id' => $gradeLevel->id,
        ]);

        Livewire::withQueryParams(['student_record' => $record->id])
            ->actingAs($admin)
            ->test(CreateStudent::class)
            ->assertSet('isCompletingRegistration', true)
            ->assertSet('student_record_id', $record->id)
            ->assertSet('firstname', 'Juan')
            ->set('grade_level', $gradeLevel->id)
            ->set('section', $section->id)
            ->call('submitRecord')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.students'));

        $this->assertSame(1, Student::count());
        $this->assertSame(2, User::count());

        $record->refresh();

        $this->assertSame($gradeLevel->id, $record->grade_level_id);
        $this->assertSame($section->id, $record->section_id);
        $this->assertTrue((bool) $record->is_active);
    }

    public function test_admin_can_reject_an_unassigned_registration(): void
    {
        [$admin, $student, $record] = $this->createUnassignedStudent();

        Livewire::actingAs($admin)
            ->test(StudentList::class)
            ->callTableAction('reject_registration', $student)
            ->assertHasNoTableActionErrors();

        $this->assertSame('Rejected', $student->fresh()->status);
        $this->assertFalse((bool) $record->fresh()->is_active);
    }

    private function createUnassignedStudent(): array
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
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

        return [$admin, $student, $record];
    }
}

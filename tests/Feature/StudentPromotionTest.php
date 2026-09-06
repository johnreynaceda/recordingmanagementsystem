<?php

namespace Tests\Feature;

use App\Livewire\Admin\StudentRecord;
use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentRecord as StudentRecordModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StudentPromotionTest extends TestCase
{
    use RefreshDatabase;

    public function test_promotion_requires_a_section_from_the_next_grade_level(): void
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        $studentUser = User::factory()->create(['user_type' => 'student']);
        $student = Student::create([
            'firstname' => 'Test',
            'lastname' => 'Student',
            'birthdate' => '2012-01-01',
            'address' => 'Test address',
            'user_id' => $studentUser->id,
        ]);

        $currentYear = AcademicYear::create([
            'name' => '2026-2027',
            'start_date' => '2026-06-01',
            'end_date' => '2027-03-31',
            'is_active' => true,
        ]);
        $nextYear = AcademicYear::create([
            'name' => '2027-2028',
            'start_date' => '2027-06-01',
            'end_date' => '2028-03-31',
        ]);

        $gradeSeven = GradeLevel::create(['name' => 'Grade 7']);
        $gradeEight = GradeLevel::create(['name' => 'Grade 8']);
        $gradeSevenSection = Section::create([
            'grade_level_id' => $gradeSeven->id,
            'name' => 'Grade 7 Section',
        ]);
        $gradeEightSection = Section::create([
            'grade_level_id' => $gradeEight->id,
            'name' => 'Grade 8 Section',
        ]);

        $currentRecord = StudentRecordModel::create([
            'student_id' => $student->id,
            'grade_level_id' => $gradeSeven->id,
            'section_id' => $gradeSevenSection->id,
            'academic_year_id' => $currentYear->id,
            'is_active' => true,
        ]);

        $component = Livewire::actingAs($admin)
            ->withQueryParams(['id' => $student->id])
            ->test(StudentRecord::class);

        $component
            ->call('editRecord', $currentRecord->id)
            ->assertSet('edit_grade_level_id', $gradeSeven->id)
            ->assertSet('edit_section_id', $gradeSevenSection->id);

        $this->assertSame([$gradeSevenSection->id], $component->get('editSections')->pluck('id')->all());

        $component
            ->set('edit_grade_level_id', $gradeEight->id)
            ->assertSet('edit_section_id', null);

        $this->assertSame([$gradeEightSection->id], $component->get('editSections')->pluck('id')->all());

        $component
            ->set('edit_section_id', $gradeSevenSection->id)
            ->call('updateRecord')
            ->assertHasErrors(['edit_section_id' => 'exists'])
            ->call('cancelEdit')
            ->call('promoteStudent')
            ->assertSet('showPromoteModal', true)
            ->assertSet('promote_grade_level_name', 'Grade 8')
            ->assertSet('promote_academic_year_name', '2027-2028')
            ->assertSee('Grade 8 Section');

        $component
            ->call('confirmPromote')
            ->assertHasErrors(['promote_section_id' => 'required'])
            ->set('promote_section_id', $gradeSevenSection->id)
            ->call('confirmPromote')
            ->assertHasErrors(['promote_section_id' => 'exists'])
            ->set('promote_section_id', $gradeEightSection->id)
            ->call('confirmPromote')
            ->assertHasNoErrors()
            ->assertSet('showPromoteModal', false);

        $this->assertDatabaseHas('student_records', [
            'student_id' => $student->id,
            'grade_level_id' => $gradeEight->id,
            'section_id' => $gradeEightSection->id,
            'academic_year_id' => $nextYear->id,
            'is_active' => true,
        ]);
        $this->assertDatabaseHas('student_records', [
            'id' => $currentRecord->id,
            'is_active' => false,
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Livewire\Teacher\Grading;
use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\GradeLevelSubject;
use App\Models\Section;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class GradingValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_grades_reject_letters_and_out_of_range_values(): void
    {
        [$teacher, $academicYear, $section, $subject] = $this->createGradingContext();

        Livewire::actingAs($teacher)
            ->test(Grading::class)
            ->set('selected_academic_year_id', $academicYear->id)
            ->set('selected_section_id', $section->id)
            ->set('selected_subject_id', $subject->id)
            ->set('termGrades.999.first_grading', 'grade A')
            ->set('termGrades.999.second_grading', '1e2')
            ->set('termGrades.999.third_grading', '101')
            ->call('saveGrades')
            ->assertHasErrors([
                'termGrades.999.first_grading' => 'numeric',
                'termGrades.999.second_grading' => 'regex',
                'termGrades.999.third_grading' => 'max',
            ]);

        $this->assertDatabaseCount('term_grades', 0);
    }

    public function test_valid_numeric_grades_can_be_saved(): void
    {
        [$teacher, $academicYear, $section, $subject] = $this->createGradingContext();

        Livewire::actingAs($teacher)
            ->test(Grading::class)
            ->set('selected_academic_year_id', $academicYear->id)
            ->set('selected_section_id', $section->id)
            ->set('selected_subject_id', $subject->id)
            ->set('termGrades.999.first_grading', '89')
            ->set('termGrades.999.second_grading', '90.50')
            ->set('termGrades.999.third_grading', '92')
            ->call('saveGrades')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('term_grades', [
            'student_id' => 999,
            'first_grading' => '89',
            'second_grading' => '90.50',
            'third_grading' => '92',
            'final_rating' => 91,
        ]);
    }

    private function createGradingContext(): array
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
        $gradeLevel = GradeLevel::create(['name' => 'Grade 10']);
        $section = Section::create([
            'grade_level_id' => $gradeLevel->id,
            'name' => 'Test Section',
            'staff_id' => $staff->id,
        ]);
        $subject = GradeLevelSubject::create([
            'grade_level_id' => $gradeLevel->id,
            'subject_name' => 'Mathematics',
            'teacher_id' => $staff->id,
            'academic_year_id' => $academicYear->id,
        ]);

        return [$teacher, $academicYear, $section, $subject];
    }
}

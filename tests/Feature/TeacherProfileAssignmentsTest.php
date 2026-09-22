<?php

namespace Tests\Feature;

use App\Livewire\Teacher\Profile;
use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\GradeLevelSubject;
use App\Models\Section;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TeacherProfileAssignmentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_assignments_are_grouped_by_grade_level_for_the_active_academic_year(): void
    {
        $user = User::factory()->create(['user_type' => 'teacher']);
        $teacher = Staff::create([
            'firstname' => 'Maria',
            'lastname' => 'Santos',
            'address' => 'Trece Martires City',
            'user_id' => $user->id,
        ]);

        $activeYear = AcademicYear::create([
            'name' => '2026-2027',
            'start_date' => '2026-06-01',
            'end_date' => '2027-03-31',
            'is_active' => true,
        ]);
        $previousYear = AcademicYear::create([
            'name' => '2025-2026',
            'start_date' => '2025-06-01',
            'end_date' => '2026-03-31',
            'is_active' => false,
        ]);

        $gradeSeven = GradeLevel::create(['name' => 'Grade 7']);
        $gradeTen = GradeLevel::create(['name' => 'Grade 10']);

        Section::create([
            'grade_level_id' => $gradeSeven->id,
            'name' => 'Sampaguita',
            'staff_id' => $teacher->id,
            'academic_year_id' => $activeYear->id,
        ]);
        Section::create([
            'grade_level_id' => $gradeSeven->id,
            'name' => 'Historical Section',
            'staff_id' => $teacher->id,
            'academic_year_id' => $previousYear->id,
        ]);

        GradeLevelSubject::create([
            'grade_level_id' => $gradeSeven->id,
            'subject_name' => 'Mathematics',
            'teacher_id' => $teacher->id,
            'academic_year_id' => $activeYear->id,
        ]);
        GradeLevelSubject::create([
            'grade_level_id' => $gradeTen->id,
            'subject_name' => 'Science',
            'teacher_id' => $teacher->id,
            'academic_year_id' => $activeYear->id,
        ]);
        GradeLevelSubject::create([
            'grade_level_id' => $gradeSeven->id,
            'subject_name' => 'Historical Subject',
            'teacher_id' => $teacher->id,
            'academic_year_id' => $previousYear->id,
        ]);

        $component = Livewire::actingAs($user)->test(Profile::class);

        $component
            ->assertSet('activeAcademicYearName', '2026-2027')
            ->assertSeeInOrder(['Grade 7', 'Sampaguita', 'Mathematics', 'Grade 10', 'Science'])
            ->assertDontSee('Historical Section')
            ->assertDontSee('Historical Subject');

        $groups = $component->get('assignmentGroups');

        $this->assertCount(2, $groups);
        $this->assertSame('Grade 7', $groups[0]['name']);
        $this->assertSame(['Sampaguita'], array_column($groups[0]['sections'], 'name'));
        $this->assertSame(['Mathematics'], array_column($groups[0]['subjects'], 'name'));
        $this->assertSame('Grade 10', $groups[1]['name']);
        $this->assertEmpty($groups[1]['sections']);
        $this->assertSame(['Science'], array_column($groups[1]['subjects'], 'name'));
    }
}

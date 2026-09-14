<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\StudentList;
use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StudentListAcademicYearFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_promoted_student_displays_the_placement_for_the_filtered_school_year(): void
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        $studentUser = User::factory()->create(['user_type' => 'student']);
        $oldYear = AcademicYear::create([
            'name' => '2025-2026',
            'start_date' => '2025-06-01',
            'end_date' => '2026-03-31',
            'is_active' => false,
        ]);
        $newYear = AcademicYear::create([
            'name' => '2026-2027',
            'start_date' => '2026-06-01',
            'end_date' => '2027-03-31',
            'is_active' => true,
        ]);
        $gradeSeven = GradeLevel::create(['name' => 'Grade 7']);
        $gradeEight = GradeLevel::create(['name' => 'Grade 8']);
        $oldSection = Section::create([
            'name' => 'Old Integrity',
            'grade_level_id' => $gradeSeven->id,
        ]);
        $newSection = Section::create([
            'name' => 'New Excellence',
            'grade_level_id' => $gradeEight->id,
        ]);
        $student = Student::create([
            'firstname' => 'Juan',
            'lastname' => 'Dela Cruz',
            'birthdate' => '2010-01-01',
            'address' => 'Test address',
            'lrn' => '123456789012',
            'user_id' => $studentUser->id,
        ]);

        StudentRecord::create([
            'student_id' => $student->id,
            'grade_level_id' => $gradeSeven->id,
            'section_id' => $oldSection->id,
            'academic_year_id' => $oldYear->id,
            'is_active' => false,
        ]);
        StudentRecord::create([
            'student_id' => $student->id,
            'grade_level_id' => $gradeEight->id,
            'section_id' => $newSection->id,
            'academic_year_id' => $newYear->id,
            'is_active' => true,
        ]);

        Livewire::actingAs($admin)
            ->test(StudentList::class)
            ->assertCanSeeTableRecords([$student])
            ->assertSeeHtml('<p class="mt-1 truncate font-bold text-slate-800">Grade 8</p>')
            ->assertSeeHtml('<p class="mt-1 truncate font-bold text-slate-800">New Excellence</p>')
            ->assertSeeHtml('<p class="mt-0.5 truncate text-sm font-semibold text-slate-700">2026-2027</p>')
            ->assertDontSeeHtml('<p class="mt-1 truncate font-bold text-slate-800">Old Integrity</p>')
            ->filterTable('academic_year_id', $oldYear->id)
            ->assertCanSeeTableRecords([$student])
            ->assertSeeHtml('<p class="mt-1 truncate font-bold text-slate-800">Grade 7</p>')
            ->assertSeeHtml('<p class="mt-1 truncate font-bold text-slate-800">Old Integrity</p>')
            ->assertSeeHtml('<p class="mt-0.5 truncate text-sm font-semibold text-slate-700">2025-2026</p>')
            ->assertDontSeeHtml('<p class="mt-1 truncate font-bold text-slate-800">New Excellence</p>');
    }
}

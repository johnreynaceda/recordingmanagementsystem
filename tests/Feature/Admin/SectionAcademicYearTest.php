<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\SectionList;
use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SectionAcademicYearTest extends TestCase
{
    use RefreshDatabase;

    public function test_sections_are_automatically_filtered_to_the_active_school_year(): void
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        $oldYear = AcademicYear::create([
            'name' => '2025-2026',
            'start_date' => '2025-06-01',
            'end_date' => '2026-03-31',
            'is_active' => false,
        ]);
        $activeYear = AcademicYear::create([
            'name' => '2026-2027',
            'start_date' => '2026-06-01',
            'end_date' => '2027-03-31',
            'is_active' => true,
        ]);
        $gradeLevel = GradeLevel::create(['name' => 'Grade 8']);
        $oldSection = Section::create([
            'name' => 'Old Integrity',
            'grade_level_id' => $gradeLevel->id,
            'academic_year_id' => $oldYear->id,
        ]);

        $component = Livewire::withQueryParams(['id' => $gradeLevel->id])
            ->actingAs($admin)
            ->test(SectionList::class)
            ->assertSet('active_academic_year_id', $activeYear->id)
            ->assertCanNotSeeTableRecords([$oldSection])
            ->callTableAction('section', data: ['name' => 'New Excellence'])
            ->assertHasNoTableActionErrors();

        $newSection = Section::where('name', 'New Excellence')->firstOrFail();

        $this->assertSame($activeYear->id, $newSection->academic_year_id);

        $component
            ->assertCanSeeTableRecords([$newSection])
            ->assertCanNotSeeTableRecords([$oldSection]);
    }
}

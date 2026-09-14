<?php

namespace Tests\Feature;

use App\Livewire\CreateStudent;
use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateStudentValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_lrn_and_contact_number_formats_are_enforced(): void
    {
        $admin = User::factory()->create(['user_type' => 'admin']);

        Livewire::actingAs($admin)
            ->test(CreateStudent::class)
            ->set('lrn', '12345')
            ->set('contact_number', '09171234567')
            ->call('submitRecord')
            ->assertHasErrors([
                'lrn' => 'digits',
                'contact_number' => 'digits',
            ]);

        Livewire::actingAs($admin)
            ->test(CreateStudent::class)
            ->set('lrn', '123456789012')
            ->set('contact_number', '9171234567')
            ->call('submitRecord')
            ->assertHasNoErrors(['lrn', 'contact_number']);
    }

    public function test_guardian_information_is_normalized_and_saved_with_the_student(): void
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        $academicYear = AcademicYear::create([
            'name' => '2026-2027',
            'start_date' => '2026-06-01',
            'end_date' => '2027-03-31',
            'is_active' => true,
        ]);
        $gradeLevel = GradeLevel::create(['name' => 'Grade 7']);
        $section = Section::create([
            'name' => 'Integrity',
            'grade_level_id' => $gradeLevel->id,
            'academic_year_id' => $academicYear->id,
        ]);

        Livewire::actingAs($admin)
            ->test(CreateStudent::class)
            ->set('firstname', 'Juan')
            ->set('lastname', 'Dela Cruz')
            ->set('birthdate', '2010-01-01')
            ->set('address', 'Test Address')
            ->set('contact_number', '917-123-4567')
            ->set('parent_name', 'maria dela cruz')
            ->set('parent_contact', '918-765-4321')
            ->set('selected_academic_year_id', $academicYear->id)
            ->set('grade_level', $gradeLevel->id)
            ->set('section', $section->id)
            ->set('lrn', '123456789012')
            ->set('email', 'juan@example.com')
            ->set('password', 'password')
            ->set('confirm_password', 'password')
            ->call('submitRecord')
            ->assertHasNoErrors();

        $student = Student::where('lrn', '123456789012')->firstOrFail();

        $this->assertSame('Maria Dela Cruz', $student->parent_name);
        $this->assertSame('+639187654321', $student->parent_contact);
    }
}

<?php

namespace Tests\Feature;

use App\Livewire\Student\Request as StudentRequest;
use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\Request;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StudentRequestContactDetailsTest extends TestCase
{
    use RefreshDatabase;

    public function test_request_uses_contact_details_from_the_authenticated_student(): void
    {
        $user = User::factory()->create([
            'name' => 'Juan Dela Cruz',
            'email' => 'juan@example.com',
            'user_type' => 'student',
        ]);
        $student = Student::create([
            'firstname' => 'Juan',
            'lastname' => 'Dela Cruz',
            'birthdate' => '2010-01-01',
            'address' => 'Test address',
            'contact_number' => '+639171234567',
            'lrn' => '123456789012',
            'user_id' => $user->id,
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
        ]);
        StudentRecord::create([
            'student_id' => $student->id,
            'grade_level_id' => $gradeLevel->id,
            'section_id' => $section->id,
            'academic_year_id' => $academicYear->id,
            'is_active' => true,
        ]);

        Livewire::actingAs($user)
            ->test(StudentRequest::class)
            ->assertSet('email_address', 'juan@example.com')
            ->assertSet('phone_number', '9171234567')
            ->assertSeeHtml('value="917-123-4567"')
            ->set('email_address', 'changed@example.com')
            ->set('phone_number', '9999999999')
            ->set('option', 'SF 9 (Report Card)')
            ->set('last_year_attended_id', $academicYear->id)
            ->set('section_id', $section->id)
            ->call('save')
            ->assertHasNoErrors()
            ->assertSet('email_address', 'juan@example.com')
            ->assertSet('phone_number', '9171234567')
            ->assertSeeHtml('value="917-123-4567"');

        $request = Request::firstOrFail();

        $this->assertSame('juan@example.com', $request->email_address);
        $this->assertSame('+639171234567', $request->phone_number);
    }
}

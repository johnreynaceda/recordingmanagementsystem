<?php

namespace Tests\Feature;

use App\Livewire\Auth\StudentSelfEnrollment;
use App\Models\AcademicYear;
use App\Models\Student;
use App\Models\StudentRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class StudentSelfEnrollmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_self_enrollment_page_is_publicly_available(): void
    {
        $this->get(route('student.self-enrollment'))
            ->assertOk()
            ->assertSee('Create your student account')
            ->assertSee('Account Information')
            ->assertSee('Student Information')
            ->assertSee('Parent/Guardian Information')
            ->assertSee('Create Account');
    }

    public function test_student_can_complete_self_enrollment(): void
    {
        $academicYear = AcademicYear::create([
            'name' => '2026-2027',
            'start_date' => '2026-06-01',
            'end_date' => '2027-03-31',
            'is_active' => true,
        ]);

        Livewire::test(StudentSelfEnrollment::class)
            ->set('firstname', 'juan')
            ->set('middlename', 'santos')
            ->set('lastname', 'dela cruz')
            ->set('birthdate', now()->subYears(13)->toDateString())
            ->set('address', '123 Test Street')
            ->set('contact_number', '9171234567')
            ->set('parent_name', 'maria dela cruz')
            ->set('parent_contact', '9187654321')
            ->set('lrn', '123456789012')
            ->set('email', 'JUAN@EXAMPLE.COM')
            ->set('password', 'secret123')
            ->set('password_confirmation', 'secret123')
            ->call('enroll')
            ->assertHasNoErrors()
            ->assertRedirect(route('student-login'));

        $user = User::where('email', 'juan@example.com')->firstOrFail();
        $student = Student::where('lrn', '123456789012')->firstOrFail();
        $record = StudentRecord::where('student_id', $student->id)->firstOrFail();

        $this->assertSame('student', $user->user_type);
        $this->assertNotNull($user->password_changed_at);
        $this->assertTrue(Hash::check('secret123', $user->password));
        $this->assertSame('Juan', $student->firstname);
        $this->assertNull($student->status);
        $this->assertSame('+639171234567', $student->contact_number);
        $this->assertTrue((bool) $record->is_active);
        $this->assertNull($record->grade_level_id);
        $this->assertNull($record->section_id);
        $this->assertSame($academicYear->id, $record->academic_year_id);
    }

    public function test_self_enrollment_validates_identifiers_and_contact_numbers(): void
    {
        Livewire::test(StudentSelfEnrollment::class)
            ->set('lrn', '12345')
            ->set('contact_number', '09171234567')
            ->set('parent_contact', '123')
            ->call('enroll')
            ->assertHasErrors([
                'lrn' => 'digits',
                'contact_number' => 'digits',
                'parent_contact' => 'digits',
            ]);
    }
}

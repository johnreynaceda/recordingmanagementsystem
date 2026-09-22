<?php

namespace Tests\Feature;

use App\Livewire\Auth\StudentLogin;
use App\Models\Student;
use App\Models\StudentRecord;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Livewire\Livewire;
use Tests\TestCase;

class StudentLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_login_page_accepts_email_or_lrn_and_links_to_self_enrollment(): void
    {
        $this->get(route('student-login'))
            ->assertOk()
            ->assertSee('Email or LRN')
            ->assertSee('Start self-enrollment')
            ->assertSee(route('student.self-enrollment'));
    }

    public function test_login_identifier_must_be_an_email_or_exactly_12_digits(): void
    {
        Livewire::test(StudentLogin::class)
            ->set('lrn', '12345')
            ->set('password', 'password')
            ->call('login')
            ->assertHasErrors(['lrn']);
    }

    public function test_first_login_emails_password_change_link_and_logs_student_out(): void
    {
        Notification::fake();
        [$user, $student] = $this->createStudent();

        Livewire::test(StudentLogin::class)
            ->set('lrn', $student->lrn)
            ->set('password', 'initial-password')
            ->call('login')
            ->assertRedirect(route('student-login'));

        $this->assertGuest();
        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    public function test_student_cannot_bypass_first_login_password_change(): void
    {
        Notification::fake();
        [$user] = $this->createStudent();

        $this->actingAs($user)
            ->get(route('student.index'))
            ->assertRedirect(route('student-login'));

        $this->assertGuest();
        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    public function test_student_can_open_link_and_change_initial_password(): void
    {
        [$user] = $this->createStudent();
        $token = Password::broker()->createToken($user);

        $this->get(route('password.reset', ['token' => $token, 'email' => $user->email]))
            ->assertOk()
            ->assertSee('Reset Password');

        $this->post(route('password.store'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'new-secure-password',
            'password_confirmation' => 'new-secure-password',
        ])->assertRedirect(route('student-login'));

        $user->refresh();

        $this->assertNotNull($user->password_changed_at);
        $this->assertTrue(Hash::check('new-secure-password', $user->password));
    }

    public function test_initial_password_cannot_be_reused_from_change_link(): void
    {
        [$user] = $this->createStudent();
        $token = Password::broker()->createToken($user);

        $this->from(route('password.reset', ['token' => $token, 'email' => $user->email]))
            ->post(route('password.store'), [
                'token' => $token,
                'email' => $user->email,
                'password' => 'initial-password',
                'password_confirmation' => 'initial-password',
            ])
            ->assertSessionHasErrors(['password']);

        $this->assertNull($user->fresh()->password_changed_at);
    }

    public function test_returning_student_logs_in_without_another_email(): void
    {
        Notification::fake();
        [$user, $student] = $this->createStudent([
            'password_changed_at' => now(),
        ]);

        Livewire::test(StudentLogin::class)
            ->set('lrn', $student->lrn)
            ->set('password', 'initial-password')
            ->call('login')
            ->assertRedirect(route('student.index'));

        $this->assertAuthenticatedAs($user);
        Notification::assertNothingSent();
    }

    public function test_returning_student_can_log_in_with_email(): void
    {
        Notification::fake();
        [$user] = $this->createStudent([
            'email' => 'student@example.com',
            'password_changed_at' => now(),
        ]);

        Livewire::test(StudentLogin::class)
            ->set('lrn', 'STUDENT@example.com')
            ->set('password', 'initial-password')
            ->call('login')
            ->assertRedirect(route('student.index'));

        $this->assertAuthenticatedAs($user);
        Notification::assertNothingSent();
    }

    public function test_rejected_student_cannot_log_in(): void
    {
        [$user, $student] = $this->createStudent([
            'password_changed_at' => now(),
        ]);
        $student->update(['status' => 'Rejected']);

        Livewire::test(StudentLogin::class)
            ->set('lrn', $student->lrn)
            ->set('password', 'initial-password')
            ->call('login')
            ->assertNoRedirect();

        $this->assertGuest();
    }

    public function test_student_with_unassigned_grade_or_section_cannot_log_in(): void
    {
        [$user, $student] = $this->createStudent([
            'password_changed_at' => now(),
        ]);
        StudentRecord::create([
            'student_id' => $student->id,
            'grade_level_id' => null,
            'section_id' => null,
            'academic_year_id' => null,
            'is_active' => true,
        ]);

        Livewire::test(StudentLogin::class)
            ->set('lrn', $student->lrn)
            ->set('password', 'initial-password')
            ->call('login')
            ->assertNoRedirect();

        $this->assertGuest();
    }

    private function createStudent(array $userAttributes = []): array
    {
        $user = User::factory()->create(array_merge([
            'password' => Hash::make('initial-password'),
            'user_type' => 'student',
            'password_changed_at' => null,
        ], $userAttributes));

        $student = Student::create([
            'firstname' => 'Juan',
            'lastname' => 'Dela Cruz',
            'birthdate' => '2010-01-01',
            'address' => 'Test Address',
            'lrn' => '123456789012',
            'user_id' => $user->id,
        ]);

        return [$user, $student];
    }
}

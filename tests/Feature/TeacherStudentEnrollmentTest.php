<?php

namespace Tests\Feature;

use App\Livewire\CreateStudent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TeacherStudentEnrollmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_navigation_links_to_student_enrollment_page(): void
    {
        $teacher = User::factory()->create(['user_type' => 'teacher']);

        $this->actingAs($teacher)
            ->get(route('teacher.students-create'))
            ->assertOk()
            ->assertSee('Enroll Student')
            ->assertSee('Create student profile');

        Livewire::actingAs($teacher)
            ->test(CreateStudent::class)
            ->assertViewHas('returnUrl', route('teacher.dashboard'))
            ->assertViewHas('returnLabel', 'Back to dashboard');
    }

    public function test_student_cannot_open_teacher_enrollment_page(): void
    {
        $student = User::factory()->create(['user_type' => 'student']);

        $this->actingAs($student)
            ->get(route('teacher.students-create'))
            ->assertForbidden();
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RoleAccessMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_role_middleware_is_registered_on_each_protected_area(): void
    {
        $this->assertContains('role:admin', Route::getRoutes()->getByName('admin.staffs')->gatherMiddleware());
        $this->assertContains('role:teacher', Route::getRoutes()->getByName('teacher.dashboard')->gatherMiddleware());
        $this->assertContains('role:student', Route::getRoutes()->getByName('student.index')->gatherMiddleware());
    }

    public function test_admin_cannot_access_teacher_or_student_routes(): void
    {
        $admin = User::factory()->create(['user_type' => 'admin']);

        $this->actingAs($admin)->get(route('teacher.dashboard'))->assertForbidden();
        $this->actingAs($admin)->get(route('student.index'))->assertForbidden();
    }

    public function test_teacher_cannot_access_admin_or_student_routes(): void
    {
        $teacher = User::factory()->create(['user_type' => 'teacher']);

        $this->actingAs($teacher)->get(route('admin.staffs'))->assertForbidden();
        $this->actingAs($teacher)->get(route('student.index'))->assertForbidden();
    }

    public function test_student_cannot_access_admin_or_teacher_routes(): void
    {
        $student = User::factory()->create(['user_type' => 'student']);

        $this->actingAs($student)->get(route('admin.staffs'))->assertForbidden();
        $this->actingAs($student)->get(route('teacher.dashboard'))->assertForbidden();
    }
}

<?php

namespace Tests\Feature;

use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AccountCascadeDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_a_student_removes_the_account_and_student_data(): void
    {
        $user = User::factory()->create(['user_type' => 'student']);
        $student = Student::create([
            'firstname' => 'Test',
            'lastname' => 'Student',
            'birthdate' => '2010-01-01',
            'address' => 'Test address',
            'user_id' => $user->id,
        ]);

        $studentRecordId = DB::table('student_records')->insertGetId([
            'student_id' => $student->id,
            'grade_level_id' => 1,
            'section_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('attendance_records')->insert(['student_record_id' => $studentRecordId]);
        DB::table('student_grades')->insert([
            'student_id' => $student->id,
            'name' => 'Grade file',
            'file_path' => 'grades/test.pdf',
        ]);
        DB::table('term_grades')->insert([
            'student_id' => $student->id,
            'section_id' => 1,
        ]);
        DB::table('notifications')->insert([
            'student_id' => $student->id,
            'message' => 'Test notification',
        ]);
        $this->insertUserData($user);

        $student->delete();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('student_records', ['student_id' => $student->id]);
        $this->assertDatabaseMissing('attendance_records', ['student_record_id' => $studentRecordId]);
        $this->assertDatabaseMissing('student_grades', ['student_id' => $student->id]);
        $this->assertDatabaseMissing('term_grades', ['student_id' => $student->id]);
        $this->assertDatabaseMissing('notifications', ['student_id' => $student->id]);
        $this->assertUserDataWasDeleted($user);
    }

    public function test_deleting_a_teacher_removes_the_account_and_unassigns_shared_data(): void
    {
        $user = User::factory()->create(['user_type' => 'teacher']);
        $staff = Staff::create([
            'firstname' => 'Test',
            'lastname' => 'Teacher',
            'address' => 'Test address',
            'user_id' => $user->id,
        ]);

        $sectionId = DB::table('sections')->insertGetId([
            'grade_level_id' => 1,
            'name' => 'Test section',
            'staff_id' => $staff->id,
        ]);
        $subjectId = DB::table('grade_level_subjects')->insertGetId([
            'grade_level_id' => 1,
            'subject_name' => 'Test subject',
            'teacher_id' => $staff->id,
        ]);
        $this->insertUserData($user);

        $staff->delete();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseHas('sections', ['id' => $sectionId, 'staff_id' => null]);
        $this->assertDatabaseHas('grade_level_subjects', ['id' => $subjectId, 'teacher_id' => null]);
        $this->assertUserDataWasDeleted($user);
    }

    private function insertUserData(User $user): void
    {
        DB::table('requests')->insert([
            'user_id' => $user->id,
            'name' => $user->name,
            'option' => 'Test document',
        ]);
        DB::table('sessions')->insert([
            'id' => 'session-'.$user->id,
            'user_id' => $user->id,
            'payload' => 'test',
            'last_activity' => now()->timestamp,
        ]);
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => 'test-token',
        ]);
    }

    private function assertUserDataWasDeleted(User $user): void
    {
        $this->assertDatabaseMissing('requests', ['user_id' => $user->id]);
        $this->assertDatabaseMissing('sessions', ['user_id' => $user->id]);
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);
    }
}

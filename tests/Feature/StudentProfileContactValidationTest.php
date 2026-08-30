<?php

namespace Tests\Feature;

use App\Livewire\Student\Profile;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StudentProfileContactValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_and_parent_contacts_use_philippine_international_format(): void
    {
        $user = User::factory()->create(['user_type' => 'student']);
        $student = Student::create([
            'firstname' => 'Juan',
            'lastname' => 'Dela Cruz',
            'birthdate' => '2010-01-01',
            'address' => 'Test Address',
            'user_id' => $user->id,
        ]);

        $profile = Livewire::actingAs($user)
            ->test(Profile::class)
            ->call('edit')
            ->set('contact_number', '09171234567')
            ->set('parent_contact', '09181234567')
            ->call('save')
            ->assertHasErrors([
                'contact_number' => 'regex',
                'parent_contact' => 'regex',
            ]);

        $profile
            ->set('contact_number', '+639171234567')
            ->set('parent_contact', '+639181234567')
            ->call('save')
            ->assertHasNoErrors(['contact_number', 'parent_contact']);

        $student->refresh();

        $this->assertSame('+639171234567', $student->contact_number);
        $this->assertSame('+639181234567', $student->parent_contact);
    }
}

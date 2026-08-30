<?php

namespace Tests\Feature;

use App\Livewire\CreateStudent;
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
                'contact_number' => 'regex',
            ]);

        Livewire::actingAs($admin)
            ->test(CreateStudent::class)
            ->set('lrn', '123456789012')
            ->set('contact_number', '+639171234567')
            ->call('submitRecord')
            ->assertHasNoErrors(['lrn', 'contact_number']);
    }
}

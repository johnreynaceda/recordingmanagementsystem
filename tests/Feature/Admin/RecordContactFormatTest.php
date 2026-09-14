<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Record;
use App\Models\Record as RecordModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RecordContactFormatTest extends TestCase
{
    use RefreshDatabase;

    public function test_masked_contact_number_is_saved_in_philippine_international_format(): void
    {
        $admin = User::factory()->create(['user_type' => 'admin']);

        Livewire::actingAs($admin)
            ->test(Record::class)
            ->callTableAction('create', data: [
                'firstname' => 'Juan',
                'lastname' => 'Dela Cruz',
                'birthdate' => '2010-01-01',
                'address' => 'Test address',
                'contact_number' => '976-988-7841',
                'status' => 'active',
            ])
            ->assertHasNoTableActionErrors();

        $this->assertSame('+639769887841', RecordModel::firstOrFail()->contact_number);
    }
}

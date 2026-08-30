<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\CalendarSchedule;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CalendarScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_edit_and_delete_calendar_event(): void
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        $event = Event::create([
            'title' => 'Original Event',
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(6)->toDateString(),
        ]);

        $calendar = Livewire::actingAs($admin)
            ->test(CalendarSchedule::class)
            ->call('editEvent', $event->id)
            ->assertSet('editingEventId', $event->id)
            ->assertSet('title', 'Original Event')
            ->set('title', 'Updated Event')
            ->set('start_date', now()->addDays(7)->toDateString())
            ->set('end_date', now()->addDays(8)->toDateString())
            ->call('saveEvent')
            ->assertHasNoErrors()
            ->assertSet('editingEventId', null)
            ->assertSee('Event updated successfully.');

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Updated Event',
        ]);

        $calendar
            ->call('deleteEvent', $event->id)
            ->assertSee('Event deleted successfully.');

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    public function test_non_admin_cannot_modify_calendar_events(): void
    {
        $student = User::factory()->create(['user_type' => 'student']);
        $event = Event::create([
            'title' => 'Protected Event',
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addDay()->toDateString(),
        ]);

        Livewire::actingAs($student)
            ->test(CalendarSchedule::class, ['audience' => 'student'])
            ->call('deleteEvent', $event->id)
            ->assertForbidden();

        $this->assertDatabaseHas('events', ['id' => $event->id]);
    }
}

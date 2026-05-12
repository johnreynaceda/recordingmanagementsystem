<?php

namespace App\Livewire\Admin;

use App\Models\Event;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Livewire\Component;

class CalendarSchedule extends Component implements HasForms
{
    use InteractsWithForms;

    public $title, $start_date, $end_date;

    public $events = [];
    public string $audience = 'admin';

    public function mount()
    {
        $this->loadEvents();
    }

    public function loadEvents()
    {
        $this->events = Event::get()->map(
            function($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => Carbon::parse($event->start_date)->toDateString(),
                    'end' => Carbon::parse($event->end_date)->addDay()->toDateString(),
                    'displayEnd' => Carbon::parse($event->end_date)->toFormattedDateString(),
                    'allDay' => true,
                ];
            }
        )->toArray();
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
              Fieldset::make('EVENT INFORMATION')->schema([
                TextInput::make('title')
                    ->label('Event Title')
                    ->placeholder('Recognition day, enrollment deadline...')
                    ->required(),
                DatePicker::make('start_date')
                    ->label('Start Date')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('End Date')
                    ->required(),
              ])->columns(1)
            ]);
    }

    public function saveEvent(){
        $this->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date|after_or_equal:today',
        ], [
            'start_date.after_or_equal' => 'The start date cannot be in the past.',
            'end_date.after_or_equal' => 'The end date cannot be before the start date or in the past.',
        ]);

        Event::create([
            'title' => $this->title,
            'start_date' => Carbon::parse($this->start_date),
            'end_date' => Carbon::parse($this->end_date),
        ]);

        return redirect()->route('admin.calendar');
    }


    public function render()
    {
        $upcomingEvents = Event::query()
            ->whereDate('end_date', '>=', now()->toDateString())
            ->orderBy('start_date')
            ->limit(5)
            ->get();

        return view('livewire.admin.calendar-schedule', [
            'total_events' => Event::count(),
            'upcoming_events_count' => Event::whereDate('end_date', '>=', now()->toDateString())->count(),
            'this_month_events_count' => Event::whereBetween('start_date', [
                now()->startOfMonth()->toDateString(),
                now()->endOfMonth()->toDateString(),
            ])->count(),
            'upcoming_events' => $upcomingEvents,
            'calendar_copy' => $this->calendarCopy(),
        ]);
    }

    private function calendarCopy(): array
    {
        return match ($this->audience) {
            'student' => [
                'eyebrow' => 'Academic Calendar',
                'title' => 'View school events',
                'description' => 'Stay updated on school activities, deadlines, and important academic dates.',
            ],
            'teacher' => [
                'eyebrow' => 'School Calendar',
                'title' => 'View schedules and events',
                'description' => 'Keep track of upcoming school activities, class-related dates, and academic events.',
            ],
            default => [
                'eyebrow' => 'School Calendar',
                'title' => 'Manage events and schedules',
                'description' => 'Add school-wide events, track upcoming dates, and keep the academic calendar visible for everyone.',
            ],
        };
    }
}

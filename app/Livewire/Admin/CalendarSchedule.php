<?php

namespace App\Livewire\Admin;

use App\Models\Event;
use App\Models\Post;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CalendarSchedule extends Component implements HasForms
{
    use InteractsWithForms;

    public $title, $start_date, $end_date;

    public $events = [];

    public function mount()
    {
        $this->loadEvents();
    }

    public function loadEvents()
    {
        $this->events = Event::get()->map(
            function($event) {
                return [
                    'title' => $event->title,
                    'start' => Carbon::parse($event->start_date),
                    'end' => Carbon::parse($event->end_date),
                ];
            }
        );;
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
              Fieldset::make('EVENT INFORMATION')->schema([
                TextInput::make('title')->required(),
                DatePicker::make('start_date')->required(),
                DatePicker::make('end_date')->required(),
              ])->columns(1)
            ]);
    }

    public function saveEvent(){
        Event::create([
            'title' => $this->title,
            'start_date' => Carbon::parse($this->start_date),
            'end_date' => Carbon::parse($this->end_date),
        ]);
        return redirect()->route('admin.calendar');
    }


    public function render()
    {
        return view('livewire.admin.calendar-schedule');
    }
}

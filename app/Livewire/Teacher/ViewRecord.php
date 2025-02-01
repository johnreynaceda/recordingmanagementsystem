<?php

namespace App\Livewire\Teacher;

use App\Models\AttendanceRecord;
use App\Models\Section;
use Livewire\Component;

class ViewRecord extends Component
{
    public $date, $section_id;
    public function render()
    {
        return view('livewire.teacher.view-record',[
           'sections' => Section::where('staff_id', auth()->user()->staff->id)->get(),
           'attendances' => AttendanceRecord::when($this->date, function($record){
             return $record->whereDate('created_at', $this->date);
           })->when($this->section_id, function($section){
             return $section->whereHas('studentRecord', function($student){
                return $student->where('section_id', $this->section_id);
             });
           })->get(),
        ]);
    }
}

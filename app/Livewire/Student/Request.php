<?php

namespace App\Livewire\Student;

use App\Models\AcademicYear;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\Request as Requesst;
use Livewire\Component;

class Request extends Component
{
    public $name;
    public $email_address;
    public $phone_number;
    public $option;
    public $additional_information;
    public $showModal = false;
    public $selected_academic_year_id;

    public function mount()
    {
        $this->selected_academic_year_id = AcademicYear::getActiveYearId();
    }

    public function updatedSelectedAcademicYearId()
    {
        // Livewire will automatically re-render due to property change
    }

    public function render()
    {
        $requests = Requesst::where('user_id', Auth::id())
            ->when($this->selected_academic_year_id, function($query) {
                $query->where('academic_year_id', $this->selected_academic_year_id);
            })
            ->orderByDesc('created_at')
            ->get();

        return view('livewire.student.request', [
            'requests' => $requests,
            'academic_years' => AcademicYear::orderByDesc('is_active')->orderBy('name', 'desc')->get(),
        ]);
    }

    public function save()
    {
        $this->name = Auth::user()->name;

        $this->validate([
            'name' => 'required|string|max:255',
            'email_address' => 'required|email',
            'phone_number' => 'required|string|max:15',
            'option' => 'required|string',
            'additional_information' => 'nullable|string|max:500',
        ]);

        Requesst::create([
            'name' => $this->name,
            'user_id' => Auth::id(),
            'email_address' => $this->email_address,
            'phone_number' => $this->phone_number,
            'option' => $this->option,
            'additional_information' => $this->additional_information,
            'academic_year_id' => AcademicYear::getActiveYearId(),
        ]);

        Notification::create([
            'student_id' => auth()->user()->student->id,
            'message' => $this->name . ' has submitted a new  request of ' . $this->option . '.',
        ]);

        flash()->success('Your request has been submitted successfully!');

        $this->reset();
    }
}

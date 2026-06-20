<?php

namespace App\Livewire\Student;

use App\Models\AcademicYear;
use App\Models\Notification;
use App\Models\Section;
use App\Models\StudentRecord;
use Illuminate\Support\Facades\Auth;
use App\Models\Request as Requesst;
use Livewire\Component;

class Request extends Component
{
    public $name;
    public $email_address;
    public $phone_number;
    public $option;
    public $last_year_attended_id;
    public $section_id;
    public $additional_information;
    public $showModal = false;
    public $selected_academic_year_id;

    public function mount()
    {
        $this->selected_academic_year_id = AcademicYear::getActiveYearId();
        $this->name = Auth::user()->name;
        $this->email_address = Auth::user()->email;
    }

    public function updatedSelectedAcademicYearId()
    {
        // Livewire will automatically re-render due to property change
    }

    public function updatedLastYearAttendedId()
    {
        $this->section_id = null;
    }

    public function render()
    {
        $student = Auth::user()->student;
        $studentRecords = StudentRecord::where('student_id', $student?->id)
            ->with(['academicYear', 'section'])
            ->get();

        $requestAcademicYears = AcademicYear::whereIn('id', $studentRecords->pluck('academic_year_id')->filter()->unique())
            ->orderByDesc('is_active')
            ->orderBy('name', 'desc')
            ->get();

        if ($requestAcademicYears->isEmpty()) {
            $requestAcademicYears = AcademicYear::orderByDesc('is_active')->orderBy('name', 'desc')->get();
        }

        $sectionIds = $studentRecords
            ->when($this->last_year_attended_id, fn($records) => $records->where('academic_year_id', $this->last_year_attended_id))
            ->pluck('section_id')
            ->filter()
            ->unique();

        $sections = Section::whereIn('id', $sectionIds)->orderBy('name')->get();
        if ($sections->isEmpty()) {
            $sections = Section::orderBy('name')->get();
        }

        $requests = Requesst::where('user_id', Auth::id())
            ->with(['lastYearAttended', 'section'])
            ->when($this->selected_academic_year_id, function($query) {
                $query->where('academic_year_id', $this->selected_academic_year_id);
            })
            ->orderByDesc('created_at')
            ->get();

        return view('livewire.student.request', [
            'requests' => $requests,
            'academic_years' => AcademicYear::orderByDesc('is_active')->orderBy('name', 'desc')->get(),
            'request_academic_years' => $requestAcademicYears,
            'sections' => $sections,
            'total_requests' => $requests->count(),
            'pending_requests' => $requests->whereNotIn('status', ['approved', 'declined'])->count(),
            'approved_requests' => $requests->where('status', 'approved')->count(),
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
            'last_year_attended_id' => 'required|exists:academic_years,id',
            'section_id' => 'required|exists:sections,id',
            'additional_information' => 'nullable|string|max:500',
        ]);

        Requesst::create([
            'name' => $this->name,
            'user_id' => Auth::id(),
            'email_address' => $this->email_address,
            'phone_number' => $this->phone_number,
            'option' => $this->option,
            'last_year_attended_id' => $this->last_year_attended_id,
            'section_id' => $this->section_id,
            'additional_information' => $this->additional_information,
            'academic_year_id' => AcademicYear::getActiveYearId(),
        ]);

        Notification::create([
            'student_id' => auth()->user()->student->id,
            'message' => $this->name . ' has submitted a new request of ' . $this->option . '.',
        ]);

        flash()->success('Your request has been submitted successfully!');

        $this->reset(['phone_number', 'option', 'last_year_attended_id', 'section_id', 'additional_information', 'showModal']);
        $this->name = Auth::user()->name;
        $this->email_address = Auth::user()->email;
    }
}

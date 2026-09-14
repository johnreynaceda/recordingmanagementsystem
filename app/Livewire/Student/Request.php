<?php

namespace App\Livewire\Student;

use App\Models\AcademicYear;
use App\Models\Notification;
use App\Models\Request as Requesst;
use App\Models\Section;
use App\Models\StudentRecord;
use Illuminate\Support\Facades\Auth;
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
        $this->fillContactDetailsFromStudent();
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
            ->when($this->last_year_attended_id, fn ($records) => $records->where('academic_year_id', $this->last_year_attended_id))
            ->pluck('section_id')
            ->filter()
            ->unique();

        $sections = Section::whereIn('id', $sectionIds)->orderBy('name')->get();
        if ($sections->isEmpty()) {
            $sections = Section::orderBy('name')->get();
        }

        $requests = Requesst::where('user_id', Auth::id())
            ->with(['lastYearAttended', 'section'])
            ->when($this->selected_academic_year_id, function ($query) {
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
        $this->fillContactDetailsFromStudent();

        $this->validate([
            'name' => 'required|string|max:255',
            'email_address' => 'required|email',
            'phone_number' => ['required', 'digits:10'],
            'option' => 'required|string',
            'last_year_attended_id' => 'required|exists:academic_years,id',
            'section_id' => 'required|exists:sections,id',
            'additional_information' => 'nullable|string|max:500',
        ], [
            'phone_number.digits' => 'The phone number must contain exactly 10 digits after +63.',
        ]);

        Requesst::create([
            'name' => $this->name,
            'user_id' => Auth::id(),
            'email_address' => $this->email_address,
            'phone_number' => '+63'.$this->phone_number,
            'option' => $this->option,
            'last_year_attended_id' => $this->last_year_attended_id,
            'section_id' => $this->section_id,
            'additional_information' => $this->additional_information,
            'academic_year_id' => AcademicYear::getActiveYearId(),
        ]);

        Notification::create([
            'student_id' => auth()->user()->student->id,
            'message' => $this->name.' has submitted a new request of '.$this->option.'.',
        ]);

        sweetalert()->success('Your request has been submitted successfully!');

        $this->reset(['option', 'last_year_attended_id', 'section_id', 'additional_information', 'showModal']);
        $this->name = Auth::user()->name;
        $this->fillContactDetailsFromStudent();
    }

    private function fillContactDetailsFromStudent(): void
    {
        $user = Auth::user();

        $this->email_address = $user?->email;
        $this->phone_number = $this->localContactNumber($user?->student?->contact_number);
    }

    public function formatContactNumber(?string $number): string
    {
        $localNumber = $this->localContactNumber($number);

        if (! $localNumber || strlen($localNumber) !== 10) {
            return $localNumber ?? '';
        }

        return substr($localNumber, 0, 3).'-'.substr($localNumber, 3, 3).'-'.substr($localNumber, 6, 4);
    }

    private function localContactNumber(?string $number): ?string
    {
        if (! filled($number)) {
            return null;
        }

        $digits = preg_replace('/\D/', '', $number);

        if (str_starts_with($digits, '63') && strlen($digits) === 12) {
            return substr($digits, 2);
        }

        if (str_starts_with($digits, '0') && strlen($digits) === 11) {
            return substr($digits, 1);
        }

        return $digits;
    }
}

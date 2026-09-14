<?php

namespace App\Livewire\Auth;

use App\Models\AcademicYear;
use App\Models\Student;
use App\Models\StudentRecord;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class StudentSelfEnrollment extends Component
{
    public string $firstname = '';

    public string $middlename = '';

    public string $lastname = '';

    public string $birthdate = '';

    public string $address = '';

    public string $contact_number = '';

    public string $parent_name = '';

    public string $parent_contact = '';

    public string $lrn = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function enroll(): mixed
    {
        $this->firstname = $this->normalizeName($this->firstname) ?? '';
        $this->middlename = $this->normalizeName($this->middlename) ?? '';
        $this->lastname = $this->normalizeName($this->lastname) ?? '';
        $this->parent_name = $this->normalizeName($this->parent_name) ?? '';
        $this->email = strtolower(trim($this->email));

        $validated = $this->validate([
            'firstname' => ['required', 'string', 'max:50'],
            'middlename' => ['nullable', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:50'],
            'birthdate' => ['required', 'date', 'before_or_equal:'.now()->subYears(12)->toDateString()],
            'address' => ['required', 'string', 'max:100'],
            'contact_number' => ['required', 'digits:10'],
            'parent_name' => ['required', 'string', 'max:100'],
            'parent_contact' => ['required', 'digits:10'],
            'lrn' => ['required', 'digits:12', 'unique:students,lrn'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'max:16', Password::min(8)],
        ], [
            'birthdate.before_or_equal' => 'The student must be at least 12 years old.',
            'contact_number.digits' => 'Enter the 10-digit mobile number after +63.',
            'parent_contact.digits' => 'Enter the 10-digit parent or guardian mobile number after +63.',
            'lrn.digits' => 'The LRN must contain exactly 12 digits.',
            'lrn.unique' => 'This LRN is already enrolled.',
        ]);

        DB::transaction(function () use ($validated): void {
            $user = User::create([
                'name' => $validated['firstname'].' '.$validated['lastname'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'password_changed_at' => now(),
                'user_type' => 'student',
            ]);

            $student = Student::create([
                'firstname' => $validated['firstname'],
                'middlename' => $validated['middlename'] ?: null,
                'lastname' => $validated['lastname'],
                'birthdate' => $validated['birthdate'],
                'address' => trim($validated['address']),
                'contact_number' => '+63'.$validated['contact_number'],
                'parent_name' => $validated['parent_name'],
                'parent_contact' => '+63'.$validated['parent_contact'],
                'lrn' => $validated['lrn'],
                'user_id' => $user->id,
            ]);

            StudentRecord::create([
                'student_id' => $student->id,
                'grade_level_id' => null,
                'section_id' => null,
                'academic_year_id' => AcademicYear::getActiveYearId(),
                'is_active' => true,
            ]);
        });

        sweetalert()->success('Successfully submitted');

        return redirect()->route('student-login');
    }

    public function render(): View
    {
        return view('livewire.auth.student-self-enrollment')
            ->layout('layouts.guest', ['wide' => true]);
    }

    private function normalizeName(?string $value): ?string
    {
        $value = preg_replace('/\s+/', ' ', trim($value ?? ''));

        return $value === '' ? null : ucwords(strtolower($value));
    }
}

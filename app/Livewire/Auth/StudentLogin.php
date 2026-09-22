<?php

namespace App\Livewire\Auth;

use App\Models\Student;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;

class StudentLogin extends Component implements HasForms
{
    use InteractsWithForms;

    public string $lrn = '';

    public string $password = '';

    public bool $remember = false;

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('lrn')
                ->label('Email or LRN')
                ->required()
                ->placeholder('Enter your email or 12-digit LRN')
                ->helperText('Use the email address linked to your account or your 12-digit LRN.')
                ->maxLength(255)
                ->autocomplete('username'),
            TextInput::make('password')
                ->required()
                ->password()
                ->revealable()
                ->autocomplete('current-password'),
        ]);
    }

    public function login(): mixed
    {
        $this->validate([
            'lrn' => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $identifier = trim((string) $value);

                    if (! filter_var($identifier, FILTER_VALIDATE_EMAIL)
                        && preg_match('/^\d{12}$/', $identifier) !== 1) {
                        $fail('Enter a valid email address or a 12-digit LRN.');
                    }
                },
            ],
            'password' => ['required', 'string'],
        ]);

        $identifier = trim($this->lrn);

        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $user = User::query()
                ->with('student')
                ->where('user_type', 'student')
                ->whereRaw('LOWER(email) = ?', [Str::lower($identifier)])
                ->first();
            $student = $user?->student;
        } else {
            $student = Student::query()
                ->with('user')
                ->where('lrn', $identifier)
                ->first();
            $user = $student?->user;
        }

        if (! $student || ! $user || ! Auth::attempt([
            'id' => $user->id,
            'password' => $this->password,
        ], $this->remember)) {
            sweetalert()->error('Invalid email, LRN, or password.');
            $this->reset('lrn', 'password');

            return null;
        }

        if (request()->hasSession()) {
            request()->session()->regenerate();
        }

        $user = Auth::user();

        if ($user->user_type !== 'student' || ! $user->student) {
            Auth::logout();
            if (request()->hasSession()) {
                request()->session()->invalidate();
                request()->session()->regenerateToken();
            }
            sweetalert()->error('Only students can access the student portal.');
            $this->reset('lrn', 'password');

            return null;
        }

        if ($user->student->status === 'Rejected') {
            Auth::logout();
            if (request()->hasSession()) {
                request()->session()->invalidate();
                request()->session()->regenerateToken();
            }
            sweetalert()->error('Your student registration was rejected. Please contact the school for assistance.');
            $this->reset('lrn', 'password');

            return null;
        }

        $hasUnassignedPlacement = $user->student->studentRecords()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('grade_level_id')
                    ->orWhereNull('section_id');
            })
            ->exists();

        if ($hasUnassignedPlacement) {
            Auth::logout();
            if (request()->hasSession()) {
                request()->session()->invalidate();
                request()->session()->regenerateToken();
            }
            sweetalert()->warning('Your enrollment is awaiting grade level and section assignment. Please contact the school.');
            $this->reset('lrn', 'password');

            return null;
        }

        if ($user->password_changed_at === null) {
            $status = Password::sendResetLink(['email' => $user->email]);

            Auth::logout();

            if (request()->hasSession()) {
                request()->session()->invalidate();
                request()->session()->regenerateToken();
            }

            $message = $status === Password::RESET_LINK_SENT
                ? 'A password change link has been sent to your email address.'
                : __($status);

            return redirect()->route('student-login')->with(
                $status === Password::RESET_LINK_SENT ? 'status' : 'error',
                $message,
            );
        }

        return redirect()->route('student.index');
    }

    public function render(): View
    {
        return view('livewire.auth.student-login')->layout('layouts.guest');
    }
}

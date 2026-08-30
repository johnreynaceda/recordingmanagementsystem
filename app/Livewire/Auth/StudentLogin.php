<?php

namespace App\Livewire\Auth;

use App\Models\Student;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
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
                ->label('LRN')
                ->required()
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
            'lrn' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string'],
        ]);

        $student = Student::query()
            ->with('user')
            ->where('lrn', trim($this->lrn))
            ->first();

        if (! $student?->user || ! Auth::attempt([
            'id' => $student->user_id,
            'password' => $this->password,
        ], $this->remember)) {
            sweetalert()->error('Invalid LRN or password.');
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

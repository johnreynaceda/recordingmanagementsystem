<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;

class StudentLogin extends Component implements HasForms
{
    use InteractsWithForms;
    public string $email = '';
    public string $password = '';
    public string $error = '';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->required()->email(),
                TextInput::make('password')
                    ->required()
                    ->password()->revealable(),
            ]);
    }



    public function login()
    {
        sleep(1);
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            sweetalert()->error('Invalid email or password.');
            $this->reset('email', 'password');
            return;
        }

        $user = Auth::user();

        // 🚫 Only allow users who are students
        if (! $user->student) {
            Auth::logout();
            sweetalert()->error('Only students can access the student portal.');
            $this->reset('email', 'password');
            return;
        }

        // ✅ Student verified
        return redirect()->route('student.index');
    }

    public function render()
    {
        return view('livewire.auth.student-login')->layout('layouts.guest');
    }
}

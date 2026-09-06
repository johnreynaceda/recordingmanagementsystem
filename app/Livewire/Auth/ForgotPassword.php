<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPassword extends Component
{
    public string $email = '';

    public string $portal = '';

    public function mount(): void
    {
        $this->portal = request()->query('portal') === 'staff' ? 'staff' : '';
    }

    public function sendResetLink()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink([
            'email' => $this->email,
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('status', __($status));
            $this->reset('email');
        } else {
            $this->addError('email', __($status));
        }
    }
    public function render()
    {
        return view('livewire.auth.forgot-password')->layout('layouts.guest');
    }
}

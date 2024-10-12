<?php

namespace App\Livewire\Teacher;

use App\Models\Staff;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Profile extends Component
{
    use WireUiActions;

    public $record;
    public $firstname;
    public $lastname;
    public $address;
    public $showModal = false;

    public function mount()
    {

        $this->record = Staff::where('user_id', auth()->user()->id)->first();
        $this->firstname = $this->record->firstname;
        $this->lastname = $this->record->lastname;
        $this->address = $this->record->address;
    }

    public function render()
    {
        return view('livewire.teacher.profile');
    }

    public function update()
    {
        $this->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);


        $this->record->update([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'address' => $this->address,
        ]);


        session()->flash('message', 'Profile updated successfully.');

        $this->showModal = false;
    }
}

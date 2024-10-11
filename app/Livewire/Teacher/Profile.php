<?php

namespace App\Livewire\Teacher;

use App\Models\Staff;
use Livewire\Component;

class Profile extends Component
{
    public function render()
    {
        return view('livewire.teacher.profile',[
            'record' => Staff::where('user_id', auth()->user()->id)->first(),
        ]);
    }
}

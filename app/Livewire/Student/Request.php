<?php

namespace App\Livewire\Student;

use Illuminate\Support\Facades\Auth;
use App\Models\Request as Requesst;
use Livewire\Component;
use PHPFlasher\Laravel\Flasher;

class Request extends Component
{
    public $name;
    public $email_address;
    public $phone_number;
    public $option;
    public $additional_information;
    public $showModal = false;
    public function render()
    {

        $requests = Requesst::where('user_id', Auth::id())->get();

        return view('livewire.student.request', [
            'requests' => $requests,
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
            'name' =>$this->name,
            'user_id' => Auth::id(),
            'email_address' => $this->email_address,
            'phone_number' => $this->phone_number,
            'option' => $this->option,
            'additional_information' => $this->additional_information,
        ]);


        flash()->success('Your request has been submitted successfully!');


        $this->reset();
    }
}

<?php

namespace App\Livewire\Admin;

use App\Models\Request as Requesst;
use Livewire\Component;
use Livewire\WithPagination;

class Request extends Component
{
    use WithPagination;

    public function render()
    {
        $requests = Requesst::orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.request', [
            'requests' => $requests,
        ]);
    }
}

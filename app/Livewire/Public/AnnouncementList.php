<?php

namespace App\Livewire\Public;

use Livewire\Component;

class AnnouncementList extends Component
{
    public function render()
    {
        return view('livewire.public.announcement-list', [
            'announcements' => \App\Models\Announcement::where('is_active', true)->latest()->get(),
        ]);
    }
}

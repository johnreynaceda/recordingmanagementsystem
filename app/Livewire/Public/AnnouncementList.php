<?php

namespace App\Livewire\Public;

use Livewire\Component;

class AnnouncementList extends Component
{
    public int $perPage = 6;

    public function loadMore(): void
    {
        $this->perPage += 6;
    }

    public function render()
    {
        $activeAnnouncements = \App\Models\Announcement::query()
            ->where('is_active', true)
            ->orderByDesc('created_at')
            ->orderByDesc('id');

        $featured = (clone $activeAnnouncements)->first();

        $remainingAnnouncements = (clone $activeAnnouncements)
            ->when($featured, fn ($query) => $query->whereKeyNot($featured->getKey()))
            ->take($this->perPage + 1)
            ->get();

        $hasMore = $remainingAnnouncements->count() > $this->perPage;

        return view('livewire.public.announcement-list', [
            'featured' => $featured,
            'announcements' => $remainingAnnouncements->take($this->perPage),
            'hasMore' => $hasMore,
        ]);
    }
}

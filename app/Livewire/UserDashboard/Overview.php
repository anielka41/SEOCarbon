<?php

declare(strict_types=1);

namespace App\Livewire\UserDashboard;

use App\Domain\Directory\Models\DirectoryEntry;
use App\Enums\EntryStatus;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.dashboard')]
#[Title('Overview')]
class Overview extends Component
{
    public function render(Guard $guard, Factory $factory): View
    {
        $user = $guard->user();

        $recentEntries = DirectoryEntry::query()
            ->whereBelongsTo($user)
            ->with('category:id,name')
            ->latest()
            ->limit(5)
            ->get();

        return $factory->make('livewire.user-dashboard.overview', [
            'activeEntriesCount' => DirectoryEntry::query()
                ->whereBelongsTo($user)
                ->where('status', EntryStatus::Published->value)
                ->count(),
            'pendingEntriesCount' => DirectoryEntry::query()
                ->whereBelongsTo($user)
                ->where('status', EntryStatus::Pending->value)
                ->count(),
            'promotedEntriesCount' => DirectoryEntry::query()
                ->whereBelongsTo($user)
                ->where('is_promoted', true)
                ->count(),
            'recentEntries' => $recentEntries,
        ]);
    }
}

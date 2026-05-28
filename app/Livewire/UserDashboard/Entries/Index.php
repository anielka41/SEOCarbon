<?php

declare(strict_types=1);

namespace App\Livewire\UserDashboard\Entries;

use App\Domain\Directory\Models\DirectoryEntry;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
#[Title('My Entries')]
final class Index extends Component
{
    use WithPagination;

    public function render(Factory $factory, Guard $guard): View
    {
        return $factory->make('livewire.user-dashboard.entries.index', [
            'entries' => DirectoryEntry::query()
                ->whereBelongsTo($guard->user())
                ->with(['category:id,name', 'package:id,name', 'user:id,name'])
                ->latest()
                ->paginate(10),
        ]);
    }
}

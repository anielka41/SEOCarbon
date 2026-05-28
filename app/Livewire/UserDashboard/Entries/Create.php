<?php

declare(strict_types=1);

namespace App\Livewire\UserDashboard\Entries;

use App\Domain\Directory\Models\DirectoryCategory;
use App\Domain\Directory\Models\DirectoryEntry;
use App\Domain\Directory\Models\DirectoryGroup;
use App\Enums\EntryStatus;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.dashboard')]
#[Title('Create Entry')]
final class Create extends Component
{
    public ?int $categoryId = null;

    public ?int $packageId = null;

    public string $name = '';

    public string $slug = '';

    public string $url = '';

    public string $description = '';

    public function updatedName(string $value): void
    {
        if ($this->slug === '') {
            $this->slug = Str::slug($value);
        }
    }

    public function save(): void
    {
        $this->authorizeCreate();

        $validated = $this->validate([
            'categoryId' => ['required', 'integer', Rule::exists('directory_categories', 'id')],
            'packageId' => ['nullable', 'integer', Rule::exists('directory_groups', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('directory_entries', 'slug')],
            'url' => ['required', 'url:http,https', 'max:2048', Rule::unique('directory_entries', 'url')],
            'description' => ['required', 'string', 'max:5000'],
        ]);

        $group = $validated['packageId'] ? DirectoryGroup::query()->find($validated['packageId']) : null;

        DirectoryEntry::query()->create([
            'category_id' => $validated['categoryId'],
            'package_id' => $validated['packageId'],
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'url' => $validated['url'],
            'description' => $validated['description'],
            'status' => $group?->auto_approve ? EntryStatus::Published : EntryStatus::Pending,
            'is_promoted' => false,
            'expires_at' => $group?->duration_days ? now()->addDays($group->duration_days) : now()->addYear(),
        ]);

        $this->redirectRoute('dashboard.entries.index', navigate: true);
    }

    public function render(Factory $factory): View
    {
        return $factory->make('livewire.user-dashboard.entries.create', [
            'categories' => DirectoryCategory::query()
                ->where('type', 'directory')
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(['id', 'name']),
            'groups' => DirectoryGroup::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(['id', 'name', 'is_paid', 'price_net_amount', 'currency']),
        ]);
    }

    private function authorizeCreate(): void
    {
        abort_unless(Auth::user()?->exists, 403);
    }
}

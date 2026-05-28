<?php

declare(strict_types=1);

namespace App\Livewire\UserDashboard\Entries;

use App\Domain\Directory\Models\DirectoryCategory;
use App\Domain\Directory\Models\DirectoryEntry;
use App\Domain\Directory\Models\DirectoryGroup;
use App\Enums\EntryStatus;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.dashboard')]
#[Title('Edit Entry')]
final class Edit extends Component
{
    private DirectoryEntry $entry;

    public ?int $categoryId = null;

    public ?int $packageId = null;

    public string $name = '';

    public string $slug = '';

    public string $url = '';

    public string $description = '';

    public function mount(DirectoryEntry $directoryEntry): void
    {
        $this->authorize('update', $directoryEntry);

        $this->entry = $directoryEntry;
        $this->categoryId = $directoryEntry->category_id;
        $this->packageId = $directoryEntry->package_id;
        $this->name = $directoryEntry->name;
        $this->slug = $directoryEntry->slug;
        $this->url = $directoryEntry->url;
        $this->description = $directoryEntry->description;
    }

    public function updatedName(string $value): void
    {
        if ($this->slug === $this->entry->slug) {
            $this->slug = Str::slug($value);
        }
    }

    public function save(): void
    {
        $validated = $this->validate([
            'categoryId' => ['required', 'integer', Rule::exists('directory_categories', 'id')],
            'packageId' => ['nullable', 'integer', Rule::exists('directory_groups', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('directory_entries', 'slug')->ignore($this->entry->id)],
            'url' => ['required', 'url:http,https', 'max:2048', Rule::unique('directory_entries', 'url')->ignore($this->entry->id)],
            'description' => ['required', 'string', 'max:5000'],
        ]);

        $group = $validated['packageId'] ? DirectoryGroup::query()->find($validated['packageId']) : null;

        $this->entry->update([
            'category_id' => $validated['categoryId'],
            'package_id' => $validated['packageId'],
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'url' => $validated['url'],
            'description' => $validated['description'],
            'status' => $this->entry->status instanceof EntryStatus ? $this->entry->status : EntryStatus::Pending,
            'expires_at' => $group?->duration_days ? now()->addDays($group->duration_days) : $this->entry->expires_at,
        ]);

        $this->redirectRoute('dashboard.entries.index', navigate: true);
    }

    public function render(Factory $factory): View
    {
        return $factory->make('livewire.user-dashboard.entries.edit', [
            'entry' => $this->entry,
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
}

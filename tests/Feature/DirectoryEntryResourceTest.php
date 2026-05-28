<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Directory\Models\DirectoryCategory;
use App\Domain\Directory\Models\DirectoryEntry;
use App\Domain\Users\Models\User;
use App\Filament\Resources\Directory\DirectoryEntries\Pages\ListDirectoryEntries;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DirectoryEntryResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->admin()->create();
        $this->actingAs($user);
    }

    public function test_can_render_page(): void
    {
        Livewire::test(ListDirectoryEntries::class)
            ->assertSuccessful();
    }

    public function test_can_list_listings(): void
    {
        $directoryCategory = DirectoryCategory::factory()->create();
        $directoryEntrys = DirectoryEntry::factory()->count(5)->create([
            'category_id' => $directoryCategory->id,
            'user_id' => auth()->id(),
        ]);

        Livewire::test(ListDirectoryEntries::class)
            ->assertCanSeeTableRecords($directoryEntrys);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature\Directory;

use App\Domain\Directory\Actions\VerifyBacklinkAction;
use App\Domain\Directory\Enums\BacklinkCheckStatus;
use App\Domain\Directory\Models\DirectoryCategory;
use App\Domain\Directory\Models\DirectoryEntry;
use App\Domain\Directory\Models\DirectoryGroup;
use App\Domain\Users\Models\User;
use App\Enums\EntryStatus;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class VerifyBacklinkActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_verifies_backlink_successfully(): void
    {
        Http::fake([
            'example.com/*' => Http::response('<html><body><a href="'.App::make(Repository::class)->get('app.url').'">Backlink</a></body></html>', 200),
        ]);

        $category = DirectoryCategory::factory()->create(['type' => 'directory']);
        $group = DirectoryGroup::factory()->create(['requires_backlink' => true]);
        $user = User::factory()->create();

        $directoryEntry = DirectoryEntry::query()->create([
            'category_id' => $category->id,
            'package_id' => $group->id,
            'user_id' => $user->id,
            'name' => 'Test Entry',
            'slug' => 'test-entry',
            'url' => 'https://example.com',
            'backlink_url' => 'https://example.com/backlink',
            'description' => 'Test description',
            'status' => EntryStatus::Published,
        ]);

        $verifyBacklinkAction = App::make(VerifyBacklinkAction::class);
        $backlinkCheck = $verifyBacklinkAction->execute($directoryEntry);

        $this->assertEquals(BacklinkCheckStatus::Success, $backlinkCheck->status);
        $this->assertNotNull($directoryEntry->fresh()->backlink_verified_at);
        $this->assertDatabaseHas('backlink_checks', [
            'directory_entry_id' => $directoryEntry->id,
            'status' => BacklinkCheckStatus::Success->value,
        ]);
    }

    public function test_it_fails_when_backlink_is_missing(): void
    {
        Http::fake([
            'example.com/*' => Http::response('<html><body>No backlink here</body></html>', 200),
        ]);

        $category = DirectoryCategory::factory()->create(['type' => 'directory']);
        $group = DirectoryGroup::factory()->create(['requires_backlink' => true]);
        $user = User::factory()->create();

        $directoryEntry = DirectoryEntry::query()->create([
            'category_id' => $category->id,
            'package_id' => $group->id,
            'user_id' => $user->id,
            'name' => 'Test Entry',
            'slug' => 'test-entry',
            'url' => 'https://example.com',
            'backlink_url' => 'https://example.com/backlink',
            'description' => 'Test description',
            'status' => EntryStatus::Published,
        ]);

        $verifyBacklinkAction = App::make(VerifyBacklinkAction::class);
        $backlinkCheck = $verifyBacklinkAction->execute($directoryEntry);

        $this->assertEquals(BacklinkCheckStatus::Failed, $backlinkCheck->status);
        $this->assertNull($directoryEntry->fresh()->backlink_verified_at);
    }
}

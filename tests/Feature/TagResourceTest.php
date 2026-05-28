<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Blog\Models\Tag;
use App\Domain\Users\Models\User;
use App\Filament\Resources\Blog\Tags\Pages\ListTags;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TagResourceTest extends TestCase
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
        Livewire::test(ListTags::class)
            ->assertSuccessful();
    }

    public function test_can_list_tags(): void
    {
        $tags = Tag::factory()->count(5)->create();

        Livewire::test(ListTags::class)
            ->assertCanSeeTableRecords($tags);
    }
}

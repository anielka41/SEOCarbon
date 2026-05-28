<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Blog\Models\Post;
use App\Domain\Directory\Models\DirectoryCategory;
use App\Domain\Users\Models\User;
use App\Filament\Resources\Blog\Posts\Pages\ListPosts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PostResourceTest extends TestCase
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
        Livewire::test(ListPosts::class)
            ->assertSuccessful();
    }

    public function test_can_list_posts(): void
    {
        $directoryCategory = DirectoryCategory::factory()->create();
        $posts = Post::factory()->count(5)->create([
            'category_id' => $directoryCategory->id,
            'user_id' => auth()->id(),
        ]);

        Livewire::test(ListPosts::class)
            ->assertCanSeeTableRecords($posts);
    }
}

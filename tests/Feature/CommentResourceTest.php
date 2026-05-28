<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Blog\Models\PostComment;
use App\Domain\Users\Models\User;
use App\Filament\Resources\Blog\Comments\Pages\ListComments;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CommentResourceTest extends TestCase
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
        Livewire::test(ListComments::class)
            ->assertSuccessful();
    }

    public function test_can_list_comments(): void
    {
        $comments = PostComment::factory()->count(5)->create();

        Livewire::test(ListComments::class)
            ->assertCanSeeTableRecords($comments);
    }
}

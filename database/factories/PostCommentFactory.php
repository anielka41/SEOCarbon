<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domain\Blog\Models\PostComment;
use App\Domain\Directory\Models\DirectoryEntry;
use App\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Override;

/**
 * @extends Factory<PostComment>
 */
class PostCommentFactory extends Factory
{
    #[Override]
    protected $model = PostComment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'commentable_id' => DirectoryEntry::factory(),
            'commentable_type' => DirectoryEntry::class,
            'content' => fake()->paragraph(),
            'rating' => fake()->numberBetween(1, 5),
            'is_approved' => true,
        ];
    }
}

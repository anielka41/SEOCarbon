<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domain\Blog\Models\Post;
use App\Domain\Directory\Models\DirectoryCategory;
use App\Domain\Users\Models\User;
use App\Enums\EntryStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Override;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    #[Override]
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'user_id' => User::factory(),
            'category_id' => DirectoryCategory::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->paragraphs(3, true),
            'status' => EntryStatus::Published,
            'published_at' => now(),
        ];
    }
}

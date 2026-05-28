<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domain\Directory\Models\DirectoryCategory;
use App\Domain\Directory\Models\DirectoryEntry;
use App\Domain\Users\Models\User;
use App\Enums\EntryStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Override;

/**
 * @extends Factory<DirectoryEntry>
 */
class DirectoryEntryFactory extends Factory
{
    #[Override]
    protected $model = DirectoryEntry::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->company().' '.fake()->unique()->word();

        return [
            'category_id' => DirectoryCategory::factory(),
            'user_id' => User::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'url' => fake()->unique()->url(),
            'description' => fake()->sentence(),
            'content' => fake()->paragraphs(2, true),
            'contact_email' => fake()->safeEmail(),
            'status' => EntryStatus::Published,
            'is_promoted' => false,
            'verified_at' => now(),
            'expires_at' => now()->addYear(),
        ];
    }
}

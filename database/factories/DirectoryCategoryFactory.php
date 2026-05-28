<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domain\Directory\Models\DirectoryCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Override;

/**
 * @extends Factory<DirectoryCategory>
 */
class DirectoryCategoryFactory extends Factory
{
    #[Override]
    protected $model = DirectoryCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}

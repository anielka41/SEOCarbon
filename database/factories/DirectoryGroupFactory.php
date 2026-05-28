<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domain\Directory\Models\DirectoryGroup;
use Illuminate\Database\Eloquent\Factories\Factory;
use Override;

/**
 * @extends Factory<DirectoryGroup>
 */
class DirectoryGroupFactory extends Factory
{
    #[Override]
    protected $model = DirectoryGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'slug' => fake()->slug(),
            'description' => fake()->sentence(),
            'price_net_amount' => fake()->numberBetween(0, 10000),
            'currency' => 'PLN',
            'vat_rate' => 2300,
            'is_paid' => fake()->boolean(),
            'duration_days' => 30,
            'can_upload_logo' => fake()->boolean(),
            'can_upload_thumbnail' => fake()->boolean(),
            'can_add_backlink' => fake()->boolean(),
            'requires_backlink' => fake()->boolean(),
            'auto_approve' => fake()->boolean(),
            'max_images' => 1,
            'max_links' => 1,
            'is_promoted' => fake()->boolean(),
            'max_tags' => 3,
            'is_active' => true,
            'sort_order' => 0,
            'sort_boost' => 0,
        ];
    }
}

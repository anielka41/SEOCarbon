<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domain\Directory\Models\DirectoryField;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Override;

/**
 * @extends Factory<DirectoryField>
 */
class DirectoryFieldFactory extends Factory
{
    #[Override]
    protected $model = DirectoryField::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->word();

        return [
            'name' => $name,
            'label' => Str::title($name),
            'type' => 'text',
            'is_required' => false,
            'is_searchable' => true,
            'is_filterable' => false,
            'sort_order' => 0,
        ];
    }
}

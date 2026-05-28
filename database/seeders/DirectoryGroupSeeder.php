<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domain\Directory\Models\DirectoryGroup;
use Illuminate\Database\Seeder;

class DirectoryGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DirectoryGroup::query()->create([
            'name' => 'Free',
            'slug' => 'free',
            'price' => 0,
            'duration_days' => 30,
            'can_upload_logo' => false,
            'can_upload_thumbnail' => false,
            'can_add_backlink' => false,
            'is_promoted' => false,
            'max_tags' => 3,
            'sort_order' => 1,
        ]);

        DirectoryGroup::query()->create([
            'name' => 'Basic',
            'slug' => 'basic',
            'price' => 10,
            'duration_days' => 30,
            'can_upload_logo' => true,
            'can_upload_thumbnail' => false,
            'can_add_backlink' => true,
            'is_promoted' => false,
            'max_tags' => 5,
            'sort_order' => 2,
        ]);

        DirectoryGroup::query()->create([
            'name' => 'Premium',
            'slug' => 'premium',
            'price' => 30,
            'duration_days' => 90,
            'can_upload_logo' => true,
            'can_upload_thumbnail' => true,
            'can_add_backlink' => true,
            'is_promoted' => true,
            'max_tags' => 10,
            'sort_order' => 3,
        ]);
    }
}

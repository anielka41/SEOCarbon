<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domain\Directory\Models\DirectoryCategory;
use App\Domain\Directory\Models\DirectoryEntry;
use App\Domain\Users\Models\User;
use App\Enums\EntryStatus;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);

        /** @var User $user */
        $user = User::query()->find(1);

        $icons = ['📁', '🏢', '🛠️', '🌐', '📊', '🚀', '🎨', '📱', '🏥', '🎓'];

        foreach ($icons as $index => $icon) {
            $directoryCategory = DirectoryCategory::factory()->create([
                'type' => 'directory',
                'icon' => $icon,
                'sort_order' => $index,
            ]);

            DirectoryEntry::factory(5)->create([
                'category_id' => $directoryCategory->id,
                'user_id' => $user->id,
                'status' => EntryStatus::Published,
                'is_promoted' => ($index < 3), // First 3 categories have promoted listings
            ]);
        }

        User::factory(10)->create();
    }
}

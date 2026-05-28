<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domain\Users\Enums\UserRole;
use App\Domain\Users\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::unguard();

        /** @var User $admin */
        $admin = User::query()->updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'email_verified_at' => now(),
            ]
        );

        User::reguard();

        $admin->syncRoles([UserRole::SuperAdmin->value]);
    }
}

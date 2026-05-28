<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domain\Users\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

final class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        App::make(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (UserRole::cases() as $role) {
            $roleModel = Role::findOrCreate($role->value, 'web');
            $permissions = PermissionSeeder::permissionsByRole()[$role->value] ?? [];

            $roleModel->syncPermissions($permissions);
        }

        App::make(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}

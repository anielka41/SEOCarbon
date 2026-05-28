<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Users\Enums\UserRole;
use App\Domain\Users\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

final class SeederPermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_permission_and_role_seeders_create_expected_data(): void
    {
        $this->seed(PermissionSeeder::class);
        $this->seed(RoleSeeder::class);

        $this->assertTrue(Permission::query()->where('name', 'dashboard.access')->exists());
        $this->assertTrue(Permission::query()->where('name', 'directory.entries.approve')->exists());

        $adminRole = Role::query()->where('name', UserRole::Admin->value)->firstOrFail();

        $permissionNames = $adminRole->permissions()->pluck('name')->all();

        $this->assertContains('dashboard.access', $permissionNames);
        $this->assertContains('directory.entries.approve', $permissionNames);
        $this->assertContains('payments.manage', $permissionNames);
    }

    public function test_database_seeder_assigns_admin_role_to_admin_user(): void
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::query()->where('email', 'admin@example.com')->firstOrFail();

        $this->assertTrue($user->hasRole(UserRole::Admin->value));
    }
}

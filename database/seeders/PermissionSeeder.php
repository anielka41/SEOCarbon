<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domain\Users\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

final class PermissionSeeder extends Seeder
{
    /**
     * @return array<int, string>
     */
    public static function allPermissions(): array
    {
        return [
            'dashboard.access',
            'dashboard.entries.view-own',
            'dashboard.entries.create-own',
            'dashboard.entries.update-own',
            'dashboard.entries.feature-own',
            'dashboard.payments.view-own',
            'dashboard.notifications.view-own',
            'dashboard.profile.manage-own',
            'dashboard.privacy.manage-own',
            'blog.posts.view-any',
            'blog.posts.create',
            'blog.posts.update',
            'blog.posts.delete',
            'blog.tags.manage',
            'blog.comments.manage',
            'directory.entries.view-any',
            'directory.entries.create',
            'directory.entries.update',
            'directory.entries.delete',
            'directory.entries.approve',
            'directory.entries.reject',
            'directory.entries.feature',
            'directory.groups.manage',
            'directory.categories.manage',
            'directory.fields.manage',
            'directory.backlinks.manage',
            'payments.view',
            'payments.manage',
            'payments.refund',
            'payments.invoices.view',
            'payments.gateways.manage',
            'featured.manage',
            'media.manage',
            'search.manage',
            'seo.manage',
            'analytics.view',
            'notifications.manage',
            'moderation.manage',
            'moderation.reports.manage',
            'moderation.bans.manage',
            'moderation.captcha.manage',
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'users.roles.manage',
            'settings.manage',
            'license.manage',
            'privacy.manage',
        ];
    }

    /**
     * @return array<string, array<int, string>>
     */
    public static function permissionsByRole(): array
    {
        $ownDashboardPermissions = [
            'dashboard.access',
            'dashboard.entries.view-own',
            'dashboard.entries.create-own',
            'dashboard.entries.update-own',
            'dashboard.entries.feature-own',
            'dashboard.payments.view-own',
            'dashboard.notifications.view-own',
            'dashboard.profile.manage-own',
            'dashboard.privacy.manage-own',
        ];

        return [
            UserRole::SuperAdmin->value => self::allPermissions(),
            UserRole::Admin->value => array_values(array_unique(array_merge(
                $ownDashboardPermissions,
                [
                    'blog.posts.view-any',
                    'blog.posts.create',
                    'blog.posts.update',
                    'blog.posts.delete',
                    'blog.tags.manage',
                    'blog.comments.manage',
                    'directory.entries.view-any',
                    'directory.entries.create',
                    'directory.entries.update',
                    'directory.entries.delete',
                    'directory.entries.approve',
                    'directory.entries.reject',
                    'directory.entries.feature',
                    'directory.groups.manage',
                    'directory.categories.manage',
                    'directory.fields.manage',
                    'directory.backlinks.manage',
                    'payments.view',
                    'payments.manage',
                    'payments.refund',
                    'payments.invoices.view',
                    'featured.manage',
                    'media.manage',
                    'search.manage',
                    'seo.manage',
                    'analytics.view',
                    'notifications.manage',
                    'moderation.manage',
                    'moderation.reports.manage',
                    'moderation.bans.manage',
                    'moderation.captcha.manage',
                    'users.view',
                    'users.update',
                    'privacy.manage',
                ]
            ))),
            UserRole::Moderator->value => array_values(array_unique(['dashboard.access', 'directory.entries.view-any', 'directory.entries.update', 'directory.entries.approve', 'directory.entries.reject', 'blog.comments.manage', 'moderation.manage', 'moderation.reports.manage', 'moderation.bans.manage', 'moderation.captcha.manage', 'notifications.manage', 'analytics.view'])),
            UserRole::User->value => $ownDashboardPermissions,
        ];
    }

    public function run(): void
    {
        App::make(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (self::allPermissions() as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        App::make(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}

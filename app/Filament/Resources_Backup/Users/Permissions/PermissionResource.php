<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Permissions;

use App\Filament\Resources\Users\Permissions\Pages\CreatePermission;
use App\Filament\Resources\Users\Permissions\Pages\EditPermission;
use App\Filament\Resources\Users\Permissions\Pages\ListPermissions;
use App\Filament\Resources\Users\Permissions\Schemas\PermissionSchema;
use App\Filament\Resources\Users\Permissions\Tables\PermissionTable;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use Spatie\Permission\Models\Permission;
use UnitEnum;

final class PermissionResource extends Resource
{
    #[Override]
    protected static ?string $model = Permission::class;

    #[Override]
    protected static ?string $slug = 'permissions';

    #[Override]
    protected static ?string $recordTitleAttribute = 'name';

    #[Override]
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLockClosed;

    #[Override]
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return PermissionSchema::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return PermissionTable::configure($table);
    }

    /**
     * @return array<string, PageRegistration>
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListPermissions::route('/'),
            'create' => CreatePermission::route('/create'),
            'edit' => EditPermission::route('/{record}/edit'),
        ];
    }
}

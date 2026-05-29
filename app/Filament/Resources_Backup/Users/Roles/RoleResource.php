<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Roles;

use App\Filament\Resources\Users\Roles\Pages\CreateRole;
use App\Filament\Resources\Users\Roles\Pages\EditRole;
use App\Filament\Resources\Users\Roles\Pages\ListRoles;
use App\Filament\Resources\Users\Roles\Schemas\RoleSchema;
use App\Filament\Resources\Users\Roles\Tables\RoleTable;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use Spatie\Permission\Models\Role;
use UnitEnum;

final class RoleResource extends Resource
{
    #[Override]
    protected static ?string $model = Role::class;

    #[Override]
    protected static ?string $slug = 'roles';

    #[Override]
    protected static ?string $recordTitleAttribute = 'name';

    #[Override]
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    #[Override]
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return RoleSchema::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return RoleTable::configure($table);
    }

    /**
     * @return array<string, PageRegistration>
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }
}

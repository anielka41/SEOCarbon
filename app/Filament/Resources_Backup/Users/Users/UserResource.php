<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Users;

use App\Domain\Users\Models\User;
use App\Filament\Resources\Users\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Users\Pages\EditUser;
use App\Filament\Resources\Users\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Users\Schemas\UserSchema;
use App\Filament\Resources\Users\Users\Tables\UserTable;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class UserResource extends Resource
{
    #[Override]
    protected static ?string $model = User::class;

    #[Override]
    protected static ?string $slug = 'users';

    #[Override]
    protected static ?string $recordTitleAttribute = 'name';

    #[Override]
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    #[Override]
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return UserSchema::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return UserTable::configure($table);
    }

    /**
     * @return array<string, PageRegistration>
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}

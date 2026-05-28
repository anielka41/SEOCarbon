<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryGroups;

use App\Domain\Directory\Models\DirectoryGroup;
use App\Filament\Resources\Directory\DirectoryGroups\Pages\CreateDirectoryGroup;
use App\Filament\Resources\Directory\DirectoryGroups\Pages\EditDirectoryGroup;
use App\Filament\Resources\Directory\DirectoryGroups\Pages\ListDirectoryGroups;
use App\Filament\Resources\Directory\DirectoryGroups\Schemas\DirectoryGroupSchema;
use App\Filament\Resources\Directory\DirectoryGroups\Tables\DirectoryGroupsTable;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class DirectoryGroupResource extends Resource
{
    #[Override]
    protected static ?string $model = DirectoryGroup::class;

    #[Override]
    protected static ?string $slug = 'packages';

    #[Override]
    protected static ?string $navigationLabel = 'Packages';

    #[Override]
    protected static ?string $modelLabel = 'Package';

    #[Override]
    protected static ?string $pluralModelLabel = 'Packages';

    #[Override]
    protected static ?string $recordTitleAttribute = 'name';

    #[Override]
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCreditCard;

    #[Override]
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return DirectoryGroupSchema::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return DirectoryGroupsTable::configure($table);
    }

    /**
     * @return array<string, PageRegistration>
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListDirectoryGroups::route('/'),
            'create' => CreateDirectoryGroup::route('/create'),
            'edit' => EditDirectoryGroup::route('/{record}/edit'),
        ];
    }
}

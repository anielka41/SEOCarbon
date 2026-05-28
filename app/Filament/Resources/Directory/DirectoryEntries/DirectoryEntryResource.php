<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryEntries;

use App\Domain\Directory\Models\DirectoryEntry;
use App\Filament\Resources\Directory\DirectoryEntries\Pages\CreateDirectoryEntry;
use App\Filament\Resources\Directory\DirectoryEntries\Pages\EditDirectoryEntry;
use App\Filament\Resources\Directory\DirectoryEntries\Pages\ListDirectoryEntries;
use App\Filament\Resources\Directory\DirectoryEntries\RelationManagers\BacklinkChecksRelationManager;
use App\Filament\Resources\Directory\DirectoryEntries\RelationManagers\CommentsRelationManager;
use App\Filament\Resources\Directory\DirectoryEntries\RelationManagers\InvoicesRelationManager;
use App\Filament\Resources\Directory\DirectoryEntries\Schemas\DirectoryEntrySchema;
use App\Filament\Resources\Directory\DirectoryEntries\Tables\DirectoryEntriesTable;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class DirectoryEntryResource extends Resource
{
    #[Override]
    protected static ?string $model = DirectoryEntry::class;

    #[Override]
    protected static ?string $slug = 'listings';

    #[Override]
    protected static ?string $navigationLabel = 'Listings';

    #[Override]
    protected static ?string $modelLabel = 'Listing';

    #[Override]
    protected static ?string $pluralModelLabel = 'Listings';

    #[Override]
    protected static ?string $recordTitleAttribute = 'name';

    #[Override]
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    #[Override]
    protected static string|UnitEnum|null $navigationGroup = 'Content';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return DirectoryEntrySchema::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return DirectoryEntriesTable::configure($table);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
            InvoicesRelationManager::class,
            CommentsRelationManager::class,
            BacklinkChecksRelationManager::class,
        ];
    }

    /**
     * @return array<string, PageRegistration>
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListDirectoryEntries::route('/'),
            'create' => CreateDirectoryEntry::route('/create'),
            'edit' => EditDirectoryEntry::route('/{record}/edit'),
        ];
    }
}

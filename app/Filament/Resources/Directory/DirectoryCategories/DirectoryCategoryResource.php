<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryCategories;

use App\Domain\Directory\Models\DirectoryCategory;
use App\Filament\Resources\Directory\DirectoryCategories\Pages\CreateDirectoryCategory;
use App\Filament\Resources\Directory\DirectoryCategories\Pages\EditDirectoryCategory;
use App\Filament\Resources\Directory\DirectoryCategories\Pages\ListDirectoryCategories;
use App\Filament\Resources\Directory\DirectoryCategories\Schemas\DirectoryCategorySchema;
use App\Filament\Resources\Directory\DirectoryCategories\Tables\DirectoryCategoriesTable;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class DirectoryCategoryResource extends Resource
{
    #[Override]
    protected static ?string $model = DirectoryCategory::class;

    #[Override]
    protected static ?string $slug = 'categories';

    #[Override]
    protected static ?string $recordTitleAttribute = 'name';

    #[Override]
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolder;

    #[Override]
    protected static string|UnitEnum|null $navigationGroup = 'Content';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return DirectoryCategorySchema::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return DirectoryCategoriesTable::configure($table);
    }

    /**
     * @return array<string, PageRegistration>
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListDirectoryCategories::route('/'),
            'create' => CreateDirectoryCategory::route('/create'),
            'edit' => EditDirectoryCategory::route('/{record}/edit'),
        ];
    }
}

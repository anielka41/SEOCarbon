<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryFields;

use App\Domain\Directory\Models\DirectoryField;
use App\Filament\Resources\Directory\DirectoryFields\Pages\ListDirectoryFields;
use App\Filament\Resources\Directory\DirectoryFields\Schemas\DirectoryFieldSchema;
use App\Filament\Resources\Directory\DirectoryFields\Tables\DirectoryFieldsTable;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class DirectoryFieldResource extends Resource
{
    #[Override]
    protected static ?string $model = DirectoryField::class;

    #[Override]
    protected static ?string $slug = 'directory-fields';

    #[Override]
    protected static ?string $recordTitleAttribute = 'label';

    #[Override]
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAdjustmentsHorizontal;

    #[Override]
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return DirectoryFieldSchema::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return DirectoryFieldsTable::configure($table);
    }

    /**
     * @return PageRegistration[]
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListDirectoryFields::route('/'),
        ];
    }
}

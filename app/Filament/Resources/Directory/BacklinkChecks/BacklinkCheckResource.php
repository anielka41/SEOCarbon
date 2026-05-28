<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\BacklinkChecks;

use App\Domain\Directory\Models\BacklinkCheck;
use App\Filament\Resources\Directory\BacklinkChecks\Pages\ListBacklinkChecks;
use App\Filament\Resources\Directory\BacklinkChecks\Schemas\BacklinkCheckSchema;
use App\Filament\Resources\Directory\BacklinkChecks\Tables\BacklinkCheckTable;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class BacklinkCheckResource extends Resource
{
    #[Override]
    protected static ?string $model = BacklinkCheck::class;

    #[Override]
    protected static ?string $slug = 'backlink-checks';

    #[Override]
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLink;

    #[Override]
    protected static string|UnitEnum|null $navigationGroup = 'Directory';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return BacklinkCheckSchema::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return BacklinkCheckTable::configure($table);
    }

    /**
     * @return array<string, PageRegistration>
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListBacklinkChecks::route('/'),
        ];
    }
}

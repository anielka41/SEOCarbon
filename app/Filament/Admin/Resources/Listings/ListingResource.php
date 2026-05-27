<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Listings;

use App\Filament\Admin\Resources\Listings\Pages\CreateListing;
use App\Filament\Admin\Resources\Listings\Pages\EditListing;
use App\Filament\Admin\Resources\Listings\Pages\ListListings;
use App\Filament\Admin\Resources\Listings\Schemas\ListingSchema;
use App\Filament\Admin\Resources\Listings\Tables\ListingsTable;
use App\Models\Listing;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use UnitEnum;

final class ListingResource extends Resource
{
    protected static ?string $model = Listing::class;

    protected static ?string $slug = 'listings';

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    public static function form(Schema $schema): Schema
    {
        return ListingSchema::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ListingsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListListings::route('/'),
            'create' => CreateListing::route('/create'),
            'edit' => EditListing::route('/{record}/edit'),
        ];
    }
}

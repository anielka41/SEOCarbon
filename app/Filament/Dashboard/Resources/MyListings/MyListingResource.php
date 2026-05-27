<?php

declare(strict_types=1);

namespace App\Filament\Dashboard\Resources\MyListings;

use App\Filament\Dashboard\Resources\MyListings\Pages\CreateMyListing;
use App\Filament\Dashboard\Resources\MyListings\Pages\EditMyListing;
use App\Filament\Dashboard\Resources\MyListings\Pages\ListMyListings;
use App\Filament\Dashboard\Resources\MyListings\Schemas\MyListingSchema;
use App\Filament\Dashboard\Resources\MyListings\Tables\MyListingsTable;
use App\Models\Listing;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

final class MyListingResource extends Resource
{
    protected static ?string $model = Listing::class;

    protected static ?string $slug = 'my-listings';

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    public static function form(Schema $schema): Schema
    {
        return MyListingSchema::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MyListingsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', Auth::id());
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMyListings::route('/'),
            'create' => CreateMyListing::route('/create'),
            'edit' => EditMyListing::route('/{record}/edit'),
        ];
    }
}

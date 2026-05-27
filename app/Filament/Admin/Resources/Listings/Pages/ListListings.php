<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Listings\Pages;

use App\Filament\Admin\Resources\Listings\ListingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListListings extends ListRecords
{
    protected static string $resource = ListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

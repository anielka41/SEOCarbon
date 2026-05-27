<?php

declare(strict_types=1);

namespace App\Filament\Dashboard\Resources\MyListings\Pages;

use App\Filament\Dashboard\Resources\MyListings\MyListingResource;
use Filament\Resources\Pages\ListRecords;

class ListMyListings extends ListRecords
{
    protected static string $resource = MyListingResource::class;
}

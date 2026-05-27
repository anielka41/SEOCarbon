<?php

declare(strict_types=1);

namespace App\Filament\Dashboard\Resources\MyListings\Pages;

use App\Filament\Dashboard\Resources\MyListings\MyListingResource;
use Filament\Resources\Pages\EditRecord;

class EditMyListing extends EditRecord
{
    protected static string $resource = MyListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No delete action for users unless we want them to be able to delete their listings
        ];
    }
}

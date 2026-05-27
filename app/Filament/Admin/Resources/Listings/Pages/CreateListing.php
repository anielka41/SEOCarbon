<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Listings\Pages;

use App\Filament\Admin\Resources\Listings\ListingResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateListing extends CreateRecord
{
    protected static string $resource = ListingResource::class;
}

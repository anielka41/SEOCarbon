<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Listings\Pages;

use App\Filament\Admin\Resources\Listings\ListingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

final class EditListing extends EditRecord
{
    protected static string $resource = ListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

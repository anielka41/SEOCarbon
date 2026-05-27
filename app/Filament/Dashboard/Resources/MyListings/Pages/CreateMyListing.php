<?php

declare(strict_types=1);

namespace App\Filament\Dashboard\Resources\MyListings\Pages;

use App\Filament\Dashboard\Resources\MyListings\MyListingResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateMyListing extends CreateRecord
{
    protected static string $resource = MyListingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        return $data;
    }
}

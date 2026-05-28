<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Users\Pages;

use App\Filament\Resources\Users\Users\UserResource;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListUsers extends ListRecords
{
    #[Override]
    protected static string $resource = UserResource::class;
}

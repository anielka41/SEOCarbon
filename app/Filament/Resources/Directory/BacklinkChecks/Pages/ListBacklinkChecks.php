<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\BacklinkChecks\Pages;

use App\Filament\Resources\Directory\BacklinkChecks\BacklinkCheckResource;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListBacklinkChecks extends ListRecords
{
    #[Override]
    protected static string $resource = BacklinkCheckResource::class;
}

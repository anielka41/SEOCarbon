<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryGroups\Pages;

use App\Filament\Resources\Directory\DirectoryGroups\DirectoryGroupResource;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListDirectoryGroups extends ListRecords
{
    #[Override]
    protected static string $resource = DirectoryGroupResource::class;
}

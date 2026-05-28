<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryGroups\Pages;

use App\Filament\Resources\Directory\DirectoryGroups\DirectoryGroupResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateDirectoryGroup extends CreateRecord
{
    #[Override]
    protected static string $resource = DirectoryGroupResource::class;
}

<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryEntries\Pages;

use App\Filament\Resources\Directory\DirectoryEntries\DirectoryEntryResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateDirectoryEntry extends CreateRecord
{
    #[Override]
    protected static string $resource = DirectoryEntryResource::class;
}

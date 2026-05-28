<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryGroups\Pages;

use App\Filament\Resources\Directory\DirectoryGroups\DirectoryGroupResource;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditDirectoryGroup extends EditRecord
{
    #[Override]
    protected static string $resource = DirectoryGroupResource::class;
}

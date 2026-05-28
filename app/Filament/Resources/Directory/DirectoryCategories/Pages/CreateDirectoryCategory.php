<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryCategories\Pages;

use App\Filament\Resources\Directory\DirectoryCategories\DirectoryCategoryResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateDirectoryCategory extends CreateRecord
{
    #[Override]
    protected static string $resource = DirectoryCategoryResource::class;
}

<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryCategories\Pages;

use App\Filament\Resources\Directory\DirectoryCategories\DirectoryCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListDirectoryCategories extends ListRecords
{
    #[Override]
    protected static string $resource = DirectoryCategoryResource::class;

    /**
     * @return CreateAction[]
     */
    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

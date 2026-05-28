<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryEntries\Pages;

use App\Filament\Resources\Directory\DirectoryEntries\DirectoryEntryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListDirectoryEntries extends ListRecords
{
    #[Override]
    protected static string $resource = DirectoryEntryResource::class;

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

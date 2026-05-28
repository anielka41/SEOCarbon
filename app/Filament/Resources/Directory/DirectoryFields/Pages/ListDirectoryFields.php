<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryFields\Pages;

use App\Filament\Resources\Directory\DirectoryFields\DirectoryFieldResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListDirectoryFields extends ListRecords
{
    #[Override]
    protected static string $resource = DirectoryFieldResource::class;

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

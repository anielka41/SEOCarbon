<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryEntries\Pages;

use App\Filament\Resources\Directory\DirectoryEntries\DirectoryEntryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditDirectoryEntry extends EditRecord
{
    #[Override]
    protected static string $resource = DirectoryEntryResource::class;

    /**
     * @return DeleteAction[]
     */
    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

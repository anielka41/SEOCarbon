<?php

declare(strict_types=1);

namespace App\Filament\Resources\Directory\DirectoryCategories\Pages;

use App\Filament\Resources\Directory\DirectoryCategories\DirectoryCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditDirectoryCategory extends EditRecord
{
    #[Override]
    protected static string $resource = DirectoryCategoryResource::class;

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

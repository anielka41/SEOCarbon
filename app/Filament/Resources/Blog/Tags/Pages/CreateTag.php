<?php

declare(strict_types=1);

namespace App\Filament\Resources\Blog\Tags\Pages;

use App\Filament\Resources\Blog\Tags\TagResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateTag extends CreateRecord
{
    #[Override]
    protected static string $resource = TagResource::class;
}

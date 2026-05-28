<?php

declare(strict_types=1);

namespace App\Filament\Resources\Blog\Tags\Pages;

use App\Filament\Resources\Blog\Tags\TagResource;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListTags extends ListRecords
{
    #[Override]
    protected static string $resource = TagResource::class;
}

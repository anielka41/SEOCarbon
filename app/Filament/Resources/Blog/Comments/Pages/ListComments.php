<?php

declare(strict_types=1);

namespace App\Filament\Resources\Blog\Comments\Pages;

use App\Filament\Resources\Blog\Comments\CommentResource;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListComments extends ListRecords
{
    #[Override]
    protected static string $resource = CommentResource::class;
}

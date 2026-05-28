<?php

declare(strict_types=1);

namespace App\Filament\Resources\Blog\Posts\Pages;

use App\Filament\Resources\Blog\Posts\PostResource;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListPosts extends ListRecords
{
    #[Override]
    protected static string $resource = PostResource::class;
}

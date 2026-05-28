<?php

declare(strict_types=1);

namespace App\Filament\Resources\Blog\Posts\Pages;

use App\Filament\Resources\Blog\Posts\PostResource;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditPost extends EditRecord
{
    #[Override]
    protected static string $resource = PostResource::class;
}

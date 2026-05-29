<?php

declare(strict_types=1);

namespace App\Filament\Resources\Moderation\Reviews\Pages;

use App\Filament\Resources\Moderation\Reviews\ReviewResource;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListReviews extends ListRecords
{
    #[Override]
    protected static string $resource = ReviewResource::class;
}

<?php

declare(strict_types=1);

namespace App\Filament\Resources\Moderation\Reviews\Pages;

use App\Filament\Resources\Moderation\Reviews\ReviewResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateReview extends CreateRecord
{
    #[Override]
    protected static string $resource = ReviewResource::class;
}

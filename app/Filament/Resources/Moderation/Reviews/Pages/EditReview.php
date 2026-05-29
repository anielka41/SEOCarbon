<?php

declare(strict_types=1);

namespace App\Filament\Resources\Moderation\Reviews\Pages;

use App\Filament\Resources\Moderation\Reviews\ReviewResource;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditReview extends EditRecord
{
    #[Override]
    protected static string $resource = ReviewResource::class;
}

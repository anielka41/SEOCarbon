<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Roles\Pages;

use App\Filament\Resources\Users\Roles\RoleResource;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditRole extends EditRecord
{
    #[Override]
    protected static string $resource = RoleResource::class;
}

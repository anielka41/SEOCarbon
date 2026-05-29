<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Roles\Pages;

use App\Filament\Resources\Users\Roles\RoleResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateRole extends CreateRecord
{
    #[Override]
    protected static string $resource = RoleResource::class;
}

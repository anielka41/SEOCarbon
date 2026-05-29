<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Permissions\Pages;

use App\Filament\Resources\Users\Permissions\PermissionResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreatePermission extends CreateRecord
{
    #[Override]
    protected static string $resource = PermissionResource::class;
}

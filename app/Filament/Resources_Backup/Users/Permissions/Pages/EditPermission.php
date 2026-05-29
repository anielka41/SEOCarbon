<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Permissions\Pages;

use App\Filament\Resources\Users\Permissions\PermissionResource;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditPermission extends EditRecord
{
    #[Override]
    protected static string $resource = PermissionResource::class;
}

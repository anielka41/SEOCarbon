<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Permissions\Pages;

use App\Filament\Resources\Users\Permissions\PermissionResource;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListPermissions extends ListRecords
{
    #[Override]
    protected static string $resource = PermissionResource::class;
}

<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Roles\Pages;

use App\Filament\Resources\Users\Roles\RoleResource;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListRoles extends ListRecords
{
    #[Override]
    protected static string $resource = RoleResource::class;
}

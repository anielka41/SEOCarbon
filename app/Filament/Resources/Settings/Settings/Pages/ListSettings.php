<?php

declare(strict_types=1);

namespace App\Filament\Resources\Settings\Settings\Pages;

use App\Filament\Resources\Settings\Settings\SettingResource;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListSettings extends ListRecords
{
    #[Override]
    protected static string $resource = SettingResource::class;
}

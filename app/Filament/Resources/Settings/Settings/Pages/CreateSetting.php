<?php

declare(strict_types=1);

namespace App\Filament\Resources\Settings\Settings\Pages;

use App\Filament\Resources\Settings\Settings\SettingResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateSetting extends CreateRecord
{
    #[Override]
    protected static string $resource = SettingResource::class;
}

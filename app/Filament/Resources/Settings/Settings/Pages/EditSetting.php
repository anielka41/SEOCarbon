<?php

declare(strict_types=1);

namespace App\Filament\Resources\Settings\Settings\Pages;

use App\Filament\Resources\Settings\Settings\SettingResource;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditSetting extends EditRecord
{
    #[Override]
    protected static string $resource = SettingResource::class;
}

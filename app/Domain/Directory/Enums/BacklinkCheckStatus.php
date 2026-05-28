<?php

declare(strict_types=1);

namespace App\Domain\Directory\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum BacklinkCheckStatus: string implements HasColor, HasLabel
{
    case Pending = 'pending';
    case Success = 'success';
    case Failed = 'failed';
    case Error = 'error';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => strval(__('Pending')),
            self::Success => strval(__('Success')),
            self::Failed => strval(__('Failed')),
            self::Error => strval(__('Error')),
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Pending => 'gray',
            self::Success => 'success',
            self::Failed => 'warning',
            self::Error => 'danger',
        };
    }
}

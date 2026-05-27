<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum EntryStatus: string implements HasLabel, HasColor, HasIcon
{
    case Draft = 'draft';
    case Pending = 'pending';
    case Published = 'published';
    case Rejected = 'rejected';
    case Expired = 'expired';

    public function getLabel(): string
    {
        return match ($this) {
            self::Draft => strval(__('Draft')),
            self::Pending => strval(__('Pending')),
            self::Published => strval(__('Published')),
            self::Rejected => strval(__('Rejected')),
            self::Expired => strval(__('Expired')),
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Pending => 'warning',
            self::Published => 'success',
            self::Rejected => 'danger',
            self::Expired => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Draft => 'heroicon-m-pencil-square',
            self::Pending => 'heroicon-m-clock',
            self::Published => 'heroicon-m-check-circle',
            self::Rejected => 'heroicon-m-x-circle',
            self::Expired => 'heroicon-m-calendar-days',
        };
    }
}

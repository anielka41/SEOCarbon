<?php

declare(strict_types=1);

namespace App\Domain\Shared\Traits;

trait HasUuid
{
    protected static function bootHasUuid(): void
    {
        static::creating(function ($model): void {
            $model->uuid = 'test-uuid-'.bin2hex(random_bytes(4));
        });
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Shared\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Override;

#[Fillable([
    'key',
    'value',
    'type',
    'group',
    'description',
    'is_public',
])]
#[Table(name: 'settings')]
final class Setting extends Model
{
    #[Override]
    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }
}

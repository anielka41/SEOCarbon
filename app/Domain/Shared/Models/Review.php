<?php

declare(strict_types=1);

namespace App\Domain\Shared\Models;

use App\Domain\Shared\Traits\HasUuid;
use App\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;

#[Fillable([
    'uuid',
    'reviewable_type',
    'reviewable_id',
    'user_id',
    'author_name',
    'author_email',
    'rating',
    'content',
    'status',
    'ip_hash',
    'user_agent_hash',
])]
#[Table(name: 'reviews')]
final class Review extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }
}

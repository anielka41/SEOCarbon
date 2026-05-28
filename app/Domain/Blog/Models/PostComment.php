<?php

declare(strict_types=1);

namespace App\Domain\Blog\Models;

use App\Domain\Shared\Traits\HasUuid;
use App\Domain\Users\Models\User;
use Database\Factories\PostCommentFactory;
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
    'user_id',
    'commentable_type',
    'commentable_id',
    'content',
    'rating',
    'is_approved',
])]
#[Table(name: 'comments')]
class PostComment extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    protected static function newFactory(): PostCommentFactory
    {
        return PostCommentFactory::new();
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'rating' => 'integer',
        ];
    }
}

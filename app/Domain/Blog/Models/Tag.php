<?php

declare(strict_types=1);

namespace App\Domain\Blog\Models;

use App\Domain\Directory\Models\DirectoryEntry;
use App\Domain\Shared\Traits\HasUuid;
use Database\Factories\TagFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'uuid',
    'name',
    'slug',
])]
class Tag extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    protected static function newFactory(): TagFactory
    {
        return TagFactory::new();
    }

    /**
     * @return BelongsToMany<Post, $this>
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * @return BelongsToMany<DirectoryEntry, $this>
     */
    public function listings(): BelongsToMany
    {
        return $this->belongsToMany(DirectoryEntry::class);
    }
}

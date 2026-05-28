<?php

declare(strict_types=1);

namespace App\Domain\Directory\Models;

use App\Domain\Blog\Models\Post;
use App\Domain\Shared\Traits\HasUuid;
use Database\Factories\DirectoryCategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;

#[Fillable([
    'uuid',
    'parent_id',
    'type',
    'name',
    'slug',
    'description',
    'meta_title',
    'meta_description',
    'seo_title',
    'seo_description',
    'canonical_url',
    'faq',
    'icon',
    'is_active',
    'sort_order',
])]
#[Table(name: 'directory_categories')]
class DirectoryCategory extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    protected static function newFactory(): DirectoryCategoryFactory
    {
        return DirectoryCategoryFactory::new();
    }

    /**
     * @return BelongsTo<DirectoryCategory, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(DirectoryCategory::class, 'parent_id');
    }

    /**
     * @return HasMany<DirectoryCategory, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(DirectoryCategory::class, 'parent_id');
    }

    /**
     * @return HasMany<DirectoryEntry, $this>
     */
    public function entries(): HasMany
    {
        return $this->hasMany(DirectoryEntry::class, 'category_id');
    }

    /**
     * @return HasMany<Post, $this>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    /**
     * @return array<string, string> */
    #[Override]
    protected function casts(): array
    {
        return [
            'faq' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Blog\Models;

use App\Domain\Directory\Models\DirectoryCategory;
use App\Domain\Shared\Models\Review;
use App\Domain\Shared\Traits\HasUuid;
use App\Domain\Users\Models\User;
use App\Enums\EntryStatus;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\App;
use Override;

#[Fillable([
    'uuid',
    'user_id',
    'category_id',
    'title',
    'slug',
    'excerpt',
    'content',
    'featured_image',
    'status',
    'meta_title',
    'meta_description',
    'seo_title',
    'seo_description',
    'canonical_url',
    'published_at',
])]
#[Table(name: 'blog_posts')]
class Post extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    protected static function newFactory(): PostFactory
    {
        return PostFactory::new();
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<DirectoryCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(DirectoryCategory::class);
    }

    /**
     * @return BelongsToMany<Tag, $this>
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @return MorphMany<PostComment, $this>
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(PostComment::class, 'commentable');
    }

    /**
     * @return MorphMany<Review, $this>
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function getFeaturedImageUrl(int $width = 800, int $height = 600): ?string
    {
        if (! $this->featured_image) {
            return null;
        }

        return App::make(UrlGenerator::class)->route('image.show', [
            'path' => $this->featured_image,
            'w' => $width,
            'h' => $height,
            'fit' => 'crop',
        ]);
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'status' => EntryStatus::class,
            'published_at' => 'datetime',
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Directory\Models;

use App\Domain\Blog\Models\PostComment;
use App\Domain\Blog\Models\Tag;
use App\Domain\Payments\Models\Invoice;
use App\Domain\Shared\Traits\HasUuid;
use App\Domain\Users\Models\User;
use App\Enums\EntryStatus;
use Database\Factories\DirectoryEntryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\App;
use Override;

#[Fillable([
    'uuid',
    'category_id',
    'package_id',
    'user_id',
    'name',
    'slug',
    'url',
    'backlink_url',
    'description',
    'content',
    'logo_path',
    'thumbnail_path',
    'contact_email',
    'contact_phone',
    'address',
    'meta_title',
    'meta_description',
    'status',
    'is_promoted',
    'verified_at',
    'backlink_verified_at',
    'expires_at',
])]
#[Table(name: 'directory_entries')]
class DirectoryEntry extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    protected static function newFactory(): DirectoryEntryFactory
    {
        return DirectoryEntryFactory::new();
    }

    /**
     * @return BelongsTo<DirectoryCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(DirectoryCategory::class);
    }

    /**
     * @return BelongsTo<DirectoryGroup, $this>
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(DirectoryGroup::class, 'package_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphMany<PostComment, $this>
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(PostComment::class, 'commentable');
    }

    /**
     * @return BelongsToMany<Tag, $this>
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @return HasMany<Invoice, $this>
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'listing_id');
    }

    /**
     * @return HasMany<BacklinkCheck, $this>
     */
    public function backlinkChecks(): HasMany
    {
        return $this->hasMany(BacklinkCheck::class, 'directory_entry_id');
    }

    /**
     * @return HasMany<DirectoryFieldValue, $this>
     */
    public function fieldValues(): HasMany
    {
        return $this->hasMany(DirectoryFieldValue::class, 'directory_entry_id');
    }

    public function getLogoUrl(int $width = 200, ?int $height = null): ?string
    {
        if (! $this->logo_path) {
            return null;
        }

        return App::make(UrlGenerator::class)->route('image.show', [
            'path' => $this->logo_path,
            'w' => $width,
            'h' => $height,
            'fit' => 'crop',
        ]);
    }

    public function getThumbnailUrl(int $width = 400, int $height = 300): ?string
    {
        if (! $this->thumbnail_path) {
            return null;
        }

        return App::make(UrlGenerator::class)->route('image.show', [
            'path' => $this->thumbnail_path,
            'w' => $width,
            'h' => $height,
            'fit' => 'crop',
        ]);
    }

    /**
     * @param  Builder<DirectoryEntry>  $query
     */
    #[Scope]
    protected function verifiedBacklink($query): void
    {
        $query->whereNotNull('backlink_verified_at');
    }

    /**
     * @param  Builder<DirectoryEntry>  $query
     */
    #[Scope]
    protected function sorted($query): void
    {
        $query->orderByDesc('is_promoted')
            ->latest('backlink_verified_at')->latest();
    }

    /**
     * @return array<string, string|class-string> */
    #[Override]
    protected function casts(): array
    {
        return [
            'status' => EntryStatus::class,
            'is_promoted' => 'boolean',
            'verified_at' => 'datetime',
            'backlink_verified_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }
}

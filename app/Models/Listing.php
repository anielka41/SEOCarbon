<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EntryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Relations\MorphMany;

class Listing extends Model
{
    /** @use HasFactory<\Database\Factories\ListingFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'name',
        'slug',
        'url',
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
        'expires_at',
    ];

    /** @var array<string, string|class-string> */
    protected $casts = [
        'status' => EntryStatus::class,
        'is_promoted' => 'boolean',
        'verified_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphMany<Comment, $this>
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}

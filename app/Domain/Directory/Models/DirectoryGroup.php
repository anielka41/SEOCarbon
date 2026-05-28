<?php

declare(strict_types=1);

namespace App\Domain\Directory\Models;

use App\Domain\Shared\Traits\HasUuid;
use Database\Factories\DirectoryGroupFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;

#[Fillable([
    'uuid',
    'name',
    'slug',
    'description',
    'price_net_amount',
    'currency',
    'vat_rate',
    'is_paid',
    'duration_days',
    'can_upload_logo',
    'can_upload_thumbnail',
    'can_add_backlink',
    'requires_backlink',
    'auto_approve',
    'max_images',
    'max_links',
    'is_promoted',
    'max_tags',
    'is_active',
    'sort_order',
    'sort_boost',
])]
#[Table(name: 'directory_groups')]
class DirectoryGroup extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    protected static function newFactory(): DirectoryGroupFactory
    {
        return DirectoryGroupFactory::new();
    }

    /**
     * @return HasMany<DirectoryEntry, $this>
     */
    public function entries(): HasMany
    {
        return $this->hasMany(DirectoryEntry::class, 'package_id');
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'price_net_amount' => 'integer',
            'vat_rate' => 'integer',
            'is_paid' => 'boolean',
            'duration_days' => 'integer',
            'can_upload_logo' => 'boolean',
            'can_upload_thumbnail' => 'boolean',
            'can_add_backlink' => 'boolean',
            'requires_backlink' => 'boolean',
            'auto_approve' => 'boolean',
            'max_images' => 'integer',
            'max_links' => 'integer',
            'is_promoted' => 'boolean',
            'max_tags' => 'integer',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'sort_boost' => 'integer',
        ];
    }
}

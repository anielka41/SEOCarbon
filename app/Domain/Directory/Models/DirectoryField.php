<?php

declare(strict_types=1);

namespace App\Domain\Directory\Models;

use App\Domain\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;

#[Fillable([
    'uuid',
    'name',
    'label',
    'type',
    'placeholder',
    'help_text',
    'options',
    'validation_rules',
    'is_required',
    'is_searchable',
    'is_filterable',
    'sort_order',
])]
#[Table(name: 'directory_fields')]
class DirectoryField extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    /**
     * @return BelongsToMany<DirectoryCategory, $this>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(DirectoryCategory::class, 'directory_category_field');
    }

    /**
     * @return BelongsToMany<DirectoryGroup, $this>
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(DirectoryGroup::class, 'directory_group_field');
    }

    /**
     * @return HasMany<DirectoryFieldValue, $this>
     */
    public function values(): HasMany
    {
        return $this->hasMany(DirectoryFieldValue::class);
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'options' => 'array',
            'validation_rules' => 'array',
            'is_required' => 'boolean',
            'is_searchable' => 'boolean',
            'is_filterable' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}

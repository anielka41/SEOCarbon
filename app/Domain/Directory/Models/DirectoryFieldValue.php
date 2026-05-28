<?php

declare(strict_types=1);

namespace App\Domain\Directory\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'directory_entry_id',
    'directory_field_id',
    'value',
])]
#[Table(name: 'directory_field_values')]
class DirectoryFieldValue extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo<DirectoryEntry, $this>
     */
    public function entry(): BelongsTo
    {
        return $this->belongsTo(DirectoryEntry::class, 'directory_entry_id');
    }

    /**
     * @return BelongsTo<DirectoryField, $this>
     */
    public function field(): BelongsTo
    {
        return $this->belongsTo(DirectoryField::class, 'directory_field_id');
    }
}

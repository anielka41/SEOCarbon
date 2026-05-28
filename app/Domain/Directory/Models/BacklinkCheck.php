<?php

declare(strict_types=1);

namespace App\Domain\Directory\Models;

use App\Domain\Directory\Enums\BacklinkCheckStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Override;

#[Fillable([
    'uuid',
    'directory_entry_id',
    'status',
    'checked_at',
    'error_message',
    'html_snapshot_path',
])]
#[Table(name: 'backlink_checks')]
class BacklinkCheck extends Model
{
    use HasFactory;

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (BacklinkCheck $backlinkCheck): void {
            if (empty($backlinkCheck->uuid)) {
                $backlinkCheck->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * @return BelongsTo<DirectoryEntry, $this>
     */
    public function entry(): BelongsTo
    {
        return $this->belongsTo(DirectoryEntry::class, 'directory_entry_id');
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'status' => BacklinkCheckStatus::class,
            'checked_at' => 'datetime',
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Payments\Models;

use App\Domain\Directory\Models\DirectoryEntry;
use App\Domain\Users\Models\User;
use BcMath\Number;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

#[Fillable([
    'user_id',
    'listing_id',
    'number',
    'amount_net',
    'amount_vat',
    'amount_gross',
    'currency',
    'status',
])]
final class Invoice extends Model
{
    use HasFactory;

    /**
     * Using PHP 8.5 Property Hooks for automatic gross calculation.
     */
    public string $total {
        get => new Number($this->amount_net)->add(new Number($this->amount_vat))->__toString();
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<DirectoryEntry, $this>
     */
    public function listing(): BelongsTo
    {
        return $this->belongsTo(DirectoryEntry::class);
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'amount_net' => 'decimal:2',
            'amount_vat' => 'decimal:2',
            'amount_gross' => 'decimal:2',
        ];
    }
}

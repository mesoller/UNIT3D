<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShopBadge extends Model
{
    protected $guarded = [];

    protected $casts = [
        'buy_price'  => 'float',
        'sell_price' => 'float',
    ];

    public function collection(): BelongsTo
    {
        return $this->belongsTo(BadgeCollection::class, 'badge_collection_id');
    }

    public function owners(): HasMany
    {
        return $this->hasMany(UserShopBadge::class);
    }

    public function currentOwnerCount(): int
    {
        return $this->owners()->count();
    }

    public function isUnlimited(): bool
    {
        return $this->supply === 0;
    }

    public function isAvailable(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        return $this->isUnlimited() || $this->currentOwnerCount() < $this->supply;
    }

    public function slotsRemaining(): ?int
    {
        if ($this->isUnlimited()) {
            return null;
        }

        return max(0, $this->supply - $this->currentOwnerCount());
    }
}

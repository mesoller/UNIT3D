<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BonGiveaway extends Model
{
    protected $guarded = [];

    protected $casts = [
        'next_reminder_at' => 'datetime',
        'starts_at'        => 'datetime',
        'ends_at'          => 'datetime',
        'ended_at'         => 'datetime',
    ];

    public function entries(): HasMany
    {
        return $this->hasMany(BonGiveawayEntry::class, 'giveaway_id');
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_user_id');
    }

    public static function active(): ?self
    {
        return self::whereNull('ended_at')->latest()->first();
    }

    public function isExpired(): bool
    {
        return now()->greaterThanOrEqualTo($this->ends_at);
    }

    public function totalSlots(): int
    {
        return $this->end_num - $this->start_num + 1;
    }
}

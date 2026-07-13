<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCompletedCollection extends Model
{
    protected $fillable = [
        'user_id',
        'badge_collection_id',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<BadgeCollection, $this> */
    public function collection(): BelongsTo
    {
        return $this->belongsTo(BadgeCollection::class, 'badge_collection_id');
    }
}

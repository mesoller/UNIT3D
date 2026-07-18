<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTreat extends Model
{
    protected $fillable = ['user_id', 'treat_id', 'purchased_at'];

    protected $casts = [
        'purchased_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function treat(): BelongsTo
    {
        return $this->belongsTo(Treat::class);
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BadgeCollection extends Model
{
    protected $guarded = [];

    public function shopBadges(): HasMany
    {
        return $this->hasMany(ShopBadge::class)->orderBy('sort_order');
    }
}

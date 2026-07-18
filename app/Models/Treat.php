<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Treat extends Model
{
    protected $guarded = [];

    public function owners(): HasMany
    {
        return $this->hasMany(UserTreat::class);
    }
}

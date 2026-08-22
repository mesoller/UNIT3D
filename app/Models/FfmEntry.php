<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FfmEntry extends Model
{
    protected $guarded = [];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(TmdbMovie::class, 'tmdb_movie_id');
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FilmClubSuggestion extends Model
{
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(TmdbMovie::class, 'tmdb_movie_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(FilmClubVote::class, 'suggestion_id');
    }
}

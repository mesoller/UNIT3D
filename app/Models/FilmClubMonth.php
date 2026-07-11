<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FilmClubMonth extends Model
{
    protected $guarded = [];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(TmdbMovie::class, 'tmdb_movie_id');
    }

    public function suggestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winning_user_id');
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'forum_topic_id');
    }

    public static function current(): ?self
    {
        return self::with(['movie', 'suggestedBy'])->where('year_month', now()->format('Y-m'))->first();
    }
}

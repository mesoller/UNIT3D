<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Review extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_anonymous' => 'bool',
            'is_spoiler'   => 'bool',
            'rating'       => 'int',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'username' => 'Anonymous',
            'id'       => 0,
        ]);
    }

    public function tmdbMovie(): BelongsTo
    {
        return $this->belongsTo(TmdbMovie::class, 'tmdb_movie_id');
    }

    public function tmdbTv(): BelongsTo
    {
        return $this->belongsTo(TmdbTv::class, 'tmdb_tv_id');
    }

    public function igdbGame(): BelongsTo
    {
        return $this->belongsTo(IgdbGame::class, 'igdb_id');
    }

    public function thanks(): HasMany
    {
        return $this->hasMany(ReviewThank::class);
    }

    public function mediaTitle(): string
    {
        if ($this->tmdbMovie) {
            return $this->tmdbMovie->title;
        }

        if ($this->tmdbTv) {
            return $this->tmdbTv->name;
        }

        if ($this->igdbGame) {
            return $this->igdbGame->name;
        }

        return 'Unknown';
    }

    public function mediaYear(): string
    {
        if ($this->tmdbMovie) {
            return substr((string) ($this->tmdbMovie->release_date ?? ''), 0, 4);
        }

        if ($this->tmdbTv) {
            return substr((string) ($this->tmdbTv->first_air_date ?? ''), 0, 4);
        }

        return '';
    }

    public function mediaType(): string
    {
        if ($this->tmdb_movie_id) {
            return 'Movie';
        }

        if ($this->tmdb_tv_id) {
            return 'TV';
        }

        if ($this->igdb_id) {
            return 'Game';
        }

        return '';
    }

    public function mediaRoute(): ?string
    {
        if ($this->tmdb_movie_id) {
            return route('torrents.similar', ['category_id' => 1, 'tmdb' => $this->tmdb_movie_id]);
        }

        if ($this->tmdb_tv_id) {
            return route('torrents.similar', ['category_id' => 2, 'tmdb' => $this->tmdb_tv_id]);
        }

        return null;
    }
}

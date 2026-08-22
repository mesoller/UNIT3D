<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\ProcessMovieJob;
use App\Models\FfmEntry;
use App\Models\TmdbMovie;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncFfmList extends Command
{
    protected $signature = 'ffm:sync';

    protected $description = 'Sync the Festival Filem Malaysia TMDB list into ffm_entries';

    private const LIST_ID = '8679422';

    public function handle(): void
    {
        $response = Http::get('https://api.themoviedb.org/3/list/'.self::LIST_ID, [
            'api_key'  => config('api-keys.tmdb'),
            'language' => 'ms-MY',
        ]);

        if (! $response->successful()) {
            $this->error('Failed to fetch TMDB list: '.$response->status());

            return;
        }

        $items = $response->json('items', []);

        if (empty($items)) {
            $this->warn('No items returned from TMDB list.');

            return;
        }

        $this->info('Fetched '.count($items).' items from TMDB list.');

        foreach ($items as $position => $item) {
            $tmdbId = (int) $item['id'];

            FfmEntry::updateOrCreate(
                ['tmdb_movie_id' => $tmdbId],
                ['position' => $position + 1]
            );

            // Dispatch job to fetch/update movie data if not already in local DB
            if (! TmdbMovie::where('id', $tmdbId)->exists()) {
                ProcessMovieJob::dispatch($tmdbId);
                $this->line("  Queued TMDB fetch for movie ID {$tmdbId}");
            }
        }

        // Remove entries that are no longer in the list
        $currentIds = collect($items)->pluck('id')->map(fn ($id) => (int) $id);
        $removed = FfmEntry::whereNotIn('tmdb_movie_id', $currentIds)->delete();

        if ($removed > 0) {
            $this->warn("  Removed {$removed} entries no longer in the list.");
        }

        $this->info('FFM list synced successfully. Total: '.count($items).' entries.');
    }
}

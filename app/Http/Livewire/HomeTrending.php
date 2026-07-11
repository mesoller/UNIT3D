<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Torrent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HomeTrending extends Component
{
    final public function placeholder(): string
    {
        return <<<'HTML'
        <section class="panelV2">
            <h2 class="panel__heading">Trending</h2>
            <div class="panel__body">Loading...</div>
        </section>
        HTML;
    }

    private function works(string $metaType, string $interval): Collection
    {
        $metaIdColumn = $metaType === 'tv_meta' ? 'tmdb_tv_id' : 'tmdb_movie_id';
        $relation = $metaType === 'tv_meta' ? 'tv' : 'movie';

        return cache()->flexible(
            "home-trending-{$metaType}-{$interval}",
            [1800, 7200],
            fn () => Torrent::query()
                ->with($relation)
                ->addSelect([
                    $metaIdColumn,
                    DB::raw('MIN(category_id) as category_id'),
                    DB::raw('COUNT(*) as download_count'),
                ])
                ->join('history', 'history.torrent_id', '=', 'torrents.id')
                ->where($metaIdColumn, '!=', 0)
                ->when($interval === 'day', fn ($q) => $q->whereBetween('history.completed_at', [now()->subDay(), now()]))
                ->when($interval === 'week', fn ($q) => $q->whereBetween('history.completed_at', [now()->subWeek(), now()]))
                ->when($interval === 'month', fn ($q) => $q->whereBetween('history.completed_at', [now()->subMonth(), now()]))
                ->whereRelation('category', $metaType, '=', true)
                ->where('torrents.size', '>', 1024 * 1024 * 1024)
                ->groupBy($metaIdColumn)
                ->orderByRaw('COUNT(*) DESC')
                ->limit(10)
                ->get($metaIdColumn)
        );
    }

    final public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.home-trending', [
            'tabs' => [
                'movie-day'   => $this->works('movie_meta', 'day'),
                'movie-week'  => $this->works('movie_meta', 'week'),
                'movie-month' => $this->works('movie_meta', 'month'),
                'tv-day'      => $this->works('tv_meta', 'day'),
                'tv-week'     => $this->works('tv_meta', 'week'),
                'tv-month'    => $this->works('tv_meta', 'month'),
            ],
        ]);
    }
}

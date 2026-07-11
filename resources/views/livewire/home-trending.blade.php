<section
    class="panelV2 home-trending"
    x-data="{ tab: 'movie-month' }"
>
    <header class="panel__header">
        <h2 class="panel__heading">
            <i class="{{ config('other.font-awesome') }} fa-fire"></i>
            Trending
        </h2>
        <div class="panel__actions">
            <div class="panel__action">
                <a
                    class="home-trending__view-all"
                    href="{{ route('trending.index') }}"
                >
                    <i class="{{ config('other.font-awesome') }} fa-arrow-right"></i>
                    Lihat Semua
                </a>
            </div>
        </div>
    </header>

    <div class="home-trending__tabs">
        <div class="home-trending__tab-group">
            <span class="home-trending__group-label">
                <i class="{{ config('other.font-awesome') }} fa-film"></i>
                Movie
            </span>
            <button
                class="home-trending__tab-btn"
                :class="{ 'home-trending__tab-btn--active': tab === 'movie-day' }"
                @click="tab = 'movie-day'"
                type="button"
            >Harian</button>
            <button
                class="home-trending__tab-btn"
                :class="{ 'home-trending__tab-btn--active': tab === 'movie-week' }"
                @click="tab = 'movie-week'"
                type="button"
            >Mingguan</button>
            <button
                class="home-trending__tab-btn"
                :class="{ 'home-trending__tab-btn--active': tab === 'movie-month' }"
                @click="tab = 'movie-month'"
                type="button"
            >Bulanan</button>
        </div>

        <div class="home-trending__tab-group">
            <span class="home-trending__group-label">
                <i class="{{ config('other.font-awesome') }} fa-tv"></i>
                TV Series
            </span>
            <button
                class="home-trending__tab-btn"
                :class="{ 'home-trending__tab-btn--active': tab === 'tv-day' }"
                @click="tab = 'tv-day'"
                type="button"
            >Harian</button>
            <button
                class="home-trending__tab-btn"
                :class="{ 'home-trending__tab-btn--active': tab === 'tv-week' }"
                @click="tab = 'tv-week'"
                type="button"
            >Mingguan</button>
            <button
                class="home-trending__tab-btn"
                :class="{ 'home-trending__tab-btn--active': tab === 'tv-month' }"
                @click="tab = 'tv-month'"
                type="button"
            >Bulanan</button>
        </div>
    </div>

    @foreach ($tabs as $key => $items)
        <div
            class="home-trending__poster-row"
            x-show="tab === '{{ $key }}'"
            x-cloak
        >
            @forelse ($items as $ranking)
                <figure class="trending-poster home-trending__poster-item">
                    @if (str_starts_with($key, 'movie'))
                        <x-movie.poster
                            :movie="$ranking->movie"
                            :categoryId="$ranking->category_id"
                            :tmdb="$ranking->tmdb_movie_id"
                        />
                    @else
                        <x-tv.poster
                            :tv="$ranking->tv"
                            :categoryId="$ranking->category_id"
                            :tmdb="$ranking->tmdb_tv_id"
                        />
                    @endif
                    <figcaption
                        class="trending-poster__download-count"
                        title="{{ __('torrent.completed-times') }}"
                    >
                        {{ $ranking->download_count }}
                    </figcaption>
                </figure>
            @empty
                <p class="home-trending__empty">Tiada data untuk tempoh ini.</p>
            @endforelse
        </div>
    @endforeach
</section>

@extends('layout.with-main')

@section('title')
    <title>Festival Filem Malaysia - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Senarai filem-filem pemenang Festival Filem Malaysia di {{ config('other.title') }}." />
@endsection

@section('breadcrumbs')
    <li class="breadcrumb--active">
        Festival Filem Malaysia
    </li>
@endsection

@section('page', 'page__ffm')

@section('main')
    <section class="panelV2 ffm-hero">
        <div class="ffm-hero__inner">
            <h1 class="ffm-hero__title">Festival Filem Malaysia</h1>
            <p class="ffm-hero__subtitle">
                Senarai filem-filem Malaysia yang telah memenangi atau dicalonkan dalam Festival Filem Malaysia (FFM).
                <a href="https://www.themoviedb.org/list/8679422-festival-filem-malaysia" target="_blank" rel="noopener noreferrer" class="ffm-hero__tmdb-link">
                    <i class="{{ config('other.font-awesome') }} fa-arrow-up-right-from-square"></i> TMDB List
                </a>
            </p>
        </div>
    </section>

    @forelse ($entries as $entry)
        @php $movie = $entry->movie; @endphp

        <article class="panelV2 ffm-entry">
            <div class="ffm-entry__rank">#{{ $entry->position }}</div>

            @if ($movie)
                <div class="ffm-entry__inner">
                    {{-- Poster --}}
                    <div class="ffm-entry__poster-col">
                        @if ($movie->poster)
                            <img
                                class="ffm-entry__poster"
                                src="{{ tmdb_image('poster_mid', $movie->poster) }}"
                                alt="{{ $movie->title }}"
                            />
                        @else
                            <div class="ffm-entry__poster ffm-entry__poster--placeholder">
                                <i class="{{ config('other.font-awesome') }} fa-film"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="ffm-entry__info">
                        <h2 class="ffm-entry__title">
                            @if ($movie->torrents->count() > 0)
                                <a href="{{ route('torrents.similar', ['category_id' => 1, 'tmdb' => $movie->id]) }}" class="ffm-entry__title-link">
                                    {{ $movie->title }}
                                </a>
                            @else
                                {{ $movie->title }}
                            @endif
                            @if ($movie->release_date)
                                <span class="ffm-entry__release-year">{{ $movie->release_date->format('Y') }}</span>
                            @endif
                        </h2>

                        @if ($movie->tagline)
                            <p class="ffm-entry__tagline">{{ $movie->tagline }}</p>
                        @endif

                        @if ($movie->overview)
                            <p class="ffm-entry__overview">{{ $movie->overview }}</p>
                        @endif

                        <div class="ffm-entry__chips">
                            @foreach ($movie->genres->take(4) as $genre)
                                <span class="ffm-entry__chip">{{ $genre->name }}</span>
                            @endforeach
                            @foreach ($movie->directors->take(2) as $director)
                                <span class="ffm-entry__chip ffm-entry__chip--director">
                                    <i class="{{ config('other.font-awesome') }} fa-clapperboard"></i>
                                    {{ $director->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    {{-- Score + Torrent Stats --}}
                    <div class="ffm-entry__side">
                        @if ($entry->award_year)
                            <div class="ffm-entry__year-badge">FFM {{ $entry->award_year }}</div>
                        @endif

                        @if ($movie->vote_average > 0)
                            <div class="ffm-entry__score">
                                <span class="ffm-entry__score-num">{{ number_format((float) $movie->vote_average, 2) }}</span>
                                <span class="ffm-entry__score-label">TMDB</span>
                            </div>
                        @endif

                        @php
                            $torrents = $movie->torrents;
                            $seeders   = $torrents->sum('seeders');
                            $leechers  = $torrents->sum('leechers');
                            $completed = $torrents->sum('times_completed');
                        @endphp

                        @if ($torrents->count() > 0)
                            <div class="ffm-entry__torrent-stats">
                                <a
                                    href="{{ route('torrents.similar', ['category_id' => 1, 'tmdb' => $movie->id]) }}"
                                    class="ffm-entry__stat ffm-entry__stat--seed"
                                    title="Seeders"
                                >
                                    <i class="{{ config('other.font-awesome') }} fa-arrow-up"></i>
                                    {{ number_format($seeders) }}
                                </a>
                                <a
                                    href="{{ route('torrents.similar', ['category_id' => 1, 'tmdb' => $movie->id]) }}"
                                    class="ffm-entry__stat ffm-entry__stat--leech"
                                    title="Leechers"
                                >
                                    <i class="{{ config('other.font-awesome') }} fa-arrow-down"></i>
                                    {{ number_format($leechers) }}
                                </a>
                                <a
                                    href="{{ route('torrents.similar', ['category_id' => 1, 'tmdb' => $movie->id]) }}"
                                    class="ffm-entry__stat ffm-entry__stat--completed"
                                    title="Completed"
                                >
                                    <i class="{{ config('other.font-awesome') }} fa-check"></i>
                                    {{ number_format($completed) }}
                                </a>
                            </div>
                        @else
                            <div class="ffm-entry__no-torrent">
                                <i class="{{ config('other.font-awesome') }} fa-circle-xmark"></i>
                                Tiada torrent
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="ffm-entry__inner ffm-entry__inner--missing">
                    <p>Maklumat filem tidak tersedia. TMDB ID: {{ $entry->tmdb_movie_id }}</p>
                </div>
            @endif
        </article>
    @empty
        <section class="panelV2">
            <div class="panel__body">Tiada entri dalam senarai ini.</div>
        </section>
    @endforelse
@endsection

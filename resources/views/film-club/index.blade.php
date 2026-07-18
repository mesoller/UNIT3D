@extends('layout.with-main-and-sidebar')

@section('title')
    {{ __('film-club.page-title') }}
@endsection

@section('page', 'page__film-club')

@section('main')
    {{-- ── Film of the Month ─────────────────────────────────────────── --}}
    @if ($filmOfMonth && $filmOfMonth->movie)
        @php $movie = $filmOfMonth->movie; @endphp

        <section class="panelV2 fc-feature">
            <header class="panel__header">
                <h2 class="panel__heading">
                    <i class="{{ config('other.font-awesome') }} fa-film"></i>
                    {{ __('film-club.film-of-month', ['month' => \Carbon\Carbon::createFromFormat('Y-m', $filmOfMonth->year_month)->translatedFormat('F Y')]) }}
                </h2>
            </header>

            @if ($movie->backdrop)
                <div
                    class="fc-feature__backdrop"
                    style="background-image: url('{{ tmdb_image('back_big', $movie->backdrop) }}')"
                ></div>
            @endif

            <div class="fc-feature__body">
                <div class="fc-feature__poster-col">
                    <img
                        class="fc-feature__poster"
                        src="{{ $movie->poster ? tmdb_image('poster_big', $movie->poster) : 'https://via.placeholder.com/400x600?text=No+Poster' }}"
                        alt="{{ $movie->title }}"
                    />
                </div>

                <div class="fc-feature__info">
                    <h1 class="fc-feature__title">
                        {{ $movie->title }}
                        @if ($movie->release_date)
                            <span class="fc-feature__year">({{ $movie->release_date->format('Y') }})</span>
                        @endif
                    </h1>

                    <div class="fc-feature__badges">
                        <a
                            href="https://www.themoviedb.org/movie/{{ $movie->id }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="fc-feature__tmdb-badge"
                        >
                            <i class="{{ config('other.font-awesome') }} fa-film"></i> TMDB
                        </a>
                        @if ($movie->vote_average)
                            <span class="fc-feature__rating">
                                <i class="{{ config('other.font-awesome') }} fa-star"></i>
                                {{ number_format((float) $movie->vote_average, 1) }}
                            </span>
                        @endif
                        @if ($movie->runtime)
                            <span class="fc-feature__meta-chip">
                                <i class="{{ config('other.font-awesome') }} fa-clock"></i>
                                {{ $movie->runtime }} min
                            </span>
                        @endif
                    </div>

                    @if ($movie->overview)
                        <p class="fc-feature__overview">{{ $movie->overview }}</p>
                    @endif

                    {{-- Torrents on site --}}
                    @php
                        $torrents = $movie->torrents()
                            ->with(['resolution', 'type'])
                            ->where('status', \App\Enums\ModerationStatus::APPROVED)
                            ->orderByDesc('seeders')
                            ->take(5)
                            ->get();
                    @endphp

                    @if ($torrents->isNotEmpty())
                        <div class="fc-feature__watch">
                            <h3 class="fc-feature__section-heading">
                                <i class="{{ config('other.font-awesome') }} fa-play-circle"></i>
                                {{ __('film-club.watch-now') }}
                            </h3>
                            <ul class="fc-feature__torrent-list">
                                @foreach ($torrents as $torrent)
                                    <li class="fc-feature__torrent-item">
                                        @if ($torrent->resolution)
                                            <span class="fc-feature__torrent-chip fc-feature__torrent-chip--res">
                                                {{ $torrent->resolution->name }}
                                            </span>
                                        @endif
                                        @if ($torrent->type)
                                            <span class="fc-feature__torrent-chip">
                                                {{ $torrent->type->name }}
                                            </span>
                                        @endif
                                        <a
                                            class="fc-feature__torrent-link"
                                            href="{{ route('torrents.show', $torrent->id) }}"
                                        >{{ $torrent->name }}</a>
                                        <span class="fc-feature__torrent-seeds">
                                            <i class="{{ config('other.font-awesome') }} fa-arrow-up text-green"></i>
                                            {{ $torrent->seeders }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Forum thread --}}
                    @if ($filmOfMonth->topic)
                        <div class="fc-feature__discuss">
                            <h3 class="fc-feature__section-heading">
                                <i class="{{ config('other.font-awesome') }} fa-comments"></i>
                                {{ __('film-club.discuss') }}
                            </h3>
                            <p>
                                {!! __('film-club.discuss-body', [
                                    'link' => '<a href="' . route('forums.topics.show', $filmOfMonth->topic->id) . '">' . __('film-club.discuss-forum-link') . '</a>',
                                ]) !!}
                            </p>
                        </div>
                    @endif

                    {{-- Credit --}}
                    <p class="fc-feature__credit">
                        {!! __('film-club.credit', [
                            'user'  => $filmOfMonth->suggestedBy
                                ? '<a href="' . route('users.show', $filmOfMonth->suggestedBy->username) . '"><strong>' . e($filmOfMonth->suggestedBy->username) . '</strong></a>'
                                : '<strong>' . __('film-club.anonymous-member') . '</strong>',
                            'votes' => '<strong>' . $filmOfMonth->total_votes . '</strong>',
                        ]) !!}
                    </p>
                </div>
            </div>
        </section>
    @else
        <section class="panelV2">
            <div class="panel__body fc-empty">
                <i class="{{ config('other.font-awesome') }} fa-film fa-3x"></i>
                <p>{{ __('film-club.no-film-this-month') }}</p>
            </div>
        </section>
    @endif

    {{-- ── Suggestions / Voting ──────────────────────────────────────── --}}
    <section class="panelV2 fc-voting" x-data>
        <header class="panel__header">
            <h2 class="panel__heading">
                <i class="{{ config('other.font-awesome') }} fa-vote-yea"></i>
                {{ __('film-club.suggestions-heading') }}
                <span class="fc-voting__month-badge">
                    {{ \Carbon\Carbon::createFromFormat('Y-m', $nextMonth)->translatedFormat('F Y') }}
                </span>
            </h2>
            <div class="panel__actions">
                <div class="panel__action">
                    <span class="fc-voting__slot-count">
                        {{ __('film-club.slots', ['total' => $totalSuggestions, 'max' => $maxSuggestions]) }}
                    </span>
                </div>
            </div>
        </header>

        @if (session('success'))
            <div class="fc-alert fc-alert--success">
                <i class="{{ config('other.font-awesome') }} fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="fc-alert fc-alert--error">
                <i class="{{ config('other.font-awesome') }} fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if ($suggestions->isEmpty())
            <div class="panel__body fc-empty">
                <i class="{{ config('other.font-awesome') }} fa-inbox fa-2x"></i>
                <p>{{ __('film-club.no-suggestions') }}</p>
            </div>
        @else
            <div class="fc-suggestions">
                @foreach ($suggestions as $suggestion)
                    @if ($suggestion->movie)
                        <div class="fc-suggestion-card @if ((int) $userVotedSuggestionId === (int) $suggestion->id) fc-suggestion-card--voted @endif">
                            <div class="fc-suggestion-card__rank">{{ $loop->iteration }}</div>

                            <img
                                class="fc-suggestion-card__poster"
                                src="{{ $suggestion->movie->poster
                                    ? tmdb_image('poster_mid', $suggestion->movie->poster)
                                    : 'https://via.placeholder.com/200x300?text=?' }}"
                                alt="{{ $suggestion->movie->title }}"
                            />

                            <div class="fc-suggestion-card__body">
                                <h3 class="fc-suggestion-card__title">
                                    {{ $suggestion->movie->title }}
                                    @if ($suggestion->movie->release_date)
                                        <span class="fc-suggestion-card__year">
                                            ({{ $suggestion->movie->release_date->format('Y') }})
                                        </span>
                                    @endif
                                </h3>

                                @if ($suggestion->movie->overview)
                                    <p class="fc-suggestion-card__overview">
                                        {{ Str::limit($suggestion->movie->overview, 140) }}
                                    </p>
                                @endif

                                <div class="fc-suggestion-card__footer">
                                    <span class="fc-suggestion-card__by">
                                        {{ __('film-club.by') }}
                                        <a href="{{ route('users.show', $suggestion->user->username) }}">
                                            {{ $suggestion->user->username }}
                                        </a>
                                    </span>

                                    <span class="fc-suggestion-card__votes">
                                        <i class="{{ config('other.font-awesome') }} fa-heart"></i>
                                        {{ $suggestion->votes_count }}
                                        {{ trans_choice(__('film-club.vote-singular') . '|' . __('film-club.vote-plural'), $suggestion->votes_count) }}
                                    </span>
                                </div>
                            </div>

                            <div class="fc-suggestion-card__action">
                                @if ((int) $userVotedSuggestionId === (int) $suggestion->id)
                                    <span class="fc-suggestion-card__voted-badge">
                                        <i class="{{ config('other.font-awesome') }} fa-check"></i>
                                        {{ __('film-club.your-vote') }}
                                    </span>
                                @elseif ($userVotedSuggestionId !== null)
                                    <span class="fc-suggestion-card__voted-other">{{ __('film-club.already-voted') }}</span>
                                @else
                                    <form
                                        method="POST"
                                        action="{{ route('film_club.vote', $suggestion->id) }}"
                                    >
                                        @csrf
                                        <button
                                            class="fc-suggestion-card__vote-btn"
                                            type="submit"
                                        >
                                            <i class="{{ config('other.font-awesome') }} fa-heart"></i>
                                            {{ __('film-club.vote') }}
                                        </button>
                                    </form>
                                @endif

                                {{-- Staff: set as winner --}}
                                @if (auth()->user()->group->is_admin || auth()->user()->group->is_modo)
                                    <button
                                        class="fc-suggestion-card__winner-btn"
                                        type="button"
                                        x-on:click="$refs.winnerModal.showModal()"
                                        x-on:click.stop="
                                            $refs.winnerSuggId.value = '{{ $suggestion->id }}';
                                            $refs.winnerMonth.value = '{{ now()->format('Y-m') }}'
                                        "
                                    >
                                        <i class="{{ config('other.font-awesome') }} fa-trophy"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        {{-- Staff winner modal --}}
        @if (auth()->user()->group->is_admin || auth()->user()->group->is_modo)
            <dialog class="fc-dialog" x-ref="winnerModal">
                <div class="fc-dialog__inner">
                    <h3 class="fc-dialog__title">
                        <i class="{{ config('other.font-awesome') }} fa-trophy text-gold"></i>
                        {{ __('film-club.set-winner-title') }}
                    </h3>
                    <p class="fc-dialog__desc">
                        {{ __('film-club.set-winner-desc') }}
                    </p>
                    <form method="POST" action="{{ route('film_club.set_winner') }}">
                        @csrf
                        <input type="hidden" name="suggestion_id" x-ref="winnerSuggId" value="">
                        <div class="fc-dialog__field">
                            <label class="fc-dialog__label">{{ __('film-club.set-winner-month-label') }}</label>
                            <input
                                class="form__text"
                                type="month"
                                name="year_month"
                                x-ref="winnerMonth"
                                value="{{ now()->format('Y-m') }}"
                            />
                        </div>
                        <div class="fc-dialog__actions">
                            <button
                                class="fc-dialog__cancel"
                                type="button"
                                x-on:click="$refs.winnerModal.close()"
                            >{{ __('film-club.cancel') }}</button>
                            <button class="fc-dialog__confirm" type="submit">
                                <i class="{{ config('other.font-awesome') }} fa-trophy"></i>
                                {{ __('film-club.set-winner-confirm') }}
                            </button>
                        </div>
                    </form>
                </div>
            </dialog>
        @endif
    </section>
@endsection

@section('sidebar')
    {{-- ── Suggest Button + Form ─────────────────────────────────────── --}}
    <section
        class="panelV2 fc-suggest-panel"
        x-data="{
            open: false,
            query: '',
            results: [],
            selected: null,
            loading: false,
            async search() {
                if (this.query.length < 2) { this.results = []; return; }
                this.loading = true;
                const r = await fetch('/film-club/search?q=' + encodeURIComponent(this.query));
                this.results = await r.json();
                this.loading = false;
            },
            pick(movie) {
                this.selected = movie;
                this.query = movie.title + (movie.year ? ' (' + movie.year + ')' : '');
                this.results = [];
            },
            reset() { this.open = false; this.query = ''; this.results = []; this.selected = null; }
        }"
    >
        @if ($userHasSuggested)
            <div class="panel__body fc-suggest-panel__done">
                <i class="{{ config('other.font-awesome') }} fa-check-circle"></i>
                <p>{{ __('film-club.already-suggested') }}</p>
            </div>
        @elseif ($totalSuggestions >= $maxSuggestions)
            <div class="panel__body fc-suggest-panel__full">
                <i class="{{ config('other.font-awesome') }} fa-lock"></i>
                <p>{{ __('film-club.suggestions-full') }}</p>
            </div>
        @else
            <div class="panel__body">
                <button
                    class="fc-suggest-panel__btn"
                    type="button"
                    x-on:click="open = true"
                >
                    <i class="{{ config('other.font-awesome') }} fa-plus"></i>
                    {{ __('film-club.suggest-btn') }}
                </button>
            </div>

            <dialog class="fc-dialog" x-bind:open="open" x-show="open" x-cloak>
                <div class="fc-dialog__inner">
                    <h3 class="fc-dialog__title">
                        <i class="{{ config('other.font-awesome') }} fa-search text-gold"></i>
                        {{ __('film-club.suggest-title') }}
                    </h3>

                    <form method="POST" action="{{ route('film_club.store') }}">
                        @csrf
                        <input type="hidden" name="tmdb_movie_id" x-bind:value="selected ? selected.id : ''">

                        <div class="fc-dialog__field">
                            <label class="fc-dialog__label">{{ __('film-club.search-label') }}</label>
                            <input
                                class="form__text"
                                type="text"
                                placeholder="{{ __('film-club.search-placeholder') }}"
                                x-model="query"
                                x-on:input.debounce.300ms="search()"
                                autocomplete="off"
                            />

                            <div class="fc-search-results" x-show="results.length > 0" x-cloak>
                                <template x-for="movie in results" :key="movie.id">
                                    <div
                                        class="fc-search-result"
                                        x-on:click="pick(movie)"
                                    >
                                        <img
                                            class="fc-search-result__poster"
                                            x-bind:src="movie.poster_url || 'https://via.placeholder.com/46x69?text=?'"
                                            x-bind:alt="movie.title"
                                        />
                                        <div class="fc-search-result__info">
                                            <span class="fc-search-result__title" x-text="movie.title"></span>
                                            <span class="fc-search-result__year" x-text="movie.year"></span>
                                        </div>
                                    </div>
                                </template>
                                <div class="fc-search-results__loading" x-show="loading">
                                    <i class="{{ config('other.font-awesome') }} fa-spinner fa-spin"></i>
                                </div>
                            </div>
                        </div>

                        <div class="fc-selected-movie" x-show="selected" x-cloak>
                            <img
                                class="fc-selected-movie__poster"
                                x-bind:src="selected?.poster_url || ''"
                                x-bind:alt="selected?.title"
                            />
                            <div class="fc-selected-movie__info">
                                <strong x-text="selected?.title"></strong>
                                <span x-text="selected?.year"></span>
                            </div>
                        </div>

                        <div class="fc-dialog__actions">
                            <button
                                class="fc-dialog__cancel"
                                type="button"
                                x-on:click="reset()"
                            >{{ __('film-club.cancel') }}</button>
                            <button
                                class="fc-dialog__confirm"
                                type="submit"
                                x-bind:disabled="!selected"
                            >
                                <i class="{{ config('other.font-awesome') }} fa-paper-plane"></i>
                                {{ __('film-club.submit-suggestion') }}
                            </button>
                        </div>
                    </form>
                </div>
            </dialog>
        @endif
    </section>

    {{-- ── Rules ────────────────────────────────────────────────────── --}}
    <section class="panelV2 fc-rules">
        <header class="panel__header">
            <h2 class="panel__heading">
                <i class="{{ config('other.font-awesome') }} fa-info-circle"></i>
                {{ __('film-club.rules-heading') }}
            </h2>
        </header>
        <div class="panel__body fc-rules__body">
            <p>{{ __('film-club.rules-intro') }}</p>

            <h4 class="fc-rules__heading">{{ __('film-club.suggestion-rules-heading') }}</h4>
            <ul class="fc-rules__list">
                @foreach (__('film-club.suggestion-rules') as $rule)
                    <li>{{ $rule }}</li>
                @endforeach
            </ul>

            <h4 class="fc-rules__heading">{{ __('film-club.voting-rules-heading') }}</h4>
            <ul class="fc-rules__list">
                @foreach (__('film-club.voting-rules') as $rule)
                    <li>{{ $rule }}</li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- ── Past Winners ─────────────────────────────────────────────── --}}
    @if ($pastWinners->isNotEmpty())
        <section class="panelV2 fc-past">
            <header class="panel__header">
                <h2 class="panel__heading">
                    <i class="{{ config('other.font-awesome') }} fa-history"></i>
                    {{ __('film-club.past-winners') }}
                </h2>
            </header>
            <ul class="fc-past__list">
                @foreach ($pastWinners as $winner)
                    @if ($winner->movie)
                        <li class="fc-past__item">
                            <img
                                class="fc-past__poster"
                                src="{{ $winner->movie->poster
                                    ? tmdb_image('poster_small', $winner->movie->poster)
                                    : 'https://via.placeholder.com/46x69?text=?' }}"
                                alt="{{ $winner->movie->title }}"
                            />
                            <div class="fc-past__info">
                                <span class="fc-past__title">{{ $winner->movie->title }}</span>
                                <span class="fc-past__month">
                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $winner->year_month)->translatedFormat('M Y') }}
                                    · {{ __('film-club.past-votes', ['votes' => $winner->total_votes]) }}
                                </span>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </section>
    @endif
@endsection

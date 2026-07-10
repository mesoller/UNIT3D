@props([
    'torrent',
    'meta',
    'personalFreeleech',
])

@php
    $alwaysFreeleech = $personalFreeleech
        || $torrent->freeleech_tokens_exists
        || auth()->user()->group->is_freeleech
        || auth()->user()->is_donor
        || config('other.freeleech');

    $isFreeleech = $alwaysFreeleech || $torrent->free > 0 || $torrent->featured;

    $posterUrl = match (true) {
        ($torrent->category->movie_meta || $torrent->category->tv_meta) && isset($meta->poster)
            => tmdb_image('poster_small', $meta->poster),
        $torrent->category->game_meta && isset($meta->cover_image_id)
            => 'https://images.igdb.com/igdb/image/upload/t_cover_small_2x/' . $meta->cover_image_id . '.png',
        $torrent->category->no_meta && Storage::disk('torrent-covers')->exists("torrent-cover_{$torrent->id}.jpg")
            => route('authenticated_images.torrent_cover', ['id' => $torrent->id]),
        default => url('img/profile.png'),
    };

    $similarUrl = match (true) {
        $torrent->tmdb_movie_id !== null => route('torrents.similar', ['category_id' => $torrent->category_id, 'tmdb' => $torrent->tmdb_movie_id]),
        $torrent->tmdb_tv_id !== null    => route('torrents.similar', ['category_id' => $torrent->category_id, 'tmdb' => $torrent->tmdb_tv_id]),
        $torrent->igdb !== null          => route('torrents.similar', ['category_id' => $torrent->category_id, 'tmdb' => $torrent->igdb]),
        default                          => '#',
    };

    if ($torrent->category->game_meta) {
        $ratingLabel = round($meta->rating ?? 0) . '%';
        $ratingClass = rating_color($meta->rating ?? 0) ?? 'text-white';
    } elseif ($torrent->category->movie_meta || $torrent->category->tv_meta) {
        $ratingLabel = number_format(round(($meta->vote_average ?? 0) * 10)) . '%';
        $ratingClass = rating_color($meta->vote_average ?? 0) ?? 'text-white';
    } else {
        $ratingLabel = null;
        $ratingClass = '';
    }
@endphp

<tr
    @class([
        'torrent-search--list__row',
        'torrent-search--list__sticky-row' => $torrent->sticky,
    ])
    data-torrent-id="{{ $torrent->id }}"
    data-igdb-id="{{ $torrent->igdb }}"
    data-imdb-id="{{ $torrent->imdb }}"
    data-tmdb-id="{{ $torrent->tmdb }}"
    data-tvdb-id="{{ $torrent->tvdb }}"
    data-mal-id="{{ $torrent->mal }}"
    data-category-id="{{ $torrent->category_id }}"
    data-type-id="{{ $torrent->type_id }}"
    data-resolution-id="{{ $torrent->resolution_id }}"
    wire:key="torrent-search-row-{{ $torrent->id }}"
>
    {{-- Poster --}}
    <td class="torrent-search--list__poster">
        <a href="{{ $similarUrl }}">
            <img
                class="torrent-search--list__poster-img"
                src="{{ $posterUrl }}"
                alt="{{ $torrent->name }}"
                loading="lazy"
            />
        </a>
    </td>

    {{-- Overview: title + tags --}}
    <td class="torrent-search--list__overview">
        {{-- Title row --}}
        <div class="tt-card__title-row">
            <a class="tt-card__name tsl__name" href="{{ route('torrents.show', ['id' => $torrent->id]) }}">
                {{ $torrent->name }}
            </a>
            <div class="tt-card__title-actions">
                @if (auth()->user()->group->is_editor || auth()->user()->group->is_modo || auth()->id() === $torrent->user_id)
                    <a
                        class="tt-card__icon-btn"
                        href="{{ route('torrents.edit', ['id' => $torrent->id]) }}"
                        title="{{ __('common.edit') }}"
                    >
                        <i class="{{ config('other.font-awesome') }} fa-pencil-alt"></i>
                    </a>
                @endif
                <button
                    class="tt-card__icon-btn"
                    x-data="bookmark({{ $torrent->id }}, {{ Js::from($torrent->bookmarks_exists) }})"
                    x-bind="button"
                    title="{{ __('torrent.bookmark') }}"
                >
                    <i class="{{ config('other.font-awesome') }}" x-bind="icon"></i>
                </button>
                @if (config('torrent.download_check_page'))
                    <a
                        class="tt-card__icon-btn"
                        href="{{ route('download_check', ['id' => $torrent->id]) }}"
                        title="{{ __('common.download') }}"
                    >
                        <i class="{{ config('other.font-awesome') }} fa-download"></i>
                    </a>
                @else
                    <a
                        class="tt-card__icon-btn"
                        href="{{ route('download', ['id' => $torrent->id]) }}"
                        title="{{ __('common.download') }}"
                    >
                        <i class="{{ config('other.font-awesome') }} fa-download"></i>
                    </a>
                @endif
                @if (config('torrent.magnet'))
                    <a
                        class="tt-card__icon-btn"
                        href="magnet:?dn={{ $torrent->name }}&xt=urn:btih:{{ bin2hex($torrent->info_hash) }}&as={{ route('torrent.download.rsskey', ['id' => $torrent->id, 'rsskey' => auth()->user()->rsskey]) }}&tr={{ route('announce', ['passkey' => auth()->user()->passkey]) }}&xl={{ $torrent->size }}"
                        download
                        title="{{ __('common.magnet') }}"
                    >
                        <i class="{{ config('other.font-awesome') }} fa-magnet"></i>
                    </a>
                @endif
            </div>
        </div>

        {{-- Tags row --}}
        <div class="tt-card__tags">
            {{-- Category icon --}}
            @if ($torrent->category->image !== null)
                <img
                    class="tt-card__category-img"
                    src="{{ route('authenticated_images.category_image', ['category' => $torrent->category]) }}"
                    title="{{ $torrent->category->name }}"
                    alt="{{ $torrent->category->name }}"
                    loading="lazy"
                />
            @else
                <i class="{{ $torrent->category->icon }} tt-card__category-icon" title="{{ $torrent->category->name }}"></i>
            @endif

            {{-- Resolution + type --}}
            @if (($torrent->category->movie_meta || $torrent->category->tv_meta) && $torrent->resolution)
                <span class="tt-card__badge tt-card__badge--resolution">{{ $torrent->resolution->name }}</span>
            @endif
            <span class="tt-card__badge tt-card__badge--type">{{ $torrent->type->name }}</span>

            {{-- Uploader --}}
            <x-user-tag class="tt-card__uploader" :user="$torrent->user" :anon="$torrent->anon" />

            {{-- Thanks --}}
            <a
                class="tt-card__action-badge tt-card__action-badge--thanks"
                href="{{ route('torrents.show', ['id' => $torrent->id]) }}#thanks"
                title="{{ __('common.thanks') }}"
            >
                <i class="{{ config('other.font-awesome') }} fa-heart"></i>
                {{ $torrent->thanks_count ?? 0 }}
            </a>

            {{-- Comments --}}
            <a
                class="tt-card__action-badge tt-card__action-badge--comments"
                href="{{ route('torrents.show', ['id' => $torrent->id]) }}#comments"
                title="{{ __('torrent.comments') }}"
            >
                <i class="{{ config('other.font-awesome') }} fa-comment"></i>
                {{ $torrent->comments_count ?? 0 }}
            </a>

            {{-- Freeleech --}}
            @if ($isFreeleech)
                <span class="tt-card__action-badge tt-card__action-badge--fl" title="{{ __('torrent.freeleech') }}">
                    <i class="{{ config('other.font-awesome') }} fa-star"></i>
                    FL
                </span>
            @endif

            {{-- Double upload --}}
            @if (config('other.doubleup') || auth()->user()->group->is_double_upload || $torrent->doubleup || $torrent->featured)
                <span class="tt-card__action-badge tt-card__action-badge--du" title="{{ __('torrent.double-upload') }}">
                    <i class="{{ config('other.font-awesome') }} fa-chevron-double-up"></i>
                    2×
                </span>
            @endif

            {{-- Small status icons --}}
            @if ($torrent->internal)
                <i class="{{ config('other.font-awesome') }} fa-magic torrent-icons__internal tsl__small-icon" title="{{ __('torrent.internal-release') }}"></i>
            @endif
            @if ($torrent->personal_release)
                <i class="{{ config('other.font-awesome') }} fa-user-plus torrent-icons__personal-release tsl__small-icon" title="Personal release"></i>
            @endif
            @if ($torrent->sticky)
                <i class="{{ config('other.font-awesome') }} fa-thumbtack torrent-icons__sticky tsl__small-icon" title="{{ __('torrent.sticky') }}"></i>
            @endif
            @if ($torrent->highspeed)
                <i class="{{ config('other.font-awesome') }} fa-bolt-lightning torrent-icons__highspeed tsl__small-icon" title="{{ __('common.high-speeds') }}"></i>
            @endif
            @if ($torrent->trump_exists)
                <i class="{{ config('other.font-awesome') }} fa-skull-crossbones tsl__small-icon" style="color: lightcoral" title="Trumpable: {{ $torrent->trump->reason }}"></i>
            @endif
        </div>
    </td>

    {{-- Rating --}}
    <td class="torrent-search--list__rating">
        @if ($ratingLabel !== null)
            <span class="{{ $ratingClass }}">{{ $ratingLabel }}</span>
        @else
            <span class="tsl__na">—</span>
        @endif
    </td>

    {{-- Size --}}
    <td class="torrent-search--list__size">
        <span>{{ $torrent->getSize() }}</span>
    </td>

    {{-- Seeders --}}
    <td
        @class([
            'torrent-search--list__seeders',
            'torrent-activity-indicator--seeding' => $torrent->seeding,
        ])
        @if ($torrent->seeding)
            title="{{ __('torrent.currently-seeding') }}"
        @endif
    >
        <a class="torrent__seeder-count" href="{{ route('peers', ['id' => $torrent->id]) }}">
            {{ $torrent->seeds_count ?? $torrent->seeders }}
        </a>
    </td>

    {{-- Leechers --}}
    <td
        @class([
            'torrent-search--list__leechers',
            'torrent-activity-indicator--leeching' => $torrent->leeching,
        ])
        @if ($torrent->leeching)
            title="{{ __('torrent.currently-leeching') }}"
        @endif
    >
        <a class="torrent__leecher-count" href="{{ route('peers', ['id' => $torrent->id]) }}">
            {{ $torrent->leeches_count ?? $torrent->leechers }}
        </a>
    </td>

    {{-- Completed --}}
    <td
        @class([
            'torrent-search--list__completed',
            'torrent-activity-indicator--completed' => $torrent->completed,
        ])
        @if ($torrent->completed)
            title="{{ __('torrent.completed') }}"
        @endif
    >
        <a class="torrent__times-completed-count" href="{{ route('history', ['id' => $torrent->id]) }}">
            {{ $torrent->times_completed }}
        </a>
    </td>

    {{-- Age --}}
    <td class="torrent-search--list__age">
        <time datetime="{{ $torrent->created_at }}" title="{{ $torrent->created_at }}">
            {{ $torrent->created_at->diffForHumans() }}
        </time>
    </td>
</tr>

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
        default => url('img/profile.png'),
    };

    $similarUrl = match (true) {
        $torrent->tmdb_movie_id !== null => route('torrents.similar', ['category_id' => $torrent->category_id, 'tmdb' => $torrent->tmdb_movie_id]),
        $torrent->tmdb_tv_id !== null    => route('torrents.similar', ['category_id' => $torrent->category_id, 'tmdb' => $torrent->tmdb_tv_id]),
        $torrent->igdb !== null          => route('torrents.similar', ['category_id' => $torrent->category_id, 'tmdb' => $torrent->igdb]),
        default                          => '#',
    };

    if ($torrent->category->game_meta) {
        $ratingValue = round($meta->rating ?? 0);
        $ratingLabel = $ratingValue . '%';
        $ratingClass = rating_color($meta->rating ?? 0) ?? 'text-white';
    } elseif ($torrent->category->movie_meta || $torrent->category->tv_meta) {
        $ratingValue = round(($meta->vote_average ?? 0), 1);
        $ratingLabel = number_format($ratingValue, 1) . '/10';
        $ratingClass = rating_color($meta->vote_average ?? 0) ?? 'text-white';
    } else {
        $ratingLabel = null;
        $ratingClass = '';
    }
@endphp

<div class="tt-card" data-torrent-id="{{ $torrent->id }}" wire:key="tt-card-{{ $torrent->id }}">
    {{-- Poster --}}
    <a class="tt-card__poster" href="{{ $similarUrl }}">
        <img
            class="tt-card__poster-img"
            src="{{ $posterUrl }}"
            alt="{{ $torrent->name }}"
            loading="lazy"
        />
    </a>

    {{-- Main content --}}
    <div class="tt-card__body">
        {{-- Title row --}}
        <div class="tt-card__title-row">
            <a class="tt-card__name" href="{{ route('torrents.show', ['id' => $torrent->id]) }}">
                {{ $torrent->name }}
            </a>
            <div class="tt-card__title-actions">
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
            </div>
        </div>

        {{-- Tags row: category, resolution, type, uploader, action badges --}}
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

            {{-- Action badges --}}
            <a
                class="tt-card__action-badge tt-card__action-badge--thanks"
                href="{{ route('torrents.show', ['id' => $torrent->id]) }}#thanks"
                title="{{ __('common.thanks') }}"
            >
                <i class="{{ config('other.font-awesome') }} fa-heart"></i>
                {{ $torrent->thanks_count ?? 0 }}
            </a>

            <a
                class="tt-card__action-badge tt-card__action-badge--comments"
                href="{{ route('torrents.show', ['id' => $torrent->id]) }}#comments"
                title="{{ __('torrent.comments') }}"
            >
                <i class="{{ config('other.font-awesome') }} fa-comment"></i>
                {{ $torrent->comments_count ?? 0 }}
            </a>

            @if ($isFreeleech)
                <span class="tt-card__action-badge tt-card__action-badge--fl" title="{{ __('torrent.freeleech') }}">
                    <i class="{{ config('other.font-awesome') }} fa-star"></i>
                    FL
                </span>
            @endif

            @if (config('other.doubleup') || auth()->user()->group->is_double_upload || $torrent->doubleup || $torrent->featured)
                <span class="tt-card__action-badge tt-card__action-badge--du" title="{{ __('torrent.double-upload') }}">
                    <i class="{{ config('other.font-awesome') }} fa-chevron-double-up"></i>
                    2×
                </span>
            @endif
        </div>

        {{-- Stats row --}}
        <div class="tt-card__stats">
            @if ($ratingLabel !== null)
                <span class="tt-card__stat tt-card__stat--rating {{ $ratingClass }}">
                    <i class="{{ config('other.font-awesome') }} fa-star"></i>
                    {{ $ratingLabel }}
                </span>
            @endif

            <span class="tt-card__stat tt-card__stat--size">
                <i class="{{ config('other.font-awesome') }} fa-hdd"></i>
                {{ $torrent->getSize() }}
            </span>

            <a
                class="tt-card__stat tt-card__stat--seeds text-green"
                href="{{ route('peers', ['id' => $torrent->id]) }}"
                title="{{ __('torrent.seeders') }}"
            >
                <i class="{{ config('other.font-awesome') }} fa-arrow-up"></i>
                {{ $torrent->seeds_count ?? $torrent->seeders }}
            </a>

            <a
                class="tt-card__stat tt-card__stat--leeches"
                href="{{ route('peers', ['id' => $torrent->id]) }}"
                title="{{ __('torrent.leechers') }}"
            >
                <i class="{{ config('other.font-awesome') }} fa-arrow-down"></i>
                {{ $torrent->leeches_count ?? $torrent->leechers }}
            </a>

            <a
                class="tt-card__stat tt-card__stat--completed"
                href="{{ route('history', ['id' => $torrent->id]) }}"
                title="{{ __('torrent.completed') }}"
            >
                <i class="{{ config('other.font-awesome') }} fa-check"></i>
                {{ $torrent->times_completed }}
            </a>

            <time
                class="tt-card__stat tt-card__stat--age"
                datetime="{{ $torrent->created_at }}"
                title="{{ $torrent->created_at }}"
            >
                {{ $torrent->created_at->diffForHumans() }}
            </time>
        </div>
    </div>
</div>

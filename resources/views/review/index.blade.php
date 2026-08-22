@extends('layout.with-main')

@section('title')
    <title>Ulasan - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Semak dan cari ulasan pengguna untuk filem, siri TV dan permainan di {{ config('other.title') }}." />
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('forums.index') }}" class="breadcrumb__link">Komuniti</a>
    </li>
    <li class="breadcrumb--active">Ulasan</li>
@endsection

@section('page', 'page__reviews')

@section('main')
    <section class="panelV2 reviews-hero">
        <div class="reviews-hero__inner">
            <div class="reviews-hero__icon-wrap">
                <i class="{{ config('other.font-awesome') }} fa-star reviews-hero__icon"></i>
            </div>
            <div class="reviews-hero__info">
                <h1 class="reviews-hero__title">Ulasan</h1>
                <p class="reviews-hero__subtitle">Semak dan cari ulasan pengguna merentas laman.</p>
            </div>
            <div class="reviews-hero__count">
                <span class="reviews-hero__count-number">{{ number_format($reviews->total()) }}</span>
                <span class="reviews-hero__count-label">ULASAN</span>
            </div>
        </div>
    </section>

    <section class="panelV2 reviews-list-panel">
        @forelse ($reviews as $review)
            @php
                $reviewer = $review->is_anonymous ? null : $review->user;
                $mediaTitle = $review->mediaTitle();
                $mediaYear  = $review->mediaYear();
                $mediaType  = $review->mediaType();
                $mediaRoute = $review->mediaRoute();
            @endphp
            <div class="review-item">
                <div class="review-item__header">
                    <div class="review-item__user">
                        @if ($review->is_anonymous || !$reviewer)
                            <img src="{{ url('img/profile.png') }}" class="review-item__avatar" alt="Anonymous" />
                        @else
                            <a href="{{ route('users.show', $reviewer->username) }}">
                                <img
                                    src="{{ $reviewer->image ? route('authenticated_images.user_avatar', ['user' => $reviewer]) : url('img/profile.png') }}"
                                    class="review-item__avatar"
                                    alt="{{ $reviewer->username }}"
                                />
                            </a>
                        @endif
                        <div class="review-item__meta">
                            @if ($review->is_anonymous || !$reviewer)
                                <span class="review-item__username" style="color:#aaa;">
                                    <i class="{{ config('other.font-awesome') }} fa-user-secret"></i> Anonymous
                                </span>
                            @else
                                <a
                                    class="review-item__username"
                                    href="{{ route('users.show', $reviewer->username) }}"
                                    style="color: {{ $reviewer->group->color }};"
                                >
                                    @if ($reviewer->group->icon)
                                        <i class="{{ config('other.font-awesome') }} {{ $reviewer->group->icon }}"></i>
                                    @endif
                                    {{ $reviewer->username }}
                                </a>
                            @endif
                            <div class="review-item__rating">
                                <i class="{{ config('other.font-awesome') }} fa-star" style="color:#ffd700;"></i>
                                <strong>{{ $review->rating }}/10</strong>
                                <span class="review-item__time">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="review-item__actions">
                        <form action="{{ route('reviews.thank', $review) }}" method="POST" style="display:inline;">
                            @csrf
                            @php $thanked = $review->thanks->contains('user_id', auth()->id()); @endphp
                            <button
                                type="submit"
                                class="review-item__thank-btn{{ $thanked ? ' review-item__thank-btn--active' : '' }}"
                                @if ($review->user_id === auth()->id()) disabled @endif
                            >
                                <i class="{{ config('other.font-awesome') }} fa-heart"></i>
                                Thank ({{ $review->thanks->count() }})
                            </button>
                        </form>
                        @if (auth()->id() === $review->user_id || auth()->user()->group->is_modo)
                            <form action="{{ route('reviews.destroy', $review) }}" method="POST" style="display:inline;"
                                onsubmit="return confirm('Padam ulasan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="review-item__delete-btn">
                                    <i class="{{ config('other.font-awesome') }} fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="review-item__media-label">
                    <span class="review-item__media-type">{{ $mediaType }}</span>
                    @if ($mediaRoute)
                        <a href="{{ $mediaRoute }}" class="review-item__media-link">
                            {{ $mediaTitle }}{{ $mediaYear ? ' ('.$mediaYear.')' : '' }}
                        </a>
                    @else
                        <span class="review-item__media-link">{{ $mediaTitle }}{{ $mediaYear ? ' ('.$mediaYear.')' : '' }}</span>
                    @endif
                </div>

                @if ($review->is_spoiler)
                    <details class="review-item__spoiler-wrap">
                        <summary class="review-item__spoiler-label">
                            <i class="{{ config('other.font-awesome') }} fa-triangle-exclamation"></i> Spoiler — klik untuk lihat
                        </summary>
                        <div class="review-item__body">
                            <strong class="review-item__title">{{ $review->title }}</strong>
                            @if ($review->body)
                                <p class="review-item__text">{{ $review->body }}</p>
                            @endif
                        </div>
                    </details>
                @else
                    <div class="review-item__body">
                        <strong class="review-item__title">{{ $review->title }}</strong>
                        @if ($review->body)
                            <p class="review-item__text">{{ $review->body }}</p>
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <div class="review-list__empty">
                Belum ada ulasan lagi.
            </div>
        @endforelse

        @if ($reviews->hasPages())
            <div class="reviews-pagination">
                {{ $reviews->links() }}
            </div>
        @endif
    </section>
@endsection

@php
    $avgRating = $reviews->avg('rating');
    $totalReviews = $reviews->count();
@endphp

<section class="review-section panel">
    <header class="panel__heading">
        <i class="{{ config('other.font-awesome') }} fa-star"></i>
        User Reviews
        @if ($totalReviews > 0)
            <span class="review-section__count">
                {{ number_format($avgRating, 1) }}
                <span class="review-section__stars">
                    @for ($s = 1; $s <= 5; $s++)
                        <i class="{{ config('other.font-awesome') }} fa-star{{ $avgRating / 2 >= $s ? '' : ($avgRating / 2 >= $s - 0.5 ? '-half-stroke' : '-o') }}"></i>
                    @endfor
                </span>
                {{ $totalReviews }} {{ Str::plural('review', $totalReviews) }}
            </span>
        @endif
    </header>

    <div class="review-list">
        @forelse ($reviews as $review)
            @php
                $reviewer = $review->is_anonymous ? null : $review->user;
            @endphp
            <div class="review-item">
                <div class="review-item__header">
                    <div class="review-item__user">
                        @if ($review->is_anonymous || !$reviewer)
                            <img
                                src="{{ url('img/profile.png') }}"
                                class="review-item__avatar"
                                alt="Anonymous"
                            />
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
                                <span class="review-item__username" style="color: #aaa;">
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
                Belum ada ulasan. Jadilah yang pertama!
            </div>
        @endforelse
    </div>

    {{-- Write a Review Form --}}
    @if (!$userReview)
        <div class="review-form-wrap">
            <header class="review-form__header">
                <i class="{{ config('other.font-awesome') }} fa-pencil"></i>
                Tulis Ulasan
                <span class="review-form__star-display" id="starDisplay"></span>
            </header>

            @if ($errors->any())
                <div class="review-form__errors">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('reviews.store') }}" method="POST" class="review-form">
                @csrf

                {{-- Hidden meta fields --}}
                <input type="hidden" name="category_id" value="{{ $category->id }}">
                <input type="hidden" name="meta_id" value="{{ $tmdb ?? $igdb ?? 0 }}">
                @if ($category->movie_meta)
                    <input type="hidden" name="tmdb_movie_id" value="{{ $tmdb }}">
                @elseif ($category->tv_meta)
                    <input type="hidden" name="tmdb_tv_id" value="{{ $tmdb }}">
                @elseif ($category->game_meta)
                    <input type="hidden" name="igdb_id" value="{{ $igdb }}">
                @endif

                {{-- Star Rating --}}
                <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', '') }}">
                <div class="review-form__stars" id="starRating">
                    @for ($i = 1; $i <= 10; $i++)
                        <i
                            class="{{ config('other.font-awesome') }} fa-star review-form__star"
                            data-value="{{ $i }}"
                            title="{{ $i }}/10"
                        ></i>
                    @endfor
                </div>

                <input
                    type="text"
                    name="title"
                    class="review-form__input"
                    placeholder="Tajuk Ulasan"
                    value="{{ old('title') }}"
                    required
                    maxlength="255"
                />

                <textarea
                    name="body"
                    class="review-form__textarea"
                    placeholder="Ulasan anda (pilihan)"
                    maxlength="5000"
                    rows="4"
                >{{ old('body') }}</textarea>

                <div class="review-form__footer">
                    <label class="review-form__checkbox">
                        <input type="checkbox" name="is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }}>
                        <i class="{{ config('other.font-awesome') }} fa-user-secret"></i> Tanpa Nama
                    </label>
                    <label class="review-form__checkbox">
                        <input type="checkbox" name="is_spoiler" value="1" {{ old('is_spoiler') ? 'checked' : '' }}>
                        <i class="{{ config('other.font-awesome') }} fa-triangle-exclamation"></i> Spoiler
                    </label>
                    <button type="submit" class="review-form__submit">
                        <i class="{{ config('other.font-awesome') }} fa-paper-plane"></i>
                        Hantar Ulasan
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="review-already-reviewed">
            <i class="{{ config('other.font-awesome') }} fa-circle-check"></i>
            Anda sudah menghantar ulasan untuk tajuk ini.
        </div>
    @endif
</section>

<script>
(function () {
    const stars = document.querySelectorAll('.review-form__star');
    const input = document.getElementById('ratingInput');
    const display = document.getElementById('starDisplay');

    if (!stars.length) return;

    let current = parseInt(input?.value) || 0;

    function render(val) {
        stars.forEach((s, i) => {
            s.classList.toggle('review-form__star--filled', i < val);
        });
        if (display) display.textContent = val ? val + '/10' : '';
    }

    render(current);

    stars.forEach((star) => {
        star.addEventListener('mouseenter', () => render(parseInt(star.dataset.value)));
        star.addEventListener('mouseleave', () => render(current));
        star.addEventListener('click', () => {
            current = parseInt(star.dataset.value);
            input.value = current;
            render(current);
        });
    });
})();
</script>

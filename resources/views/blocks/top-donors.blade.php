<section class="panelV2 top-donors-widget">
    <header class="panel__heading top-donors-widget__heading">
        <i class="{{ config('other.font-awesome') }} fa-heart"></i>
        Penyokong Teratas
    </header>

    <div class="top-donors-widget__list">
        @forelse ($topDonors as $i => $donation)
            @php $donor = $donation->user; @endphp
            <div class="top-donors-widget__row">
                <span class="top-donors-widget__rank top-donors-widget__rank--{{ $i + 1 }}">
                    {{ $i + 1 }}
                </span>

                <img
                    class="top-donors-widget__avatar"
                    src="{{ $donor->image ? route('authenticated_images.user_avatar', ['user' => $donor]) : url('img/profile.png') }}"
                    alt="{{ $donor->username }}"
                    loading="lazy"
                >

                <div class="top-donors-widget__meta">
                    <a
                        href="{{ route('users.show', ['user' => $donor]) }}"
                        class="top-donors-widget__username"
                        style="color: {{ $donor->group->color }};"
                    >
                        @if ($donor->group->icon)
                            <i class="{{ config('other.font-awesome') }} {{ $donor->group->icon }}"></i>
                        @endif
                        {{ $donor->username }}
                    </a>
                    <span class="top-donors-widget__package">{{ $donation->package->name }}</span>
                </div>

                <span class="top-donors-widget__status {{ $donation->ends_at === null ? 'top-donors-widget__status--lifetime' : 'top-donors-widget__status--active' }}">
                    @if ($donation->ends_at === null)
                        <i class="{{ config('other.font-awesome') }} fa-infinity"></i>
                    @else
                        <i class="{{ config('other.font-awesome') }} fa-circle-check"></i>
                    @endif
                </span>
            </div>
        @empty
            <p class="top-donors-widget__empty">Tiada penyokong aktif buat masa ini.</p>
        @endforelse
    </div>
</section>

<section class="panelV2 home-bon-pool">
    <header class="panel__heading">
        <i class="{{ config('other.font-awesome') }} fa-users"></i>
        {{ __('bon.pool-title') }}
        @if ($bonPool->freeleech_until && $bonPool->freeleech_until->isFuture())
            <span class="home-bon-pool__active-badge">
                <i class="{{ config('other.font-awesome') }} fa-circle-check"></i>
                {{ __('bon.pool-freeleech-active') }}
            </span>
        @endif
    </header>

    <div class="home-bon-pool__body">
        @php
            $bonCycleTotal  = $bonPool->cycleTotal();
            $bonPercent     = $bonPoolTarget > 0 ? min(100, round(($bonCycleTotal / $bonPoolTarget) * 100, 1)) : 0;
        @endphp

        {{-- Stat row --}}
        <div class="home-bon-pool__stats">
            <div class="home-bon-pool__stat">
                <span class="home-bon-pool__stat-label">{{ __('bon.pool-current') }}</span>
                <span class="home-bon-pool__stat-value">{{ number_format($bonCycleTotal) }}</span>
            </div>
            <div class="home-bon-pool__stat">
                <span class="home-bon-pool__stat-label">{{ __('bon.pool-target') }}</span>
                <span class="home-bon-pool__stat-value">{{ number_format($bonPoolTarget) }}</span>
            </div>
            <div class="home-bon-pool__stat">
                <span class="home-bon-pool__stat-label">{{ __('bon.pool-reward') }}</span>
                <span class="home-bon-pool__stat-value">{{ __('bon.pool-days-fl', ['days' => $bonPoolReward]) }}</span>
            </div>
        </div>

        {{-- Progress bar --}}
        <div class="home-bon-pool__bar-wrap">
            <div class="home-bon-pool__bar-fill" style="width: {{ $bonPercent }}%">
                @if ($bonPercent >= 8)
                    <span class="home-bon-pool__bar-label">{{ $bonPercent }}%</span>
                @endif
            </div>
            @if ($bonPercent < 8)
                <span class="home-bon-pool__bar-label-outside">{{ $bonPercent }}%</span>
            @endif
        </div>

        {{-- Action --}}
        <div class="home-bon-pool__footer">
            @if ($bonPool->freeleech_until && $bonPool->freeleech_until->isFuture())
                <span class="home-bon-pool__expires">
                    <i class="{{ config('other.font-awesome') }} fa-clock"></i>
                    {{ __('bon.pool-expires', ['time' => $bonPool->freeleech_until->diffForHumans()]) }}
                </span>
            @else
                <span class="home-bon-pool__hint">
                    <i class="{{ config('other.font-awesome') }} fa-circle-info"></i>
                    {{ __('bon.pool-hint', ['days' => $bonPoolReward]) }}
                </span>
            @endif
            <a href="{{ route('bon_pool.index') }}" class="home-bon-pool__btn">
                <i class="{{ config('other.font-awesome') }} fa-plus"></i>
                {{ __('bon.pool-contribute') }}
            </a>
        </div>

        {{-- Top contributors this cycle --}}
        @if ($bonPoolTopDonors->isNotEmpty())
            <div style="border-top: 1px solid rgba(255,255,255,0.07); margin-top: 0.5rem;">
                <div style="font-size: 0.68rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; opacity: 0.4; padding: 0.6rem 1rem 0.3rem;">
                    <i class="{{ config('other.font-awesome') }} fa-ranking-star" style="margin-right: 0.3rem;"></i>
                    Penyumbang Teratas Kitaran Ini
                </div>
                @foreach ($bonPoolTopDonors as $i => $contrib)
                    @php
                        $rankColors = [
                            1 => ['bg' => 'rgba(255,215,0,0.12)', 'color' => '#ffd700', 'border' => 'rgba(255,215,0,0.35)'],
                            2 => ['bg' => 'rgba(192,192,192,0.12)', 'color' => '#c0c0c0', 'border' => 'rgba(192,192,192,0.3)'],
                            3 => ['bg' => 'rgba(205,127,50,0.12)', 'color' => '#cd7f32', 'border' => 'rgba(205,127,50,0.3)'],
                        ];
                        $rc = $rankColors[$i + 1] ?? ['bg' => 'rgba(255,255,255,0.05)', 'color' => 'rgba(255,255,255,0.3)', 'border' => 'rgba(255,255,255,0.1)'];
                    @endphp
                    <div style="display:flex; align-items:center; gap:0.6rem; padding:0.45rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.04);">
                        {{-- Rank --}}
                        <span style="width:20px; height:20px; flex-shrink:0; display:flex; align-items:center; justify-content:center; border-radius:50%; font-size:0.65rem; font-weight:700; background:{{ $rc['bg'] }}; color:{{ $rc['color'] }}; border:1px solid {{ $rc['border'] }};">
                            {{ $i + 1 }}
                        </span>
                        {{-- Avatar --}}
                        <img
                            src="{{ $contrib->user->image ? route('authenticated_images.user_avatar', ['user' => $contrib->user]) : url('img/profile.png') }}"
                            alt="{{ $contrib->user->username }}"
                            loading="lazy"
                            style="width:36px; height:36px; border-radius:50%; object-fit:cover; flex-shrink:0; border:1px solid rgba(255,255,255,0.1);"
                        >
                        {{-- Name --}}
                        <a
                            href="{{ route('users.show', ['user' => $contrib->user]) }}"
                            style="flex:1; font-size:0.875rem; font-weight:600; text-decoration:none; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:{{ $contrib->user->group->color }};"
                        >
                            @if ($contrib->user->group->icon)
                                <i class="{{ config('other.font-awesome') }} {{ $contrib->user->group->icon }}" style="margin-right:0.2rem; font-size:0.75rem;"></i>
                            @endif
                            {{ $contrib->user->username }}
                        </a>
                        {{-- Amount --}}
                        <span style="font-size:0.75rem; font-weight:600; color:#fbbf24; white-space:nowrap; flex-shrink:0;">
                            {{ number_format($contrib->total) }} BON
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

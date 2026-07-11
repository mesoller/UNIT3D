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
    </div>
</section>

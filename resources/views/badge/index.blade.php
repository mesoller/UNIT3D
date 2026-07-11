@extends('layout.with-main')

@section('title')
    <title>Koleksi Lencana - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Koleksi lencana MalayaBits — perolehi lencana dengan menjadi ahli aktif komuniti!" />
@endsection

@section('breadcrumbs')
    <li class="breadcrumb--active">Lencana</li>
@endsection

@section('page', 'page__badges')

@section('main')
    <section class="panelV2 badges-hero">
        <div class="badges-hero__inner">
            <i class="{{ config('other.font-awesome') }} fa-shield-halved badges-hero__icon"></i>
            <div>
                <h1 class="badges-hero__title">Koleksi Lencana</h1>
                <p class="badges-hero__subtitle">
                    Perolehi lencana dengan menjadi ahli aktif komuniti MalayaBits.
                    Lencana tidak boleh dibeli — ia hanya boleh diperoleh!
                </p>
            </div>
            <div class="badges-hero__stats">
                <div class="badges-hero__stat">
                    <span class="badges-hero__stat-value">{{ $earnedIds->count() }}</span>
                    <span class="badges-hero__stat-label">Diperoleh</span>
                </div>
                <div class="badges-hero__stat">
                    <span class="badges-hero__stat-value">{{ $badgesByCategory->flatten()->count() }}</span>
                    <span class="badges-hero__stat-label">Jumlah Lencana</span>
                </div>
            </div>
        </div>
    </section>

    @foreach ($badgesByCategory as $category => $badges)
        <section class="panelV2 badge-category">
            <header class="panel__heading">
                <i class="{{ config('other.font-awesome') }} {{ $badges->first()->icon }}"></i>
                {{ $badges->first()->categoryLabel() }}
                <span class="badge-category__count">
                    {{ $badges->filter(fn ($b) => $earnedIds->has($b->id))->count() }} / {{ $badges->count() }}
                </span>
            </header>

            <div class="badge-grid">
                @foreach ($badges as $badge)
                    @php $earned = $earnedIds->get($badge->id); @endphp
                    <div class="badge-card {{ $earned ? 'badge-card--earned' : 'badge-card--locked' }}"
                         style="--badge-color: {{ $badge->color }}">
                        <div class="badge-card__icon-wrap">
                            <i class="{{ config('other.font-awesome') }} {{ $badge->icon }} badge-card__icon"></i>
                        </div>
                        <div class="badge-card__body">
                            <span class="badge-card__name">{{ $badge->name }}</span>
                            <span class="badge-card__desc">{{ $badge->description }}</span>
                            @if ($earned)
                                <span class="badge-card__earned-date">
                                    <i class="{{ config('other.font-awesome') }} fa-check-circle"></i>
                                    Diperoleh {{ \Carbon\Carbon::parse($earned->pivot->awarded_at)->diffForHumans() }}
                                </span>
                            @else
                                <span class="badge-card__locked">
                                    <i class="{{ config('other.font-awesome') }} fa-lock"></i>
                                    Belum diperoleh
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach
@endsection

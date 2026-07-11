@extends('layout.with-main')

@section('title')
    <title>Kedai Lencana - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Beli dan jual lencana koleksi eksklusif menggunakan BON." />
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('badges.index') }}">Lencana</a></li>
    <li class="breadcrumb--active">Kedai</li>
@endsection

@section('page', 'page__badge-shop')

@section('main')
    <section class="panelV2 badge-shop-hero">
        <div class="badge-shop-hero__inner">
            <i class="{{ config('other.font-awesome') }} fa-store badge-shop-hero__icon"></i>
            <div>
                <h1 class="badge-shop-hero__title">Kedai Lencana</h1>
                <p class="badge-shop-hero__subtitle">
                    Beli lencana koleksi eksklusif menggunakan BON. Lencana boleh dijual semula pada bila-bila masa.
                </p>
            </div>
            <div class="badge-shop-hero__balance">
                <span class="badge-shop-hero__balance-label">Baki BON anda</span>
                <span class="badge-shop-hero__balance-value">
                    <i class="{{ config('other.font-awesome') }} fa-coins"></i>
                    {{ number_format(auth()->user()->seedbonus, 2) }}
                </span>
            </div>
        </div>
    </section>

    @if (session('success'))
        <div class="badge-shop-alert badge-shop-alert--success">
            <i class="{{ config('other.font-awesome') }} fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="badge-shop-alert badge-shop-alert--error">
            <i class="{{ config('other.font-awesome') }} fa-triangle-exclamation"></i>
            {{ $errors->first() }}
        </div>
    @endif

    @forelse ($collections as $collection)
        @if ($collection->shopBadges->isNotEmpty())
            <section class="panelV2 badge-shop-section">
                <header class="panel__heading">
                    <i class="{{ config('other.font-awesome') }} fa-layer-group"></i>
                    {{ $collection->name }}
                    @if ($collection->description)
                        <span class="badge-shop-section__subtitle">— {{ $collection->description }}</span>
                    @endif
                </header>

                <div class="badge-shop-grid">
                    @foreach ($collection->shopBadges as $badge)
                        @php
                            $owned     = $ownedIds->has($badge->id);
                            $available = $badge->isAvailable();
                            $slots     = $badge->slotsRemaining();
                            $owners    = $badge->currentOwnerCount();
                        @endphp
                        <div class="shop-badge-card {{ $owned ? 'shop-badge-card--owned' : ($available ? '' : 'shop-badge-card--soldout') }}"
                             style="--badge-color: {{ $badge->color }}">

                            {{-- Top bar: supply / price --}}
                            <div class="shop-badge-card__topbar">
                                <span class="shop-badge-card__supply" title="Unit tersedia">
                                    <i class="{{ config('other.font-awesome') }} fa-tag"></i>
                                    {{ $badge->isUnlimited() ? 'UNLIMITED' : number_format($slots) }}
                                </span>
                                <span class="shop-badge-card__price">
                                    {{ number_format($badge->buy_price, 2) }} BP
                                </span>
                            </div>

                            {{-- Icon --}}
                            <div class="shop-badge-card__icon-wrap">
                                <i class="{{ config('other.font-awesome') }} {{ $badge->icon }} shop-badge-card__icon"></i>
                            </div>

                            {{-- Name --}}
                            <span class="shop-badge-card__name">{{ strtoupper($badge->name) }}</span>

                            {{-- Stats: owners --}}
                            <div class="shop-badge-card__stats">
                                <span class="shop-badge-card__stat" title="Jumlah pemilik">
                                    <i class="{{ config('other.font-awesome') }} fa-users"></i>
                                    {{ number_format($owners) }}
                                </span>
                            </div>

                            {{-- Collection label --}}
                            <div class="shop-badge-card__collection">
                                <span class="shop-badge-card__from">FROM</span>
                                @if ($badge->series)
                                    <span class="shop-badge-card__collection-name">{{ strtoupper($badge->series) }}</span>
                                    <span class="shop-badge-card__collection-subtitle">{{ $collection->name }}</span>
                                @else
                                    <span class="shop-badge-card__collection-name">{{ strtoupper($collection->name) }}</span>
                                @endif
                            </div>

                            {{-- Action button --}}
                            @if ($owned)
                                <div x-data="dialog" style="width:100%">
                                    <button type="button" class="shop-badge-card__btn shop-badge-card__btn--sell" x-bind="showDialog">
                                        <i class="{{ config('other.font-awesome') }} fa-tag"></i>
                                        JUAL · {{ number_format($badge->sell_price, 2) }} BON
                                    </button>
                                    <dialog class="dialog" x-bind="dialogElement">
                                        <h3 class="dialog__heading">
                                            <i class="{{ config('other.font-awesome') }} fa-tag"></i>
                                            Jual Lencana
                                        </h3>
                                        <p style="margin: 0 0 1.25rem; opacity: 0.8; font-size: 0.95rem; line-height: 1.5">
                                            Anda ingin menjual lencana <strong>{{ $badge->name }}</strong>?<br>
                                            Anda akan menerima <strong>{{ number_format($badge->sell_price, 2) }} BON</strong> ke akaun anda.
                                        </p>
                                        <form method="POST" action="{{ route('badges.shop.sell', ['shopBadge' => $badge]) }}" x-bind="dialogForm">
                                            @csrf
                                            <p class="form__group">
                                                <button type="submit" class="form__button form__button--filled">
                                                    <i class="{{ config('other.font-awesome') }} fa-check"></i>
                                                    Ya, Jual Sekarang
                                                </button>
                                                <button type="button" formmethod="dialog" formnovalidate class="form__button form__button--outlined" @click="$refs.dialog?.close()">
                                                    {{ __('common.cancel') }}
                                                </button>
                                            </p>
                                        </form>
                                    </dialog>
                                </div>
                            @elseif ($available)
                                <div x-data="dialog" style="width:100%">
                                    <button type="button" class="shop-badge-card__btn shop-badge-card__btn--buy" x-bind="showDialog">
                                        <i class="{{ config('other.font-awesome') }} fa-cart-shopping"></i>
                                        BELI · {{ number_format($badge->buy_price, 2) }} BON
                                    </button>
                                    <dialog class="dialog" x-bind="dialogElement">
                                        <h3 class="dialog__heading">
                                            <i class="{{ config('other.font-awesome') }} fa-cart-shopping"></i>
                                            Beli Lencana
                                        </h3>
                                        <p style="margin: 0 0 1.25rem; opacity: 0.8; font-size: 0.95rem; line-height: 1.5">
                                            Anda ingin membeli lencana <strong>{{ $badge->name }}</strong>?<br>
                                            Sebanyak <strong>{{ number_format($badge->buy_price, 2) }} BON</strong> akan ditolak daripada baki anda.<br>
                                            <span style="font-size:0.85rem; opacity:0.6">Baki semasa: {{ number_format(auth()->user()->seedbonus, 2) }} BON</span>
                                        </p>
                                        <form method="POST" action="{{ route('badges.shop.buy', ['shopBadge' => $badge]) }}" x-bind="dialogForm">
                                            @csrf
                                            <p class="form__group">
                                                <button type="submit" class="form__button form__button--filled">
                                                    <i class="{{ config('other.font-awesome') }} fa-check"></i>
                                                    Ya, Beli Sekarang
                                                </button>
                                                <button type="button" formmethod="dialog" formnovalidate class="form__button form__button--outlined" @click="$refs.dialog?.close()">
                                                    {{ __('common.cancel') }}
                                                </button>
                                            </p>
                                        </form>
                                    </dialog>
                                </div>
                            @else
                                <span class="shop-badge-card__btn shop-badge-card__btn--soldout">
                                    <i class="{{ config('other.font-awesome') }} fa-ban"></i>
                                    HABIS TERJUAL
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    @empty
        <section class="panelV2">
            <div class="panel__body" style="padding:2rem; text-align:center; opacity:0.5;">
                Tiada lencana tersedia dalam kedai buat masa ini.
            </div>
        </section>
    @endforelse
@endsection

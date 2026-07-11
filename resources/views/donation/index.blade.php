@extends('layout.with-main-and-sidebar')

@section('title')
    <title>Donate - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Donate" />
@endsection

@section('breadcrumbs')
    <li class="breadcrumb--active">Donate</li>
@endsection

@section('page', 'page__donation--index')

@section('main')
    <section x-data class="panelV2">
        <div class="don-hero">
            <div class="don-hero__icon-wrap">
                <i class="{{ config('other.font-awesome') }} fa-heart"></i>
            </div>
            <div class="don-hero__text">
                <h2 class="don-hero__title">{{ __('common.support') }} {{ config('other.title') }}</h2>
                <p class="don-hero__subtitle">Choose a donation package that works for you</p>
                <p class="don-hero__desc">{{ config('donation.description') }}</p>
            </div>
        </div>

        <div class="don-grid">
            @foreach ($packages as $package)
                <div class="don-card">
                    <div class="don-card__icon-circle">
                        <i class="{{ config('other.font-awesome') }} fa-star"></i>
                    </div>

                    <h3 class="don-card__name">{{ $package->name }}</h3>

                    <span class="don-card__badge">
                        {{ number_format((float) $package->cost, 2) }} {{ config('donation.currency') }}
                        &rarr;
                        @if ($package->donor_value === null)
                            Lifetime
                        @else
                            {{ $package->donor_value }} days
                        @endif
                    </span>

                    @if ($package->description)
                        <p class="don-card__desc">{{ $package->description }}</p>
                    @endif

                    <ul class="don-card__benefits">
                        @if ($package->donor_value === null)
                            <li>
                                <i class="{{ config('other.font-awesome') }} fa-check"></i>
                                Unlimited download slots
                            </li>
                            <li>
                                <i class="{{ config('other.font-awesome') }} fa-check"></i>
                                Custom user icon
                            </li>
                        @endif
                        <li>
                            <i class="{{ config('other.font-awesome') }} fa-check"></i>
                            Global freeleech
                        </li>
                        <li>
                            <i class="{{ config('other.font-awesome') }} fa-check"></i>
                            Immunity to automated warnings
                        </li>
                        <li style="background-image: url(/img/sparkels.gif);">
                            <i class="{{ config('other.font-awesome') }} fa-check"></i>
                            Sparkle effect on username
                        </li>
                        <li>
                            <i class="{{ config('other.font-awesome') }} fa-check"></i>
                            Donor star by username
                        </li>
                        <li>
                            <i class="{{ config('other.font-awesome') }} fa-check"></i>
                            Warm fuzzy feeling by supporting {{ config('other.title') }}
                        </li>
                        @if ($package->upload_value !== null)
                            <li>
                                <i class="{{ config('other.font-awesome') }} fa-check"></i>
                                {{ App\Helpers\StringHelper::formatBytes($package->upload_value) }} Upload credit
                            </li>
                        @endif
                        @if ($package->bonus_value !== null)
                            <li>
                                <i class="{{ config('other.font-awesome') }} fa-check"></i>
                                {{ number_format($package->bonus_value) }} bonus points
                            </li>
                        @endif
                        @if ($package->invite_value !== null)
                            <li>
                                <i class="{{ config('other.font-awesome') }} fa-check"></i>
                                {{ $package->invite_value }} invites
                            </li>
                        @endif
                    </ul>

                    <button
                        class="don-card__btn"
                        x-on:click.stop="$refs.dialog{{ $package->id }}.showModal()"
                    >
                        <i class="{{ config('other.font-awesome') }} fa-heart"></i>
                        Donate Now
                    </button>
                </div>
            @endforeach
        </div>

        @foreach ($packages as $package)
        <dialog class="dialog" x-ref="dialog{{ $package->id }}">
            <h4 class="dialog__heading">Donate ${{ $package->cost }} {{ config('donation.currency') }}</h4>
            <form
                class="dialog__form"
                method="POST"
                action="{{ route('donations.store') }}"
                x-on:click.outside="$refs.dialog{{ $package->id }}.close()"
            >
                @csrf
                <span class="text-success text-center">
                    To make a donation you must complete the following steps:
                </span>
                <div class="form__group--horizontal">
                    @foreach ($gateways->sortBy('position') as $gateway)
                        <p class="form__group">
                            <input
                                class="form__text"
                                type="text"
                                disabled
                                value="{{ $gateway->address }}"
                                id="{{ 'gateway-' . $gateway->id }}"
                            />
                            <label
                                for="{{ 'gateway-' . $gateway->id }}"
                                class="form__label form__label--floating"
                            >
                                {{ $gateway->name }}
                            </label>
                        </p>
                    @endforeach

                    <p class="text-info">
                        Send
                        <strong>${{ $package->cost }} {{ config('donation.currency') }}</strong>
                        to the gateway of your choice. Take note of the tx hash, receipt number, etc and input it below.
                    </p>
                </div>
                <div class="form__group--horizontal">
                    <p class="form__group">
                        <input
                            class="form__text"
                            type="text"
                            disabled
                            value="{{ $package->cost }}"
                            id="package-cost-{{ $package->id }}"
                        />
                        <label for="package-cost-{{ $package->id }}" class="form__label form__label--floating">
                            Cost
                        </label>
                    </p>
                    <p class="form__group">
                        <input
                            class="form__text"
                            type="text"
                            value=""
                            id="proof-{{ $package->id }}"
                            name="transaction"
                        />
                        <label for="proof-{{ $package->id }}" class="form__label form__label--floating">
                            Tx hash, Receipt number, Etc
                        </label>
                    </p>
                </div>
                <span class="text-warning">
                    * Transactions may take up to 48 hours to process.
                </span>
                <p class="form__group">
                    <input type="hidden" name="package_id" value="{{ $package->id }}" />
                    <button class="form__button form__button--filled">Donate</button>
                    <button
                        formmethod="dialog"
                        formnovalidate
                        class="form__button form__button--outlined"
                    >
                        {{ __('common.cancel') }}
                    </button>
                </p>
            </form>
        </dialog>
        @endforeach
    </section>
@endsection

@section('sidebar')
    <section class="panelV2 don-progress">
        <header class="panel__heading">
            <i class="{{ config('other.font-awesome') }} fa-chart-line"></i>
            Monthly Progress
        </header>
        <div class="don-progress__body">
            <span class="don-progress__percent">{{ $monthlyPercent }}%</span>
            <div class="don-progress__amounts">
                ${{ number_format($monthlyCollected, 0) }} / ${{ number_format($monthlyGoal, 0) }}
            </div>
            <div class="don-progress__bar-wrap">
                <div class="don-progress__bar-fill" style="height: {{ $monthlyPercent }}%"></div>
            </div>
            <div class="don-progress__goal-label">
                Monthly Goal: ${{ number_format($monthlyGoal, 0) }}
            </div>
        </div>
    </section>
@endsection

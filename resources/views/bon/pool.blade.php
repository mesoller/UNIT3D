@extends('layout.with-main-and-sidebar')

@section('title')
    <title>{{ __('bon.pool-title') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Contribute BON to the pool and unlock global freeleech for everyone!" />
@endsection

@section('breadcrumbs')
    <li class="breadcrumb--active">{{ __('bon.pool-title') }}</li>
@endsection

@section('page', 'page__bon-pool')

@section('main')
    <section class="panelV2">
        <h2 class="panel__heading">
            <i class="{{ config('other.font-awesome') }} fa-users"></i>
            {{ __('bon.pool-title') }}
        </h2>

        {{-- Stat Cards --}}
        <div class="bon-pool-stats">
            <div class="bon-stat-card">
                <div class="bon-stat-card__icon bon-stat-card__icon--green">
                    <i class="{{ config('other.font-awesome') }} fa-coins"></i>
                </div>
                <div class="bon-stat-card__body">
                    <span class="bon-stat-card__label">{{ __('bon.pool-current') }}</span>
                    <span class="bon-stat-card__value">{{ number_format($cycleTotal) }}</span>
                </div>
            </div>

            <div class="bon-stat-card">
                <div class="bon-stat-card__icon bon-stat-card__icon--blue">
                    <i class="{{ config('other.font-awesome') }} fa-bullseye"></i>
                </div>
                <div class="bon-stat-card__body">
                    <span class="bon-stat-card__label">{{ __('bon.pool-target-goal') }}</span>
                    <span class="bon-stat-card__value">{{ number_format($target) }}</span>
                </div>
            </div>

            <div class="bon-stat-card">
                <div class="bon-stat-card__icon bon-stat-card__icon--gold">
                    <i class="{{ config('other.font-awesome') }} fa-trophy"></i>
                </div>
                <div class="bon-stat-card__body">
                    <span class="bon-stat-card__label">{{ __('bon.pool-reward') }}</span>
                    <span class="bon-stat-card__value">{{ __('bon.pool-days-fl', ['days' => $rewardDays]) }}</span>
                </div>
            </div>
        </div>

        {{-- Progress Bar --}}
        <div class="bon-pool-progress">
            <div class="bon-pool-progress__bar-wrap">
                <div class="bon-pool-progress__bar-fill" style="width: {{ $percent }}%">
                    <span class="bon-pool-progress__bar-label">{{ $percent }}%</span>
                </div>
            </div>
        </div>

        {{-- Active Freeleech Banner --}}
        @if ($pool->freeleech_until && $pool->freeleech_until->isFuture())
            <div class="bon-pool-active">
                <i class="{{ config('other.font-awesome') }} fa-circle-check"></i>
                {{ __('bon.pool-active-message', ['time' => $pool->freeleech_until->diffForHumans()]) }}
            </div>
        @else
            <div class="bon-pool-notice">
                <i class="{{ config('other.font-awesome') }} fa-circle-info"></i>
                {{ __('bon.pool-notice', ['days' => $rewardDays]) }}
            </div>
        @endif

        {{-- Contribute Form --}}
        <div class="bon-pool-form">
            <h3 class="bon-pool-form__heading">
                <i class="{{ config('other.font-awesome') }} fa-hand-holding-dollar"></i>
                {{ __('bon.pool-contribute-heading') }}
            </h3>

            @if (session('success'))
                <div class="bon-pool-notice" style="margin: 0 0 1rem; background: rgba(34,197,94,0.1); border-color: rgba(34,197,94,0.3); color: #4ade80;">
                    <i class="{{ config('other.font-awesome') }} fa-circle-check" style="color:#4ade80"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bon-pool-notice" style="margin: 0 0 1rem; background: rgba(239,68,68,0.1); border-color: rgba(239,68,68,0.3); color: #f87171;">
                    <i class="{{ config('other.font-awesome') }} fa-triangle-exclamation" style="color:#f87171"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('bon_pool.store') }}">
                @csrf
                <div class="bon-pool-form__row">
                    <div class="bon-pool-form__amount-wrap">
                        <p class="form__group">
                            <input
                                class="form__text"
                                type="number"
                                name="amount"
                                id="bon-amount"
                                min="1"
                                step="1"
                                placeholder=" "
                                value="{{ old('amount') }}"
                                required
                            />
                            <label class="form__label form__label--floating" for="bon-amount">
                                {{ __('bon.pool-bon-amount') }}
                            </label>
                        </p>
                        <p class="bon-pool-form__balance">
                            {{ __('bon.pool-your-balance') }}: <strong>{{ number_format(auth()->user()->seedbonus, 2) }} BON</strong>
                        </p>
                    </div>

                    <label class="bon-pool-form__checkbox-wrap">
                        <input type="checkbox" name="anonymous" value="1" {{ old('anonymous') ? 'checked' : '' }} />
                        <i class="{{ config('other.font-awesome') }} fa-user-secret"></i>
                        {{ __('bon.pool-anonymous') }}
                    </label>

                    <button type="submit" class="bon-pool-form__submit">
                        <i class="{{ config('other.font-awesome') }} fa-plus"></i>
                        {{ __('bon.pool-add') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- Recent Contributions --}}
        <div class="bon-pool-recent">
            <h3 class="bon-pool-recent__heading">
                <i class="{{ config('other.font-awesome') }} fa-clock-rotate-left"></i>
                {{ __('bon.pool-recent') }}
            </h3>

            <table class="bon-pool-recent__table">
                <thead class="bon-pool-recent__thead">
                    <tr>
                        <th><i class="{{ config('other.font-awesome') }} fa-user"></i> {{ __('bon.pool-col-username') }}</th>
                        <th><i class="{{ config('other.font-awesome') }} fa-coins"></i> {{ __('bon.pool-col-amount') }}</th>
                        <th><i class="{{ config('other.font-awesome') }} fa-clock"></i> {{ __('bon.pool-col-time') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recent as $contribution)
                        <tr class="bon-pool-recent__row">
                            <td class="bon-pool-recent__cell">
                                @if ($contribution->anonymous || $contribution->user === null)
                                    <span style="color: rgba(255,255,255,0.4)">{{ __('bon.pool-anonymous') }}</span>
                                @else
                                    <a class="bon-pool-recent__user-link" href="{{ route('users.show', ['user' => $contribution->user]) }}">
                                        {{ $contribution->user->username }}
                                    </a>
                                @endif
                            </td>
                            <td class="bon-pool-recent__cell bon-pool-recent__cell--amount">
                                {{ number_format($contribution->amount) }} BON
                            </td>
                            <td class="bon-pool-recent__cell bon-pool-recent__cell--time">
                                {{ $contribution->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr class="bon-pool-recent__row">
                            <td class="bon-pool-recent__cell" colspan="3" style="text-align:center; color: rgba(255,255,255,0.3);">
                                {{ __('bon.pool-no-contributions') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection

@section('sidebar')
    <section class="panelV2 bon-top">
        <header class="panel__heading">
            <i class="{{ config('other.font-awesome') }} fa-ranking-star"></i>
            {{ __('bon.pool-top-contributors') }}
        </header>
        <ul class="bon-top__list">
            @forelse ($topContributors as $i => $contrib)
                <li class="bon-top__item">
                    <span class="bon-top__rank {{ $i === 0 ? 'bon-top__rank--gold' : ($i === 1 ? 'bon-top__rank--silver' : ($i === 2 ? 'bon-top__rank--bronze' : '')) }}">
                        {{ $i + 1 }}
                    </span>
                    <span class="bon-top__name">
                        @if ($contrib->user)
                            <a href="{{ route('users.show', ['user' => $contrib->user]) }}">
                                {{ $contrib->user->username }}
                            </a>
                        @else
                            <span style="color: rgba(255,255,255,0.4)">{{ __('bon.pool-anonymous') }}</span>
                        @endif
                    </span>
                    <span class="bon-top__amount">{{ number_format($contrib->total) }}</span>
                </li>
            @empty
                <li class="bon-top__item" style="color: rgba(255,255,255,0.3); font-size: 0.85rem;">
                    {{ __('bon.pool-no-contributors') }}
                </li>
            @endforelse
        </ul>
    </section>
@endsection

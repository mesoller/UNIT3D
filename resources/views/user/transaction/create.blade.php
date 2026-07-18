@extends('layout.with-main-and-sidebar')

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('users.show', ['user' => $user]) }}" class="breadcrumb__link">
            {{ $user->username }}
        </a>
    </li>
    <li class="breadcrumbV2">
        <a href="{{ route('users.earnings.index', ['user' => $user]) }}" class="breadcrumb__link">
            {{ __('bon.bonus') }} {{ __('bon.points') }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ __('bon.store') }}
    </li>
@endsection

@section('nav-tabs')
    @include('user.buttons.user')
@endsection

@section('page', 'page__user-transaction--create')

@section('main')
    <section class="panelV2">
        <h2 class="panel__heading">{{ __('bon.exchange') }}</h2>
        <div class="data-table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>{{ __('bon.item') }}</th>
                        <th>Cost</th>
                        <th>{{ __('bon.exchange') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->cost }}</td>
                            <td>
                                @if ($item->personal_freeleech && $activefl)
                                    <button disabled class="form__button form__button--filled">
                                        {{ __('bon.activated') }}!
                                    </button>
                                @elseif ($item->upload && config('other.bon.max-buffer-to-buy-upload') !== null && $user->uploaded - $user->downloaded > config('other.bon.max-buffer-to-buy-upload'))
                                    <button disabled class="form__button form__button--filled">
                                        Too much buffer!
                                    </button>
                                @else
                                    <form
                                        method="POST"
                                        action="{{ route('users.transactions.store', ['user' => $user]) }}"
                                    >
                                        @csrf
                                        <button class="form__button form__button--filled">
                                            {{ __('bon.exchange') }}
                                        </button>
                                        <input
                                            type="hidden"
                                            name="exchange"
                                            value="{{ $item->id }}"
                                        />
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    @if ($treats->count() > 0)
        @php
            $treatsByLevel = $treats->groupBy('level');
        @endphp
        <section class="panelV2">
            <h2 class="panel__heading">
                <i class="{{ config('other.font-awesome') }} fa-candy-cane"></i>
                {{ __('bon.treats') }}
            </h2>
            <div class="panel__body">
                <p class="treats-intro">{{ __('bon.treats-intro') }}</p>
            </div>
            @foreach ($treatsByLevel as $level => $levelTreats)
                <div class="treats-level">
                    <h3 class="treats-level__heading">
                        @if ($level === 1)
                            <i class="{{ config('other.font-awesome') }} fa-star"></i>
                        @else
                            <i class="{{ config('other.font-awesome') }} fa-star-half-stroke"></i>
                        @endif
                        {{ __('bon.treats-level', ['level' => $level]) }}
                    </h3>
                    <div class="treats-grid">
                        @foreach ($levelTreats as $treat)
                            <div class="treat-card {{ $ownedTreatIds->contains($treat->id) ? 'treat-card--owned' : '' }}">
                                <div class="treat-card__icon">
                                    @if ($treat->image)
                                        <img src="{{ asset('img/treats/' . $treat->image) }}" alt="{{ $treat->name }}" style="width:4rem; height:4rem; object-fit:contain;">
                                    @else
                                        {{ $treat->icon }}
                                    @endif
                                </div>
                                <div class="treat-card__name">{{ $treat->name }}</div>
                                <div class="treat-card__desc">{{ $treat->description }}</div>
                                @if ($ownedTreatIds->contains($treat->id))
                                    <span class="treat-card__owned-badge">
                                        <i class="{{ config('other.font-awesome') }} fa-check"></i>
                                        {{ __('bon.treats-owned') }}
                                    </span>
                                @else
                                    <form
                                        method="POST"
                                        action="{{ route('users.treats.store', ['user' => $user]) }}"
                                    >
                                        @csrf
                                        <input type="hidden" name="treat_id" value="{{ $treat->id }}" />
                                        <button class="form__button form__button--filled treat-card__btn">
                                            {{ number_format($treat->cost) }} BON
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </section>
    @endif
@endsection

@section('sidebar')
    <section class="panelV2">
        <h2 class="panel__heading">{{ __('bon.your-points') }}</h2>
        <div class="panel__body">{{ $bon }}</div>
    </section>
    <section class="panelV2">
        <h2 class="panel__heading">{{ __('bon.no-refund') }}</h2>
        <div class="panel__body">{{ __('bon.exchange-warning') }}</div>
    </section>
@endsection

@extends('layout.with-main')

@section('title')
    <title>
        {{ $user->username }} - {{ __('common.members') }} - {{ config('other.title') }}
    </title>
@endsection

@section('meta')
    <meta
        name="description"
        content="{{ __('user.profile-desc', ['user' => $user->username, 'title' => config('other.title')]) }}"
    />
@endsection

@section('breadcrumbs')
    <li class="breadcrumb--active">
        {{ $user->username }}
    </li>
@endsection

@section('nav-tabs')
    @include('user.buttons.user')
@endsection

@section('page', 'page__user-profile--show')

@if (auth()->user()->isAllowed($user))
    @section('main')
        <section class="panelV2">
            <header class="panel__header">
                <h2 class="panel__heading">{{ __('user.user') }} {{ __('user.information') }}</h2>
                <div class="panel__actions">
                    @if (auth()->user()->is($user))
                        <div class="panel__action">
                            <a
                                href="{{ route('users.edit', ['user' => $user]) }}"
                                class="form__button form__button--text"
                            >
                                {{ __('common.edit') }}
                            </a>
                        </div>
                    @elseif (auth()->user()->group->is_modo)
                        <div class="panel__action">
                            <a
                                href="{{ route('staff.users.edit', ['user' => $user]) }}"
                                class="form__button form__button--text"
                            >
                                {{ __('common.edit') }}
                            </a>
                        </div>
                        <div class="panel__action">
                            <form
                                action="{{ route('staff.users.destroy', ['user' => $user]) }}"
                                method="POST"
                                x-data="confirmation"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    x-on:click.prevent="confirmAction"
                                    data-b64-deletion-message="{{ base64_encode('Are you sure you want to delete this user and all their associated records: ' . $user->username . '?') }}"
                                    class="form__button form__button--text"
                                >
                                    {{ __('common.delete') }}
                                </button>
                            </form>
                        </div>
                    @endif
                    @if (auth()->id() !== $user->id)
                        <div class="panel__action" x-data="dialog">
                            <button class="form__button form__button--text" x-bind="showDialog">
                                {{ __('common.report') }}
                            </button>
                            <dialog class="dialog" x-bind="dialogElement">
                                <h3 class="dialog__heading">{{ __('common.report') }}: {{ $user->username }}</h3>
                                <form
                                    class="dialog__form"
                                    method="POST"
                                    action="{{ route('report_user', ['username' => $user->username]) }}"
                                    x-bind="dialogForm"
                                >
                                    @csrf
                                    <p class="form__group">
                                        <textarea
                                            id="report_reason"
                                            class="form__textarea"
                                            name="message"
                                            required
                                        ></textarea>
                                        <label
                                            class="form__label form__label--floating"
                                            for="report_reason"
                                        >
                                            {{ __('common.reason') }}
                                        </label>
                                    </p>
                                    <p class="form__group">
                                        <button class="form__button form__button--filled">
                                            {{ __('common.save') }}
                                        </button>
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
                        </div>
                    @endif
                </div>
            </header>
            <div class="panel__body">
                <article class="profileV2">
                    {{-- Top: avatar + username/meta --}}
                    <div class="profile__top">
                        <img
                            src="{{ $user->image === null ? url('img/profile.png') : route('authenticated_images.user_avatar', ['user' => $user]) }}"
                            alt=""
                            class="profile__avatar"
                        />
                        <div class="profile__header-content">
                            <x-user-tag :user="$user" :anon="false" class="profile__username">
                                <x-slot:appendedIcons>
                                    @if ($user->isOnline())
                                        <i
                                            class="{{ config('other.font-awesome') }} fa-circle text-green"
                                            title="{{ __('user.online') }}"
                                        ></i>
                                    @else
                                        <i
                                            class="{{ config('other.font-awesome') }} fa-circle text-red"
                                            title="{{ __('user.offline') }}"
                                        ></i>
                                    @endif
                                    <a
                                        href="{{ route('users.conversations.create', ['user' => auth()->user(), 'username' => $user->username]) }}"
                                    >
                                        <i
                                            class="{{ config('other.font-awesome') }} fa-envelope text-info"
                                        ></i>
                                    </a>
                                    @if ($user->warnings()->active()->exists())
                                        <i
                                            class="{{ config('other.font-awesome') }} fa-exclamation-circle text-orange"
                                            aria-hidden="true"
                                            title="{{ __('user.active-warning') }}"
                                        ></i>
                                    @endif
                                </x-slot>
                            </x-user-tag>
                            <div class="profile__meta">
                                <span>
                                    <i class="{{ config('other.font-awesome') }} fa-calendar-alt"></i>
                                    {{ __('user.registration-date') }}:
                                    <time
                                        datetime="{{ $user->created_at }}"
                                        title="{{ $user->created_at }}"
                                    >
                                        {{ $user->created_at?->diffForHumans() ?? 'N/A' }}
                                    </time>
                                </span>
                                <span>
                                    <i class="{{ config('other.font-awesome') }} fa-sign-in-alt"></i>
                                    {{ __('user.last-login') }}:
                                    @if ($user->last_login)
                                        <time
                                            datetime="{{ $user->last_login }}"
                                            title="{{ $user->last_login }}"
                                        >
                                            {{ $user->last_login->diffForHumans() }}
                                        </time>
                                    @else
                                        N/A
                                    @endif
                                </span>
                                <span>
                                    <i class="{{ config('other.font-awesome') }} fa-clock"></i>
                                    {{ __('user.last-action') }}:
                                    @if ($user->last_action)
                                        <time
                                            datetime="{{ $user->last_action }}"
                                            title="{{ $user->last_action }}"
                                        >
                                            {{ $user->last_action->diffForHumans() }}
                                        </time>
                                    @else
                                        N/A
                                    @endif
                                </span>
                                @if (auth()->user()->is($user) || auth()->user()->group->is_modo)
                                    <span>
                                        <i class="{{ config('other.font-awesome') }} fa-key"></i>
                                        {{ __('user.passkey') }}: ••••••••
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Info row: ID / Invited by / Email / 2FA --}}
                    @if (auth()->user()->is($user) || auth()->user()->group->is_modo)
                        <div class="profile__info-row">
                            <span>
                                <i class="{{ config('other.font-awesome') }} fa-hashtag"></i>
                                {{ __('user.user-id') }}: <strong>{{ $user->id }}</strong>
                            </span>
                            <span>
                                <i class="{{ config('other.font-awesome') }} fa-user-friends"></i>
                                {{ __('user.invited-by') }}:
                                @if ($invitedBy)
                                    <x-user-tag :user="$invitedBy->sender" :anon="false" />
                                @else
                                    <strong>{{ __('user.open-registration') }}</strong>
                                @endif
                            </span>
                            <span>
                                <i class="{{ config('other.font-awesome') }} fa-envelope"></i>
                                {{ __('common.email') }}: {{ $user->email }}
                            </span>
                            <span>
                                @if ($user->two_factor_confirmed_at !== null)
                                    <i class="{{ config('other.font-awesome') }} fa-lock text-green"></i>
                                    2FA: <span class="text-green">{{ __('common.yes') }}</span>
                                @else
                                    <i class="{{ config('other.font-awesome') }} fa-lock-open text-red"></i>
                                    2FA: <span class="text-red">{{ __('common.no') }}</span>
                                @endif
                            </span>
                        </div>
                    @endif

                    {{-- Permissions section --}}
                    @if (auth()->user()->is($user) || auth()->user()->group->is_modo)
                        <div class="profile__permissions">
                            <div class="profile__permissions-header">
                                <i class="{{ config('other.font-awesome') }} fa-lock"></i>
                                {{ __('user.permissions') }}
                            </div>
                            <div class="profile__permission-badges">
                                <span class="permission-badge {{ ($user->can_upload ?? $user->group->can_upload) ? 'permission-badge--active' : 'permission-badge--inactive' }}">
                                    <i class="{{ config('other.font-awesome') }} fa-upload"></i>
                                    {{ __('common.upload') }}
                                </span>
                                <span class="permission-badge {{ $user->can_download ? 'permission-badge--active' : 'permission-badge--inactive' }}">
                                    <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                    {{ __('common.download') }}
                                </span>
                                <span class="permission-badge {{ ($user->can_comment ?? $user->group->can_comment) ? 'permission-badge--active' : 'permission-badge--inactive' }}">
                                    <i class="{{ config('other.font-awesome') }} fa-comment"></i>
                                    {{ __('common.comment') }}
                                </span>
                                <span class="permission-badge {{ ($user->can_request ?? $user->group->can_request) ? 'permission-badge--active' : 'permission-badge--inactive' }}">
                                    <i class="{{ config('other.font-awesome') }} fa-question-circle"></i>
                                    {{ __('user.request') }}
                                </span>
                                <span class="permission-badge {{ (($user->can_invite ?? $user->group->can_invite) && $user->two_factor_confirmed_at !== null) ? 'permission-badge--active' : 'permission-badge--inactive' }}">
                                    <i class="{{ config('other.font-awesome') }} fa-paper-plane"></i>
                                    {{ __('user.invites') }}
                                </span>
                                <span class="permission-badge {{ ($user->can_chat ?? $user->group->can_chat) ? 'permission-badge--active' : 'permission-badge--inactive' }}">
                                    <i class="{{ config('other.font-awesome') }} fa-comments"></i>
                                    {{ __('common.chat') }}
                                </span>
                            </div>
                            @php
                                $hasSpecialBadge = $user->group->is_freeleech
                                    || $user->group->is_double_upload
                                    || $user->group->is_trusted
                                    || $user->group->is_immune;
                            @endphp
                            @if ($hasSpecialBadge)
                                <div class="profile__special-badges">
                                    @if ($user->group->is_freeleech)
                                        <span class="special-badge special-badge--freeleech">
                                            <i class="{{ config('other.font-awesome') }} fa-star"></i>
                                            {{ __('user.freeleech') }}
                                        </span>
                                    @endif
                                    @if ($user->group->is_double_upload)
                                        <span class="special-badge special-badge--double-upload">
                                            <i class="{{ config('other.font-awesome') }} fa-sort-amount-up"></i>
                                            {{ __('user.double-upload') }}
                                        </span>
                                    @endif
                                    @if ($user->group->is_trusted)
                                        <span class="special-badge special-badge--skip-modq">
                                            <i class="{{ config('other.font-awesome') }} fa-check-circle"></i>
                                            {{ __('user.skip-modq') }}
                                        </span>
                                    @endif
                                    @if ($user->group->is_immune)
                                        <span class="special-badge special-badge--hnr-immune">
                                            <i class="{{ config('other.font-awesome') }} fa-shield-alt"></i>
                                            {{ __('user.hnr-immune') }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Stats cards --}}
                    @if (auth()->user()->isAllowed($user, 'profile', 'show_profile_torrent_ratio'))
                        <div class="profile__stats">
                            <div class="profile__stat-card">
                                <i class="{{ config('other.font-awesome') }} fa-balance-scale profile__stat-icon"></i>
                                <div class="profile__stat-value">{{ $user->formatted_ratio }}</div>
                                <div class="profile__stat-label">{{ __('common.ratio') }}</div>
                            </div>
                            <div class="profile__stat-card">
                                <i class="{{ config('other.font-awesome') }} fa-database profile__stat-icon"></i>
                                <div class="profile__stat-value">{{ App\Helpers\StringHelper::formatBytes($user->seedingTorrents()->sum('size'), 2) }}</div>
                                <div class="profile__stat-label">{{ __('user.seeding-size') }}</div>
                            </div>
                            <div class="profile__stat-card">
                                <i class="{{ config('other.font-awesome') }} fa-arrow-up profile__stat-icon"></i>
                                <div class="profile__stat-value">{{ $user->formatted_uploaded }}</div>
                                <div class="profile__stat-label">{{ __('user.total-upload') }}</div>
                            </div>
                            <div class="profile__stat-card">
                                <i class="{{ config('other.font-awesome') }} fa-arrow-down profile__stat-icon"></i>
                                <div class="profile__stat-value">{{ $user->formatted_downloaded }}</div>
                                <div class="profile__stat-label">{{ __('user.total-download') }}</div>
                            </div>
                            <div class="profile__stat-card">
                                <i class="{{ config('other.font-awesome') }} fa-upload profile__stat-icon"></i>
                                <div class="profile__stat-value">{{ ($user->non_anon_uploads_count ?? 0) + ($user->anon_uploads_count ?? 0) }}</div>
                                <div class="profile__stat-label">{{ __('user.total-uploads') }}</div>
                            </div>
                            <div class="profile__stat-card">
                                <i class="{{ config('other.font-awesome') }} fa-hourglass-half profile__stat-icon"></i>
                                <div class="profile__stat-value">{{ App\Helpers\StringHelper::timeElapsed(($history->seedtime_sum ?? 0) / max(1, $history->count ?? 0)) }}</div>
                                <div class="profile__stat-label">{{ __('user.avg-seedtime') }}</div>
                            </div>
                            <div class="profile__stat-card">
                                <i class="{{ config('other.font-awesome') }} fa-satellite-dish profile__stat-icon"></i>
                                <div class="profile__stat-value text-green">{{ $peers->seeding ?? 0 }}</div>
                                <div class="profile__stat-label">{{ __('user.total-seeding') }}</div>
                            </div>
                            @if (auth()->user()->isAllowed($user, 'profile', 'show_profile_warning'))
                                <div class="profile__stat-card">
                                    <i class="{{ config('other.font-awesome') }} fa-exclamation-triangle profile__stat-icon text-yellow"></i>
                                    <div class="profile__stat-value">{{ $user->active_warnings_count ?? 0 }}</div>
                                    <div class="profile__stat-label">{{ __('user.active-warnings') }}</div>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if (auth()->user()->isAllowed($user, 'profile', 'show_profile_title') && $user->title)
                        <span class="profile__title">
                            {{ __('user.title') }}: {{ $user->title }}
                        </span>
                    @endif

                    @if (auth()->user()->isAllowed($user, 'profile', 'show_profile_about') && $user->about)
                        <div class="profile__about">
                            {{ __('user.about') }}:
                            <div class="bbcode-rendered">@bbcode($user->about ?? 'N/A')</div>
                        </div>
                    @endif
                </article>
            </div>
        </section>
        @if (auth()->user()->isAllowed($user, 'profile', 'show_profile_achievement'))
            <section class="panelV2 profile-collapsible" x-data="{ open: true }">
                <header class="panel__header profile-collapsible__header" @click="open = !open">
                    <h2 class="panel__heading">
                        <i class="{{ config('other.font-awesome') }} fa-trophy"></i>
                        {{ __('user.recent-achievements') }}
                    </h2>
                    <i class="{{ config('other.font-awesome') }} fa-chevron-down profile-collapsible__chevron" :class="{ 'profile-collapsible__chevron--open': open }"></i>
                </header>
                <div class="panel__body profile__badges" x-show="open" x-cloak x-transition>
                    @forelse ($achievements->take(25) as $achievement)
                        <img
                            class="profile__badge"
                            src="/img/badges/{{ $achievement->details->name }}.png"
                            title="{{ $achievement->details->name }}"
                            alt="{{ $achievement->details->name }}"
                        />
                    @empty
                        {{ __('user.no-recent-achievements') }}
                    @endforelse
                </div>
            </section>
        @endif

        @if ($userBadges->count() > 0)
            <section class="panelV2 profile-collapsible profile-badges-section" x-data="{ open: true }">
                <header class="panel__header profile-collapsible__header" @click="open = !open">
                    <h2 class="panel__heading">
                        <i class="{{ config('other.font-awesome') }} fa-shield-halved"></i>
                        Lencana
                        <span style="font-weight:400; font-size:0.85rem; opacity:0.6; margin-left:0.4rem">({{ $userBadges->count() }})</span>
                    </h2>
                    <i class="{{ config('other.font-awesome') }} fa-chevron-down profile-collapsible__chevron" :class="{ 'profile-collapsible__chevron--open': open }"></i>
                </header>
                <div x-show="open" x-cloak x-transition>
                    <div class="profile-badges-grid">
                        @foreach ($userBadges->take(20) as $badge)
                            <a class="profile-badge-chip"
                               href="{{ route('badges.index') }}"
                               title="{{ $badge->description }} — Diperoleh {{ \Carbon\Carbon::parse($badge->pivot->awarded_at)->diffForHumans() }}"
                               style="--badge-color: {{ $badge->color }}">
                                <i class="{{ config('other.font-awesome') }} {{ $badge->icon }}"></i>
                                {{ $badge->name }}
                            </a>
                        @endforeach
                    </div>
                    @if ($userBadges->count() > 20)
                        <p class="profile-badges-more">
                            <a href="{{ route('badges.index') }}">+ {{ $userBadges->count() - 20 }} lagi lencana</a>
                        </p>
                    @endif
                </div>
            </section>
        @endif

        {{-- Statistics Grid --}}
        <div class="profile-panels-grid">
            {{-- Traffic Statistics --}}
            @if (auth()->user()->isAllowed($user, 'profile', 'show_profile_torrent_ratio'))
                <div class="profile-panel" x-data="{ open: true }">
                    <div class="profile-panel__header" @click="open = !open">
                        <span class="profile-panel__title">
                            <i class="{{ config('other.font-awesome') }} fa-chart-bar"></i>
                            {{ __('user.traffic-statistics') }}
                        </span>
                        <i class="{{ config('other.font-awesome') }} fa-chevron-down profile-panel__chevron" :class="{ 'profile-panel__chevron--open': open }"></i>
                    </div>
                    <div class="profile-panel__body" x-show="open" x-cloak x-transition>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-balance-scale"></i>
                            <span class="profile-panel__label">{{ __('user.real-ratio') }}</span>
                            <span class="profile-panel__value">{{ $history->download_sum ? round(($history->upload_sum ?? 0) / $history->download_sum, 2) : "\u{221E}" }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-arrow-up"></i>
                            <span class="profile-panel__label">{{ __('user.account-upload') }}</span>
                            <span class="profile-panel__value">{{ $user->formatted_uploaded }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-arrow-down"></i>
                            <span class="profile-panel__label">{{ __('user.account-download') }}</span>
                            <span class="profile-panel__value">{{ $user->formatted_downloaded }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-upload"></i>
                            <span class="profile-panel__label">{{ __('user.torrent-upload') }}</span>
                            <span class="profile-panel__value">{{ App\Helpers\StringHelper::formatBytes($history->upload_sum ?? 0, 2) }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-upload"></i>
                            <span class="profile-panel__label">{{ __('user.upload-credited') }}</span>
                            <span class="profile-panel__value">{{ App\Helpers\StringHelper::formatBytes($history->credited_upload_sum ?? 0, 2) }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-download"></i>
                            <span class="profile-panel__label">{{ __('user.torrent-download') }}</span>
                            <span class="profile-panel__value">{{ App\Helpers\StringHelper::formatBytes($history->download_sum ?? 0, 2) }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-download"></i>
                            <span class="profile-panel__label">{{ __('user.download-credited') }}</span>
                            <span class="profile-panel__value">{{ App\Helpers\StringHelper::formatBytes($history->credited_download_sum ?? 0, 2) }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-undo"></i>
                            <span class="profile-panel__label">{{ __('user.download-refunded') }}</span>
                            <span class="profile-panel__value">{{ App\Helpers\StringHelper::formatBytes($history->refunded_download_sum ?? 0, 2) }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-coins"></i>
                            <span class="profile-panel__label">{{ __('user.bon-upload') }}</span>
                            <span class="profile-panel__value">{{ App\Helpers\StringHelper::formatBytes($boughtUpload, 2) }}</span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Torrent Activity --}}
            @if (auth()->user()->isAllowed($user, 'profile', 'show_profile_torrent_count'))
                <div class="profile-panel" x-data="{ open: true }">
                    <div class="profile-panel__header" @click="open = !open">
                        <span class="profile-panel__title">
                            <i class="{{ config('other.font-awesome') }} fa-cloud-upload-alt"></i>
                            {{ __('user.torrent-activity') }}
                        </span>
                        <i class="{{ config('other.font-awesome') }} fa-chevron-down profile-panel__chevron" :class="{ 'profile-panel__chevron--open': open }"></i>
                    </div>
                    <div class="profile-panel__body" x-show="open" x-cloak x-transition>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-upload"></i>
                            <span class="profile-panel__label">
                                @if (auth()->user()->is($user) || auth()->user()->group->is_modo)
                                    <a href="{{ route('users.torrents.index', ['user' => $user]) }}">{{ __('user.total-uploads') }}</a>
                                @else
                                    <a href="{{ route('torrents.index', ['uploader' => $user->username]) }}">{{ __('user.total-uploads') }}</a>
                                @endif
                            </span>
                            <span class="profile-panel__value">{{ ($user->non_anon_uploads_count ?? 0) + ($user->anon_uploads_count ?? 0) }}</span>
                        </div>
                        @if (auth()->user()->is($user) || auth()->user()->group->is_modo)
                            <div class="profile-panel__item">
                                <i class="{{ config('other.font-awesome') }} fa-user-secret"></i>
                                <span class="profile-panel__label">{{ __('user.anon-uploads') }}</span>
                                <span class="profile-panel__value">{{ $user->anon_uploads_count ?? 0 }}</span>
                            </div>
                        @endif
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-download"></i>
                            <span class="profile-panel__label">
                                @if (auth()->user()->is($user) || auth()->user()->group->is_modo)
                                    <a href="{{ route('users.history.index', ['user' => $user, 'downloaded' => 'include']) }}">{{ __('user.total-downloads') }}</a>
                                @else
                                    {{ __('user.total-downloads') }}
                                @endif
                            </span>
                            <span class="profile-panel__value">{{ $history->download_count ?? 0 }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-satellite-dish"></i>
                            <span class="profile-panel__label">
                                @if (auth()->user()->is($user) || auth()->user()->group->is_modo)
                                    <a href="{{ route('users.peers.index', ['user' => $user, 'seeding' => 'include']) }}">{{ __('user.total-seeding') }}</a>
                                @else
                                    {{ __('user.total-seeding') }}
                                @endif
                            </span>
                            <span class="profile-panel__value text-green">{{ $peers->seeding ?? 0 }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-arrow-circle-down"></i>
                            <span class="profile-panel__label">
                                @if (auth()->user()->is($user) || auth()->user()->group->is_modo)
                                    <a href="{{ route('users.peers.index', ['user' => $user, 'seeding' => 'exclude']) }}">{{ __('user.total-leeching') }}</a>
                                @else
                                    {{ __('user.total-leeching') }}
                                @endif
                            </span>
                            <span class="profile-panel__value">{{ $peers->leeching ?? 0 }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-minus-circle"></i>
                            <span class="profile-panel__label">
                                @if (auth()->user()->is($user) || auth()->user()->group->is_modo)
                                    <a href="{{ route('users.peers.index', ['user' => $user, 'active' => 'exclude']) }}">{{ __('user.inactive-peers') }}</a>
                                @else
                                    {{ __('user.inactive-peers') }}
                                @endif
                            </span>
                            <span class="profile-panel__value">{{ $peers->inactive ?? 0 }}</span>
                        </div>
                        @if (config('other.thanks-system.is-enabled'))
                            <div class="profile-panel__item">
                                <i class="{{ config('other.font-awesome') }} fa-heart"></i>
                                <span class="profile-panel__label">{{ __('user.thanks-received') }}</span>
                                <span class="profile-panel__value">{{ $user->thanksReceived()->count() }}</span>
                            </div>
                            <div class="profile-panel__item">
                                <i class="{{ config('other.font-awesome') }} fa-heart"></i>
                                <span class="profile-panel__label">{{ __('user.thanks-given') }}</span>
                                <span class="profile-panel__value">{{ $user->thanksGiven()->count() }}</span>
                            </div>
                        @endif
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-cloud-download-alt"></i>
                            <span class="profile-panel__label">{{ __('user.upload-snatches') }}</span>
                            <span class="profile-panel__value">{{ $user->uploadSnatches()->count() }}</span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Seed Statistics --}}
            @if (auth()->user()->isAllowed($user, 'profile', 'show_profile_torrent_seed'))
                <div class="profile-panel" x-data="{ open: true }">
                    <div class="profile-panel__header" @click="open = !open">
                        <span class="profile-panel__title">
                            <i class="{{ config('other.font-awesome') }} fa-leaf"></i>
                            {{ __('user.seed-statistics') }}
                        </span>
                        <i class="{{ config('other.font-awesome') }} fa-chevron-down profile-panel__chevron" :class="{ 'profile-panel__chevron--open': open }"></i>
                    </div>
                    <div class="profile-panel__body" x-show="open" x-cloak x-transition>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-clock"></i>
                            <span class="profile-panel__label">{{ __('user.total-seedtime') }}</span>
                            <span class="profile-panel__value">{{ App\Helpers\StringHelper::timeElapsed($history->seedtime_sum ?? 0) }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-hourglass-half"></i>
                            <span class="profile-panel__label">{{ __('user.avg-seedtime') }}</span>
                            <span class="profile-panel__value">{{ App\Helpers\StringHelper::timeElapsed(($history->seedtime_sum ?? 0) / max(1, $history->count ?? 0)) }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-database"></i>
                            <span class="profile-panel__label">{{ __('user.seeding-size') }}</span>
                            <span class="profile-panel__value">{{ App\Helpers\StringHelper::formatBytes($user->seedingTorrents()->sum('size'), 2) }}</span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Community --}}
            <div class="profile-panel" x-data="{ open: true }">
                <div class="profile-panel__header" @click="open = !open">
                    <span class="profile-panel__title">
                        <i class="{{ config('other.font-awesome') }} fa-users"></i>
                        {{ __('user.community') }}
                    </span>
                    <i class="{{ config('other.font-awesome') }} fa-chevron-down profile-panel__chevron" :class="{ 'profile-panel__chevron--open': open }"></i>
                </div>
                <div class="profile-panel__body" x-show="open" x-cloak x-transition>
                    @if (auth()->user()->isAllowed($user, 'profile', 'show_profile_forum_extra'))
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-comments"></i>
                            <span class="profile-panel__label">
                                <a href="{{ route('users.topics.index', ['user' => $user]) }}">{{ __('user.topics-started') }}</a>
                            </span>
                            <span class="profile-panel__value">{{ $user->topics_count }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-comment"></i>
                            <span class="profile-panel__label">
                                <a href="{{ route('users.posts.index', ['user' => $user]) }}">{{ __('user.posts-posted') }}</a>
                            </span>
                            <span class="profile-panel__value">{{ $user->posts_count }}</span>
                        </div>
                    @endif
                    @if (auth()->user()->isAllowed($user, 'profile', 'show_profile_comment_extra'))
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-newspaper"></i>
                            <span class="profile-panel__label">{{ __('user.article-comments') }}</span>
                            <span class="profile-panel__value">{{ $user->comments()->whereHasMorph('commentable', [App\Models\Article::class])->count() }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-film"></i>
                            <span class="profile-panel__label">{{ __('user.torrent-comments') }}</span>
                            <span class="profile-panel__value">{{ $user->comments()->whereHasMorph('commentable', [App\Models\Torrent::class])->count() }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-question"></i>
                            <span class="profile-panel__label">{{ __('user.request-comments') }}</span>
                            <span class="profile-panel__value">{{ $user->comments()->whereHasMorph('commentable', [App\Models\TorrentRequest::class])->count() }}</span>
                        </div>
                    @endif
                    @if (auth()->user()->isAllowed($user, 'profile', 'show_profile_request_extra'))
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-hand-paper"></i>
                            <span class="profile-panel__label">
                                <a href="{{ route('requests.index', ['requestor' => $user->username]) }}">{{ __('user.request') }}</a>
                            </span>
                            <span class="profile-panel__value">{{ $user->requests_count }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-check-circle"></i>
                            <span class="profile-panel__label">{{ __('user.filled-request') }}</span>
                            <span class="profile-panel__value">{{ $user->filled_requests_count }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- BON Transactions --}}
            @if (auth()->user()->isAllowed($user, 'profile', 'show_profile_bon_extra'))
                <div class="profile-panel" x-data="{ open: true }">
                    <div class="profile-panel__header" @click="open = !open">
                        <span class="profile-panel__title">
                            <i class="{{ config('other.font-awesome') }} fa-coins"></i>
                            {{ __('user.bon-transactions') }}
                        </span>
                        <i class="{{ config('other.font-awesome') }} fa-chevron-down profile-panel__chevron" :class="{ 'profile-panel__chevron--open': open }"></i>
                    </div>
                    <div class="profile-panel__body" x-show="open" x-cloak x-transition>
                        @if (auth()->user()->isNot($user))
                            <div class="profile-panel__action-row" x-data="dialog" @click.stop>
                                <button class="form__button form__button--text profile-panel__gift-btn" x-bind="showDialog">
                                    <i class="{{ config('other.font-awesome') }} fa-gift"></i> Gift BON
                                </button>
                                <dialog class="dialog" x-bind="dialogElement">
                                    <h3 class="dialog__heading">Gift BON to: {{ $user->username }}</h3>
                                    <form class="dialog__form" method="POST" action="{{ route('users.gifts.store', ['user' => auth()->user()]) }}" x-bind="dialogForm">
                                        @csrf
                                        <input type="hidden" name="recipient_username" value="{{ $user->username }}" />
                                        <p class="form__group">
                                            <input id="bon" class="form__text" name="bon" type="text" pattern="[0-9]*" inputmode="numeric" placeholder=" " />
                                            <label class="form__label form__label--floating" for="bon">{{ __('bon.amount') }}</label>
                                        </p>
                                        <p class="form__group">
                                            <textarea id="message" class="form__textarea" name="message" placeholder=" "></textarea>
                                            <label class="form__label form__label--floating" for="message">{{ __('pm.message') }}</label>
                                        </p>
                                        <p class="form__group">
                                            <button class="form__button form__button--filled">{{ __('bon.gift') }}</button>
                                            <button formmethod="dialog" formnovalidate class="form__button form__button--outlined">{{ __('common.cancel') }}</button>
                                        </p>
                                    </form>
                                </dialog>
                            </div>
                        @endif
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-wallet"></i>
                            <span class="profile-panel__label">
                                <a href="{{ route('users.earnings.index', ['user' => $user]) }}">{{ __('user.bon-balance') }}</a>
                            </span>
                            <span class="profile-panel__value text-yellow">{{ $user->formatted_seedbonus }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-thumbs-up"></i>
                            <span class="profile-panel__label">{{ __('user.tips-received') }}</span>
                            <span class="profile-panel__value text-green">{{ \number_format($user->receivedPostTips()->sum('bon') + $user->receivedTorrentTips()->sum('bon'), 0, null, "\u{202F}") }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-thumbs-down"></i>
                            <span class="profile-panel__label">{{ __('user.tips-given') }}</span>
                            <span class="profile-panel__value">{{ \number_format($user->sentPostTips()->sum('bon') + $user->sentTorrentTips()->sum('bon'), 0, null, "\u{202F}") }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-gift"></i>
                            <span class="profile-panel__label">{{ __('user.gift-received') }}</span>
                            <span class="profile-panel__value text-green">{{ \number_format($user->receivedGifts()->sum('bon'), 0, null, "\u{202F}") }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-gift"></i>
                            <span class="profile-panel__label">{{ __('user.gift-given') }}</span>
                            <span class="profile-panel__value">{{ \number_format($user->sentGifts()->sum('bon'), 0, null, "\u{202F}") }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-trophy"></i>
                            <span class="profile-panel__label">{{ __('user.bounty-received') }}</span>
                            <span class="profile-panel__value text-green">{{ \number_format($user->filledRequests()->sum('bounty'), 0, null, "\u{202F}") }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-donate"></i>
                            <span class="profile-panel__label">{{ __('user.bounty-given') }}</span>
                            <span class="profile-panel__value">{{ \number_format($user->requestBounty()->sum('seedbonus'), 0, null, "\u{202F}") }}</span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Currencies --}}
            @if (auth()->user()->isAllowed($user, 'profile', 'show_profile_torrent_extra'))
                <div class="profile-panel" x-data="{ open: true }">
                    <div class="profile-panel__header" @click="open = !open">
                        <span class="profile-panel__title">
                            <i class="{{ config('other.font-awesome') }} fa-star"></i>
                            {{ __('user.currencies') }}
                        </span>
                        <i class="{{ config('other.font-awesome') }} fa-chevron-down profile-panel__chevron" :class="{ 'profile-panel__chevron--open': open }"></i>
                    </div>
                    <div class="profile-panel__body" x-show="open" x-cloak x-transition>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-ticket-alt"></i>
                            <span class="profile-panel__label">{{ __('common.fl_tokens') }}</span>
                            <span class="profile-panel__value text-yellow">{{ $user->fl_tokens }}</span>
                        </div>
                        <div class="profile-panel__item">
                            <i class="{{ config('other.font-awesome') }} fa-paper-plane"></i>
                            <span class="profile-panel__label">
                                <a href="{{ route('users.invites.index', ['user' => $user]) }}">{{ __('user.invites') }}</a>
                            </span>
                            <span class="profile-panel__value">{{ $user->invites }}</span>
                        </div>
                        @if (auth()->user()->isAllowed($user, 'profile', 'show_profile_warning'))
                            <div class="profile-panel__item">
                                <i class="{{ config('other.font-awesome') }} fa-exclamation-triangle text-yellow"></i>
                                <span class="profile-panel__label">{{ __('user.active-warnings') }}</span>
                                <span class="profile-panel__value {{ ($user->active_warnings_count ?? 0) > 0 ? 'text-red' : '' }}">{{ $user->active_warnings_count ?? 0 }}</span>
                            </div>
                            <div class="profile-panel__item">
                                <i class="{{ config('other.font-awesome') }} fa-running text-orange"></i>
                                <span class="profile-panel__label">{{ __('user.hit-n-runs') }}</span>
                                <span class="profile-panel__value {{ $user->hitandruns > 0 ? 'text-red' : '' }}">{{ $user->hitandruns }}</span>
                            </div>
                        @endif
                        @if (auth()->user()->group->is_modo || auth()->user()->is($user))
                            <div class="profile-panel__item">
                                <i class="{{ config('other.font-awesome') }} fa-heart text-red"></i>
                                <span class="profile-panel__label">{{ __('user.active-donor') }}</span>
                                <span class="profile-panel__value">
                                    @if ($user->is_donor)
                                        <i class="{{ config('other.font-awesome') }} fa-check text-green"></i>
                                    @else
                                        <i class="{{ config('other.font-awesome') }} fa-times text-red"></i>
                                    @endif
                                </span>
                            </div>
                        @endif
                        @if (auth()->user()->is($user) || auth()->user()->group->is_modo)
                            <div class="profile-panel__item profile-panel__item--passkey">
                                <i class="{{ config('other.font-awesome') }} fa-key"></i>
                                <span class="profile-panel__label">{{ __('user.passkey') }}</span>
                                <span class="profile-panel__value">
                                    <details>
                                        <summary style="cursor:pointer">{{ __('user.show-passkey') }}</summary>
                                        <code style="font-size:0.75rem;word-break:break-all">{{ $user->passkey }}</code>
                                        <span class="text-red" style="font-size:0.75rem">{{ __('user.passkey-warning') }}</span>
                                    </details>
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        @if (auth()->user()->isAllowed($user, 'profile', 'show_profile_follower'))
            <section class="panelV2 profile-collapsible" x-data="{ open: true }">
                <header class="panel__header profile-collapsible__header" @click="open = !open">
                    <h2 class="panel__heading">
                        <i class="{{ config('other.font-awesome') }} fa-user-friends"></i>
                        {{ __('user.recent-followers') }}
                        <span class="profile-collapsible__count">({{ $followers->count() }})</span>
                    </h2>
                    <div class="panel__actions" @click.stop>
                        @if (auth()->id() !== $user->id)
                            @if ($user->followers()->where('users.id', '=', auth()->id())->exists())
                                <form action="{{ route('users.followers.destroy', ['user' => $user]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="form__button form__button--text" id="delete-follow-{{ $user->target_id }}">{{ __('user.unfollow') }}</button>
                                </form>
                            @else
                                <form action="{{ route('users.followers.store', ['user' => $user]) }}" method="POST">
                                    @csrf
                                    <button class="form__button form__button--text" id="follow-user-{{ $user->id }}">{{ __('user.follow') }}</button>
                                </form>
                            @endif
                        @endif
                        <i class="{{ config('other.font-awesome') }} fa-chevron-down profile-collapsible__chevron" :class="{ 'profile-collapsible__chevron--open': open }"></i>
                    </div>
                </header>
                <div class="panel__body followers-grid" x-show="open" x-cloak x-transition>
                    @forelse ($followers as $follower)
                        <a class="follower-card" href="{{ route('users.show', ['user' => $follower]) }}">
                            <img
                                class="follower-card__avatar"
                                alt="{{ $follower->username }}"
                                src="{{ $follower->image === null ? url('img/profile.png') : route('authenticated_images.user_avatar', ['user' => $follower]) }}"
                            />
                            <span class="follower-card__name" style="color: {{ $follower->group->color }}">
                                {{ $follower->username }}
                            </span>
                            <span class="follower-card__group">{{ $follower->group->name }}</span>
                        </a>
                    @empty
                        <p class="followers-grid__empty">{{ __('user.no-recent-followers') }}</p>
                    @endforelse
                </div>
            </section>
        @endif

        @if (auth()->user()->is($user) || auth()->user()->group->is_modo)
            <section class="panelV2 profile-collapsible" x-data="{ open: true }">
                <header class="panel__header profile-collapsible__header" @click="open = !open">
                    <h2 class="panel__heading">
                        <i class="{{ config('other.font-awesome') }} fa-desktop"></i>
                        {{ __('user.client-list') }}
                        <span class="profile-collapsible__count">({{ $clients->count() }})</span>
                    </h2>
                    <i class="{{ config('other.font-awesome') }} fa-chevron-down profile-collapsible__chevron" :class="{ 'profile-collapsible__chevron--open': open }"></i>
                </header>
                <div class="clients-list" x-show="open" x-cloak x-transition>
                    @forelse ($clients as $client)
                        <div class="client-card">
                            <div class="client-card__header">
                                <i class="{{ config('other.font-awesome') }} fa-desktop client-card__icon"></i>
                                <span class="client-card__agent">{{ $client->agent }}</span>
                            </div>
                            <div class="client-card__meta">
                                <div class="client-card__row">
                                    <span class="client-card__label">
                                        <i class="{{ config('other.font-awesome') }} fa-network-wired"></i>
                                        {{ __('common.ip') }} / {{ __('common.port') }}
                                    </span>
                                    <span class="client-card__value">
                                        @if (auth()->user()->group->is_modo)
                                            <a href="{{ route('staff.peers.index', ['ip' => $client->ip, 'groupBy' => 'user_ip']) }}">{{ $client->ip }}</a>
                                        @elseif (auth()->id() === $user->id)
                                            {{ $client->ip }}
                                        @endif
                                        :{{ $client->port }}
                                    </span>
                                </div>
                                <div class="client-card__row">
                                    <span class="client-card__label">
                                        <i class="{{ config('other.font-awesome') }} fa-play-circle"></i>
                                        {{ __('torrent.started') }}
                                    </span>
                                    <span class="client-card__value">
                                        <time datetime="{{ $client->created_at }}" title="{{ $client->created_at }}">
                                            {{ $client->created_at?->diffForHumans() ?? 'N/A' }}
                                        </time>
                                    </span>
                                </div>
                                <div class="client-card__row">
                                    <span class="client-card__label">
                                        <i class="{{ config('other.font-awesome') }} fa-sync-alt"></i>
                                        {{ __('torrent.last-update') }}
                                    </span>
                                    <span class="client-card__value">
                                        <time datetime="{{ $client->updated_at }}" title="{{ $client->updated_at }}">
                                            {{ $client->updated_at?->diffForHumans() ?? 'N/A' }}
                                        </time>
                                    </span>
                                </div>
                                <div class="client-card__row">
                                    <span class="client-card__label">
                                        <i class="{{ config('other.font-awesome') }} fa-users"></i>
                                        Peers
                                    </span>
                                    <span class="client-card__value">
                                        <a href="{{ route('users.peers.index', ['user' => $user, 'ip' => $client->ip, 'port' => $client->port, 'client' => $client->agent]) }}" class="text-green">
                                            {{ $client->num_peers }}
                                        </a>
                                    </span>
                                </div>
                                <div class="client-card__row">
                                    <span class="client-card__label">
                                        <i class="{{ config('other.font-awesome') }} fa-hdd"></i>
                                        {{ __('torrent.size') }}
                                    </span>
                                    <span class="client-card__value">{{ App\Helpers\StringHelper::formatBytes($client->size) }}</span>
                                </div>
                                @if (\config('announce.connectable_check') == true)
                                    @php
                                        $connectable = false;
                                        if (config('announce.external_tracker.is_enabled')) {
                                            $connectable = $client->connectable;
                                        } elseif (cache()->has('peers:connectable:' . $client->ip . '-' . $client->port . '-' . $client->agent)) {
                                            $connectable = cache()->get('peers:connectable:' . $client->ip . '-' . $client->port . '-' . $client->agent);
                                        }
                                    @endphp
                                    <div class="client-card__row">
                                        <span class="client-card__label">
                                            <i class="{{ config('other.font-awesome') }} fa-plug"></i>
                                            {{ __('user.connectable') }}
                                        </span>
                                        <span class="client-card__value {{ $connectable ? 'text-green' : 'text-red' }}">
                                            @choice('user.client-connectable-state', $connectable)
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="clients-list__empty">{{ __('user.no-active-clients') }}</p>
                    @endforelse
                    <p class="clients-list__notice">
                        <i class="{{ config('other.font-awesome') }} fa-info-circle"></i>
                        {{ __('user.client-unrecognised') }}
                        <a href="{{ route('tickets.index') }}">{{ __('ticket.helpdesk') }}</a>
                    </p>
                </div>
            </section>
        @endif

        @if (auth()->user()->group->is_modo)
            @livewire('user-notes', ['user' => $user])
            @if ($user->application !== null)
                <section class="panelV2">
                    <h2 class="panel__heading">{{ __('staff.application') }}</h2>
                    <div class="data-table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>{{ __('common.email') }}</th>
                                    <th>{{ __('staff.application-type') }}</th>
                                    <th>{{ __('common.created_at') }}</th>
                                    <th>{{ __('common.status') }}</th>
                                    <th>{{ __('common.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td>{{ $user->application->email }}</td>
                                <td>{{ $user->application->type }}</td>
                                <td>
                                    <time
                                        datetime="{{ $user->application->created_at }}"
                                        title="{{ $user->application->created_at }}"
                                    >
                                        {{ $user->application->created_at->diffForHumans() }}
                                    </time>
                                </td>
                                <td>
                                    @switch($user->application->status)
                                        @case(\App\Enums\ModerationStatus::PENDING)
                                            <span class="application--pending">Pending</span>

                                            @break
                                        @case(\App\Enums\ModerationStatus::APPROVED)
                                            <span class="application--approved">Approved</span>

                                            @break
                                        @case(\App\Enums\ModerationStatus::REJECTED)
                                            <span class="application--rejected">Rejected</span>

                                            @break
                                        @default
                                            <span class="application--unknown">Unknown</span>
                                    @endswitch
                                </td>
                                <td>
                                    <menu class="data-table__actions">
                                        <li class="data-table__action">
                                            <a
                                                class="form__button form__button--text"
                                                href="{{ route('staff.applications.show', ['id' => $user->application->id]) }}"
                                            >
                                                {{ __('common.view') }}
                                            </a>
                                        </li>
                                    </menu>
                                </td>
                            </tbody>
                        </table>
                    </div>
                </section>
            @endif
        @endif

        @if (auth()->user()->group->is_modo ||auth()->user()->is($user))
            <section class="panelV2">
                <h2 class="panel__heading">{{ __('ticket.helpdesk') }}</h2>
                <div class="data-table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>{{ __('ticket.subject') }}</th>
                                <th>{{ __('common.status') }}</th>
                                <th>{{ __('ticket.created') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->tickets as $ticket)
                                <tr>
                                    <td>
                                        <a
                                            href="{{ route('tickets.show', ['ticket' => $ticket]) }}"
                                        >
                                            {{ $ticket->subject }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($ticket->closed_at)
                                            <i class="fas fa-circle text-danger"></i>
                                            Closed
                                        @else
                                            <i class="fas fa-circle text-success"></i>
                                            Open
                                        @endif
                                    </td>
                                    <td>{{ $ticket->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif

        @if (auth()->user()->group->is_modo)
            @include('user.profile.partials.bans', ['bans' => $user->bans])
        @endif

        @if (auth()->user()->group->is_modo ||auth()->user()->is($user))
            <livewire:user-warnings :user="$user" />
        @endif

        @if (auth()->user()->group->is_modo)
            <section class="panelV2">
                <header class="panel__header">
                    <h2 class="panel__heading">Watchlist</h2>
                    <div class="panel__actions">
                        @if ($watch === null)
                            <div class="panel__action" x-data="dialog">
                                <button
                                    class="form__button form__button--text"
                                    x-bind="showDialog"
                                >
                                    Watch
                                </button>
                                <dialog class="dialog" x-bind="dialogElement">
                                    <h3 class="dialog__heading">
                                        Watch user: {{ $user->username }}
                                    </h3>
                                    <form
                                        class="dialog__form"
                                        method="POST"
                                        action="{{ route('staff.watchlist.store') }}"
                                        x-bind="dialogForm"
                                    >
                                        @csrf
                                        <input
                                            type="hidden"
                                            name="user_id"
                                            value="{{ $user->id }}"
                                        />
                                        <p class="form__group">
                                            <textarea
                                                id="watchlist_reason"
                                                class="form__textarea"
                                                name="message"
                                                required
                                            ></textarea>
                                            <label
                                                class="form__label form__label--floating"
                                                for="watchlist_reason"
                                            >
                                                Reason
                                            </label>
                                        </p>
                                        <p class="form__group">
                                            <button class="form__button form__button--filled">
                                                {{ __('common.save') }}
                                            </button>
                                            <button
                                                formaction="dialog"
                                                formnovalidate
                                                class="form__button form__button--outlined"
                                            >
                                                {{ __('common.cancel') }}
                                            </button>
                                        </p>
                                    </form>
                                </dialog>
                            </div>
                        @else
                            <form
                                class="panel__action"
                                action="{{ route('staff.watchlist.destroy', ['watchlist' => $watch]) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')
                                <button class="form__button form__button--text">Unwatch</button>
                            </form>
                        @endif
                    </div>
                </header>
                <div class="data-table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Watched by</th>
                                <th>Message</th>
                                <th>Created at</th>
                                <th>{{ __('common.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($watch === null)
                                <tr>
                                    <td colspan="4">Not watched</td>
                                </tr>
                            @else
                                <tr>
                                    <td>
                                        <x-user-tag :anon="false" :user="$watch->author" />
                                    </td>
                                    <td>{{ $watch->message }}</td>
                                    <td>
                                        <time
                                            datetime="{{ $watch->created_at }}"
                                            title="{{ $watch->created_at }}"
                                        >
                                            {{ $watch->created_at }}
                                        </time>
                                    </td>
                                    <td>
                                        <menu class="data-table__actions">
                                            <li class="data-table__action">
                                                <form
                                                    action="{{ route('staff.watchlist.destroy', ['watchlist' => $watch]) }}"
                                                    method="POST"
                                                    x-data="confirmation"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        x-on:click.prevent="confirmAction"
                                                        data-b64-deletion-message="{{ base64_encode('Are you sure you want to unwatch this user: ' . $watch->user->username . '?') }}"
                                                        class="form__button form__button--text"
                                                    >
                                                        Unwatch
                                                    </button>
                                                </form>
                                            </li>
                                        </menu>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    @endsection

@else
    @section('main')
        <section class="panelV2">
            <h2 class="panel__heading">{{ __('user.private-profile') }}</h2>
            <div class="panel__body">{{ __('user.not-authorized') }}</div>
        </section>
    @endsection
@endif

<section class="panelV2 panel--grid-item stat-card">
    <header class="stat-card__header">
        <div class="stat-card__header-left">
            <span class="stat-card__icon-box">
                <i class="{{ config('other.font-awesome') }} fa-users"></i>
            </span>
            <h2 class="stat-card__title">{{ __('common.users') }}</h2>
        </div>
        <i class="{{ config('other.font-awesome') }} fa-copy stat-card__copy-icon"></i>
    </header>
    <div class="stat-card__body">
        <div class="stat-card__row">
            <span class="stat-card__row-icon stat-card__row-icon--gold">
                <i class="{{ config('other.font-awesome') }} fa-user"></i>
            </span>
            <span class="stat-card__row-label">{{ __('stat.all') }}</span>
            <span class="stat-card__row-value">{{ number_format($all_user) }}</span>
        </div>
        <div class="stat-card__row">
            <span class="stat-card__row-icon stat-card__row-icon--muted">
                <i class="{{ config('other.font-awesome') }} fa-user-slash"></i>
            </span>
            <span class="stat-card__row-label">{{ __('stat.disabled') }}</span>
            <span class="stat-card__row-value">{{ number_format($disabled_user) }}</span>
        </div>
        <div class="stat-card__row">
            <span class="stat-card__row-icon stat-card__row-icon--muted">
                <i class="{{ config('other.font-awesome') }} fa-user-minus"></i>
            </span>
            <span class="stat-card__row-label">{{ __('stat.pruned') }}</span>
            <span class="stat-card__row-value">{{ number_format($pruned_user) }}</span>
        </div>
        <div class="stat-card__row">
            <span class="stat-card__row-icon stat-card__row-icon--red">
                <i class="{{ config('other.font-awesome') }} fa-user-xmark"></i>
            </span>
            <span class="stat-card__row-label">{{ __('stat.banned') }}</span>
            <span class="stat-card__row-value">{{ number_format($banned_user) }}</span>
        </div>
        <div class="stat-card__section">
            <div class="stat-card__section-heading">
                <i class="{{ config('other.font-awesome') }} fa-bolt stat-card__section-heading-icon"></i>
                {{ __('stat.active') }}
            </div>
            <div class="stat-card__row stat-card__row--indented">
                <span class="stat-card__row-label">{{ __('common.today') }}</span>
                <span class="stat-card__row-value">{{ number_format($users_active_today) }}</span>
            </div>
            <div class="stat-card__row stat-card__row--indented">
                <span class="stat-card__row-label">{{ __('common.this-week') }}</span>
                <span class="stat-card__row-value">{{ number_format($users_active_this_week) }}</span>
            </div>
            <div class="stat-card__row stat-card__row--indented">
                <span class="stat-card__row-label">{{ __('common.this-month') }}</span>
                <span class="stat-card__row-value">{{ number_format($users_active_this_month) }}</span>
            </div>
            <div class="stat-card__row stat-card__row--indented">
                <span class="stat-card__row-label">{{ __('stat.all') }}</span>
                <span class="stat-card__row-value">{{ number_format($active_user) }}</span>
            </div>
        </div>
    </div>
</section>

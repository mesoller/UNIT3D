<section class="panelV2 panel--grid-item stat-card">
    <header class="stat-card__header">
        <div class="stat-card__header-left">
            <span class="stat-card__icon-box">
                <i class="{{ config('other.font-awesome') }} fa-chart-line"></i>
            </span>
            <h2 class="stat-card__title">{{ __('stat.total-traffic') }}</h2>
        </div>
        <i class="{{ config('other.font-awesome') }} fa-copy stat-card__copy-icon"></i>
    </header>
    <div class="stat-card__body">
        <div class="stat-card__section">
            <div class="stat-card__section-heading">
                <i class="{{ config('other.font-awesome') }} fa-chart-bar stat-card__section-heading-icon"></i>
                {{ __('stat.real') }}
            </div>
            <div class="stat-card__row stat-card__row--indented">
                <span class="stat-card__row-icon">
                    <i class="{{ config('other.font-awesome') }} fa-arrow-up" style="color:#ffd700"></i>
                </span>
                <span class="stat-card__row-label">{{ __('stat.total-upload') }}</span>
                <span class="stat-card__row-value">{{ \App\Helpers\StringHelper::formatBytes($actual_upload, 2) }}</span>
            </div>
            <div class="stat-card__row stat-card__row--indented">
                <span class="stat-card__row-icon">
                    <i class="{{ config('other.font-awesome') }} fa-arrow-down" style="color:#ffd700"></i>
                </span>
                <span class="stat-card__row-label">{{ __('stat.total-download') }}</span>
                <span class="stat-card__row-value">{{ \App\Helpers\StringHelper::formatBytes($actual_download, 2) }}</span>
            </div>
            <div class="stat-card__row stat-card__row--indented">
                <span class="stat-card__row-icon">
                    <i class="{{ config('other.font-awesome') }} fa-arrows-up-down" style="color:#ffd700"></i>
                </span>
                <span class="stat-card__row-label">{{ __('stat.total-traffic') }}</span>
                <span class="stat-card__row-value">{{ \App\Helpers\StringHelper::formatBytes($actual_up_down, 2) }}</span>
            </div>
        </div>
        <div class="stat-card__section">
            <div class="stat-card__section-heading">
                <i class="{{ config('other.font-awesome') }} fa-coins stat-card__section-heading-icon"></i>
                {{ __('stat.credited') }}
            </div>
            <div class="stat-card__row stat-card__row--indented">
                <span class="stat-card__row-icon">
                    <i class="{{ config('other.font-awesome') }} fa-arrow-up" style="color:#ffd700"></i>
                </span>
                <span class="stat-card__row-label">{{ __('stat.total-upload') }}</span>
                <span class="stat-card__row-value">{{ \App\Helpers\StringHelper::formatBytes($credited_upload, 2) }}</span>
            </div>
            <div class="stat-card__row stat-card__row--indented">
                <span class="stat-card__row-icon">
                    <i class="{{ config('other.font-awesome') }} fa-arrow-down" style="color:#ffd700"></i>
                </span>
                <span class="stat-card__row-label">{{ __('stat.total-download') }}</span>
                <span class="stat-card__row-value">{{ \App\Helpers\StringHelper::formatBytes($credited_download, 2) }}</span>
            </div>
            <div class="stat-card__row stat-card__row--indented">
                <span class="stat-card__row-icon">
                    <i class="{{ config('other.font-awesome') }} fa-arrows-up-down" style="color:#ffd700"></i>
                </span>
                <span class="stat-card__row-label">{{ __('stat.total-traffic') }}</span>
                <span class="stat-card__row-value">{{ \App\Helpers\StringHelper::formatBytes($credited_up_down, 2) }}</span>
            </div>
        </div>
    </div>
</section>

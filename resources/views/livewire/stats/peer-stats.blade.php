<section class="panelV2 panel--grid-item stat-card">
    <header class="stat-card__header">
        <div class="stat-card__header-left">
            <span class="stat-card__icon-box">
                <i class="{{ config('other.font-awesome') }} fa-shuffle"></i>
            </span>
            <h2 class="stat-card__title">{{ __('torrent.peers') }}</h2>
        </div>
        <i class="{{ config('other.font-awesome') }} fa-copy stat-card__copy-icon"></i>
    </header>
    <div class="stat-card__body">
        <div class="stat-card__row">
            <span class="stat-card__row-icon stat-card__row-icon--green">
                <i class="{{ config('other.font-awesome') }} fa-circle"></i>
            </span>
            <span class="stat-card__row-label">{{ __('torrent.seeders') }}</span>
            <span class="stat-card__row-value">{{ number_format($num_seeders) }}</span>
        </div>
        <div class="stat-card__row">
            <span class="stat-card__row-icon stat-card__row-icon--blue">
                <i class="{{ config('other.font-awesome') }} fa-circle"></i>
            </span>
            <span class="stat-card__row-label">{{ __('torrent.leechers') }}</span>
            <span class="stat-card__row-value">{{ number_format($num_leechers) }}</span>
        </div>
        <div class="stat-card__row">
            <span class="stat-card__row-icon stat-card__row-icon--muted">
                <i class="{{ config('other.font-awesome') }} fa-circle"></i>
            </span>
            <span class="stat-card__row-label">{{ __('common.total') }}</span>
            <span class="stat-card__row-value">{{ number_format($num_peers) }}</span>
        </div>
    </div>
    <div class="stat-card__summary">
        <span class="stat-card__summary-icon">
            <i class="{{ config('other.font-awesome') }} fa-hard-drive"></i>
        </span>
        <div class="stat-card__summary-text">
            <span class="stat-card__summary-label">{{ __('torrent.seedsize') }}</span>
            <span class="stat-card__summary-value">{{ \App\Helpers\StringHelper::formatBytes($totalSeeded) }}</span>
        </div>
    </div>
</section>

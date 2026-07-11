<section class="panelV2 panel--grid-item stat-card">
    <header class="stat-card__header">
        <div class="stat-card__header-left">
            <span class="stat-card__icon-box">
                <i class="{{ config('other.font-awesome') }} fa-border-all"></i>
            </span>
            <h2 class="stat-card__title">{{ __('torrent.torrents') }}</h2>
        </div>
        <i class="{{ config('other.font-awesome') }} fa-copy stat-card__copy-icon"></i>
    </header>
    <div class="stat-card__body">
        <div class="stat-card__section">
            <div class="stat-card__section-heading">
                <i class="{{ config('other.font-awesome') }} fa-folder stat-card__section-heading-icon"></i>
                {{ __('common.category') }}
            </div>
            @foreach ($categories as $category)
                <div class="stat-card__row stat-card__row--indented">
                    <span class="stat-card__row-label">{{ $category->name }}</span>
                    <span class="stat-card__row-value">{{ number_format($category->torrents_count) }}</span>
                </div>
            @endforeach
        </div>
        <div class="stat-card__section">
            <div class="stat-card__section-heading">
                <i class="{{ config('other.font-awesome') }} fa-desktop stat-card__section-heading-icon"></i>
                {{ __('common.resolution') }}
            </div>
            @foreach ($resolutions as $resolution)
                <div class="stat-card__row stat-card__row--indented">
                    <span class="stat-card__row-label">{{ $resolution->name }}</span>
                    <span class="stat-card__row-value">{{ number_format($resolution->torrents_count) }}</span>
                </div>
            @endforeach
        </div>
    </div>
    <div class="stat-card__summary">
        <span class="stat-card__summary-icon">
            <i class="{{ config('other.font-awesome') }} fa-coins"></i>
        </span>
        <div class="stat-card__summary-text">
            <span class="stat-card__summary-label">{{ __('stat.total-torrents') }}</span>
            <span class="stat-card__summary-value">{{ number_format($num_torrent) }}</span>
        </div>
    </div>
    <div class="stat-card__summary">
        <span class="stat-card__summary-icon">
            <i class="{{ config('other.font-awesome') }} fa-weight-hanging"></i>
        </span>
        <div class="stat-card__summary-text">
            <span class="stat-card__summary-label">{{ __('stat.total-torrents') }} {{ __('torrent.size') }}</span>
            <span class="stat-card__summary-value">{{ App\Helpers\StringHelper::formatBytes($torrent_size, 2) }}</span>
        </div>
    </div>
</section>

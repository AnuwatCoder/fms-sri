@props(['application', 'favoriteKey' => null])

<article
    class="system-card system-card--{{ $application['color'] }} h-100"
    data-system-card
    data-search="{{ Str::lower($application['name_th'].' '.$application['name_en'].' '.$application['description'].' '.$application['category'].' '.$application->access_label) }}"
>
    <div class="d-flex align-items-start gap-3">
        <div class="system-card__icon flex-shrink-0" aria-hidden="true">
            <i class="bi {{ $application['icon'] }}"></i>
        </div>
        <div class="min-w-0 flex-grow-1">
            <div class="d-flex align-items-start justify-content-between gap-2">
                <h3 class="system-card__title mb-0">{{ $application['name_th'] }}</h3>
                <button
                    type="button"
                    class="favorite-button{{ $application['favorite'] ? ' is-favorite' : '' }}"
                    aria-label="{{ $application['favorite'] ? 'นำออกจากรายการโปรด' : 'เพิ่มในรายการโปรด' }}: {{ $application['name_th'] }}"
                    aria-pressed="{{ $application['favorite'] ? 'true' : 'false' }}"
                    @if ($favoriteKey !== null) wire:click="toggleFavorite({{ $favoriteKey }})" wire:loading.attr="disabled" @endif
                >
                    <i class="bi {{ $application['favorite'] ? 'bi-star-fill' : 'bi-star' }}" aria-hidden="true"></i>
                </button>
            </div>
            <p class="system-card__title-en mb-0">{{ $application['name_en'] }}</p>
        </div>
    </div>
    <span class="system-card__access system-card__access--{{ $application->access_type }}"><i class="bi {{ $application->access_icon }}" aria-hidden="true"></i>{{ $application->access_label }}</span>
    <p class="system-card__description">{{ $application['description'] }}</p>
    <a class="system-card__action" href="{{ $application['url'] ?: '#' }}" aria-label="เข้าใช้งาน {{ $application['name_th'] }}">
        เข้าใช้งาน <i class="bi bi-arrow-right" aria-hidden="true"></i>
    </a>
</article>

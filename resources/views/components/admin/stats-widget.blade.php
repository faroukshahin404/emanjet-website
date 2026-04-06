@props([
    'title',
    'value',
    'icon',
    'color' => 'primary',
    'today' => null,
])

<div class="card border-0 shadow-sm admin-stats-card admin-stats-card--compact overflow-hidden">
    <div class="card-body py-2 px-3 d-flex align-items-center gap-2 gap-md-3 position-relative">
        <div
            class="admin-stats-icon-compact bg-label-{{ $color }} rounded-2 d-flex align-items-center justify-content-center flex-shrink-0">
            <i class="bi {{ $icon }}"></i>
        </div>
        <div class="min-w-0 flex-grow-1">
            <div class="d-flex align-items-baseline flex-wrap gap-2">
                <span class="admin-stats-value-compact text-{{ $color }} fw-bold lh-1">{{ $value }}</span>
                @if ($today !== null && (int) $today > 0)
                    <span class="badge rounded-pill admin-stats-chip-success admin-stats-chip--xs">
                        +{{ $today }} <i class="bi bi-arrow-up-short"></i>
                    </span>
                @elseif($today !== null && (int) $today < 0)
                    <span class="badge rounded-pill admin-stats-chip-danger admin-stats-chip--xs">
                        {{ $today }} <i class="bi bi-arrow-down-short"></i>
                    </span>
                @endif
            </div>
            <p class="admin-stats-title-compact text-muted mb-0 mt-1 text-truncate">{{ $title }}</p>
        </div>
    </div>
</div>

@once
    @push('styles')
        <style>
            .admin-stats-card {
                background: var(--bs-body-bg, #fff);
                transition: box-shadow 0.2s ease;
            }

            .admin-stats-card--compact {
                border: 1px solid var(--bs-border-color-translucent, rgba(0, 0, 0, 0.06)) !important;
            }

            .admin-stats-card--compact:hover {
                box-shadow: 0 0.25rem 0.75rem rgba(67, 89, 113, 0.08) !important;
            }

            /* Dark theme (disabled)
            [data-theme="dark"] .admin-stats-card {
                background: var(--bg-surface, #1e293b);
            }
            */

            .admin-stats-icon-compact {
                width: 2.25rem;
                height: 2.25rem;
            }

            .admin-stats-icon-compact i {
                font-size: 1rem;
            }

            .admin-stats-value-compact {
                font-family: 'Space Grotesk', 'Cairo', sans-serif;
                font-size: 1.125rem;
                letter-spacing: -0.02em;
            }

            @media (min-width: 768px) {
                .admin-stats-value-compact {
                    font-size: 1.25rem;
                }
            }

            .admin-stats-title-compact {
                font-size: 0.7rem;
                font-weight: 600;
                line-height: 1.2;
            }

            .admin-stats-chip-success {
                background: rgba(113, 221, 55, 0.15) !important;
                color: #71dd37 !important;
                font-weight: 700;
            }

            .admin-stats-chip-danger {
                background: rgba(255, 62, 29, 0.12) !important;
                color: #ff3e1d !important;
                font-weight: 700;
            }

            .admin-stats-chip--xs {
                font-size: 0.65rem;
                padding: 0.15em 0.45em;
            }
        </style>
    @endpush
@endonce

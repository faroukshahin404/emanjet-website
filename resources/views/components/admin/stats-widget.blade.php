@props([
    'title',
    'value',
    'icon',
    'color' => 'primary',
    'today' => null,
])

<div class="card h-100 border-0 shadow-sm admin-stats-card overflow-hidden position-relative">
    <div class="card-body p-4 d-flex flex-column justify-content-between position-relative z-1">
        <div class="admin-stats-glass bg-{{ $color }} opacity-10 position-absolute rounded-circle"
            style="width: 156px; height: 156px; top: -78px; right: -78px;"></div>

        <div class="d-flex align-items-start justify-content-between mb-3">
            <div>
                @if ($today !== null && (int) $today > 0)
                    <span class="badge rounded-pill admin-stats-chip-success">
                        +{{ $today }} <i class="bi bi-arrow-up-short"></i>
                    </span>
                @elseif($today !== null && (int) $today < 0)
                    <span class="badge rounded-pill admin-stats-chip-danger">
                        {{ $today }} <i class="bi bi-arrow-down-short"></i>
                    </span>
                @endif
            </div>
            <div
                class="rounded-circle shadow-sm bg-label-{{ $color }} d-flex align-items-center justify-content-center admin-stats-icon-box">
                <i class="bi {{ $icon }} fs-3"></i>
            </div>
        </div>

        <div class="mt-2">
            <h3 class="fw-bold mb-1 text-{{ $color }} admin-stats-value">{{ $value }}</h3>
            <p class="text-muted fw-semibold mb-0 small text-uppercase letter-spacing-1">{{ $title }}</p>
        </div>
    </div>
</div>

@once
    @push('styles')
        <style>
            .admin-stats-card {
                background: var(--bs-body-bg, #fff);
                transition: transform 0.25s ease, box-shadow 0.25s ease;
            }

            .admin-stats-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 0.75rem 2rem rgba(67, 89, 113, 0.12) !important;
            }

            [data-theme="dark"] .admin-stats-card {
                background: var(--bg-surface, #1e293b);
            }

            .admin-stats-icon-box {
                width: 3.25rem;
                height: 3.25rem;
            }

            .admin-stats-value {
                font-family: 'Space Grotesk', 'Cairo', sans-serif;
                letter-spacing: -0.03em;
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
        </style>
    @endpush
@endonce

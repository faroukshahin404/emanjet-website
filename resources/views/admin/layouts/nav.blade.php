<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme container-xxl navbar-detached"
    id="layout-navbar">

    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
        <a id="sidebar-toggle" class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)" role="button"
            aria-controls="layout-menu" aria-expanded="true">
            <i class="icon-base bi bi-list fs-4"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center flex-grow-1" id="navbar-collapse">
        <div class="flex-grow-1"></div>

        <ul class="navbar-nav align-items-center gap-2 flex-row">
            <li class="nav-item navbar-dropdown dropdown-language dropdown">
                <a class="nav-link dropdown-toggle hide-arrow px-3 py-1 rounded-pill border d-flex align-items-center gap-2"
                    href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-translate"></i>
                    <span class="d-none d-md-inline fw-semibold" style="font-size: 0.75rem;">
                        {{ getCurrentLocale() === 'en' ? __('English') : __('Arabic') }}
                    </span>
                    <i class="bi bi-chevron-down d-none d-md-inline" style="font-size: 0.625rem;"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 {{ getCurrentLocale() === 'ar' ? 'active' : '' }}"
                            href="{{ url('lang/ar') }}">
                            <span>{{ __('Arabic') }}</span>
                            @if (getCurrentLocale() === 'ar')
                                <i class="bi bi-check-lg ms-auto text-primary"></i>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 {{ getCurrentLocale() === 'en' ? 'active' : '' }}"
                            href="{{ url('lang/en') }}">
                            <span>{{ __('English') }}</span>
                            @if (getCurrentLocale() === 'en')
                                <i class="bi bi-check-lg ms-auto text-primary"></i>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Dark / light theme toggle (disabled)
            <li class="nav-item">
                <button type="button" onclick="togglePlanxTheme()"
                    class="nav-link border rounded-circle d-flex align-items-center justify-content-center theme-toggle-btn"
                    style="width:38px;height:38px;padding:0;background:transparent;" title="{{ __('Toggle Theme') }}"
                    aria-label="Toggle dark mode">
                    <i class="bi bi-moon-stars-fill icon-dark-mode"></i>
                    <i class="bi bi-sun-fill icon-light-mode"></i>
                </button>
            </li>
            --}}

            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center gap-2 px-2"
                    href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="user-avatar shadow-sm">
                        {{ strtoupper(substr(optional(auth('admin')->user())->name ?? 'A', 0, 1)) }}
                    </div>
                    <span class="d-none d-sm-inline fw-semibold"
                        style="font-size:0.875rem;">{{ auth('admin')->user()->name ?? 'Admin' }}</span>
                    <i class="bi bi-chevron-down d-none d-sm-inline" style="font-size:0.625rem;"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                    <li class="px-3 py-2">
                        <p class="mb-0 fw-bold" style="font-size:0.9rem;">{{ auth('admin')->user()->name ?? 'Admin' }}
                        </p>
                        <p class="mb-0 text-muted" style="font-size:0.8rem;">
                            {{ auth('admin')->user()->email ?? '' }}</p>
                    </li>
                    <li>
                        <hr class="dropdown-divider my-1">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.profile.edit') }}">
                            <i class="bi bi-person-gear"></i>
                            <span>{{ __('Profile') }}</span>
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>{{ __('Logout') }}</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

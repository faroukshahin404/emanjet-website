<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard.index') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <span class="text-primary">
                    <img src="{{ dashboard_logo('sidebar') }}" alt="{{ dashboard_project_name() }}"
                        class="d-inline-block" style="max-height: 40px; width: auto; height: auto;">
                </span>
            </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bi bi-chevron-left align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('Main') }}</span>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bi bi-grid-1x2-fill"></i>
                <div class="text-truncate">{{ __('Dashboard') }}</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <a href="{{ route('admin.settings.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bi bi-gear-fill"></i>
                <div class="text-truncate">{{ __('Settings') }}</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.translations.*') ? 'active' : '' }}">
            <a href="{{ route('admin.translations.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bi bi-translate"></i>
                <div class="text-truncate">{{ __('Translation Tools') }}</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('Content Management') }}</span>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
            <a href="{{ route('admin.pages.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bi bi-file-text"></i>
                <div class="text-truncate">{{ __('Pages') }}</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
            <a href="{{ route('admin.faqs.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bi bi-question-circle-fill"></i>
                <div class="text-truncate">{{ __('FAQs') }}</div>
            </a>
        </li>
        <li
            class="menu-item {{ request()->routeIs('admin.blogs.*', 'admin.blog-categories.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bi bi-journal-text"></i>
                <div class="text-truncate">{{ __('Blog') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.blog-categories.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.blog-categories.index') }}" class="menu-link">
                        <div class="text-truncate">{{ __('Categories') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.blogs.index') }}" class="menu-link">
                        <div class="text-truncate">{{ __('Posts') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('Logistics & Fleet') }}</span>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.cities.*') ? 'active' : '' }}">
            <a href="{{ route('admin.cities.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bi bi-geo-alt-fill"></i>
                <div class="text-truncate">{{ __('Cities') }}</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.stations.*') ? 'active' : '' }}">
            <a href="{{ route('admin.stations.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bi bi-pin-map-fill"></i>
                <div class="text-truncate">{{ __('Stations') }}</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.bus-categories.*') ? 'active' : '' }}">
            <a href="{{ route('admin.bus-categories.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bi bi-bus-front-fill"></i>
                <div class="text-truncate">{{ __('Bus Categories') }}</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.destinations.*') ? 'active' : '' }}">
            <a href="{{ route('admin.destinations.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bi bi-signpost-split-fill"></i>
                <div class="text-truncate">{{ __('Destinations') }}</div>
            </a>
        </li>
    </ul>
</aside>

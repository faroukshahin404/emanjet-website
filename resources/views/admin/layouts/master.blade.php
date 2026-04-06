<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ getDirection() }}" data-theme="light">

<head>
    @include('admin.layouts.head')
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('admin.layouts.sidebar')

            <div class="layout-page">
                @include('admin.layouts.nav')

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('breadcrumb')
                        @yield('content')
                    </div>
                    @include('admin.layouts.footer')
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    @include('admin.layouts.scripts')

    <script>
        (function() {
            var savedTheme = localStorage.getItem('planx-theme') || @json(dashboard_setting('theme.default', 'light'));
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();

        function togglePlanxTheme() {
            var current = document.documentElement.getAttribute('data-theme') || 'light';
            var next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('planx-theme', next);
            window.dispatchEvent(new CustomEvent('themeChanged', {
                detail: {
                    theme: next
                }
            }));
        }
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

@include('layouts.head')

<body
    style="direction: {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
    @php
        $viewportLocalePrefixes = array_keys(config('laravellocalization.supportedLocales', []));
    @endphp
    {{-- Run before rest of body parses: fast web↔mobile trip redirects; matchMedia fires on breakpoint cross only --}}
    <script>
        (function() {
            var DESKTOP_MQL = window.matchMedia('(min-width: 992px)');
            var localePrefixes = @json($viewportLocalePrefixes);

            function pathNorm(pathname) {
                return (pathname || '/').replace(/\/+$/, '') || '/';
            }

            function hasDesktopEquivalent(rest) {
                return /^\/one-way\/trips(\/|$)/.test(rest) ||
                    /^\/one-way\/choose-seat(\/|$)/.test(rest) ||
                    /^\/round\/trips(\/|$)/.test(rest) ||
                    /^\/round\/back-trips(\/|$)/.test(rest) ||
                    /^\/round\/choose-seat(\/|$)/.test(rest);
            }

            function mobilePathToDesktop(pathname) {
                var p = pathNorm(pathname);
                var key = '/mobile/';
                var i = p.indexOf(key);
                if (i === -1) {
                    return null;
                }
                var rest = p.slice(i + key.length - 1);
                if (!rest.startsWith('/')) {
                    rest = '/' + rest;
                }
                if (!hasDesktopEquivalent(rest)) {
                    return null;
                }
                rest = rest.replace(/^\/round\/back-trips(\/|$)/, '/round/trips$1');
                var prefix = p.slice(0, i).replace(/\/+$/, '') || '';
                return prefix + rest;
            }

            function isTripDesktopSegment(parts, startIdx) {
                var a = parts[startIdx];
                var b = parts[startIdx + 1];
                if (!a || !b) {
                    return false;
                }
                if (a === 'one-way' && (b === 'trips' || b === 'choose-seat')) {
                    return true;
                }
                if (a === 'round' && (b === 'trips' || b === 'choose-seat')) {
                    return true;
                }
                return false;
            }

            function desktopPathToMobile(pathname) {
                var p = pathNorm(pathname);
                if (p.indexOf('/mobile/') !== -1) {
                    return null;
                }
                var parts = p.split('/').filter(Boolean);
                var i = 0;
                if (parts.length && localePrefixes.indexOf(parts[0]) !== -1) {
                    i = 1;
                }
                if (!isTripDesktopSegment(parts, i)) {
                    return null;
                }
                var next = parts.slice();
                next.splice(i, 0, 'mobile');
                return '/' + next.join('/');
            }

            function applyViewportRouting() {
                if (document.body && document.body.dataset.skipMobileDesktopRedirect === '1') {
                    return;
                }
                var path = window.location.pathname;
                var qs = window.location.search + window.location.hash;
                var pathKey = pathNorm(path);
                if (DESKTOP_MQL.matches) {
                    var toDesk = mobilePathToDesktop(path);
                    if (toDesk && pathNorm(toDesk) !== pathKey) {
                        window.location.replace(toDesk + qs);
                    }
                } else {
                    var toMob = desktopPathToMobile(path);
                    if (toMob && pathNorm(toMob) !== pathKey) {
                        window.location.replace(toMob + qs);
                    }
                }
            }

            function prefetchMobileTwinIfDesktop() {
                if (!document.head || !DESKTOP_MQL.matches) {
                    return;
                }
                if (document.body && document.body.dataset.skipMobileDesktopRedirect === '1') {
                    return;
                }
                var toMob = desktopPathToMobile(window.location.pathname);
                if (!toMob) {
                    return;
                }
                if (document.querySelector('link[rel="prefetch"][data-viewport-mobile-twin="1"]')) {
                    return;
                }
                var l = document.createElement('link');
                l.rel = 'prefetch';
                l.href = toMob + window.location.search;
                l.setAttribute('data-viewport-mobile-twin', '1');
                document.head.appendChild(l);
            }

            if (typeof DESKTOP_MQL.addEventListener === 'function') {
                DESKTOP_MQL.addEventListener('change', applyViewportRouting);
            } else {
                DESKTOP_MQL.addListener(applyViewportRouting);
            }
            applyViewportRouting();
            prefetchMobileTwinIfDesktop();
        })();
    </script>
    <div id="site-loader">
        <div class="spinner"></div>
    </div>
    <!-- Desktop View -->
    <div class="desktop d-lg-block d-none">
        @include('layouts.header')
        @yield('content')
        <div id="footer">
            @include('layouts.footer')
        </div>
    </div>

    <div class="mobile d-lg-none d-block">
        <nav class="mobile-header navbar navbar-light bg-white border-bottom sticky-top shadow-sm py-2">
            <div class="container-fluid d-flex justify-content-center">
                <a class="navbar-brand p-0 m-0" href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Super Jet') }}" style="height: 35px; width: auto;">
                </a>
            </div>
        </nav>

        <div class="container mo-view mb-5 mt-3 px-4">
            <div class="row">
                @yield('mobile-content')
            </div>
        </div>
        @include('mobile.layouts.footer')
    </div>

    @include('includes.mobile-sidebar')
    @yield('includes')

    <script>
        window.addEventListener('load', () => {
            const loader = document.getElementById('site-loader');
            if (loader) {
                loader.classList.add('hidden');
            }
        });
    </script>

    <!-- Scripts -->
    {{-- Swiper before @stack: page scripts expect Swiper global after DOMContentLoaded --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- Bootstrap bundle includes Popper; separate popper script removed as redundant --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-swal-init />
    @stack('scripts')
    <script src="{{ asset('js/main.js') }}" defer></script>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showAlert('success', @json(session('success')), @json(__('Success')));
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showAlert('error', @json(session('error')), @json(__('Error')));
            });
        </script>
    @endif
    @if (session('warning'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showAlert('warning', @json(session('warning')), @json(__('Warning')));
            });
        </script>
    @endif
    @if (session('info'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showAlert('info', @json(session('info')), @json(__('Info')));
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showAlert('error', @json($errors->first()), @json(__('Error')));
            });
        </script>
    @endif

    @include('includes.logout-modal')

</body>

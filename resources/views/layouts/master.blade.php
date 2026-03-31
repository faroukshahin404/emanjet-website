<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

@include('layouts.head')

<body
    style="direction: {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
    <div id="site-loader">
        <div class="spinner"></div>
    </div>
    <div class="custom-toastr-container"></div>

    <!-- Desktop View -->
    <div class="desktop d-lg-block d-none">
        @include('layouts.header')
        @yield('content')
        <div id="footer">
            @include('layouts.footer')
        </div>
    </div>

    <!-- Mobile View -->
    <div class="mobile d-lg-none d-block">
        <div class="container mo-view mb-5 mt-3 px-4">
            <div class="row">
                @yield('mobile-content')
            </div>
        </div>
        @include('mobile.layouts.footer')
    </div>
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
    @stack('scripts')
    <script src="{{ asset('js/main.js') }}" defer></script>
    <script src="{{ asset('js/custom-toastr.js') }}"></script>
    @if (session('success'))
        <script>
            showToast('success', @json(session('success')));
        </script>
    @endif
    @if (session('error'))
        <script>
            showToast('error', @json(session('error')));
        </script>
    @endif
    @if ($errors->any())
        <script>
            showToast('error', @json($errors->first()));
        </script>
    @endif

    @include('includes.logout-modal')
</body>

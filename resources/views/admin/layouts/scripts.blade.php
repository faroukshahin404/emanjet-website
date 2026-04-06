<script src="{{ asset('vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('vendor/js/menu.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/feather-icons"></script>

<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/dashboards-analytics.js') }}"></script>

<script>
    window.showAlert = function(type, message, title) {
        title = title || '';
        const icons = {
            'success': 'success',
            'error': 'error',
            'warning': 'warning',
            'info': 'info'
        };
        Swal.fire({
            title: title || (type.charAt(0).toUpperCase() + type.slice(1)),
            text: message,
            icon: icons[type] || 'info',
            confirmButtonText: "{{ __('OK') }}",
            customClass: {
                confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false
        });
    };

    document.addEventListener('DOMContentLoaded', function() {
        var layoutMenu = document.getElementById('layout-menu');
        if (layoutMenu && layoutMenu.menuInstance && typeof layoutMenu.menuInstance.update === 'function') {
            layoutMenu.addEventListener('click', function(e) {
                if (!e.target.closest('.menu-toggle')) {
                    return;
                }
                var inst = layoutMenu.menuInstance;
                requestAnimationFrame(function() {
                    inst.update();
                });
                setTimeout(function() {
                    inst.update();
                }, 200);
            });
        }

        @if (session('success'))
            showAlert('success', @json(session('success')), @json(__('Success')));
        @endif
        @if (session('error'))
            showAlert('error', @json(session('error')), @json(__('Error')));
        @endif
        @if (session('warning'))
            showAlert('warning', @json(session('warning')), @json(__('Warning')));
        @endif
        @if (session('info'))
            showAlert('info', @json(session('info')), @json(__('Info')));
        @endif

        if (window.feather) {
            feather.replace();
        }
    });
</script>

@stack('scripts')
@stack('js')

<style>
    .swal2-container {
        z-index: 9999 !important;
    }
</style>

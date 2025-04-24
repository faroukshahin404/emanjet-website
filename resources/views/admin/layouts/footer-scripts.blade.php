<script src="{{ asset('assets/js/vendors.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/chat-popup.js') }}"></script>
<script src="{{ asset('assets/icons/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/c3/d3.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/c3/c3.min.js') }}"></script>

<!-- CrmX Admin App -->
<script src="{{ asset('assets/js/jquery.smartmenus.js') }}"></script>
<script src="{{ asset('assets/js/menus.js') }}"></script>
<script src="{{ asset('assets/js/template.js') }}"></script>


<script src="{{ asset('assets/js/pages/c3-axis.js') }}"></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/pages/data-table.js') }}"></script>
{{-- <script src="{{ asset('assets/vendor_components/datatable/datatables.min.js')}}"></script> --}}

<script>
   function showConfirmationAlert(event, message, callback) {
    if (event) event.preventDefault();
    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'نعم',
        cancelButtonText: 'لا',
    }).then((result) => {
        if (result.isConfirmed) {
            callback(); // استدعاء الـ callback إذا تم التأكيد
        }
    });
}

    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000",
    };

    function showToast(message, type) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            closeOnClickOutside: false,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon: type,
            title: message
        });
    }

    @if (session('success'))
        showToast("{{ session('success') }}", "success");
    @endif
    @if (session('error'))
        showToast("{{ session('error') }}", "error");
    @endif
    @if (session('warning'))
        showToast("{{ session('warning') }}", "warning");
    @endif
    @if (session('info'))
        showToast("{{ session('info') }}", "info");
    @endif
</script>


@yield('js')
@stack('scripts')

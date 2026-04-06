@once('sweetalert2-zindex')
    <style>
        .swal2-container {
            z-index: 200000 !important;
        }
    </style>
@endonce
@once('sweetalert2-init-inline')
    <script>
        (function() {
            'use strict';

            var confirmOk = @json(__('OK'));
            var deleteYes = @json(__('Yes'));
            var cancelTxt = @json(__('Cancel'));

            window.showAlert = function(type, message, title) {
                if (typeof Swal === 'undefined') {
                    window.alert(message != null ? String(message) : '');
                    return Promise.resolve();
                }
                type = type || 'info';
                var icons = {
                    success: 'success',
                    error: 'error',
                    warning: 'warning',
                    info: 'info'
                };
                var t = type;
                var defaultTitle = t ? t.charAt(0).toUpperCase() + t.slice(1) : 'Info';
                return Swal.fire({
                    title: title || defaultTitle,
                    text: message != null ? String(message) : '',
                    icon: icons[t] || 'info',
                    confirmButtonText: confirmOk,
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
            };

            window.showToast = function(type, message, title) {
                return window.showAlert(type, message, title);
            };

            /**
             * Use on delete forms: onsubmit="return confirmDelete(this, @json(__('...')))"
             */
            window.confirmDelete = function(form, message) {
                if (typeof Swal === 'undefined') {
                    return window.confirm(message);
                }
                Swal.fire({
                    title: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: deleteYes,
                    cancelButtonText: cancelTxt,
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-outline-secondary ms-2'
                    },
                    reverseButtons: document.documentElement.getAttribute('dir') === 'rtl'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
                return false;
            };
        })();
    </script>
@endonce

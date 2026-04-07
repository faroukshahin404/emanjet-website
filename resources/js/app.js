import './bootstrap';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

// Optional Toastr defaults
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "3000",
};

// Expose on window if you need global access
window.toastr = toastr;

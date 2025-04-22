import './bootstrap';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

// تهيئة Toastr (اختياري)
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "3000",
};

// اجعله متاحًا globally إذا أردت
window.toastr = toastr;

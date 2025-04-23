document.addEventListener('DOMContentLoaded', () => {
    if (!document.querySelector('.custom-toastr-container')) {
        const container = document.createElement('div');
        container.className = 'custom-toastr-container';
        document.body.appendChild(container);
    }
});

function showToast(type, message, duration = 5000) {
    const container = document.querySelector('.custom-toastr-container');

    const toast = document.createElement('div');
    toast.className = `custom-toast ${type}`;

    // محتوى التوست
    toast.innerHTML = `
        <span class="custom-toast-message">${message}</span>
        <button class="custom-toast-close">&times;</button>
        <div class="custom-toast-timer"></div>
    `;

    container.appendChild(toast);

    // تحريك التايمر
    const timer = toast.querySelector('.custom-toast-timer');
    timer.style.animation = `timerLine ${duration}ms linear forwards`;

    // إزالة التوست بعد المدة
    const timeout = setTimeout(() => {
        toast.remove();
    }, duration);

    // زر الإغلاق
    toast.querySelector('.custom-toast-close').addEventListener('click', () => {
        clearTimeout(timeout);
        toast.remove();
    });
}

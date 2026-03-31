document.addEventListener('DOMContentLoaded', () => {
    if (!document.querySelector('.custom-toastr-container')) {
        const container = document.createElement('div');
        container.className = 'custom-toastr-container';
        document.body.appendChild(container);
    }
});

function showToast(type, message, duration = 5000) {
    const container = document.querySelector('.custom-toastr-container');
    if (!container) {
        return;
    }

    const toast = document.createElement('div');
    toast.className = `custom-toast ${type}`;

    const messageSpan = document.createElement('span');
    messageSpan.className = 'custom-toast-message';
    messageSpan.textContent = message;

    const closeBtn = document.createElement('button');
    closeBtn.type = 'button';
    closeBtn.className = 'custom-toast-close';
    closeBtn.setAttribute('aria-label', 'Close');
    closeBtn.innerHTML = '&times;';

    const timer = document.createElement('div');
    timer.className = 'custom-toast-timer';

    toast.appendChild(messageSpan);
    toast.appendChild(closeBtn);
    toast.appendChild(timer);

    container.appendChild(toast);

    const timerEl = toast.querySelector('.custom-toast-timer');
    timerEl.style.animation = `timerLine ${duration}ms linear forwards`;

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

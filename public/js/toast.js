// script.js

const icons = {
    success: '<i class="fas fa-check-circle"></i>',
    danger: '<i class="fas fa-exclamation-circle"></i>',
    warning: '<i class="fas fa-exclamation-triangle"></i>',
    info: '<i class="fas fa-info-circle"></i>',
};

function showToast(message, type = 'info') {
    // Validate type
    if (!icons[type]) {
        type = 'info';
    }

    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <div class="toast-icon">${icons[type]}</div>
        <div class="toast-message">${message}</div>
    `;

    // Add toast to container
    const container = document.getElementById('toast-container');
    container.appendChild(toast);

    // Show toast
    setTimeout(() => {
        toast.classList.add('show');
    }, 100); // Small delay to ensure toast is added to the DOM

    // Hide and remove toast after 5 seconds
    setTimeout(() => {
        toast.classList.add('hide');
        setTimeout(() => {
            toast.remove();
        }, 500); // Match the hide transition duration
    }, 5000); // Display duration
}
<div id="alert-container" class="fixed bottom-5 right-5 z-50 space-y-3 pointer-events-none">
</div>

<script>
    function showAlert(type = 'info', message = '') {
        const container = document.getElementById('alert-container');
        if (!container) return;

        const alert = document.createElement('div');

        const typeClass = {
            info: 'alert-info',
            success: 'alert-success',
            warning: 'alert-warning',
            error: 'alert-error',
        };

        alert.className = `
            alert alert-soft ${typeClass[type] ?? 'alert-info'}
            shadow-lg w-80 pointer-events-auto
            animate-slide-in
        `;

        alert.innerHTML = `
            <span>${message}</span>
        `;

        container.appendChild(alert);

        // auto remove after 3 seconds
        setTimeout(() => {
            alert.classList.add('animate-slide-out');
            setTimeout(() => alert.remove(), 300);
        }, 3000);
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-alert-message]').forEach(el => {
            el.addEventListener('click', () => {
                showAlert(
                    el.dataset.alertType || 'info',
                    el.dataset.alertMessage
                );
            });
        });
    });
</script>

<style>
    @keyframes slide-in {
        from {
            opacity: 0;
            transform: translateX(30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slide-out {
        from {
            opacity: 1;
            transform: translateX(0);
        }

        to {
            opacity: 0;
            transform: translateX(30px);
        }
    }

    .animate-slide-in {
        animation: slide-in 0.3s ease-out;
    }

    .animate-slide-out {
        animation: slide-out 0.3s ease-in;
    }
</style>

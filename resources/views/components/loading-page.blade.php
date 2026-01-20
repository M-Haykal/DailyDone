{{-- Global Page Loading --}}
<div id="page-loading" class="fixed inset-0 z-[9999] flex items-center justify-center bg-base-100/40 backdrop-blur-sm">
    <span class="loading loading-spinner loading-xl text-primary"></span>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loader = document.getElementById('page-loading');

        const showLoading = () => {
            loader.classList.remove('hidden');
            loader.classList.add('flex');
        };

        const hideLoading = () => {
            loader.classList.add('hidden');
            loader.classList.remove('flex');
        };

        document.querySelectorAll('a[href]').forEach(link => {
            link.addEventListener('click', () => {
                const href = link.getAttribute('href');

                if (
                    !href ||
                    href.startsWith('#') ||
                    href.startsWith('javascript') ||
                    link.target === '_blank' ||
                    link.hasAttribute('data-no-loading')
                ) return;

                showLoading();
            });
        });

        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', () => {
                showLoading();
            });
        });

        window.addEventListener('load', () => {
            hideLoading();
        });
    });
</script>

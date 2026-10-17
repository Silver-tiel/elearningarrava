{{-- Global Page Progress & Transition Bar (YouTube / GitHub style) --}}
<div id="global-page-loader" class="fixed top-0 left-0 h-[3px] w-0 opacity-0 pointer-events-none z-[999999] transition-all duration-300 ease-out"
     style="background: linear-gradient(90deg, #4f46e5, #06b6d4, #10b981); box-shadow: 0 0 10px rgba(79, 70, 229, 0.7), 0 0 5px rgba(6, 182, 212, 0.5);">
</div>

<script>
    (function () {
        const loader = document.getElementById('global-page-loader');
        if (!loader) return;

        let progress = 0;
        let timer = null;

        function setProgress(val) {
            progress = Math.min(val, 95);
            loader.style.opacity = '1';
            loader.style.width = progress + '%';
        }

        function startLoader() {
            if (timer) clearInterval(timer);
            progress = 15;
            loader.style.transition = 'width 0.2s ease-out, opacity 0.2s ease';
            loader.style.opacity = '1';
            loader.style.width = progress + '%';

            timer = setInterval(() => {
                if (progress < 60) {
                    progress += Math.floor(Math.random() * 15) + 5;
                } else if (progress < 85) {
                    progress += Math.floor(Math.random() * 5) + 2;
                }
                loader.style.width = progress + '%';
            }, 250);
        }

        function completeLoader() {
            if (timer) clearInterval(timer);
            loader.style.width = '100%';
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.width = '0%';
                }, 300);
            }, 150);
        }

        // Global API
        window.PageLoader = {
            start: startLoader,
            done: completeLoader,
            set: setProgress
        };

        // Listen for internal link clicks
        document.addEventListener('click', function (e) {
            const link = e.target.closest('a');
            if (!link) return;

            // Abaikan jika modifier keys ditekan (buka tab baru)
            if (e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;

            const href = link.getAttribute('href');
            if (!href) return;

            // Abaikan hash, javascript, mailto, tel, atau target _blank
            if (href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
            if (link.target && link.target !== '_self') return;
            if (link.hasAttribute('download')) return;

            // Pastikan URL satu domain
            try {
                const targetUrl = new URL(link.href, window.location.href);
                if (targetUrl.origin === window.location.origin && targetUrl.href !== window.location.href) {
                    startLoader();
                }
            } catch (err) {
                // Abaikan jika URL tidak valid
            }
        });

        // Listen for standard form submits (kecuali yang di-prevent)
        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (!form) return;
            if (form.target && form.target !== '_self') return;
            if (e.defaultPrevented) return;
            
            startLoader();
        });

        // Reset jika halaman dibuka dari bfcache (tombol back/forward browser)
        window.addEventListener('pageshow', function (e) {
            completeLoader();
        });
    })();
</script>

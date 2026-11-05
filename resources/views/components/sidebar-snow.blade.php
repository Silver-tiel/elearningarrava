        <div class="relative overflow-hidden h-52 sm:h-56 cursor-pointer select-none group bg-transparent transition-transform duration-150 active:scale-[0.98]"
             id="sidebarSnowWidget"
             role="button"
             tabindex="0"
             title="Klik untuk memutar animasi salju"
             aria-label="Animasi Salju Sidebar">

            <!-- 1. Gambar Diam / Normal (WEBP) - Skala diperbesar 110% agar melebihi batas sidebar namun tetap terpotong rapih -->
            <img id="sidebarSnowStatic"
                 src="{{ asset('assets/background/sidebar/sideSnow.webp') }}"
                 alt="Pemandangan Salju Sidebar"
                 class="sidebar-snow-pixel-img absolute inset-0 h-full w-full object-cover object-bottom scale-110 transition-opacity duration-200">

            <!-- 2. Animasi Bergerak (GIF) - Berputar 1 kali saat diklik -->
            <img id="sidebarSnowAnim"
                 src="{{ asset('assets/background/sidebar/sideSnow.gif') }}"
                 data-src="{{ asset('assets/background/sidebar/sideSnow.gif') }}"
                 alt="Animasi Salju Sidebar Bergerak"
                 class="sidebar-snow-pixel-img absolute inset-0 h-full w-full object-cover object-bottom scale-110 opacity-0 pointer-events-none transition-opacity duration-200">
        </div>

<script>
(function () {
        function initSidebarSnowInteraction() {
            var widget = document.getElementById('sidebarSnowWidget');
            var staticImg = document.getElementById('sidebarSnowStatic');
            var animImg = document.getElementById('sidebarSnowAnim');

            if (!widget || !staticImg || !animImg) return;

            var SOUND_FILE = "{{ asset('assets/sounds/widgets/jingleSnowSound.wav') }}";
            var currentAudio = null;
            var stopTimer = null;

            function stopAnimation() {
                if (stopTimer) {
                    clearTimeout(stopTimer);
                    stopTimer = null;
                }
                animImg.classList.remove('opacity-100');
                animImg.classList.add('opacity-0');
                staticImg.classList.remove('opacity-0');
            }

            function playOnce() {
                // Hentikan audio sebelumnya jika ada yang sedang berbunyi agar sinkron dari awal
                if (currentAudio) {
                    try {
                        currentAudio.pause();
                        currentAudio.currentTime = 0;
                    } catch (e) {}
                }
                if (stopTimer) {
                    clearTimeout(stopTimer);
                    stopTimer = null;
                }

                // Mulai animasi GIF dari frame pertama (refresh timestamp)
                var baseSrc = animImg.getAttribute('data-src') || animImg.src;
                var cleanSrc = baseSrc.split('?')[0];
                animImg.src = cleanSrc + '?t=' + Date.now();

                // Tampilkan GIF, sembunyikan gambar diam
                staticImg.classList.add('opacity-0');
                animImg.classList.remove('opacity-0');
                animImg.classList.add('opacity-100');

                // Putar suara lonceng jingle (jingleSnowSound.wav)
                try {
                    var audio = new Audio(SOUND_FILE);
                    audio.volume = 0.85;
                    currentAudio = audio;

                    audio.onended = function() {
                        stopAnimation();
                    };

                    audio.onerror = function() {
                        stopTimer = setTimeout(stopAnimation, 3000);
                    };

                    var playPromise = audio.play();
                    if (playPromise !== undefined) {
                        playPromise.catch(function() {
                            stopTimer = setTimeout(stopAnimation, 3000);
                        });
                    }
                } catch (e) {
                    stopTimer = setTimeout(stopAnimation, 3000);
                }

                // Fallback batas waktu maksimal 7 detik sesuai durasi file WAV ~6.2 detik
                stopTimer = setTimeout(stopAnimation, 7000);
            }

            widget.addEventListener('click', function() {
                playOnce();
            });

            widget.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    playOnce();
                }
            });
        }

    initSidebarSnowInteraction();
})();
</script>

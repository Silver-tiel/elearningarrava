{{--
    Komponen Pengaturan Suara Header (Reusable)
    Penggunaan: @include('components.sound-settings')
    Menyediakan tombol ikon suara di kanan atas header dan popover pengaturan
    volume serta on/off efek suara (SFX) yang tersimpan di localStorage.
--}}
<div class="relative" id="soundSettingsContainer">
    {{-- Tombol Utama di Header --}}
    <button type="button"
            id="soundSettingsTrigger"
            class="group flex h-9 sm:h-10 items-center gap-2 rounded-xl border border-slate-200 bg-white px-2.5 sm:px-3 text-slate-600 shadow-sm transition hover:border-blue-300 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-100"
            title="Pengaturan Suara"
            aria-label="Buka Pengaturan Suara"
            aria-haspopup="true"
            aria-expanded="false">
        <span id="soundIconWrapper" class="flex items-center justify-center transition group-hover:scale-105">
            {{-- Icon Volume Tinggi (>= 50%) --}}
            <svg id="soundIconHigh" class="h-4 sm:h-5 w-4 sm:w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
            </svg>
            {{-- Icon Volume Rendah (> 0% & < 50%) --}}
            <svg id="soundIconLow" class="h-4 sm:h-5 w-4 sm:w-5 text-blue-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
            </svg>
            {{-- Icon Senyap / Muted --}}
            <svg id="soundIconMuted" class="h-4 sm:h-5 w-4 sm:w-5 text-rose-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15zM17 14l4-4m0 4l-4-4"/>
            </svg>
        </span>
        <span id="soundVolumeLabel" class="hidden md:inline-block text-xs font-semibold text-slate-700">75%</span>
        <span id="soundStatusDot" class="h-2 w-2 rounded-full bg-emerald-500 transition shadow-sm" title="Suara Aktif"></span>
    </button>

    {{-- Dropdown Panel Pengaturan Suara --}}
    <div id="soundDropdownPanel"
         class="absolute right-0 top-full mt-2 w-72 sm:w-80 rounded-2xl border border-slate-200/90 bg-white p-4 shadow-xl z-50 transform origin-top-right transition-all duration-150 scale-95 opacity-0 pointer-events-none"
         role="dialog"
         aria-label="Panel Pengaturan Suara">

        {{-- Header Panel --}}
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                    </svg>
                </span>
                <span class="text-sm font-bold text-slate-800">Pengaturan Suara</span>
            </div>
            <button type="button"
                    id="soundCloseBtn"
                    class="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition"
                    aria-label="Tutup Panel">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Switch On / Off SFX --}}
        <div class="flex items-center justify-between py-3 border-b border-slate-100">
            <div>
                <p class="text-xs font-semibold text-slate-700">Efek Suara Interaktif</p>
                <p class="text-[11px] text-slate-400">Efek suara klik, tombol, dan kuis</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer select-none">
                <input type="checkbox" id="soundToggleCheckbox" class="sr-only peer" checked>
                <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
        </div>

        {{-- Slider Volume --}}
        <div class="py-3">
            <div class="flex items-center justify-between mb-1.5">
                <span class="text-xs font-semibold text-slate-700">Tingkat Volume</span>
                <span id="sliderPercentText" class="text-xs font-bold text-blue-600">75%</span>
            </div>
            <div class="flex items-center gap-2.5">
                <button type="button"
                        id="soundQuickMuteBtn"
                        class="text-slate-400 hover:text-slate-600 transition"
                        title="Senyap / Mute">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                    </svg>
                </button>
                <input type="range"
                       id="soundVolumeRange"
                       min="0"
                       max="100"
                       value="75"
                       class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-blue-600 focus:outline-none">
                <button type="button"
                        id="soundQuickMaxBtn"
                        class="text-slate-400 hover:text-slate-600 transition"
                        title="Volume Maksimal">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                    </svg>
                </button>
            </div>

            {{-- Tombol Preset Cepat --}}
            <div class="grid grid-cols-3 gap-1.5 mt-2.5">
                <button type="button"
                        data-preset="0"
                        class="sound-preset-btn py-1 px-1.5 rounded-lg border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-[10.5px] font-medium text-slate-600 transition text-center">
                    Senyap (0%)
                </button>
                <button type="button"
                        data-preset="50"
                        class="sound-preset-btn py-1 px-1.5 rounded-lg border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-[10.5px] font-medium text-slate-600 transition text-center">
                    Sedang (50%)
                </button>
                <button type="button"
                        data-preset="100"
                        class="sound-preset-btn py-1 px-1.5 rounded-lg border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-[10.5px] font-medium text-slate-600 transition text-center">
                    Penuh (100%)
                </button>
            </div>
        </div>

        {{-- Tombol Tes Suara --}}
        <div class="pt-2 border-t border-slate-100">
            <button type="button"
                    id="soundTestBtn"
                    class="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold transition active:scale-[0.98]">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Uji Efek Suara (Tes)</span>
            </button>
        </div>
    </div>
</div>

<script>
    (function () {
        function initSoundSettings() {
            const container = document.getElementById('soundSettingsContainer');
            if (!container || container.dataset.initialized) return;
            container.dataset.initialized = 'true';

            const trigger = document.getElementById('soundSettingsTrigger');
            const panel = document.getElementById('soundDropdownPanel');
            const closeBtn = document.getElementById('soundCloseBtn');
            const toggleCheckbox = document.getElementById('soundToggleCheckbox');
            const volumeRange = document.getElementById('soundVolumeRange');
            const sliderPercentText = document.getElementById('sliderPercentText');
            const volumeLabel = document.getElementById('soundVolumeLabel');
            const statusDot = document.getElementById('soundStatusDot');
            const testBtn = document.getElementById('soundTestBtn');
            const quickMuteBtn = document.getElementById('soundQuickMuteBtn');
            const quickMaxBtn = document.getElementById('soundQuickMaxBtn');
            const presetBtns = container.querySelectorAll('.sound-preset-btn');

            const iconHigh = document.getElementById('soundIconHigh');
            const iconLow = document.getElementById('soundIconLow');
            const iconMuted = document.getElementById('soundIconMuted');

            let isOpen = false;

            // Baca nilai awal dari localStorage
            let isMuted = false;
            let currentVolume = 0.75;

            try {
                if (localStorage.getItem('arrava_sound_muted') === 'true') {
                    isMuted = true;
                }
                const savedVol = localStorage.getItem('arrava_sound_volume');
                if (savedVol !== null && !isNaN(parseFloat(savedVol))) {
                    currentVolume = Math.max(0, Math.min(1, parseFloat(savedVol)));
                }
            } catch (e) {}

            function syncUi(muted, vol) {
                const percent = Math.round(vol * 100);

                if (volumeRange) volumeRange.value = percent;
                if (sliderPercentText) sliderPercentText.textContent = percent + '%';
                if (volumeLabel) volumeLabel.textContent = muted ? 'Senyap' : percent + '%';
                if (toggleCheckbox) toggleCheckbox.checked = !muted;

                // Status Dot
                if (statusDot) {
                    if (muted || vol === 0) {
                        statusDot.className = 'h-2 w-2 rounded-full bg-slate-400 transition shadow-sm';
                        statusDot.title = 'Suara Senyap (Muted)';
                    } else {
                        statusDot.className = 'h-2 w-2 rounded-full bg-emerald-500 transition shadow-sm';
                        statusDot.title = 'Suara Aktif (' + percent + '%)';
                    }
                }

                // Update Icon
                if (iconHigh && iconLow && iconMuted) {
                    if (muted || vol === 0) {
                        iconHigh.classList.add('hidden');
                        iconLow.classList.add('hidden');
                        iconMuted.classList.remove('hidden');
                    } else if (vol < 0.5) {
                        iconHigh.classList.add('hidden');
                        iconLow.classList.remove('hidden');
                        iconMuted.classList.add('hidden');
                    } else {
                        iconHigh.classList.remove('hidden');
                        iconLow.classList.add('hidden');
                        iconMuted.classList.add('hidden');
                    }
                }
            }

            syncUi(isMuted, currentVolume);

            // Buka / Tutup Dropdown Panel
            function openPanel() {
                isOpen = true;
                panel.classList.remove('scale-95', 'opacity-0', 'pointer-events-none');
                panel.classList.add('scale-100', 'opacity-100', 'pointer-events-auto');
                trigger.setAttribute('aria-expanded', 'true');
            }

            function closePanel() {
                isOpen = false;
                panel.classList.remove('scale-100', 'opacity-100', 'pointer-events-auto');
                panel.classList.add('scale-95', 'opacity-0', 'pointer-events-none');
                trigger.setAttribute('aria-expanded', 'false');
            }

            trigger.addEventListener('click', function (e) {
                e.stopPropagation();
                if (isOpen) {
                    closePanel();
                } else {
                    openPanel();
                }
            });

            if (closeBtn) {
                closeBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    closePanel();
                });
            }

            panel.addEventListener('click', function (e) {
                e.stopPropagation();
            });

            document.addEventListener('click', function (e) {
                if (isOpen && !container.contains(e.target)) {
                    closePanel();
                }
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && isOpen) {
                    closePanel();
                }
            });

            // Toggle Mute / Unmute
            toggleCheckbox.addEventListener('change', function () {
                const muted = !this.checked;
                isMuted = muted;
                if (window.ArravaHoverSound) {
                    window.ArravaHoverSound.mute(muted);
                } else {
                    try { localStorage.setItem('arrava_sound_muted', muted); } catch (e) {}
                }
                syncUi(isMuted, currentVolume);
            });

            // Volume Range Slider
            volumeRange.addEventListener('input', function () {
                const val = parseInt(this.value, 10) / 100;
                currentVolume = val;

                // Jika user menggeser volume di atas 0 saat sedang mute, otomatis un-mute
                if (isMuted && val > 0) {
                    isMuted = false;
                    if (window.ArravaHoverSound) window.ArravaHoverSound.mute(false);
                    try { localStorage.setItem('arrava_sound_muted', 'false'); } catch (e) {}
                }

                if (window.ArravaHoverSound) {
                    window.ArravaHoverSound.setVolume(val);
                } else {
                    try { localStorage.setItem('arrava_sound_volume', val); } catch (e) {}
                }
                syncUi(isMuted, currentVolume);
            });

            // Preset Buttons
            presetBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    const preset = parseInt(this.dataset.preset, 10);
                    const val = preset / 100;
                    currentVolume = val;

                    if (preset === 0) {
                        isMuted = true;
                        if (window.ArravaHoverSound) window.ArravaHoverSound.mute(true);
                    } else {
                        isMuted = false;
                        if (window.ArravaHoverSound) {
                            window.ArravaHoverSound.mute(false);
                            window.ArravaHoverSound.setVolume(val);
                            window.ArravaHoverSound.playMenuClick(0, 0.8);
                        }
                    }
                    syncUi(isMuted, currentVolume);
                });
            });

            if (quickMuteBtn) {
                quickMuteBtn.addEventListener('click', function () {
                    isMuted = true;
                    if (window.ArravaHoverSound) window.ArravaHoverSound.mute(true);
                    syncUi(isMuted, currentVolume);
                });
            }

            if (quickMaxBtn) {
                quickMaxBtn.addEventListener('click', function () {
                    isMuted = false;
                    currentVolume = 1.0;
                    if (window.ArravaHoverSound) {
                        window.ArravaHoverSound.mute(false);
                        window.ArravaHoverSound.setVolume(1.0);
                        window.ArravaHoverSound.playMenuClick(0, 0.8);
                    }
                    syncUi(isMuted, currentVolume);
                });
            }

            // Tes Suara
            if (testBtn) {
                testBtn.addEventListener('click', function () {
                    // Jika saat ini di-mute, otomatis aktifkan suara terlebih dahulu
                    if (isMuted) {
                        isMuted = false;
                        if (window.ArravaHoverSound) window.ArravaHoverSound.mute(false);
                        syncUi(isMuted, currentVolume);
                    }

                    if (window.ArravaHoverSound) {
                        window.ArravaHoverSound.playQuizChime(3, 0.9);
                    }
                });
            }

            // Tangkap event update global jika diubah dari tempat lain
            window.addEventListener('arrava-sound-updated', function (e) {
                if (e.detail) {
                    isMuted = e.detail.isMuted;
                    currentVolume = e.detail.volume;
                    syncUi(isMuted, currentVolume);
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSoundSettings);
        } else {
            initSoundSettings();
        }
    })();
</script>


{{--
    Komponen Modal Konfirmasi Logout (Reusable)
    Gunakan: @include('components.logout-modal') atau <x-logout-modal />
    Syarat  : Ada <form id="logoutForm"> di halaman yang sama (hidden).
--}}

{{-- Hidden logout form --}}
<form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>

{{-- Modal Overlay --}}
<div id="logoutModal"
     class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
     style="display:none !important;">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
         onclick="closeLogoutModal()"></div>

    {{-- Panel --}}
    <div id="logoutPanel"
         class="relative w-full max-w-sm rounded-2xl bg-white shadow-2xl overflow-hidden
                transform transition-all duration-200 scale-95 opacity-0">

        {{-- Accent bar --}}
        <div class="h-1.5 w-full bg-gradient-to-r from-red-400 to-rose-500"></div>

        <div class="px-6 py-6">
            {{-- Icon --}}
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-red-50 mb-4">
                <svg class="h-7 w-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </div>

            {{-- Teks --}}
            <h3 class="text-center text-lg font-bold text-slate-800">Konfirmasi Keluar</h3>
            <p class="mt-2 text-center text-sm text-slate-500">
                Apakah kamu yakin ingin keluar dari akun ini?<br>
                Sesi kamu akan diakhiri.
            </p>

            {{-- Tombol --}}
            <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:gap-3">
                <button type="button" onclick="closeLogoutModal()"
                        class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2.5
                               text-sm font-semibold text-slate-600 hover:bg-slate-50
                               transition focus:outline-none focus:ring-2 focus:ring-slate-300">
                    Batal
                </button>
                <button type="button" onclick="document.getElementById('logoutForm').submit()"
                        class="flex-1 rounded-xl bg-red-500 px-4 py-2.5
                               text-sm font-semibold text-white hover:bg-red-600
                               transition focus:outline-none focus:ring-2 focus:ring-red-300">
                    Ya, Keluar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var _modal = null, _panel = null;

    function getEls() {
        if (!_modal) _modal = document.getElementById('logoutModal');
        if (!_panel) _panel = document.getElementById('logoutPanel');
    }

    window.openLogoutModal = function () {
        getEls();
        if (!_modal) return;
        _modal.style.removeProperty('display');
        requestAnimationFrame(function () {
            _panel.classList.remove('scale-95', 'opacity-0');
            _panel.classList.add('scale-100', 'opacity-100');
        });
        document.body.style.overflow = 'hidden';
    };

    window.closeLogoutModal = function () {
        getEls();
        if (!_modal) return;
        _panel.classList.remove('scale-100', 'opacity-100');
        _panel.classList.add('scale-95', 'opacity-0');
        setTimeout(function () {
            _modal.style.display = 'none';
            document.body.style.overflow = '';
        }, 180);
    };

    // Bind trigger button jika ada
    document.addEventListener('DOMContentLoaded', function () {
        var trigger = document.getElementById('logoutTrigger');
        if (trigger) trigger.addEventListener('click', window.openLogoutModal);

        // Tutup dengan Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') window.closeLogoutModal();
        });
    });
})();
</script>

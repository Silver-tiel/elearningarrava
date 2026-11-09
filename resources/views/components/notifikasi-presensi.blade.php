@props([
    'notifikasi' => [],
    'userId' => auth()->id() ?? 0,
    'role' => 'siswa',
])

@php
    $totalNotif = count($notifikasi);
@endphp

<!-- ================= WIDGET NOTIFIKASI PRESENSI ARRAVA ================= -->
<div class="relative inline-block text-left" id="notifikasiPresensiRoot" data-user-id="{{ $userId }}">
    <!-- Tombol Lonceng Notifikasi di Header -->
    <button type="button" 
            id="notifBellButton" 
            class="relative flex h-10 w-10 items-center justify-center rounded-2xl border border-[#DCEFFF] bg-[#F0F6FF] text-[#007FBE] shadow-[0_2px_0_#B2E7FC] hover:bg-white hover:border-[#007FBE] active:translate-y-0.5 active:shadow-none transition"
            aria-label="Notifikasi Presensi"
            aria-expanded="false"
            title="Notifikasi Presensi">
        <svg class="h-5 w-5 transition-transform duration-200 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>

        <!-- Badge Counter Unread (Akan dihitung dinamis via JS, disembunyikan jika unread = 0) -->
        <span id="notifBadgeCounter" 
              class="hidden absolute -top-1 -right-1 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-rose-500 px-1 text-[11px] font-bold text-white shadow-xs ring-2 ring-white animate-pulse">
            0
        </span>
    </button>

    <!-- Dropdown Panel Notifikasi -->
    <div id="notifDropdownPanel" 
         class="hidden absolute right-0 mt-2 w-80 sm:w-96 rounded-[22px] border border-[#DCEFFF] bg-white shadow-[0_8px_24px_rgba(0,127,190,0.12)] z-50 overflow-hidden transition-all duration-200 origin-top-right transform opacity-0 scale-95">
        
        <!-- Header Panel -->
        <div class="flex items-center justify-between border-b border-[#DCEFFF] bg-[#F0F6FF]/80 px-4 py-3">
            <div class="flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </span>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Notifikasi Presensi</h3>
                    <p class="text-[11px] text-slate-500" id="notifSubheading">Pemberitahuan presensi kelas</p>
                </div>
            </div>
            <button type="button" 
                    id="notifClearAllBtn"
                    class="text-[11px] font-semibold text-blue-600 hover:text-blue-800 transition hover:underline">
                Tandai semua dibaca
            </button>
        </div>

        <!-- Daftar Notifikasi -->
        <div id="notifItemsContainer" class="max-h-[380px] overflow-y-auto divide-y divide-slate-100 p-1">
            @forelse($notifikasi as $item)
                @php
                    $isDanger = ($item['tipe'] ?? '') === 'danger';
                    $bgIcon = $isDanger ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-blue-50 text-blue-600 border border-blue-100';
                @endphp
                <div class="notif-item group relative flex items-start gap-3 p-3 rounded-xl transition duration-150 cursor-pointer border-l-4"
                     data-notif-id="{{ $item['id'] }}"
                     data-action-url="{{ $item['action_url'] ?? '' }}">
                    
                    <!-- Icon Status -->
                    <div class="shrink-0 mt-0.5 flex h-9 w-9 items-center justify-center rounded-xl {{ $bgIcon }}">
                        @if($isDanger)
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        @else
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        @endif
                    </div>

                    <!-- Teks Notifikasi -->
                    <div class="flex-1 min-w-0 pr-2">
                        <div class="flex items-center justify-between gap-1.5 mb-1">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $item['badge_color'] }}">
                                    {{ $item['badge'] }}
                                </span>
                                <span class="text-[10px] text-slate-400 font-medium">{{ $item['waktu'] }}</span>
                            </div>
                            <!-- Status Dibaca / Belum Dibaca -->
                            <span class="notif-read-badge text-[10px] font-medium"></span>
                        </div>
                        <h4 class="notif-title text-xs font-bold text-slate-800 leading-tight group-hover:text-blue-600 transition">
                            {{ $item['judul'] }}
                        </h4>
                        <p class="text-[11px] text-slate-600 mt-1 leading-snug">
                            {{ $item['pesan'] }}
                        </p>
                        @if(!empty($item['action_label']))
                            <div class="mt-2 flex items-center gap-1 text-[11px] font-semibold text-blue-600 group-hover:underline">
                                <span>{{ $item['action_label'] }}</span>
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
            @endforelse
        </div>

        <!-- Empty State (Ketika tidak ada notifikasi sama sekali dari server) -->
        <div id="notifEmptyState" class="hidden p-6 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 mb-3">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h4 class="text-sm font-bold text-slate-800">Semua Presensi Selesai!</h4>
            <p class="text-xs text-slate-500 mt-1 max-w-[220px] mx-auto">
                Tidak ada notifikasi presensi untuk saat ini.
            </p>
        </div>
    </div>
</div>

<!-- ================= REALTIME ENGINE & PERSISTENCE SCRIPT ================= -->
<script>
(function() {
    const root = document.getElementById('notifikasiPresensiRoot');
    if (!root) return;

    const userId = root.getAttribute('data-user-id') || '0';
    const storageKey = `arrava_read_notif_${userId}`;
    const bellBtn = document.getElementById('notifBellButton');
    const panel = document.getElementById('notifDropdownPanel');
    const badge = document.getElementById('notifBadgeCounter');
    const container = document.getElementById('notifItemsContainer');
    const emptyState = document.getElementById('notifEmptyState');
    const clearAllBtn = document.getElementById('notifClearAllBtn');
    const subheading = document.getElementById('notifSubheading');

    const INITIAL_NOTIFS = @json($notifikasi);

    // Ambil list ID notifikasi yang sudah DIBACA oleh user dari localStorage
    function getReadIds() {
        try {
            return JSON.parse(localStorage.getItem(storageKey) || '[]');
        } catch(e) {
            return [];
        }
    }

    // Simpan list ID notifikasi yang sudah dibaca ke localStorage
    function saveReadIds(ids) {
        try {
            localStorage.setItem(storageKey, JSON.stringify(ids));
        } catch(e) {}
    }

    // Hitung status Unread dan perbarui visual tiap item notifikasi (NOTIFIKASI TETAP ADA, HANYA EFFECT BELUM DIBACA YANG HILANG)
    function applyNotifState() {
        const readIds = getReadIds();
        const items = container ? container.querySelectorAll('.notif-item') : [];
        let totalCount = items.length;
        let unreadCount = 0;
        const unreadItemsData = [];

        items.forEach(item => {
            const notifId = item.getAttribute('data-notif-id');
            const isRead = readIds.includes(notifId);
            const statusBadge = item.querySelector('.notif-read-badge');
            const titleEl = item.querySelector('.notif-title');

            if (isRead) {
                // Style NOTIFIKASI SUDAH DIBACA:
                // Tetap muncul di daftar, tetapi efek 'belum dibaca' dihilangkan
                item.classList.remove('bg-blue-50/70', 'border-blue-500', 'shadow-xs');
                item.classList.add('bg-white', 'border-transparent', 'hover:bg-slate-50/80');
                if (statusBadge) {
                    statusBadge.innerHTML = `<span class="inline-flex items-center text-slate-400 font-medium">✓ Dibaca</span>`;
                }
                if (titleEl) {
                    titleEl.classList.remove('text-blue-700');
                    titleEl.classList.add('text-slate-700');
                }
            } else {
                // Style NOTIFIKASI BELUM DIBACA:
                // Memiliki aksen khusus & indikator 'Baru'
                item.classList.add('bg-blue-50/70', 'border-blue-500', 'shadow-xs');
                item.classList.remove('bg-white', 'border-transparent');
                if (statusBadge) {
                    statusBadge.innerHTML = `<span class="inline-flex items-center gap-1 font-bold text-blue-600 bg-blue-100/90 px-1.5 py-0.5 rounded-full"><span class="h-1.5 w-1.5 rounded-full bg-blue-600 animate-ping"></span>Baru</span>`;
                }
                if (titleEl) {
                    titleEl.classList.add('text-blue-700');
                    titleEl.classList.remove('text-slate-700');
                }
                unreadCount++;

                // Kumpulkan data notifikasi yang belum dibaca untuk Niere
                const judul = titleEl ? titleEl.textContent.trim() : '';
                const pesan = item.querySelector('p') ? item.querySelector('p').textContent.trim() : '';
                unreadItemsData.push({ id: notifId, judul, pesan });
            }
        });

        // Update Badge Counter pada Lonceng Header
        if (unreadCount > 0) {
            badge.textContent = unreadCount > 9 ? '9+' : unreadCount;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }

        // Update Subheading
        if (subheading) {
            if (unreadCount > 0) {
                subheading.textContent = `${unreadCount} pemberitahuan belum dibaca`;
            } else if (totalCount > 0) {
                subheading.textContent = `Semua ${totalCount} pemberitahuan sudah dibaca`;
            } else {
                subheading.textContent = `Tidak ada notifikasi presensi`;
            }
        }

        // Tampilan Empty State jika memang tidak ada data sama sekali dari server
        if (totalCount === 0) {
            if (emptyState) emptyState.classList.remove('hidden');
            if (clearAllBtn) clearAllBtn.classList.add('hidden');
        } else {
            if (emptyState) emptyState.classList.add('hidden');
            if (clearAllBtn) {
                clearAllBtn.classList.remove('hidden');
                clearAllBtn.textContent = unreadCount > 0 ? 'Tandai semua dibaca' : 'Semua sudah dibaca ✓';
                clearAllBtn.disabled = unreadCount === 0;
                clearAllBtn.style.opacity = unreadCount === 0 ? '0.6' : '1';
            }
        }

        // Simpan data ke window agar Niere bisa langsung mengakses informasi unread & pesan
        window.arravaNotifData = {
            totalCount,
            unreadCount,
            unreadItems: unreadItemsData,
            readIds
        };

        // Kirim event global ke Niere & komponen lain
        window.dispatchEvent(new CustomEvent('arrava:notif-update', {
            detail: window.arravaNotifData
        }));
    }

    // Inisialisasi awal saat dimuat
    applyNotifState();

    // Fungsi Global untuk membuka dropdown notifikasi header (bisa dipanggil dari Niere)
    window.openHeaderNotifDropdown = function() {
        if (!panel) return;
        panel.classList.remove('hidden');
        requestAnimationFrame(() => {
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
        if (bellBtn) bellBtn.setAttribute('aria-expanded', 'true');
    };

    window.closeHeaderNotifDropdown = function() {
        if (!panel) return;
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            panel.classList.add('hidden');
        }, 150);
        if (bellBtn) bellBtn.setAttribute('aria-expanded', 'false');
    };

    // Toggle Dropdown saat tombol lonceng diklik
    if (bellBtn && panel) {
        bellBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const isOpen = !panel.classList.contains('hidden');
            if (isOpen) {
                window.closeHeaderNotifDropdown();
            } else {
                window.openHeaderNotifDropdown();
            }
        });
    }

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function(e) {
        if (!root.contains(e.target)) {
            if (panel && !panel.classList.contains('hidden')) {
                window.closeHeaderNotifDropdown();
            }
        }
    });

    // Tandai satu notifikasi sebagai DIBACA saat item diklik (Item TETAP ADA, efek unread hilang)
    if (container) {
        container.addEventListener('click', function(e) {
            const item = e.target.closest('.notif-item');
            if (!item) return;

            const notifId = item.getAttribute('data-notif-id');
            const actionUrl = item.getAttribute('data-action-url');

            // Tambahkan ke read list jika belum
            const readIds = getReadIds();
            if (!readIds.includes(notifId)) {
                readIds.push(notifId);
                saveReadIds(readIds);
                applyNotifState();

                // Sync ke backend secara asynchronous
                try {
                    fetch('{{ route("notifikasi.mark_read") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ id: notifId })
                    }).catch(() => {});
                } catch(e) {}
            }

            // Jika item memiliki action URL dan diklik, beri sedikit feedback visual lalu navigasikan
            if (actionUrl) {
                setTimeout(() => {
                    window.location.href = actionUrl;
                }, 150);
            }
        });
    }

    // Fungsi Global untuk menandai SEMUA notifikasi sebagai DIBACA (Dipanggil dari tombol header maupun Niere)
    window.markAllNotifAsRead = function() {
        const items = container ? container.querySelectorAll('.notif-item') : [];
        const readIds = getReadIds();

        items.forEach(item => {
            const id = item.getAttribute('data-notif-id');
            if (id && !readIds.includes(id)) {
                readIds.push(id);
            }
        });

        saveReadIds(readIds);
        applyNotifState();

        // Sync ke backend
        try {
            fetch('{{ route("notifikasi.mark_read") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ all: true })
            }).catch(() => {});
        } catch(e) {}
    };

    // Tandai SEMUA notifikasi sebagai DIBACA saat tombol di panel diklik
    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            window.markAllNotifAsRead();
        });
    }

    // ================= REALTIME ENGINE: SINKRONISASI OTOMATIS TANPA REFRESH =================
    // Mendukung Laravel Reverb / WebSockets jika aktif, dan didukung smart background sync
    function handleIncomingNotifications(newNotifList) {
        if (!Array.isArray(newNotifList) || !container) return;

        let hasNewArrival = false;
        const currentItemIds = Array.from(container.querySelectorAll('.notif-item'))
            .map(el => el.getAttribute('data-notif-id'));

        newNotifList.forEach(item => {
            if (!currentItemIds.includes(item.id)) {
                hasNewArrival = true;
                const isDanger = item.tipe === 'danger';
                const bgIcon = isDanger ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-blue-50 text-blue-600 border border-blue-100';
                const iconSvg = isDanger
                    ? `<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`
                    : `<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>`;

                const itemDiv = document.createElement('div');
                itemDiv.className = 'notif-item group relative flex items-start gap-3 p-3 rounded-xl transition duration-150 cursor-pointer border-l-4 opacity-0 transform -translate-y-2';
                itemDiv.setAttribute('data-notif-id', item.id);
                itemDiv.setAttribute('data-action-url', item.action_url || '');

                itemDiv.innerHTML = `
                    <div class="shrink-0 mt-0.5 flex h-9 w-9 items-center justify-center rounded-xl ${bgIcon}">
                        ${iconSvg}
                    </div>
                    <div class="flex-1 min-w-0 pr-2">
                        <div class="flex items-center justify-between gap-1.5 mb-1">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border ${item.badge_color || ''}">
                                    ${item.badge || ''}
                                </span>
                                <span class="text-[10px] text-slate-400 font-medium">${item.waktu || ''}</span>
                            </div>
                            <span class="notif-read-badge text-[10px] font-medium"></span>
                        </div>
                        <h4 class="notif-title text-xs font-bold text-slate-800 leading-tight group-hover:text-blue-600 transition">
                            ${item.judul || ''}
                        </h4>
                        <p class="text-[11px] text-slate-600 mt-1 leading-snug">
                            ${item.pesan || ''}
                        </p>
                        ${item.action_label ? `
                            <div class="mt-2 flex items-center gap-1 text-[11px] font-semibold text-blue-600 group-hover:underline">
                                <span>${item.action_label}</span>
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        ` : ''}
                    </div>
                `;

                // Sisipkan di paling atas daftar notifikasi
                container.prepend(itemDiv);

                // Animasi halus muncul
                requestAnimationFrame(() => {
                    itemDiv.style.transition = 'all 0.3s ease';
                    itemDiv.classList.remove('opacity-0', '-translate-y-2');
                });

                // Kirim event khusus notifikasi baru tiba secara realtime untuk Niere
                window.dispatchEvent(new CustomEvent('arrava:notif-realtime-arrival', {
                    detail: item
                }));
            }
        });

        if (hasNewArrival) {
            applyNotifState();
        }
    }

    // 1. Cek secara berkala setiap 12 detik dan saat tab browser kembali aktif
    function pollCheck() {
        fetch('{{ route("notifikasi.check") }}', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && Array.isArray(data.notifikasi)) {
                handleIncomingNotifications(data.notifikasi);
            }
        })
        .catch(() => {});
    }

    // Jalankan timer polling realtime
    const poller = setInterval(pollCheck, 12000);
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            pollCheck();
        }
    });

    // 2. Integrasi Laravel Echo (Reverb / Pusher WebSockets) jika tersedia
    if (window.Echo && userId) {
        try {
            window.Echo.private(`user.${userId}`)
                .listen('.PresensiNotificationEvent', (e) => {
                    if (e && Array.isArray(e.notifikasi)) {
                        handleIncomingNotifications(e.notifikasi);
                    }
                });
        } catch(e) {}
    }
})();
</script>

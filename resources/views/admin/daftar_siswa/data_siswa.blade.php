@extends('layouts.app')

@section('header')
<h1 class="text-lg font-bold text-gray-900">Manajemen Akun Siswa</h1>

<div class="flex items-center gap-4">
    <!-- Icon Notifikasi -->
    <button class="p-2 text-gray-400 hover:text-gray-600 rounded-lg transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
            </path>
        </svg>
    </button>
    <!-- Switch Bahasa -->
    <button class="flex items-center gap-1.5 text-xs font-semibold text-gray-600 bg-gray-50 px-2.5 py-1.5 rounded-lg border border-gray-100">
        <span>ID</span>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
</div>
@endsection

@section('content')
<div class="p-8 space-y-6">

    {{-- Judul Halaman --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Manajemen Siswa</h1>
        <p class="text-sm text-slate-500">Kelola data siswa dan ubah status akun terdaftar di platform e-learning.</p>
    </div>

    {{-- Toast Notifikasi AJAX --}}
    <div id="toast-notification" class="hidden p-4 rounded-xl text-sm flex items-center justify-between transition-all duration-300">
        <div class="flex items-center gap-3">
            <svg id="toast-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="toast-message" class="font-medium"></span>
        </div>
        <button onclick="hideToast()" class="text-xs opacity-70 hover:opacity-100">✕</button>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-medium">Total Siswa</p>
                <h3 class="text-xl font-bold text-slate-800">{{ $totalSiswa ?? 0 }}</h3>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-medium">Aktif</p>
                <h3 id="stat-aktif" class="text-xl font-bold text-slate-800">{{ $totalAktif ?? 0 }}</h3>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-medium">Nonaktif</p>
                <h3 id="stat-nonaktif" class="text-xl font-bold text-slate-800">{{ $totalNonaktif ?? 0 }}</h3>
            </div>
        </div>

        
    </div>

    {{-- Filter & Search Bar --}}
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
        <form method="GET" action="{{ route('admin.daftar_siswa') }}" class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white focus:border-transparent transition"
                    placeholder="Cari nama atau email siswa...">
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <select
                    name="kelas"
                    onchange="filterData(this)"
                    class="w-full md:w-auto bg-slate-50 border border-slate-200 text-slate-600 text-sm rounded-xl px-3.5 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="">Semua Kelas</option>
                    @foreach($listKelas ?? [] as $k)
                    <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>
                        {{ $k }}
                    </option>
                    @endforeach
                </select>

                <select
                    name="status"
                    onchange="filterData(this)"
                    class="w-full md:w-auto bg-slate-50 border border-slate-200 text-slate-600 text-sm rounded-xl px-3.5 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="">Status: Semua</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Status: Aktif</option>
                    <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Status: Nonaktif</option>
                </select>
            </div>
        </form>
    </div>

    <form id="bulk-jenjang-form" method="POST" action="{{ route('admin.siswa.jenjang.massal') }}">
        @csrf
        <input type="hidden" name="search" value="{{ request('search') }}">
        <input type="hidden" name="kelas" value="{{ request('kelas') }}">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <input id="all-filtered-input" type="hidden" name="all_filtered" value="0">

        <div class="mb-4 flex flex-col gap-4 rounded-2xl border border-blue-100 bg-blue-50/60 p-4 md:flex-row md:items-end md:justify-between">
            <div class="space-y-3">
                <div>
                    <h2 class="text-sm font-bold text-slate-800">Ubah jenjang siswa secara massal</h2>
                    <p class="mt-1 text-xs text-slate-500">
                        Pilih siswa pada halaman ini, atau terapkan ke semua {{ $filteredStudentCount }} siswa yang cocok dengan filter.
                    </p>
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-700">
                    <input id="all-filtered-checkbox" type="checkbox" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    Terapkan ke semua hasil filter ({{ $filteredStudentCount }} siswa)
                </label>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row sm:items-end">
                <label class="text-xs font-medium text-slate-600">
                    Jenjang tujuan
                    <select id="bulk-jenjang-select" name="id_jenjang" required disabled
                        class="mt-1 block w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih jenjang</option>
                        @foreach ($jenjangs as $jenjang)
                            <option value="{{ $jenjang->id_jenjang }}">{{ $jenjang->nama_tipe }}</option>
                        @endforeach
                    </select>
                </label>
                <div>
                    <p id="bulk-selection-count" class="mb-1 text-xs text-slate-500">Pilih siswa terlebih dahulu</p>
                    <button id="bulk-jenjang-submit" type="submit" disabled
                        class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50">
                    Ubah jenjang
                    </button>
                </div>
            </div>
        </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs text-slate-400 font-medium border-b border-slate-100 bg-slate-50/50">
                        <th class="py-3.5 px-4 w-12 text-center">
                            <input id="select-page-students" type="checkbox" aria-label="Pilih semua siswa di halaman ini"
                                class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Nama Siswa</th>
                        <th class="py-3.5 px-4">Email</th>
                        <th class="py-3.5 px-4">Jenjang / Kelas</th>
                        <th class="py-3.5 px-4">NISN</th>
                        <th class="py-3.5 px-4">No Hp</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4">Poin</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($siswas as $index =>$siswa)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-4 px-4 text-center">
                            <input type="checkbox" name="student_ids[]" value="{{ $siswa->id_user }}"
                                aria-label="Pilih {{ $siswa->nama }}" data-student-checkbox
                                class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="py-4 px-4 text-center text-slate-400">
                            {{ method_exists($siswas, 'firstItem') ?$siswas->firstItem() + $index :$index + 1 }}
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.siswa.profil', $siswa->id_user) }}" class="shrink-0 group">
                                    <img class="w-9 h-9 rounded-full object-cover border border-slate-100 shadow-sm group-hover:ring-2 group-hover:ring-blue-400 transition"
                                        src="{{ !empty($siswa->foto_profil) ? \Illuminate\Support\Facades\Storage::url($siswa->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama) . '&background=EFF6FF&color=2563EB' }}"
                                        alt="{{ $siswa->nama }}">
                                </a>
                                <a href="{{ route('admin.siswa.profil', $siswa->id_user) }}" class="font-semibold text-slate-800 hover:text-blue-600 transition">
                                    {{ $siswa->nama }}
                                </a>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-slate-500">{{ $siswa->email }}</td>
                        <td class="py-4 px-4 text-slate-600">
                            {{ $siswa->jenjang->nama_tipe ?? $siswa->kelas ?? 'Belum ditentukan' }}
                        </td>
                        <td class="py-4 px-4 text-slate-500">{{ $siswa->nisn ?? '-' }}</td>
                        <td class="py-4 px-4 text-slate-500">{{ $siswa->nomor_hp ?? '-' }}</td>

                        {{-- Dropdown Status Interaktif --}}
                        <td class="py-4 px-4 text-center">
                            @php
                            $status =$siswa->status_akun ?? 'Aktif';
                            $badgeClass = match($status) {
                            'Aktif' => 'bg-emerald-50 text-emerald-600 border-emerald-200 focus:ring-emerald-500',
                            'Nonaktif' => 'bg-rose-50 text-rose-600 border-rose-200 focus:ring-rose-500',
                            default => 'bg-amber-50 text-amber-600 border-amber-200 focus:ring-amber-500',
                            };
                            @endphp
                            <select
                                id="select-status-{{ $siswa->id_user }}"
                                data-current-status="{{ $status }}"
                                onchange="confirmStatusChange('{{ $siswa->id_user }}', '{{ addslashes($siswa->nama) }}', this)"
                                class="text-xs font-semibold px-2.5 py-1 rounded-full border focus:outline-none focus:ring-2 cursor-pointer transition {{ $badgeClass }}">
                                <option value="Aktif" {{ $status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Nonaktif" {{ $status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </td>

                        <td class="py-4 px-4 text-slate-500 font-semibold">{{ $siswa->total_poin ?? 0 }}</td>

                        {{-- Aksi --}}
                        <td class="py-4 px-4 text-center">
                            <a href="{{ route('admin.siswa.profil', $siswa->id_user) }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition font-semibold text-xs shadow-xs"
                                title="Lihat Profil Siswa">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <span>Profil</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="py-12 text-center text-slate-400">
                            Tidak ada data siswa ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer & Pagination --}}
        <div class="p-4 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-400">
            <div>
                @if(method_exists($siswas, 'firstItem'))
                Menampilkan {{ $siswas->firstItem() ?? 0 }}-{{ $siswas->lastItem() ?? 0 }} dari {{$siswas->total() }} siswa
                @else
                Menampilkan {{ count($siswas) }} siswa
                @endif
            </div>
            <div>
                @if(method_exists($siswas, 'links'))
                {{ $siswas->links() }}
                @endif
            </div>
        </div>
    </div>
    </form>

</div>

{{-- MODAL KONFIRMASI UBAH JENJANG MASSAL --}}
<div id="bulkJenjangModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/50 px-4 backdrop-blur-sm transition-opacity">
    <div class="w-full max-w-md space-y-4 rounded-2xl border border-slate-100 bg-white p-6 shadow-xl">
        <div class="flex items-center gap-3">
            <div class="rounded-full bg-amber-50 p-3 text-amber-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800">Konfirmasi Ubah Jenjang</h3>
                <p class="text-xs text-slate-500">Pastikan pilihan siswa dan jenjang tujuan sudah benar.</p>
            </div>
        </div>

        <p id="bulkJenjangModalDescription" class="text-sm leading-relaxed text-slate-600"></p>

        <div class="flex justify-end gap-3 pt-2">
            <button id="cancelBulkJenjang" type="button" class="rounded-xl px-4 py-2 text-xs font-semibold text-slate-600 transition hover:bg-slate-100">
                Batal
            </button>
            <button id="confirmBulkJenjang" type="button" class="rounded-xl bg-blue-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-blue-700">
                Ya, Ubah Jenjang
            </button>
        </div>
    </div>
</div>

{{-- MODAL PERINGATAN KONFIRMASI UBAH STATUS --}}
<div id="statusModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4 border border-slate-100 animate-in fade-in zoom-in duration-150">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800">Konfirmasi Perubahan Status</h3>
                <p class="text-xs text-slate-500">Tindakan ini mempengaruhi akses siswa ke sistem.</p>
            </div>
        </div>

        <p id="modalDescription" class="text-sm text-slate-600 leading-relaxed"></p>

        <div class="flex justify-end gap-3 pt-2">
            <button onclick="closeModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                Batal
            </button>
            <button id="btnConfirmSubmit" onclick="submitStatusUpdate()" class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition flex items-center gap-2">
                <span>Ya, Ubah Status</span>
            </button>
        </div>
    </div>
</div>

<script>
    let pendingData = null;

    function filterData(select) {
        const form = select.form;
        const search = form.querySelector('[name="search"]').value;
        const kelas = form.querySelector('[name="kelas"]').value;
        const status = form.querySelector('[name="status"]').value;

        if (!search && !kelas && !status) {
            window.location.href = "{{ route('admin.daftar_siswa') }}";
            return;
        }

        form.submit();
    }

    // Modal Confirmation Logic
    function confirmStatusChange(id, name, selectElement) {
        const newStatus = selectElement.value;
        const oldStatus = selectElement.getAttribute('data-current-status');

        if (newStatus === oldStatus) return;

        pendingData = {
            id: id,
            name: name,
            newStatus: newStatus,
            oldStatus: oldStatus,
            selectElement: selectElement
        };

        let message = `Apakah Anda yakin ingin mengubah status <strong>${name}</strong> dari <span class="font-semibold text-slate-700">${oldStatus}</span> menjadi <span class="font-semibold text-blue-600">${newStatus}</span>?`;

        if (newStatus === 'Nonaktif') {
            message += `<br><span class="text-xs text-rose-500 mt-2 block">⚠️ Siswa ini tidak akan bisa login ke platform e-learning selama statusnya nonaktif.</span>`;
        }

        document.getElementById('modalDescription').innerHTML = message;
        document.getElementById('statusModal').classList.remove('hidden');
    }

    function closeModal() {
        if (pendingData) {
            // Revert select back to previous status if cancelled
            pendingData.selectElement.value = pendingData.oldStatus;
            pendingData = null;
        }
        document.getElementById('statusModal').classList.add('hidden');
    }

    // Process Status Update via AJAX (Fetch API)
    function submitStatusUpdate() {
        if (!pendingData) return;

        const btn = document.getElementById('btnConfirmSubmit');
        btn.disabled = true;
        btn.innerText = 'Memproses...';

        const url = "{{ route('admin.siswa.status', ':id') }}".replace(':id', pendingData.id);

        fetch(url, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                status: pendingData.newStatus
            })
        })
    .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update dropdown state & styles
                const selectEl = pendingData.selectElement;
                selectEl.setAttribute('data-current-status', pendingData.newStatus);

                // Update badge color class
                selectEl.className = 'text-xs font-semibold px-2.5 py-1 rounded-full border focus:outline-none focus:ring-2 cursor-pointer transition ';
                if (pendingData.newStatus === 'Aktif') {
                    selectEl.classList.add('bg-emerald-50', 'text-emerald-600', 'border-emerald-200', 'focus:ring-emerald-500');
                } else if (pendingData.newStatus === 'Nonaktif') {
                    selectEl.classList.add('bg-rose-50', 'text-rose-600', 'border-rose-200', 'focus:ring-rose-500');
                } else {
                    selectEl.classList.add('bg-amber-50', 'text-amber-600', 'border-amber-200', 'focus:ring-amber-500');
                }

                showToast('success', data.message || `Status ${pendingData.name} berhasil diperbarui.`);
            } else {
                showToast('error', data.message || 'Gagal memperbarui status.');
                pendingData.selectElement.value = pendingData.oldStatus;
            }
        })
        .catch(err => {
            console.error(err);
            showToast('error', 'Terjadi kesalahan sistem.');
            pendingData.selectElement.value = pendingData.oldStatus;
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerText = 'Ya, Ubah Status';
            pendingData = null;
            document.getElementById('statusModal').classList.add('hidden');
        });
    }

    function showToast(type, message) {
        const toast = document.getElementById('toast-notification');
        const toastMessage = document.getElementById('toast-message');

        toastMessage.innerText = message;
        toast.className = 'p-4 rounded-xl text-sm flex items-center justify-between transition-all duration-300 ';

        if (type === 'success') {
            toast.classList.add('bg-emerald-50', 'border', 'border-emerald-200', 'text-emerald-700');
        } else {
            toast.classList.add('bg-rose-50', 'border', 'border-rose-200', 'text-rose-700');
        }

        toast.classList.remove('hidden');
        setTimeout(() => hideToast(), 4000);
    }

    function hideToast() {
        document.getElementById('toast-notification').classList.add('hidden');
    }

    const bulkForm = document.getElementById('bulk-jenjang-form');
    const allFilteredCheckbox = document.getElementById('all-filtered-checkbox');
    const allFilteredInput = document.getElementById('all-filtered-input');
    const bulkJenjangSelect = document.getElementById('bulk-jenjang-select');
    const bulkJenjangSubmit = document.getElementById('bulk-jenjang-submit');
    const bulkSelectionCount = document.getElementById('bulk-selection-count');
    const studentCheckboxes = Array.from(document.querySelectorAll('[data-student-checkbox]'));
    const selectPageStudents = document.getElementById('select-page-students');
    const bulkJenjangModal = document.getElementById('bulkJenjangModal');
    const bulkJenjangModalDescription = document.getElementById('bulkJenjangModalDescription');
    const confirmBulkJenjang = document.getElementById('confirmBulkJenjang');
    const cancelBulkJenjang = document.getElementById('cancelBulkJenjang');

    function updateBulkJenjangButton() {
        const hasSelection = allFilteredCheckbox.checked || studentCheckboxes.some(checkbox => checkbox.checked);
        const selectedCount = studentCheckboxes.filter(checkbox => checkbox.checked).length;
        const countLabel = allFilteredCheckbox.checked
            ? `Semua {{ $filteredStudentCount }} siswa hasil filter dipilih`
            : `${selectedCount} siswa dipilih`;

        bulkJenjangSelect.disabled = !hasSelection;
        bulkJenjangSubmit.disabled = !hasSelection || !bulkJenjangSelect.value;
        allFilteredInput.value = allFilteredCheckbox.checked ? '1' : '0';
        bulkSelectionCount.textContent = hasSelection ? countLabel : 'Pilih siswa terlebih dahulu';
    }

    studentCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            selectPageStudents.checked = studentCheckboxes.length > 0 && studentCheckboxes.every(item => item.checked);
            selectPageStudents.indeterminate = studentCheckboxes.some(item => item.checked) && !selectPageStudents.checked;
            updateBulkJenjangButton();
        });
    });

    selectPageStudents.addEventListener('change', () => {
        studentCheckboxes.forEach(checkbox => {
            checkbox.checked = selectPageStudents.checked;
        });
        updateBulkJenjangButton();
    });

    allFilteredCheckbox.addEventListener('change', updateBulkJenjangButton);
    bulkJenjangSelect.addEventListener('change', updateBulkJenjangButton);

    bulkForm.addEventListener('submit', event => {
        event.preventDefault();

        const applyToAll = allFilteredCheckbox.checked;
        const count = applyToAll
            ? {{ $filteredStudentCount }}
            : studentCheckboxes.filter(checkbox => checkbox.checked).length;
        const destination = bulkJenjangSelect.selectedOptions[0].text;
        const scope = applyToAll ? 'semua siswa yang sesuai dengan filter' : `${count} siswa terpilih`;

        bulkJenjangModalDescription.textContent = `Anda akan mengubah jenjang ${scope} menjadi ${destination}. Perubahan ini tidak dapat dibatalkan dari halaman ini.`;
        bulkJenjangModal.classList.remove('hidden');
    });

    cancelBulkJenjang.addEventListener('click', () => {
        bulkJenjangModal.classList.add('hidden');
    });

    confirmBulkJenjang.addEventListener('click', () => {
        confirmBulkJenjang.disabled = true;
        confirmBulkJenjang.textContent = 'Memproses...';
        bulkForm.submit();
    });

    @if (session('success'))
        showToast('success', @json(session('success')));
    @elseif (isset($errors) && $errors->any())
        showToast('error', @json($errors->first()));
    @endif
</script>
@endsection
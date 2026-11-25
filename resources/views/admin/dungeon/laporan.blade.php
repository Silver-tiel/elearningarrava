@extends('layouts.app')

@section('title', 'Antrean Moderasi Laporan Soal Dungeon')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 font-heading flex items-center gap-2">
                <span>🚩</span> Antrean Moderasi Laporan Soal
            </h1>
            <p class="text-slate-500 text-sm mt-1">
                Tinjau keluhan atau laporan dari siswa terkait kesalahan teks, gambar, atau kunci jawaban pada soal Dungeon.
            </p>
        </div>
        <a href="{{ route('dungeon.admin.bank') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm transition">
            ← Kembali ke Bank Soal
        </a>
    </div>

    <!-- Filter Status -->
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 mb-6 flex items-center gap-2">
        <span class="text-xs uppercase font-extrabold text-slate-400 mr-2 tracking-wider">Status:</span>
        <a href="{{ route('dungeon.admin.laporan', ['status' => 'menunggu']) }}"
           class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $statusFilter === 'menunggu' ? 'bg-amber-500 text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Menunggu Tinjauan
        </a>
        <a href="{{ route('dungeon.admin.laporan', ['status' => 'diterima']) }}"
           class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $statusFilter === 'diterima' ? 'bg-rose-600 text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Diterima (Dinonaktifkan)
        </a>
        <a href="{{ route('dungeon.admin.laporan', ['status' => 'dipulihkan']) }}"
           class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $statusFilter === 'dipulihkan' ? 'bg-emerald-600 text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Dipulihkan (Aktif)
        </a>
        <a href="{{ route('dungeon.admin.laporan', ['status' => 'ditolak']) }}"
           class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $statusFilter === 'ditolak' ? 'bg-slate-600 text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Ditolak
        </a>
        <a href="{{ route('dungeon.admin.laporan', ['status' => 'semua']) }}"
           class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $statusFilter === 'semua' ? 'bg-[#007FBE] text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Semua
        </a>
    </div>

    <!-- List Laporan -->
    <div class="space-y-4">
        @forelse($laporanList as $lap)
            @php
                $soal = $lap->soal;
                $pelapor = $lap->user;
            @endphp
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-start justify-between gap-6">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold uppercase {{ $soal->aktif ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                            {{ $soal->aktif ? 'Soal Aktif' : 'Soal Dinonaktifkan' }}
                        </span>
                        <span class="text-xs text-slate-400 font-medium">
                            Mapel: <strong>{{ $soal->quiz->mapel->nama_mapel ?? '-' }}</strong> • Jenjang: {{ $soal->quiz->jenjang->nama_tipe ?? '-' }}
                        </span>
                        <span class="text-xs text-slate-400">
                            ID Soal: #{{ $soal->id_soal }}
                        </span>
                    </div>

                    <h4 class="text-base font-bold text-slate-900 mb-2">
                        {{ $soal->pertanyaan }}
                    </h4>

                    @if($soal->foto_soal)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $soal->foto_soal) }}" alt="Foto Soal" class="max-h-40 rounded-xl border border-slate-200">
                        </div>
                    @endif

                    <!-- Kotak Alasan Siswa -->
                    <div class="p-3 rounded-xl bg-amber-50 border border-amber-200/80 text-xs text-amber-900 flex items-start gap-2">
                        <span>💬</span>
                        <div>
                            <strong>Laporan dari {{ $pelapor->nama ?? 'Siswa' }}:</strong>
                            <p class="mt-0.5 italic">"{{ $lap->alasan }}"</p>
                        </div>
                    </div>

                    @if($soal->nonaktif_alasan)
                        <div class="mt-2 text-xs text-rose-600 font-semibold">
                            Alasan Nonaktif: {{ $soal->nonaktif_alasan }}
                        </div>
                    @endif
                </div>

                <!-- Tombol Putusan -->
                <div class="flex md:flex-col gap-2 shrink-0">
                    <a href="{{ route('admin.soal.edit', $soal->id_soal) }}" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs text-center transition">
                        Edit Soal ✏️
                    </a>

                    @if($soal->aktif)
                        <button onclick="putuskanLaporan({{ $lap->id }}, 'nonaktifkan')" class="px-3 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs transition">
                            Nonaktifkan Soal 🚫
                        </button>
                    @else
                        <button onclick="putuskanLaporan({{ $lap->id }}, 'pulihkan')" class="px-3 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition">
                            Pulihkan / Aktifkan ✅
                        </button>
                    @endif

                    @if($lap->status === 'menunggu')
                        <button onclick="putuskanLaporan({{ $lap->id }}, 'tolak')" class="px-3 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs transition">
                            Tolak Laporan ❌
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl py-16 text-center text-slate-400 border border-slate-200">
                <div class="text-5xl mb-3">✨</div>
                <p class="font-bold text-lg">Tidak ada laporan soal pada kategori ini.</p>
                <p class="text-xs mt-1">Semua soal berkualitas dan berjalan lancar!</p>
            </div>
        @endforelse

        @if($laporanList->hasPages())
            <div class="p-4">
                {{ $laporanList->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    async function putuskanLaporan(id, tindakan) {
        let catatan = '';
        if (tindakan === 'nonaktifkan') {
            catatan = prompt('Catatan penonaktifan (opsional):', 'Kunci jawaban salah / soal cacat');
            if (catatan === null) return;
        }

        try {
            const res = await fetch(`/admin/dungeon/laporan/${id}/putuskan`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ tindakan, catatan })
            });
            const data = await res.json();
            if (data.success) {
                alert(data.message);
                window.location.reload();
            }
        } catch (e) {
            alert('Gagal menyimpan keputusan.');
        }
    }
</script>
@endsection

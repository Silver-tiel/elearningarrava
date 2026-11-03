@php
    $hariTerpilih = old('hari', isset($kelas) ? $kelas->hariAktif() : []);
    $hariTerpilih = array_map('intval', (array) $hariTerpilih);
    $dari = old('berlaku_dari', isset($kelas) && $kelas->berlaku_dari ? $kelas->berlaku_dari->toDateString() : '');
    $jamBatas = isset($kelas) && $kelas->jam_batas ? substr($kelas->jam_batas, 0, 5) : '';
    $sampai = old('berlaku_sampai', isset($kelas) && $kelas->berlaku_sampai ? $kelas->berlaku_sampai->toDateString() : '');
@endphp
<fieldset class="sm:col-span-4 rounded-xl border border-slate-200 p-4">
    <legend class="px-2 text-sm font-semibold text-slate-700">Jadwal &amp; masa berlaku (opsional)</legend>
    <p class="text-xs text-slate-500 mb-3">Guru hanya bisa membuat sesi presensi pada hari yang dicentang dan selama masa berlaku. Kosongkan hari = setiap hari. Kosongkan tanggal = tanpa batas.</p>
    <div class="flex flex-wrap gap-2 mb-4">
        @foreach(\App\Models\Kelas::HARI as $angka => $nama)
            <label class="inline-flex items-center gap-2 h-11 px-3 rounded-xl border border-slate-300 bg-white text-sm cursor-pointer">
                <input type="checkbox" name="hari[]" value="{{ $angka }}" @checked(in_array($angka, $hariTerpilih, true)) class="h-5 w-5 rounded border-slate-300">
                {{ $nama }}
            </label>
        @endforeach
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="berlaku_dari" class="block text-sm font-medium text-slate-700 mb-1">Berlaku dari</label>
            <input id="berlaku_dari" name="berlaku_dari" type="date" value="{{ $dari }}" class="w-full h-12 rounded-xl border border-slate-300 px-4 text-base">
        </div>
        <div>
            <label for="berlaku_sampai" class="block text-sm font-medium text-slate-700 mb-1">Berlaku sampai</label>
            <input id="berlaku_sampai" name="berlaku_sampai" type="date" value="{{ $sampai }}" class="w-full h-12 rounded-xl border border-slate-300 px-4 text-base">
        </div>
    </div>
    <div class="mt-4 sm:max-w-xs">
        <label for="jam_batas" class="block text-sm font-medium text-slate-700 mb-1">Batas tepat waktu (opsional)</label>
        <input id="jam_batas" name="jam_batas" type="time" value="{{ old('jam_batas', $jamBatas) }}" class="w-full h-12 rounded-xl border border-slate-300 px-4 text-base">
        <p class="text-xs text-slate-500 mt-1">Siswa yang dipindai setelah jam ini dicatat "terlambat".</p>
    </div>
    <p class="mt-4 text-xs text-slate-600 bg-slate-50 rounded-lg px-3 py-2">Sesi presensi dibuat <b>otomatis</b> pada setiap hari aktif kelas, mengikuti jadwal dan masa berlaku di atas. Guru tidak perlu membuatnya.</p>
</fieldset>

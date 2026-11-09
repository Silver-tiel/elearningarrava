@php
    $hariTerpilih = old('hari', isset($kelas) ? $kelas->hariAktif() : []);
    $hariTerpilih = array_map('intval', (array) $hariTerpilih);
    $dari = old('berlaku_dari', isset($kelas) && $kelas->berlaku_dari ? $kelas->berlaku_dari->toDateString() : '');
    $jamBatas = isset($kelas) && $kelas->jam_batas ? substr($kelas->jam_batas, 0, 5) : '';
    $sampai = old('berlaku_sampai', isset($kelas) && $kelas->berlaku_sampai ? $kelas->berlaku_sampai->toDateString() : '');

    $todayStr = now()->toDateString();
    // Pengaman: Pada kelas baru, tanggal masa lalu dinonaktifkan (disabled).
    // Pada edit kelas lama yang sudah berjalan, perbolehkan tanggal mulai lama tetap terbaca.
    $minDari = (isset($kelas) && $kelas->berlaku_dari && $kelas->berlaku_dari->toDateString() < $todayStr)
        ? $kelas->berlaku_dari->toDateString()
        : $todayStr;
    $minSampai = ($dari && $dari > $todayStr) ? $dari : $todayStr;
@endphp
<fieldset class="sm:col-span-4 rounded-xl border border-slate-200 p-4">
    <legend class="px-2 text-sm font-semibold text-slate-700">Jadwal &amp; masa berlaku presensi (opsional)</legend>
    <p class="text-xs text-slate-500 mb-3">Sesi presensi dibuat otomatis sesuai hari dan masa berlaku. Tanggal yang sudah lewat dinonaktifkan untuk menjaga validitas data presensi.</p>
    <div class="flex flex-wrap gap-2 mb-4">
        @foreach(\App\Models\Kelas::HARI as $angka => $nama)
            <label class="inline-flex items-center gap-2 h-11 px-3 rounded-xl border border-slate-300 bg-white text-sm cursor-pointer hover:bg-slate-50 transition">
                <input type="checkbox" name="hari[]" value="{{ $angka }}" @checked(in_array($angka, $hariTerpilih, true)) class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                <span class="font-semibold text-slate-700">{{ $nama }}</span>
            </label>
        @endforeach
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="berlaku_dari" class="block text-sm font-medium text-slate-700">Berlaku dari</label>
                <span class="text-[11px] text-blue-600 font-semibold">Min: Hari Ini ({{ now()->translatedFormat('d M Y') }})</span>
            </div>
            <input id="berlaku_dari" name="berlaku_dari" type="date" value="{{ $dari }}" min="{{ $minDari }}"
                   class="w-full h-12 rounded-xl border border-slate-300 px-4 text-base focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
            <p class="text-[11px] text-slate-400 mt-1">Tanggal mulai presensi (tanggal lampau dinonaktifkan).</p>
        </div>
        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="berlaku_sampai" class="block text-sm font-medium text-slate-700">Berlaku sampai</label>
                <span id="label-min-sampai" class="text-[11px] text-blue-600 font-semibold">Min: {{ $minSampai }}</span>
            </div>
            <input id="berlaku_sampai" name="berlaku_sampai" type="date" value="{{ $sampai }}" min="{{ $minSampai }}"
                   class="w-full h-12 rounded-xl border border-slate-300 px-4 text-base focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
            <p class="text-[11px] text-slate-400 mt-1">Tanggal akhir presensi (harus sama atau setelah tanggal mulai).</p>
        </div>
    </div>
    <div id="jadwal-date-alert" class="hidden mt-3 p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-semibold flex items-center gap-2">
        <span class="text-base">⚠️</span>
        <span id="jadwal-date-alert-text"></span>
    </div>
    <div class="mt-4 sm:max-w-xs">
        <label for="jam_batas" class="block text-sm font-medium text-slate-700 mb-1">Batas tepat waktu (opsional)</label>
        <input id="jam_batas" name="jam_batas" type="time" value="{{ old('jam_batas', $jamBatas) }}" class="w-full h-12 rounded-xl border border-slate-300 px-4 text-base focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none">
        <p class="text-xs text-slate-500 mt-1">Siswa yang dipindai setelah jam ini dicatat "terlambat".</p>
    </div>
    <p class="mt-4 text-xs text-slate-600 bg-slate-50 rounded-lg px-3 py-2">Sesi presensi dibuat <b>otomatis</b> pada setiap hari aktif kelas, mengikuti jadwal dan masa berlaku di atas. Guru tidak perlu membuatnya.</p>
</fieldset>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputDari = document.getElementById('berlaku_dari');
    const inputSampai = document.getElementById('berlaku_sampai');
    const alertBox = document.getElementById('jadwal-date-alert');
    const alertText = document.getElementById('jadwal-date-alert-text');
    const labelMinSampai = document.getElementById('label-min-sampai');
    const todayStr = '{{ $todayStr }}';
    const isEdit = {{ isset($kelas) ? 'true' : 'false' }};

    function showAlert(msg) {
        if (!alertBox || !alertText) return;
        alertText.textContent = msg;
        alertBox.classList.remove('hidden');
    }

    function hideAlert() {
        if (!alertBox) return;
        alertBox.classList.add('hidden');
    }

    function syncDateConstraints() {
        hideAlert();
        const valDari = inputDari ? inputDari.value : '';
        const valSampai = inputSampai ? inputSampai.value : '';

        // Validasi: tanggal mulai tidak boleh di masa lalu untuk kelas baru
        if (!isEdit && valDari && valDari < todayStr) {
            showAlert('Tanggal mulai berlaku tidak boleh tanggal yang sudah lewat (' + valDari + '). Otomatis disesuaikan ke hari ini.');
            inputDari.value = todayStr;
        }

        // Tentukan batas minimal tanggal sampai
        const effectiveMinSampai = valDari ? valDari : todayStr;
        if (inputSampai) {
            inputSampai.min = effectiveMinSampai;
        }
        if (labelMinSampai) {
            labelMinSampai.textContent = 'Min: ' + effectiveMinSampai;
        }

        // Batas maksimal tanggal mulai jika tanggal sampai sudah terisi
        if (inputDari && valSampai) {
            inputDari.max = valSampai;
        } else if (inputDari) {
            inputDari.removeAttribute('max');
        }

        // Validasi: tanggal sampai tidak boleh sebelum tanggal mulai
        if (valSampai && valDari && valSampai < valDari) {
            showAlert('Tanggal akhir berlaku (' + valSampai + ') tidak boleh sebelum tanggal mulai (' + valDari + '). Tanggal akhir telah direset.');
            inputSampai.value = '';
            inputSampai.focus();
        } else if (!isEdit && valSampai && valSampai < todayStr) {
            showAlert('Tanggal akhir berlaku tidak boleh tanggal yang sudah lewat.');
            inputSampai.value = '';
        }
    }

    if (inputDari) {
        inputDari.addEventListener('change', syncDateConstraints);
        inputDari.addEventListener('input', syncDateConstraints);
    }
    if (inputSampai) {
        inputSampai.addEventListener('change', syncDateConstraints);
        inputSampai.addEventListener('input', syncDateConstraints);
    }

    // Tangani validasi saat submit form
    const parentForm = inputDari ? inputDari.closest('form') : null;
    if (parentForm) {
        parentForm.addEventListener('submit', function (e) {
            const valDari = inputDari ? inputDari.value : '';
            const valSampai = inputSampai ? inputSampai.value : '';

            if (!isEdit && valDari && valDari < todayStr) {
                e.preventDefault();
                showAlert('Form tidak dapat disimpan karena tanggal mulai berlaku (' + valDari + ') sudah lewat.');
                inputDari.focus();
                return false;
            }

            if (!isEdit && valSampai && valSampai < todayStr) {
                e.preventDefault();
                showAlert('Form tidak dapat disimpan karena tanggal akhir berlaku (' + valSampai + ') sudah lewat.');
                inputSampai.focus();
                return false;
            }

            if (valDari && valSampai && valSampai < valDari) {
                e.preventDefault();
                showAlert('Form tidak dapat disimpan karena tanggal akhir berlaku mendahului tanggal mulai.');
                inputSampai.focus();
                return false;
            }
        });
    }

    syncDateConstraints();
});
</script>

import QrScanner from 'qr-scanner';

const root = document.getElementById('scan-app');

if (root) {
    const url = root.dataset.url;
    const csrf = root.dataset.csrf;
    const sesiBuka = root.dataset.buka === '1';

    const video = document.getElementById('kamera');
    const placeholder = document.getElementById('kamera-kosong');
    const btnMulai = document.getElementById('btn-mulai');
    const btnStop = document.getElementById('btn-stop');
    const hasil = document.getElementById('hasil');
    const hasilJudul = document.getElementById('hasil-judul');
    const hasilDetail = document.getElementById('hasil-detail');
    const formManual = document.getElementById('form-manual');
    const inputManual = document.getElementById('token-manual');
    const riwayat = document.getElementById('riwayat');
    const riwayatKosong = document.getElementById('riwayat-kosong');

    const GAYA = {
        hadir: { judul: '✓ Hadir', kelas: ['bg-green-50', 'border-green-500', 'text-green-900'] },
        terlambat: { judul: '⏰ Terlambat', kelas: ['bg-amber-50', 'border-amber-500', 'text-amber-900'] },
        duplikat: { judul: '↺ Sudah tercatat hadir', kelas: ['bg-blue-50', 'border-blue-500', 'text-blue-900'] },
        galat: { judul: '✕ Tidak dapat dicatat', kelas: ['bg-red-50', 'border-red-500', 'text-red-900'] },
    };
    const SEMUA_KELAS = Object.values(GAYA).flatMap((g) => g.kelas);

    const LABEL_RIWAYAT = {
        hadir: 'Hadir', terlambat: 'Terlambat', duplikat: 'Sudah tercatat',
        tidak_valid: 'QR tidak valid', bukan_anggota: 'Bukan anggota kelas',
        tidak_aktif: 'Akun nonaktif', sesi_ditutup: 'Sesi ditutup', dibatasi: 'Dibatasi',
    };

    let scanner = null;
    let sedangKirim = false;
    let tokenTerakhir = '';
    let waktuTerakhir = 0;

    function tampilkan(jenis, detail) {
        const gaya = GAYA[jenis] ?? GAYA.galat;
        hasil.classList.remove('hidden', ...SEMUA_KELAS);
        hasil.classList.add(...gaya.kelas);
        hasilJudul.textContent = gaya.judul;
        hasilDetail.textContent = detail; // textContent: aman dari XSS
    }

    function getar(pola) {
        if (navigator.vibrate) navigator.vibrate(pola);
    }

    function perbaruiRingkasan(r) {
        if (!r) return;
        document.getElementById('n-hadir').textContent = r.hadir;
        document.getElementById('n-terlambat').textContent = r.terlambat;
        document.getElementById('n-belum').textContent = r.tidak_hadir;
    }

    function tambahRiwayat(status, nama, waktu) {
        const li = document.createElement('li');
        li.className = 'flex items-center justify-between rounded-xl bg-white border border-gray-100 px-4 py-3 text-sm';
        const kiri = document.createElement('span');
        kiri.className = 'font-medium text-slate-800';
        kiri.textContent = nama || 'QR tidak dikenal';
        const kanan = document.createElement('span');
        kanan.className = 'text-slate-500';
        kanan.textContent = `${LABEL_RIWAYAT[status] ?? status} · ${waktu}`;
        li.append(kiri, kanan);
        riwayat.prepend(li);
        while (riwayat.children.length > 10) riwayat.lastElementChild.remove();
        riwayatKosong.classList.add('hidden');
    }

    function jamSekarang() {
        return new Date().toLocaleTimeString('id-ID', { hour12: false });
    }

    async function kirim(token) {
        token = (token || '').trim();
        if (!token || sedangKirim) return;

        // Cegah kirim berulang saat QR yang sama masih berada di depan kamera.
        const sekarang = Date.now();
        if (token === tokenTerakhir && sekarang - waktuTerakhir < 4000) return;
        tokenTerakhir = token;
        waktuTerakhir = sekarang;

        sedangKirim = true;
        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ token }),
                credentials: 'same-origin',
            });

            let data = null;
            try { data = await res.json(); } catch (_) { /* bukan JSON */ }

            if (!data) {
                const pesan = res.status === 419
                    ? 'Sesi login habis. Muat ulang halaman lalu coba lagi.'
                    : 'Terjadi gangguan pada server. Coba lagi sebentar lagi.';
                tampilkan('galat', pesan);
                getar([200, 100, 200]);
                return;
            }

            if (data.status === 'hadir' || data.status === 'terlambat' || data.status === 'duplikat') {
                const nama = data.siswa?.nama ?? '';
                const kelas = data.siswa?.kelas ?? '';
                tampilkan(data.status, `${nama} · ${kelas} · ${data.pesan}`);
                getar(data.status === 'duplikat' ? [100] : [80]);
                tambahRiwayat(data.status, nama, data.waktu ?? jamSekarang());
                perbaruiRingkasan(data.ringkasan);
                if (inputManual) inputManual.value = '';
            } else {
                tampilkan('galat', data.pesan ?? 'Terjadi kesalahan.');
                getar([200, 100, 200]);
                tambahRiwayat(data.status ?? 'tidak_valid', null, jamSekarang());
            }
        } catch (_) {
            tampilkan('galat', 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.');
        } finally {
            sedangKirim = false;
        }
    }

    async function mulai() {
        if (!sesiBuka) return;

        if (window.__scanFallbackMsg) {
            tampilkan('galat', window.__scanFallbackMsg);
            inputManual?.focus();
            return;
        }

        try {
            if (!(await QrScanner.hasCamera())) {
                throw new Error('tidak-ada-kamera');
            }
            if (!scanner) {
                scanner = new QrScanner(video, (r) => kirim(r.data), {
                    preferredCamera: 'environment',
                    highlightScanRegion: true,
                    highlightCodeOutline: true,
                    maxScansPerSecond: 5,
                    returnDetailedScanResult: true,
                });
            }
            await scanner.start();
            placeholder.classList.add('hidden');
            btnMulai.disabled = true;
            btnStop.disabled = false;
        } catch (e) {
            const ditolak = e && (e.name === 'NotAllowedError' || String(e).includes('NotAllowed'));
            tampilkan('galat', ditolak
                ? 'Izin kamera ditolak. Aktifkan izin kamera di pengaturan browser, atau gunakan input token manual di bawah.'
                : 'Kamera tidak tersedia di perangkat ini. Gunakan input token manual di bawah.');
            inputManual?.focus();
        }
    }

    function berhenti() {
        if (scanner) scanner.stop();
        placeholder.classList.remove('hidden');
        btnMulai.disabled = !sesiBuka;
        btnStop.disabled = true;
    }

    btnMulai.addEventListener('click', mulai);
    btnStop.addEventListener('click', berhenti);

    formManual.addEventListener('submit', (e) => {
        e.preventDefault();
        tokenTerakhir = ''; // input manual selalu diproses
        kirim(inputManual.value);
    });

    window.addEventListener('pagehide', () => scanner?.destroy());
}

import QrScanner from 'qr-scanner';

const root = document.getElementById('attendance-app');

if (root) {
    const url = root.dataset.url;
    const csrf = root.dataset.csrf;

    const video = document.getElementById('kamera');
    const placeholder = document.getElementById('kamera-kosong');
    const btnMulai = document.getElementById('btn-mulai');
    const btnStop = document.getElementById('btn-stop');
    const hasil = document.getElementById('hasil');
    const hasilJudul = document.getElementById('hasil-judul');
    const hasilDetail = document.getElementById('hasil-detail');
    const inputManual = document.getElementById('token-manual');

    const KELAS = {
        sukses: ['bg-green-50', 'border-green-500', 'text-green-900'],
        terlambat: ['bg-amber-50', 'border-amber-500', 'text-amber-900'],
        info: ['bg-blue-50', 'border-blue-500', 'text-blue-900'],
        galat: ['bg-red-50', 'border-red-500', 'text-red-900'],
    };
    const SEMUA = Object.values(KELAS).flat();

    let scanner = null;
    let sedangKirim = false;
    let tokenTerakhir = '';
    let waktuTerakhir = 0;

    function tampilkan(jenis, judul, detail) {
        hasil.classList.remove('hidden', ...SEMUA);
        hasil.classList.add(...KELAS[jenis]);
        hasilJudul.textContent = judul;
        hasilDetail.textContent = detail; // textContent: aman dari XSS
        if (navigator.vibrate) navigator.vibrate(jenis === 'galat' ? [200, 100, 200] : [80]);
    }

    /** Isi QR berupa tautan (…/attendance/check-in?token=XXX) atau token murni. */
    function ambilToken(isi) {
        const teks = (isi || '').trim();
        try {
            const u = new URL(teks);
            return (u.searchParams.get('token') || '').trim();
        } catch (_) {
            return teks;
        }
    }

    function berhenti() {
        if (scanner) scanner.stop();
        placeholder.classList.remove('hidden');
        btnMulai.disabled = false;
        btnStop.disabled = true;
    }

    async function kirim(isi) {
        const token = ambilToken(isi);
        if (!token || sedangKirim) return;

        // Cegah kirim berulang saat QR yang sama masih di depan kamera.
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
                tampilkan('galat', '✕ Gagal',
                    res.status === 419 || res.status === 401
                        ? 'Sesi login habis. Muat ulang halaman lalu masuk kembali.'
                        : 'Terjadi gangguan pada server. Coba lagi sebentar lagi.');
                return;
            }

            if (data.success) {
                tampilkan(data.status === 'terlambat' ? 'terlambat' : 'sukses',
                    data.status === 'terlambat' ? '⏰ Check-in tercatat (terlambat)' : '✓ Check-in berhasil',
                    data.message);
                berhenti(); // satu check-in per sesi: matikan kamera agar tidak memindai ulang
            } else if (data.reason === 'already_checked_in') {
                tampilkan('info', '↺ Sudah check-in', data.message);
                berhenti();
            } else {
                tampilkan('galat', '✕ Tidak dapat check-in', data.message || 'Terjadi kesalahan.');
            }
        } catch (_) {
            tampilkan('galat', '✕ Gagal', 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.');
        } finally {
            sedangKirim = false;
        }
    }

    async function mulai() {
        if (window.__attendanceFallbackMsg) {
            tampilkan('galat', 'Kamera belum tersedia', window.__attendanceFallbackMsg);
            inputManual?.focus();
            return;
        }

        try {
            if (!(await QrScanner.hasCamera())) throw new Error('tidak-ada-kamera');

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
            tampilkan('galat', 'Kamera tidak dapat dipakai', ditolak
                ? 'Izin kamera ditolak. Aktifkan izin kamera di pengaturan browser, atau gunakan input token manual.'
                : 'Kamera tidak tersedia (atau halaman bukan HTTPS). Gunakan input token manual di bawah.');
            inputManual?.focus();
        }
    }

    btnMulai.addEventListener('click', mulai);
    btnStop.addEventListener('click', berhenti);
    window.addEventListener('pagehide', () => scanner?.destroy());
}

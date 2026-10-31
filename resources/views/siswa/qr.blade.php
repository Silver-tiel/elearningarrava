@extends('layouts.siswa')

@section('title', 'QR Presensi Saya')

@section('content')
<style>
    #qr-svg svg { width: 100%; height: auto; display: block; }
    @media print {
        body * { visibility: hidden !important; }
        #kartu-qr, #kartu-qr * { visibility: visible !important; }
        #kartu-qr { position: absolute; left: 0; top: 0; width: 86mm; box-shadow: none !important; border: 1px solid #000 !important; }
    }
</style>

<div class="p-4 sm:p-8 max-w-md mx-auto">
    <h1 class="text-2xl font-bold text-slate-800 mb-1">QR Presensi Saya</h1>
    <p class="text-sm text-slate-500 mb-6">Tunjukkan QR ini kepada guru saat presensi. QR ini hanya untukmu dan tidak boleh dibagikan.</p>

    <div id="kartu-qr" class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 text-center">
        <div id="qr-svg" class="mx-auto w-full max-w-[280px] bg-white p-2" role="img" aria-label="QR presensi milik {{ $nama }}">{!! $svg !!}</div>
        <p class="mt-4 text-lg font-bold text-slate-800">{{ $nama }}</p>
        @if($kelas->isNotEmpty())
            <p class="text-sm text-slate-500">{{ $kelas->implode(', ') }}</p>
        @endif
        <p class="mt-2 text-xs text-slate-400">Bimbel Arava · Kartu presensi</p>
    </div>

    <div class="grid grid-cols-2 gap-3 mt-6">
        <button id="btn-unduh" type="button" class="h-14 rounded-xl bg-blue-600 text-white text-lg font-bold hover:bg-blue-700">Unduh PNG</button>
        <button id="btn-cetak" type="button" class="h-14 rounded-xl border border-slate-300 text-slate-800 text-lg font-bold hover:bg-slate-50">Cetak</button>
    </div>
    <p id="pesan-unduh" class="text-sm text-red-600 mt-3 hidden" role="alert">Gagal membuat gambar. Coba lagi atau gunakan tombol Cetak.</p>
</div>

<script>
    (function () {
        var namaFile = 'qr-presensi-{{ \Illuminate\Support\Str::slug($nama) ?: 'siswa' }}.png';

        document.getElementById('btn-cetak').addEventListener('click', function () { window.print(); });

        document.getElementById('btn-unduh').addEventListener('click', function () {
            var svg = document.querySelector('#qr-svg svg');
            var pesan = document.getElementById('pesan-unduh');
            pesan.classList.add('hidden');
            if (!svg) { pesan.classList.remove('hidden'); return; }

            svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
            var xml = new XMLSerializer().serializeToString(svg);
            var img = new Image();
            img.onload = function () {
                var ukuran = 900, pad = 50;
                var canvas = document.createElement('canvas');
                canvas.width = ukuran; canvas.height = ukuran;
                var ctx = canvas.getContext('2d');
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, ukuran, ukuran);
                ctx.imageSmoothingEnabled = false;
                ctx.drawImage(img, pad, pad, ukuran - pad * 2, ukuran - pad * 2);
                canvas.toBlob(function (blob) {
                    if (!blob) { pesan.classList.remove('hidden'); return; }
                    var a = document.createElement('a');
                    a.href = URL.createObjectURL(blob);
                    a.download = namaFile;
                    document.body.appendChild(a); a.click(); a.remove();
                    setTimeout(function () { URL.revokeObjectURL(a.href); }, 1000);
                }, 'image/png');
            };
            img.onerror = function () { pesan.classList.remove('hidden'); };
            img.src = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(xml);
        });
    })();
</script>
@endsection

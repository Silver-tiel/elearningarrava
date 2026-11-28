<div id="attendance-app"
     data-url="{{ route('attendance.check-in') }}"
     data-csrf="{{ csrf_token() }}"
     class="mx-auto w-full max-w-xl space-y-4 p-4 sm:p-8">

    @include('attendance._flash')

    <div>
        <h2 class="text-2xl font-bold text-slate-800">Absen Mentor</h2>
        <p class="mt-1 text-sm text-slate-500">Pindai QR yang ditampilkan admin untuk mencatat kehadiran Anda.</p>
    </div>

    <div class="relative aspect-square overflow-hidden rounded-2xl bg-slate-900 sm:aspect-[4/3]">
        <video id="kamera" class="absolute inset-0 h-full w-full object-cover" playsinline muted></video>
        <div id="kamera-kosong" class="absolute inset-0 flex items-center justify-center p-6 text-center text-slate-300">
            Tekan <b class="mx-1">Mulai Scan</b> untuk mengaktifkan kamera.
        </div>
    </div>

    <div class="grid grid-cols-2 gap-3">
        <button id="btn-mulai" type="button" class="h-14 rounded-xl bg-blue-600 text-lg font-bold text-white hover:bg-blue-700 disabled:opacity-50">Mulai Scan</button>
        <button id="btn-stop" type="button" disabled class="h-14 rounded-xl bg-slate-200 text-slate-800 disabled:opacity-50">Berhenti</button>
    </div>

    <div id="hasil" role="status" aria-live="assertive" class="hidden rounded-2xl border-2 p-4">
        <p id="hasil-judul" class="text-lg font-bold"></p>
        <p id="hasil-detail" class="text-base"></p>
    </div>

    <form method="POST" action="{{ route('attendance.check-in') }}" class="rounded-2xl border border-gray-100 bg-white p-4" autocomplete="off">
        @csrf
        @if($embedded ?? false)
            <input type="hidden" name="return_to" value="presensi">
        @endif
        <label for="token-manual" class="mb-1 block text-sm font-medium text-slate-700">Input token manual</label>
        <p class="mb-2 text-xs text-slate-500">Gunakan jika kamera tidak tersedia. Tempel token (atau tautan) dari admin.</p>
        <div class="flex gap-2">
            <input id="token-manual" name="token" type="text" required maxlength="2048" autocapitalize="off" spellcheck="false"
                   class="h-14 min-w-0 flex-1 rounded-xl border border-slate-300 px-4 font-mono text-base" placeholder="Token sesi">
            <button type="submit" class="h-14 rounded-xl bg-slate-800 px-6 font-bold text-white">Check-in</button>
        </div>
    </form>

    <p class="text-xs text-slate-500">
        Kamera di browser hanya bisa dipakai pada alamat <b>HTTPS</b> (atau <b>localhost</b>). Jika kamera tidak muncul,
        gunakan input token manual di atas atau pindai QR dengan aplikasi kamera ponsel lalu buka tautannya.
    </p>
</div>

@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite('resources/js/attendance-scan.js')
@else
    <script>
        window.__attendanceFallbackMsg = 'Kamera belum tersedia (jalankan npm run build). Gunakan input token manual.';
    </script>
@endif

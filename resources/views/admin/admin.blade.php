@extends('layouts.app')

@section('header')
    <h1 class="text-base sm:text-lg font-heading font-black text-[#082765]">Ringkasan Aktivitas Belajar</h1>

    <div class="flex items-center gap-3">
        <!-- Switch Bahasa -->
        <button class="flex items-center gap-1.5 text-xs font-bold text-[#465673] bg-white px-3 py-1.5 rounded-xl border border-[#DCEFFF] shadow-[0_2px_0_#DCEFFF] hover:border-[#007FBE] transition">
            <span>ID</span>
            <svg class="w-3.5 h-3.5 text-[#72839E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
    </div>
@endsection

@section('content')
@php
    /**
     * @var int $siswaCount
     * @var int $guruCount
     * @var int $modulCount
     * @var int $quizCount
     * @var int $achievementCount
     * @var \Illuminate\Database\Eloquent\Collection<int, \App\Models\User>|array $siswaTerbaru
     * @var \Illuminate\Database\Eloquent\Collection<int, \App\Models\Modul>|array $modulTerbaru
     */
@endphp
<div class="p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl mx-auto">

    <!-- GREETING SECTION -->
    <div class="rounded-2xl sm:rounded-3xl bg-gradient-to-r from-[#007FBE] via-[#0095DE] to-[#38BDF8] p-6 sm:p-7 text-white shadow-[0_6px_0_#005580] relative overflow-hidden">
        <div class="absolute -right-8 -bottom-10 w-44 h-44 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
        <div class="relative z-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-black text-white border border-white/25 mb-2.5">
                <span>🛡️</span> Portal Administrator Arrava
            </span>
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-heading font-black leading-tight">
                Selamat datang kembali, {{ Auth::user()->nama ?? 'Admin' }}! 👋
            </h2>
            <p class="text-xs sm:text-sm text-white/90 mt-1.5 max-w-xl font-medium">
                Arrava adalah platform pembelajaran digital yang mempertemukan siswa dan guru. Siswa dapat mempelajari materi dan mengerjakan kuis, sementara guru mendampingi serta memantau perkembangan belajar.
            </p>
        </div>
    </div>

    <nav aria-label="Tampilan dashboard" class="flex flex-wrap gap-2 rounded-2xl border-2 border-[#DCEFFF] bg-white p-2 shadow-[0_4px_0_#B2E7FC]">
        @foreach([
            ['key' => 'overview', 'label' => 'Overview', 'description' => 'Ringkasan platform'],
            ['key' => 'siswa', 'label' => 'Siswa', 'description' => 'Aktivitas dan perkembangan'],
            ['key' => 'guru', 'label' => 'Guru', 'description' => 'Pengajar dan konten belajar'],
        ] as $menu)
            <a
                href="{{ route('admin', ['view' => $menu['key']]) }}"
                data-dashboard-tab="{{ $menu['key'] }}"
                aria-current="{{ $dashboardView === $menu['key'] ? 'page' : 'false' }}"
                class="flex-1 rounded-xl border px-4 py-3 transition sm:flex-none {{ $dashboardView === $menu['key'] ? 'border-[#007FBE] bg-[#DDF3FF] text-[#007FBE] shadow-[0_2px_0_#B2E7FC]' : 'border-transparent text-[#465673] hover:border-[#DCEFFF] hover:bg-[#F0F6FF]' }}"
            >
                <span class="block text-sm font-black">{{ $menu['label'] }}</span>
                <span class="mt-0.5 hidden text-[10px] font-semibold opacity-75 sm:block">{{ $menu['description'] }}</span>
            </a>
        @endforeach
    </nav>

    <div id="dashboard-panel" data-loaded-view="{{ $dashboardView }}" aria-live="polite" class="space-y-6">
    @php
        $nilaiTertinggiHarian = max(
            1,
            collect($grafikPenyelesaianMingguan ?? [])
                ->flatMap(fn ($hari) => [$hari['kuis'], $hari['modul']])
                ->max() ?? 0
        );
    @endphp

    @if($dashboardView === 'siswa')
    <section class="rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] bg-white p-5 sm:p-6 shadow-[0_4px_0_#B2E7FC]">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-5">
            <div>
                <h3 class="font-heading font-black text-[#082765] text-base sm:text-lg flex items-center gap-2">
                    <span>📊</span> Penyelesaian Belajar Minggu Ini
                </h3>
                <p class="mt-1 text-xs font-semibold text-[#72839E]">Aktivitas siswa dari Senin sampai Minggu · {{ $rentangMinggu ?? '' }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-3 text-[11px] font-bold text-[#465673]">
                <span class="inline-flex items-center gap-1.5"><span class="h-3 w-3 rounded-sm bg-[#0095DE]"></span>Kuis disubmit</span>
                <span class="inline-flex items-center gap-1.5"><span class="h-3 w-3 rounded-sm bg-[#10B981]"></span>Modul pertama kali tuntas</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <div class="min-w-[640px]">
                <div class="relative grid h-60 grid-cols-7 gap-2 sm:gap-4">
                    <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 inset-y-0 flex flex-col justify-between">
                        @foreach([0, 1, 2, 3, 4] as $gridLine)
                            <div class="border-t border-dashed border-[#E8F0FA]"></div>
                        @endforeach
                    </div>

                    @foreach($grafikPenyelesaianMingguan ?? [] as $hari)
                        <div class="relative z-10 flex min-w-0 flex-col items-center">
                            <div class="flex h-48 w-full items-end justify-center gap-2 border-b border-[#C9D8EA]">
                                @foreach([
                                    ['key' => 'kuis', 'color' => 'bg-[#0095DE]', 'label' => 'Kuis disubmit'],
                                    ['key' => 'modul', 'color' => 'bg-[#10B981]', 'label' => 'Modul pertama kali tuntas'],
                                ] as $seri)
                                    @php
                                        $jumlahAktivitas = $hari[$seri['key']];
                                        $tinggiBatang = $jumlahAktivitas > 0
                                            ? max(3, (int) round(($jumlahAktivitas / $nilaiTertinggiHarian) * 78))
                                            : 0;
                                    @endphp
                                    <div class="flex h-full w-7 flex-col items-center justify-end gap-1" title="{{ $seri['label'] }}: {{ $jumlahAktivitas }}">
                                        <span class="text-[10px] font-black text-[#465673]">{{ $jumlahAktivitas }}</span>
                                        <div class="{{ $seri['color'] }} w-5 rounded-t-md shadow-sm" style="height: {{ $tinggiBatang }}%"></div>
                                    </div>
                                @endforeach
                            </div>
                            <span class="mt-2 text-[10px] sm:text-xs font-black text-[#082765]">{{ $hari['label'] }}</span>
                            <span class="text-[10px] font-semibold text-[#9AA8BC]">{{ \Illuminate\Support\Carbon::parse($hari['tanggal'])->format('d/m') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <p class="mt-3 text-[10px] font-medium text-[#9AA8BC]">Setiap submit kuis dihitung. Modul dihitung saat pertama kali mencapai status tuntas.</p>
    </section>
    @endif

    @if($dashboardView === 'siswa')
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <section class="rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] bg-white p-5 sm:p-6 shadow-[0_4px_0_#B2E7FC]">
            <div class="mb-5">
                <h3 class="font-heading font-black text-[#082765] text-base sm:text-lg flex items-center gap-2">
                    <span>🧠</span> Hasil Kuis Minggu Ini
                </h3>
                <p class="mt-1 text-xs font-semibold text-[#72839E]">Rata-rata nilai dan persentase lulus dari setiap submit siswa.</p>
            </div>

            <div class="grid grid-cols-3 gap-2 sm:gap-3 mb-5">
                <div class="rounded-xl border border-[#DCEFFF] bg-[#F0F6FF]/70 p-3">
                    <p class="text-[10px] font-bold text-[#72839E]">Rata-rata nilai</p>
                    <p class="mt-1 text-lg sm:text-2xl font-black text-[#082765]">
                        {{ isset($rataNilaiKuis) ? number_format($rataNilaiKuis, 1) . '%' : '—' }}
                    </p>
                </div>
                <div class="rounded-xl border border-emerald-100 bg-emerald-50/70 p-3">
                    <p class="text-[10px] font-bold text-emerald-700">Tingkat kelulusan</p>
                    <p class="mt-1 text-lg sm:text-2xl font-black text-emerald-800">
                        {{ isset($persentaseLulusKuis) ? number_format($persentaseLulusKuis, 1) . '%' : '—' }}
                    </p>
                </div>
                <div class="rounded-xl border border-amber-100 bg-amber-50/70 p-3">
                    <p class="text-[10px] font-bold text-amber-700">Jumlah submit</p>
                    <p class="mt-1 text-lg sm:text-2xl font-black text-amber-800">{{ number_format($jumlahSubmitKuis ?? 0) }}</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse($hasilKuisPerJenjang ?? [] as $hasilJenjang)
                    <div class="rounded-xl border border-[#E8F0FA] p-3">
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-xs font-black text-[#082765]">{{ $hasilJenjang['jenjang'] }}</span>
                            <span class="text-[10px] font-semibold text-[#72839E]">{{ $hasilJenjang['jumlah_submit'] }} submit</span>
                        </div>
                        <div class="mt-2 grid grid-cols-2 gap-3">
                            <div>
                                <div class="mb-1 flex justify-between text-[10px] font-bold text-[#465673]">
                                    <span>Rata-rata nilai</span>
                                    <span>{{ isset($hasilJenjang['rata_nilai']) ? number_format($hasilJenjang['rata_nilai'], 1) . '%' : '—' }}</span>
                                </div>
                                <div class="h-1.5 rounded-full bg-[#F0F6FF]">
                                    <div class="h-1.5 rounded-full bg-[#0095DE]" style="width: {{ min(100, max(0, $hasilJenjang['rata_nilai'] ?? 0)) }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="mb-1 flex justify-between text-[10px] font-bold text-[#465673]">
                                    <span>Lulus</span>
                                    <span>{{ isset($hasilJenjang['persentase_lulus']) ? number_format($hasilJenjang['persentase_lulus'], 1) . '%' : '—' }}</span>
                                </div>
                                <div class="h-1.5 rounded-full bg-emerald-50">
                                    <div class="h-1.5 rounded-full bg-emerald-500" style="width: {{ min(100, max(0, $hasilJenjang['persentase_lulus'] ?? 0)) }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="py-5 text-center text-xs font-semibold text-[#72839E]">Belum ada data jenjang kuis.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] bg-white p-5 sm:p-6 shadow-[0_4px_0_#B2E7FC]">
            <div class="mb-5">
                <h3 class="font-heading font-black text-[#082765] text-base sm:text-lg flex items-center gap-2">
                    <span>👣</span> Keaktifan Siswa
                </h3>
                <p class="mt-1 text-xs font-semibold text-[#72839E]">Aktivitas diukur dari submit kuis atau pembaruan progres modul.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="rounded-2xl border border-[#DCEFFF] bg-[#F0F6FF]/70 p-4">
                    <p class="text-[11px] font-bold text-[#72839E]">Siswa aktif minggu ini</p>
                    <p class="mt-2 text-3xl font-black text-[#007FBE]">{{ number_format($siswaAktifMingguIni ?? 0) }}</p>
                    <p class="mt-1 text-[10px] font-semibold text-[#72839E]">dari {{ number_format($jumlahSiswaAktif ?? 0) }} siswa aktif</p>
                </div>
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4">
                    <p class="text-[11px] font-bold text-emerald-700">Aktif 14 hari terakhir</p>
                    <p class="mt-2 text-3xl font-black text-emerald-700">{{ number_format($siswaAktif14HariIni ?? 0) }}</p>
                    <p class="mt-1 text-[10px] font-semibold text-emerald-700">punya aktivitas belajar</p>
                </div>
                <div class="rounded-2xl border border-amber-100 bg-amber-50/70 p-4">
                    <p class="text-[11px] font-bold text-amber-700">Tidak aktif 14 hari</p>
                    <p class="mt-2 text-3xl font-black text-amber-800">{{ number_format($siswaTidakAktif14Hari ?? 0) }}</p>
                    <p class="mt-1 text-[10px] font-semibold text-amber-700">termasuk yang belum punya aktivitas</p>
                </div>
            </div>
        </section>

        <section class="rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] bg-white p-5 sm:p-6 shadow-[0_4px_0_#B2E7FC]">
            <div class="mb-5">
                <h3 class="font-heading font-black text-[#082765] text-base sm:text-lg flex items-center gap-2">
                    <span>📚</span> Progres Modul per Jenjang
                </h3>
                <p class="mt-1 text-xs font-semibold text-[#72839E]">Rasio modul tuntas dibanding total progres modul siswa aktif.</p>
            </div>

            <div class="space-y-4">
                @forelse($progressPerJenjang ?? [] as $progresJenjang)
                    <div>
                        <div class="mb-1.5 flex items-center justify-between gap-3">
                            <div>
                                <p class="text-xs font-black text-[#082765]">{{ $progresJenjang['jenjang'] }}</p>
                                <p class="text-[10px] font-semibold text-[#72839E]">
                                    {{ $progresJenjang['jumlah_tuntas'] }} dari {{ $progresJenjang['jumlah_siswa'] * $progresJenjang['jumlah_modul'] }} progres modul
                                </p>
                            </div>
                            <span class="text-sm font-black text-[#007FBE]">
                                {{ isset($progresJenjang['persentase']) ? number_format($progresJenjang['persentase'], 1) . '%' : '—' }}
                            </span>
                        </div>
                        <div class="h-2.5 rounded-full bg-[#F0F6FF]">
                            <div class="h-2.5 rounded-full bg-gradient-to-r from-[#0095DE] to-[#38BDF8]" style="width: {{ min(100, max(0, $progresJenjang['persentase'] ?? 0)) }}%"></div>
                        </div>
                        @if($progresJenjang['jumlah_siswa'] === 0 || $progresJenjang['jumlah_modul'] === 0)
                            <p class="mt-1 text-[10px] font-medium text-[#9AA8BC]">Belum ada siswa aktif atau modul tersedia pada jenjang ini.</p>
                        @endif
                    </div>
                @empty
                    <p class="py-5 text-center text-xs font-semibold text-[#72839E]">Belum ada data progres modul.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] bg-white p-5 sm:p-6 shadow-[0_4px_0_#B2E7FC]">
            <div class="mb-5">
                <h3 class="font-heading font-black text-[#082765] text-base sm:text-lg flex items-center gap-2">
                    <span>🗓️</span> Kehadiran Minggu Ini
                </h3>
                <p class="mt-1 text-xs font-semibold text-[#72839E]">Dihitung dari siswa aktif pada sesi presensi yang sudah selesai.</p>
            </div>

            @if(!($presensiTersedia ?? false))
                <p class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-center text-xs font-semibold text-amber-800">
                    Data presensi belum tersedia.
                </p>
            @elseif(($sesiPresensiSelesai ?? 0) === 0)
                <p class="rounded-xl border border-[#DCEFFF] bg-[#F0F6FF]/70 p-4 text-center text-xs font-semibold text-[#72839E]">
                    Belum ada sesi presensi selesai pada minggu ini.
                </p>
            @else
                <div class="mb-4 rounded-2xl bg-gradient-to-r from-[#ECFDF5] to-[#F0FDF4] p-4">
                    <p class="text-[11px] font-bold text-emerald-700">Rata-rata tingkat kehadiran</p>
                    <div class="mt-1 flex items-end justify-between gap-3">
                        <p class="text-3xl font-black text-emerald-800">{{ number_format($persentaseHadirMingguan, 1) }}%</p>
                        <p class="text-right text-[10px] font-semibold text-emerald-700">
                            {{ number_format($jumlahHadirMingguan) }} hadir dari {{ number_format($jumlahPesertaSeharusnya) }} kesempatan
                        </p>
                    </div>
                </div>
                <div class="space-y-3">
                    @foreach($presensiPerJenjang ?? [] as $rekapPresensi)
                        <div>
                            <div class="mb-1 flex justify-between text-[11px] font-bold text-[#465673]">
                                <span>{{ $rekapPresensi['jenjang'] }} · {{ $rekapPresensi['jumlah_sesi'] }} sesi</span>
                                <span>{{ number_format($rekapPresensi['persentase'], 1) }}%</span>
                            </div>
                            <div class="h-2 rounded-full bg-emerald-50">
                                <div class="h-2 rounded-full bg-emerald-500" style="width: {{ min(100, max(0, $rekapPresensi['persentase'])) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
    @endif

    @if($dashboardView === 'overview')
    @php
        $pendaftaranMaksimum = max(
            1,
            collect($registrasiBulanan ?? [])
                ->flatMap(fn ($bulan) => [$bulan['siswa'], $bulan['guru']])
                ->max() ?? 0
        );
    @endphp
    <section class="rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] bg-white p-5 sm:p-6 shadow-[0_4px_0_#B2E7FC]">
        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="font-heading font-black text-[#082765] text-base sm:text-lg flex items-center gap-2">
                    <span>📈</span> Pertumbuhan Pendaftaran
                </h3>
                <p class="mt-1 text-xs font-semibold text-[#72839E]">Siswa dan guru baru per bulan · {{ $rentangRegistrasi ?? '' }}</p>
            </div>
            <div class="flex items-center gap-4 text-[11px] font-bold text-[#465673]">
                <span class="inline-flex items-center gap-1.5"><span class="h-3 w-3 rounded-sm bg-[#0095DE]"></span>Siswa</span>
                <span class="inline-flex items-center gap-1.5"><span class="h-3 w-3 rounded-sm bg-[#8B5CF6]"></span>Guru</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <div class="min-w-[600px]">
                <div class="grid h-48 grid-cols-6 gap-3 sm:gap-6">
                    @foreach($registrasiBulanan ?? [] as $bulan)
                        <div class="flex flex-col items-center">
                            <div class="flex h-40 w-full items-end justify-center gap-2 border-b border-[#C9D8EA]">
                                @foreach([
                                    ['key' => 'siswa', 'color' => 'bg-[#0095DE]'],
                                    ['key' => 'guru', 'color' => 'bg-[#8B5CF6]'],
                                ] as $seri)
                                    @php
                                        $jumlahPendaftar = $bulan[$seri['key']];
                                        $tinggiBatang = $jumlahPendaftar > 0
                                            ? max(4, (int) round(($jumlahPendaftar / $pendaftaranMaksimum) * 78))
                                            : 0;
                                    @endphp
                                    <div class="flex h-full w-9 flex-col items-center justify-end gap-1" title="{{ ucfirst($seri['key']) }}: {{ $jumlahPendaftar }}">
                                        <span class="text-[10px] font-black text-[#465673]">{{ $jumlahPendaftar }}</span>
                                        <div class="{{ $seri['color'] }} w-6 rounded-t-md shadow-sm" style="height: {{ $tinggiBatang }}%"></div>
                                    </div>
                                @endforeach
                            </div>
                            <span class="mt-2 text-[10px] sm:text-xs font-black text-[#082765]">{{ $bulan['bulan'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    @if($dashboardView === 'guru')
        @php
            $pendaftaranGuruMaksimum = max(
                1,
                collect($registrasiBulanan ?? [])->pluck('guru')->max() ?? 0
            );
            $guruBulanIni = collect($registrasiBulanan ?? [])->last()['guru'] ?? 0;
        @endphp
        <section class="space-y-5">
            <div>
                <h3 class="font-heading text-lg font-black text-[#082765]">Ringkasan Guru</h3>
                <p class="mt-1 text-xs font-semibold text-[#72839E]">Gambaran jumlah pengajar dan konten belajar{{ Auth::user()?->isGuru() ? ' yang Anda buat' : ' di Arrava' }}.</p>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-2xl border-2 border-[#DCEFFF] bg-white p-5 shadow-[0_4px_0_#B2E7FC]">
                    <p class="text-xs font-bold text-[#72839E]">Total Guru</p>
                    <p class="mt-2 text-3xl font-black text-[#082765]">{{ number_format($guruCount ?? 0) }}</p>
                </div>
                <div class="rounded-2xl border-2 border-[#DCEFFF] bg-white p-5 shadow-[0_4px_0_#B2E7FC]">
                    <p class="text-xs font-bold text-[#72839E]">{{ Auth::user()?->isGuru() ? 'Modul Saya' : 'Total Modul' }}</p>
                    <p class="mt-2 text-3xl font-black text-[#059669]">{{ number_format($modulCount ?? 0) }}</p>
                </div>
                <div class="rounded-2xl border-2 border-[#DCEFFF] bg-white p-5 shadow-[0_4px_0_#B2E7FC]">
                    <p class="text-xs font-bold text-[#72839E]">{{ Auth::user()?->isGuru() ? 'Kuis Saya' : 'Total Kuis' }}</p>
                    <p class="mt-2 text-3xl font-black text-[#D97706]">{{ number_format($quizCount ?? 0) }}</p>
                </div>
            </div>

            <section class="rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] bg-white p-5 sm:p-6 shadow-[0_4px_0_#B2E7FC]">
                <div class="mb-5">
                    <h3 class="font-heading font-black text-[#082765] text-base sm:text-lg flex items-center gap-2">
                        <span>📈</span> Pendaftaran Guru
                    </h3>
                    <p class="mt-1 text-xs font-semibold text-[#72839E]">Jumlah guru baru per bulan selama enam bulan terakhir · {{ $rentangRegistrasi ?? '' }}</p>
                </div>

                <div class="overflow-x-auto">
                    <div class="min-w-[600px]">
                        <div class="grid h-48 grid-cols-6 gap-3 sm:gap-6">
                            @foreach($registrasiBulanan ?? [] as $bulan)
                                @php
                                    $jumlahGuruBaru = $bulan['guru'];
                                    $tinggiBatangGuru = $jumlahGuruBaru > 0
                                        ? max(4, (int) round(($jumlahGuruBaru / $pendaftaranGuruMaksimum) * 78))
                                        : 0;
                                @endphp
                                <div class="flex flex-col items-center">
                                    <div class="flex h-40 w-full items-end justify-center border-b border-[#C9D8EA]">
                                        <div class="flex h-full w-9 flex-col items-center justify-end gap-1" title="Guru baru: {{ $jumlahGuruBaru }}">
                                            <span class="text-[10px] font-black text-[#465673]">{{ $jumlahGuruBaru }}</span>
                                            <div class="w-6 rounded-t-md bg-[#8B5CF6] shadow-sm" style="height: {{ $tinggiBatangGuru }}%"></div>
                                        </div>
                                    </div>
                                    <span class="mt-2 text-[10px] font-black text-[#082765] sm:text-xs">{{ $bulan['bulan'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <p class="mt-3 text-[10px] font-medium text-[#9AA8BC]">Guru baru bulan ini: {{ number_format($guruBulanIni) }}.</p>
            </section>
        </section>
    @endif

    <!-- STATS CARDS (3D SAMUDRA STYLE) -->
    @if($dashboardView === 'overview')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">

        <!-- Card 1: Total Siswa -->
        <div class="bg-white p-5 rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] shadow-[0_4px_0_#B2E7FC] hover:shadow-[0_6px_0_#007FBE] hover:border-[#007FBE] hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-2xl bg-[#DDF3FF] text-[#007FBE] border border-[#B2E7FC] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-wider text-[#007FBE] bg-[#DDF3FF] px-2.5 py-0.5 rounded-full border border-[#B2E7FC]">Siswa</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-bold text-[#72839E]">Total Siswa</p>
                <h3 class="text-2xl sm:text-3xl font-heading font-black text-[#082765] mt-0.5">{{ number_format($siswaCount ?? 0) }}</h3>
            </div>
        </div>

        <!-- Card 2: Total Guru -->
        <div class="bg-white p-5 rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] shadow-[0_4px_0_#B2E7FC] hover:shadow-[0_6px_0_#007FBE] hover:border-[#007FBE] hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-2xl bg-[#EEF2FF] text-[#4F46E5] border border-[#C7D2FE] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-wider text-[#4F46E5] bg-[#EEF2FF] px-2.5 py-0.5 rounded-full border border-[#C7D2FE]">Guru</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-bold text-[#72839E]">Total Guru</p>
                <h3 class="text-2xl sm:text-3xl font-heading font-black text-[#082765] mt-0.5">{{ number_format($guruCount ?? 0) }}</h3>
            </div>
        </div>

        <!-- Card 3: Total Modul -->
        <div class="bg-white p-5 rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] shadow-[0_4px_0_#B2E7FC] hover:shadow-[0_6px_0_#007FBE] hover:border-[#007FBE] hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-2xl bg-[#DCFCE7] text-[#059669] border border-[#BBF7D0] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-wider text-[#059669] bg-[#DCFCE7] px-2.5 py-0.5 rounded-full border border-[#BBF7D0]">Modul</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-bold text-[#72839E]">Total Modul</p>
                <h3 class="text-2xl sm:text-3xl font-heading font-black text-[#082765] mt-0.5">{{ number_format($modulCount ?? 0) }}</h3>
            </div>
        </div>

        <!-- Card 4: Total Quiz -->
        <div class="bg-white p-5 rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] shadow-[0_4px_0_#B2E7FC] hover:shadow-[0_6px_0_#007FBE] hover:border-[#007FBE] hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-2xl bg-[#FEF3C7] text-[#D97706] border border-[#FDE68A] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-wider text-[#D97706] bg-[#FEF3C7] px-2.5 py-0.5 rounded-full border border-[#FDE68A]">Kuis</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-bold text-[#72839E]">Total Kuis</p>
                <h3 class="text-2xl sm:text-3xl font-heading font-black text-[#082765] mt-0.5">{{ number_format($quizCount ?? 0) }}</h3>
            </div>
        </div>

        <!-- Card 5: Total Kelas -->
        <div class="bg-white p-5 rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] shadow-[0_4px_0_#B2E7FC] hover:shadow-[0_6px_0_#007FBE] hover:border-[#007FBE] hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-2xl bg-[#EDE9FE] text-[#7C3AED] border border-[#DDD6FE] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M5 7v12h14V7M8 11h8m-8 4h5"/>
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-wider text-[#7C3AED] bg-[#EDE9FE] px-2.5 py-0.5 rounded-full border border-[#DDD6FE]">Kelas</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-bold text-[#72839E]">Total Kelas</p>
                <h3 class="text-2xl sm:text-3xl font-heading font-black text-[#082765] mt-0.5">{{ number_format($kelasCount ?? 0) }}</h3>
            </div>
        </div>

        <!-- Card 5: Total Penghargaan -->
        <a href="{{ route('admin.achievement') }}" class="bg-white p-5 rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] shadow-[0_4px_0_#B2E7FC] hover:shadow-[0_6px_0_#E11D48] hover:border-[#E11D48] hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-2xl bg-[#FFE4E6] text-[#E11D48] border border-[#FECDD3] flex items-center justify-center group-hover:scale-105 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-wider text-[#E11D48] bg-[#FFE4E6] px-2.5 py-0.5 rounded-full border border-[#FECDD3] group-hover:bg-[#E11D48] group-hover:text-white transition">Kelola →</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-bold text-[#72839E]">Penghargaan</p>
                <h3 class="text-2xl sm:text-3xl font-heading font-black text-[#082765] mt-0.5">{{ number_format($achievementCount ?? 0) }}</h3>
            </div>
        </a>

    </div>
    @endif

    <!-- MIDDLE SECTION: SISWA TERBARU & MODUL TERBARU -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">

        <!-- List Siswa Terbaru -->
        @if($dashboardView === 'siswa')
        <div class="bg-white p-6 rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] shadow-[0_4px_0_#B2E7FC]">
            <div class="flex items-center justify-between mb-5 pb-3 border-b border-[#DCEFFF]">
                <h3 class="font-heading font-black text-[#082765] text-base flex items-center gap-2">
                    <span>👥</span> Siswa Pendaftaran Terbaru
                </h3>
                <a href="{{ route('admin.daftar_siswa') }}" class="text-xs font-black text-[#007FBE] hover:text-[#00679A] hover:underline">Lihat Semua →</a>
            </div>

            <div class="space-y-3.5">
                @forelse($siswaTerbaru ?? [] as $siswa)
                    @php /** @var \App\Models\User $siswa */ @endphp
                    <div class="flex items-center justify-between p-3 rounded-2xl bg-[#F0F6FF]/60 border border-[#DCEFFF] hover:border-[#007FBE] hover:bg-[#F0F6FF] transition">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-2xl bg-[#DDF3FF] text-[#007FBE] font-black border border-[#B2E7FC] flex items-center justify-center shrink-0 text-sm">
                                {{ strtoupper(substr($siswa->nama ?? 'S', 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-xs sm:text-sm font-black text-[#082765] leading-tight truncate">{{ $siswa->nama }}</h4>
                                <p class="text-[11px] font-bold text-[#72839E] mt-0.5 truncate">{{ $siswa->email ?? 'Siswa' }}</p>
                            </div>
                        </div>
                        <span class="text-[11px] font-bold text-[#72839E] shrink-0 ml-2 px-2.5 py-0.5 rounded-lg bg-white border border-[#DCEFFF]">{{ $siswa->created_at ? $siswa->created_at->diffForHumans() : '-' }}</span>
                    </div>
                @empty
                    <p class="text-xs font-bold text-[#72839E] text-center py-6">Belum ada data siswa.</p>
                @endforelse
            </div>
        </div>
        @endif

        <!-- List Modul Terbaru / Aktif -->
        @if(in_array($dashboardView, ['overview', 'guru'], true))
        <div class="bg-white p-6 rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] shadow-[0_4px_0_#B2E7FC]">
            <div class="flex items-center justify-between mb-5 pb-3 border-b border-[#DCEFFF]">
                <h3 class="font-heading font-black text-[#082765] text-base flex items-center gap-2">
                    <span>📚</span> Modul Terbaru
                </h3>
                <a href="{{ route('admin.modul') }}" class="text-xs font-black text-[#007FBE] hover:text-[#00679A] hover:underline">Kelola Modul →</a>
            </div>

            <div class="space-y-3.5">
                @forelse($modulTerbaru ?? [] as $modul)
                    @php /** @var \App\Models\Modul $modul */ @endphp
                    <div class="flex items-center gap-3 p-3 rounded-2xl bg-[#F0F6FF]/60 border border-[#DCEFFF] hover:border-[#007FBE] hover:bg-[#F0F6FF] transition">
                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-[#DDF3FF] flex items-center justify-center shrink-0 border border-[#B2E7FC] relative">
                            @if($modul->foto_modul && Storage::disk('public')->exists($modul->foto_modul))
                                <img src="{{ Storage::url($modul->foto_modul) }}" alt="{{ $modul->judul_modul }}" class="w-full h-full object-cover">
                            @elseif($modul->youtube_id)
                                <img src="https://img.youtube.com/vi/{{ $modul->youtube_id }}/hqdefault.jpg" alt="{{ $modul->judul_modul }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/25 flex items-center justify-center">
                                    <div class="w-5 h-5 rounded-full bg-red-600 text-white flex items-center justify-center text-[9px] font-black pl-0.5 border border-white">▶</div>
                                </div>
                            @else
                                <div class="w-full h-full bg-[#DDF3FF] text-[#007FBE] flex items-center justify-center text-lg select-none">
                                    📖
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="text-xs sm:text-sm font-black text-[#082765] leading-tight truncate">{{ $modul->judul_modul }}</h4>
                            <p class="text-[11px] font-bold text-[#72839E] mt-0.5 truncate">{{ $modul->jenjang?->nama_jenjang ?? $modul->jenjang?->nama_tipe ?? 'Semua Jenjang' }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-xs font-bold text-[#72839E] text-center py-6">Belum ada modul tersedia.</p>
                @endforelse
            </div>
        </div>
        @endif

        @if($dashboardView === 'overview' && Auth::user()?->isAdmin())
            <div class="bg-white p-6 rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] shadow-[0_4px_0_#B2E7FC]">
                <div class="flex items-center justify-between mb-5 pb-3 border-b border-[#DCEFFF]">
                    <h3 class="font-heading font-black text-[#082765] text-base flex items-center gap-2">
                        <span>🕘</span> Log Aktivitas Terbaru
                    </h3>
                    <span class="text-[10px] font-black uppercase tracking-wide text-[#72839E] bg-[#F0F6FF] px-2.5 py-1 rounded-full">Terbaru</span>
                </div>

                <div class="space-y-3">
                    @if(!($logAktivitasTersedia ?? false))
                        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-center">
                            <p class="text-xs font-bold text-amber-800">Penyimpanan log aktivitas belum tersedia.</p>
                            <p class="text-[11px] text-amber-700 mt-1">Pastikan migrasi database sudah dijalankan.</p>
                        </div>
                    @else
                        @forelse($logAktivitasTerbaru ?? [] as $log)
                            <div class="flex items-start gap-3 p-3 rounded-2xl bg-[#F0F6FF]/60 border border-[#DCEFFF]">
                                <div class="w-9 h-9 rounded-xl bg-[#DDF3FF] text-[#007FBE] border border-[#B2E7FC] flex items-center justify-center font-black text-xs shrink-0">
                                    {{ strtoupper(substr($log->user?->nama ?? 'A', 0, 1)) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-bold text-[#082765] leading-relaxed">{{ $log->kegiatan }}</p>
                                    <p class="text-[10px] font-semibold text-[#72839E] mt-1 truncate">
                                        {{ $log->user?->nama ?? 'Pengguna' }} · {{ $log->waktu_kegiataan?->diffForHumans() ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-2xl mb-2">📝</p>
                                <p class="text-xs font-bold text-[#72839E]">Belum ada aktivitas tercatat.</p>
                                <p class="text-[11px] text-[#9AA8BC] mt-1">Aktivitas belajar dan pengelolaan akan muncul di sini.</p>
                            </div>
                        @endforelse
                    @endif
                </div>
            </div>
        @endif

    </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    (() => {
        const panel = document.getElementById('dashboard-panel');
        if (!panel) return;

        const tabs = Array.from(document.querySelectorAll('[data-dashboard-tab]'));
        const cachedPanels = new Map([[panel.dataset.loadedView, panel.innerHTML]]);
        let currentView = panel.dataset.loadedView;
        let requestVersion = 0;

        const setActiveTab = (view) => {
            tabs.forEach((tab) => {
                const active = tab.dataset.dashboardTab === view;
                tab.setAttribute('aria-current', active ? 'page' : 'false');
                tab.className = `flex-1 rounded-xl border px-4 py-3 transition sm:flex-none ${
                    active
                        ? 'border-[#007FBE] bg-[#DDF3FF] text-[#007FBE] shadow-[0_2px_0_#B2E7FC]'
                        : 'border-transparent text-[#465673] hover:border-[#DCEFFF] hover:bg-[#F0F6FF]'
                }`;
            });
        };

        const showError = (view) => {
            panel.innerHTML = `
                <div role="alert" class="rounded-2xl border border-rose-200 bg-rose-50 p-5 text-center">
                    <p class="text-sm font-bold text-rose-800">Tampilan gagal dimuat. Periksa koneksi lalu coba lagi.</p>
                    <button type="button" data-dashboard-retry class="mt-3 rounded-xl bg-rose-700 px-4 py-2 text-xs font-bold text-white hover:bg-rose-800">
                        Coba lagi
                    </button>
                </div>
            `;
            panel.querySelector('[data-dashboard-retry]')?.addEventListener('click', () => loadView(view, false));
        };

        const loadView = async (view, updateHistory = true) => {
            const tab = tabs.find((item) => item.dataset.dashboardTab === view);
            if (!tab) return;

            currentView = view;
            const version = ++requestVersion;
            setActiveTab(view);
            if (updateHistory) history.pushState({ dashboardView: view }, '', tab.href);

            if (cachedPanels.has(view)) {
                panel.innerHTML = cachedPanels.get(view);
                panel.dataset.loadedView = view;
                panel.setAttribute('aria-busy', 'false');
                return;
            }

            panel.setAttribute('aria-busy', 'true');
            panel.innerHTML = `
                <div class="space-y-4" role="status" aria-label="Memuat ringkasan">
                    <div class="h-28 animate-pulse rounded-2xl bg-white"></div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="h-48 animate-pulse rounded-2xl bg-white"></div>
                        <div class="h-48 animate-pulse rounded-2xl bg-white"></div>
                    </div>
                </div>
            `;

            try {
                const url = new URL(tab.href);
                url.searchParams.set('fragment', '1');
                const response = await fetch(url, {
                    headers: {
                        'Accept': 'text/html',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                });
                if (!response.ok) throw new Error(`Dashboard request failed (${response.status})`);

                const documentResponse = new DOMParser().parseFromString(await response.text(), 'text/html');
                const responsePanel = documentResponse.querySelector('#dashboard-panel');
                if (!responsePanel) throw new Error('Dashboard panel was not present in the response');

                cachedPanels.set(view, responsePanel.innerHTML);
                if (version === requestVersion && currentView === view) {
                    panel.innerHTML = responsePanel.innerHTML;
                    panel.dataset.loadedView = view;
                    panel.setAttribute('aria-busy', 'false');
                }
            } catch (error) {
                console.error('Unable to load dashboard view:', error);
                if (version === requestVersion && currentView === view) {
                    panel.setAttribute('aria-busy', 'false');
                    showError(view);
                }
            }
        };

        tabs.forEach((tab) => {
            tab.addEventListener('click', (event) => {
                event.preventDefault();
                loadView(tab.dataset.dashboardTab);
            });
        });

        window.addEventListener('popstate', () => {
            const requestedView = new URL(window.location.href).searchParams.get('view');
            const view = tabs.some((tab) => tab.dataset.dashboardTab === requestedView)
                ? requestedView
                : 'overview';
            loadView(view, false);
        });
    })();
</script>
@endpush

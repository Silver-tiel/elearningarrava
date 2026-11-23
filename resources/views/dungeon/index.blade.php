@extends(auth()->user()->isSiswa() ? 'layouts.siswa' : 'layouts.app')

@section('title', 'Pilih Dungeon - Petualangan Kuis Gamifikasi')

@section('header')
    <div class="flex items-center justify-between gap-4 w-full">
        <div class="min-w-0 hidden md:block">
            <h1 class="font-bold text-lg text-slate-800 leading-tight truncate">
                Dungeon Soal
            </h1>
            <p class="text-xs text-slate-500 truncate">
                Petualangan kuis gamifikasi & tantangan endless run
            </p>
        </div>
        <x-quiz-header-tabs />
    </div>
@endsection

@section('content')
    @php
        if (!function_exists('getDungeonMeta')) {
        function getDungeonMeta($namaMapel, $index)
        {
            $nama = strtolower($namaMapel);
            if (str_contains($nama, 'matematika')) {
                return [
                    'img' => asset('assets/dungeon/dungeon-sunset-crags.webp'),
                    'pos' => '42%',
                    'desc' => 'Hitung cepat, tebak pola, dan jaga hati terakhirmu. Makin dalam kamu turun, makin sulit angkanya.'
                ];
            } elseif (str_contains($nama, 'ipa') || str_contains($nama, 'alam')) {
                return [
                    'img' => asset('assets/dungeon/dungeon-sunset-cave.webp'),
                    'pos' => '58%',
                    'desc' => 'Dari sel sampai galaksi. Jawab sebelum waktu habis dan jangan biarkan cahaya terakhir padam.'
                ];
            } elseif (str_contains($nama, 'indonesia')) {
                return [
                    'img' => asset('assets/dungeon/dungeon-crystal-orange.webp'),
                    'pos' => '24%',
                    'desc' => 'Tata bahasa, kosakata, dan pemahaman bacaan di lorong yang berkilau dan makin gelap.'
                ];
            } elseif (str_contains($nama, 'inggris') || str_contains($nama, 'english')) {
                return [
                    'img' => asset('assets/dungeon/dungeon-crystal-purple.webp'),
                    'pos' => '68%',
                    'desc' => 'Vocabulary, grammar, dan reading. Satu jawaban salah, satu hati hilang.'
                ];
            } elseif (str_contains($nama, 'ips') || str_contains($nama, 'sosial')) {
                return [
                    'img' => asset('assets/dungeon/dungeon-crystal-blue.webp'),
                    'pos' => '50%',
                    'desc' => 'Sejarah, geografi, dan ekonomi menunggu di balik gerbang yang masih terkunci.'
                ];
            } elseif (str_contains($nama, 'pancasila') || str_contains($nama, 'pkn')) {
                return [
                    'img' => asset('assets/dungeon/dungeon-door.webp'),
                    'pos' => '50%',
                    'desc' => 'Uji integritas, wawasan kebangsaan, dan tekadmu menaklukkan lorong para ksatria.'
                ];
            } else {
                $pool = [
                    ['img' => asset('assets/dungeon/dungeon-sunset-crags.webp'), 'pos' => '42%'],
                    ['img' => asset('assets/dungeon/dungeon-sunset-cave.webp'), 'pos' => '58%'],
                    ['img' => asset('assets/dungeon/dungeon-crystal-orange.webp'), 'pos' => '24%'],
                    ['img' => asset('assets/dungeon/dungeon-crystal-purple.webp'), 'pos' => '68%'],
                    ['img' => asset('assets/dungeon/dungeon-crystal-blue.webp'), 'pos' => '50%'],
                    ['img' => asset('assets/dungeon/dungeon-door.webp'), 'pos' => '50%'],
                ];
                $item = $pool[$index % count($pool)];
                return [
                    'img' => $item['img'],
                    'pos' => $item['pos'],
                    'desc' => 'Taklukkan tantangan ' . $namaMapel . ', raih multiplier tertinggi dan capai lantai terdalam!'
                ];
            }
        }
        }

        if (!function_exists('parseMapelNames')) {
        function parseMapelNames($namaMapel)
        {
            $nama = trim($namaMapel);
            if (preg_match('/^(.*?)\s*\(([^)]+)\)$/', $nama, $m)) {
                return [
                    'short' => trim($m[2]),
                    'full' => trim($m[1])
                ];
            }
            return [
                'short' => $nama,
                'full' => $nama
            ];
        }
        }

        $dungeonItems = [];
        $activeInitialIdx = 0;

        foreach ($dungeonData as $i => $item) {
            $mapel = $item['mapel'];
            $status = $item['status'];
            $terbuka = $item['bisa_main'];
            $sesiAktif = $item['sesi_aktif'];
            $quizId = $item['quiz_id'];
            $meta = getDungeonMeta($mapel->nama_mapel, $i);
            $names = parseMapelNames($mapel->nama_mapel);

            if ($sesiAktif && $activeInitialIdx === 0) {
                $activeInitialIdx = $i;
            }

            $dungeonItems[] = [
                'id' => $mapel->id_mapel,
                'name' => $mapel->nama_mapel,
                'short_name' => $names['short'],
                'full_name' => $names['full'],
                'jenjang' => $selectedJenjang->nama_tipe ?? $selectedJenjang->nama_jenjang ?? 'SD',
                'desc' => $meta['desc'],
                'img' => $meta['img'],
                'pos' => $meta['pos'],
                'locked' => !$terbuka,
                'sesi_aktif' => (bool) $sesiAktif,
                'alasan' => $status['alasan'] ?? null,
                'need' => $status['alasan'] ?: 'Syarat soal belum cukup',
                'url' => route('dungeon.show', $mapel->id_mapel),
                'trial_url' => route('dungeon.show', ['mapel' => $mapel->id_mapel, 'uji_coba' => 1]),
                'editor_url' => $quizId ? route('admin.quiz.edit', $quizId) : route('admin.quiz.create'),
                'rekor' => $item['rekor_skor'] ?? 0,
                'lantai' => $item['lantai_tertinggi'] ?? 1,
                'total_soal' => $status['total_soal'] ?? 0,
                'mudah' => $status['mudah'] ?? 0,
                'sedang' => $status['sedang'] ?? 0,
                'sulit' => $status['sulit'] ?? 0,
                'has_quiz' => (bool) $quizId,
            ];
        }
    @endphp

    {{-- ======================================================== --}}
    {{-- 1. BACKGROUND LAYAR PENUH (Paling Belakang) --}}
    {{-- ======================================================== --}}
    <div class="dg-page-bg">
        <div class="dg-imgs" id="dungeonImgs">
            @foreach($dungeonItems as $idx => $d)
                <div class="{{ $idx === $activeInitialIdx ? 'on' : '' }}"
                    style="background-image: url('{{ $d['img'] }}'); --pos: {{ $d['pos'] }};"></div>
            @endforeach
        </div>
        {{-- Lapisan Gelap Transparan agar Teks & Tombol Terbaca Jelas --}}
        <div class="dg-bg-overlay"></div>
    </div>

    {{-- ======================================================== --}}
    {{-- 2. KONTEN UTAMA (Mengambang di Depan Background, z-10) --}}
    {{-- ======================================================== --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        {{-- Header Tombol Laporan / Peringkat / Riwayat --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5">
            <div class="flex items-center gap-2.5 flex-wrap">
                @if($isStaff)
                    <a href="{{ route('dungeon.admin.laporan') }}"
                        class="inline-flex items-center justify-center gap-1.5 bg-rose-50/90 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold text-xs px-3.5 py-2 rounded-xl shadow-[0_2px_0_#fecdd3] hover:-translate-y-0.5 transition backdrop-blur-xs">
                        <span>🚩</span>
                        <span>Laporan</span>
                        @if(!empty($pendingReportsCount) && $pendingReportsCount > 0)
                            <span
                                class="px-1.5 py-0.2 text-[10px] bg-rose-600 text-white rounded-full font-extrabold">{{ $pendingReportsCount }}</span>
                        @endif
                    </a>
                @else
                    <a href="{{ route('siswa.leaderboard') }}"
                        class="inline-flex items-center justify-center gap-1.5 bg-amber-50/90 hover:bg-amber-100 text-amber-800 border border-amber-200 font-bold text-xs px-3.5 py-2 rounded-xl shadow-[0_2px_0_#fde68a] hover:-translate-y-0.5 transition backdrop-blur-xs">
                        <span>🏆</span>
                        <span>Papan Peringkat</span>
                    </a>
                @endif
                <a href="{{ route('dungeon.riwayat') }}"
                    class="inline-flex items-center justify-center gap-1.5 bg-white/90 hover:bg-white text-[#465673] border border-[#DCEFFF] font-bold text-xs px-3.5 py-2 rounded-xl shadow-[0_2px_0_#DCEFFF] hover:-translate-y-0.5 transition backdrop-blur-xs">
                    <span>📜</span>
                    <span>Riwayat</span>
                </a>
            </div>
        </div>

        @if($isStaff)
            {{-- Filter Jenjang Khusus Guru & Admin --}}
            <div
                class="rounded-2xl border-2 border-[#DCEFFF]/80 bg-white/80 backdrop-blur-md p-3.5 sm:p-4 shadow-[0_3px_0_#DCEFFF] mb-6 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-2 overflow-x-auto pb-0.5 scrollbar-none">
                    <span class="text-xs font-black uppercase text-[#465673] mr-1 shrink-0">Jenjang:</span>
                    @foreach($jenjangList as $j)
                        @php
                            $isSelected = ($selectedJenjang->id_jenjang ?? 1) == $j->id_jenjang;
                        @endphp
                        <a href="{{ route('dungeon.index', ['jenjang' => $j->id_jenjang]) }}"
                            class="px-3.5 py-1.5 rounded-full text-xs font-black leading-tight transition-all select-none shrink-0 border no-underline inline-flex items-center gap-1 {{ $isSelected ? 'bg-[#007FBE] text-white border-[#007FBE] shadow-[0_2px_0_#005580]' : 'bg-white text-[#465673] border-[#DCEFFF] hover:bg-[#F0F6FF] shadow-xs' }}">
                            <span>🎓</span>
                            <span>{{ $j->nama_tipe ?? $j->nama_jenjang }}</span>
                        </a>
                    @endforeach
                </div>

                <div
                    class="text-xs font-extrabold text-[#007FBE] bg-white px-3 py-1 rounded-full border border-[#DCEFFF] shadow-xs">
                    Aktif: {{ $selectedJenjang->nama_tipe ?? $selectedJenjang->nama_jenjang }} ({{ count($dungeonItems) }}
                    Mapel)
                </div>
            </div>
        @endif

        @if(count($dungeonItems) === 0)
            <div
                class="py-16 text-center text-slate-400 bg-white/90 backdrop-blur-md rounded-3xl border border-dashed border-slate-300 shadow-sm">
                <div class="text-5xl mb-3">📭</div>
                <p class="font-bold text-lg text-slate-700">Belum ada mata pelajaran untuk jenjang ini.</p>
                <p class="text-xs text-slate-400 mt-1">Silakan pilih jenjang lain melalui tombol di atas.</p>
            </div>
        @else
            {{-- Baris Tabs Horizontal --}}
            <nav class="dg-tabs" id="dungeonTabs" role="tablist" aria-label="Dungeon">
                @foreach($dungeonItems as $idx => $d)
                    <button type="button"
                        class="dg-tab {{ $idx === $activeInitialIdx ? 'on' : '' }} {{ $d['locked'] ? 'locked' : '' }}" role="tab"
                        aria-selected="{{ $idx === $activeInitialIdx ? 'true' : 'false' }}" data-idx="{{ $idx }}"
                        title="{{ $d['name'] }}" onclick="focusDungeon({{ $idx }})">
                        <span class="th" style="background-image: url('{{ $d['img'] }}'); --pos: {{ $d['pos'] }};"></span>
                        <span class="nm">{{ $d['short_name'] }}</span>
                        @if($d['locked'])
                            <svg class="w-3.5 h-3.5 text-slate-800 shrink-0" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                <path d="M4 7V5a4 4 0 0 1 8 0v2h1v8H3V7h1zm2 0h4V5a2 2 0 0 0-4 0v2z" />
                            </svg>
                        @endif
                    </button>
                @endforeach
            </nav>

            {{-- Area Konten Teks & Tombol Mulai (Langsung Melayang di Atas Background) --}}
            <section class="dg-hero-flat" id="dungeonHero">
                <div class="dg-info" id="dungeonInfo" aria-live="polite">
                    <h2 class="dg-title" id="dungeonTitle">{{ $dungeonItems[$activeInitialIdx]['short_name'] }}</h2>
                    <p class="dg-fullname {{ $dungeonItems[$activeInitialIdx]['short_name'] === $dungeonItems[$activeInitialIdx]['full_name'] ? 'hidden' : '' }}"
                        id="dungeonFullName">
                        {{ $dungeonItems[$activeInitialIdx]['full_name'] }}
                    </p>
                    <p class="dg-jenjang" id="dungeonJenjang">
                        @if($dungeonItems[$activeInitialIdx]['locked'])
                            <span class="inline-flex items-center gap-1.5 text-amber-300 font-bold">
                                <svg class="w-4 h-4 shrink-0" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="M4 7V5a4 4 0 0 1 8 0v2h1v8H3V7h1zm2 0h4V5a2 2 0 0 0-4 0v2z" />
                                </svg>
                                <span>Belum dibuka · {{ $dungeonItems[$activeInitialIdx]['need'] }}</span>
                            </span>
                        @else
                            <span class="font-extrabold text-sky-200">Jenjang
                                {{ $dungeonItems[$activeInitialIdx]['jenjang'] }}</span>
                        @endif
                    </p>

                    <p class="dg-desc" id="dungeonDesc">
                        {{ $dungeonItems[$activeInitialIdx]['desc'] }}
                    </p>

                    {{-- Rekor & Stat Ringkas --}}
                    <div id="dungeonStatsPills" class="flex items-center gap-2 mb-6 flex-wrap">
                        <span
                            class="px-3 py-1 rounded-full bg-black/50 backdrop-blur-md border border-white/20 text-white text-xs font-bold">
                            ❤️ 3 Nyawa
                        </span>
                        <span
                            class="px-3 py-1 rounded-full bg-black/50 backdrop-blur-md border border-white/20 text-sky-200 text-xs font-bold">
                            ⚡ Multiplier 3.0x
                        </span>
                        <span id="pillRekor"
                            class="px-3 py-1 rounded-full bg-black/50 backdrop-blur-md border border-amber-300/40 text-amber-300 text-xs font-bold {{ $dungeonItems[$activeInitialIdx]['rekor'] > 0 ? '' : 'hidden' }}">
                            🏆 Rekor: <b
                                id="textRekor">{{ number_format($dungeonItems[$activeInitialIdx]['rekor'], 0, ',', '.') }}</b>
                        </span>
                        <span id="pillLantai"
                            class="px-3 py-1 rounded-full bg-black/50 backdrop-blur-md border border-sky-300/40 text-sky-300 text-xs font-bold {{ $dungeonItems[$activeInitialIdx]['lantai'] > 1 ? '' : 'hidden' }}">
                            🪜 Lt. <b id="textLantai">{{ $dungeonItems[$activeInitialIdx]['lantai'] }}</b>
                        </span>
                    </div>

                    {{-- Tombol Aksi Utama --}}
                    <div class="flex items-center gap-3 flex-wrap">
                        <a id="dungeonStart"
                            href="{{ $dungeonItems[$activeInitialIdx]['locked'] ? 'javascript:void(0)' : $dungeonItems[$activeInitialIdx]['url'] }}"
                            class="dg-start {{ $dungeonItems[$activeInitialIdx]['locked'] ? 'locked' : '' }}">
                            <span id="dungeonStText">
                                @if($dungeonItems[$activeInitialIdx]['locked'])
                                    Terkunci
                                @elseif($dungeonItems[$activeInitialIdx]['sesi_aktif'])
                                    ⚔️ Lanjutkan Petualangan
                                @else
                                    Mulai
                                @endif
                            </span>
                        </a>

                        @if($isStaff)
                            <a id="dungeonTrialBtn" href="{{ $dungeonItems[$activeInitialIdx]['trial_url'] }}"
                                class="inline-flex items-center gap-1.5 px-4 py-3 rounded-full border-2 border-white/70 bg-white/20 hover:bg-white/30 text-white font-display font-bold text-sm backdrop-blur-md transition shadow-sm select-none">
                                <span>🛠️ Uji Coba Staff</span>
                            </a>
                            <a id="dungeonEditorBtn" href="{{ $dungeonItems[$activeInitialIdx]['editor_url'] }}"
                                class="inline-flex items-center gap-1.5 px-4 py-3 rounded-full border-2 border-white/70 bg-white/20 hover:bg-white/30 text-white font-display font-bold text-sm backdrop-blur-md transition shadow-sm select-none">
                                <span>📝 Kelola Soal</span>
                            </a>
                            <button type="button" id="dungeonImportBtn" onclick="openImportCurrentModal()"
                                class="inline-flex items-center gap-1.5 px-4 py-3 rounded-full border-2 border-white/70 bg-white/20 hover:bg-white/30 text-white font-display font-bold text-sm backdrop-blur-md transition shadow-sm select-none cursor-pointer">
                                <span>📥 Impor Kuis</span>
                            </button>
                        @endif
                    </div>
                </div>
            </section>
        @endif
    </div>

    {{-- Toast Notifikasi untuk Tombol Terkunci --}}
    <div id="dgToast"
        class="fixed left-1/2 bottom-8 -translate-x-1/2 bg-[#0f3a5f] text-white font-bold text-sm px-5 py-3 rounded-2xl shadow-2xl border-2 border-white/20 opacity-0 pointer-events-none transition-all duration-300 z-50 max-w-[90vw] text-center">
    </div>

    @if($isStaff)
        <!-- Modal Impor Soal dari Kuis Biasa ke Dungeon -->
        <div id="importModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 hidden">
            <div
                class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700 relative animate-in fade-in zoom-in-95 duration-150">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-700 mb-4">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">📥</span>
                        <div>
                            <h3 class="font-extrabold text-base text-slate-900 dark:text-white" id="modalMapelTitle">
                                Impor Soal ke Dungeon
                            </h3>
                            <p class="text-xs text-slate-400">Salin soal dari kuis biasa yang sudah ada ke kuis Dungeon</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeImportModal()"
                        class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 font-bold flex items-center justify-center cursor-pointer">
                        ✕
                    </button>
                </div>

                <form id="importForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="id_jenjang" value="{{ $selectedJenjang->id_jenjang ?? 1 }}">

                    <div class="space-y-4 text-xs">
                        <div>
                            <label class="block font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                Pilih Kuis Biasa Sumber:
                            </label>
                            <select id="modalQuizSelect" name="id_quiz_asal" required
                                class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2.5 text-xs font-semibold text-slate-800 dark:text-white focus:ring-2 focus:ring-[#007FBE] transition">
                                <option value="">-- Pilih Kuis --</option>
                            </select>
                            <p id="modalEmptyNotice" class="text-xs text-rose-500 mt-1.5 hidden font-semibold">
                                ⚠️ Belum ada kuis biasa untuk mapel ini di jenjang ini.
                            </p>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                Tingkat Kesulitan untuk Soal yang Diimpor:
                            </label>
                            <select name="tingkat_soal" required
                                class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2.5 text-xs font-semibold text-slate-800 dark:text-white focus:ring-2 focus:ring-[#007FBE] transition">
                                <option value="otomatis" selected>⚡ Otomatis (Mengikuti Tingkat Kuis Asal)</option>
                                <option value="mudah">🟢 Semua Dijadikan Tingkat Mudah (20 Detik)</option>
                                <option value="sedang">🟡 Semua Dijadikan Tingkat Sedang (30 Detik)</option>
                                <option value="sulit">🔴 Semua Dijadikan Tingkat Sulit (60 Detik)</option>
                            </select>
                            <p class="text-[11px] text-slate-400 mt-1">
                                *Catatan: Sesuai aturan Dungeon, soal Benar/Salah akan otomatis disesuaikan ke tingkat Mudah.
                            </p>
                        </div>

                        <div
                            class="p-3 rounded-xl bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800 text-slate-800 dark:text-blue-200 text-xs">
                            💡 <strong>Tips:</strong> Sistem otomatis menduplikasi soal dan pilihan jawabannya. Jika soal yang
                            sama persis sudah ada di Dungeon, soal tersebut otomatis dilewati agar tidak terjadi duplikasi.
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-2.5">
                        <button type="button" onclick="closeImportModal()"
                            class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" id="btnSubmitImport"
                            class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#007FBE] hover:bg-[#00689E] shadow-[0_3px_0_#005580] transition cursor-pointer">
                            📥 Salin Soal ke Dungeon
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- CSS KHUSUS TAMPILAN BACKGROUND DUNGEON & TABS --}}
    <style>
        /* 1. Background Menutupi Seluruh Layar (Fixed Inset-0) */
        .dg-page-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .dg-imgs {
            position: absolute;
            inset: 0;
        }

        .dg-imgs div {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: var(--pos, 50%) 50%;
            opacity: 0;
            transform: scale(1.05);
            transition: opacity .6s ease, transform .9s cubic-bezier(.2, .7, .2, 1);
        }

        .dg-imgs div.on {
            opacity: 1;
            transform: none;
        }

        .dg-imgs.locked div {
            filter: grayscale(.85) brightness(.75);
        }

        /* 2. Overlay Gradien Gelap Transparan */
        .dg-bg-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg,
                    rgba(6, 18, 38, 0.70) 0%,
                    rgba(8, 22, 46, 0.85) 50%,
                    rgba(5, 14, 30, 0.96) 100%);
        }

        /* 3. Baris Tabs Horizontal */
        .dg-tabs {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            scrollbar-width: none;
            padding: 6px 4px 18px;
        }

        .dg-tabs::-webkit-scrollbar {
            display: none;
        }

        .dg-tab {
            position: relative;
            flex: 0 0 auto;
            min-width: 140px;
            max-width: 220px;
            height: 56px;
            border: 3px solid #10315a;
            border-radius: 16px;
            padding: 0 16px;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 8px;
            text-align: left;
            cursor: pointer;
            background: #ffffff;
            color: #10315a;
            font-family: "Fredoka", "Plus Jakarta Sans", system-ui, sans-serif;
            font-weight: 600;
            font-size: 15px;
            box-shadow: 0 4px 0 #10315a;
            transition: transform .15s, box-shadow .15s, background .2s;
            user-select: none;
        }

        .dg-tab:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 0 #10315a;
        }

        .dg-tab .th {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 44%;
            background-size: cover;
            background-position: var(--pos, 50%) 50%;
            opacity: .55;
            -webkit-mask-image: linear-gradient(90deg, transparent, #000 60%);
            mask-image: linear-gradient(90deg, transparent, #000 60%);
        }

        .dg-tab .nm {
            position: relative;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 130px;
            z-index: 2;
        }

        .dg-tab svg {
            position: relative;
            width: 14px;
            height: 14px;
            flex: none;
            z-index: 2;
        }

        .dg-tab.on {
            background: linear-gradient(180deg, #1488e6, #0b69c4);
            color: #ffffff;
            transform: translateY(2px);
            box-shadow: 0 2px 0 #10315a;
        }

        .dg-tab.on .th {
            opacity: 1;
        }

        .dg-tab.locked .th {
            filter: grayscale(.9);
        }

        .dg-tab:focus-visible,
        .dg-start:focus-visible {
            outline: 3px solid #f5a623;
            outline-offset: 3px;
        }

        /* 4. Area Hero/Info Tanpa Border Kotak */
        .dg-hero-flat {
            position: relative;
            padding: clamp(24px, 4vw, 44px) 0 clamp(32px, 5vw, 60px);
            min-height: clamp(340px, 48vh, 520px);
            display: flex;
            align-items: flex-end;
        }

        .dg-info {
            position: relative;
            max-width: min(680px, 100%);
        }

        .dg-title {
            margin: 0;
            font-family: "Fredoka", "Plus Jakarta Sans", system-ui, sans-serif;
            font-weight: 700;
            line-height: 1.15;
            font-size: clamp(28px, 4vw, 50px);
            color: #ffffff;
            text-shadow: 0 3px 0 #0b2447, 0 0 16px rgba(8, 28, 60, .6);
            word-break: break-word;
        }

        .dg-fullname {
            margin: 4px 0 0;
            font-size: clamp(14px, 1.3vw, 17px);
            font-weight: 700;
            color: #bde0fe;
            text-shadow: 0 1px 4px rgba(0, 0, 0, .5);
        }

        .dg-jenjang {
            margin: 8px 0 0;
            font-weight: 800;
            font-size: clamp(13px, 1.3vw, 16px);
            color: #cfe6ff;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dg-desc {
            margin: 12px 0 18px;
            max-width: 48ch;
            font-weight: 600;
            font-size: clamp(14px, 1.25vw, 16px);
            line-height: 1.5;
            color: #e2edff;
            text-shadow: 0 1px 6px rgba(0, 0, 0, .6);
        }

        .dg-start {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 3px solid #0b2447;
            border-radius: 999px;
            padding: 10px 36px;
            cursor: pointer;
            background: linear-gradient(180deg, #2aa0ff, #0b69c4);
            color: #ffffff;
            font-family: "Fredoka", "Plus Jakarta Sans", system-ui, sans-serif;
            font-weight: 700;
            font-size: clamp(16px, 1.8vw, 20px);
            box-shadow: 0 5px 0 #0b2447;
            transition: transform .12s, box-shadow .12s, filter .15s;
            text-decoration: none;
            user-select: none;
        }

        .dg-start:hover {
            filter: brightness(1.08);
        }

        .dg-start:active {
            transform: translateY(3px);
            box-shadow: 0 2px 0 #0b2447;
        }

        .dg-start.locked {
            background: #cfd9e6;
            color: #5f7290;
            cursor: not-allowed;
            box-shadow: 0 3px 0 #0b2447;
        }

        @media (max-width: 700px) {
            .dg-tab {
                flex-basis: 150px;
                font-size: 16px;
            }
        }
    </style>

    {{-- JAVASCRIPT INTERAKSI PILIH DUNGEON --}}
    <script>
        const dungeonData = @json($dungeonItems);
        let currentIdx = {{ $activeInitialIdx }};
        const LOCK_ICON = '<svg class="w-4 h-4 shrink-0" viewBox="0 0 16 16" fill="currentColor"><path d="M4 7V5a4 4 0 0 1 8 0v2h1v8H3V7h1zm2 0h4V5a2 2 0 0 0-4 0v2z"/></svg>';

        function focusDungeon(idx) {
            if (!dungeonData || idx < 0 || idx >= dungeonData.length) return;
            currentIdx = idx;
            const d = dungeonData[idx];

            // 1. Update status aktif pada tab
            const tabEls = document.querySelectorAll('#dungeonTabs .dg-tab');
            tabEls.forEach((el, i) => {
                el.classList.toggle('on', i === idx);
                el.setAttribute('aria-selected', i === idx ? 'true' : 'false');
            });

            // 2. Transisi crossfade gambar background
            const imgEls = document.querySelectorAll('#dungeonImgs div');
            imgEls.forEach((el, i) => {
                el.classList.toggle('on', i === idx);
            });

            // 3. Efek grayscale jika dungeon terkunci
            const heroImgs = document.getElementById('dungeonImgs');
            if (heroImgs) {
                heroImgs.classList.toggle('locked', !!d.locked);
            }

            // 4. Update Judul, Nama Lengkap, Jenjang, dan Deskripsi
            document.getElementById('dungeonTitle').textContent = d.short_name || d.name;
            const fullNameEl = document.getElementById('dungeonFullName');
            if (fullNameEl) {
                if (d.short_name && d.full_name && d.short_name !== d.full_name) {
                    fullNameEl.textContent = d.full_name;
                    fullNameEl.classList.remove('hidden');
                } else {
                    fullNameEl.classList.add('hidden');
                }
            }
            const jenjangEl = document.getElementById('dungeonJenjang');
            if (d.locked) {
                jenjangEl.innerHTML = `<span class="inline-flex items-center gap-1.5 text-amber-300 font-bold">
                                    ${LOCK_ICON}
                                    <span>Belum dibuka · ${d.need}</span>
                                </span>`;
            } else {
                jenjangEl.innerHTML = `<span class="font-extrabold text-sky-200">Jenjang ${d.jenjang}</span>`;
            }

            document.getElementById('dungeonDesc').textContent = d.desc;

            // 5. Update Rekor & Lantai Pills
            const pillRekor = document.getElementById('pillRekor');
            const textRekor = document.getElementById('textRekor');
            if (pillRekor && textRekor) {
                if (d.rekor > 0) {
                    textRekor.textContent = Number(d.rekor).toLocaleString('id-ID');
                    pillRekor.classList.remove('hidden');
                } else {
                    pillRekor.classList.add('hidden');
                }
            }

            const pillLantai = document.getElementById('pillLantai');
            const textLantai = document.getElementById('textLantai');
            if (pillLantai && textLantai) {
                if (d.lantai > 1) {
                    textLantai.textContent = d.lantai;
                    pillLantai.classList.remove('hidden');
                } else {
                    pillLantai.classList.add('hidden');
                }
            }

            // 6. Update Tombol Mulai
            const startBtn = document.getElementById('dungeonStart');
            const startText = document.getElementById('dungeonStText');
            startBtn.classList.toggle('locked', !!d.locked);

            if (d.locked) {
                startText.textContent = 'Terkunci';
                startBtn.href = 'javascript:void(0)';
            } else if (d.sesi_aktif) {
                startText.textContent = '⚔️ Lanjutkan Petualangan';
                startBtn.href = d.url;
            } else {
                startText.textContent = 'Mulai';
                startBtn.href = d.url;
            }

            // Update tombol tambahan untuk staff
            @if($isStaff)
                const trialBtn = document.getElementById('dungeonTrialBtn');
                if (trialBtn) trialBtn.href = d.trial_url;

                const editorBtn = document.getElementById('dungeonEditorBtn');
                if (editorBtn) editorBtn.href = d.editor_url;
            @endif

                // 7. Animasi halus teks masuk dari samping
                const infoEl = document.getElementById('dungeonInfo');
            if (infoEl && typeof infoEl.animate === 'function') {
                infoEl.animate([
                    { opacity: 0, transform: 'translateX(-18px)' },
                    { opacity: 1, transform: 'none' }
                ], { duration: 320, easing: 'cubic-bezier(.2,.7,.2,1)' });
            }

            // 8. Auto scroll tab aktif ke tengah layar
            if (tabEls[idx]) {
                tabEls[idx].scrollIntoView({ block: 'nearest', inline: 'center', behavior: 'smooth' });
            }
        }

        // Animasi shake jika tombol terkunci diklik
        document.getElementById('dungeonStart')?.addEventListener('click', function (e) {
            if (!dungeonData || !dungeonData[currentIdx]) return;
            const d = dungeonData[currentIdx];
            if (d.locked) {
                e.preventDefault();
                if (typeof this.animate === 'function') {
                    this.animate([
                        { transform: 'translateX(0)' },
                        { transform: 'translateX(-8px)' },
                        { transform: 'translateX(8px)' },
                        { transform: 'translateX(-5px)' },
                        { transform: 'translateX(0)' }
                    ], { duration: 320 });
                }
                showDgToast(`Pintu dungeon masih terkunci: ${d.need}`);
            }
        });

        // Toast sederhana
        let toastTimer;
        function showDgToast(msg) {
            const toast = document.getElementById('dgToast');
            if (!toast) return;
            toast.textContent = msg;
            toast.classList.remove('opacity-0', 'pointer-events-none');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => {
                toast.classList.add('opacity-0', 'pointer-events-none');
            }, 2200);
        }

        // Navigasi Keyboard (Panah Kiri & Kanan)
        document.addEventListener('keydown', function (e) {
            if (e.target && (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.tagName === 'SELECT')) {
                return;
            }
            if (e.key === 'ArrowRight') {
                focusDungeon(currentIdx + 1);
                e.preventDefault();
            } else if (e.key === 'ArrowLeft') {
                focusDungeon(currentIdx - 1);
                e.preventDefault();
            }
        });

        // Dukungan Swipe Sentuhan di Layar Hero (Mobile / Tablet)
        let touchStartX = null;
        const heroEl = document.getElementById('dungeonHero');
        if (heroEl) {
            heroEl.addEventListener('touchstart', e => {
                touchStartX = e.touches[0].clientX;
            }, { passive: true });

            heroEl.addEventListener('touchend', e => {
                if (touchStartX === null) return;
                const dx = e.changedTouches[0].clientX - touchStartX;
                touchStartX = null;
                if (Math.abs(dx) > 50) {
                    focusDungeon(currentIdx + (dx < 0 ? 1 : -1));
                }
            });
        }

        @if($isStaff)
            function openImportCurrentModal() {
                const d = dungeonData[currentIdx];
                if (d && typeof openImportModal === 'function') {
                    openImportModal(d.id, d.name);
                }
            }

            const regularQuizzesData = @json($regularQuizzesByMapel ?? []);

            function openImportModal(mapelId, namaMapel) {
                const modal = document.getElementById('importModal');
                const form = document.getElementById('importForm');
                const title = document.getElementById('modalMapelTitle');
                const select = document.getElementById('modalQuizSelect');
                const emptyNotice = document.getElementById('modalEmptyNotice');
                const submitBtn = document.getElementById('btnSubmitImport');

                title.textContent = `Impor Soal ke Dungeon ${namaMapel}`;
                form.action = `/dungeon/${mapelId}/impor`;

                select.innerHTML = '<option value="">-- Pilih Kuis Sumber --</option>';
                const quizzes = regularQuizzesData[mapelId] || [];

                if (quizzes.length === 0) {
                    emptyNotice.classList.remove('hidden');
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    emptyNotice.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');

                    quizzes.forEach(q => {
                        const opt = document.createElement('option');
                        opt.value = q.id_quiz;
                        opt.textContent = `${q.judul} (${q.total_soal} Soal - Tingkat: ${q.tingkat})`;
                        select.appendChild(opt);
                    });
                }

                modal.classList.remove('hidden');
            }

            function closeImportModal() {
                document.getElementById('importModal').classList.add('hidden');
            }
        @endif
    </script>
@endsection
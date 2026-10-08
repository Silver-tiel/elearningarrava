<div class="min-h-screen bg-slate-100 p-6 font-sans text-slate-800">

    {{-- Topbar / Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-slate-800">
            Dashboard Utama
        </h1>

        <div class="flex items-center gap-4">

            {{-- Language Selector --}}
            <div class="flex items-center gap-1 text-sm text-slate-600 bg-white px-3 py-1.5 rounded-lg border border-slate-200">
                <i class="fa-solid font-bold text-base">🌐</i>
                <span class="font-medium">ID</span>
                <i class="fa-solid fa-chevron-down text-xs ml-1"></i>
            </div>

            {{-- User Profile --}}
            <button
                onclick="openEditModal()"
                class="flex items-center gap-3 bg-white p-1.5 pr-4 rounded-full border border-slate-200 hover:bg-slate-50 transition"
            >
                <img
                    src="{{ auth()->user()->avatar
                        ? asset('storage/' . auth()->user()->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                    alt="Avatar"
                    class="w-10 h-10 rounded-full object-cover"
                >

                <div class="text-left">
                    <h4 class="text-sm font-bold leading-tight text-slate-800">
                        {{ auth()->user()->name }}
                    </h4>

                    <p class="text-xs text-slate-500">
                        {{ auth()->user()->kelas }}
                    </p>
                </div>
            </button>

        </div>
    </div>


    {{-- Main Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left & Middle Column --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Banner Welcome --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 text-white relative overflow-hidden shadow-lg shadow-blue-500/10 flex justify-between items-center">

                <div class="max-w-md z-10">

                    <h2 class="text-2xl font-bold mb-2">
                        Halo, {{ auth()->user()->name }}! 👋
                    </h2>

                </div>

                <div class="hidden sm:block z-10">
                    <img
                        src="{{ asset('images/banner-illustration.png') }}"
                        alt="Ilustrasi"
                        class="w-36 h-36 object-contain rounded-xl"
                    >
                </div>

            </div>


            {{-- Stat Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                {{-- Streak --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-sm">

                    <span class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                        Hari Streak
                    </span>

                    <h3 class="text-xl font-extrabold text-slate-800 mt-1">
                        {{ auth()->user()->streak }} Hari
                    </h3>

                    <span class="inline-block mt-2 px-2 py-0.5 bg-amber-100 text-amber-700 text-[11px] font-semibold rounded">
                        Konsisten belajar!
                    </span>

                </div>


                {{-- XP Hari Ini --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-sm">

                    <span class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                        Poin XP
                    </span>

                    <h3 class="text-xl font-extrabold text-slate-800 mt-1">
                        +{{ $total_poin }} XP
                    </h3>

                    <span class="inline-block mt-2 text-blue-600 text-[11px] font-semibold">
                        XP diperoleh hari ini
                    </span>

                </div>


                {{-- Persentase Belajar --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-sm">

                    <span class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                        Persentase Belajar
                    </span>

                    <h3 class="text-xl font-extrabold text-slate-800 mt-1">
                        {{ $progressPercentage }}%
                    </h3>

                    <span class="inline-block mt-2 px-2 py-0.5 bg-emerald-100 text-emerald-700 text-[11px] font-semibold rounded">
                        Sangat baik
                    </span>

                </div>


                {{-- Total XP --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-sm">

                    <span class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                        Total XP Akumulatif
                    </span>

                    <h3 class="text-xl font-extrabold text-slate-800 mt-1">
                        {{ number_format(auth()->user()->total_xp) }} XP
                    </h3>

                    <span class="inline-block mt-2 text-rose-500 text-[11px] font-semibold">
                        Level {{ auth()->user()->level }} • Smart Learner
                    </span>

                </div>

            </div>


            {{-- Progress Pembelajaran --}}
            @if($currentCourse)

                <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm flex items-center justify-between">

                    <div class="flex items-center gap-4 w-full">

                        <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                            <i class="fa-solid fa-book-open text-xl"></i>
                        </div>

                        <div class="w-full">

                            <div class="flex justify-between items-center mb-1">

                                <h4 class="font-bold text-slate-800">
                                    {{ $currentCourse->nama_matpel }}
                                </h4>

                                <span class="text-xs font-semibold text-blue-600">
                                    Materi: {{ $currentCourse->materi_aktif }}
                                </span>

                            </div>

                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden my-1">

                                <div
                                    class="bg-blue-600 h-full rounded-full"
                                    style="width: {{ $currentCourse->progress }}%"
                                ></div>

                            </div>

                            <div class="flex justify-between text-xs text-slate-400 font-medium">

                                <span>
                                    Progress:
                                    Bab {{ $currentCourse->bab_aktif }}
                                    dari {{ $currentCourse->total_bab }}
                                </span>

                                <span>
                                    {{ $currentCourse->progress }}% Selesai
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            @endif


            {{-- Modul Pelajaran --}}
            <div>

                <h3 class="text-base font-bold text-slate-800 mb-3">
                    Modul Pelajaran
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    @forelse($moduls as $modul)

                        <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-sm flex flex-col justify-between">

                            <div>

                                <div class="flex justify-between items-center mb-3">

                                    <span class="p-2 bg-slate-50 rounded-lg text-blue-600">
                                        <i class="fa-solid fa-file-lines"></i>
                                    </span>

                                    <span class="text-xs text-slate-400 font-medium">
                                        {{ $modul->jam }}
                                    </span>

                                </div>

                                <h4 class="font-bold text-slate-800">
                                    {{ $modul->nama_pelajaran }}
                                </h4>

                                <p class="text-xs text-slate-400 mt-0.5">
                                    Tutor: {{ $modul->nama_tutor }}
                                </p>

                            </div>

                            <a
                                href="{{ route('materi.show', $modul->id) }}"
                                class="mt-4 w-full py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded-lg text-center transition"
                            >
                                Mulai Belajar
                            </a>

                        </div>

                    @empty

                        <p class="text-xs text-slate-400 col-span-3">
                            Tidak ada jadwal modul hari ini.
                        </p>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- Right Column --}}
        <div class="space-y-6">

            {{-- Latihan Soal --}}
            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm">

                <h3 class="text-base font-bold text-slate-800 mb-4">
                    Latihan Soal
                </h3>

                <div class="space-y-4">

                    @forelse($latihanSoal as $item)

                        <div class="flex justify-between items-center border-b border-slate-100 pb-3 last:border-0 last:pb-0">

                            <div>

                                <h5 class="text-sm font-bold text-slate-800">
                                    {{ $item->judul }}
                                </h5>

                                <p class="text-xs text-slate-400">
                                    {{ $item->mata_pelajaran }}
                                </p>

                            </div>

                            <span class="px-2 py-1 text-[10px] font-semibold rounded-full {{ $item->sisa_waktu_color }}">
                                {{ $item->sisa_waktu }}
                            </span>

                        </div>

                    @empty

                        <p class="text-xs text-slate-400">
                            Belum ada latihan soal.
                        </p>

                    @endforelse

                </div>

            </div>


            {{-- Pencapaian Terbaru --}}
            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm">

                <h3 class="text-base font-bold text-slate-800 mb-4">
                    Pencapaian Terbaru
                </h3>

                <div class="grid grid-cols-3 gap-2 text-center">

                    @forelse($achievements as $badge)

                        <div class="flex flex-col items-center">

                            <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-xl mb-1">
                                {!! $badge->icon !!}
                            </div>

                            <span class="text-xs font-semibold text-slate-700">
                                {{ $badge->nama }}
                            </span>

                        </div>

                    @empty

                        <p class="text-xs text-slate-400 col-span-3">
                            Belum ada badge.
                        </p>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>


{{-- MODAL EDIT PROFIL --}}
<div
    id="editProfileModal"
    class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4"
>

    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl relative">

        <div class="flex justify-between items-center mb-4">

            <h3 class="text-lg font-bold text-slate-800">
                Edit Profil Siswa
            </h3>

            <button
                onclick="closeEditModal()"
                class="text-slate-400 hover:text-slate-600"
            >
                &times;
            </button>

        </div>


        <form
            action="{{ route('siswa.profil.update') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-4"
        >

            @csrf
            @method('PUT')


            {{-- Foto Profil --}}
            <div>

                <label class="block text-xs font-semibold text-slate-600 mb-1">
                    Foto Profil
                </label>

                <input
                    type="file"
                    name="avatar"
                    class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                >

            </div>


            {{-- Nama Lengkap --}}
            <div>

                <label class="block text-xs font-semibold text-slate-600 mb-1">
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ auth()->user()->name }}"
                    required
                    class="w-full text-sm border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:border-blue-500"
                >

            </div>


            {{-- Email --}}
            <div>

                <label class="block text-xs font-semibold text-slate-400 mb-1">
                    Email (Tidak dapat diubah)
                </label>

                <input
                    type="email"
                    value="{{ auth()->user()->email }}"
                    readonly
                    class="w-full text-sm border border-slate-200 bg-slate-100 text-slate-500 rounded-lg p-2.5 cursor-not-allowed focus:outline-none"
                >

            </div>


            {{-- Nomor HP --}}
            <div>

                <label class="block text-xs font-semibold text-slate-600 mb-1">
                    Nomor HP / WhatsApp
                </label>

                <input
                    type="text"
                    name="no_hp"
                    value="{{ auth()->user()->no_hp }}"
                    placeholder="08xxxxxxxxxx"
                    class="w-full text-sm border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:border-blue-500"
                >

            </div>


            {{-- Kelas --}}
            <div>

                <label class="block text-xs font-semibold text-slate-600 mb-1">
                    Kelas
                </label>

                <input
                    type="text"
                    name="kelas"
                    value="{{ auth()->user()->kelas }}"
                    placeholder="Siswa Kelas 10"
                    class="w-full text-sm border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:border-blue-500"
                >

            </div>


            {{-- Tombol --}}
            <div class="flex justify-end gap-2 pt-2">

                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold hover:bg-slate-200"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>


<script>

    function openEditModal() {
        document
            .getElementById('editProfileModal')
            .classList.remove('hidden');
    }

    function closeEditModal() {
        document
            .getElementById('editProfileModal')
            .classList.add('hidden');
    }

</script>
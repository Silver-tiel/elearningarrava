@extends('layouts.app') {{-- Sesuaikan dengan nama layout utama Anda yang sudah ada sidebar-nya --}}

@section('content')
    <div class="flex-1 flex flex-col h-screen overflow-hidden">

        <!-- Header Atas -->
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-900">Detail Modul: {{ $modul->judul_modul }}</h1>
                <p class="text-xs text-gray-500 mt-0.5">
                    {{ optional($modul->jenjang)->nama_tipe ?? 'Umum' }} &bull;
                    Kategori: {{ optional($modul->tipeModul)->nama_tipe ?? 'Materi' }}
                </p>
            </div>
            @if(auth()->check() && in_array(auth()->user()->id_tipeuser, [1, 2]))
                <a href="{{ route('admin.modul') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    &larr; Kembali
                </a>
            @else
                <a href="{{ route('siswa.modul') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    &larr; Kembali
                </a>
            @endif
        </header>

        <!-- Area Tampilan Konten di Tengah -->
        <main class="flex-1 p-6 flex flex-col items-center justify-center overflow-hidden">
            <div
                class="w-full max-w-4xl h-full bg-white border border-gray-200 rounded-xl shadow-sm flex flex-col overflow-hidden">

                <!-- Bar Informasi Dokumen / Video -->
                <div
                    class="bg-gray-50 px-6 py-3 border-b border-gray-200 flex justify-between items-center text-xs text-gray-500 font-medium">
                    @if($modul->youtube_embed_url)
                        <span class="flex items-center gap-1.5 text-blue-600 font-semibold">
                            <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                            Video Pembelajaran YouTube
                        </span>
                        <span id="scroll-status"
                            class="text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                            ▶ Tonton video untuk menyelesaikan materi
                        </span>
                    @else
                        <span>File Materi: <strong
                                class="text-gray-700">{{ basename($modul->file_materi ?? '') }}</strong></span>
                        <span id="scroll-status"
                            class="text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full border border-amber-200">
                            ↓ Gulir ke bawah untuk menyelesaikan modul
                        </span>
                    @endif
                </div>

                <!-- Container Viewer Materi (PDF / YouTube / Link) -->
                <div id="pdf-container" class="flex-1 overflow-y-auto p-4 bg-gray-100 flex items-center justify-center relative">
                    @if($modul->youtube_embed_url)
                        <div id="video-container" class="w-full max-w-3xl aspect-video rounded-2xl overflow-hidden shadow-xl border border-gray-200 bg-black">
                            <iframe 
                                src="{{ $modul->youtube_embed_url }}?rel=0&enablejsapi=1" 
                                class="w-full h-full" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                referrerpolicy="strict-origin-when-cross-origin"
                                allowfullscreen>
                            </iframe>
                        </div>
                    @elseif($modul->tipe_file === 'link')
                        <div class="w-full h-full flex flex-col items-center justify-center bg-white rounded-lg p-8 text-center">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Materi Tautan Eksternal</h3>
                            <a href="{{ $modul->file_materi }}" target="_blank" id="external-link-btn"
                                class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-medium text-sm hover:bg-blue-700 transition">
                                Buka Tautan Materi &rarr;
                            </a>
                        </div>
                    @else
                        <iframe src="{{ asset('storage/' . $modul->file_materi) }}"
                            class="w-full h-[650px] bg-white rounded-lg shadow border border-gray-200" id="pdf-frame"></iframe>
                    @endif
                </div>

                <!-- Footer Aksi (Pemisah Admin & Siswa) -->
                <div class="bg-white px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                    @if(auth()->check() && in_array(auth()->user()->id_tipeuser, [1, 2]))
                        <span class="text-xs text-blue-600 font-medium">ℹ️ Anda sedang berada dalam Mode Pratinjau
                            (Admin)</span>
                        <a href="{{ route('admin.modul') }}"
                            class="px-6 py-2.5 bg-gray-800 text-white font-semibold text-sm rounded-lg hover:bg-gray-700 transition">
                            Kembali ke Daftar Modul
                        </a>
                    @else
                        <span class="text-xs text-gray-400">Pastikan Anda telah membaca seluruh materi pembelajaran dengan
                            teliti.</span>

                        @if($modul->id_quiz)
                            <button id="btn-selesai" disabled
                                class="px-6 py-2.5 bg-gray-300 text-gray-500 font-semibold text-sm rounded-lg cursor-not-allowed transition flex items-center space-x-2">
                                <span>Selesai & Lanjut ke Kuis</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        @else
                            <span class="text-xs text-rose-500 font-medium">Tidak ada kuis terikat pada modul ini.</span>
                        @endif
                    @endif
                </div>

            </div>
        </main>
    </div>

    <!-- Skrip Interaktif -->
    <script>
        const container = document.getElementById('pdf-container');
        const btnSelesai = document.getElementById('btn-selesai');
        const scrollStatus = document.getElementById('scroll-status');
        const externalLinkBtn = document.getElementById('external-link-btn');
        const videoContainer = document.getElementById('video-container');

        let isCompleted = false;

        if (videoContainer) {
            // Untuk materi video, aktifkan tombol selesai agar siswa dapat lanjut ke kuis setelah menonton
            setTimeout(() => {
                enableButton();
            }, 3000);
        }

        if (externalLinkBtn) {
            externalLinkBtn.addEventListener('click', function () {
                enableButton();
            });
        }

        if (container) {
            container.addEventListener('scroll', function () {
                if (container.scrollHeight - container.scrollTop - container.clientHeight < 30) {
                    enableButton();
                }
            });
        }

        function enableButton() {
            if (!isCompleted && btnSelesai) {
                isCompleted = true;
                btnSelesai.disabled = false;
                btnSelesai.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
                btnSelesai.classList.add('bg-emerald-600', 'text-white', 'hover:bg-emerald-700', 'shadow-md');

                if (scrollStatus) {
                    scrollStatus.innerText = "✓ Modul telah selesai dibaca";
                    scrollStatus.classList.remove('text-amber-600', 'bg-amber-50', 'border-amber-200');
                    scrollStatus.classList.add('text-emerald-600', 'bg-emerald-50', 'border-emerald-200');
                }
            }
        }

        if (btnSelesai) {
            btnSelesai.addEventListener('click', function () {
                if (!isCompleted) return;
                window.location.href = "{{ route('siswa.quiz.kerjakan', $modul->id_quiz ?? 0) }}";
            });
        }
    </script>
@endsection
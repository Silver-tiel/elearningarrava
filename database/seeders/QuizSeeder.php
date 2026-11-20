<?php

namespace Database\Seeders;

use App\Models\PilihanSoal;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        if (Schema::hasTable('mapel') && DB::table('mapel')->count() === 0) {
            $this->call(MapelSeeder::class);
        }

        $quizList = array_merge(
            $this->existingCuratedQuizzes(),
            $this->quizzesMatematika(),
            $this->quizzesBahasaIndonesia(),
            $this->quizzesBahasaInggris(),
            $this->quizzesIpa(),
            $this->quizzesIps(),
            $this->quizzesPpkn(),
            $this->quizzesAgama(),
            $this->quizzesInformatika(),
            $this->quizzesSeniBudaya(),
            $this->quizzesPjok(),
            $this->quizzesFisika(),
            $this->quizzesKimia(),
            $this->quizzesBiologi(),
            $this->quizzesEkonomi(),
            $this->quizzesGeografi(),
            $this->quizzesSosiologi(),
            $this->quizzesSejarahIndonesia(),
            QuizExpandedDataset::getQuizzes()
        );

        DB::transaction(function () use ($quizList) {
            $hasMapelTable = Schema::hasTable('mapel');
            $hasPembuat = Schema::hasColumn('quiz', 'id_pembuat');
            $defaultGuruId = ($hasPembuat && Schema::hasTable('user'))
                ? User::where('id_tipeuser', 2)->value('id_user')
                : null;

            foreach ($quizList as $qData) {
                $idMapel = null;
                if (!empty($qData['id_mapel']) && $hasMapelTable) {
                    if (DB::table('mapel')->where('id_mapel', $qData['id_mapel'])->exists()) {
                        $idMapel = $qData['id_mapel'];
                    }
                }

                $quizAttributes = [
                    'deskripsi' => $qData['deskripsi'],
                    'id_jenjang' => $qData['id_jenjang'],
                    'id_mapel' => $idMapel,
                    'id_tipequiz' => $qData['id_tipequiz'],
                    'id_tingkatquiz' => $qData['id_tingkatquiz'],
                    'mode_pengerjaan' => $qData['mode_pengerjaan'],
                    'durasi_total_menit' => $qData['durasi_total_menit'],
                    'token' => $qData['token'],
                    'proggressQuiz' => $qData['proggressQuiz'],
                    'opsi_preview' => $qData['opsi_preview'] ?? 'lengkap',
                    'waktu_kadaluarsa' => null,
                ];

                $quiz = Quiz::updateOrCreate(
                    ['judul' => $qData['judul']],
                    $quizAttributes
                );

                if ($hasPembuat && $defaultGuruId && empty($quiz->id_pembuat)) {
                    $quiz->update(['id_pembuat' => $defaultGuruId]);
                }

                foreach ($qData['soal'] as $sData) {
                    $jenis = $sData['jenis'];
                    $idJenisSoal = 1;
                    $jawabanBenar = 'A';

                    if ($jenis === 'isian') {
                        $idJenisSoal = 2;
                        $jawabanBenar = mb_strtolower(trim($sData['jawaban_benar']));
                    } elseif ($jenis === 'benar_salah') {
                        $idJenisSoal = 3;
                        $jawabanBenar = strtoupper(trim($sData['jawaban_benar']));
                    } else {
                        $idJenisSoal = 1;
                        foreach ($sData['pilihan'] as $p) {
                            if (!empty($p['is_correct'])) {
                                $jawabanBenar = strtoupper(trim($p['label']));
                                break;
                            }
                        }
                    }

                    $soal = Soal::updateOrCreate(
                        [
                            'id_quiz' => $quiz->id_quiz,
                            'pertanyaan' => $sData['pertanyaan'],
                        ],
                        [
                            'id_jenjang' => $qData['id_jenjang'],
                            'id_jenis_soal' => $idJenisSoal,
                            'jawaban_benar' => $jawabanBenar,
                            'poin' => $sData['poin'] ?? 10,
                            'durasi_detik' => $sData['durasi_detik'] ?? 20,
                        ]
                    );

                    if ($jenis === 'pilihan_ganda') {
                        foreach ($sData['pilihan'] as $pChoice) {
                            PilihanSoal::updateOrCreate(
                                [
                                    'id_soal' => $soal->id_soal,
                                    'label' => strtoupper(trim($pChoice['label'])),
                                ],
                                [
                                    'teks_pilihan' => $pChoice['teks_pilihan'],
                                    'is_correct' => (bool) ($pChoice['is_correct'] ?? false),
                                ]
                            );
                        }
                    } elseif ($jenis === 'benar_salah') {
                        $pilihanBS = [
                            ['label' => 'A', 'teks_pilihan' => 'Benar', 'is_correct' => $jawabanBenar === 'A'],
                            ['label' => 'B', 'teks_pilihan' => 'Salah', 'is_correct' => $jawabanBenar === 'B'],
                        ];

                        foreach ($pilihanBS as $pChoice) {
                            PilihanSoal::updateOrCreate(
                                [
                                    'id_soal' => $soal->id_soal,
                                    'label' => $pChoice['label'],
                                ],
                                [
                                    'teks_pilihan' => $pChoice['teks_pilihan'],
                                    'is_correct' => $pChoice['is_correct'],
                                ]
                            );
                        }
                    } elseif ($jenis === 'isian') {
                        PilihanSoal::where('id_soal', $soal->id_soal)->delete();
                    }
                }
            }
        });
    }

    private function quiz(
        string $judul,
        string $deskripsi,
        int $jenjang,
        int $mapel,
        int $tipe,
        int $tingkat,
        string $mode,
        ?int $durasiMenit,
        array $soal,
        ?string $token = null
    ): array {
        return [
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'id_jenjang' => $jenjang,
            'id_mapel' => $mapel,
            'id_tipequiz' => $tipe,
            'id_tingkatquiz' => $tingkat,
            'mode_pengerjaan' => $mode,
            'durasi_total_menit' => $mode === 'biasa' ? ($durasiMenit ?? 20) : null,
            'token' => $token,
            'proggressQuiz' => 'Tersedia',
            'opsi_preview' => 'lengkap',
            'soal' => $soal,
        ];
    }

    private function pg(string $pertanyaan, array $opsi, string $benarLabel, int $poin = 10, int $durasi = 20): array
    {
        $labels = ['A', 'B', 'C', 'D'];
        $pilihan = [];
        foreach ($labels as $idx => $label) {
            $pilihan[] = [
                'label' => $label,
                'teks_pilihan' => $opsi[$idx],
                'is_correct' => strtoupper($benarLabel) === $label,
            ];
        }

        return [
            'jenis' => 'pilihan_ganda',
            'pertanyaan' => $pertanyaan,
            'poin' => $poin,
            'durasi_detik' => $durasi,
            'pilihan' => $pilihan,
        ];
    }

    private function bs(string $pertanyaan, bool $isBenar, int $poin = 10, int $durasi = 15): array
    {
        return [
            'jenis' => 'benar_salah',
            'pertanyaan' => $pertanyaan,
            'poin' => $poin,
            'durasi_detik' => $durasi,
            'jawaban_benar' => $isBenar ? 'A' : 'B',
        ];
    }

    private function isian(string $pertanyaan, string $jawabanBenar, int $poin = 15, int $durasi = 20): array
    {
        return [
            'jenis' => 'isian',
            'pertanyaan' => $pertanyaan,
            'poin' => $poin,
            'durasi_detik' => $durasi,
            'jawaban_benar' => mb_strtolower(trim($jawabanBenar)),
        ];
    }

    private function existingCuratedQuizzes(): array
    {
        return [
            // SD (1) - Mapel 4 (IPA) [1/3]
            $this->quiz(
                'Kuis Cepat Kilat Ceria SD',
                'Uji kecepatan berpikir dan ketangkasan wawasan dasar seputar sains, matematika, dan pengetahuan umum dengan durasi waktu per soal.',
                1, 4, 1, 1, 'wayground', null,
                [
                    $this->pg('Organ tubuh manusia yang berfungsi utama memompa darah ke seluruh tubuh adalah...', ['Jantung', 'Lambung', 'Paru-paru', 'Ginjal'], 'A', 10, 15),
                    $this->bs('Hasil penjumlahan dari 25 ditambah 75 adalah 100.', true, 10, 15),
                    $this->isian('Kelompok hewan yang menyusui dan melahirkan anaknya disebut hewan golongan...', 'mamalia', 15, 20),
                    $this->pg('Lambang negara kesatuan Republik Indonesia adalah burung...', ['Rajawali', 'Garuda', 'Elang Jawa', 'Merpati'], 'B', 10, 15),
                    $this->bs('Air murni membeku menjadi es pada suhu 100 derajat Celsius.', false, 10, 15),
                ]
            ),
            // SD (1) - Mapel 4 (IPA) [2/3]
            $this->quiz(
                'Penilaian Harian Tematik & IPA Terpadu SD',
                'Penilaian harian tematik mencakup IPA, Bahasa Indonesia, dan Matematika dasar dalam mode waktu total 20 menit.',
                1, 4, 1, 2, 'biasa', 20,
                [
                    $this->pg('Proses pembuatan makanan pada tumbuhan hijau dengan bantuan cahaya matahari dinamakan...', ['Respirasi', 'Fotosintesis', 'Fermentasi', 'Metamorfosis'], 'B', 10, 25),
                    $this->isian('Lawan kata atau antonim dari kata "tinggi" dalam bahasa Indonesia adalah...', 'pendek', 15, 20),
                    $this->bs('Sudut siku-siku memiliki besar sudut tepat 90 derajat.', true, 10, 15),
                    $this->pg('Sebuah persegi memiliki panjang sisi 8 cm. Berapakah luas persegi tersebut?', ['32 cm²', '64 cm²', '16 cm²', '48 cm²'], 'B', 10, 25),
                    $this->isian('Ibukota negara Indonesia yang saat ini adalah...', 'jakarta', 10, 20),
                    $this->bs('Kupu-kupu mengalami metamorfosis sempurna yang dimulai dari fase telur, ulat, kepompong, hingga dewasa.', true, 10, 15),
                ]
            ),
            // SD (1) - Mapel 1 (Matematika) [1/3]
            $this->quiz(
                'Ulangan Akhir Semester Cerdas Cendekia SD',
                'Ujian semester komprehensif untuk siswa SD tingkat lanjut. Dibutuhkan token untuk membuka akses pengerjaan.',
                1, 1, 2, 3, 'biasa', 30,
                [
                    $this->pg('Planet terbesar dalam tata surya kita adalah planet...', ['Mars', 'Bumi', 'Jupiter', 'Saturnus'], 'C', 10, 20),
                    $this->isian('Berapakah hasil operasi hitung dari (15 x 4) : 2?', '30', 15, 25),
                    $this->bs('Naskah proklamasi kemerdekaan Republik Indonesia dibacakan pada tanggal 17 Agustus 1945.', true, 10, 15),
                    $this->isian('Zat warna hijau pada daun yang berfungsi menyerap energi matahari disebut...', 'klorofil', 15, 20),
                    $this->pg('Tokoh utama yang memiliki sifat baik dalam sebuah cerita narasi disebut tokoh...', ['Antagonis', 'Protagonis', 'Tritagonis', 'Figuran'], 'B', 10, 20),
                    $this->bs('Batang magnet selalu memiliki 3 kutub utama yaitu kutub utara, timur, dan selatan.', false, 10, 15),
                ],
                'SDJUARA'
            ),
            // SMP (2) - Mapel 4 (IPA) [1/3]
            $this->quiz(
                'Speed Challenge Sains & Logika SMP',
                'Tantangan kecepatan sains dan penalaran logika SMP dalam tempo cepat per nomor.',
                2, 4, 1, 2, 'wayground', null,
                [
                    $this->pg('Satuan internasional (SI) yang digunakan untuk mengukur besaran gaya adalah...', ['Joule', 'Watt', 'Newton', 'Pascal'], 'C', 10, 15),
                    $this->bs('Rumus kimia resmi untuk molekul air murni adalah H2O.', true, 10, 15),
                    $this->isian('Organ ekskresi utama manusia yang berfungsi menyaring zat sisa metabolisme dari darah dan menghasilkan urine adalah...', 'ginjal', 15, 20),
                    $this->pg('Berapakah nilai dari 3 dipangkatkan 4 (3⁴)?', ['12', '27', '64', '81'], 'D', 10, 20),
                    $this->bs('Kecepatan rambat cahaya di ruang hampa lebih lambat dibandingkan kecepatan rambat gelombang bunyi di udara.', false, 10, 15),
                ]
            ),
            // SMP (2) - Mapel 2 (Bahasa Indonesia) [1/3]
            $this->quiz(
                'Ujian Mandiri Bahasa & Sosial Budaya SMP',
                'Evaluasi wawasan kebahasaan, sosial, dan sejarah nasional dengan mode waktu total 25 menit.',
                2, 2, 1, 1, 'biasa', 25,
                [
                    $this->pg('Bentuk kata turunan baku dalam bahasa Indonesia yang benar dari kata dasar "ubah" adalah...', ['Merubah', 'Mengubah', 'Memrubah', 'Pengrubahan'], 'B', 10, 20),
                    $this->isian('Candi peninggalan agama Buddha terbesar di dunia yang terletak di Kabupaten Magelang, Jawa Tengah adalah Candi...', 'borobudur', 15, 20),
                    $this->bs('In English grammar, the correct past tense (V2) form of the verb "go" is "goed".', false, 10, 15),
                    $this->pg('Benua dengan luas wilayah daratan terbesar dan terluas di dunia adalah Benua...', ['Afrika', 'Amerika', 'Asia', 'Eropa'], 'C', 10, 20),
                    $this->isian('Nama mata uang resmi yang berlaku di negara Jepang adalah...', 'yen', 10, 20),
                    $this->bs('Sila pertama dalam Pancasila berbunyi "Ketuhanan Yang Maha Esa".', true, 10, 15),
                ]
            ),
            // SMP (2) - Mapel 8 (Informatika & TIK) [1/3]
            $this->quiz(
                'Ulangan Tengah Semester IPA & Teknologi SMP',
                'Ulangan komprehensif sains, biologi sel, dan teknologi informasi untuk siswa berprestasi SMP.',
                2, 8, 2, 3, 'biasa', 35,
                [
                    $this->pg('Energi yang dimiliki oleh suatu benda yang timbul akibat dari pergerakan atau kecepatannya disebut energi...', ['Potensial', 'Kinetik', 'Kalor', 'Kimia'], 'B', 10, 20),
                    $this->isian('Bagian struktur sel tumbuhan yang tidak terdapat pada sel hewan dan berfungsi memberikan bentuk yang kaku dan kokoh adalah...', 'dinding sel', 15, 25),
                    $this->bs('Persamaan kuadrat x² - 16 = 0 mempunyai dua himpunan penyelesaian real yaitu x = 4 dan x = -4.', true, 10, 20),
                    $this->isian('Alat ukur yang digunakan untuk mendeteksi dan mengukur besarnya kuat arus listrik adalah...', 'amperemeter', 15, 20),
                    $this->pg('Gas unsur terbanyak yang menyusun lapisan atmosfer bumi hingga mencapai kurang lebih 78% adalah...', ['Oksigen', 'Karbon Dioksida', 'Nitrogen', 'Argon'], 'C', 10, 20),
                    $this->bs('Pembuluh balik (vena) bertugas memompa dan membawa darah segar yang kaya akan oksigen langsung dari bilik kiri jantung menuju seluruh jaringan tubuh.', false, 10, 15),
                ],
                'SMPHEBAT'
            ),
            // SMA (3) - Mapel 11 (Fisika) [1/3]
            $this->quiz(
                'Grand Prix Sains & Olimpiade SMA',
                'Ajang uji cepat ketepatan analisis konsep sains fisika, kimia, dan matematika SMA bergaya Wayground.',
                3, 11, 1, 2, 'wayground', null,
                [
                    $this->pg('Hukum kelistrikan yang menyatakan bahwa beda potensial (tegangan) berbanding lurus dengan kuat arus listrik adalah Hukum...', ['Coulomb', 'Ohm', 'Faraday', 'Ampere'], 'B', 10, 15),
                    $this->bs('Dalam trigonometri, nilai dari perbandingan sin 30° adalah 0,5 (atau 1/2).', true, 10, 15),
                    $this->isian('Subpartikel penyusun inti atom bersama proton yang tidak memiliki muatan listrik (netral) disebut...', 'neutron', 15, 20),
                    $this->pg('Asam nukleat beruntai ganda (double helix) yang menjadi materi pembawa informasi hereditas pada organisme adalah...', ['RNA', 'DNA', 'ATP', 'Polipeptida'], 'B', 10, 15),
                    $this->bs('Pada peristiwa tumbukan lenting sempurna antara dua benda, berlaku hukum kekekalan momentum namun hukum kekekalan energi kinetik tidak berlaku.', false, 10, 15),
                ]
            ),
            // SMA (3) - Mapel 1 (Matematika) [1/3]
            $this->quiz(
                'Simulasi UTBK & Penalaran Skolastik SMA',
                'Simulasi ujian seleksi masuk perguruan tinggi menguji literasi, penalaran matematika tingkat lanjut, dan analisis kritis.',
                3, 1, 2, 3, 'biasa', 40,
                [
                    $this->pg('Diketahui fungsi f(x) = 3x² + 4x - 5. Maka turunan pertama f\'(x) adalah...', ['6x + 4', '3x + 4', '6x² + 4', '6x - 5'], 'A', 10, 30),
                    $this->isian('Kondisi perekonomian di mana harga barang dan jasa secara umum mengalami kenaikan secara terus menerus dalam jangka waktu tertentu disebut...', 'inflasi', 15, 25),
                    $this->bs('Suatu larutan kimia dengan nilai derajat keasaman (pH) di bawah 7 tergolong larutan asam, sedangkan di atas 7 tergolong basa.', true, 10, 20),
                    $this->pg('Proses perpaduan dua kebudayaan yang saling mempengaruhi tanpa menghilangkan unsur kepribadian dari masing-masing kebudayaan asli disebut...', ['Asimilasi', 'Akulturasi', 'Difusi', 'Segregasi'], 'B', 10, 25),
                    $this->isian('Komponen perangkat keras utama komputer yang bertindak sebagai otak untuk mengeksekusi instruksi aritmatika dan logika disingkat...', 'cpu', 10, 20),
                    $this->bs('Enzim dalam tubuh bertindak sebagai biokatalisator dengan cara meningkatkan energi aktivasi reaksi biokimia.', false, 10, 15),
                ],
                'SMASUKSES'
            ),
            // SMA (3) - Mapel 17 (Sejarah Indonesia) [1/3]
            $this->quiz(
                'Wawasan Literasi & Sejarah Global SMA',
                'Eksplorasi wawasan sejarah dunia, literasi global, dan kebudayaan umum dalam mode waktu total 25 menit.',
                3, 17, 1, 1, 'biasa', 25,
                [
                    $this->pg('Era revolusi industri pertama kali bermula dan berkembang pesat pada abad ke-18 di negara...', ['Prancis', 'Amerika Serikat', 'Inggris', 'Jerman'], 'C', 10, 20),
                    $this->isian('Samudra terbesar dan terluas di planet Bumi yang membentang di antara Benua Asia dan Amerika adalah Samudra...', 'pasifik', 10, 20),
                    $this->bs('Galaksi tempat tata surya kita bernaung bernama Galaksi Bima Sakti (Milky Way).', true, 10, 15),
                    $this->pg('Gaya bahasa (majas) yang membandingkan dua hal secara langsung atas dasar sifat yang sama tanpa menggunakan kata pembanding (seperti/laksana) disebut majas...', ['Personifikasi', 'Hiperbola', 'Metafora', 'Litotes'], 'C', 10, 20),
                    $this->isian('Konferensi Meja Bundar (KMB) tahun 1949 yang menghasilkan pengakuan kedaulatan Indonesia oleh Belanda diselenggarakan di kota...', 'den haag', 15, 20),
                    $this->bs('Menurut hukum permintaan ekonomi, apabila harga suatu barang melonjak tinggi, maka jumlah barang yang diminta konsumen cenderung akan meningkat drastis.', false, 10, 15),
                ]
            ),
        ];
    }

    // 1. Matematika (SD +2, SMP +3, SMA +2)
    private function quizzesMatematika(): array
    {
        return [
            $this->quiz('Latihan Kilat Bilangan & Operasi Hitung SD', 'Mengasah kecepatan berhitung penjumlahan, pengurangan, perkalian, dan pembagian bilangan cacah SD.', 1, 1, 1, 1, 'wayground', null, [
                $this->pg('Hasil dari 125 + 275 adalah...', ['390', '400', '410', '425'], 'B'),
                $this->bs('Bilangan genap terkecil yang lebih besar dari 10 adalah 12.', true),
                $this->isian('Hasil dari 9 x 8 adalah...', '72'),
                $this->pg('Nilai tempat angka 7 pada bilangan 4.725 adalah...', ['Ribuan', 'Ratusan', 'Puluhan', 'Satuan'], 'B'),
            ]),
            $this->quiz('Evaluasi Pecahan & Bangun Datar SD', 'Latihan pemahaman konsep pecahan sederhana, keliling, dan luas bangun datar SD.', 1, 1, 1, 2, 'biasa', 20, [
                $this->pg('Pecahan yang senilai dengan 1/2 adalah...', ['2/3', '3/6', '3/5', '4/6'], 'B'),
                $this->bs('Keliling persegi dengan panjang sisi 5 cm adalah 20 cm.', true),
                $this->isian('Hasil dari 3/4 + 1/4 adalah...', '1'),
                $this->pg('Jumlah sudut dalam sebuah segitiga selalu sebesar...', ['90 derajat', '180 derajat', '270 derajat', '360 derajat'], 'B'),
            ]),

            $this->quiz('Tantangan Aljabar & Bilangan Bulat SMP', 'Uji cepat konsep bilangan bulat, pecahan aljabar, dan persamaan linear satu variabel SMP.', 2, 1, 1, 1, 'wayground', null, [
                $this->pg('Hasil dari -12 + 19 - 5 adalah...', ['-2', '2', '12', '26'], 'B'),
                $this->bs('Jika 2x + 4 = 14, maka nilai x adalah 5.', true),
                $this->isian('Bentuk sederhana dari 5a + 3b - 2a + b adalah...', '3a + 4b'),
                $this->pg('KPK dari 12 dan 18 adalah...', ['6', '24', '36', '72'], 'C'),
            ]),
            $this->quiz('Pendalaman Teorema Pythagoras & Lingkaran SMP', 'Evaluasi penerapan Teorema Pythagoras, luas lingkaran, dan perbandingan senilai SMP.', 2, 1, 1, 2, 'biasa', 25, [
                $this->pg('Segitiga siku-siku dengan sisi siku-siku 6 cm dan 8 cm memiliki sisi miring sepanjang...', ['9 cm', '10 cm', '12 cm', '14 cm'], 'B'),
                $this->bs('Gradien garis yang sejajar dengan sumbu X adalah 0.', true),
                $this->isian('Jika rasio kelereng Budi dan Ani adalah 2 : 3 dan jumlahnya 25, banyak kelereng Budi adalah...', '10'),
                $this->pg('Keliling lingkaran dengan diameter 14 cm (pi = 22/7) adalah...', ['22 cm', '44 cm', '88 cm', '154 cm'], 'B'),
            ]),
            $this->quiz('Ulangan Akhir Statistika & Peluang SMP', 'Ujian tingkat lanjut mencakup mean, median, modus, dan peluang kejadian sederhana SMP.', 2, 1, 2, 3, 'biasa', 35, [
                $this->pg('Nilai rata-rata dari data 6, 7, 8, 9, 10 adalah...', ['7', '7,5', '8', '8,5'], 'C'),
                $this->bs('Median dari data terurut 3, 5, 7, 9, 11 adalah 7.', true),
                $this->isian('Banyak ruang sampel pada pelemparan dua koin secara bersamaan adalah...', '4'),
                $this->pg('Jika sebuah dadu bersisi 6 dilempar sekali, peluang muncul mata dadu prima adalah...', ['1/6', '1/3', '1/2', '2/3'], 'C'),
            ]),

            $this->quiz('Kuis Cepat Eksponen & Logaritma SMA', 'Menguji ketangkasan menyederhanakan bilangan berpangkat, bentuk akar, dan logaritma dasar SMA.', 3, 1, 1, 1, 'wayground', null, [
                $this->pg('Nilai dari 2^5 adalah...', ['16', '25', '32', '64'], 'C'),
                $this->bs('Nilai dari ^2 log 8 adalah 3.', true),
                $this->isian('Hasil dari akar kuadrat 144 ditambah akar kuadrat 25 adalah...', '17'),
                $this->pg('Jika 3^x = 81, maka nilai x adalah...', ['2', '3', '4', '5'], 'C'),
            ]),
            $this->quiz('Evaluasi Barisan, Matriks & Trigonometri SMA', 'Pendalaman barisan aritmatika, operasi matriks 2x2, dan perbandingan trigonometri sudut istimewa.', 3, 1, 1, 2, 'biasa', 30, [
                $this->pg('Suku ke-10 dari barisan aritmatika 2, 5, 8, 11, ... adalah...', ['26', '29', '32', '35'], 'B'),
                $this->bs('Nilai tan 45 derajat adalah 1.', true),
                $this->isian('Determinan matriks [[4, 2], [1, 3]] adalah...', '10'),
                $this->pg('Identitas trigonometri sin²x + cos²x selalu bernilai...', ['0', '1', '2', '-1'], 'B'),
            ]),
        ];
    }

    // 2. Bahasa Indonesia (SD +3, SMP +2, SMA +3)
    private function quizzesBahasaIndonesia(): array
    {
        return [
            $this->quiz('Kuis Cepat Ejaan & Kosakata SD', 'Melatih penggunaan huruf kapital, tanda baca, serta sinonim dan antonim dasar.', 1, 2, 1, 1, 'wayground', null, [
                $this->pg('Kata baku untuk penulisan kegiatan praktik adalah...', ['Praktek', 'Praktik', 'Prakteck', 'Pratik'], 'B'),
                $this->bs('Kalimat tanya selalu diakhiri dengan tanda baca titik.', false),
                $this->isian('Sinonim dari kata "pintar" yang paling umum adalah...', 'pandai'),
                $this->pg('Huruf kapital digunakan dengan tepat pada kalimat...', ['Ibu pergi ke pasar.', 'ibu pergi ke Pasar.', 'Ibu Pergi ke pasar.', 'ibu Pergi Ke pasar.'], 'A'),
            ]),
            $this->quiz('Pemahaman Paragraf & Puisi Anak SD', 'Menentukan gagasan pokok paragraf, unsur intrinsik dongeng, dan makna puisi anak.', 1, 2, 1, 2, 'biasa', 20, [
                $this->pg('Gagasan utama yang menjadi dasar pengembangan sebuah paragraf disebut...', ['Kalimat penjelas', 'Ide pokok', 'Kesimpulan', 'Judul'], 'B'),
                $this->bs('Fabel adalah cerita rakyat atau dongeng yang tokoh-tokohnya berupa hewan yang berperilaku seperti manusia.', true),
                $this->isian('Pesan moral yang ingin disampaikan pengarang dalam sebuah cerita disebut...', 'amanat'),
                $this->pg('Pantun terdiri atas empat baris dalam satu bait dengan rima akhir...', ['a-a-a-a', 'a-b-a-b', 'a-a-b-b', 'a-b-b-a'], 'B'),
            ]),
            $this->quiz('Ulangan Bahasa Indonesia Terpadu SD', 'Evaluasi kemampuan membaca pemahaman, menulis surat pribadi, dan kalimat efektif.', 1, 2, 2, 3, 'biasa', 30, [
                $this->pg('Kata dasar dari kata berimbuhan "menulis" adalah...', ['Nulis', 'Tulis', 'Tulisan', 'Menulisi'], 'B'),
                $this->bs('Imbuhan di- yang menyatakan tempat ditulis serangkai dengan kata yang mengikutinya.', false),
                $this->isian('Jenis kalimat yang memuat subjek, predikat, dan objek secara ringkas serta jelas disebut kalimat...', 'efektif'),
                $this->pg('Bagian awal cerita yang berisi pengenalan tokoh dan latar disebut...', ['Komplikasi', 'Resolusi', 'Orientasi', 'Koda'], 'C'),
            ]),

            $this->quiz('Kuis Cepat Teks Deskripsi & Berita SMP', 'Latihan struktur teks deskripsi, teks berita (ADIKSIMBA), dan kebahasaan teks prosedur.', 2, 2, 1, 2, 'wayground', null, [
                $this->pg('Unsur berita yang menanyakan tempat terjadinya peristiwa adalah...', ['Apa', 'Siapa', 'Di mana', 'Mengapa'], 'C'),
                $this->bs('Teks prosedur berisi langkah-langkah berurutan untuk melakukan atau membuat sesuatu.', true),
                $this->isian('Majas yang mengumpamakan benda mati seolah-olah hidup seperti manusia disebut majas...', 'personifikasi'),
                $this->pg('Kata penghubung "namun" dan "tetapi" termasuk konjungsi...', ['Temporal', 'Pertentangan', 'Sebab-akibat', 'Penambahan'], 'B'),
            ]),
            $this->quiz('Ulangan Sastra & Teks Eksplanasi SMP', 'Penilaian mendalam struktur teks eksplanasi, persuasi, dan analisis karya puisi serta cerpen.', 2, 2, 2, 3, 'biasa', 35, [
                $this->pg('Teks yang menjelaskan proses terjadinya suatu fenomena alam atau sosial secara ilmiah disebut teks...', ['Narasi', 'Eksplanasi', 'Anekdot', 'Observasi'], 'B'),
                $this->bs('Kata "di" sebagai awalan kata kerja pasif seperti "dibaca" harus ditulis terpisah.', false),
                $this->isian('Paragraf yang kalimat utamanya berada di awal paragraf disebut paragraf...', 'deduktif'),
                $this->pg('Bagian akhir teks eksplanasi yang berisi simpulan atau komentar umum disebut...', ['Pernyataan umum', 'Deretan penjelas', 'Interpretasi', 'Orientasi'], 'C'),
            ]),

            $this->quiz('Tantangan Kebahasaan & PUEBI SMA', 'Uji cepat ketepatan ejaan EYD V/PUEBI, kalimat efektif, dan kata serapan baku SMA.', 3, 2, 1, 1, 'wayground', null, [
                $this->pg('Penulisan kata serapan yang baku menurut KBBI adalah...', ['Analisa', 'Analisis', 'Sistim', 'Kwalitas'], 'B'),
                $this->bs('Penulisan gelar akademik yang diletakkan di belakang nama dipisahkan dengan tanda koma.', true),
                $this->isian('Istilah lain untuk ragam kata yang sesuai dengan kaidah tata bahasa resmi adalah kata...', 'baku'),
                $this->pg('Kalimat yang mengandung makna ganda sehingga menimbulkan keraguan pembaca disebut kalimat...', ['Pasif', 'Ambigu', 'Majemuk', 'Imperatif'], 'B'),
            ]),
            $this->quiz('Analisis Teks Argumentasi & Resensi SMA', 'Evaluasi struktur teks negosiasi, eksposisi, artikel opini, dan penulisan karya ilmiah.', 3, 2, 1, 2, 'biasa', 30, [
                $this->pg('Bagian dalam karya tulis ilmiah yang berisi ringkasan singkat seluruh isi penelitian adalah...', ['Kata pengantar', 'Abstrak', 'Daftar pustaka', 'Lampiran'], 'B'),
                $this->bs('Teks negosiasi bertujuan mencapai kesepakatan bersama antara dua belah pihak tanpa merugikan salah satu pihak.', true),
                $this->isian('Kalimat yang mengungkapkan pendapat penulis terhadap suatu isu dalam editorial disebut...', 'opini'),
                $this->pg('Penilaian mengenai keunggulan dan kelemahan sebuah buku atau film disebut...', ['Sinopsis', 'Resensi', 'Biografi', 'Prolog'], 'B'),
            ]),
            $this->quiz('Ulangan Sastra Indonesia & Kritik Esai SMA', 'Pengujian pemahaman periodisasi sastra Indonesia, hikayat, drama, dan kritik esai.', 3, 2, 2, 3, 'biasa', 40, [
                $this->pg('Karya sastra Melayu klasik yang mengisahkan kehebatan tokoh istana dengan unsur kemustahilan disebut...', ['Gurindam', 'Hikayat', 'Soneta', 'Babad'], 'B'),
                $this->bs('Esai merupakan karangan prosa yang membahas suatu masalah secara subjektif dari sudut pandang penulisnya.', true),
                $this->isian('Watak atau karakter tokoh dalam pementasan drama disebut...', 'perwatakan'),
                $this->pg('Karya tulis yang membahas suatu persoalan berdasarkan data objektif dan metode ilmiah disebut...', ['Cerpen', 'Artikel ilmiah', 'Anekdot', 'Parodi'], 'B'),
            ]),
        ];
    }

    // 3. Bahasa Inggris (SD +3, SMP +3, SMA +3)
    private function quizzesBahasaInggris(): array
    {
        return [
            $this->quiz('Fun Vocabulary & Greetings SD', 'Mengenal kosakata dasar benda di kelas, angka, warna, dan sapaan sederhana dalam bahasa Inggris.', 1, 3, 1, 1, 'wayground', null, [
                $this->pg('What is the English word for "buku"?', ['Pen', 'Book', 'Bag', 'Table'], 'B'),
                $this->bs('"Good morning" means "Selamat pagi" in Indonesian.', true),
                $this->isian('The color of the clear sky during the day is...', 'blue'),
                $this->pg('Which number comes after seven?', ['Six', 'Eight', 'Nine', 'Ten'], 'B'),
            ]),
            $this->quiz('Daily Routine & Basic Grammar SD', 'Latihan penggunaan to be (am, is, are), kata ganti orang, dan kalimat sederhana sehari-hari.', 1, 3, 1, 2, 'biasa', 20, [
                $this->pg('She ... a diligent student in my school.', ['am', 'is', 'are', 'were'], 'B'),
                $this->bs('We use "are" with the subject "They".', true),
                $this->isian('The plural form of "one apple" for three pieces is three...', 'apples'),
                $this->pg('How do you say "Terima kasih" in English?', ['Sorry', 'Excuse me', 'Thank you', 'Goodbye'], 'C'),
            ]),
            $this->quiz('Ulangan Bahasa Inggris Dasar SD', 'Evaluasi pemahaman teks pendek, nama hari dan bulan, serta ungkapan izin sederhana.', 1, 3, 2, 3, 'biasa', 30, [
                $this->pg('Today is Monday. Tomorrow will be...', ['Sunday', 'Tuesday', 'Wednesday', 'Friday'], 'B'),
                $this->bs('January is the first month of the year.', true),
                $this->isian('My father\'s sister is my...', 'aunt'),
                $this->pg('Which animal can swim and lives in water?', ['Cat', 'Bird', 'Fish', 'Rabbit'], 'C'),
            ]),

            $this->quiz('Quick Grammar & Tenses Challenge SMP', 'Uji cepat Simple Present Tense, Simple Past Tense, dan kosakata deskriptif SMP.', 2, 3, 1, 1, 'wayground', null, [
                $this->pg('Rina ... to school by bicycle every morning.', ['go', 'goes', 'went', 'going'], 'B'),
                $this->bs('The past tense (V2) of the verb "eat" is "ate".', true),
                $this->isian('The opposite adjective of "expensive" is...', 'cheap'),
                $this->pg('Did you ... the football match last night?', ['watch', 'watches', 'watched', 'watching'], 'A'),
            ]),
            $this->quiz('Reading Comprehension & Notice SMP', 'Evaluasi teks deskriptif, pesan singkat, pengumuman, dan perbandingan adjective (comparison degree).', 2, 3, 1, 2, 'biasa', 25, [
                $this->pg('Mount Everest is the ... mountain in the world.', ['high', 'higher', 'highest', 'more high'], 'C'),
                $this->bs('"Do not step on the grass" means visitors are allowed to walk on the grass.', false),
                $this->isian('A text that tells past events in chronological order is called a ... text.', 'recount'),
                $this->pg('My bag is ... than yours because it holds ten books.', ['heavy', 'heavier', 'heaviest', 'more heavy'], 'B'),
            ]),
            $this->quiz('Ulangan Narrative & Passive Voice SMP', 'Pengujian teks naratif, prosedur, dan kalimat pasif dasar tingkat SMP.', 2, 3, 2, 3, 'biasa', 35, [
                $this->pg('The letter ... by Dina yesterday afternoon.', ['writes', 'wrote', 'was written', 'is written'], 'C'),
                $this->bs('The generic structure of Narrative Text starts with Orientation.', true),
                $this->isian('The synonym of the word "smart" is...', 'clever'),
                $this->pg('If it ... tomorrow, we will cancel the picnic.', ['rain', 'rains', 'rained', 'raining'], 'B'),
            ]),

            $this->quiz('Academic Vocabulary & Idioms SMA', 'Kuis cepat sinonim akademik, phrasal verbs, dan ungkapan idiomatik dalam konteks SMA.', 3, 3, 1, 1, 'wayground', null, [
                $this->pg('The word "crucial" is closest in meaning to...', ['Minor', 'Essential', 'Optional', 'Fragile'], 'B'),
                $this->bs('In English, "give up" means to stop trying or surrender.', true),
                $this->isian('The noun form derived from the verb "decide" is...', 'decision'),
                $this->pg('Despite the heavy rain, the team ... with the match.', ['carried on', 'turned down', 'gave away', 'broke off'], 'A'),
            ]),
            $this->quiz('Analytical Exposition & Conditional SMA', 'Pendalaman struktur teks Analytical Exposition, Hortatory Exposition, dan Conditional Sentences.', 3, 3, 1, 2, 'biasa', 30, [
                $this->pg('If I had studied harder earlier, I ... passed the scholarship test.', ['will have', 'would have', 'would', 'had'], 'B'),
                $this->bs('An Analytical Exposition text ends with a Reiteration paragraph.', true),
                $this->isian('A clause used to give additional information starting with "who", "which", or "that" is a ... clause.', 'relative'),
                $this->pg('The purpose of an Explanation Text is to...', ['Entertain readers', 'Explain how or why a phenomenon happens', 'Persuade people to buy something', 'Describe a specific person'], 'B'),
            ]),
            $this->quiz('Ulangan UTBK Literasi Bahasa Inggris SMA', 'Simulasi pemahaman bacaan kritis, inferensi penulis, dan struktur kalimat kompleks tingkat SMA.', 3, 3, 2, 3, 'biasa', 40, [
                $this->pg('Not only ... the project on time, but she also presented it brilliantly.', ['she finished', 'did she finish', 'she did finish', 'finished she'], 'B'),
                $this->bs('A News Item text presents newsworthy events to inform readers.', true),
                $this->isian('In academic reading, a conclusion drawn from evidence and reasoning rather than explicit statements is an...', 'inference'),
                $this->pg('The manager insisted that every applicant ... punctual for the interview.', ['is', 'was', 'be', 'were'], 'C'),
            ]),
        ];
    }

    // 4. IPA (SD +1, SMP +2, SMA +3)
    private function quizzesIpa(): array
    {
        return [
            $this->quiz('Ulangan Rantai Makanan & Gaya Magnet SD', 'Ujian pemahaman ekosistem sederhana, perubahan wujud benda, dan sifat gaya magnet SD.', 1, 4, 2, 3, 'biasa', 30, [
                $this->pg('Perubahan wujud benda dari gas menjadi cair disebut...', ['Menguap', 'Mengembun', 'Menyublim', 'Membeku'], 'B'),
                $this->bs('Tumbuhan hijau berperan sebagai produsen dalam rantai makanan.', true),
                $this->isian('Gaya tarik bumi yang menyebabkan benda jatuh ke bawah disebut gaya...', 'gravitasi'),
                $this->pg('Sumber energi panas utama dan terbesar bagi kehidupan di Bumi adalah...', ['Bulan', 'Matahari', 'Bintang laut', 'Baterai'], 'B'),
            ]),

            $this->quiz('Evaluasi Klasifikasi & Sistem Organ SMP', 'Pendalaman klasifikasi makhluk hidup, sistem pencernaan, dan pernapasan manusia SMP.', 2, 4, 1, 1, 'biasa', 25, [
                $this->pg('Enzim di mulut yang mengubah amilum menjadi maltosa adalah...', ['Pepsin', 'Ptialin', 'Lipase', 'Tripsin'], 'B'),
                $this->bs('Pertukaran gas oksigen dan karbon dioksida di paru-paru terjadi di alveolus.', true),
                $this->isian('Alat pengukur suhu tubuh atau suhu ruangan disebut...', 'termometer'),
                $this->pg('Bagian darah yang berperan membekukan darah saat terjadi luka adalah...', ['Eritrosit', 'Leukosit', 'Trombosit', 'Plasma darah'], 'C'),
            ]),
            $this->quiz('Ulangan Cahaya, Bunyi & Kelistrikan SMP', 'Evaluasi konsep pemantulan cahaya, sifat gelombang bunyi, dan rangkaian listrik SMP.', 2, 4, 2, 3, 'biasa', 35, [
                $this->pg('Cermin yang digunakan pada kaca spion kendaraan bermotor agar jangkauan pandang luas adalah cermin...', ['Datar', 'Cekung', 'Cembung', 'Rangkap'], 'C'),
                $this->bs('Gelombang bunyi termasuk gelombang mekanik yang membutuhkan medium untuk merambat.', true),
                $this->isian('Satuan internasional untuk hambatan listrik adalah...', 'ohm'),
                $this->pg('Pada rangkaian listrik seri, apabila salah satu lampu putus maka lampu lainnya akan...', ['Tetap menyala terang', 'Ikut padam', 'Menyala lebih terang', 'Berkedip'], 'B'),
            ]),

            $this->quiz('Kuis Cepat Literasi Sains Terpadu SMA', 'Uji cepat konsep dasar metode ilmiah, energi terbarukan, dan fenomena alam terpadu SMA.', 3, 4, 1, 1, 'wayground', null, [
                $this->pg('Sumber energi terbarukan yang memanfaatkan panas dari dalam kerak bumi adalah...', ['Energi surya', 'Energi panas bumi', 'Energi pasang surut', 'Energi biomassa'], 'B'),
                $this->bs('Lapisan ozon (O3) di stratosfer berfungsi melindungi Bumi dari radiasi ultraviolet berlebih.', true),
                $this->isian('Gas rumah kaca utama yang dihasilkan dari pembakaran bahan bakar fosil adalah karbon...', 'dioksida'),
                $this->pg('Cabang ilmu sains yang mempelajari interaksi antar makhluk hidup dan lingkungannya adalah...', ['Genetika', 'Ekologi', 'Anatomi', 'Taksonomi'], 'B'),
            ]),
            $this->quiz('Evaluasi Sains Lingkungan & Bioteknologi SMA', 'Menguji pemahaman daur biogeokimia, pemanasan global, dan penerapan bioteknologi modern.', 3, 4, 1, 2, 'biasa', 30, [
                $this->pg('Mikroorganisme yang berperan dalam pembuatan tempe adalah...', ['Saccharomyces cerevisiae', 'Rhizopus oryzae', 'Lactobacillus bulgaricus', 'Acetobacter xylinum'], 'B'),
                $this->bs('Hujan asam dapat terjadi akibat tingginya kadar sulfur dioksida dan nitrogen oksida di atmosfer.', true),
                $this->isian('Proses perubahan uap air menjadi titik-titik air membentuk awan disebut...', 'kondensasi'),
                $this->pg('Pencemaran air akibat penumpukan limbah organik dapat menyebabkan ledakan populasi alga yang disebut...', ['Eutrofikasi', 'Bioremidiasi', 'Nitrifikasi', 'Sublimasi'], 'A'),
            ]),
            $this->quiz('Ulangan Metode Ilmiah & Sains Terapan SMA', 'Penilaian komprehensif variabel eksperimen, energi berkelanjutan, dan konservasi alam SMA.', 3, 4, 2, 3, 'biasa', 40, [
                $this->pg('Variabel yang sengaja diubah atau dimanipulasi oleh peneliti dalam eksperimen disebut variabel...', ['Terikat', 'Bebas', 'Kontrol', 'Konstan'], 'B'),
                $this->bs('Kultur jaringan tumbuhan memanfaatkan sifat totipotensi sel tanaman.', true),
                $this->isian('Langkah awal sebelum menyusun hipotesis dalam metode ilmiah adalah melakukan...', 'observasi'),
                $this->pg('Teknologi pengolahan limbah cair menggunakan bantuan mikroorganisme pengurai disebut...', ['Bioremediasi', 'Desalinasi', 'Kromatografi', 'Elektrolisis'], 'A'),
            ]),
        ];
    }

    // 5. IPS (SD +3, SMP +3, SMA +3)
    private function quizzesIps(): array
    {
        return [
            $this->quiz('Kuis Cepat Kenampakan Alam & Budaya SD', 'Mengenal peta sederhana, bentang alam daratan dan perairan, serta keragaman suku di Indonesia.', 1, 5, 1, 1, 'wayground', null, [
                $this->pg('Rumah adat Tongkonan berasal dari provinsi...', ['Sumatera Barat', 'Sulawesi Selatan', 'Bali', 'Kalimantan Timur'], 'B'),
                $this->bs('Danau Toba merupakan danau vulkanik terbesar di Indonesia yang berada di Pulau Sumatera.', true),
                $this->isian('Garis khayal yang membelah Bumi menjadi belahan utara dan selatan adalah garis...', 'khatulistiwa'),
                $this->pg('Pekerjaan utama penduduk yang tinggal di daerah pesisir pantai umumnya adalah...', ['Petani teh', 'Nelayan', 'Penambang batu bara', 'Peternak sapi perah'], 'B'),
            ]),
            $this->quiz('Kegiatan Ekonomi & Peninggalan Sejarah SD', 'Memahami jenis kegiatan produksi, distribusi, konsumsi, serta kerajaan bercorak Hindu-Buddha.', 1, 5, 1, 2, 'biasa', 20, [
                $this->pg('Kegiatan menyalurkan barang dari produsen kepada konsumen disebut...', ['Produksi', 'Distribusi', 'Konsumsi', 'Investasi'], 'B'),
                $this->bs('Kerajaan Kutai di Kalimantan Timur merupakan kerajaan bercorak Hindu tertua di Indonesia.', true),
                $this->isian('Mata uang resmi negara kesatuan Republik Indonesia adalah...', 'rupiah'),
                $this->pg('Organisasi kerja sama negara-negara di kawasan Asia Tenggara disebut...', ['PBB', 'ASEAN', 'APEC', 'OPEC'], 'B'),
            ]),
            $this->quiz('Ulangan IPS Nusantara & ASEAN SD', 'Ujian pemahaman posisi geografis Indonesia, ekspor-impor, dan negara anggota ASEAN.', 1, 5, 2, 3, 'biasa', 30, [
                $this->pg('Indonesia terletak di antara dua samudra, yaitu Samudra Hindia dan Samudra...', ['Atlantik', 'Arktik', 'Pasifik', 'Antartika'], 'C'),
                $this->bs('Singapura dan Thailand termasuk negara pendiri ASEAN pada tahun 1967.', true),
                $this->isian('Kegiatan mendatangkan barang dari luar negeri ke dalam negeri disebut...', 'impor'),
                $this->pg('Suku Asmat berasal dari wilayah pulau...', ['Kalimantan', 'Sulawesi', 'Papua', 'Nusa Tenggara'], 'C'),
            ]),

            $this->quiz('Kuis Cepat Interaksi Sosial & Ruang SMP', 'Menguji pemahaman syarat interaksi sosial, peta tematik, dan pembagian zona waktu di Indonesia.', 2, 5, 1, 1, 'wayground', null, [
                $this->pg('Indonesia terbagi menjadi tiga daerah waktu, yaitu WIB, WITA, dan...', ['WIT', 'WIBT', 'GMT', 'UTC'], 'A'),
                $this->bs('Syarat terjadinya interaksi sosial adalah adanya kontak sosial dan komunikasi.', true),
                $this->isian('Perbandingan jarak pada peta dengan jarak sebenarnya di permukaan bumi disebut...', 'skala'),
                $this->pg('Angin muson barat yang bertiup pada Oktober-April di Indonesia umumnya membawa musim...', ['Kemarau', 'Hujan', 'Pancaroba', 'Dingin'], 'B'),
            ]),
            $this->quiz('Evaluasi Mobilitas Sosial & Pasar SMP', 'Pendalaman lembaga sosial, mobilitas sosial, permintaan, penawaran, dan bentuk pasar SMP.', 2, 5, 1, 2, 'biasa', 25, [
                $this->pg('Perpindahan status sosial seseorang dari kelas bawah ke kelas yang lebih tinggi disebut mobilitas...', ['Vertikal turun', 'Vertikal naik', 'Horizontal', 'Antargenerasi'], 'B'),
                $this->bs('Harga keseimbangan terjadi saat jumlah barang yang diminta sama dengan jumlah barang yang ditawarkan.', true),
                $this->isian('Lembaga sosial yang paling kecil dan pertama membentuk kepribadian anak adalah...', 'keluarga'),
                $this->pg('Pasar yang hanya terdapat satu penjual tetapi melayani banyak pembeli disebut pasar...', ['Persaingan sempurna', 'Monopoli', 'Oligopoli', 'Monopsoni'], 'B'),
            ]),
            $this->quiz('Ulangan Perdagangan Internasional & Benua SMP', 'Ujian mencakup keunggulan komparatif perdagangan antarnegara dan karakteristik benua di dunia.', 2, 5, 2, 3, 'biasa', 35, [
                $this->pg('Kebijakan pemerintah menjual barang di luar negeri lebih murah daripada di dalam negeri disebut...', ['Kuota', 'Tarif', 'Dumping', 'Embargo'], 'C'),
                $this->bs('Benua Australia adalah benua terkecil di dunia yang sebagian besar wilayahnya berupa satu negara.', true),
                $this->isian('Terusan yang menghubungkan Laut Merah dengan Laut Tengah di Mesir adalah Terusan...', 'suez'),
                $this->pg('Berikut yang merupakan faktor pendorong perdagangan internasional adalah...', ['Kesamaan sumber daya alam', 'Perbedaan sumber daya dan teknologi', 'Konflik antarnegara', 'Pembatasan ekspor'], 'B'),
            ]),

            $this->quiz('Kuis Cepat Ilmu Sosial Terintegrasi SMA', 'Uji cepat konsep dasar fenomena sosial, geografis, ekonomi, dan dinamika masyarakat SMA.', 3, 5, 1, 1, 'wayground', null, [
                $this->pg('Ilmu yang mempelajari perilaku manusia dalam memilih dan memanfaatkan sumber daya terbatas adalah ilmu...', ['Antropologi', 'Ekonomi', 'Geologi', 'Demografi'], 'B'),
                $this->bs('Urbanisasi adalah perpindahan penduduk dari wilayah desa menuju ke kota.', true),
                $this->isian('Ilmu yang mempelajari kependudukan seperti kelahiran, kematian, dan migrasi disebut...', 'demografi'),
                $this->pg('Bentuk kerja sama antara dua negara saja disebut kerja sama...', ['Multilateral', 'Regional', 'Bilateral', 'Global'], 'C'),
            ]),
            $this->quiz('Evaluasi Globalisasi & Pembangunan SMA', 'Analisis dampak globalisasi, ketimpangan pembangunan wilayah, dan lembaga keuangan internasional.', 3, 5, 1, 2, 'biasa', 30, [
                $this->pg('Indikator yang sering digunakan untuk mengukur tingkat kesejahteraan rata-rata penduduk suatu negara adalah...', ['Inflasi', 'Pendapatan per kapita', 'Kurs valuta', 'Neraca impor'], 'B'),
                $this->bs('Globalisasi mempercepat pertukaran informasi dan teknologi lintas batas negara.', true),
                $this->isian('Selisih antara total nilai ekspor dan impor barang suatu negara dalam periode tertentu disebut neraca...', 'perdagangan'),
                $this->pg('Organisasi perdagangan dunia yang mengatur aturan main perdagangan antarnegara adalah...', ['WHO', 'WTO', 'UNESCO', 'ILO'], 'B'),
            ]),
            $this->quiz('Ulangan Kajian Sosial Humaniora SMA', 'Evaluasi menyeluruh interaksi geopolitik, kewilayahan, ketenagakerjaan, dan struktur sosial.', 3, 5, 2, 3, 'biasa', 40, [
                $this->pg('Kondisi ketika nilai ekspor suatu negara lebih besar dibandingkan nilai impornya disebut neraca perdagangan...', ['Defisit', 'Surplus', 'Seimbang', 'Resesi'], 'B'),
                $this->bs('Bonus demografi terjadi ketika proporsi penduduk usia produktif lebih besar daripada usia nonproduktif.', true),
                $this->isian('Indeks yang digunakan untuk mengukur ketimpangan distribusi pendapatan suatu negara disebut rasio...', 'gini'),
                $this->pg('Kebijakan bank sentral mengatur jumlah uang beredar dan suku bunga disebut kebijakan...', ['Fiskal', 'Moneter', 'Proteksi', 'Subsidi'], 'B'),
            ]),
        ];
    }

    // 6. Pendidikan Pancasila & Kewarganegaraan (SD +3, SMP +3, SMA +3)
    private function quizzesPpkn(): array
    {
        return [
            $this->quiz('Kuis Cepat Simbol & Sila Pancasila SD', 'Mengenal lima simbol pada perisai Garuda Pancasila beserta pengamalannya sehari-hari.', 1, 6, 1, 1, 'wayground', null, [
                $this->pg('Simbol sila keempat Pancasila yang berbunyi kerakyatan adalah...', ['Bintang', 'Rantai emas', 'Pohon beringin', 'Kepala banteng'], 'D'),
                $this->bs('Pohon beringin merupakan lambang sila ketiga Pancasila, Persatuan Indonesia.', true),
                $this->isian('Semboyan negara Indonesia yang berarti berbeda-beda tetapi tetap satu jua adalah Bhinneka Tunggal...', 'ika'),
                $this->pg('Menghormati teman yang sedang beribadah sesuai agamanya merupakan pengamalan sila ke...', ['Pertama', 'Kedua', 'Keempat', 'Kelima'], 'A'),
            ]),
            $this->quiz('Hak, Kewajiban & Gotong Royong SD', 'Memahami keseimbangan hak dan kewajiban di rumah serta sekolah, serta makna musyawarah.', 1, 6, 1, 2, 'biasa', 20, [
                $this->pg('Membersihkan ruang kelas bersama regu piket merupakan contoh dari...', ['Hak siswa', 'Kewajiban siswa', 'Pelanggaran aturan', 'Hukuman sekolah'], 'B'),
                $this->bs('Musyawarah dilakukan untuk mencapai kata mufakat secara adil dan damai.', true),
                $this->isian('Sikap saling membantu mengerjakan pekerjaan bersama demi kepentingan umum disebut gotong...', 'royong'),
                $this->pg('Mendapatkan pengajaran dan bimbingan dari guru di sekolah merupakan ... siswa.', ['Kewajiban', 'Hak', 'Larangan', 'Tuntutan'], 'B'),
            ]),
            $this->quiz('Ulangan Nilai Kebangsaan & Aturan SD', 'Penilaian materi norma kesopanan, persatuan dalam keberagaman, dan cinta tanah air SD.', 1, 6, 2, 3, 'biasa', 30, [
                $this->pg('Dasar negara Republik Indonesia adalah...', ['UUD 1945', 'Pancasila', 'Tap MPR', 'Peraturan Pemerintah'], 'B'),
                $this->bs('Lagu kebangsaan Indonesia Raya diciptakan oleh W.R. Supratman.', true),
                $this->isian('Warna bendera negara Indonesia adalah merah dan...', 'putih'),
                $this->pg('Memakai produk buatan dalam negeri merupakan bentuk sikap...', ['Individualisme', 'Cinta tanah air', 'Konsumerisme', 'Fanatisme'], 'B'),
            ]),

            $this->quiz('Kuis Cepat Perumusan Pancasila & Norma SMP', 'Uji cepat sejarah BPUPKI, Panitia Sembilan, serta macam-macam norma masyarakat SMP.', 2, 6, 1, 1, 'wayground', null, [
                $this->pg('Badan yang dibentuk untuk menyelidiki usaha persiapan kemerdekaan Indonesia disingkat...', ['PPKI', 'BPUPKI', 'KNIP', 'PETA'], 'B'),
                $this->bs('Hari lahirnya Pancasila diperingati setiap tanggal 1 Juni.', true),
                $this->isian('Norma yang sanksinya bersifat tegas dan memaksa dari aparat negara adalah norma...', 'hukum'),
                $this->pg('Ketua BPUPKI yang memimpin sidang perumusan dasar negara adalah...', ['Ir. Soekarno', 'Dr. Radjiman Wedyodiningrat', 'Moh. Hatta', 'Soepomo'], 'B'),
            ]),
            $this->quiz('UUD 1945 & Tata Urutan Peraturan SMP', 'Memahami kedudukan Pembukaan UUD 1945, hierarki peraturan perundang-undangan, dan Sumpah Pemuda.', 2, 6, 1, 2, 'biasa', 25, [
                $this->pg('Peraturan tertinggi dalam tata urutan peraturan perundang-undangan di Indonesia adalah...', ['Undang-Undang', 'UUD NRI Tahun 1945', 'Peraturan Presiden', 'Peraturan Daerah'], 'B'),
                $this->bs('Sumpah Pemuda diikrarkan pada tanggal 28 Oktober 1928.', true),
                $this->isian('Alinea keempat Pembukaan UUD 1945 memuat tujuan negara dan dasar negara yaitu...', 'pancasila'),
                $this->pg('Lembaga yang berwenang menguji undang-undang terhadap UUD 1945 adalah...', ['Mahkamah Agung', 'Mahkamah Konstitusi', 'Komisi Yudisial', 'KPK'], 'B'),
            ]),
            $this->quiz('Ulangan Kebangkitan Nasional & Wawasan Nusantara SMP', 'Evaluasi makna Kebangkitan Nasional 1908, persatuan bangsa, dan bela negara.', 2, 6, 2, 3, 'biasa', 35, [
                $this->pg('Organisasi modern pertama yang menandai Kebangkitan Nasional tahun 1908 adalah...', ['Sarekat Islam', 'Budi Utomo', 'Indische Partij', 'Taman Siswa'], 'B'),
                $this->bs('Bela negara hanya menjadi kewajiban anggota TNI dan Polri saja.', false),
                $this->isian('Cara pandang bangsa Indonesia mengenai diri dan lingkungannya berdasarkan Pancasila disebut wawasan...', 'nusantara'),
                $this->pg('Pasal dalam UUD 1945 yang mengatur bahwa bentuk negara Indonesia adalah kesatuan berbentuk republik adalah...', ['Pasal 1 ayat 1', 'Pasal 2 ayat 1', 'Pasal 27 ayat 1', 'Pasal 33 ayat 1'], 'A'),
            ]),

            $this->quiz('Kuis Cepat Ideologi & Konstitusi SMA', 'Menguji pemahaman Pancasila sebagai ideologi terbuka dan pembagian kekuasaan negara SMA.', 3, 6, 1, 1, 'wayground', null, [
                $this->pg('Pancasila bersifat fleksibel mengikuti perkembangan zaman tanpa kehilangan nilai dasarnya karena merupakan ideologi...', ['Tertutup', 'Terbuka', 'Kaku', 'Pragmatis'], 'B'),
                $this->bs('Sistem pemerintahan Indonesia menurut UUD 1945 hasil amandemen menganut sistem presidensial.', true),
                $this->isian('Lembaga negara yang memegang kekuasaan membentuk undang-undang bersama Presiden adalah...', 'dpr'),
                $this->pg('Nilai dalam Pancasila yang tidak dapat diubah oleh siapa pun disebut nilai...', ['Instrumental', 'Praksis', 'Dasar', 'Tambahan'], 'C'),
            ]),
            $this->quiz('Evaluasi HAM, Demokrasi & Hubungan Internasional SMA', 'Pendalaman penegakan HAM, prinsip demokrasi Pancasila, dan politik luar negeri bebas aktif.', 3, 6, 1, 2, 'biasa', 30, [
                $this->pg('Politik luar negeri Indonesia memiliki sifat...', ['Blok Barat', 'Blok Timur', 'Bebas aktif', 'Isolasionis'], 'C'),
                $this->bs('Komnas HAM adalah lembaga mandiri yang bertugas mengkaji, meneliti, dan memantau pelaksanaan hak asasi manusia.', true),
                $this->isian('Asas pemilihan umum di Indonesia disingkat LUBER dan...', 'jurdil'),
                $this->pg('Pelanggaran HAM berat seperti genosida dan kejahatan terhadap kemanusiaan diadili melalui...', ['Pengadilan Negeri', 'Pengadilan HAM', 'PTUN', 'Pengadilan Agama'], 'B'),
            ]),
            $this->quiz('Ulangan NKRI, IPTEKS & Integrasi Nasional SMA', 'Ujian tingkat lanjut tentang ancaman terhadap NKRI, pengaruh IPTEK, dan dinamika persatuan bangsa.', 3, 6, 2, 3, 'biasa', 40, [
                $this->pg('Sikap merasa kebudayaan daerah atau sukunya paling unggul dan merendahkan suku lain disebut...', ['Nasionalisme', 'Etnosentrisme', 'Patriotisme', 'Pluralisme'], 'B'),
                $this->bs('Integrasi nasional adalah usaha menyatukan berbagai kelompok sosial budaya dalam satu kesatuan wilayah yang harmonis.', true),
                $this->isian('Sistem pertahanan dan keamanan negara Indonesia melibatkan seluruh rakyat yang dikenal dengan istilah...', 'sishankamrata'),
                $this->pg('Lembaga yang bertugas memeriksa pengelolaan dan tanggung jawab keuangan negara adalah...', ['BPK', 'Bappenas', 'OJK', 'BPS'], 'A'),
            ]),
        ];
    }

    // 7. Pendidikan Agama & Budi Pekerti (SD +3, SMP +3, SMA +3)
    private function quizzesAgama(): array
    {
        return [
            $this->quiz('Kuis Cepat Akhlak Terpuji & Sopan Santun SD', 'Mengenal perilaku jujur, hormat kepada orang tua, dan toleransi antarsesama untuk siswa SD.', 1, 7, 1, 1, 'wayground', null, [
                $this->pg('Berkata apa adanya dan tidak berbohong merupakan perilaku...', ['Sombong', 'Jujur', 'Malas', 'Iri hati'], 'B'),
                $this->bs('Berbicara lembut dan santun kepada kedua orang tua merupakan perilaku terpuji.', true),
                $this->isian('Sikap saling menghormati antarumat beragama disebut...', 'toleransi'),
                $this->pg('Apabila teman mengalami kesulitan saat belajar, sikap terbaik kita adalah...', ['Menertawakannya', 'Membantunya dengan tulus', 'Mengabaikannya', 'Memarahinya'], 'B'),
            ]),
            $this->quiz('Evaluasi Peduli Lingkungan & Kasih Sayang SD', 'Menanamkan sikap amanah, bersyukur, menyayangi sesama makhluk, dan menjaga kebersihan.', 1, 7, 1, 2, 'biasa', 20, [
                $this->pg('Mengembalikan barang temuan kepada pemiliknya menunjukkan sikap...', ['Amanah', 'Ria', 'Kikir', 'Gegabah'], 'A'),
                $this->bs('Menjaga kebersihan sekolah dan merawat tanaman adalah wujud rasa syukur atas ciptaan Tuhan.', true),
                $this->isian('Mengucapkan terima kasih saat menerima bantuan merupakan cerminan sikap tahu...', 'bersyukur'),
                $this->pg('Ketika melakukan kesalahan kepada teman, kita sebaiknya segera...', ['Menyalahkan orang lain', 'Meminta maaf', 'Bersembunyi', 'Berpura-pura lupa'], 'B'),
            ]),
            $this->quiz('Ulangan Budi Pekerti & Karakter Mulia SD', 'Penilaian penerapan empati, disiplin ibadah, kerja sama, dan menghindari sifat tercela SD.', 1, 7, 2, 3, 'biasa', 30, [
                $this->pg('Sikap yang ikut merasakan kesedihan atau kesulitan orang lain disebut...', ['Apatis', 'Empati', 'Egois', 'Takabur'], 'B'),
                $this->bs('Sifat dendam dan iri hati dapat merusak kerukunan dalam pertemanan.', true),
                $this->isian('Lawan dari sifat rendah hati adalah...', 'sombong'),
                $this->pg('Menjaga kerukunan dengan tetangga meskipun berbeda keyakinan mencerminkan...', ['Permusuhan', 'Persatuan dan toleransi', 'Persaingan', 'Keterasingan'], 'B'),
            ]),

            $this->quiz('Kuis Cepat Etika Remaja & Kejujuran SMP', 'Uji cepat nilai integritas, adab bergaul, dan menjauhi perundungan di lingkungan sekolah SMP.', 2, 7, 1, 1, 'wayground', null, [
                $this->pg('Perilaku menyakiti teman secara fisik maupun verbal berulang kali di sekolah disebut...', ['Gotong royong', 'Perundungan (bullying)', 'Solidaritas', 'Musyawarah'], 'B'),
                $this->bs('Integritas berarti kesesuaian antara ucapan dan perbuatan yang jujur.', true),
                $this->isian('Sifat rendah hati dan tidak membanggakan diri disebut...', 'tawaduk'),
                $this->pg('Saat mengerjakan ujian sekolah, perilaku yang mencerminkan integritas adalah...', ['Menyontek teman', 'Membuka catatan tersembunyi', 'Mengerjakan secara mandiri dan jujur', 'Bertukar jawaban'], 'C'),
            ]),
            $this->quiz('Evaluasi Toleransi & Amanah Sosial SMP', 'Pendalaman adab bermedia sosial, pengendalian diri, dan sikap dermawan bagi remaja.', 2, 7, 1, 2, 'biasa', 25, [
                $this->pg('Sebelum menyebarkan berita di media sosial, sikap bijak yang harus dilakukan adalah...', ['Langsung membagikan', 'Memeriksa kebenaran informasi', 'Menambah komentar provokatif', 'Menyalin tanpa membaca'], 'B'),
                $this->bs('Berbagi sebagian rezeki kepada orang yang membutuhkan melatih sifat kedermawanan.', true),
                $this->isian('Pengendalian diri dari amarah dan hawa nafsu mencerminkan sikap...', 'sabar'),
                $this->pg('Menepati janji yang telah dibuat kepada teman termasuk wujud dari sikap...', ['Amanah', 'Ingkar', 'Ceroboh', 'Lalainya tanggung jawab'], 'A'),
            ]),
            $this->quiz('Ulangan Akhlak Mulia & Kerukunan Umat SMP', 'Ujian penerapan etika komunikasi, bakti kepada guru, dan moderasi beragama tingkat SMP.', 2, 7, 2, 3, 'biasa', 35, [
                $this->pg('Menghormati guru dan mendengarkan penjelasan pelajaran dengan saksama merupakan...', ['Adab menuntut ilmu', 'Pelanggaran tata tertib', 'Sikap acuh tak acuh', 'Pemborosan waktu'], 'A'),
                $this->bs('Berprasangka baik (husnuzan) membantu menjaga keharmonisan antarmanusia.', true),
                $this->isian('Perbuatan membicarakan keburukan orang lain di belakangnya disebut...', 'gibah'),
                $this->pg('Sikap moderat berarti mengambil jalan tengah yang adil dan menghormati...', ['Kekerasan', 'Keberagaman', 'Diskriminasi', 'Ekstremisme'], 'B'),
            ]),

            $this->quiz('Kuis Cepat Etika Moral & Kehidupan Modern SMA', 'Menguji pemahaman etika digital, tanggung jawab sosial, dan nilai spiritualitas bagi pelajar SMA.', 3, 7, 1, 1, 'wayground', null, [
                $this->pg('Kemampuan berpikir positif dan mencari solusi konstruktif saat menghadapi kegagalan menunjukkan sikap...', ['Putus asa', 'Optimis', 'Pesimis', 'Apatis'], 'B'),
                $this->bs('Etika dalam menggunakan teknologi digital mencakup penghormatan terhadap hak privasi orang lain.', true),
                $this->isian('Keadaan di mana seseorang bekerja keras dan bersungguh-sungguh demi meraih cita-cita disebut...', 'ikhtiar'),
                $this->pg('Kompetisi dalam kebaikan di lingkungan sekolah sebaiknya dilakukan secara...', ['Curang dan saling menjatuhkan', 'Sehat dan saling memotivasi', 'Diam-diam menipu', 'Mengabaikan aturan'], 'B'),
            ]),
            $this->quiz('Evaluasi Moderasi & Tanggung Jawab Publik SMA', 'Analisis sikap toleransi beragama, kepemimpinan beretika, dan kepedulian sosial masyarakat.', 3, 7, 1, 2, 'biasa', 30, [
                $this->pg('Pemimpin yang adil dan mendahulukan kepentingan umum di atas kepentingan pribadi mencerminkan nilai...', ['Nepotisme', 'Amanah dan keadilan', 'Otoritarianisme', 'Individualisme'], 'B'),
                $this->bs('Moderasi beragama mengajarkan penghormatan terhadap keyakinan orang lain tanpa mengorbankan prinsip iman sendiri.', true),
                $this->isian('Sikap merasa cukup dan bersyukur atas hasil usaha yang diraih disebut...', 'qanaah'),
                $this->pg('Menghindari ujaran kebencian di dunia nyata maupun digital bertujuan menjaga...', ['Perpecahan bangsa', 'Persaudaraan dan kedamaian', 'Konflik horizontal', 'Ketegangan sosial'], 'B'),
            ]),
            $this->quiz('Ulangan Falsafah Budi Pekerti & Kemanusiaan SMA', 'Ujian komprehensif tentang nilai keadilan sosial, kejujuran ilmiah, dan etika peradaban.', 3, 7, 2, 3, 'biasa', 40, [
                $this->pg('Kejujuran akademik dalam menyusun karya ilmiah diwujudkan dengan cara...', ['Melakukan plagiarisme', 'Mencantumkan sumber kutipan dengan benar', 'Memanipulasi data penelitian', 'Menyalin tugas teman'], 'B'),
                $this->bs('Menegakkan keadilan tanpa memandang status sosial merupakan perintah luhur ajaran agama dan moralitas.', true),
                $this->isian('Tindakan mengambil atau menyalin karya orang lain tanpa izin dan mengakuinya sebagai karya sendiri disebut...', 'plagiarisme'),
                $this->pg('Peran pelajar sebagai agen perubahan sosial yang bermoral adalah...', ['Menyebarkan hoaks', 'Menjadi teladan integritas dan kepedulian', 'Bersikap masa bodoh terhadap lingkungan', 'Mengutamakan ego pribadi'], 'B'),
            ]),
        ];
    }

    // 8. Informatika & TIK (SD +3, SMP +2, SMA +3)
    private function quizzesInformatika(): array
    {
        return [
            $this->quiz('Kuis Cepat Mengenal Perangkat Komputer SD', 'Mengenal fungsi monitor, keyboard, mouse, printer, dan perangkat digital sehari-hari.', 1, 8, 1, 1, 'wayground', null, [
                $this->pg('Perangkat keras komputer yang digunakan untuk mengetik huruf dan angka adalah...', ['Mouse', 'Monitor', 'Keyboard', 'Speaker'], 'C'),
                $this->bs('Monitor berfungsi menampilkan gambar dan teks kepada pengguna komputer.', true),
                $this->isian('Alat penunjuk kursor di layar komputer yang digerakkan dengan tangan disebut...', 'mouse'),
                $this->pg('Perangkat untuk mencetak dokumen dari komputer ke kertas adalah...', ['Scanner', 'Printer', 'Webcam', 'Modem'], 'B'),
            ]),
            $this->quiz('Logika Berpikir Komputasional & Keamanan Dasar SD', 'Mengenal pola urutan langkah (algoritma sederhana) dan etika penggunaan gawai yang aman.', 1, 8, 1, 2, 'biasa', 20, [
                $this->pg('Urutan langkah-langkah yang jelas untuk menyelesaikan suatu tugas disebut...', ['Algoritma', 'Wallpaper', 'Ikon', 'Baterai'], 'A'),
                $this->bs('Kata sandi (password) akun pribadi boleh dibagikan ke semua teman di internet.', false),
                $this->isian('Program perangkat lunak yang digunakan untuk mengetik dan mengolah dokumen teks disebut pengolah...', 'kata'),
                $this->pg('Tombol pintasan pada keyboard untuk menyalin (copy) teks adalah...', ['Ctrl + V', 'Ctrl + C', 'Ctrl + X', 'Ctrl + Z'], 'B'),
            ]),
            $this->quiz('Ulangan Literasi Digital Dasar SD', 'Evaluasi pengenalan internet sehat, folder berkas, serta perangkat masukan dan keluaran.', 1, 8, 2, 3, 'biasa', 30, [
                $this->pg('Aplikasi peramban (browser) digunakan untuk...', ['Mencetak foto', 'Menjelajah halaman web di internet', 'Menghitung listrik', 'Mengisi daya laptop'], 'B'),
                $this->bs('Speaker merupakan perangkat keluaran (output) yang menghasilkan suara.', true),
                $this->isian('Tempat penyimpanan digital untuk mengelompokkan beberapa file di komputer disebut...', 'folder'),
                $this->pg('Jika menemui pesan mencurigakan dari orang tak dikenal di internet, langkah yang benar adalah...', ['Mengklik semua tautan', 'Melaporkan kepada orang tua atau guru', 'Memberikan alamat rumah', 'Membalas dengan kata sandi'], 'B'),
            ]),

            $this->quiz('Kuis Cepat Jaringan Komputer & Bilangan Biner SMP', 'Uji cepat konsep sistem bilangan biner, LAN/WAN, dan keamanan siber tingkat SMP.', 2, 8, 1, 1, 'wayground', null, [
                $this->pg('Sistem bilangan biner yang digunakan komputer hanya terdiri atas angka...', ['0 dan 1', '1 dan 2', '0 sampai 9', 'A sampai F'], 'A'),
                $this->bs('RAM berfungsi sebagai memori penyimpanan sementara saat komputer menjalankan program.', true),
                $this->isian('Singkatan dari jaringan lokal dalam satu gedung atau sekolah adalah...', 'lan'),
                $this->pg('Angka desimal 5 jika dikonversi menjadi bilangan biner bernilai...', ['100', '101', '110', '111'], 'B'),
            ]),
            $this->quiz('Evaluasi Algoritma, Flowchart & Pengolah Angka SMP', 'Latihan simbol diagram alir, rumus dasar spreadsheet (SUM, AVERAGE), dan privasi data.', 2, 8, 1, 2, 'biasa', 25, [
                $this->pg('Fungsi pada aplikasi pengolah angka (spreadsheet) untuk menghitung nilai rata-rata adalah...', ['SUM', 'MAX', 'AVERAGE', 'COUNT'], 'C'),
                $this->bs('Simbol belah ketupat pada flowchart digunakan untuk menyatakan percabangan atau keputusan.', true),
                $this->isian('Perangkat lunak berbahaya yang dapat merusak sistem atau mencuri data komputer disebut...', 'malware'),
                $this->pg('Ekstensi berkas standar untuk gambar yang sering digunakan di web adalah...', ['.mp3', '.png', '.exe', '.xlsx'], 'B'),
            ]),

            $this->quiz('Kuis Cepat Struktur Data & Logika Pemrograman SMA', 'Uji cepat konsep array, stack, queue, perulangan, dan percabangan dalam pemrograman SMA.', 3, 8, 1, 1, 'wayground', null, [
                $this->pg('Struktur data yang menggunakan prinsip LIFO (Last In, First Out) adalah...', ['Queue', 'Stack', 'Tree', 'Graph'], 'B'),
                $this->bs('Struktur data Queue (antrean) bekerja dengan prinsip FIFO (First In, First Out).', true),
                $this->isian('Struktur data linear yang menyimpan kumpulan elemen bertipe sama secara berurutan dalam satu variabel disebut...', 'array'),
                $this->pg('Dalam logika pemrograman, operator yang menghasilkan nilai benar hanya jika kedua kondisi benar adalah...', ['OR', 'AND', 'NOT', 'XOR'], 'B'),
            ]),
            $this->quiz('Evaluasi Basis Data, Jaringan & HTTP SMA', 'Pendalaman model relasional SQL, protokol jaringan TCP/IP, HTTP, dan enkripsi data.', 3, 8, 1, 2, 'biasa', 30, [
                $this->pg('Perintah SQL untuk mengambil data dari tabel database adalah...', ['INSERT', 'UPDATE', 'SELECT', 'DELETE'], 'C'),
                $this->bs('Protokol HTTPS menggunakan enkripsi SSL/TLS untuk mengamankan pertukaran data di web.', true),
                $this->isian('Kunci unik yang membedakan setiap baris data dalam sebuah tabel basis data disebut primary...', 'key'),
                $this->pg('Sistem yang menerjemahkan nama domain seperti google.com menjadi alamat IP adalah...', ['DHCP', 'DNS', 'FTP', 'SMTP'], 'B'),
            ]),
            $this->quiz('Ulangan Kecerdasan Buatan & Keamanan Siber SMA', 'Ujian tingkat lanjut konsep machine learning dasar, phishing, otentikasi dua faktor, dan dampak sosial TI.', 3, 8, 2, 3, 'biasa', 40, [
                $this->pg('Teknik penipuan digital dengan menyamar sebagai pihak resmi untuk mencuri kredensial akun disebut...', ['Caching', 'Phishing', 'Debugging', 'Routing'], 'B'),
                $this->bs('Two-Factor Authentication (2FA) menambah lapisan keamanan selain kata sandi.', true),
                $this->isian('Cabang ilmu komputer yang membuat mesin mampu belajar dari data dan mengenali pola disebut machine...', 'learning'),
                $this->pg('Proses mencari dan memperbaiki kesalahan (bug) dalam kode program disebut...', ['Compiling', 'Debugging', 'Refactoring', 'Deployment'], 'B'),
            ]),
        ];
    }

    // 9. Seni Budaya & Prakarya (SD +3, SMP +3, SMA +3)
    private function quizzesSeniBudaya(): array
    {
        return [
            $this->quiz('Kuis Cepat Warna Primer & Alat Musik SD', 'Mengenal warna dasar, alat musik ritmis/melodis sederhana, dan kerajinan tangan SD.', 1, 9, 1, 1, 'wayground', null, [
                $this->pg('Berikut yang termasuk warna primer adalah...', ['Merah, Kuning, Biru', 'Hijau, Ungu, Jingga', 'Hitam, Putih, Abu-abu', 'Cokelat, Merah Muda, Perak'], 'A'),
                $this->bs('Campuran warna biru dan kuning menghasilkan warna hijau.', true),
                $this->isian('Alat musik tradisional Jawa Barat yang dimainkan dengan cara digoyangkan adalah...', 'angklung'),
                $this->pg('Seni melipat kertas dari Jepang yang populer dijadikan prakarya sekolah adalah...', ['Mozaik', 'Origami', 'Kolase', 'Montase'], 'B'),
            ]),
            $this->quiz('Evaluasi Tari Daerah & Prakarya Bahan Alam SD', 'Memahami tari tradisional Nusantara, tempo lagu, dan kerajinan dari bahan alam atau bekas.', 1, 9, 1, 2, 'biasa', 20, [
                $this->pg('Tari Pendet dan Tari Kecak merupakan tarian daerah yang berasal dari...', ['Jawa Timur', 'Bali', 'Sumatera Utara', 'Papua'], 'B'),
                $this->bs('Karya seni kolase dibuat dengan cara menempelkan berbagai potongan bahan pada permukaan gambar.', true),
                $this->isian('Unsur utama dalam seni tari adalah gerak, irama, dan...', 'ekspresi'),
                $this->pg('Alat musik berikut yang dimainkan dengan cara dipetik adalah...', ['Seruling', 'Gendang', 'Sasando', 'Simbal'], 'C'),
            ]),
            $this->quiz('Ulangan Seni Rupa & Budaya Nusantara SD', 'Evaluasi pengenalan motif batik dasar, pola lantai tari, dan lagu daerah Indonesia.', 1, 9, 2, 3, 'biasa', 30, [
                $this->pg('Lagu daerah "Ampar-Ampar Pisang" berasal dari provinsi...', ['Kalimantan Selatan', 'Sulawesi Utara', 'Maluku', 'Lampung'], 'A'),
                $this->bs('Batik Indonesia telah diakui UNESCO sebagai Warisan Budaya Takbenda Dunia.', true),
                $this->isian('Alat khusus yang digunakan untuk melukis motif batik dengan lilin malam adalah...', 'canting'),
                $this->pg('Unsur seni rupa yang paling dasar sebagai awal pembentukan garis dan bidang adalah...', ['Tekstur', 'Titik', 'Gelap terang', 'Ruang'], 'B'),
            ]),

            $this->quiz('Kuis Cepat Unsur Seni Rupa & Musik Tradisional SMP', 'Uji cepat prinsip komposisi seni rupa, jenis suara vokal, dan ansambel musik SMP.', 2, 9, 1, 1, 'wayground', null, [
                $this->pg('Jenis suara tertinggi pada penyanyi wanita dewasa disebut...', ['Alto', 'Sopran', 'Tenor', 'Bass'], 'B'),
                $this->bs('Gamelan merupakan seperangkat alat musik tradisional ansambel dari Jawa dan Bali.', true),
                $this->isian('Teknik menggambar dengan menutup objek menggunakan satu warna penuh secara merata disebut teknik...', 'siluet'),
                $this->pg('Suara rendah pada penyanyi pria dewasa dikenal dengan istilah...', ['Bariton', 'Tenor', 'Bass', 'Mezzo-sopran'], 'C'),
            ]),
            $this->quiz('Evaluasi Ragam Hias, Teater & Kerajinan SMP', 'Pendalaman teknik menggambar perspektif, ragam hias flora/fauna, serta seni peran teater.', 2, 9, 1, 2, 'biasa', 25, [
                $this->pg('Patung atau relief yang hanya dapat dinikmati keindahannya dari arah depan disebut seni rupa...', ['Tiga dimensi', 'Dua dimensi', 'Abstrak', 'Arsitektur'], 'B'),
                $this->bs('Pementasan teater membutuhkan tata panggung, tata suara, dan tata cahaya.', true),
                $this->isian('Proses mengukir motif pada media kayu atau batu disebut seni...', 'pahat'),
                $this->pg('Teknik membuat kerajinan keramik dari tanah liat dengan memutar meja khusus disebut teknik...', ['Pijat', 'Putar', 'Pilinan', 'Cetak tuang'], 'B'),
            ]),
            $this->quiz('Ulangan Apresiasi Seni & Musik Modern SMP', 'Evaluasi kritik karya seni, aransemen vokal grup, dan pameran seni rupa sekolah.', 2, 9, 2, 3, 'biasa', 35, [
                $this->pg('Kegiatan penyajian karya seni rupa agar dapat diapresiasi masyarakat luas disebut...', ['Lelang', 'Pameran', 'Konser', 'Bazar'], 'B'),
                $this->bs('Karya seni rupa tiga dimensi memiliki ukuran panjang, lebar, dan volume atau ruang.', true),
                $this->isian('Rangkaian nada-nada yang disusun secara berurutan sehingga terdengar indah disebut...', 'melodi'),
                $this->pg('Dalam seni grafis, teknik mencetak menggunakan klise atau acuan berlubang (screen) disebut cetak...', ['Tinggi', 'Dalam', 'Saring (sablon)', 'Datar'], 'C'),
            ]),

            $this->quiz('Kuis Cepat Aliran Seni Rupa & Musik Modern SMA', 'Mengenal aliran seni rupa realisme, impresionisme, kubisme, dan perkembangan musik modern SMA.', 3, 9, 1, 1, 'wayground', null, [
                $this->pg('Aliran seni lukis yang menggambarkan objek secara persis dan nyata sebagaimana aslinya adalah...', ['Kubisme', 'Realisme', 'Surealisme', 'Ekspresionisme'], 'B'),
                $this->bs('Affandi merupakan salah satu maestro seni lukis terkenal dari Indonesia beraliran ekspresionisme.', true),
                $this->isian('Aliran seni lukis yang menampilkan objek bagaikan alam mimpi dan imajinasi bawah sadar disebut...', 'surealisme'),
                $this->pg('Gabungan tiga nada atau lebih yang dibunyikan secara bersamaan dan harmonis dalam musik disebut...', ['Tempo', 'Akord', 'Birama', 'Dinamika'], 'B'),
            ]),
            $this->quiz('Evaluasi Kritik Seni, Koreografi & Teater Modern SMA', 'Pendalaman konsep koreografi tari kreasi, kritik karya seni, dan penyutradaraan teater.', 3, 9, 1, 2, 'biasa', 30, [
                $this->pg('Tahap pertama dalam melakukan kritik karya seni rupa secara sistematis adalah...', ['Evaluasi', 'Deskripsi', 'Interpretasi', 'Penilaian akhir'], 'B'),
                $this->bs('Koreografi adalah seni merancang dan menyusun komposisi gerak tari.', true),
                $this->isian('Naskah tertulis yang berisi dialog dan petunjuk pementasan drama disebut...', 'skenario'),
                $this->pg('Seni rupa yang diciptakan semata-mata untuk tujuan fungsi praktis atau guna pakai disebut seni rupa...', ['Murni', 'Terapan', 'Kontemporer', 'Minimalis'], 'B'),
            ]),
            $this->quiz('Ulangan Seni Kontemporer & Manajemen Pertunjukan SMA', 'Evaluasi tata kelola pergelaran seni, seni instalasi, dan kewirausahaan kreatif SMA.', 3, 9, 2, 3, 'biasa', 40, [
                $this->pg('Panitia pameran yang bertugas menyeleksi dan menyusun penataan karya seni disebut...', ['Kurator', 'Bendahara', 'Protokoler', 'Sponsor'], 'A'),
                $this->bs('Seni kontemporer adalah karya seni yang merespons isu serta perkembangan zaman masa kini tanpa terikat pakem lama.', true),
                $this->isian('Perpaduan antara warna hangat dan warna dingin yang saling berseberangan pada roda warna disebut warna...', 'komplementer'),
                $this->pg('Dalam manajemen pertunjukan musik, pimpinan yang mengarahkan keselarasan permainan orkestra adalah...', ['Koreografer', 'Konduktor', 'Sutradara', 'Aktor'], 'B'),
            ]),
        ];
    }

    // 10. PJOK (Olahraga) (SD +3, SMP +3, SMA +3)
    private function quizzesPjok(): array
    {
        return [
            $this->quiz('Kuis Cepat Gerak Dasar & Pemanasan SD', 'Mengenal gerak lokomotor, nonlokomotor, manipulatif, dan manfaat pemanasan sebelum olahraga.', 1, 10, 1, 1, 'wayground', null, [
                $this->pg('Gerakan berpindah tempat seperti berlari dan melompat termasuk gerak...', ['Nonlokomotor', 'Lokomotor', 'Statis', 'Refleks'], 'B'),
                $this->bs('Pemanasan sebelum berolahraga membantu mengurangi risiko cedera otot.', true),
                $this->isian('Gerakan melempar dan menangkap bola termasuk contoh gerak...', 'manipulatif'),
                $this->pg('Setelah selesai berolahraga berat, gerakan yang perlu dilakukan untuk mengembalikan detak jantung normal adalah...', ['Sprint', 'Pendinginan', 'Lompat jauh', 'Push up'], 'B'),
            ]),
            $this->quiz('Permainan Bola Kecil & Kebersihan Diri SD', 'Memahami aturan dasar permainan kasti, senam lantai sederhana, serta pola hidup bersih dan sehat.', 1, 10, 1, 2, 'biasa', 20, [
                $this->pg('Permainan kasti merupakan jenis permainan bola...', ['Besar', 'Kecil', 'Air', 'Meja'], 'B'),
                $this->bs('Mencuci tangan dengan sabun setelah bermain membantu mencegah kuman penyakit masuk ke tubuh.', true),
                $this->isian('Induk organisasi sepak bola di Indonesia adalah...', 'pssi'),
                $this->pg('Latihan bertumpu dengan satu kaki bertujuan melatih...', ['Kecepatan lari', 'Keseimbangan tubuh', 'Tinggi badan', 'Daya tahan napas'], 'B'),
            ]),
            $this->quiz('Ulangan Kebugaran & Atletik Dasar SD', 'Evaluasi lari jarak pendek, lompat jauh, renang gaya dada, dan gizi seimbang anak SD.', 1, 10, 2, 3, 'biasa', 30, [
                $this->pg('Zat gizi utama yang berfungsi sebagai sumber energi bagi tubuh adalah...', ['Vitamin', 'Karbohidrat', 'Mineral', 'Air'], 'B'),
                $this->bs('Lari jarak pendek (sprint) menggunakan aba-aba start jongkok.', true),
                $this->isian('Jumlah pemain dalam satu tim sepak bola di lapangan adalah ... orang.', '11'),
                $this->pg('Olahraga renang bermanfaat terutama untuk melatih kekuatan otot dan...', ['Pendengaran', 'Pernapasan', 'Penglihatan', 'Penciuman'], 'B'),
            ]),

            $this->quiz('Kuis Cepat Permainan Bola Besar & Atletik SMP', 'Uji cepat teknik dasar sepak bola, bola basket, bola voli, dan nomor cabang atletik SMP.', 2, 10, 1, 1, 'wayground', null, [
                $this->pg('Teknik mengoper bola dalam permainan bola basket dari depan dada disebut...', ['Bounce pass', 'Chest pass', 'Overhead pass', 'Dribble'], 'B'),
                $this->bs('Dalam permainan bola voli, satu tim di lapangan terdiri atas 6 pemain.', true),
                $this->isian('Teknik memantul-mantulkan bola dengan satu tangan ke lantai dalam bola basket disebut...', 'dribble'),
                $this->pg('Lompat jauh memiliki empat tahapan, yaitu awalan, tolakan, melayang di udara, dan...', ['Berlari', 'Mendarat', 'Berbalik', 'Menghindar'], 'B'),
            ]),
            $this->quiz('Evaluasi Kebugaran Jasmani & Senam Irama SMP', 'Pendalaman komponen kebugaran jasmani (kekuatan, kelincahan, daya tahan) dan pencak silat.', 2, 10, 1, 2, 'biasa', 25, [
                $this->pg('Latihan push up secara rutin sangat efektif untuk meningkatkan kekuatan otot...', ['Kaki', 'Lengan dan dada', 'Leher', 'Betis'], 'B'),
                $this->bs('Lari bolak-balik (shuttle run) digunakan untuk melatih kelincahan.', true),
                $this->isian('Seni bela diri tradisional asli yang berasal dari kepulauan Nusantara adalah pencak...', 'silat'),
                $this->pg('Tes lari selama 12 menit (Cooper test) umumnya digunakan untuk mengukur...', ['Kelenturan', 'Daya tahan jantung dan paru', 'Keseimbangan', 'Kecepatan reaksi'], 'B'),
            ]),
            $this->quiz('Ulangan Pertolongan Pertama & Hidup Sehat SMP', 'Evaluasi prinsip P3K cedera olahraga, bahaya rokok/narkotika, dan aktivitas akuatik SMP.', 2, 10, 2, 3, 'biasa', 35, [
                $this->pg('Langkah pertama penanganan cedera keseleo ringan dengan prinsip RICE huruf "I" berarti...', ['Injection', 'Ice (kompres es)', 'Ignore', 'Iron'], 'B'),
                $this->bs('Konsumsi air putih yang cukup membantu mencegah dehidrasi selama beraktivitas fisik.', true),
                $this->isian('Dalam bulu tangkis, bola yang dipukul menggunakan raket disebut...', 'shuttlecock'),
                $this->pg('Gaya renang yang gerakannya menyerupai katak adalah gaya...', ['Bebas', 'Punggung', 'Dada', 'Kupu-kupu'], 'C'),
            ]),

            $this->quiz('Kuis Cepat Taktik Olahraga & Atletik SMA', 'Uji cepat strategi permainan bola besar, nomor estafet, dan peraturan pertandingan resmi SMA.', 3, 10, 1, 1, 'wayground', null, [
                $this->pg('Dalam lari estafet 4 x 100 meter, tongkat estafet diserahkan dari pelari ke pelari di dalam zona pergantian yang disebut...', ['Finish line', 'Wissel zone', 'Penalty box', 'Starting block'], 'B'),
                $this->bs('Formasi 4-4-2 dalam sepak bola menunjukkan 4 bek, 4 gelandang, dan 2 penyerang.', true),
                $this->isian('Pelanggaran dalam bola basket ketika pemain membawa bola tanpa memantulkannya lebih dari dua langkah disebut...', 'traveling'),
                $this->pg('Pemain bertahan khusus dalam bola voli yang memakai seragam berbeda dan tidak boleh melakukan smash di area depan adalah...', ['Tosser', 'Smasher', 'Libero', 'Blocker'], 'C'),
            ]),
            $this->quiz('Evaluasi Program Latihan & Anatomi Gerak SMA', 'Pendalaman prinsip FITT, denyut nadi latihan maksimal, dan gizi olahraga untuk remaja SMA.', 3, 10, 1, 2, 'biasa', 30, [
                $this->pg('Rumus sederhana untuk memperkirakan denyut nadi maksimal per menit seseorang adalah...', ['200 - usia', '220 - usia', '180 + usia', '150 - usia'], 'B'),
                $this->bs('Latihan anaerobik berlangsung dengan intensitas tinggi dalam waktu singkat tanpa bergantung penuh pada suplai oksigen.', true),
                $this->isian('Dalam prinsip latihan FITT, huruf "F" merupakan singkatan dari...', 'frequency'),
                $this->pg('Latihan peregangan statis paling ideal dilakukan dengan durasi tahan sekitar...', ['1 detik', '10 sampai 30 detik', '10 menit per otot', '1 jam'], 'B'),
            ]),
            $this->quiz('Ulangan Sport Science & Penyelamatan Air SMA', 'Ujian tingkat lanjut meliputi manajemen turnamen, kesehatan reproduksi remaja, dan penyelamatan air.', 3, 10, 2, 3, 'biasa', 40, [
                $this->pg('Sistem pertandingan di mana peserta langsung terhenti jika mengalami satu kali kekalahan adalah sistem...', ['Setengah kompetisi', 'Kompetisi penuh', 'Gugur tunggal', 'Round robin'], 'C'),
                $this->bs('Overtraining terjadi ketika tubuh berlatih terlalu keras tanpa waktu pemulihan yang memadai.', true),
                $this->isian('Induk organisasi cabang olahraga atletik di Indonesia disingkat...', 'pasi'),
                $this->pg('Dalam bola voli, skor kemenangan standar pada satu set reguler (set 1-4) adalah ... poin dengan selisih minimal 2.', ['15', '21', '25', '30'], 'C'),
            ]),
        ];
    }

    // 11. Fisika (SMA +2)
    private function quizzesFisika(): array
    {
        return [
            $this->quiz('Kuis Cepat Dinamika Gerak & Hukum Newton SMA', 'Uji cepat konsep kinematika, gaya gesek, usaha, energi mekanik, dan hukum Newton SMA.', 3, 11, 1, 1, 'wayground', null, [
                $this->pg('Hukum Newton yang menyatakan bahwa percepatan benda berbanding lurus dengan gaya resultan dan berbanding terbalik dengan massanya adalah Hukum...', ['Newton I', 'Newton II', 'Newton III', 'Kepler I'], 'B'),
                $this->bs('Energi mekanik adalah penjumlahan dari energi potensial dan energi kinetik suatu benda.', true),
                $this->isian('Satuan internasional untuk usaha dan energi adalah...', 'joule'),
                $this->pg('Sebuah benda bermassa 4 kg diberi gaya 20 N. Percepatan yang dialami benda tersebut adalah...', ['2 m/s²', '4 m/s²', '5 m/s²', '80 m/s²'], 'C'),
            ]),
            $this->quiz('Ulangan Termodinamika, Gelombang & Listrik SMA', 'Ujian fisika SMA mencakup hukum termodinamika, gelombang elektromagnetik, dan induksi magnetik.', 3, 11, 2, 3, 'biasa', 40, [
                $this->pg('Gelombang elektromagnetik yang memiliki frekuensi paling tinggi dan panjang gelombang paling pendek adalah...', ['Gelombang radio', 'Sinar inframerah', 'Cahaya tampak', 'Sinar gamma'], 'D'),
                $this->bs('Pada proses isotermik gas ideal, suhu sistem dijaga selalu tetap.', true),
                $this->isian('Alat yang berfungsi menaikkan atau menurunkan tegangan listrik bolak-balik (AC) adalah...', 'transformator'),
                $this->pg('Hukum termodinamika yang menyatakan kekekalan energi dalam sistem termal adalah Hukum Termodinamika ke-...', ['Nol', 'Pertama', 'Kedua', 'Ketiga'], 'B'),
            ]),
        ];
    }

    // 12. Kimia (SMA +3)
    private function quizzesKimia(): array
    {
        return [
            $this->quiz('Kuis Cepat Struktur Atom & Tabel Periodik SMA', 'Menguji pemahaman partikel penyusun atom, konfigurasi elektron, serta golongan dan periode unsur.', 3, 12, 1, 1, 'wayground', null, [
                $this->pg('Partikel penyusun atom yang bermuatan listrik negatif dan mengelilingi inti atom adalah...', ['Proton', 'Neutron', 'Elektron', 'Nukleon'], 'C'),
                $this->bs('Unsur-unsur pada golongan VIIIA dalam tabel periodik disebut gas mulia yang sangat stabil.', true),
                $this->isian('Lambang kimia untuk unsur natrium adalah...', 'na'),
                $this->pg('Ikatan kimia yang terbentuk akibat serah terima elektron antara atom logam dan nonlogam adalah ikatan...', ['Kovalen', 'Ion', 'Logam', 'Hidrogen'], 'B'),
            ]),
            $this->quiz('Evaluasi Stoikiometri & Larutan Asam Basa SMA', 'Latihan konsep mol, penyetaraan reaksi kimia, pH larutan, dan reaksi redoks SMA.', 3, 12, 1, 2, 'biasa', 30, [
                $this->pg('Bilangan Avogadro menyatakan jumlah partikel dalam 1 mol zat yaitu sekitar...', ['6,02 x 10^21', '6,02 x 10^22', '6,02 x 10^23', '6,02 x 10^24'], 'C'),
                $this->bs('Reaksi oksidasi ditandai dengan pelepasan elektron atau kenaikan bilangan oksidasi.', true),
                $this->isian('Indikator alami atau kertas uji yang berubah menjadi merah pada larutan asam dan biru pada larutan basa adalah kertas...', 'lakmus'),
                $this->pg('Larutan HCl 0,01 M merupakan asam kuat monoprotik yang memiliki nilai pH sebesar...', ['1', '2', '3', '12'], 'B'),
            ]),
            $this->quiz('Ulangan Termokimia, Kesetimbangan & Organik SMA', 'Ujian tingkat lanjut meliputi reaksi eksoterm/endoterm, laju reaksi, kesetimbangan kimia, dan hidrokarbon.', 3, 12, 2, 3, 'biasa', 40, [
                $this->pg('Reaksi kimia yang melepaskan kalor ke lingkungan dengan perubahan entalpi bernilai negatif disebut reaksi...', ['Endoterm', 'Eksoterm', 'Sublimasi', 'Hidrolisis'], 'B'),
                $this->bs('Katalis mempercepat laju reaksi tanpa ikut habis bereaksi di akhir reaksi.', true),
                $this->isian('Golongan senyawa hidrokarbon jenuh yang hanya memiliki ikatan tunggal karbon-karbon disebut...', 'alkana'),
                $this->pg('Rumus molekul umum untuk deret homolog alkuna adalah...', ['CnH2n+2', 'CnH2n', 'CnH2n-2', 'CnHn'], 'C'),
            ]),
        ];
    }

    // 13. Biologi (SMA +3)
    private function quizzesBiologi(): array
    {
        return [
            $this->quiz('Kuis Cepat Sel, Jaringan & Keanekaragaman Hayati SMA', 'Uji cepat struktur organel sel, jaringan tumbuhan/hewan, dan tingkatan keanekaragaman hayati SMA.', 3, 13, 1, 1, 'wayground', null, [
                $this->pg('Organel sel yang berfungsi sebagai tempat berlangsungnya respirasi seluler penghasil ATP adalah...', ['Ribosom', 'Mitokondria', 'Lisosom', 'Badan Golgi'], 'B'),
                $this->bs('Ribosom berperan utama dalam proses sintesis protein di dalam sel.', true),
                $this->isian('Jaringan pengangkut pada tumbuhan yang membawa air dan mineral dari akar menuju daun adalah...', 'xilem'),
                $this->pg('Tingkatan keanekaragaman hayati yang tampak pada variasi warna mawar dalam satu spesies adalah keanekaragaman tingkat...', ['Gen', 'Jenis', 'Ekosistem', 'Bioma'], 'A'),
            ]),
            $this->quiz('Evaluasi Metabolisme & Pembelahan Sel SMA', 'Pendalaman katabolisme, anabolisme fotosintesis, mitosis, dan meiosis untuk siswa SMA.', 3, 13, 1, 2, 'biasa', 30, [
                $this->pg('Pembelahan sel yang menghasilkan dua sel anak identik dengan jumlah kromosom sama dengan induknya adalah...', ['Meiosis', 'Mitosis', 'Amitosis', 'Fragmentasi'], 'B'),
                $this->bs('Tahap glikolisis dalam respirasi aerob berlangsung di dalam sitoplasma sel.', true),
                $this->isian('Reaksi terang fotosintesis terjadi di bagian kloroplas yang disebut...', 'tilakoid'),
                $this->pg('Produk akhir utama dari tahap siklus Krebs yang membawa elektron berenergi tinggi antara lain...', ['Oksigen dan air', 'NADH dan FADH2', 'Glukosa dan pati', 'Asam laktat'], 'B'),
            ]),
            $this->quiz('Ulangan Genetika, Mutasi & Evolusi SMA', 'Ujian komprehensif hukum Mendel, sintesis protein, mutasi genetik, dan mekanisme evolusi SMA.', 3, 13, 2, 3, 'biasa', 40, [
                $this->pg('Proses penyalinan informasi genetik dari rantai DNA menjadi mRNA di dalam nukleus disebut...', ['Translasi', 'Transkripsi', 'Replikasi', 'Mutasi'], 'B'),
                $this->bs('Persilangan monohibrid dominan penuh antara dua individu heterozigot (Aa x Aa) menghasilkan rasio fenotipe 3 : 1.', true),
                $this->isian('Basa nitrogen yang hanya ditemukan pada RNA tetapi tidak ada pada DNA adalah...', 'urasil'),
                $this->pg('Perubahan jumlah atau susunan materi genetik yang dapat diwariskan kepada keturunannya disebut...', ['Adaptasi', 'Mutasi', 'Fosil', 'Modifikasi'], 'B'),
            ]),
        ];
    }

    // 14. Ekonomi & Akuntansi (SMA +3)
    private function quizzesEkonomi(): array
    {
        return [
            $this->quiz('Kuis Cepat Konsep Dasar Ekonomi & Pasar SMA', 'Uji cepat kelangkaan sumber daya, biaya peluang, pelaku ekonomi, dan struktur pasar SMA.', 3, 14, 1, 1, 'wayground', null, [
                $this->pg('Masalah pokok ekonomi timbul karena ketidakterbatasan kebutuhan manusia dihadapkan pada sumber daya yang...', ['Berlimpah', 'Langka (terbatas)', 'Gratis', 'Tetap'], 'B'),
                $this->bs('Biaya peluang (opportunity cost) adalah nilai barang atau manfaat terbaik yang dikorbankan saat memilih suatu alternatif.', true),
                $this->isian('Balas jasa yang diterima rumah tangga konsumen karena menyewakan modal berupa uang adalah...', 'bunga'),
                $this->pg('Lembaga keuangan yang bertugas menetapkan kebijakan moneter dan menjaga stabilitas nilai rupiah adalah...', ['Bank Umum', 'Bank Sentral (BI)', 'Koperasi', 'Pegadaian'], 'B'),
            ]),
            $this->quiz('Evaluasi Pendapatan Nasional & Kebijakan Fiskal SMA', 'Pendalaman penghitungan PDB/GNP, indeks harga, APBN, perpajakan, dan kebijakan fiskal.', 3, 14, 1, 2, 'biasa', 30, [
                $this->pg('Instrumen utama pemerintah dalam menjalankan kebijakan fiskal adalah pengaturan belanja negara dan...', ['Suku bunga acuan', 'Pajak', 'Cadangan wajib bank', 'Operasi pasar terbuka'], 'B'),
                $this->bs('Produk Domestik Bruto (PDB) menghitung seluruh nilai barang dan jasa akhir yang diproduksi di dalam wilayah suatu negara.', true),
                $this->isian('Rencana keuangan tahunan pemerintahan negara Indonesia yang disetujui oleh DPR disingkat...', 'apbn'),
                $this->pg('Pajak yang dikenakan atas tambahan nilai suatu barang dalam rantai produksi dan distribusi adalah...', ['PPh', 'PBB', 'PPN', 'Bea Materai'], 'C'),
            ]),
            $this->quiz('Ulangan Akuntansi Dasar & Laporan Keuangan SMA', 'Ujian persamaan dasar akuntansi, siklus pencatatan jurnal umum, buku besar, hingga laporan laba rugi.', 3, 14, 2, 3, 'biasa', 40, [
                $this->pg('Persamaan dasar akuntansi yang benar adalah...', ['Aset = Kewajiban - Ekuitas', 'Aset = Kewajiban + Ekuitas', 'Ekuitas = Aset + Kewajiban', 'Kewajiban = Aset + Ekuitas'], 'B'),
                $this->bs('Saldo normal akun beban (expense) dan harta (aset) berada di sisi debit.', true),
                $this->isian('Laporan keuangan yang menyajikan posisi aset, liabilitas, dan ekuitas perusahaan pada tanggal tertentu disebut...', 'neraca'),
                $this->pg('Jika total pendapatan perusahaan Rp50.000.000 dan total beban Rp35.000.000, maka perusahaan memperoleh...', ['Rugi Rp15.000.000', 'Laba bersih Rp15.000.000', 'Laba Rp85.000.000', 'Modal akhir Rp35.000.000'], 'B'),
            ]),
        ];
    }

    // 15. Geografi (SMA +3)
    private function quizzesGeografi(): array
    {
        return [
            $this->quiz('Kuis Cepat Pengantar Geografi & Litosfer SMA', 'Menguji pemahaman 10 konsep esensial geografi, empat prinsip geografi, dan dinamika lempeng bumi.', 3, 15, 1, 1, 'wayground', null, [
                $this->pg('Prinsip geografi yang menganalisis hubungan timbal balik antara gejala alam dan gejala sosial disebut prinsip...', ['Distribusi', 'Interelasi', 'Deskripsi', 'Korologi'], 'B'),
                $this->bs('Pelapukan, erosi, dan sedimentasi termasuk tenaga pembentuk muka bumi yang bersifat eksogen.', true),
                $this->isian('Lapisan batuan kerak bumi paling luar tempat makhluk hidup berpijak disebut...', 'litosfer'),
                $this->pg('Alat pencatat getaran gelombang gempa bumi adalah...', ['Barometer', 'Anemometer', 'Seismograf', 'Higrometer'], 'C'),
            ]),
            $this->quiz('Evaluasi Atmosfer, Hidrosfer & Penginderaan Jauh SMA', 'Pendalaman lapisan atmosfer, siklus hidrologi, peta tematik, SIG, dan penginderaan jauh.', 3, 15, 1, 2, 'biasa', 30, [
                $this->pg('Lapisan atmosfer yang paling dekat dengan permukaan bumi tempat terjadinya cuaca dan hujan adalah...', ['Stratosfer', 'Troposfer', 'Mesosfer', 'Termosfer'], 'B'),
                $this->bs('Alat yang digunakan untuk mengukur kecepatan angin disebut anemometer.', true),
                $this->isian('Proses penyerapan air hujan oleh tanah masuk ke dalam pori-pori batuan disebut...', 'infiltrasi'),
                $this->pg('Dalam Sistem Informasi Geografis (SIG), data yang disajikan dalam bentuk titik, garis, dan poligon disebut data...', ['Raster', 'Vektor', 'Analog', 'Tabular mentah'], 'B'),
            ]),
            $this->quiz('Ulangan Antroposfer, Biosfer & Kewilayahan SMA', 'Ujian dinamika kependudukan, persebaran flora fauna dunia, serta interaksi desa dan kota SMA.', 3, 15, 2, 3, 'biasa', 40, [
                $this->pg('Garis khayal yang membatasi persebaran fauna Indonesia bagian barat (Asiatis) dengan bagian tengah (Peralihan) adalah garis...', ['Weber', 'Wallace', 'Lydekker', 'Isobar'], 'B'),
                $this->bs('Komodo, anoa, dan babirusa termasuk fauna endemik kawasan peralihan di Indonesia.', true),
                $this->isian('Piramida penduduk dengan bagian dasar sangat lebar karena angka kelahiran tinggi disebut piramida...', 'ekspansif'),
                $this->pg('Teori tempat sentral (Central Place Theory) dikemukakan oleh ahli geografi bernama...', ['Walter Christaller', 'Alfred Wegener', 'Von Thunen', 'Ernst Ravenstein'], 'A'),
            ]),
        ];
    }

    // 16. Sosiologi (SMA +3)
    private function quizzesSosiologi(): array
    {
        return [
            $this->quiz('Kuis Cepat Objek Sosiologi & Nilai Sosial SMA', 'Menguji pemahaman karakteristik sosiologi sebagai ilmu, nilai norma, dan sosialisasi SMA.', 3, 16, 1, 1, 'wayground', null, [
                $this->pg('Sosiologi tidak menilai baik atau buruknya suatu fakta sosial melainkan menjelaskannya secara objektif karena bersifat...', ['Kumulatif', 'Teoretis', 'Nonetis', 'Empiris'], 'C'),
                $this->bs('Auguste Comte dikenal sebagai Bapak Sosiologi sekaligus pencetus istilah sosiologi.', true),
                $this->isian('Proses belajar individu untuk mengenal dan menghayati nilai serta norma masyarakat disebut...', 'sosialisasi'),
                $this->pg('Faktor interaksi sosial yang meniru gaya berpakaian atau perilaku tokoh idola secara persis disebut...', ['Simpati', 'Imitasi', 'Empati', 'Sugesti'], 'B'),
            ]),
            $this->quiz('Evaluasi Struktur, Stratifikasi & Konflik Sosial SMA', 'Pendalaman kelompok sosial, pelapisan sosial terbuka/tertutup, konflik, dan integrasi sosial.', 3, 16, 1, 2, 'biasa', 30, [
                $this->pg('Penggolongan masyarakat secara vertikal berdasarkan kekayaan, kekuasaan, dan pendidikan disebut...', ['Diferensiasi sosial', 'Stratifikasi sosial', 'Mobilitas horizontal', 'Asimilasi'], 'B'),
                $this->bs('Penyelesaian konflik di luar pengadilan dengan bantuan pihak ketiga yang netral sebagai penengah tanpa memutus perkara disebut mediasi.', true),
                $this->isian('Bentuk penyelesaian konflik yang menggunakan pihak ketiga berwenang mengambil keputusan mengikat disebut...', 'arbitrase'),
                $this->pg('Kelompok sosial yang hubungannya erat, akrab, dan kekeluargaan (Gemeinschaft) disebut juga...', ['Patembayan', 'Paguyuban', 'Kerumunan', 'Publik'], 'B'),
            ]),
            $this->quiz('Ulangan Perubahan Sosial & Penelitian Sosial SMA', 'Ujian teori perubahan sosial, modernisasi, ketimpangan global, dan metode penelitian sosial SMA.', 3, 16, 2, 3, 'biasa', 40, [
                $this->pg('Perubahan sosial yang berlangsung secara lambat dan bertahap melalui penyesuaian kecil dalam waktu lama disebut...', ['Revolusi', 'Evolusi', 'Regres', 'Anomi'], 'B'),
                $this->bs('Ketidakseimbangan antara perubahan kebudayaan material (teknologi) dan nonmaterial (nilai/sikap) disebut cultural lag.', true),
                $this->isian('Teknik pengumpulan data penelitian kualitatif melalui tanya jawab langsung secara mendalam dengan informan disebut...', 'wawancara'),
                $this->pg('Dampak negatif perubahan sosial berupa memudarnya norma dan pegangan moral masyarakat disebut...', ['Modernisasi', 'Anomi', 'Akulturasi', 'Inovasi'], 'B'),
            ]),
        ];
    }

    // 17. Sejarah Indonesia (SD +3, SMP +3, SMA +2)
    private function quizzesSejarahIndonesia(): array
    {
        return [
            $this->quiz('Kuis Cepat Pahlawan Nasional Indonesia SD', 'Mengenal jasa pahlawan kemerdekaan nasional, tokoh proklamasi, dan pahlawan pendidikan SD.', 1, 17, 1, 1, 'wayground', null, [
                $this->pg('Bapak Pendidikan Nasional Indonesia yang mendirikan Perguruan Taman Siswa adalah...', ['Ki Hajar Dewantara', 'R.A. Kartini', 'Pangeran Diponegoro', 'Cut Nyak Dien'], 'A'),
                $this->bs('R.A. Kartini dikenal sebagai pahlawan pejuang emansipasi dan pendidikan kaum perempuan Indonesia.', true),
                $this->isian('Pasangan proklamator kemerdekaan Indonesia adalah Ir. Soekarno dan Drs. Mohammad...', 'hatta'),
                $this->pg('Hari Pahlawan Nasional di Indonesia diperingati setiap tanggal...', ['17 Agustus', '28 Oktober', '10 November', '2 Mei'], 'C'),
            ]),
            $this->quiz('Kerajaan Nusantara & Perjuangan Daerah SD', 'Mengenal tokoh raja terkenal Nusantara dan perlawanan rakyat terhadap penjajah di daerah.', 1, 17, 1, 2, 'biasa', 20, [
                $this->pg('Patih Kerajaan Majapahit yang terkenal dengan Sumpah Palapa adalah...', ['Hayam Wuruk', 'Gajah Mada', 'Ken Arok', 'Mulawarman'], 'B'),
                $this->bs('Kerajaan Sriwijaya di Sumatera dikenal sebagai kerajaan maritim bercorak Buddha yang besar.', true),
                $this->isian('Perang besar di Jawa tahun 1825-1830 dipimpin oleh Pangeran...', 'diponegoro'),
                $this->pg('Tokoh pengetik naskah Proklamasi Kemerdekaan Indonesia adalah...', ['Ahmad Soebardjo', 'Sayuti Melik', 'Laksamana Maeda', 'Wikana'], 'B'),
            ]),
            $this->quiz('Ulangan Detik Proklamasi & Kemerdekaan SD', 'Penilaian peristiwa Rengasdengklok, penyusunan naskah proklamasi, dan pengibaran Merah Putih.', 1, 17, 2, 3, 'biasa', 30, [
                $this->pg('Pembacaan teks Proklamasi Kemerdekaan Indonesia dilaksanakan di Jalan Pegangsaan Timur nomor 56 di kota...', ['Surabaya', 'Bandung', 'Jakarta', 'Yogyakarta'], 'C'),
                $this->bs('Bendera Merah Putih pertama yang dikibarkan saat Proklamasi dijahit oleh Ibu Fatmawati.', true),
                $this->isian('Perwira Angkatan Laut Jepang yang meminjamkan rumahnya untuk perumusan naskah proklamasi adalah Laksamana...', 'maeda'),
                $this->pg('Peristiwa penculikan Soekarno dan Hatta oleh golongan pemuda menjelang proklamasi terjadi di...', ['Rengasdengklok', 'Linggarjati', 'Kaliurang', 'Roem-Royen'], 'A'),
            ]),

            $this->quiz('Kuis Cepat Masa Kolonial & Tanam Paksa SMP', 'Uji cepat kedatangan bangsa Eropa, VOC, sistem tanam paksa, dan politik etis di Indonesia SMP.', 2, 17, 1, 1, 'wayground', null, [
                $this->pg('Kongsi dagang Belanda yang didirikan pada tahun 1602 untuk memonopoli rempah-rempah di Nusantara adalah...', ['EIC', 'VOC', 'KNIL', 'Cultuurstelsel'], 'B'),
                $this->bs('Tujuan utama kedatangan bangsa Eropa ke Nusantara dikenal dengan semboyan Gold, Glory, dan Gospel.', true),
                $this->isian('Sistem tanam paksa pada masa pemerintahan Gubernur Jenderal Johannes van den Bosch disebut...', 'cultuurstelsel'),
                $this->pg('Kebijakan Politik Etis (Balas Budi) mencakup tiga program utama yaitu irigasi, emigrasi, dan...', ['Militerisasi', 'Edukasi', 'Industrialisasi', 'Pajak tanah'], 'B'),
            ]),
            $this->quiz('Evaluasi Pergerakan Nasional & Pendudukan Jepang SMP', 'Pendalaman organisasi pergerakan nasional, peristiwa Sumpah Pemuda, dan masa pendudukan Jepang.', 2, 17, 1, 2, 'biasa', 25, [
                $this->pg('Partai politik pertama di Hindia Belanda yang didirikan oleh Tiga Serangkai pada 1912 adalah...', ['Partai Nasional Indonesia', 'Indische Partij', 'Perhimpunan Indonesia', 'Muhammadiyah'], 'B'),
                $this->bs('Kongres Pemuda II tahun 1928 menghasilkan ikrar Sumpah Pemuda dan pengenalan lagu Indonesia Raya.', true),
                $this->isian('Organisasi tenaga kerja paksa rakyat yang dibentuk pada masa pendudukan Jepang disebut...', 'romusha'),
                $this->pg('Pemuda yang pertama kali mengibarkan bendera dan menyuarakan kemerdekaan melalui siaran radio setelah proklamasi adalah tokoh dari kantor berita...', ['Domei', 'Antara', 'RRI', 'Merdeka'], 'A'),
            ]),
            $this->quiz('Ulangan Mempertahankan Kemerdekaan Indonesia SMP', 'Ujian diplomasi Linggarjati, Renville, Agresi Militer, dan Serangan Umum 1 Maret 1949 SMP.', 2, 17, 2, 3, 'biasa', 35, [
                $this->pg('Pertempuran heroik tanggal 10 November 1945 yang melibatkan pidato penyemangat Bung Tomo terjadi di...', ['Medan', 'Bandung', 'Surabaya', 'Ambarawa'], 'C'),
                $this->bs('Peristiwa Bandung Lautan Api terjadi ketika rakyat dan pejuang mengosongkan serta membakar kota Bandung bagian selatan agar tidak dimanfaatkan Sekutu.', true),
                $this->isian('Komandan pasukan TKR yang memimpin taktik gelar Supit Urang dalam Palagan Ambarawa adalah Jenderal...', 'soedirman'),
                $this->pg('Perjanjian yang membuat wilayah RI semakin sempit dibatasi oleh Garis Van Mook adalah Perjanjian...', ['Linggarjati', 'Renville', 'Roem-Royen', 'KMB'], 'B'),
            ]),

            $this->quiz('Evaluasi Demokrasi Liberal & Terpimpin SMA', 'Pendalaman dinamika kabinet Demokrasi Liberal, Pemilu 1955, KAA Bandung, dan Dekrit Presiden 1959.', 3, 17, 1, 2, 'biasa', 30, [
                $this->pg('Konferensi Asia-Afrika (KAA) tahun 1955 yang melahirkan Dasasila Bandung diselenggarakan di kota...', ['Jakarta', 'Bandung', 'Bogor', 'Surakarta'], 'B'),
                $this->bs('Pemilihan umum pertama di Indonesia diselenggarakan pada tahun 1955 untuk memilih anggota DPR dan Konstituante.', true),
                $this->isian('Dekrit Presiden yang mengakhiri masa Demokrasi Liberal dan memberlakukan kembali UUD 1945 dikeluarkan pada 5 Juli...', '1959'),
                $this->pg('Komando pembebasan Irian Barat yang dicanangkan Presiden Soekarno pada 19 Desember 1961 dikenal dengan nama...', ['Dwikora', 'Trikora', 'Tritura', 'Supersemar'], 'B'),
            ]),
            $this->quiz('Ulangan Sejarah Orde Baru hingga Reformasi SMA', 'Ujian kritis tentang pembangunan Orde Baru, krisis moneter 1997-1998, hingga lahirnya era Reformasi.', 3, 17, 2, 3, 'biasa', 40, [
                $this->pg('Tiga Tuntutan Rakyat yang disuarakan mahasiswa pada awal tahun 1966 dikenal dengan singkatan...', ['Trikora', 'Tritura', 'Dwikora', 'Nawaksara'], 'B'),
                $this->bs('Era Reformasi di Indonesia dimulai setelah Presiden Soeharto mengundurkan diri pada tanggal 21 Mei 1998.', true),
                $this->isian('Presiden Republik Indonesia ketiga yang menggantikan Presiden Soeharto pada Mei 1998 adalah B.J....', 'habibie'),
                $this->pg('Salah satu agenda utama gerakan Reformasi 1998 dalam bidang hukum dan pemerintahan adalah pemberantasan...', ['Ekspor dan impor', 'Korupsi, Kolusi, dan Nepotisme (KKN)', 'Swasembada pangan', 'Program wajib belajar'], 'B'),
            ]),
        ];
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\PilihanSoal;
use Illuminate\Support\Facades\DB;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $quizList = [
            // =========================================================================
            // JENJANG 1: SD (SEKOLAH DASAR)
            // =========================================================================
            [
                'judul' => 'Kuis Cepat Kilat Ceria SD',
                'deskripsi' => 'Uji kecepatan berpikir dan ketangkasan wawasan dasar seputar sains, matematika, dan pengetahuan umum dengan durasi waktu per soal.',
                'id_jenjang' => 1,
                'id_tipequiz' => 1, // Harian
                'id_tingkatquiz' => 1, // Mudah
                'mode_pengerjaan' => 'wayground',
                'durasi_total_menit' => null,
                'token' => null,
                'proggressQuiz' => 'Tersedia',
                'opsi_preview' => 'lengkap',
                'soal' => [
                    [
                        'jenis' => 'pilihan_ganda',
                        'pertanyaan' => 'Organ tubuh manusia yang berfungsi utama memompa darah ke seluruh tubuh adalah...',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Jantung', 'is_correct' => true],
                            ['label' => 'B', 'teks_pilihan' => 'Lambung', 'is_correct' => false],
                            ['label' => 'C', 'teks_pilihan' => 'Paru-paru', 'is_correct' => false],
                            ['label' => 'D', 'teks_pilihan' => 'Ginjal', 'is_correct' => false],
                        ],
                    ],
                    [
                        'jenis' => 'benar_salah',
                        'pertanyaan' => 'Hasil penjumlahan dari 25 ditambah 75 adalah 100.',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'jawaban_benar' => 'A', // A = Benar
                    ],
                    [
                        'jenis' => 'isian',
                        'pertanyaan' => 'Kelompok hewan yang menyusui dan melahirkan anaknya disebut hewan golongan...',
                        'poin' => 15,
                        'durasi_detik' => 20,
                        'jawaban_benar' => 'mamalia',
                    ],
                    [
                        'jenis' => 'pilihan_ganda',
                        'pertanyaan' => 'Lambang negara kesatuan Republik Indonesia adalah burung...',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Rajawali', 'is_correct' => false],
                            ['label' => 'B', 'teks_pilihan' => 'Garuda', 'is_correct' => true],
                            ['label' => 'C', 'teks_pilihan' => 'Elang Jawa', 'is_correct' => false],
                            ['label' => 'D', 'teks_pilihan' => 'Merpati', 'is_correct' => false],
                        ],
                    ],
                    [
                        'jenis' => 'benar_salah',
                        'pertanyaan' => 'Air murni membeku menjadi es pada suhu 100 derajat Celsius.',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'jawaban_benar' => 'B', // B = Salah (0 derajat)
                    ],
                ],
            ],
            [
                'judul' => 'Penilaian Harian Tematik & IPA Terpadu SD',
                'deskripsi' => 'Penilaian harian tematik mencakup IPA, Bahasa Indonesia, dan Matematika dasar dalam mode waktu total 20 menit.',
                'id_jenjang' => 1,
                'id_tipequiz' => 1, // Harian
                'id_tingkatquiz' => 2, // Sedang
                'mode_pengerjaan' => 'biasa',
                'durasi_total_menit' => 20,
                'token' => null,
                'proggressQuiz' => 'Tersedia',
                'opsi_preview' => 'lengkap',
                'soal' => [
                    [
                        'jenis' => 'pilihan_ganda',
                        'pertanyaan' => 'Proses pembuatan makanan pada tumbuhan hijau dengan bantuan cahaya matahari dinamakan...',
                        'poin' => 10,
                        'durasi_detik' => 25,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Respirasi', 'is_correct' => false],
                            ['label' => 'B', 'teks_pilihan' => 'Fotosintesis', 'is_correct' => true],
                            ['label' => 'C', 'teks_pilihan' => 'Fermentasi', 'is_correct' => false],
                            ['label' => 'D', 'teks_pilihan' => 'Metamorfosis', 'is_correct' => false],
                        ],
                    ],
                    [
                        'jenis' => 'isian',
                        'pertanyaan' => 'Lawan kata atau antonim dari kata "tinggi" dalam bahasa Indonesia adalah...',
                        'poin' => 15,
                        'durasi_detik' => 20,
                        'jawaban_benar' => 'pendek',
                    ],
                    [
                        'jenis' => 'benar_salah',
                        'pertanyaan' => 'Sudut siku-siku memiliki besar sudut tepat 90 derajat.',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'jawaban_benar' => 'A', // Benar
                    ],
                    [
                        'jenis' => 'pilihan_ganda',
                        'pertanyaan' => 'Sebuah persegi memiliki panjang sisi 8 cm. Berapakah luas persegi tersebut?',
                        'poin' => 10,
                        'durasi_detik' => 25,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => '32 cm²', 'is_correct' => false],
                            ['label' => 'B', 'teks_pilihan' => '64 cm²', 'is_correct' => true],
                            ['label' => 'C', 'teks_pilihan' => '16 cm²', 'is_correct' => false],
                            ['label' => 'D', 'teks_pilihan' => '48 cm²', 'is_correct' => false],
                        ],
                    ],
                    [
                        'jenis' => 'isian',
                        'pertanyaan' => 'Ibukota negara Indonesia yang saat ini adalah...',
                        'poin' => 10,
                        'durasi_detik' => 20,
                        'jawaban_benar' => 'jakarta',
                    ],
                    [
                        'jenis' => 'benar_salah',
                        'pertanyaan' => 'Kupu-kupu mengalami metamorfosis sempurna yang dimulai dari fase telur, ulat, kepompong, hingga dewasa.',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'jawaban_benar' => 'A', // Benar
                    ],
                ],
            ],
            [
                'judul' => 'Ulangan Akhir Semester Cerdas Cendekia SD',
                'deskripsi' => 'Ujian semester komprehensif untuk siswa SD tingkat lanjut. Dibutuhkan token untuk membuka akses pengerjaan.',
                'id_jenjang' => 1,
                'id_tipequiz' => 2, // Ulangan
                'id_tingkatquiz' => 3, // Sulit
                'mode_pengerjaan' => 'biasa',
                'durasi_total_menit' => 30,
                'token' => 'SDJUARA',
                'proggressQuiz' => 'Tersedia',
                'opsi_preview' => 'lengkap',
                'soal' => [
                    [
                        'jenis' => 'pilihan_ganda',
                        'pertanyaan' => 'Planet terbesar dalam tata surya kita adalah planet...',
                        'poin' => 10,
                        'durasi_detik' => 20,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Mars', 'is_correct' => false],
                            ['label' => 'B', 'teks_pilihan' => 'Bumi', 'is_correct' => false],
                            ['label' => 'C', 'teks_pilihan' => 'Jupiter', 'is_correct' => true],
                            ['label' => 'D', 'teks_pilihan' => 'Saturnus', 'is_correct' => false],
                        ],
                    ],
                    [
                        'jenis' => 'isian',
                        'pertanyaan' => 'Berapakah hasil operasi hitung dari (15 x 4) : 2?',
                        'poin' => 15,
                        'durasi_detik' => 25,
                        'jawaban_benar' => '30',
                    ],
                    [
                        'jenis' => 'benar_salah',
                        'pertanyaan' => 'Naskah proklamasi kemerdekaan Republik Indonesia dibacakan pada tanggal 17 Agustus 1945.',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'jawaban_benar' => 'A', // Benar
                    ],
                    [
                        'jenis' => 'isian',
                        'pertanyaan' => 'Zat warna hijau pada daun yang berfungsi menyerap energi matahari disebut...',
                        'poin' => 15,
                        'durasi_detik' => 20,
                        'jawaban_benar' => 'klorofil',
                    ],
                    [
                        'jenis' => 'pilihan_ganda',
                        'pertanyaan' => 'Tokoh utama yang memiliki sifat baik dalam sebuah cerita narasi disebut tokoh...',
                        'poin' => 10,
                        'durasi_detik' => 20,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Antagonis', 'is_correct' => false],
                            ['label' => 'B', 'teks_pilihan' => 'Protagonis', 'is_correct' => true],
                            ['label' => 'C', 'teks_pilihan' => 'Tritagonis', 'is_correct' => false],
                            ['label' => 'D', 'teks_pilihan' => 'Figuran', 'is_correct' => false],
                        ],
                    ],
                    [
                        'jenis' => 'benar_salah',
                        'pertanyaan' => 'Batang magnet selalu memiliki 3 kutub utama yaitu kutub utara, timur, dan selatan.',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'jawaban_benar' => 'B', // Salah
                    ],
                ],
            ],

            // =========================================================================
            // JENJANG 2: SMP (SEKOLAH MENENGAH PERTAMA)
            // =========================================================================
            [
                'judul' => 'Speed Challenge Sains & Logika SMP',
                'deskripsi' => 'Tantangan kecepatan sains dan penalaran logika SMP dalam tempo cepat per nomor.',
                'id_jenjang' => 2,
                'id_tipequiz' => 1, // Harian
                'id_tingkatquiz' => 2, // Sedang
                'mode_pengerjaan' => 'wayground',
                'durasi_total_menit' => null,
                'token' => null,
                'proggressQuiz' => 'Tersedia',
                'opsi_preview' => 'lengkap',
                'soal' => [
                    [
                        'jenis' => 'pilihan_ganda',
                        'pertanyaan' => 'Satuan internasional (SI) yang digunakan untuk mengukur besaran gaya adalah...',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Joule', 'is_correct' => false],
                            ['label' => 'B', 'teks_pilihan' => 'Watt', 'is_correct' => false],
                            ['label' => 'C', 'teks_pilihan' => 'Newton', 'is_correct' => true],
                            ['label' => 'D', 'teks_pilihan' => 'Pascal', 'is_correct' => false],
                        ],
                    ],
                    [
                        'jenis' => 'benar_salah',
                        'pertanyaan' => 'Rumus kimia resmi untuk molekul air murni adalah H2O.',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'jawaban_benar' => 'A', // Benar
                    ],
                    [
                        'jenis' => 'isian',
                        'pertanyaan' => 'Organ ekskresi utama manusia yang berfungsi menyaring zat sisa metabolisme dari darah dan menghasilkan urine adalah...',
                        'poin' => 15,
                        'durasi_detik' => 20,
                        'jawaban_benar' => 'ginjal',
                    ],
                    [
                        'jenis' => 'pilihan_ganda',
                        'pertanyaan' => 'Berapakah nilai dari 3 dipangkatkan 4 (3⁴)?',
                        'poin' => 10,
                        'durasi_detik' => 20,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => '12', 'is_correct' => false],
                            ['label' => 'B', 'teks_pilihan' => '27', 'is_correct' => false],
                            ['label' => 'C', 'teks_pilihan' => '64', 'is_correct' => false],
                            ['label' => 'D', 'teks_pilihan' => '81', 'is_correct' => true],
                        ],
                    ],
                    [
                        'jenis' => 'benar_salah',
                        'pertanyaan' => 'Kecepatan rambat cahaya di ruang hampa lebih lambat dibandingkan kecepatan rambat gelombang bunyi di udara.',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'jawaban_benar' => 'B', // Salah
                    ],
                ],
            ],
            [
                'judul' => 'Ujian Mandiri Bahasa & Sosial Budaya SMP',
                'deskripsi' => 'Evaluasi wawasan kebahasaan, sosial, dan sejarah nasional dengan mode waktu total 25 menit.',
                'id_jenjang' => 2,
                'id_tipequiz' => 1, // Harian
                'id_tingkatquiz' => 1, // Mudah
                'mode_pengerjaan' => 'biasa',
                'durasi_total_menit' => 25,
                'token' => null,
                'proggressQuiz' => 'Tersedia',
                'opsi_preview' => 'lengkap',
                'soal' => [
                    [
                        'jenis' => 'pilihan_ganda',
                        'pertanyaan' => 'Bentuk kata turunan baku dalam bahasa Indonesia yang benar dari kata dasar "ubah" adalah...',
                        'poin' => 10,
                        'durasi_detik' => 20,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Merubah', 'is_correct' => false],
                            ['label' => 'B', 'teks_pilihan' => 'Mengubah', 'is_correct' => true],
                            ['label' => 'C', 'teks_pilihan' => 'Memrubah', 'is_correct' => false],
                            ['label' => 'D', 'teks_pilihan' => 'Pengrubahan', 'is_correct' => false],
                        ],
                    ],
                    [
                        'jenis' => 'isian',
                        'pertanyaan' => 'Candi peninggalan agama Buddha terbesar di dunia yang terletak di Kabupaten Magelang, Jawa Tengah adalah Candi...',
                        'poin' => 15,
                        'durasi_detik' => 20,
                        'jawaban_benar' => 'borobudur',
                    ],
                    [
                        'jenis' => 'benar_salah',
                        'pertanyaan' => 'In English grammar, the correct past tense (V2) form of the verb "go" is "goed".',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'jawaban_benar' => 'B', // Salah (went)
                    ],
                    [
                        'jenis' => 'pilihan_ganda',
                        'pertanyaan' => 'Benua dengan luas wilayah daratan terbesar dan terluas di dunia adalah Benua...',
                        'poin' => 10,
                        'durasi_detik' => 20,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Afrika', 'is_correct' => false],
                            ['label' => 'B', 'teks_pilihan' => 'Amerika', 'is_correct' => false],
                            ['label' => 'C', 'teks_pilihan' => 'Asia', 'is_correct' => true],
                            ['label' => 'D', 'teks_pilihan' => 'Eropa', 'is_correct' => false],
                        ],
                    ],
                    [
                        'jenis' => 'isian',
                        'pertanyaan' => 'Nama mata uang resmi yang berlaku di negara Jepang adalah...',
                        'poin' => 10,
                        'durasi_detik' => 20,
                        'jawaban_benar' => 'yen',
                    ],
                    [
                        'jenis' => 'benar_salah',
                        'pertanyaan' => 'Sila pertama dalam Pancasila berbunyi "Ketuhanan Yang Maha Esa".',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'jawaban_benar' => 'A', // Benar
                    ],
                ],
            ],
            [
                'judul' => 'Ulangan Tengah Semester IPA & Teknologi SMP',
                'deskripsi' => 'Ulangan komprehensif sains, biologi sel, dan fisika gerak untuk siswa berprestasi SMP.',
                'id_jenjang' => 2,
                'id_tipequiz' => 2, // Ulangan
                'id_tingkatquiz' => 3, // Sulit
                'mode_pengerjaan' => 'biasa',
                'durasi_total_menit' => 35,
                'token' => 'SMPHEBAT',
                'proggressQuiz' => 'Tersedia',
                'opsi_preview' => 'lengkap',
                'soal' => [
                    [
                        'jenis' => 'pilihan_ganda',
                        'pertanyaan' => 'Energi yang dimiliki oleh suatu benda yang timbul akibat dari pergerakan atau kecepatannya disebut energi...',
                        'poin' => 10,
                        'durasi_detik' => 20,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Potensial', 'is_correct' => false],
                            ['label' => 'B', 'teks_pilihan' => 'Kinetik', 'is_correct' => true],
                            ['label' => 'C', 'teks_pilihan' => 'Kalor', 'is_correct' => false],
                            ['label' => 'D', 'teks_pilihan' => 'Kimia', 'is_correct' => false],
                        ],
                    ],
                    [
                        'jenis' => 'isian',
                        'pertanyaan' => 'Bagian struktur sel tumbuhan yang tidak terdapat pada sel hewan dan berfungsi memberikan bentuk yang kaku dan kokoh adalah...',
                        'poin' => 15,
                        'durasi_detik' => 25,
                        'jawaban_benar' => 'dinding sel',
                    ],
                    [
                        'jenis' => 'benar_salah',
                        'pertanyaan' => 'Persamaan kuadrat x² - 16 = 0 mempunyai dua himpunan penyelesaian real yaitu x = 4 dan x = -4.',
                        'poin' => 10,
                        'durasi_detik' => 20,
                        'jawaban_benar' => 'A', // Benar
                    ],
                    [
                        'jenis' => 'isian',
                        'pertanyaan' => 'Alat ukur yang digunakan untuk mendeteksi dan mengukur besarnya kuat arus listrik adalah...',
                        'poin' => 15,
                        'durasi_detik' => 20,
                        'jawaban_benar' => 'amperemeter',
                    ],
                    [
                        'jenis' => 'pilihan_ganda',
                        'pertanyaan' => 'Gas unsur terbanyak yang menyusun lapisan atmosfer bumi hingga mencapai kurang lebih 78% adalah...',
                        'poin' => 10,
                        'durasi_detik' => 20,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Oksigen', 'is_correct' => false],
                            ['label' => 'B', 'teks_pilihan' => 'Karbon Dioksida', 'is_correct' => false],
                            ['label' => 'C', 'teks_pilihan' => 'Nitrogen', 'is_correct' => true],
                            ['label' => 'D', 'teks_pilihan' => 'Argon', 'is_correct' => false],
                        ],
                    ],
                    [
                        'jenis' => 'benar_salah',
                        'pertanyaan' => 'Pembuluh balik (vena) bertugas memompa dan membawa darah segar yang kaya akan oksigen langsung dari bilik kiri jantung menuju seluruh jaringan tubuh.',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'jawaban_benar' => 'B', // Salah (itu arteri/aorta)
                    ],
                ],
            ],

            // =========================================================================
            // JENJANG 3: SMA (SEKOLAH MENENGAH ATAS)
            // =========================================================================
            [
                'judul' => 'Grand Prix Sains & Olimpiade SMA',
                'deskripsi' => 'Ajang uji cepat ketepatan analisis konsep sains fisika, kimia, dan matematika SMA bergaya Wayground.',
                'id_jenjang' => 3,
                'id_tipequiz' => 1, // Harian
                'id_tingkatquiz' => 2, // Sedang
                'mode_pengerjaan' => 'wayground',
                'durasi_total_menit' => null,
                'token' => null,
                'proggressQuiz' => 'Tersedia',
                'opsi_preview' => 'lengkap',
                'soal' => [
                    [
                        'jenis' => 'pilihan_ganda',
                        'pertanyaan' => 'Hukum kelistrikan yang menyatakan bahwa beda potensial (tegangan) berbanding lurus dengan kuat arus listrik adalah Hukum...',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Coulomb', 'is_correct' => false],
                            ['label' => 'B', 'teks_pilihan' => 'Ohm', 'is_correct' => true],
                            ['label' => 'C', 'teks_pilihan' => 'Faraday', 'is_correct' => false],
                            ['label' => 'D', 'teks_pilihan' => 'Ampere', 'is_correct' => false],
                        ],
                    ],
                    [
                        'jenis' => 'benar_salah',
                        'pertanyaan' => 'Dalam trigonometri, nilai dari perbandingan sin 30° adalah 0,5 (atau 1/2).',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'jawaban_benar' => 'A', // Benar
                    ],
                    [
                        'jenis' => 'isian',
                        'pertanyaan' => 'Subpartikel penyusun inti atom bersama proton yang tidak memiliki muatan listrik (netral) disebut...',
                        'poin' => 15,
                        'durasi_detik' => 20,
                        'jawaban_benar' => 'neutron',
                    ],
                    [
                        'jenis' => 'pilihan_ganda',
                        'pertanyaan' => 'Asam nukleat beruntai ganda (double helix) yang menjadi materi pembawa informasi hereditas pada organisme adalah...',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'RNA', 'is_correct' => false],
                            ['label' => 'B', 'teks_pilihan' => 'DNA', 'is_correct' => true],
                            ['label' => 'C', 'teks_pilihan' => 'ATP', 'is_correct' => false],
                            ['label' => 'D', 'teks_pilihan' => 'Polipeptida', 'is_correct' => false],
                        ],
                    ],
                    [
                        'jenis' => 'benar_salah',
                        'pertanyaan' => 'Pada peristiwa tumbukan lenting sempurna antara dua benda, berlaku hukum kekekalan momentum namun hukum kekekalan energi kinetik tidak berlaku.',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'jawaban_benar' => 'B', // Salah (keduanya berlaku)
                    ],
                ],
            ],
            [
                'judul' => 'Simulasi UTBK & Penalaran Skolastik SMA',
                'deskripsi' => 'Simulasi ujian seleksi masuk perguruan tinggi menguji literasi, penalaran matematika tingkat lanjut, dan analisis kritis.',
                'id_jenjang' => 3,
                'id_tipequiz' => 2, // Ulangan
                'id_tingkatquiz' => 3, // Sulit
                'mode_pengerjaan' => 'biasa',
                'durasi_total_menit' => 40,
                'token' => 'SMASUKSES',
                'proggressQuiz' => 'Tersedia',
                'opsi_preview' => 'lengkap',
                'soal' => [
                    [
                        'jenis' => 'pilihan_ganda',
                        'pertanyaan' => 'Diketahui fungsi f(x) = 3x² + 4x - 5. Maka turunan pertama f\'(x) adalah...',
                        'poin' => 10,
                        'durasi_detik' => 30,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => '6x + 4', 'is_correct' => true],
                            ['label' => 'B', 'teks_pilihan' => '3x + 4', 'is_correct' => false],
                            ['label' => 'C', 'teks_pilihan' => '6x² + 4', 'is_correct' => false],
                            ['label' => 'D', 'teks_pilihan' => '6x - 5', 'is_correct' => false],
                        ],
                    ],
                    [
                        'jenis' => 'isian',
                        'pertanyaan' => 'Kondisi perekonomian di mana harga barang dan jasa secara umum mengalami kenaikan secara terus menerus dalam jangka waktu tertentu disebut...',
                        'poin' => 15,
                        'durasi_detik' => 25,
                        'jawaban_benar' => 'inflasi',
                    ],
                    [
                        'jenis' => 'benar_salah',
                        'pertanyaan' => 'Suatu larutan kimia dengan nilai derajat keasaman (pH) di bawah 7 tergolong larutan asam, sedangkan di atas 7 tergolong basa.',
                        'poin' => 10,
                        'durasi_detik' => 20,
                        'jawaban_benar' => 'A', // Benar
                    ],
                    [
                        'jenis' => 'pilihan_ganda',
                        'pertanyaan' => 'Proses perpaduan dua kebudayaan yang saling mempengaruhi tanpa menghilangkan unsur kepribadian dari masing-masing kebudayaan asli disebut...',
                        'poin' => 10,
                        'durasi_detik' => 25,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Asimilasi', 'is_correct' => false],
                            ['label' => 'B', 'teks_pilihan' => 'Akulturasi', 'is_correct' => true],
                            ['label' => 'C', 'teks_pilihan' => 'Difusi', 'is_correct' => false],
                            ['label' => 'D', 'teks_pilihan' => 'Segregasi', 'is_correct' => false],
                        ],
                    ],
                    [
                        'jenis' => 'isian',
                        'pertanyaan' => 'Komponen perangkat keras utama komputer yang bertindak sebagai otak untuk mengeksekusi instruksi aritmatika dan logika disingkat...',
                        'poin' => 10,
                        'durasi_detik' => 20,
                        'jawaban_benar' => 'cpu',
                    ],
                    [
                        'jenis' => 'benar_salah',
                        'pertanyaan' => 'Enzim dalam tubuh bertindak sebagai biokatalisator dengan cara meningkatkan energi aktivasi reaksi biokimia.',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'jawaban_benar' => 'B', // Salah (menurunkan energi aktivasi)
                    ],
                ],
            ],
            [
                'judul' => 'Wawasan Literasi & Sejarah Global SMA',
                'deskripsi' => 'Eksplorasi wawasan sejarah dunia, literasi global, dan kebudayaan umum dalam mode waktu total 25 menit.',
                'id_jenjang' => 3,
                'id_tipequiz' => 1, // Harian
                'id_tingkatquiz' => 1, // Mudah
                'mode_pengerjaan' => 'biasa',
                'durasi_total_menit' => 25,
                'token' => null,
                'proggressQuiz' => 'Tersedia',
                'opsi_preview' => 'lengkap',
                'soal' => [
                    [
                        'jenis' => 'pilihan_ganda',
                        'pertanyaan' => 'Era revolusi industri pertama kali bermula dan berkembang pesat pada abad ke-18 di negara...',
                        'poin' => 10,
                        'durasi_detik' => 20,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Prancis', 'is_correct' => false],
                            ['label' => 'B', 'teks_pilihan' => 'Amerika Serikat', 'is_correct' => false],
                            ['label' => 'C', 'teks_pilihan' => 'Inggris', 'is_correct' => true],
                            ['label' => 'D', 'teks_pilihan' => 'Jerman', 'is_correct' => false],
                        ],
                    ],
                    [
                        'jenis' => 'isian',
                        'pertanyaan' => 'Samudra terbesar dan terluas di planet Bumi yang membentang di antara Benua Asia dan Amerika adalah Samudra...',
                        'poin' => 10,
                        'durasi_detik' => 20,
                        'jawaban_benar' => 'pasifik',
                    ],
                    [
                        'jenis' => 'benar_salah',
                        'pertanyaan' => 'Galaksi tempat tata surya kita bernaung bernama Galaksi Bima Sakti (Milky Way).',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'jawaban_benar' => 'A', // Benar
                    ],
                    [
                        'jenis' => 'pilihan_ganda',
                        'pertanyaan' => 'Gaya bahasa (majas) yang membandingkan dua hal secara langsung atas dasar sifat yang sama tanpa menggunakan kata pembanding (seperti/laksana) disebut majas...',
                        'poin' => 10,
                        'durasi_detik' => 20,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Personifikasi', 'is_correct' => false],
                            ['label' => 'B', 'teks_pilihan' => 'Hiperbola', 'is_correct' => false],
                            ['label' => 'C', 'teks_pilihan' => 'Metafora', 'is_correct' => true],
                            ['label' => 'D', 'teks_pilihan' => 'Litotes', 'is_correct' => false],
                        ],
                    ],
                    [
                        'jenis' => 'isian',
                        'pertanyaan' => 'Konferensi Meja Bundar (KMB) tahun 1949 yang menghasilkan pengakuan kedaulatan Indonesia oleh Belanda diselenggarakan di kota...',
                        'poin' => 15,
                        'durasi_detik' => 20,
                        'jawaban_benar' => 'den haag',
                    ],
                    [
                        'jenis' => 'benar_salah',
                        'pertanyaan' => 'Menurut hukum permintaan ekonomi, apabila harga suatu barang melonjak tinggi, maka jumlah barang yang diminta konsumen cenderung akan meningkat drastis.',
                        'poin' => 10,
                        'durasi_detik' => 15,
                        'jawaban_benar' => 'B', // Salah (cenderung turun)
                    ],
                ],
            ],
        ];

        DB::transaction(function () use ($quizList) {
            foreach ($quizList as $qData) {
                // Buat atau perbarui Quiz berdasarkan Judul
                $quiz = Quiz::updateOrCreate(
                    ['judul' => $qData['judul']],
                    [
                        'deskripsi' => $qData['deskripsi'],
                        'id_jenjang' => $qData['id_jenjang'],
                        'id_tipequiz' => $qData['id_tipequiz'],
                        'id_tingkatquiz' => $qData['id_tingkatquiz'],
                        'mode_pengerjaan' => $qData['mode_pengerjaan'],
                        'durasi_total_menit' => $qData['durasi_total_menit'],
                        'token' => $qData['token'],
                        'proggressQuiz' => $qData['proggressQuiz'],
                        'opsi_preview' => $qData['opsi_preview'] ?? 'lengkap',
                        'waktu_kadaluarsa' => null,
                    ]
                );

                // Buat atau perbarui Soal-soal dalam Quiz
                foreach ($qData['soal'] as $index => $sData) {
                    $jenis = $sData['jenis']; // 'pilihan_ganda', 'benar_salah', 'isian'

                    $idJenisSoal = 1;
                    $jawabanBenar = 'A';

                    if ($jenis === 'isian') {
                        $idJenisSoal = 2; // Essay / Isian
                        $jawabanBenar = mb_strtolower(trim($sData['jawaban_benar']));
                    } elseif ($jenis === 'benar_salah') {
                        $idJenisSoal = 3; // Benar / Salah
                        $jawabanBenar = strtoupper(trim($sData['jawaban_benar'])); // 'A' (Benar) atau 'B' (Salah)
                    } else {
                        $idJenisSoal = 1; // Pilihan Ganda
                        // Cari label yang benar
                        foreach ($sData['pilihan'] as $p) {
                            if (!empty($p['is_correct'])) {
                                $jawabanBenar = strtoupper(trim($p['label']));
                                break;
                            }
                        }
                    }

                    // Cari atau buat soal berdasarkan id_quiz dan pertanyaan
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

                    // Buat / Sinkronisasi pilihan jawaban
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
                        // Soal isian tidak memiliki pilihan ganda
                        PilihanSoal::where('id_soal', $soal->id_soal)->delete();
                    }
                }
            }
        });
    }
}

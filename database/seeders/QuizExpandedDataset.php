<?php

namespace Database\Seeders;

class QuizExpandedDataset
{
    /**
     * Mengembalikan 273 kuis tambahan kurikulum lengkap (7 kuis per kombinasi jenjang & mapel)
     * sehingga setiap mapel memiliki setidaknya 10 kuis untuk masing-masing jenjang.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function getQuizzes(): array
    {
        return array (
  0 => 
  array (
    'judul' => 'Kuis Pecahan Senilai & Sederhana SD',
    'deskripsi' => 'Latihan menyederhanakan pecahan dan mengenali bentuk pecahan senilai SD.',
    'id_jenjang' => 1,
    'id_mapel' => 1,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pecahan paling sederhana dari 12/16 adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '1/2',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '2/3',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '3/4',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '4/5',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pecahan 2/4 nilainya sama besar dengan pecahan 1/2.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Bentuk desimal dari pecahan satu per empat (1/4) adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '0,25',
      ),
    ),
  ),
  1 => 
  array (
    'judul' => 'Evaluasi Keliling & Luas Bangun Datar SD',
    'deskripsi' => 'Uji kemampuan menghitung keliling dan luas persegi serta persegi panjang SD.',
    'id_jenjang' => 1,
    'id_mapel' => 1,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Keliling persegi panjang dengan panjang 10 cm dan lebar 6 cm adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '16 cm',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '32 cm',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '60 cm',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '40 cm',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Luas segitiga dihitung dengan rumus alas dikali tinggi dibagi dua.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Luas persegi yang memiliki panjang sisi 7 cm adalah... cm²',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '49',
      ),
    ),
  ),
  2 => 
  array (
    'judul' => 'Kuis Satuan Waktu & Kecepatan SD',
    'deskripsi' => 'Mengenal konversi jam ke menit dan perhitungan kecepatan jarak waktu SD.',
    'id_jenjang' => 1,
    'id_mapel' => 1,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => '1 jam 30 menit sama dengan berapa menit?',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '60 menit',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '75 menit',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '90 menit',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '120 menit',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Dalam waktu satu menit terdapat 60 detik.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Jika mobil melaju menempuh 100 km dalam 2 jam, maka kecepatannya adalah... km/jam',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '50',
      ),
    ),
  ),
  3 => 
  array (
    'judul' => 'Ulangan Bangun Ruang Kubus & Balok SD',
    'deskripsi' => 'Penilaian sifat rusuk, titik sudut, dan volume kubus balok SD.',
    'id_jenjang' => 1,
    'id_mapel' => 1,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sebuah kubus memiliki jumlah rusuk sebanyak...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '6',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '8',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '12',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '14',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Balok memiliki 6 sisi yang seluruhnya berbentuk persegi identik.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'B',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Volume kubus yang memiliki panjang rusuk 5 cm adalah... cm³',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '125',
      ),
    ),
  ),
  4 => 
  array (
    'judul' => 'Latihan Bilangan Bulat Negatif SD',
    'deskripsi' => 'Konsep garis bilangan dan penjumlahan pengurangan bilangan bulat negatif SD.',
    'id_jenjang' => 1,
    'id_mapel' => 1,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Hasil operasi hitung dari -15 + 8 adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '-23',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '-7',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '7',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '23',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Bilangan -5 nilainya lebih kecil dibandingkan bilangan -2.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Lawan dari bilangan positif 35 adalah bilangan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '-35',
      ),
    ),
  ),
  5 => 
  array (
    'judul' => 'Tantangan Pengolahan Data & Diagram SD',
    'deskripsi' => 'Membaca diagram batang dan menentukan modus median mean data SD.',
    'id_jenjang' => 1,
    'id_mapel' => 1,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Nilai yang paling sering muncul dalam suatu kumpulan data disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Mean',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Median',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Modus',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Kuartil',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Diagram batang menyajikan persebaran data dalam bentuk batang persegi panjang.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Nilai tengah dari sekumpulan data yang telah diurutkan disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'median',
      ),
    ),
  ),
  6 => 
  array (
    'judul' => 'Uji Skala & Denah Peta SD',
    'deskripsi' => 'Perhitungan jarak sebenarnya berdasarkan skala gambar denah peta SD.',
    'id_jenjang' => 1,
    'id_mapel' => 1,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Jika skala peta 1 : 100.000, maka jarak 1 cm pada peta mewakili jarak sebenarnya...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '1 meter',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '10 meter',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '1 kilometer',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '10 kilometer',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Skala peta adalah perbandingan antara jarak pada gambar dengan jarak sebenarnya.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Jarak pada peta 3 cm dengan skala 1 : 50.000 mewakili jarak sebenarnya... meter',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '1500',
      ),
    ),
  ),
  7 => 
  array (
    'judul' => 'Kuis Teorema Pythagoras SMP',
    'deskripsi' => 'Penerapan dalil Pythagoras pada segitiga siku-siku dan tripel Pythagoras SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 1,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Segitiga siku-siku memiliki sisi siku-siku 5 cm dan 12 cm. Sisi miringnya adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '13 cm',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '14 cm',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '15 cm',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '17 cm',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Kelompok bilangan 3, 4, dan 5 merupakan tripel Pythagoras.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Panjang hipotenusa segitiga siku-siku dengan sisi tegak 9 cm dan 12 cm adalah... cm',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '15',
      ),
    ),
  ),
  8 => 
  array (
    'judul' => 'Evaluasi Persamaan Garis Lurus SMP',
    'deskripsi' => 'Menentukan gradien, persamaan garis sejajar, dan garis tegak lurus SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 1,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Gradien garis dengan persamaan y = 3x - 5 adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '-5',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '3',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '5',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '-3',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Dua garis lurus yang saling sejajar memiliki nilai gradien yang sama.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Gradien garis yang tegak lurus dengan garis bergradien 2 adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '-1/2',
      ),
    ),
  ),
  9 => 
  array (
    'judul' => 'Kuis Sistem Persamaan Linear Dua Variabel SMP',
    'deskripsi' => 'Penyelesaian SPLDV metode eliminasi dan substitusi SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 1,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Jika x + y = 10 dan x - y = 4, maka nilai x adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '5',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '6',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '7',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '8',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Metode eliminasi menyelesaikan SPLDV dengan mengeliminasi salah satu variabel.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Jika 2x = 12, maka nilai dari x + 5 adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '11',
      ),
    ),
  ),
  10 => 
  array (
    'judul' => 'Ulangan Bangun Ruang Sisi Lengkung SMP',
    'deskripsi' => 'Menghitung luas permukaan dan volume tabung, kerucut, dan bola SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 1,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Rumus volume tabung dengan jari-jari r dan tinggi t adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'πrt',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'πr²t',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '2πrt',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '1/3 πr²t',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Kerucut memiliki 1 rusuk lengkung dan 1 titik puncak.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Volume kerucut yang memiliki luas alas 30 cm² dan tinggi 10 cm adalah... cm³',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '100',
      ),
    ),
  ),
  11 => 
  array (
    'judul' => 'Latihan Pola Bilangan & Barisan SMP',
    'deskripsi' => 'Menentukan rumus suku ke-n barisan aritmatika dan pola bertingkat SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 1,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Tiga suku berikutnya dari barisan 2, 6, 10, 14, ... adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '16, 18, 20',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '18, 22, 26',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '17, 21, 25',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '18, 20, 24',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Barisan 3, 6, 12, 24 merupakan contoh barisan geometri dengan rasio 2.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Beda (selisih) dari barisan aritmatika 7, 12, 17, 22 adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '5',
      ),
    ),
  ),
  12 => 
  array (
    'judul' => 'Tantangan Kesebangunan & Kekongruenan SMP',
    'deskripsi' => 'Syarat-syarat kesebangunan segitiga dan trapesium bertingkat SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 1,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Dua bangun datar dikatakan kongruen jika memiliki...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Bentuk sama ukuran beda',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Bentuk dan ukuran yang sama persis',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Keliling yang sama saja',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Luas yang berbeda',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Dua segitiga sama sisi dengan panjang sisi berbeda adalah sebangun.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Syarat sudut pada dua bangun datar yang sebangun adalah sudut yang bersesuaian besarnya...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'sama',
      ),
    ),
  ),
  13 => 
  array (
    'judul' => 'Uji Peluang Teoretik SMP',
    'deskripsi' => 'Menghitung peluang kejadian pada koin, dadu, dan kartu bridge SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 1,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Peluang muncul angka pada pelemparan satu koin logam adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '1/4',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '1/3',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '1/2',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '1',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Peluang suatu peristiwa yang pasti terjadi bernilai 1.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Jika peluang turun hujan adalah 0,3 maka peluang tidak turun hujan adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '0,7',
      ),
    ),
  ),
  14 => 
  array (
    'judul' => 'Kuis Trigonometri Sudut Relasi SMA',
    'deskripsi' => 'Nilai perbandingan trigonometri di kuadran I hingga IV SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 1,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Nilai dari cos 60 derajat adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '0',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '1/2',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '1/2 √2',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '1/2 √3',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Nilai sin 90 derajat sama dengan 1.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Nilai dari sin 30 derajat ditambah cos 60 derajat adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '1',
      ),
    ),
  ),
  15 => 
  array (
    'judul' => 'Evaluasi Matriks & Invers Ordo 2x2 SMA',
    'deskripsi' => 'Operasi perkalian matriks, determinan, dan invers matriks SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 1,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Jika determinan matriks bernilai nol, matriks tersebut dinamakan matriks...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Identitas',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Singular',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Diagonal',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Skalar',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Matriks persegi memiliki invers jika dan hanya jika determinannya tidak nol.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Determinan dari matriks [[2, 1], [4, 3]] adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '2',
      ),
    ),
  ),
  16 => 
  array (
    'judul' => 'Kuis Vektor Dimensi Dua & Tiga SMA',
    'deskripsi' => 'Panjang vektor, perkalian skalar, dan proyeksi ortogonal SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 1,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Panjang vektor v = (3, 4) adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '5',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '7',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '12',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '25',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Dua vektor saling tegak lurus jika hasil kali titik keduanya bernilai nol.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Hasil perkalian titik (dot product) vektor (2, 3) dan (4, -1) adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '5',
      ),
    ),
  ),
  17 => 
  array (
    'judul' => 'Ulangan Limit Fungsi Aljabar SMA',
    'deskripsi' => 'Penentuan nilai limit fungsi aljabar mendekati titik tertentu SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 1,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Nilai limit x mendekati 2 dari (x² - 4) / (x - 2) adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '0',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '2',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '4',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '8',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Jika substitusi langsung menghasilkan 0/0, fungsi dapat difaktorkan terlebih dahulu.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Nilai limit x mendekati 3 dari (2x + 1) adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '7',
      ),
    ),
  ),
  18 => 
  array (
    'judul' => 'Latihan Turunan Fungsi Aljabar SMA',
    'deskripsi' => 'Aturan turunan fungsi aljabar, rantai diferensial, dan gradien garis singgung SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 1,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Turunan pertama dari f(x) = 4x³ adalah f\'(x) = ...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '12x²',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '7x²',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '12x',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '4x²',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Turunan pertama dari fungsi konstanta c selalu sama dengan nol.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Turunan pertama dari f(x) = 5x + 7 adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '5',
      ),
    ),
  ),
  19 => 
  array (
    'judul' => 'Tantangan Integral Tak Tentu SMA',
    'deskripsi' => 'Penerapan antiturunan dan integral dasar fungsi polinomial SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 1,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Hasil dari integral 6x dx adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '3x² + C',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '6x² + C',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '2x³ + C',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '6 + C',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Integral merupakan operasi antiturunan kebalikan dari diferensial.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Hasil integral dari 2x dx adalah x kuadrat ditambah konstanta...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'c',
      ),
    ),
  ),
  20 => 
  array (
    'judul' => 'Uji Dimensi Tiga Jarak Titik SMA',
    'deskripsi' => 'Menghitung jarak titik ke garis dan titik ke bidang pada kubus SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 1,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 40,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Panjang diagonal ruang kubus dengan panjang rusuk s adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 's√2',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 's√3',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '2s',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 's²',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pada kubus, panjang diagonal bidang adalah s akar 2.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Panjang diagonal bidang kubus dengan rusuk 6 cm adalah 6 akar...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '2',
      ),
    ),
  ),
  21 => 
  array (
    'judul' => 'Kuis Ide Pokok & Paragraf SD',
    'deskripsi' => 'Menemukan ide pokok dan kalimat penjelas dalam bacaan sederhana SD.',
    'id_jenjang' => 1,
    'id_mapel' => 2,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Gagasan utama yang mendasari sebuah paragraf disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Kalimat pengembang',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Ide pokok',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Kata kunci',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Rangkuman',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Dalam satu paragraf yang baik hanya terdapat satu ide pokok utama.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Paragraf yang kalimat utamanya terletak di awal paragraf disebut paragraf...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'deduktif',
      ),
    ),
  ),
  22 => 
  array (
    'judul' => 'Evaluasi Kata Baku & Ejaan SD',
    'deskripsi' => 'Mengidentifikasi kata baku sesuai KBBI dan penggunaan tanda baca SD.',
    'id_jenjang' => 1,
    'id_mapel' => 2,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Penulisan kata baku yang benar menurut KBBI adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Apotik',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Apotek',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Apoteek',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Apoteg',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Tanda titik dipakai pada akhir kalimat pernyataan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Huruf pertama pada awal kalimat harus selalu ditulis menggunakan huruf...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'kapital',
      ),
    ),
  ),
  23 => 
  array (
    'judul' => 'Kuis Ungkapan & Peribahasa SD',
    'deskripsi' => 'Mengenal arti ungkapan dan peribahasa populer bahasa Indonesia SD.',
    'id_jenjang' => 1,
    'id_mapel' => 2,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Ungkapan "panjang tangan" memiliki makna...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Suka mencuri',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Suka menolong',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Mudah marah',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Rajin bekerja',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Orang yang rendah hati artinya orang yang tidak sombong.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Lengkapilah peribahasa berikut: "Ada gula, ada..."',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'semut',
      ),
    ),
  ),
  24 => 
  array (
    'judul' => 'Ulangan Puisi Anak & Rima SD',
    'deskripsi' => 'Mengidentifikasi unsur rima bunyi dan bait dalam puisi anak SD.',
    'id_jenjang' => 1,
    'id_mapel' => 2,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Persamaan bunyi pada akhir baris puisi disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Irama',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Rima',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Bait',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Larik',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Membaca puisi dengan gaya dan penghayatan yang indah disebut deklamasi.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Satu bait pantun standar terdiri atas berapa baris?',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '4',
      ),
    ),
  ),
  25 => 
  array (
    'judul' => 'Latihan Surat Pribadi & Bagian Surat SD',
    'deskripsi' => 'Memahami bagian tanggal surat, salam pembuka, dan isi surat SD.',
    'id_jenjang' => 1,
    'id_mapel' => 2,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Salam pembuka yang lazim dan santun pada surat untuk sahabat adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Dengan hormat,',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Halo sahabatku,',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Kepada Yth,',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Salam sejahtera,',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Surat pribadi wajib mencantumkan kop surat resmi instansi.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'B',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Bagian surat yang menyatakan rasa terima kasih dan harapan biasanya terletak pada bagian...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'penutup',
      ),
    ),
  ),
  26 => 
  array (
    'judul' => 'Tantangan Teks Fabel & Cerita Dongeng SD',
    'deskripsi' => 'Menentukan tokoh, watak antagonis, dan amanat dalam dongeng fabel SD.',
    'id_jenjang' => 1,
    'id_mapel' => 2,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Tokoh dalam cerita yang memiliki sifat jahat dinamakan tokoh...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Protagonis',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Antagonis',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Tritagonis',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Figuran',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Fabel adalah dongeng yang tokoh-tokohnya diperankan oleh hewan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pesan kebaikan moral yang ingin disampaikan pengarang kepada pembaca disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'amanat',
      ),
    ),
  ),
  27 => 
  array (
    'judul' => 'Uji Kalimat Efektif & Tanda Tanya SD',
    'deskripsi' => 'Menyusun kalimat efektif dan ketepatan penggunaan tanda baca SD.',
    'id_jenjang' => 1,
    'id_mapel' => 2,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kalimat berikut yang merupakan kalimat efektif yang tepat adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Para ibu-ibu sekalian hadir.',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Ibu-ibu hadir di aula.',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Banyak anak-anak bermain-main.',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Siswa-siswa saling bersalam-salaman.',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Kalimat tanya dalam ragam tulis selalu diakhiri dengan tanda tanya (?).',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Lawan kata (antonim) dari kata "hemat" adalah kata...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'boros',
      ),
    ),
  ),
  28 => 
  array (
    'judul' => 'Kuis Teks Laporan Hasil Observasi SMP',
    'deskripsi' => 'Memahami sifat objektif, struktur definisi umum, dan deskripsi bagian LHO SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 2,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Teks laporan hasil observasi harus disusun berdasarkan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Imajinasi penulis',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Fakta hasil pengamatan',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Opini masyarakat',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Cerita fiktif',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Teks LHO bersifat objektif dan tidak memihak.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Bagian pembuka teks LHO yang memuat pengertian umum objek disebut pernyataan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'umum',
      ),
    ),
  ),
  29 => 
  array (
    'judul' => 'Evaluasi Teks Iklan, Slogan & Poster SMP',
    'deskripsi' => 'Unsur kalimat persuasif, slogan motivasi, dan visual poster SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 2,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kalimat yang bersifat mengajak, membujuk, atau memengaruhi pembaca disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Deklaratif',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Persuasif',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Imperatif',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Interogatif',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Slogan biasanya berbentuk kalimat pendek yang menarik dan mudah diingat.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Karya seni yang memadukan gambar dan teks di selembar kertas besar disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'poster',
      ),
    ),
  ),
  30 => 
  array (
    'judul' => 'Kuis Teks Eksposisi & Argumen Logis SMP',
    'deskripsi' => 'Menganalisis tesis, argumen penguat, dan penegasan ulang eksposisi SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 2,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Bagian teks eksposisi yang berisi sudut pandang penulis terhadap masalah adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Tesis',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Argumen',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Rekomendasi',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Koda',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Argumen dalam teks eksposisi harus didukung oleh data dan fakta yang valid.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Teks eksposisi bertujuan menambah pengetahuan dan ... pembaca.',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'wawasan',
      ),
    ),
  ),
  31 => 
  array (
    'judul' => 'Ulangan Puisi Rakyat: Pantun & Gurindam SMP',
    'deskripsi' => 'Struktur sampiran isi pantun, bait gurindam dua baris SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 2,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pola sajak akhir yang digunakan dalam pantun empat baris adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'a-a-a-a',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'a-b-a-b',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'a-a-b-b',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'a-b-b-a',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Baris pertama dan kedua pada pantun merupakan bagian sampiran.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Puisi rakyat yang tiap baitnya terdiri dari dua baris dan bersajak a-a disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'gurindam',
      ),
    ),
  ),
  32 => 
  array (
    'judul' => 'Latihan Teks Cerpen & Tahapan Alur SMP',
    'deskripsi' => 'Menganalisis perkenalan, komplikasi, klimaks, dan resolusi cerpen SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 2,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Puncak ketegangan konflik dalam suatu alur cerita disebut tahap...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Orientasi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Komplikasi',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Klimaks',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Resolusi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Sudut pandang orang pertama dalam cerpen ditandai dengan penggunaan kata "aku" atau "saya".',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Tahap penyelesaian konflik dalam struktur cerpen dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'resolusi',
      ),
    ),
  ),
  33 => 
  array (
    'judul' => 'Tantangan Teks Tanggapan Kritis SMP',
    'deskripsi' => 'Menyampaikan evaluasi, pujian, dan kritikan objektif yang santun SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 2,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kritikan terhadap suatu karya harus disampaikan secara...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Kasar',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Santun dan membangun',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Menjatuhkan',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Berbelit-belit',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Teks tanggapan dapat memuat kritik maupun pujian terhadap karya.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Bagian penutup teks tanggapan yang berisi pertimbangan akhir disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'penegasan',
      ),
    ),
  ),
  34 => 
  array (
    'judul' => 'Uji Teks Diskusi Pro dan Kontra SMP',
    'deskripsi' => 'Menganalisis isu kontroversial, argumen pendukung, dan argumen penentang SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 2,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Topik bahasan yang mengandung sudut pandang saling berbeda dalam teks diskusi disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Isu',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Simpulan',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Abstraksi',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Orientasi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Argumen kontra adalah argumen yang menentang atau menolak isu diskusi.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Sikap penengah yang mencari jalan keluar pada akhir teks diskusi dirumuskan dalam bagian...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'simpulan',
      ),
    ),
  ),
  35 => 
  array (
    'judul' => 'Kuis Teks Anekdot & Kritik Sosial SMA',
    'deskripsi' => 'Menganalisis sindiran halus, unsur humor, dan pesan sosial anekdot SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 2,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Teks rekaan singkat yang lucu dan bertujuan menyindir persoalan publik disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Fabel',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Anekdot',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Eksposisi',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Hikayat',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Struktur teks anekdot secara urut adalah abstraksi, orientasi, krisis, reaksi, dan koda.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Bagian akhir teks anekdot yang menunjukkan penyelesaian cerita dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'koda',
      ),
    ),
  ),
  36 => 
  array (
    'judul' => 'Evaluasi Teks Negosiasi Bisnis SMA',
    'deskripsi' => 'Tahapan orientasi, pengajuan, penawaran, dan persetujuan negosiasi SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 2,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Tujuan utama dari kegiatan negosiasi antara dua pihak adalah mencapai...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Kemenangan sepihak',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Kesepakatan bersama yang saling menguntungkan',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Perselisihan baru',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Pembatalan transaksi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Dalam bernegosiasi kedua pihak harus saling menghormati dan tidak memaksakan kehendak.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Tahap mengajukan usulan kompromi harga dalam negosiasi disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'penawaran',
      ),
    ),
  ),
  37 => 
  array (
    'judul' => 'Kuis Teks Biografi Tokoh Inspiratif SMA',
    'deskripsi' => 'Mengidentifikasi keteladanan, peristiwa penting, dan reorientasi biografi SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 2,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Riwayat hidup seorang tokoh yang ditulis oleh orang lain dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Autobiografi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Biografi',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Bibliografi',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Monografi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Biografi berisikan fakta perjalanan hidup, perjuangan, dan inspirasi tokoh.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kisah riwayat hidup yang ditulis sendiri oleh sang tokoh disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'autobiografi',
      ),
    ),
  ),
  38 => 
  array (
    'judul' => 'Ulangan Surat Lamaran Pekerjaan SMA',
    'deskripsi' => 'Sistematika penulisan lampiran, kualifikasi, riwayat hidup surat lamaran SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 2,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Surat lamaran pekerjaan tergolong ke dalam jenis surat...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Pribadi resmi',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Dinas antarlembaga',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Niaga komersial',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Pribadi kekeluargaan',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Daftar riwayat hidup (curriculum vitae) dilampirkan bersama surat lamaran pekerjaan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kata penutup santun pada akhir surat lamaran pekerjaan menyatakan rasa...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'terima kasih',
      ),
    ),
  ),
  39 => 
  array (
    'judul' => 'Latihan Teks Editorial Media Massa SMA',
    'deskripsi' => 'Menganalisis tajuk rencana opini redaksi terhadap peristiwa aktual SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 2,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Teks editorial dalam surat kabar mencerminkan sikap dan pandangan dari...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Wartawan lapangan',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Dewan redaksi',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Narasumber berita',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Pembaca umum',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Teks editorial sering disebut juga sebagai tajuk rencana.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Fakta dalam teks editorial berfungsi untuk memperkuat ... dewan redaksi.',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'opini',
      ),
    ),
  ),
  40 => 
  array (
    'judul' => 'Tantangan Artikel Ilmiah Populer SMA',
    'deskripsi' => 'Membedakan opini dan fakta serta gaya bahasa komunikatif ilmiah populer SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 2,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Ciri utama artikel ilmiah populer yang membedakannya dari jurnal murni adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Tidak memuat data',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Bahasa santai komunikatif dan mudah dipahami publik',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Tanpa topik jelas',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Sepenuhnya cerita fiksi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Kalimat fakta dapat dibuktikan kebenarannya secara empiris.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pernyataan yang memuat gagasan atau sikap pribadi penulis disebut kalimat...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'opini',
      ),
    ),
  ),
  41 => 
  array (
    'judul' => 'Uji Resensi Novel & Kritik Sastra SMA',
    'deskripsi' => 'Unsur identitas buku, sinopsis, kelebihan dan kekurangan karya novel SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 2,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kegiatan mengulas dan memberikan penilaian kritis terhadap kualitas sebuah buku disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Resensi',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Notula',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Transkrip',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Eksemplar',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Sinopsis dalam resensi novel berisi ringkasan garis besar alur cerita.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Penilaian mengenai keunggulan dan kelemahan buku berada pada bagian evaluasi atau...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'pertimbangan',
      ),
    ),
  ),
  42 => 
  array (
    'judul' => 'Kuis Daily Greetings & Intro SD',
    'deskripsi' => 'Salam perkenalan diri sederhana dan ungkapan kabar dalam bahasa Inggris SD.',
    'id_jenjang' => 1,
    'id_mapel' => 3,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'The best response to "How do you do?" when meeting for the first time is...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'I am fine',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'How do you do?',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'See you later',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Good night',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => '"Good morning" is used to greet someone before noon.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Complete: "My ... is Sarah." (nama)',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'name',
      ),
    ),
  ),
  43 => 
  array (
    'judul' => 'Evaluasi Numbers & Classroom Items SD',
    'deskripsi' => 'Menghitung angka 1-50 dan menyebutkan nama alat tulis di kelas SD.',
    'id_jenjang' => 1,
    'id_mapel' => 3,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'What is the English word for "papan tulis"?',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Cupboard',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Whiteboard',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Bookshelf',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Eraser',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Twenty plus fifteen equals thirty-five.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'The English word for "penggaris" is...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'ruler',
      ),
    ),
  ),
  44 => 
  array (
    'judul' => 'Kuis Animals & Their Sounds SD',
    'deskripsi' => 'Mengenal hewan peliharaan, hewan liar, dan habitat sederhananya SD.',
    'id_jenjang' => 1,
    'id_mapel' => 3,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Which animal is known as the "King of the Jungle"?',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Tiger',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Lion',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Elephant',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Giraffe',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'A cow produces milk for human consumption.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'The English word for "kucing" is...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'cat',
      ),
    ),
  ),
  45 => 
  array (
    'judul' => 'Ulangan Food, Fruits & Drinks SD',
    'deskripsi' => 'Menyebutkan makanan sehat, buah-buahan, dan minuman dalam bahasa Inggris SD.',
    'id_jenjang' => 1,
    'id_mapel' => 3,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Which of the following is a citrus fruit rich in Vitamin C?',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Apple',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Orange',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Banana',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Watermelon',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Tea and mineral water are examples of beverages.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'The English word for "roti" is...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'bread',
      ),
    ),
  ),
  46 => 
  array (
    'judul' => 'Latihan Family Members SD',
    'deskripsi' => 'Menyebutkan anggota keluarga: parents, siblings, grandparents SD.',
    'id_jenjang' => 1,
    'id_mapel' => 3,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'The brother of your mother or father is your...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Uncle',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Aunt',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Nephew',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Cousin',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Grandmother is the mother of your parents.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'The English word for "saudara perempuan" is...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'sister',
      ),
    ),
  ),
  47 => 
  array (
    'judul' => 'Tantangan Colors & Clothing SD',
    'deskripsi' => 'Mengenal warna benda dan kosakata pakaian sehari-hari SD.',
    'id_jenjang' => 1,
    'id_mapel' => 3,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'What color do you get if you mix blue and yellow?',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Purple',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Green',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Orange',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Brown',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'We wear a jacket when the weather is cold.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'The English word for "sepatu" is...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'shoes',
      ),
    ),
  ),
  48 => 
  array (
    'judul' => 'Uji Parts of the Body SD',
    'deskripsi' => 'Mengenal fungsi panca indra dan anggota tubuh dalam bahasa Inggris SD.',
    'id_jenjang' => 1,
    'id_mapel' => 3,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'We use our ears to...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Smell',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Listen to music',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Taste food',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Touch objects',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Humans normally have ten fingers on both hands.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'The English word for "hidung" is...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'nose',
      ),
    ),
  ),
  49 => 
  array (
    'judul' => 'Kuis Descriptive Text: Famous Tourism SMP',
    'deskripsi' => 'Struktur identification dan description tempat wisata bersejarah SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 3,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'The main social purpose of a descriptive text is to...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Persuade readers',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Describe a particular person, place, or thing',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Retell a past event',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Explain step-by-step procedures',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Descriptive text predominantly employs the Simple Present Tense.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'The first paragraph that introduces the object in descriptive text is called...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'identification',
      ),
    ),
  ),
  50 => 
  array (
    'judul' => 'Evaluasi Procedure Text: Food Recipe SMP',
    'deskripsi' => 'Imperative verbs, temporal connectives, dan goal-ingredients-steps SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 3,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Words like "first", "next", "then", and "finally" are called...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Comparative adjectives',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Temporal conjunctions',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Modal auxiliaries',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Possessive pronouns',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Imperative sentences in recipes give instructions to the cook.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'The ingredients needed to make a dish are also called...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'materials',
      ),
    ),
  ),
  51 => 
  array (
    'judul' => 'Kuis Recount Text: Personal Memories SMP',
    'deskripsi' => 'Orientasi, rentetan peristiwa masa lampau, dan reorientasi recount SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 3,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Which tense is mainly used in writing a recount text?',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Simple Present Tense',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Simple Past Tense',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Present Continuous Tense',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Future Tense',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'A recount text retells past events in chronological order.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'The past tense (V2) of the irregular verb "go" is...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'went',
      ),
    ),
  ),
  52 => 
  array (
    'judul' => 'Ulangan Narrative Text: Fables & Folklores SMP',
    'deskripsi' => 'Karakter fabel, komplikasi masalah, dan pesan moral naratif SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 3,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'The stage in a narrative text where problems arise between characters is...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Orientation',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Complication',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Resolution',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Coda',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Fables are narrative stories where animal characters act like humans.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'The moral lesson that readers learn from a story is called moral...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'value',
      ),
    ),
  ),
  53 => 
  array (
    'judul' => 'Latihan Notice, Warning & Prohibition Signs SMP',
    'deskripsi' => 'Memahami rambu peringatan keselamatan publik dan larangan SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 3,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'A sign reading "No Littering" means visitors must...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Throw rubbish anywhere',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Keep the area clean and not throw garbage',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Plant flowers',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Leave plastic bags on the bench',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'The phrase "Staff Only" means the public is prohibited from entering.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'A sign warning about slippery wet floor is categorized as a...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'caution',
      ),
    ),
  ),
  54 => 
  array (
    'judul' => 'Tantangan Degrees of Comparison SMP',
    'deskripsi' => 'Bentuk perbandingan positive, comparative, dan superlative SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 3,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Mount Everest is the ... mountain peak in the world.',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Highest',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Higher',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'High',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Most high',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'The comparative form of "good" is "better".',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Complete: "An elephant is ... than a goat." (big)',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'bigger',
      ),
    ),
  ),
  55 => 
  array (
    'judul' => 'Uji Passive Voice Daily Situations SMP',
    'deskripsi' => 'Mengubah kalimat aktif menjadi kalimat pasif bentuk simple present dan past SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 3,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Passive form of: "The chef cooks delicious pasta every evening." is...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Delicious pasta is cooked by the chef every evening.',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Delicious pasta was cooked by the chef.',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Delicious pasta cooked by chef.',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'The chef is cooked pasta.',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'In passive sentences, the object of the active verb becomes the subject.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Complete: "English is ... all over the world." (speak -> V3)',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'spoken',
      ),
    ),
  ),
  56 => 
  array (
    'judul' => 'Kuis Analytical Exposition: Global Ecology SMA',
    'deskripsi' => 'Thesis statement, elaborate arguments, reiteration exposition SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 3,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'An analytical exposition text aims to persuade the reader that...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'An event is amusing',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'The topic presented is an important issue to consider',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Step-by-step methods are necessary',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'A story happened in ancient times',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'The final conclusion restating the thesis in analytical exposition is called reiteration.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Arguments presented in exposition text must be backed up by factual...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'evidence',
      ),
    ),
  ),
  57 => 
  array (
    'judul' => 'Evaluasi Hortatory Exposition: Social Campaigns SMA',
    'deskripsi' => 'Membedakan rekomendasi solusi pada hortatory dengan analytical SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 3,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'The main difference between hortatory and analytical exposition is that hortatory ends with...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Reiteration',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Recommendation',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Resolution',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Orientation',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Recommendation in hortatory text suggests what should or should not happen.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'The generic structure of hortatory exposition includes thesis, arguments, and...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'recommendation',
      ),
    ),
  ),
  58 => 
  array (
    'judul' => 'Kuis News Item Text: Breaking News SMA',
    'deskripsi' => 'Headline, newsworthy event, background context, sources quote SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 3,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'The social function of a news item text is to inform readers about...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Fictional adventure stories',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Newsworthy events and noteworthy daily happenings',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Scientific biological classifications',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Personal emotional diaries',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Statements from witnesses or authorities are called sources in news item.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'The short catchy title printed at the top of a newspaper article is the...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'headline',
      ),
    ),
  ),
  59 => 
  array (
    'judul' => 'Ulangan Conditional Sentences Types 1, 2, 3 SMA',
    'deskripsi' => 'Pola pengandaian real possibility, hypothetical, dan past regret SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 3,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Complete: "If she had studied harder, she ... the university entrance exam."',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Will pass',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Would pass',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Would have passed',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Passed',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Conditional Sentence Type 2 expresses hypothetical conditions contrary to present facts.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Complete: "If water reaches 100 degrees Celsius, it ..." (boil)',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'boils',
      ),
    ),
  ),
  60 => 
  array (
    'judul' => 'Latihan Report Text: Scientific Fauna SMA',
    'deskripsi' => 'General classification dan scientific description of species SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 3,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Unlike descriptive text, a report text describes things...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Specifically and personally',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Generally as a whole natural class or phenomenon',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Fictitiously with fantasy',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Chronologically in time order',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Report texts frequently employ technical and scientific terminology.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'The introductory part of a report text is called general...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'classification',
      ),
    ),
  ),
  61 => 
  array (
    'judul' => 'Tantangan Discussion Text: Debated Technology SMA',
    'deskripsi' => 'Analyzing statement of issue, arguments for, arguments against, conclusion SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 3,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'A discussion text is designed to explore...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'A one-sided personal perspective',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Both affirmative (pro) and opposing (con) viewpoints on an issue',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Comic entertainment',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Cooking directions',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'A fair discussion text presents balanced viewpoints before concluding.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Points that contradict or disagree with the topic in discussion are arguments...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'against',
      ),
    ),
  ),
  62 => 
  array (
    'judul' => 'Uji Formal Business Invitation & Salutation SMA',
    'deskripsi' => 'Writing formal letters, RSVPs, formal register, salutation SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 3,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'On formal invitation cards, the abbreviation "RSVP" originates from French meaning...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Remember to bring a gift',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Please respond to confirm attendance',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Formal clothing only',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Reserved seating area',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Formal business correspondence avoids slang and contracted verb forms.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'When the recipient name is not known, the standard formal salutation begins with: "Dear Sir or ..."',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'madam',
      ),
    ),
  ),
  63 => 
  array (
    'judul' => 'Kuis Daur Hidup Hewan & Metamorfosis SD',
    'deskripsi' => 'Mengenal metamorfosis sempurna kupu-kupu katak dan tidak sempurna belalang SD.',
    'id_jenjang' => 1,
    'id_mapel' => 4,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Tahapan metamorfosis sempurna pada kupu-kupu yang benar adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Telur - pupa - ulat - dewasa',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Telur - ulat - kepompong (pupa) - kupu-kupu dewasa',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Ulat - telur - kepompong - dewasa',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Telur - nimfa - dewasa',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Katak mengalami fase kecebong atau berudu yang bernapas dengan insang.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Fase kepompong pada metamorfosis sempurna disebut juga fase...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'pupa',
      ),
    ),
  ),
  64 => 
  array (
    'judul' => 'Evaluasi Macam Gaya & Gesekan SD',
    'deskripsi' => 'Mengenal gaya otot, gaya gesek, gravitasi, dan magnet dalam kehidupan SD.',
    'id_jenjang' => 1,
    'id_mapel' => 4,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Gaya yang menyebabkan buah mangga matang jatuh ke permukaan tanah adalah gaya...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Otot',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Magnet',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Gravitasi',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Pegas',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Gaya gesek pada permukaan ban kendaraan bermotor membantu mencegah slip saat mengerem.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Alat yang digunakan untuk mengukur besar gaya adalah neraca pegas atau...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'dinamometer',
      ),
    ),
  ),
  65 => 
  array (
    'judul' => 'Kuis Sumber Energi Alternatif SD',
    'deskripsi' => 'Mengenal energi matahari, kincir angin, air terjun, dan biogas ramah lingkungan SD.',
    'id_jenjang' => 1,
    'id_mapel' => 4,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pembangkit listrik yang memanfaatkan pancaran sinar matahari menggunakan komponen...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Kincir angin',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Panel surya',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Turbin air',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Dinamo sepeda',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Energi angin dan air merupakan sumber energi terbarukan yang tidak cepat habis.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Gas alternatif terbarukan yang dihasilkan dari kotoran ternak membusuk disebut gas...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'biogas',
      ),
    ),
  ),
  66 => 
  array (
    'judul' => 'Ulangan Siklus Air & Pelestarian Alam SD',
    'deskripsi' => 'Mempelajari evaporasi, kondensasi, presipitasi, dan infiltrasi air SD.',
    'id_jenjang' => 1,
    'id_mapel' => 4,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Proses penguapan air permukaan laut dan danau menjadi uap air disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Kondensasi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Evaporasi',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Infiltrasi',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Presipitasi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Titik-titik air di awan yang jatuh ke bumi sebagai hujan dinamakan peristiwa presipitasi.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Penyerapan air hujan ke dalam pori-pori tanah disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'infiltrasi',
      ),
    ),
  ),
  67 => 
  array (
    'judul' => 'Latihan Sistem Pencernaan Manusia SD',
    'deskripsi' => 'Mengenal fungsi mulut, kerongkongan, lambung, usus halus, dan usus besar SD.',
    'id_jenjang' => 1,
    'id_mapel' => 4,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Penyerapan sari-sari makanan utama dalam tubuh manusia terjadi di...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Mulut',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Lambung',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Usus halus',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Usus besar',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Enzim ptialin (amilase) di dalam mulut berfungsi mencerna zat tepung (karbohidrat).',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Gerakan meremas dan mendorong makanan di sepanjang kerongkongan menuju lambung disebut gerak...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'peristaltik',
      ),
    ),
  ),
  68 => 
  array (
    'judul' => 'Tantangan Sistem Pernapasan Manusia SD',
    'deskripsi' => 'Mempelajari organ hidung, tenggorokan, trakea, bronkus, dan alveolus SD.',
    'id_jenjang' => 1,
    'id_mapel' => 4,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Tempat pertukaran gas oksigen (O2) dengan karbon dioksida (CO2) di paru-paru adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Trakea',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Bronkiolus',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Alveolus',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Faring',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Rambut hidung dan lendir berfungsi menyaring debu serta kotoran dari udara yang dihirup.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Otot sekat pembatas antara rongga dada dan rongga perut saat pernapasan disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'diafragma',
      ),
    ),
  ),
  69 => 
  array (
    'judul' => 'Uji Tata Surya & Gerhana Matahari SD',
    'deskripsi' => 'Urutan planet, orbit revolusi, rotasi bumi, dan gerhana bulan matahari SD.',
    'id_jenjang' => 1,
    'id_mapel' => 4,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Planet terdekat dari matahari dalam sistem tata surya kita adalah planet...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Venus',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Merkurius',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Mars',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Bumi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Perputaran bumi pada porosnya (rotasi) menyebabkan terjadinya pergantian siang dan malam.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Bulan berada di antara matahari dan bumi dalam satu garis lurus menyebabkan gerhana...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'matahari',
      ),
    ),
  ),
  70 => 
  array (
    'judul' => 'Kuis Pewarisan Sifat & Persilangan Mendel SMP',
    'deskripsi' => 'Persilangan monohibrid dominan resesif, genotipe dan fenotipe SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 4,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sifat fisik makhluk hidup yang dapat diamati langsung dari luar disebut sifat...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Genotipe',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Fenotipe',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Alel',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Dominan',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Persilangan monohibrid dominan penuh antara induk heterozigot (Aa x Aa) menghasilkan rasio fenotipe 3:1.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Bapak genetika dunia yang meneliti pewarisan sifat pada tanaman kacang ercis adalah Gregor...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'mendel',
      ),
    ),
  ),
  71 => 
  array (
    'judul' => 'Evaluasi Tekanan Hidrostatis & Hukum Pascal SMP',
    'deskripsi' => 'Menghitung tekanan zat padat, bejana berhubungan, dan dongkrak hidrolik SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 4,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Alat yang memanfaatkan prinsip perpindahan tekanan fluida zat cair ke segala arah menurut Hukum Pascal adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Termometer',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Dongkrak hidrolik',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Barometer',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Higrometer',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Tekanan hidrostatis di dalam zat cair semakin besar seiring bertambahnya kedalaman titik ukur.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Satuan internasional (SI) untuk besaran tekanan adalah N/m² atau...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'pascal',
      ),
    ),
  ),
  72 => 
  array (
    'judul' => 'Kuis Getaran, Gelombang & Resonansi SMP',
    'deskripsi' => 'Frekuensi getaran, periode, cepat rambat gelombang, dan bunyi pantul SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 4,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Banyaknya gelombang atau getaran yang dihasilkan dalam setiap satu detik disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Periode',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Frekuensi',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Amplitudo',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Cepat rambat',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Gelombang bunyi tidak dapat merambat melalui ruang hampa udara.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Waktu yang dibutuhkan suatu benda bergetar untuk melakukan satu getaran utuh disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'periode',
      ),
    ),
  ),
  73 => 
  array (
    'judul' => 'Ulangan Cermin, Lensa & Alat Optik SMP',
    'deskripsi' => 'Pembentukan bayangan cermin cekung cembung, cacat mata miopi hipermetropi SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 4,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sifat bayangan yang selalu dibentuk oleh cermin cembung pada spion kendaraan adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Nyata, tegak, diperbesar',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Maya, tegak, diperkecil',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Nyata, terbalik, diperkecil',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Maya, terbalik, sama besar',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Seseorang yang menderita cacat mata rabun jauh (miopi) dapat dibantu menggunakan kacamata berlensa cekung.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kaca pembesar sederhana yang menggunakan satu lensa cembung dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'lup',
      ),
    ),
  ),
  74 => 
  array (
    'judul' => 'Latihan Sistem Ekskresi Ginjal Manusia SMP',
    'deskripsi' => 'Filtrasi glomerulus, reabsorpsi tubulus, dan augmentasi pembentukan urine SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 4,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Tahap pertama pembentukan urine primer yang berlangsung di glomerulus ginjal dinamakan proses...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Filtrasi',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Reabsorpsi',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Augmentasi',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Sekresi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Unit fungsional penyaring darah terkecil di dalam organ ginjal disebut nefron.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Zat pewarna kuning khas urine dan feses yang dihasilkan dari perombakan hemoglobin hati disebut zat...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'bilirubin',
      ),
    ),
  ),
  75 => 
  array (
    'judul' => 'Tantangan Zat Aditif & Zat Adiktif Narkotika SMP',
    'deskripsi' => 'Pewarna pengawet alami sintetis dan bahaya ketergantungan psikotropika SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 4,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Zat aditif makanan yang digunakan sebagai penguat rasa sintetis yang populer adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Aspartam',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Monosodium glutamat (MSG)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Asam sitrat',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Tartrazin',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Nikotin dalam asap rokok bersifat adiktif dan menyebabkan ketergantungan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Zat kimia aktif yang terkandung dalam biji kopi dan daun teh penyegar adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'kafein',
      ),
    ),
  ),
  76 => 
  array (
    'judul' => 'Uji Bioteknologi Pangan Tradisional SMP',
    'deskripsi' => 'Fermentasi Saccharomyces, Rhizopus tempe, dan Lactobacillus yoghurt SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 4,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Mikroorganisme jamur yang berperan dalam pembuatan tempe dari biji kedelai adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Saccharomyces cerevisiae',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Rhizopus oryzae',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Lactobacillus bulgaricus',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Acetobacter xylinum',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pembuatan nata de coco memanfaatkan aktivitas bakteri Acetobacter xylinum.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Jamur ragi yang digunakan untuk fermentasi adonan roti agar mengembang adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'saccharomyces',
      ),
    ),
  ),
  77 => 
  array (
    'judul' => 'Kuis Dinamika Gerak & Hukum Newton Gerak SMA',
    'deskripsi' => 'Penerapan Hukum I, II, dan III Newton pada bidang miring dan katrol SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 4,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Berdasarkan Hukum II Newton, percepatan suatu benda bermassa m akibat gaya F dirumuskan dengan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'a = m / F',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'a = F / m',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'a = F . m',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'a = F + m',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Gaya aksi dan gaya reaksi menurut Hukum III Newton bekerja pada dua benda yang berbeda.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Sifat benda yang cenderung mempertahankan keadaan diam atau gerak lurus beraturannya disebut sifat...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'kelembaman',
      ),
    ),
  ),
  78 => 
  array (
    'judul' => 'Evaluasi Ikatan Kimia & Gaya Antarmolekul SMA',
    'deskripsi' => 'Ikatan ion, ikatan kovalen koordinasi, dan ikatan hidrogen SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 4,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Ikatan kimia yang terbentuk akibat serah terima elektron antara ion positif dan negatif disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Ikatan kovalen',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Ikatan ionik',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Ikatan logam',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Ikatan hidrogen',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Molekul air memiliki ikatan kovalen polar dan membentuk ikatan hidrogen antarmolekulnya.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Ikatan kovalen di mana pasangan elektron ikatan hanya berasal dari salah satu atom donor dinamakan ikatan kovalen...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'koordinasi',
      ),
    ),
  ),
  79 => 
  array (
    'judul' => 'Kuis Metabolisme Seluler & Fotosintesis SMA',
    'deskripsi' => 'Reaksi terang gelap fotosintesis dan siklus Krebs respirasi aerob SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 4,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Reaksi fotolisis air dan pembentukan ATP serta NADPH pada fotosintesis berlangsung di...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Stroma',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Tilakoid (grana)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Sitoplasma',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Mitokondria',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Tahap glikolisis respirasi aerob memecah glukosa menjadi dua molekul asam piruvat.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Tempat berlangsungnya Siklus Krebs di dalam organel sel adalah matriks...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'mitokondria',
      ),
    ),
  ),
  80 => 
  array (
    'judul' => 'Ulangan Gelombang Elektromagnetik & Foton SMA',
    'deskripsi' => 'Urutan spektrum gelombang elektromagnetik dan teori radiasi kuantum Planck SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 4,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Gelombang elektromagnetik yang memiliki energi foton dan frekuensi paling tinggi adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Gelombang radio',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Sinar-X',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Sinar gamma',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Gelombang mikro',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Cepat rambat semua gelombang elektromagnetik di ruang hampa bernilai sama dengan kecepatan cahaya.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Konstanta fisika kuantum yang menghubungkan energi foton dengan frekuensinya dinamakan konstanta...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'planck',
      ),
    ),
  ),
  81 => 
  array (
    'judul' => 'Latihan Larutan Asam Basa & Titrasi SMA',
    'deskripsi' => 'Teori Arrhenius, Bronsted-Lowry, indikator asam-basa, dan perhitungan pH SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 4,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Menurut teori Bronsted-Lowry, suatu zat bertindak sebagai basa apabila zat tersebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Melepas ion H+',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Menerima donor proton (H+)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Melepas ion OH-',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Menerima elektron bebas',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Larutan dengan nilai pH sama dengan 7 pada suhu kamar bersifat netral.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Indikator buatan fenolftalein (PP) akan berubah menjadi warna merah muda cerah dalam lingkungan larutan bersifat...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'basa',
      ),
    ),
  ),
  82 => 
  array (
    'judul' => 'Tantangan Genetika DNA & Transkripsi Protein SMA',
    'deskripsi' => 'Struktur heliks ganda DNA, kodon mRNA, tRNA, dan translasi ribosom SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 4,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Basa nitrogen pirimidin yang hanya ditemukan pada molekul RNA dan menggantikan Timin adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Adenin',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Guanin',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Urasil',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Sitosin',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Kodon start pembuka sintesis protein pada mRNA umumnya berkode AUG (metionin).',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Proses pembacaan kodon mRNA menjadi urutan asam amino di ribosom disebut proses...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'translasi',
      ),
    ),
  ),
  83 => 
  array (
    'judul' => 'Uji Termodinamika & Siklus Mesin Carnot SMA',
    'deskripsi' => 'Hukum ke-1 dan ke-2 termodinamika, efisiensi termal siklus Carnot SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 4,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Mesin kalor yang memiliki efisiensi teoretis tertinggi bekerja berdasarkan siklus ideal yang dinamakan siklus...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Rankine',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Diesel',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Otto',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Carnot',
            'is_correct' => true,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Hukum II Termodinamika menyatakan bahwa kalor tidak dapat mengalir secara spontan dari benda dingin ke panas.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Ukuran ketidakteraturan atau keacakan molekul dalam suatu sistem termodinamika disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'entropi',
      ),
    ),
  ),
  84 => 
  array (
    'judul' => 'Kuis Kenampakan Alam & Bentang Lahan SD',
    'deskripsi' => 'Mengenal dataran rendah, dataran tinggi, pantai, dan pemanfaatannya SD.',
    'id_jenjang' => 1,
    'id_mapel' => 5,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Wilayah daratan datar yang berada pada ketinggian lebih dari 600 meter di atas permukaan laut disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Dataran rendah',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Dataran tinggi (plato)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Lembah',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Tanjung',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Daerah pantai landai sering dimanfaatkan masyarakat sekitar untuk budidaya tambak garam dan pariwisata.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Daratan yang menjorok masuk ke perairan laut dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'tanjung',
      ),
    ),
  ),
  85 => 
  array (
    'judul' => 'Evaluasi Produksi, Distribusi & Konsumsi SD',
    'deskripsi' => 'Memahami rantai pelaku ekonomi produsen, distributor, dan konsumen SD.',
    'id_jenjang' => 1,
    'id_mapel' => 5,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pihak perantara yang bertugas menyalurkan barang dari pabrik ke toko ritel disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Produsen',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Distributor',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Konsumen',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Kolektor',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Tindakan memakai dan menghabiskan nilai guna suatu barang disebut kegiatan konsumsi.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Orang atau badan usaha yang menghasilkan barang dan jasa dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'produsen',
      ),
    ),
  ),
  86 => 
  array (
    'judul' => 'Kuis Keragaman Suku & Rumah Adat SD',
    'deskripsi' => 'Mengenal nama suku bangsa, tarian, dan rumah adat Nusantara SD.',
    'id_jenjang' => 1,
    'id_mapel' => 5,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Rumah adat Gadang yang memiliki atap runcing seperti tanduk kerbau berasal dari suku...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Minangkabau (Sumatera Barat)',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Dayak (Kalimantan)',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Asmat (Papua)',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Bugis (Sulawesi)',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Suku Badui merupakan suku asli yang mendiami wilayah pedalaman Provinsi Banten.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Rumah adat khas masyarakat Papua berbentuk bundar beratap jerami bernama rumah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'honai',
      ),
    ),
  ),
  87 => 
  array (
    'judul' => 'Ulangan Koperasi Sekolah & Asas Usaha SD',
    'deskripsi' => 'Mengenal fungsi koperasi, modal simpanan wajib, dan pembagian SHU SD.',
    'id_jenjang' => 1,
    'id_mapel' => 5,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Koperasi Indonesia didirikan dengan landasan utama berasaskan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Kapitalisme',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Kekeluargaan dan gotong royong',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Persaingan bebas',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Monopoli dagang',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Bapak Koperasi Indonesia adalah Wakil Presiden pertama Republik Indonesia, Mohammad Hatta.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Keuntungan bersih koperasi yang dibagikan kepada para anggotanya pada akhir tahun buku disingkat...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'shu',
      ),
    ),
  ),
  88 => 
  array (
    'judul' => 'Latihan Peninggalan Kerajaan Maritim SD',
    'deskripsi' => 'Mengenal kejayaan Kerajaan Sriwijaya, Majapahit, dan tokoh bersejarah SD.',
    'id_jenjang' => 1,
    'id_mapel' => 5,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kerajaan maritim Buddha terbesar di Nusantara yang berpusat di Palembang Sumatera Selatan adalah Kerajaan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Majapahit',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Sriwijaya',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Kutai',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Mataram Kuno',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Patih Gajah Mada mengucapkan Sumpah Palapa untuk menyatukan Nusantara di bawah Panji Majapahit.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pelabuhan dagang terkenal Kerajaan Majapahit di muara sungai Jawa Timur bernama pelabuhan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'ujung galuh',
      ),
    ),
  ),
  89 => 
  array (
    'judul' => 'Tantangan Peran Indonesia dalam ASEAN SD',
    'deskripsi' => 'Mengenal lima negara pemrakarsa ASEAN dan Deklarasi Bangkok SD.',
    'id_jenjang' => 1,
    'id_mapel' => 5,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Deklarasi pendirian organisasi perhimpunan bangsa-bangsa Asia Tenggara (ASEAN) pada 1967 ditandatangani di kota...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Jakarta',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Bangkok',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Manila',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Kuala Lumpur',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Tokoh wakil dari Indonesia yang menandatangani Deklarasi Bangkok adalah Adam Malik.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Gedung Sekretariat Tetap ASEAN berkedudukan di ibu kota negara...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'indonesia',
      ),
    ),
  ),
  90 => 
  array (
    'judul' => 'Uji Legenda Simbol & Arah Mata Angin SD',
    'deskripsi' => 'Membaca peta atlas, skala perbandingan, dan warna kontur tanah SD.',
    'id_jenjang' => 1,
    'id_mapel' => 5,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pada peta umum standar, warna biru tua digunakan untuk menggambarkan wilayah perairan berupa...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Dataran rendah',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Laut dalam',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Sungai dangkal',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Danau kecil',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Arah mata angin yang berada di antara utara dan timur adalah arah timur laut.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kolom daftar keterangan arti simbol-simbol yang terdapat pada peta disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'legenda',
      ),
    ),
  ),
  91 => 
  array (
    'judul' => 'Kuis Integrasi Ekonomi Negara ASEAN SMP',
    'deskripsi' => 'Kawasan AFTA, pilar MEA, dan komoditas unggulan perdagangan ASEAN SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 5,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kawasan perdagangan bebas antara negara-negara anggota ASEAN dikenal dengan singkatan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'NAFTA',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'AFTA',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'APEC',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'OPEC',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Masyarakat Ekonomi ASEAN (MEA) bertujuan mewujudkan arus bebas barang, jasa, dan tenaga kerja terampil.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pabrik pupuk urea bersama proyek industri ASEAN didirikan di wilayah negara...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'indonesia',
      ),
    ),
  ),
  92 => 
  array (
    'judul' => 'Evaluasi Hukum Permintaan & Penawaran SMP',
    'deskripsi' => 'Kurva elastisitas harga, pergeseran ekuilibrium, dan faktor pembentuk harga SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 5,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Bunyi hukum penawaran menyatakan bahwa apabila tingkat harga suatu barang mengalami kenaikan, maka...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Jumlah barang yang ditawarkan bertambah',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Jumlah barang yang diminta bertambah',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Jumlah barang yang ditawarkan berkurang',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Penjualan barang terhenti',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Titik perpotongan antara kurva permintaan dan kurva penawaran menghasilkan harga pasar keseimbangan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kondisi di mana faktor-faktor penentu selain harga dianggap tidak berubah dinamakan kondisi ceteris...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'paribus',
      ),
    ),
  ),
  93 => 
  array (
    'judul' => 'Kuis Dinamika Kependudukan Indonesia SMP',
    'deskripsi' => 'Piramida penduduk ekspansif, angka ketergantungan, dan bonus demografi SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 5,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Fenomena kependudukan di mana jumlah penduduk usia produktif (15-64 tahun) lebih banyak dibanding usia non-produktif disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Ledakan penduduk',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Bonus demografi',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Transisi demografi',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Piramida stasioner',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Program transmigrasi bertujuan memeratakan persebaran penduduk ke pulau yang masih berpenduduk jarang.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Perhitungan sensus yang hanya mencatat penduduk yang secara resmi terdaftar ber-KTP di daerah sensus disebut de...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'jure',
      ),
    ),
  ),
  94 => 
  array (
    'judul' => 'Ulangan Lempeng Tektonik & Geologi Indonesia SMP',
    'deskripsi' => 'Pertemuan lempeng Indo-Australia, Eurasia, dan Pasifik serta Ring of Fire SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 5,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Lempeng benua yang berada di bagian barat wilayah kepulauan Indonesia adalah Lempeng...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Pasifik',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Eurasia',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Indo-Australia',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Filipina',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pertemuan dua lempeng kerak bumi yang saling bertabrakan satu sama lain disebut batas lempeng konvergen.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Rangkaian sabuk pegunungan dan gunung berapi aktif di sekeliling Samudra Pasifik disebut Sirkum Pasifik atau Ring of...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'fire',
      ),
    ),
  ),
  95 => 
  array (
    'judul' => 'Latihan Perdagangan Internasional & Valuta SMP',
    'deskripsi' => 'Kebijakan proteksi kuota impor, subsidi ekspor, dan kurs valuta asing SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 5,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kebijakan pemerintah menjual barang di pasar luar negeri dengan harga lebih murah daripada pasar dalam negeri disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Tarif bea masuk',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Dumping',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Proteksionisme',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Embargo',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Devisa merupakan saldo kekayaan moneter luar negeri yang sah digunakan dalam transaksi pembayaran internasional.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Mata uang resmi gabungan yang digunakan oleh mayoritas negara anggota Uni Eropa adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'euro',
      ),
    ),
  ),
  96 => 
  array (
    'judul' => 'Tantangan Perubahan Sosial & Modernisasi SMP',
    'deskripsi' => 'Faktor pendorong penemuan baru, difusi budaya, dan perlawanan perubahan SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 5,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Penyebaran unsur-unsur kebudayaan baru dari satu kelompok masyarakat ke kelompok lain dinamakan proses...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Akulturasi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Difusi',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Asimilasi',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Inovasi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Modernisasi tidak berarti harus meninggalkan nilai luhur kepribadian budaya bangsa.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kesenjangan antara kemajuan teknologi material dengan kesiapan mental nilai norma dinamakan cultural...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'lag',
      ),
    ),
  ),
  97 => 
  array (
    'judul' => 'Uji Lembaga Sosial Kemasyarakatan SMP',
    'deskripsi' => 'Peran fungsi afeksi keluarga, lembaga agama, politik, dan perlindungan SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 5,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Lembaga sosial pertama yang berfungsi memberikan kasih sayang, perlindungan, dan sosialisasi primer adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Lembaga sekolah',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Lembaga keluarga',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Lembaga hukum',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Lembaga ekonomi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Lembaga pendidikan formal bertugas menanamkan ilmu pengetahuan dan keterampilan hidup (life skills).',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Lembaga yang mengatur tata tertib pelaksanaan wewenang pemerintahan negara disebut lembaga...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'politik',
      ),
    ),
  ),
  98 => 
  array (
    'judul' => 'Kuis Globalisasi & Dampak Sosial SMA',
    'deskripsi' => 'Dinamika pasar bebas dunia, konsumerisme, dan identitas kebudayaan SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 5,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Fenomena penyeragaman pola hidup, konsumsi, dan hiburan masyarakat dunia akibat globalisasi disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Heterogenisasi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Homogenisasi kultural',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Aglomerasi',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Degenerasi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Globalisasi membawa dampak positif dalam kecepatan transfer teknologi dan ilmu pengetahuan lintas negara.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Strategi mengadaptasi produk global agar cocok dengan selera kearifan lokal dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'glokalisasi',
      ),
    ),
  ),
  99 => 
  array (
    'judul' => 'Evaluasi Indeks Pembangunan Manusia (IPM) SMA',
    'deskripsi' => 'Metode perhitungan IPM: angka harapan hidup, harapan lama sekolah, pengeluaran SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 5,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Tiga dimensi dasar tolok ukur penentuan Indeks Pembangunan Manusia (IPM) menurut UNDP adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Militer, politik, hukum',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Kesehatan, pendidikan, dan standar hidup layak',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Luas lahan, hutan, populasi',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Industri, ekspor, perbankan',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Semakin mendekati angka 100 nilai indeks IPM suatu wilayah, semakin tinggi kualitas hidup masyarakatnya.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Lembaga organisasi pembangunan internasional di bawah naungan PBB disingkat...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'undp',
      ),
    ),
  ),
  100 => 
  array (
    'judul' => 'Kuis Pendapatan Nasional & Indeks Gini SMA',
    'deskripsi' => 'Perhitungan PDB, PNB, pendapatan disposabel, dan kurva Lorenz SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 5,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Nilai pasar seluruh barang dan jasa akhir yang dihasilkan di dalam batas wilayah suatu negara selama satu tahun disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'GNP',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'GDP (PDB)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'NNP',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Personal Income',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Koefisien Gini bernilai antara 0 (pemerataan sempurna) hingga 1 (ketimpangan absolut).',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kurva grafis yang menggambarkan distribusi persentase pendapatan nasional penduduk dinamakan Kurva...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'lorenz',
      ),
    ),
  ),
  101 => 
  array (
    'judul' => 'Ulangan Sistem Informasi Geografis Terapan SMA',
    'deskripsi' => 'Komponen perangkat keras, perangkat lunak, data vektor dan raster SIG SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 5,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Format penyajian data spasial SIG yang tersusun atas sel-sel bujur sangkar (piksel matriks) adalah format...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Vektor garis',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Raster',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Poligon poligon',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Tabel atribut',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Teknik penginderaan jauh (remote sensing) memungkinkan perekaman permukaan bumi tanpa kontak langsung.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Data SIG yang memberikan deskripsi keterangan rinci mengenai identitas suatu objek spasial dinamakan data...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'atribut',
      ),
    ),
  ),
  102 => 
  array (
    'judul' => 'Latihan Diferensiasi & Stratifikasi Vertikal SMA',
    'deskripsi' => 'Kriteria penentu kelas sosial, kekuasaan, privilese, dan prestise SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 5,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sistem pelapisan sosial tertutup yang tidak memungkinkan individu berpindah kedudukan kasta terdapat pada masyarakat...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Demokratis modern',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Kasta tradisional',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Industri perkotaan',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Meritokrasi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Diferensiasi sosial membedakan kelompok masyarakat secara horizontal tanpa tingkatan hierarki.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kenaikan status sosial seseorang dari lapisan bawah ke lapisan yang lebih tinggi disebut mobilitas vertikal...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'naik',
      ),
    ),
  ),
  103 => 
  array (
    'judul' => 'Tantangan Lembaga Finansial & Pasar Modal SMA',
    'deskripsi' => 'Fungsi Bursa Efek Indonesia, reksa dana, instrumen saham dan obligasi SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 5,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Surat bukti kepemilikan atas modal suatu perseroan terbatas yang diperdagangkan di bursa efek disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Obligasi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Saham',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Cek tunai',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Bilyet giro',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Otoritas Jasa Keuangan (OJK) bertugas mengawasi industri perbankan, pasar modal, dan asuransi di Indonesia.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Surat berharga bukti utang jangka panjang dari penerbit kepada pemegang obligasi disebut surat...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'obligasi',
      ),
    ),
  ),
  104 => 
  array (
    'judul' => 'Uji Interaksi Spasial Hubungan Desa-Kota SMA',
    'deskripsi' => 'Model gravitasi Reilly, konektivitas Kansky, dan dampak perambatan wilayah SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 5,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Menurut Teori Gravitasi W.J. Reilly, kekuatan interaksi antar dua wilayah berbanding terbalik dengan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Jumlah penduduk',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Kuadrat jarak antara kedua wilayah',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Luas wilayah gabungan',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Jumlah kendaraan melintas',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Zona peralihan antara peruntukan lahan perkotaan dan perdesaan di pinggiran kota disebut zona sub-urban fringe.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Perpindahan penduduk dari kawasan perdesaan menuju wilayah perkotaan besar disebut arus...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'urbanisasi',
      ),
    ),
  ),
  105 => 
  array (
    'judul' => 'Kuis Simbol Sila-Sila Pancasila SD',
    'deskripsi' => 'Mengenal lambang Garuda, lima simbol perisai, dan urutan sila Pancasila SD.',
    'id_jenjang' => 1,
    'id_mapel' => 6,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Simbol perisai pada Garuda Pancasila yang melambangkan sila pertama adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Rantai emas',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Bintang emas bersudut lima',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Pohon beringin',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Kepala banteng',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Sila kedua Pancasila berbunyi "Kemanusiaan yang adil dan beradab".',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Simbol sila kelima Keadilan Sosial bagi Seluruh Rakyat Indonesia adalah padi dan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'kapas',
      ),
    ),
  ),
  106 => 
  array (
    'judul' => 'Evaluasi Hak & Kewajiban di Sekolah SD',
    'deskripsi' => 'Membedakan hak memperoleh ilmu dan kewajiban menaati tata tertib kelas SD.',
    'id_jenjang' => 1,
    'id_mapel' => 6,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Mendapatkan pengajaran yang baik dari bapak dan ibu guru di sekolah merupakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Kewajiban siswa',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Hak asasi siswa',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Tugas guru saja',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Beban belajar',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Menjaga kebersihan dan ketertiban lingkungan kelas adalah kewajiban seluruh warga sekolah.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pelaksanaan antara hak dan kewajiban harus berjalan secara...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'seimbang',
      ),
    ),
  ),
  107 => 
  array (
    'judul' => 'Kuis Musyawarah di Lingkungan Rumah SD',
    'deskripsi' => 'Pengambilan keputusan bersama di lingkungan RT, RW, dan keluarga SD.',
    'id_jenjang' => 1,
    'id_mapel' => 6,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sikap yang baik ketika pendapat kita tidak disetujui dalam musyawarah adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Marah dan keluar ruangan',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Menerima keputusan mufakat dengan lapang dada',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Memaksakan kehendak',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Mengejek pendapat orang lain',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Musyawarah mufakat merupakan cerminan pengamalan sila keempat Pancasila.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kegiatan berunding bersama untuk memecahkan suatu masalah dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'musyawarah',
      ),
    ),
  ),
  108 => 
  array (
    'judul' => 'Ulangan Arti Semboyan Bhinneka Tunggal Ika SD',
    'deskripsi' => 'Sejarah semboyan kitab Sutasoma, makna pita Garuda, dan toleransi warga SD.',
    'id_jenjang' => 1,
    'id_mapel' => 6,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Arti dari semboyan luhur bangsa "Bhinneka Tunggal Ika" adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Berbeda-beda tetapi tetap satu jua',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Bersatu kita teguh bercerai runtuh',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Maju tak gentar membela yang benar',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Satu nusa satu bangsa satu bahasa',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Semboyan Bhinneka Tunggal Ika tertulis pada pita yang dicengkeram kedua kaki burung Garuda.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kitab kuno karangan Mpu Tantular tempat semboyan Bhinneka Tunggal Ika ditemukan adalah Kitab...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'sutasoma',
      ),
    ),
  ),
  109 => 
  array (
    'judul' => 'Latihan Norma & Aturan Keseharian SD',
    'deskripsi' => 'Mengenal norma kesopanan, kesusilaan, agama, dan hukum di lingkungan SD.',
    'id_jenjang' => 1,
    'id_mapel' => 6,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Mencium tangan orang tua saat berpamitan berangkat ke sekolah merupakan wujud norma...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Hukum formal',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Kesopanan',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Peraturan tertulis',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Hukum internasional',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Norma kesusilaan bersumber dari hati nurani manusia.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Sanksi bagi pelanggar norma hukum positif di negara kita bersifat tegas dan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'mengikat',
      ),
    ),
  ),
  110 => 
  array (
    'judul' => 'Tantangan Gotong Royong & Kerja Bakti SD',
    'deskripsi' => 'Nilai kebersamaan gotong royong membersihkan selokan dan pos kamling SD.',
    'id_jenjang' => 1,
    'id_mapel' => 6,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Manfaat utama dari kegiatan gotong royong membersihkan lingkungan kampung adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Membuat warga saling bersaing',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Pekerjaan berat menjadi ringan dan cepat selesai',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Menghabiskan waktu luang',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Mendapatkan pujian pamong',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Gotong royong merupakan warisan tradisi luhur yang mempererat kerukunan bangsa.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Tradisi tolong-menolong khas suku bangsa Indonesia yang dilakukan tanpa upah disebut gotong...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'royong',
      ),
    ),
  ),
  111 => 
  array (
    'judul' => 'Uji Cinta Produk Buatan Indonesia SD',
    'deskripsi' => 'Mendukung pengrajin batik lokal, kuliner khas daerah, dan bangga ber-Indonesia SD.',
    'id_jenjang' => 1,
    'id_mapel' => 6,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Salah satu sikap nyata mencintai tanah air dan bangsa di lingkungan sekolah adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Lebih memilih barang impor mahal',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Bangga memakai sepatu dan tas buatan pengrajin lokal',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Mengejek tarian daerah',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Hanya mau berbahasa asing',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Menggunakan produk dalam negeri membantu membuka lapangan kerja bagi masyarakat kita sendiri.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pakaian tradisional khas Indonesia yang telah diakui UNESCO sebagai warisan budaya dunia adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'batik',
      ),
    ),
  ),
  112 => 
  array (
    'judul' => 'Kuis Perumusan UUD NRI Tahun 1945 SMP',
    'deskripsi' => 'Sidang BPUPKI, penetapan PPKI 18 Agustus 1945, dan isi naskah pembukaan SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 6,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Undang-Undang Dasar Negara Republik Indonesia Tahun 1945 secara resmi disahkan oleh...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'BPUPKI',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'PPKI',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'KNIP',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'DPR GR',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pembukaan UUD NRI Tahun 1945 memuat tujuan nasional bangsa pada alinea keempat.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Lembaga penyelidik persiapan kemerdekaan yang dibentuk pada 1 Maret 1945 adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'bpupki',
      ),
    ),
  ),
  113 => 
  array (
    'judul' => 'Evaluasi Tata Urutan Peraturan Perundangan SMP',
    'deskripsi' => 'Hierarki UU No. 12 Tahun 2011: UUD, Tap MPR, UU/Perppu, PP, Perpres, Perda SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 6,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Peraturan perundang-undangan tertinggi dalam tata urutan hukum nasional Indonesia adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Undang-Undang',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'UUD 1945',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Peraturan Pemerintah',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Ketetapan MPR',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Peraturan daerah (Perda) tidak boleh bertentangan dengan peraturan perundang-undangan yang lebih tinggi derajatnya.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Undang-Undang dibuat dan disahkan oleh DPR bersama dengan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'presiden',
      ),
    ),
  ),
  114 => 
  array (
    'judul' => 'Kuis Semangat Kebangkitan Nasional 1908 SMP',
    'deskripsi' => 'Kiprah dr. Soetomo, STOVIA, gagasan dana belajar Wahidin Sudirohusodo SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 6,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Hari Kebangkitan Nasional yang diperingati setiap tanggal 20 Mei merujuk pada peristiwa berdirinya...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Sarekat Islam',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Organisasi Budi Utomo',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Indische Partij',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Perhimpunan Indonesia',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Budi Utomo didirikan oleh para pemuda pelajar kedokteran STOVIA di Batavia.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Tokoh penggagas perlunya dana pendidikan (studiefonds) untuk pemuda pribumi adalah dr. Wahidin...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'sudirohusodo',
      ),
    ),
  ),
  115 => 
  array (
    'judul' => 'Ulangan Sumpah Pemuda 1928 & Ikrar Bangsa SMP',
    'deskripsi' => 'Kongres Pemuda I dan II, ikrar tiga butir, dan pengibaran Merah Putih SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 6,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Ikrar putusan Kongres Pemuda II pada 28 Oktober 1928 menetapkan bahasa persatuan adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Bahasa Melayu pasar',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Bahasa Jawa krama',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Bahasa Indonesia',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Bahasa daerah masing-masing',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Lagu Indonesia Raya pertama kali dikumandangkan secara instrumental pada Kongres Pemuda II.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Ketua Kongres Pemuda II yang memimpin lahirnya ikrar Sumpah Pemuda adalah Sugondo...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'djojopuspito',
      ),
    ),
  ),
  116 => 
  array (
    'judul' => 'Latihan Semangat Bela Negara & Patriotisme SMP',
    'deskripsi' => 'Pasal 27 ayat 3, Pasal 30 ayat 1, komponen utama dan pendukung pertahanan SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 6,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pasal dalam UUD 1945 yang menegaskan bahwa setiap warga negara berhak dan wajib ikut serta dalam upaya pembelaan negara adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Pasal 27 ayat 1',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Pasal 27 ayat 3',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Pasal 29 ayat 2',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Pasal 33 ayat 1',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Sistem pertahanan keamanan di Indonesia menggunakan konsep Sistem Pertahanan Keamanan Rakyat Semesta (Sishankamrata).',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kekuatan utama dalam sistem pertahanan negara menghadapi ancaman bersenjata adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'tni',
      ),
    ),
  ),
  117 => 
  array (
    'judul' => 'Tantangan Harmoni Keberagaman Suku & Agama SMP',
    'deskripsi' => 'Menghindari etnosentrisme, stereotip primordial, dan merawat toleransi SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 6,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sikap berlebihan yang menganggap kebudayaan atau suku bangsanya sendiri paling unggul dibanding yang lain dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Chauvinisme',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Etnosentrisme',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Primordialisme',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Nasionalisme',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Sikap toleransi antarumat beragama diwujudkan dengan tidak memaksakan agama kepada orang lain.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Singkatan dari isu suku, agama, ras, dan antargolongan yang rawan memicu konflik adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'sara',
      ),
    ),
  ),
  118 => 
  array (
    'judul' => 'Uji Otonomi Daerah dalam Bingkai NKRI SMP',
    'deskripsi' => 'Desentralisasi, dekonsentrasi, tugas pembantuan, dan keutuhan wilayah SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 6,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pelimpahan wewenang pemerintahan oleh pemerintah pusat kepada daerah otonom untuk mengatur dan mengurus urusan daerahnya disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Sentralisasi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Desentralisasi',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Dekonsentrasi',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Tugas pembantuan',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Negara Kesatuan Republik Indonesia menganut bentuk negara kesatuan dengan prinsip desentralisasi.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kepala daerah yang memimpin jalannya pemerintahan pada tingkat kabupaten adalah seorang...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'bupati',
      ),
    ),
  ),
  119 => 
  array (
    'judul' => 'Kuis Nilai Pancasila Penyelenggaraan Negara SMA',
    'deskripsi' => 'Kekuasaan konstitutif, eksekutif, legislatif, yudikatif, dan eksaminatif SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 6,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Lembaga tinggi negara yang memegang kekuasaan eksaminatif atau inspektif memeriksa pengelolaan keuangan negara adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'KPK',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'BPK',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Bank Indonesia',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Kementerian Keuangan',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Kekuasaan yudikatif menegakkan hukum dan keadilan dijalankan oleh Mahkamah Agung dan Mahkamah Konstitusi.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Lembaga negara yang berwenang mengubah dan menetapkan Undang-Undang Dasar adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'mpr',
      ),
    ),
  ),
  120 => 
  array (
    'judul' => 'Evaluasi Penegakan Hak Asasi Manusia (HAM) SMA',
    'deskripsi' => 'Instrumen UU No. 39/1999, Komnas HAM, pelanggaran HAM berat peradilan HAM SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 6,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kejahatan terhadap kemanusiaan dan kejahatan genosida menurut UU No. 26 Tahun 2000 dikategorikan sebagai...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Pelanggaran hukum pidana ringan',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Pelanggaran HAM berat',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Tindak pidana perdata biasa',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Pelanggaran tata tertib',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Hak untuk hidup, hak tidak disiksa, dan hak kebebasan beragama tergolong non-derogable rights (tidak dapat dikurangi dalam situasi apapun).',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Lembaga mandiri negara yang dibentuk untuk memajukan dan menegakkan perlindungan HAM di Indonesia adalah Komnas...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'ham',
      ),
    ),
  ),
  121 => 
  array (
    'judul' => 'Kuis Sistem Hukum & Mahkamah Konstitusi SMA',
    'deskripsi' => 'Kewenangan MK uji materi UU, sengketa kewenangan lembaga negara, bubarkan parpol SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 6,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kewenangan menguji materi undang-undang terhadap Undang-Undang Dasar 1945 berada di bawah yurisdiksi...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Mahkamah Agung',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Mahkamah Konstitusi',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Komisi Yudisial',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Kejaksaan Agung',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Asas presumption of innocence menyatakan setiap orang dianggap tidak bersalah sebelum ada putusan hakim berkekuatan hukum tetap.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Lembaga yudikatif yang bertugas mengusulkan pengangkatan Hakim Agung dan menjaga integritas hakim adalah Komisi...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'yudisial',
      ),
    ),
  ),
  122 => 
  array (
    'judul' => 'Ulangan Pengaruh Kemajuan Iptek terhadap NKRI SMA',
    'deskripsi' => 'Tantangan era digital, keterbukaan informasi, keamanan siber, dan UU ITE SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 6,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Dampak negatif kemajuan teknologi informasi pada aspek budaya bangsa antara lain berkembangnya sikap...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Gotong royong',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Konsumerisme dan hedonisme',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Cinta produk lokal',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Kemandirian berpikir',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Penyebaran ujaran kebencian bermuatan SARA di media sosial dapat dipidana sesuai regulasi UU ITE.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Penerapan teknologi digital dalam penyelenggaraan pelayanan birokrasi pemerintahan disebut e-...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'government',
      ),
    ),
  ),
  123 => 
  array (
    'judul' => 'Latihan Geopolitik & Wawasan Nusantara SMA',
    'deskripsi' => 'Deklarasi Djuanda 1957, konsep laut nusantara, ZEE 200 mil laut SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 6,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Deklarasi bersejarah yang menyatakan bahwa perairan di antara pulau-pulau Nusantara adalah satu kesatuan utuh wilayah RI adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Deklarasi Bangkok',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Deklarasi Djuanda',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Deklarasi Linggarjati',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Deklarasi Bogor',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Lebar laut teritorial Republik Indonesia ditarik sejauh 12 mil laut dari garis pangkal pulau-pulau terluar.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Zona laut di mana suatu negara berdaulat penuh atas eksplorasi sumber daya alam hingga 200 mil laut dinamakan Zona Ekonomi...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'eksklusif',
      ),
    ),
  ),
  124 => 
  array (
    'judul' => 'Tantangan Demokrasi Pancasila & Pemilu Bersih SMA',
    'deskripsi' => 'Asas Luber Jurdil, pengawasan Bawaslu, partisipasi politik beradab SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 6,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Asas pelaksanaan pemilihan umum di Indonesia yang menjamin pemilih tidak boleh diwakilkan atau dipaksa adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Langsung dan Bebas',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Terbuka dan Tertutup',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Terbatas dan Terpadu',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Birokratis',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Badan Pengawas Pemilu (Bawaslu) bertugas mengawasi seluruh tahapan penyelenggaraan pemilu dari potensi kecurangan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Asas pemilu yang menjamin setiap suara pemilih dihitung secara jujur dan adil disingkat...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'jurdil',
      ),
    ),
  ),
  125 => 
  array (
    'judul' => 'Uji Politik Luar Negeri Bebas Aktif SMA',
    'deskripsi' => 'Dasasila Bandung, keikutsertaan Gerakan Non-Blok, misi perdamaian Garuda SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 6,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Prinsip dasar politik luar negeri Republik Indonesia yang dirumuskan oleh Drs. Mohammad Hatta dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Netral pasif',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Bebas dan aktif',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Isolasionis',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Agresif diplomatis',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pasukan pemelihara perdamaian Indonesia yang dikirim bertugas di bawah mandat Dewan Keamanan PBB bernama Kontingen Garuda.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pemberian suaka politik dan kekebalan hukum bagi perwakilan diplomatik negara sahabat dinamakan hak eksteritorialitas atau kekebalan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'diplomatik',
      ),
    ),
  ),
  126 => 
  array (
    'judul' => 'Kuis Perilaku Jujur & Amanah SD',
    'deskripsi' => 'Menanamkan kejujuran tidak menyontek dan memelihara barang titipan teman SD.',
    'id_jenjang' => 1,
    'id_mapel' => 7,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Contoh nyata perilaku jujur seorang siswa saat di ruang kelas adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Menyontek jawaban teman',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Mengerjakan ulangan mandiri dengan kemampuan sendiri',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Menyembunyikan buku perpustakaan',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Beralasan palsu saat terlambat',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Sifat amanah artinya seseorang dapat dipercaya memegang tanggung jawab yang diberikan kepadanya.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Perilaku selalu berkata benar sesuai dengan kenyataan sebenarnya dinamakan sikap...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'jujur',
      ),
    ),
  ),
  127 => 
  array (
    'judul' => 'Evaluasi Hormat pada Orang Tua & Guru SD',
    'deskripsi' => 'Adab santun berbicara pada orang tua dan mendengarkan penjelasan guru SD.',
    'id_jenjang' => 1,
    'id_mapel' => 7,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sikap berbakti dan patuh terhadap perintah baik kedua orang tua dalam ajaran agama disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Takabur',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Birrul walidain',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Riya',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Ujub',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Mendoakan kebaikan bagi kedua orang tua adalah kewajiban seorang anak yang saleh.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Memotong pembicaraan orang tua dengan suara keras dan membentak merupakan perbuatan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'tercela',
      ),
    ),
  ),
  128 => 
  array (
    'judul' => 'Kuis Gemar Sedekah & Peduli Sahabat SD',
    'deskripsi' => 'Menolong teman yang terjatuh, berbagi bekal, dan keutamaan bersedekah SD.',
    'id_jenjang' => 1,
    'id_mapel' => 7,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Memberikan sebagian rezeki kepada orang miskin yang membutuhkan semata-mata mengharap ridha Tuhan disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Riya',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Sedekah yang ikhlas',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Pamer kemewahan',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Meminta imbalan jasa',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Bersedekah dengan senyuman tulus kepada sesama bernilai kebaikan di mata Tuhan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Membantu orang lain tanpa mengharapkan pujian dan balasan manusia dinamakan sikap yang...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'ikhlas',
      ),
    ),
  ),
  129 => 
  array (
    'judul' => 'Ulangan Kebersihan Diri & Tempat Ibadah SD',
    'deskripsi' => 'Menjaga wudu/kebersihan sebelum ibadah, merawat kebersihan toilet SD.',
    'id_jenjang' => 1,
    'id_mapel' => 7,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Ajaran agama menekankan bahwa kesucian dan kebersihan merupakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Beban yang berat',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Sebagian dari iman',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Tradisi sekunder',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Aturan khusus orang dewasa',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Bersuci menggunakan air bersih yang suci dan menyucikan sebelum beribadah adalah syarat sah ibadah.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Membersihkan hadas kecil dilakukan dengan cara berwudu atau...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'tayamum',
      ),
    ),
  ),
  130 => 
  array (
    'judul' => 'Latihan Adab Makan, Minum & Berbicara SD',
    'deskripsi' => 'Membaca doa sebelum makan, menggunakan tangan kanan, tutur kata lembut SD.',
    'id_jenjang' => 1,
    'id_mapel' => 7,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Adab santun ketika menikmati makanan dan minuman sesuai tuntunan budi pekerti adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Makan sambil berlari',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Membaca doa dan makan dengan tertib sambil duduk',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Berbicara dengan mulut penuh makanan',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Mencela hidangan',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Mengucapkan kata "tolong" saat meminta bantuan dan "terima kasih" setelah dibantu adalah adab terpuji.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Sebelum menyantap makanan, kita dianjurkan untuk membaca...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'doa',
      ),
    ),
  ),
  131 => 
  array (
    'judul' => 'Tantangan Kerukunan Hidup Umat Beragama SD',
    'deskripsi' => 'Menghormati teman yang sedang beribadah dan merawat persahabatan beragam SD.',
    'id_jenjang' => 1,
    'id_mapel' => 7,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sikap kita ketika melihat teman sekelas sedang menjalankan ibadah sesuai agamanya adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Mengganggunya',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Menghormatinya dan tidak berisik',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Melarangnya beribadah',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Mengejek tata caranya',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Menjaga kerukunan antarumat beragama adalah kunci kedamaian hidup bersama dalam masyarakat.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Sikap saling menghormati dan menghargai perbedaan keyakinan orang lain dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'toleransi',
      ),
    ),
  ),
  132 => 
  array (
    'judul' => 'Uji Pribadi Pemaaf & Mengendalikan Amarah SD',
    'deskripsi' => 'Menahan rasa marah, segera meminta maaf bila khilaf, berjiwa lapang SD.',
    'id_jenjang' => 1,
    'id_mapel' => 7,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Orang yang paling kuat bukanlah orang yang jago berkelahi, melainkan orang yang sanggup...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Mengalahkan musuhnya',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Menahan amarahnya saat emosi',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Membalas dendam',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Menghina kelemahan orang lain',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Memberi maaf kepada teman yang sudah mengakui kesalahannya dengan tulus merupakan sifat mulia.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Orang yang mudah memaafkan kesalahan orang lain disebut memiliki sifat...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'pemaaf',
      ),
    ),
  ),
  133 => 
  array (
    'judul' => 'Kuis Teladan Sifat Wajib Rasul SMP',
    'deskripsi' => 'Sifat Siddiq (benar), Amanah (terpercaya), Tabligh (menyampaikan), Fathanah (cerdas) SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 7,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sifat wajib bagi para nabi dan rasul yang bermakna cerdas dan bijaksana adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Siddiq',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Fathanah',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Amanah',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Tabligh',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Sifat Tabligh memiliki arti menyampaikan segala wahyu kebenaran tanpa ada yang disembunyikan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Sifat wajib bagi rasul yang bermakna selalu benar dan jujur dalam perkataan maupun perbuatan adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'siddiq',
      ),
    ),
  ),
  134 => 
  array (
    'judul' => 'Evaluasi Menghindari Gibah & Fitnah SMP',
    'deskripsi' => 'Bahaya membicarakan aib sesama, tabayyun klarifikasi berita, menjauhi hoaks SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 7,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Perbuatan membicarakan keburukan atau kejelekan orang lain di belakangnya dinamakan perbuatan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Namimah',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Gibah',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Riya',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Kufur',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Klarifikasi atau memeriksa kebenaran suatu berita sebelum menyebarkannya dikenal dengan istilah tabayyun.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Menyampaikan perkataan bohong tanpa bukti untuk menjatuhkan kehormatan seseorang disebut perbuatan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'fitnah',
      ),
    ),
  ),
  135 => 
  array (
    'judul' => 'Kuis Tata Bersuci Hadas & Shalat Jamaah SMP',
    'deskripsi' => 'Mandi wajib hadas besar, syarat sah shalat fardu berjamaah 27 derajat SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 7,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pahala menunaikan ibadah shalat secara berjamaah dibandingkan shalat sendirian adalah berlipat...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '10 derajat',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '27 derajat',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '50 derajat',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '100 derajat',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Bersuci dari hadas besar seperti mimpi basah atau selesai haid dilakukan dengan mandi wajib.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Orang yang memimpin jalannya ibadah shalat berjamaah dinamakan seorang...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'imam',
      ),
    ),
  ),
  136 => 
  array (
    'judul' => 'Ulangan Adab Menuntut Ilmu & Menghormati Guru SMP',
    'deskripsi' => 'Keutamaan mencari ilmu, rendah hati pada ulama guru, dan mengamalkan ilmu SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 7,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kewajiban menuntut ilmu dalam ajaran budi pekerti agama berlaku bagi...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Hanya anak-anak',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Setiap insan manusia sejak buaian hingga liang lahad',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Kaum cendekiawan saja',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Orang yang berkecukupan saja',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Sikap tawadhu (rendah hati) di hadapan guru mempermudah penyerapan ilmu yang berkah.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Sikap rendah hati dan tidak menyombongkan kepandaian diri sendiri dinamakan sikap...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'tawadhu',
      ),
    ),
  ),
  137 => 
  array (
    'judul' => 'Latihan Karakter Qanaah & Syukur Nikmat SMP',
    'deskripsi' => 'Merasa cukup atas rezeki halal, menjauhi hasad dengki, bersyukur sehari-hari SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 7,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sikap rela dan merasa cukup atas apa yang telah dianugerahkan Tuhan dari rezeki yang halal dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Tawakal',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Qana\'ah',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Ikhtiar',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Sabar',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Sifat hasad atau dengki adalah perasaan tidak suka melihat orang lain mendapatkan nikmat kebaikan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Ungkapan rasa terima kasih dan pengakuan atas nikmat pemberian Tuhan dinamakan bersikap...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'syukur',
      ),
    ),
  ),
  138 => 
  array (
    'judul' => 'Tantangan Moderasi Beragama dalam Bangsa SMP',
    'deskripsi' => 'Wasathiyah (jalan tengah), menolak radikalisme kekerasan, Piagam Madinah SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 7,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sikap beragama yang berada di tengah-tengah, adil, tidak ekstrem dan tidak berlebihan dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Fanatisme',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Moderasi beragama (wasathiyah)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Sekularisme',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Sinkretisme',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Piagam Madinah merupakan teladan sejarah perlindungan hukum hak beragama bagi seluruh suku dan keyakinan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Sikap fanatik berlebihan yang memaksakan kehendak dan menolak dialog damai disebut sikap...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'intoleran',
      ),
    ),
  ),
  139 => 
  array (
    'judul' => 'Uji Rukun Zakat Fitrah & Zakat Mal SMP',
    'deskripsi' => 'Syarat nisab haul zakat emas perdagangan, 8 asnaf golongan mustahik zakat SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 7,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Batas minimal jumlah kepemilikan harta kekayaan yang mewajibkan seseorang membayar zakat mal disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Haul',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Nisab',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Muzakki',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Kifarat',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Zakat fitrah wajib dibayarkan sebelum pelaksanaan shalat Idul Fitri dimulai.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Sebutan bagi orang yang berhak menerima penyaluran zakat adalah golongan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'mustahik',
      ),
    ),
  ),
  140 => 
  array (
    'judul' => 'Kuis Syariat Pernikahan & Keluarga Sakinah SMA',
    'deskripsi' => 'Rukun nikah saksi wali mahar ijab kabul, sakinah mawaddah rahmah SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 7,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pernyataan penyerahan dari pihak wali pengantin wanita dan penerimaan oleh mempelai pria dalam akad nikah disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Khitan',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Ijab dan kabul',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Walimah',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Talaq',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Tujuan pernikahan yang sah adalah membangun ikatan keluarga yang sakinah, mawaddah, dan rahmah.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pemberian wajib berupa harta atau benda dari pihak pria kepada wanita saat pernikahan disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'mahar',
      ),
    ),
  ),
  141 => 
  array (
    'judul' => 'Evaluasi Hukum Kewarisan Faraidh SMA',
    'deskripsi' => 'Prinsip keadilan waris, wasiat sepertiga, hak ashabah dan dzawil furudh SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 7,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Ilmu yang mempelajari pembagian harta warisan peninggalan orang yang meninggal secara adil disebut ilmu...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Fikih jinayah',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Faraidh (mawarits)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Fikih siyasah',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Fikih munakahat',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Sebelum harta warisan dibagikan kepada ahli waris, kewajiban utang dan wasiat almarhum harus dilunasi terlebih dahulu.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Ahli waris yang bagian warisannya telah ditetapkan nominal pastinya dalam kitab suci disebut dzawil...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'furudh',
      ),
    ),
  ),
  142 => 
  array (
    'judul' => 'Kuis Pencegahan Pergaulan Bebas & Narkoba SMA',
    'deskripsi' => 'Menjaga kehormatan diri iffah, bahaya zina, khamr, dan zat adiktif perusak akal SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 7,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sikap membentengi dan menjaga kehormatan diri dari perbuatan dosa dan maksiat dinamakan menjaga...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Ghadhab',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Iffah',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Takabur',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Sum\'ah',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Penyalahgunaan minuman keras dan narkotika diharamkan karena merusak akal budi dan kesehatan tubuh.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Perbuatan hubungan badan di luar ikatan pernikahan yang sah merupakan dosa besar yang dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'zina',
      ),
    ),
  ),
  143 => 
  array (
    'judul' => 'Ulangan Prinsip Fikih Muamalah Transaksi SMA',
    'deskripsi' => 'Larangan riba gharar maisir, akad mudharabah murabahah jual beli jujur SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 7,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Akad kerjasama usaha di mana satu pihak menyediakan seluruh modal dan pihak lain mengelola usaha dinamakan akad...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Ijarah',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Mudharabah',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Rahn',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Wakalah',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Transaksi yang mengandung unsur spekulasi judi (maisir) dan ketidakjelasan barang (gharar) dilarang dalam syariat.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Penambahan nilai atau bunga uang pinjaman yang dipersyaratkan tanpa imbalan riil dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'riba',
      ),
    ),
  ),
  144 => 
  array (
    'judul' => 'Latihan Solidaritas Global & Ukhuwah Insaniyah SMA',
    'deskripsi' => 'Ukhuwah islamiyah, wathaniyah kebangsaan, insaniyah kemanusiaan sejagat SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 7,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Konsep persaudaraan yang mengikat seluruh umat manusia di bumi tanpa memandang perbedaan bangsa dan ras disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Ukhuwah Islamiyah',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Ukhuwah Insaniyah (Basyariyah)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Ukhuwah Wathaniyah',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Ukhuwah Nasabiyah',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Menjaga perdamaian dunia dan menyalurkan bantuan kemanusiaan kepada korban perang adalah kewajiban moral beragama.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Persaudaraan yang didasarkan pada ikatan satu tanah air dan bangsa dinamakan ukhuwah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'wathaniyah',
      ),
    ),
  ),
  145 => 
  array (
    'judul' => 'Tantangan Menghayati Hakikat Ihsan SMA',
    'deskripsi' => 'Beribadah seolah melihat Tuhan, keikhlasan batiniah, menjauhi riya sumah SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 7,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Tingkatan ibadah tertinggi di mana seseorang beribadah seolah-olah melihat Tuhan dinamakan tingkatan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Islam',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Ihsan',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Iman',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Syariat formal',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Perbuatan riya atau memamerkan amal kebaikan kepada orang lain dapat menghapus pahala ibadah.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Mengerjakan amal kebajikan semata-mata mengharap ridha Tuhan dinamakan beramal dengan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'ikhlas',
      ),
    ),
  ),
  146 => 
  array (
    'judul' => 'Uji Berpikir Kritis Tadabur Alam Ulil Albab SMA',
    'deskripsi' => 'Karakter ulil albab, refleksi pergantian siang malam, sains dan ketauhidan SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 7,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Orang-orang yang senantiasa mengingat Tuhan dan mendayagunakan akal pikirannya meneliti penciptaan alam semesta disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Kaum musyrik',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Ulil albab',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Kaum munafik',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Kaum taklid',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Agama mendorong umat manusia untuk melakukan riset ilmiah dan memajukan peradaban sains bagi kemaslahatan bersama.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Memperhatikan dan merenungkan tanda-tanda kebesaran Tuhan di alam ciptaan-Nya dinamakan kegiatan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'tadabur',
      ),
    ),
  ),
  147 => 
  array (
    'judul' => 'Kuis Perangkat Keras Komputer SD',
    'deskripsi' => 'Mengenal layar monitor, mouse, keyboard, CPU, dan printer SD.',
    'id_jenjang' => 1,
    'id_mapel' => 8,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Perangkat keras komputer yang berfungsi untuk menampilkan gambar dan teks di layar adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Keyboard',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Monitor',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Mouse',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Printer',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Keyboard digunakan untuk memasukkan perintah ketikan huruf, angka, dan simbol.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Perangkat keras yang digerakkan menggunakan tangan untuk mengarahkan kursor panah adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'mouse',
      ),
    ),
  ),
  148 => 
  array (
    'judul' => 'Evaluasi Mengetik Cepat & Tombol Keyboard SD',
    'deskripsi' => 'Fungsi tombol Spasi, Enter, Backspace, Delete, dan Caps Lock SD.',
    'id_jenjang' => 1,
    'id_mapel' => 8,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Tombol pada keyboard yang digunakan untuk menghapus satu huruf di sebelah kiri kursor adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Enter',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Backspace',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Shift',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Tab',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Tombol Caps Lock digunakan untuk mengetik huruf kapital secara terus menerus.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Tombol panjang di bagian bawah keyboard yang digunakan untuk memberi jarak antar kata adalah tombol...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'spasi',
      ),
    ),
  ),
  149 => 
  array (
    'judul' => 'Kuis Menggambar Digital dengan Paint SD',
    'deskripsi' => 'Mengenal ikon kuas, ember cat (fill), pensil, dan penghapus di Paint SD.',
    'id_jenjang' => 1,
    'id_mapel' => 8,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Ikon ember cat tumpah (Fill with color) pada aplikasi Paint digunakan untuk...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Menghapus gambar',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Mewarnai area tertutup dengan cepat',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Membuat garis lurus',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Memperbesar tampilan',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Ikon pensil (Pencil tool) digunakan untuk menggambar bebas di lembar kanvas digital.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Format berkas gambar digital yang sering dihasilkan dari lukisan komputer adalah PNG atau...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'jpg',
      ),
    ),
  ),
  150 => 
  array (
    'judul' => 'Ulangan Internet Sehat & Waspada Layar SD',
    'deskripsi' => 'Menjaga kerahasiaan kata sandi, tidak buka tautan asing, dan batas waktu layar SD.',
    'id_jenjang' => 1,
    'id_mapel' => 8,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Informasi pribadi berikut yang TIDAK boleh dibagikan kepada orang asing di internet adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Nama hobi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Kata sandi (password) dan alamat rumah',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Warna kesukaan',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Judul buku bacaan',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Bermain game di ponsel atau komputer terlalu lama tanpa istirahat dapat merusak kesehatan mata.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Tindakan mengunci perangkat menggunakan kode rahasia bertujuan melindungi data...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'pribadi',
      ),
    ),
  ),
  151 => 
  array (
    'judul' => 'Latihan Membuat Folder & Simpan Berkas SD',
    'deskripsi' => 'Manajemen file, menyimpan dokumen, membuat folder baru di komputer SD.',
    'id_jenjang' => 1,
    'id_mapel' => 8,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Tempat penyimpanan digital di komputer yang digunakan untuk mengelompokkan dokumen agar rapi disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'File',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Folder',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Kursor',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Shortcut',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Perintah "Save" pada aplikasi pengolah kata digunakan untuk menyimpan berkas dokumen yang telah dibuat.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Perangkat kecil portabel yang dicolokkan ke lubang USB untuk menyalin berkas file dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'flashdisk',
      ),
    ),
  ),
  152 => 
  array (
    'judul' => 'Tantangan Logika Blok Karakter Bergerak SD',
    'deskripsi' => 'Mengenal balok perintah Scratch, karakter sprite, dan kanvas panggung SD.',
    'id_jenjang' => 1,
    'id_mapel' => 8,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pada aplikasi pemrograman visual anak Scratch, karakter animasi yang dapat diberi perintah gerak disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Sprite',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Pixel',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Modem',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Browser',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Blok warna biru dalam Scratch berfungsi untuk mengatur gerakan karakter (motion).',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Karakter hewan warna oranye yang menjadi maskot utama aplikasi Scratch adalah seekor...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'kucing',
      ),
    ),
  ),
  153 => 
  array (
    'judul' => 'Uji Etika Berkomunikasi Digital Santun SD',
    'deskripsi' => 'Mengirim email tugas ke guru, tata cara menulis di grup chat, jauhi perundungan SD.',
    'id_jenjang' => 1,
    'id_mapel' => 8,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sikap yang benar saat mengirim pesan tugas sekolah lewat chat kepada bapak/ibu guru adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Langsung mengirim pesan tanpa salam',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Mengucap salam, menyebutkan nama lengkap, dan berbahasa santun',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Menggunakan huruf kapital semua',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Mengirim pesan di tengah malam',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Mengejek dan menjelek-jelekkan teman di media sosial (cyberbullying) merupakan perbuatan tercela dan dilarang.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Surat elektronik yang dikirim melalui jaringan internet dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'email',
      ),
    ),
  ),
  154 => 
  array (
    'judul' => 'Kuis Jaringan Komputer & Topologi Jaringan SMP',
    'deskripsi' => 'Mengenal LAN, WAN, router, switch, topologi bintang (star) dan bus SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 8,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Jaringan komputer yang menghubungkan perangkat dalam cakupan area terbatas seperti satu ruangan lab sekolah disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'WAN',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'LAN',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'MAN',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Internet',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Perangkat keras switch berfungsi mendistribusikan paket data ke komputer tujuan dalam jaringan lokal.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Topologi jaringan di mana semua komputer terhubung ke satu perangkat pusat switch/hub disebut topologi...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'star',
      ),
    ),
  ),
  155 => 
  array (
    'judul' => 'Evaluasi Sistem Bilangan Biner & Desimal SMP',
    'deskripsi' => 'Konversi biner ke desimal, 1 byte = 8 bit, dan gerbang logika dasar SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 8,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sistem bilangan yang digunakan oleh mesin komputer dan hanya mengenal dua simbol angka 0 dan 1 adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Desimal',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Biner',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Oktal',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Heksadesimal',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Nilai desimal dari susunan bilangan biner 1001 adalah 9.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Satu satuan Byte dalam ukuran kapasitas data digital tersusun atas kumpulan berapa bit?',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '8',
      ),
    ),
  ),
  156 => 
  array (
    'judul' => 'Kuis Rumus Lembar Kerja Spreadsheet SMP',
    'deskripsi' => 'Penerapan fungsi formula SUM, AVERAGE, MIN, MAX, dan COUNT spreadsheet SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 8,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Rumus spreadsheet yang digunakan untuk menghitung nilai rata-rata dari suatu rentang sel angka adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '=SUM()',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '=AVERAGE()',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '=COUNT()',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '=MAX()',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Semua penulisan rumus fungsi pada lembar kerja spreadsheet harus diawali dengan tanda sama dengan (=).',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Fungsi formula yang digunakan untuk menjumlahkan seluruh angka dalam rentang sel adalah fungsi...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'sum',
      ),
    ),
  ),
  157 => 
  array (
    'judul' => 'Ulangan Algoritma Percabangan & Perulangan SMP',
    'deskripsi' => 'Struktur IF-THEN-ELSE, loop FOR/WHILE, dan pembacaan diagram alir flowchart SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 8,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Struktur kontrol algoritma yang digunakan untuk memilih jalur eksekusi berdasarkan syarat kondisi tertentu adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Sekuensial',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Percabangan (Branching)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Inisialisasi',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Kompilasi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Simbol belah ketupat pada diagram alir (flowchart) digunakan untuk melambangkan keputusan (decision).',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Proses menjalankan sekumpulan perintah yang sama secara berulang-ulang sampai kondisi berhenti terpenuhi disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'perulangan',
      ),
    ),
  ),
  158 => 
  array (
    'judul' => 'Latihan Keamanan Siber & Deteksi Phishing SMP',
    'deskripsi' => 'Waspada tautan palsu phishing, autentikasi dua faktor (2FA), dan malware SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 8,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kejahatan siber yang berupaya memancing korban memasukkan kata sandi ke situs web tiruan palsu dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'DDoS',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Phishing',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Defrag',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Overclocking',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Fitur autentikasi dua langkah (Two-Factor Authentication/2FA) meningkatkan keamanan akun digital dari peretasan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Program jahat yang dirancang untuk merusak sistem atau mencuri data komputer pengguna disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'malware',
      ),
    ),
  ),
  159 => 
  array (
    'judul' => 'Tantangan Analisis Data & Grafik Batang SMP',
    'deskripsi' => 'Pengelompokan data, sorting alfabetis, dan visualisasi grafik garis lingkaran SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 8,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Jenis diagram yang paling tepat digunakan untuk menunjukkan tren kenaikan atau penurunan data sepanjang waktu adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Diagram lingkaran (Pie)',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Diagram garis (Line chart)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Diagram radar',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Diagram piramida',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Fitur Sort pada pengolah data digunakan untuk mengurutkan baris data dari nilai terkecil ke terbesar.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Diagram berbentuk lingkaran yang terbagi menjadi beberapa juring persentase dinamakan diagram...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'lingkaran',
      ),
    ),
  ),
  160 => 
  array (
    'judul' => 'Uji Computational Thinking 4 Pilar SMP',
    'deskripsi' => 'Dekomposisi persoalan, pengenalan pola, abstraksi informasi, dan algoritma SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 8,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kemampuan memecah suatu masalah yang kompleks menjadi bagian-bagian yang lebih kecil dan sederhana disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Abstraksi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Dekomposisi',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Pengenalan pola',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Perancangan algoritma',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Abstraksi adalah proses menyaring dan membuang hal-hal yang tidak penting agar dapat fokus pada inti masalah.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Urutan langkah-langkah logis dan terstruktur yang disusun untuk menyelesaikan suatu permasalahan disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'algoritma',
      ),
    ),
  ),
  161 => 
  array (
    'judul' => 'Kuis Bahasa Pemrograman Python Dasar SMA',
    'deskripsi' => 'Variabel, tipe data integer float string, fungsi print dan input Python SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 8,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Perintah bawaan dalam bahasa Python yang digunakan untuk menampilkan data ke layar konsol adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'cin >>',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'print()',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'echo',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'console.write()',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Tipe data boolean pada bahasa pemrograman hanya memiliki dua kemungkinan nilai yaitu True atau False.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Fungsi bawaan Python yang digunakan untuk menerima masukan teks dari pengguna melalui keyboard adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'input',
      ),
    ),
  ),
  162 => 
  array (
    'judul' => 'Evaluasi Struktur Data Array, Stack & Queue SMA',
    'deskripsi' => 'Prinsip LIFO pada stack, FIFO pada antrean queue, dan indeks elemen array SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 8,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Struktur data antrean yang bekerja berdasarkan prinsip First In First Out (FIFO) dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Stack',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Queue',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Tree',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Graph',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pada struktur data Stack (tumpukan), operasi penambahan elemen baru ke posisi teratas disebut operasi push.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Prinsip tumpukan di mana elemen terakhir yang masuk akan menjadi elemen pertama yang keluar disingkat...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'lifo',
      ),
    ),
  ),
  163 => 
  array (
    'judul' => 'Kuis Perancangan Basis Data Relasional & SQL SMA',
    'deskripsi' => 'Tabel relasi, Primary Key, Foreign Key, dan perintah query SELECT WHERE SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 8,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Perintah SQL yang digunakan untuk mengambil dan menampilkan rekaman data dari tabel adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'INSERT INTO',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'SELECT',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'DROP TABLE',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'ALTER TABLE',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Primary Key adalah kolom unik dalam tabel basis data yang tidak boleh bernilai kosong (NOT NULL) atau duplikat.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kueri klausa SQL yang digunakan untuk menyaring baris data berdasarkan kriteria tertentu adalah klausa...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'where',
      ),
    ),
  ),
  164 => 
  array (
    'judul' => 'Ulangan Model OSI 7 Layer & Protokol Internet SMA',
    'deskripsi' => 'Physical hingga Application layer, port 80 HTTP, port 443 HTTPS, IP address SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 8,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Lapisan teratas pada model referensi OSI Layer yang berinteraksi langsung dengan aplikasi pengguna adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Transport Layer',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Application Layer',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Network Layer',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Session Layer',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Protokol HTTPS menggunakan enkripsi data kriptografi untuk menjaga kerahasiaan komunikasi di halaman web.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Nomor identitas numerik unik yang dimiliki oleh setiap perangkat komputer yang terhubung ke jaringan internet disebut alamat...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'ip',
      ),
    ),
  ),
  165 => 
  array (
    'judul' => 'Latihan Kecerdasan Buatan & Machine Learning SMA',
    'deskripsi' => 'Model pembelajaran mesin terawasi (supervised), computer vision, dan NLP SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 8,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Cabang kecerdasan buatan (AI) yang melatih komputer untuk memahami, menafsirkan, dan memproses bahasa manusia dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Computer Vision',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Natural Language Processing (NLP)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Robotic Process',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Blockchain',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Model pembelajaran supervised learning memerlukan data latih yang telah dilengkapi label kategori benar.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Struktur komputasi kecerdasan buatan yang arsitekturnya meniru jaringan sel saraf otak manusia disingkat...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'ann',
      ),
    ),
  ),
  166 => 
  array (
    'judul' => 'Tantangan Etika Digital & Lisensi Open Source SMA',
    'deskripsi' => 'Lisensi GPL, MIT, Creative Commons, hak cipta software, dan UU ITE SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 8,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Perangkat lunak yang kode program sumbernya (source code) terbuka dan bebas untuk dipelajari serta dimodifikasi disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Proprietary Software',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Open Source Software',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Freeware tertutup',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Malware',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Mengunduh dan mendistribusikan perangkat lunak komersial bajakan merupakan pelanggaran hak kekayaan intelektual.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Lisensi yang mengizinkan pemanfaatan karya secara luas selama mencantumkan nama pembuat aslinya adalah Creative...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'commons',
      ),
    ),
  ),
  167 => 
  array (
    'judul' => 'Uji Pemrograman Web Dinamis HTML & CSS SMA',
    'deskripsi' => 'Elemen tag struktur HTML5, styling CSS, dan manipulasi DOM JavaScript SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 8,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Tag bahasa HTML yang digunakan secara tepat untuk menyisipkan tautan (hyperlink) ke halaman lain adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '<img>',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '<a>',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '<link>',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '<p>',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'CSS (Cascading Style Sheets) digunakan untuk mengatur gaya tampilan, warna, font, dan tata letak halaman web.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Bahasa pemrograman skrip yang berjalan di sisi peramban browser untuk membuat halaman web interaktif adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'javascript',
      ),
    ),
  ),
  168 => 
  array (
    'judul' => 'Kuis Campuran Warna & Lingkaran Warna SD',
    'deskripsi' => 'Mengenal warna primer merah kuning biru dan menghasilkan warna sekunder SD.',
    'id_jenjang' => 1,
    'id_mapel' => 9,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Jika warna primer merah dicampur dengan warna kuning dalam porsi seimbang, akan menghasilkan warna...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Ungu',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Oranye (Jingga)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Hijau',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Cokelat',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Warna primer adalah warna dasar yang tidak dapat dihasilkan dari campuran warna lain.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Campuran antara warna primer biru dan kuning akan menghasilkan warna...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'hijau',
      ),
    ),
  ),
  169 => 
  array (
    'judul' => 'Evaluasi Seni Melipat Origami & Kolase SD',
    'deskripsi' => 'Teknik melipat kertas bentuk hewan, menempel biji-bijian pada bidang kolase SD.',
    'id_jenjang' => 1,
    'id_mapel' => 9,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Karya seni rupa yang dibuat dengan menempelkan berbagai bahan seperti kertas, kain, atau daun pada permukaan bidang disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Lukisan cat air',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Seni kolase',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Patung batu',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Grafiti',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Seni melipat kertas tradisional yang berasal dari negara Jepang dinamakan seni origami.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Bahan perekat yang digunakan saat menyusun karya seni kolase kertas adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'lem',
      ),
    ),
  ),
  170 => 
  array (
    'judul' => 'Kuis Lagu Daerah & Nada Diatonis SD',
    'deskripsi' => 'Menyanyikan lagu Gundul Pacul, Ampar Pisang, tempo cepat lambat SD.',
    'id_jenjang' => 1,
    'id_mapel' => 9,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Lagu daerah anak yang terkenal "Ampar-Ampar Pisang" berasal dari daerah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Jawa Barat',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Kalimantan Selatan',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Sumatera Barat',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Sulawesi Selatan',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Tanda tempo allegro pada partitur lagu menunjukkan bahwa lagu tersebut dinyanyikan dengan tempo cepat dan ceria.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Lagu daerah "Gundul-Gundul Pacul" berasal dari provinsi Jawa...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'tengah',
      ),
    ),
  ),
  171 => 
  array (
    'judul' => 'Ulangan Gerak Tari Tiruan Alam SD',
    'deskripsi' => 'Gerakan meniru ombak, burung terbang, kelinci melompat pada tarian SD.',
    'id_jenjang' => 1,
    'id_mapel' => 9,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Tari Merak dari Jawa Barat merupakan tarian kreasi yang menirukan gerakan dari...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Kijang berlari',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Burung merak yang memamerkan keindahan bulu ekornya',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Ikan berenang',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Petani mencangkul',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Gerakan tangan menari yang melambai-lambai lembut dapat menirukan hembusan semilir angin.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Iringan bunyi musik pada pementasan tari berfungsi sebagai pengatur ketukan ritme dan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'tempo',
      ),
    ),
  ),
  172 => 
  array (
    'judul' => 'Latihan Anyaman Kertas Pola Tunggal SD',
    'deskripsi' => 'Menyilangkan pita kertas lungsin dan pakan, membuat pola anyaman tikar SD.',
    'id_jenjang' => 1,
    'id_mapel' => 9,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pada pembuatan kerajinan anyaman kertas, bilah kertas yang posisinya mendatar dan disusupkan disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Lungsin',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Pakan',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Pondasi',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Rangka',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pola anyaman tunggal dibuat dengan cara menyilangkan satu pakan di atas satu lungsin secara bergantian.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Bahan alami lentur dari tumbuhan yang sering digunakan masyarakat pedesaan untuk membuat anyaman adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'bambu',
      ),
    ),
  ),
  173 => 
  array (
    'judul' => 'Tantangan Mengenal Gamelan & Alat Musik SD',
    'deskripsi' => 'Kendang, gong, saron, angklung bambu, dan cara memainkannya SD.',
    'id_jenjang' => 1,
    'id_mapel' => 9,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Alat musik tradisional dari bambu khas Jawa Barat yang dimainkan dengan cara digoyangkan adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Kolintang',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Angklung',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Suling',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Calung',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Gendang atau kendang dimainkan dengan cara dipukul menggunakan telapak tangan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Alat musik pukul tradisional dari Minahasa yang terbuat dari bilah kayu tersusun rapi bernama...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'kolintang',
      ),
    ),
  ),
  174 => 
  array (
    'judul' => 'Uji Kartu Ucapan Pop-Up Kreatif SD',
    'deskripsi' => 'Gunting lipat kertas timbul, ornamen hiasan bunga, dan kartu ucapan SD.',
    'id_jenjang' => 1,
    'id_mapel' => 9,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kartu ucapan yang ketika dibuka lembarannya akan memunculkan gambar objek timbul tiga dimensi disebut kartu...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Brosur',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Pop-up',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Pamflet',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Poster',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Menggambar garis lengkung dan spiral dapat memberikan kesan visual yang dinamis dan luwes.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pewarna kering berbentuk batangan lilin yang praktis digunakan menggambar oleh anak-anak adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'krayon',
      ),
    ),
  ),
  175 => 
  array (
    'judul' => 'Kuis Ragam Hias Tradisional Nusantara SMP',
    'deskripsi' => 'Motif geometris, tumpal, kawung, parang, flora dan fauna daerah SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 9,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Motif batik klasik berbentuk lingkaran-lingkaran lonjong menyerupai buah kelapa yang tersusun rapi adalah motif...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Parang Rusak',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Kawung',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Mega Mendung',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Truntum',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Ragam hias geometris berkembang dari bentuk-bentuk dasar seperti garis, segitiga, lingkaran, dan swastika.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Motif batik khas pesisir Cirebon yang menggambarkan gumpalan awan bergradasi adalah Mega...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'mendung',
      ),
    ),
  ),
  176 => 
  array (
    'judul' => 'Evaluasi Bernyanyi Vokal Group & Paduan Suara SMP',
    'deskripsi' => 'Pembagian suara sopran, alto, tenor, bas, teknik pernapasan diafragma SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 9,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kelompok jenis suara tinggi pada wanita dalam susunan paduan suara standar dinamakan suara...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Alto',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Sopran',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Tenor',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Bariton',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pernapasan diafragma merupakan teknik pernapasan yang paling ideal dan efektif digunakan saat bernyanyi.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pemimpin kelompok paduan suara yang mengatur dinamika, tempo, dan aba-aba nada disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'dirigen',
      ),
    ),
  ),
  177 => 
  array (
    'judul' => 'Kuis Tata Rias & Busana Karakter Tari SMP',
    'deskripsi' => 'Rias korektif, rias panggung karakter gagah/halus, properti tari piring SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 9,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Tata rias panggung yang bertujuan mengubah penampilan penari agar sesuai dengan watak karakter tokoh tarian disebut rias...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Korektif',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Karakter',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Natural',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Fantasi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Tari Piring asal Sumatera Barat menggunakan piring porselen sebagai properti utama gerak tari.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kain selendang panjang yang disematkan di pinggang dan dimainkan lentur oleh penari perempuan dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'sampur',
      ),
    ),
  ),
  178 => 
  array (
    'judul' => 'Ulangan Seni Patung Teknik Butsir & Cor SMP',
    'deskripsi' => 'Bahan lunak plastisin tanah liat butsir, cetak cor gips semen patung SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 9,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Teknik pembuatan patung dari bahan lunak dengan cara mengurangi atau menambah bahan menggunakan alat sudip disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Teknik pahat',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Teknik butsir',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Teknik las',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Teknik anyam',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Teknik cor pembuatan patung memerlukan cetakan awal yang diisi adonan cairan logam, semen, atau gips.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Bahan lunak sintetis warna-warni yang sering digunakan di sekolah untuk latihan membuat miniatur patung adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'plastisin',
      ),
    ),
  ),
  179 => 
  array (
    'judul' => 'Latihan Kerajinan Bahan Keras Kayu & Rotan SMP',
    'deskripsi' => 'Teknik ukir pahat kayu Jepara, anyaman rotan, pernis politur finishing SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 9,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kota di Jawa Tengah yang terkenal di kancah nasional maupun mancanegara sebagai sentra industri ukir kayu jati adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Pekalongan',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Jepara',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Kudus',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Surakarta',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Bahan finishing pelapis transparan seperti pernis dan politur berfungsi menonjolkan keindahan serat alami kayu.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Alat bilah baja bermata tajam yang digunakan untuk mengukir ornamen pada permukaan kayu adalah pisau...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'pahat',
      ),
    ),
  ),
  180 => 
  array (
    'judul' => 'Tantangan Seni Cetak Saring Sablon Grafis SMP',
    'deskripsi' => 'Bingkai kayu screen, emulsion peka cahaya, rakel karet, cat tekstil SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 9,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Alat bergagang kayu dengan bilah karet pipih yang digunakan untuk meratakan dan menekan tinta sablon pada kain adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Spuit',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Rakel',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Kuas palet',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Rol busa',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Kain kasa sintetis halus yang dipasang kencang pada bingkai cetak sablon dinamakan kain screen.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Cairan obat peka cahaya yang dioleskan pada kain screen sablon untuk proses afdruk dinamakan emulsi...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'afdruk',
      ),
    ),
  ),
  181 => 
  array (
    'judul' => 'Uji Teater Tradisional & Tata Panggung SMP',
    'deskripsi' => 'Lakon Betawi Lenong, Ketoprak Jawa, blocking pemeran, tata lampu pentas SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 9,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Seni pertunjukan teater rakyat tradisional khas masyarakat Betawi yang diiringi musik gambang kromong adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Ketoprak',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Lenong',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Ludruk',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Randai',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pengaturan posisi perpindahan para pemain di atas panggung agar tampak serasi dan seimbang disebut blocking.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Naskah tertulis yang memuat alur cerita, petunjuk gerak, dan dialog tokoh dalam pementasan drama teater disebut naskah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'lakon',
      ),
    ),
  ),
  182 => 
  array (
    'judul' => 'Kuis Aliran Seni Lukis Representatif SMA',
    'deskripsi' => 'Realisme Courbet, romantisme Raden Saleh, naturalisme pemandangan SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 9,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pelukis tersohor pelopor seni rupa modern Indonesia yang melukis karya agung "Penangkapan Pangeran Diponegoro" adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Affandi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Raden Saleh',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Basoeki Abdullah',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'S. Sudjojono',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Aliran realisme melukiskan keadaan masyarakat secara apa adanya sesuai kenyataan riil tanpa melebih-lebihkan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Aliran seni rupa yang menekankan lukisan pemandangan alam secara indah dan mendetail dinamakan aliran...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'naturalisme',
      ),
    ),
  ),
  183 => 
  array (
    'judul' => 'Evaluasi Seni Instalasi & Seni Rupa Kontemporer SMA',
    'deskripsi' => 'Karya seni tiga dimensi situs spesifik, medium readymade, interaktif SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 9,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Karya seni rupa kontemporer yang merakit dan menata berbagai benda dalam suatu ruang pameran tematik dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Seni instalasi',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Mural dinding',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Batik tulis',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Mozaik kaca',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Seni kontemporer bersifat bebas dari batasan kaidah seni akademis klasik tradisional.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pemanfaatan barang-barang bekas pakai dalam pembuatan karya seni rupa ramah lingkungan disebut seni daur...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'ulang',
      ),
    ),
  ),
  184 => 
  array (
    'judul' => 'Kuis Interval Tangga Nada & Susunan Akor SMA',
    'deskripsi' => 'Pola interval diatonis mayor minor, akor trinada tonika subdominan dominan SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 9,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pola jarak interval nada yang berlaku pada tangga nada diatonis mayor standar adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '1 - 1/2 - 1 - 1 - 1/2 - 1 - 1',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '1 - 1 - 1/2 - 1 - 1 - 1 - 1/2',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '1/2 - 1 - 1 - 1 - 1/2 - 1 - 1',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '1 - 1 - 1 - 1/2 - 1 - 1 - 1/2',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Akor C mayor standar tersusun atas paduan tiga nada dasar yaitu nada C, E, dan G.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Paduan bunyi beberapa nada yang dimainkan secara bersamaan sehingga terdengar harmonis dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'akor',
      ),
    ),
  ),
  185 => 
  array (
    'judul' => 'Ulangan Eksplorasi Gerak Tari Kontemporer SMA',
    'deskripsi' => 'Level gerak ruang tempo ritme, komposisi koreografi, eksplorasi tema SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 9,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Tingkatan posisi gerak penari di atas lantai panggung, seperti rebah, jongkok, atau melompat tinggi disebut elemen...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Tenaga',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Level gerak',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Tata busana',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Dramaturgi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Koreografer adalah sebutan profesional bagi seniman yang merancang dan menyusun karya tari.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Eksplorasi gerak tari tanpa rancangan paten terlebih dahulu dan mengalir mengikuti irama spontan disebut gerak...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'improvisasi',
      ),
    ),
  ),
  186 => 
  array (
    'judul' => 'Latihan Penulisan Naskah Lakon Teater Modern SMA',
    'deskripsi' => 'Karakterisasi protagonis antagonis, dialektika tema sosial, plot tiga babak SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 9,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Unsur utama yang menjadi motor penggerak ketegangan dalam sebuah alur lakon drama teater adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Tata panggung',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Konflik drama',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Iringan musik',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Durasi pentas',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Percakapan yang diucapkan oleh seorang aktor pemeran kepada dirinya sendiri di panggung disebut monolog.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Bagian pembuka pementasan teater yang berisi kata pengantar pengenalan situasi lakon dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'prolog',
      ),
    ),
  ),
  187 => 
  array (
    'judul' => 'Tantangan Ergonomi & Desain Produk Fungsional SMA',
    'deskripsi' => 'Kaidah ergonomi estetika kepraktisan, prototipe kemasan industri kreatif SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 9,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Prinsip utama dalam perancangan produk fungsional yang memastikan kenyamanan dan keamanan bagi tubuh pemakai adalah prinsip...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Ekonomis',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Ergonomi',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Monumental',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Simbolis',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Prototipe produk merupakan model tiruan awal yang dibuat untuk menguji fungsi rancangan sebelum diproduksi massal.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Desain rancangan awal visual produk dalam bentuk sketsa gambar sebelum dikerjakan nyata disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'desain',
      ),
    ),
  ),
  188 => 
  array (
    'judul' => 'Uji Kurasi & Manajemen Pameran Galeri Seni SMA',
    'deskripsi' => 'Peran kurator galeri, penyusunan katalog, display pencahayaan spot pameran SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 9,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Ahli yang bertugas menyeleksi, menyusun konsep kuratorial, dan menganalisis karya seni rupa dalam pameran adalah seorang...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Apresiator',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Kurator seni',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Kolektor',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Kritikus sastra',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pencahayaan lampu sorot (spotlight) pada ruang galeri diatur agar fokus menonjolkan detail karya tanpa menyilaukan mata pengunjung.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Buku publikasi resmi yang memuat daftar foto karya, profil perupa, dan tulisan pengantar kuratorial pameran dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'katalog',
      ),
    ),
  ),
  189 => 
  array (
    'judul' => 'Kuis Gerak Lokomotor & Manipulatif SD',
    'deskripsi' => 'Mengenal jalan lari lompat lokomotor dan melempar menangkap bola manipulatif SD.',
    'id_jenjang' => 1,
    'id_mapel' => 10,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Gerakan tubuh yang berpindah dari satu titik tempat ke tempat lain seperti berlari dan melompat disebut gerak...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Non-lokomotor',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Lokomotor',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Manipulatif',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Statis',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Gerakan menekuk lutut dan memutar pergelangan tangan di tempat tergolong ke dalam gerak non-lokomotor.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Aktivitas fisik yang melibatkan keterampilan memainkan suatu benda atau bola dinamakan gerak...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'manipulatif',
      ),
    ),
  ),
  190 => 
  array (
    'judul' => 'Evaluasi Permainan Tradisional Kasti SD',
    'deskripsi' => 'Teknik memukul bola kayu, melempar bola lambung, lari ke tiang hinggap SD.',
    'id_jenjang' => 1,
    'id_mapel' => 10,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Jumlah pemain inti dalam satu regu pada permainan olahraga kasti di lapangan adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '6 orang',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '11 orang',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '12 orang',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '15 orang',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pemain pemukul kasti yang berhasil memukul bola dan berlari mengitari semua tiang hingga kembali ke ruang bebas mendapat nilai 2.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pemain dalam tim regu penjaga kasti yang bertugas melambungkan bola ke arah pemukul disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'pelambung',
      ),
    ),
  ),
  191 => 
  array (
    'judul' => 'Kuis Latihan Kekuatan Push-Up & Sit-Up SD',
    'deskripsi' => 'Melatih otot lengan push-up, otot perut sit-up, peregangan dinamis SD.',
    'id_jenjang' => 1,
    'id_mapel' => 10,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Gerakan latihan push-up yang dilakukan secara teratur bertujuan utama melatih kekuatan otot...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Perut dan punggung',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Lengan dan dada',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Paha dan betis',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Leher dan kepala',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Melakukan pemanasan (warming up) sebelum mulai berolahraga sangat penting untuk mencegah kram dan cedera otot.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Latihan berbaring lalu mengangkat punggung ke arah lutut untuk melatih kekuatan otot perut dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'sit-up',
      ),
    ),
  ),
  192 => 
  array (
    'judul' => 'Ulangan Senam Lantai Guling Depan SD',
    'deskripsi' => 'Sikap awalan jongkok, bertumpu telapak tangan, tengkuk menyentuh matras SD.',
    'id_jenjang' => 1,
    'id_mapel' => 10,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Bagian tubuh pertama yang mendarat menyentuh permukaan matras saat melakukan guling depan yang benar adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Dahi kepala',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Tengkuk leher belakang',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Punggung bawah',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Kedua lutut',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Senam lantai wajib menggunakan alas busa matras yang empuk dan aman dari benturan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Gerakan berguling ke arah depan di atas matras senam sering disebut gerakan forward roll atau roll...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'depan',
      ),
    ),
  ),
  193 => 
  array (
    'judul' => 'Latihan Meluncur di Air Renang Dada SD',
    'deskripsi' => 'Pengenalan air, posisi badan telungkup streamline, pernapasan mulut renang SD.',
    'id_jenjang' => 1,
    'id_mapel' => 10,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Posisi kedua lengan tangan saat melakukan gerakan meluncur lurus di permukaan air kolam renang adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Direntangkan ke samping',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Lurus rapat ke depan sejajar daun telinga',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Ditekuk di pinggang',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Mengayun ke belakang',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pengambilan napas pada renang gaya dada dilakukan dengan mengangkat kepala ke atas permukaan air.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Alat bantu latihan renang berupa papan apung plastik yang dipegang tangan saat melatih ayunan kaki disebut papan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'pelampung',
      ),
    ),
  ),
  194 => 
  array (
    'judul' => 'Tantangan Menu Gizi 4 Sehat 5 Sempurna SD',
    'deskripsi' => 'Karbohidrat nasi, protein lauk, vitamin sayur buah, kalsium susu pelengkap SD.',
    'id_jenjang' => 1,
    'id_mapel' => 10,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Zat gizi yang terkandung di dalam nasi, jagung, dan kentang yang berfungsi sebagai sumber tenaga utama tubuh adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Vitamin',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Karbohidrat',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Kalsium',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Zat besi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Sayur-mayur hijau dan buah-buahan segar kaya akan vitamin serta serat alami untuk melancarkan pencernaan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Minuman kaya protein hewani dan kalsium yang menjadi penyempurna dalam pola makan 4 sehat 5 sempurna adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'susu',
      ),
    ),
  ),
  195 => 
  array (
    'judul' => 'Uji Kebersihan Tubuh & Cuci Tangan Bersih SD',
    'deskripsi' => 'Mandi sabun dua kali sehari, keramas rambut, potong kuku, cuci tangan air mengalir SD.',
    'id_jenjang' => 1,
    'id_mapel' => 10,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Cara mencuci tangan yang paling bersih dan efektif membasmi kuman penyakit sebelum makan adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Mencelupkan ke mangkuk air',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Mencuci dengan sabun di bawah air bersih yang mengalir',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Mengelap ke celana',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Menyemprotkan parfum',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Setelah selesai berolahraga, pakaian yang basah oleh keringat harus segera diganti dengan pakaian bersih dan kering.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Mandi dengan sabun secara teratur minimal dilakukan sebanyak berapa kali sehari?',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '2',
      ),
    ),
  ),
  196 => 
  array (
    'judul' => 'Kuis Keterampilan Mengoper & Menembak Bola SMP',
    'deskripsi' => 'Passing kaki bagian dalam luar, dribble zig-zag, shooting keras sepak bola SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 10,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Bagian kaki yang paling tepat dan stabil digunakan untuk melakukan operan bola pendek mendatar (short pass) adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Punggung kaki kura-kura',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Kaki bagian dalam',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Ujung jari kaki',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Tumit kaki',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Penjaga gawang (kiper) sepak bola hanya diperbolehkan menangkap bola menggunakan tangan di dalam area kotak penalti sendiri.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Hukuman tendangan langsung dari titik putih berjarak 11 meter di depan gawang akibat pelanggaran di kotak terlarang disebut tendangan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'penalti',
      ),
    ),
  ),
  197 => 
  array (
    'judul' => 'Evaluasi Pola Servis & Smash Bola Voli SMP',
    'deskripsi' => 'Servis atas bawah mengapung, passing bawah bola keras, loncatan smash voli SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 10,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pukulan keras dan menukik tajam ke arah lantai lapangan lawan untuk mematikan bola voli dinamakan teknik...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Passing bawah',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Smash (spike)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Servis atas',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Blocking ganda',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Dalam permainan resmi bola voli, setiap tim yang bertanding di lapangan terdiri atas 6 orang pemain.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Teknik menyambut bola pantul keras setinggi pinggang menggunakan kedua lengan rapat lurus dinamakan passing...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'bawah',
      ),
    ),
  ),
  198 => 
  array (
    'judul' => 'Kuis Variasi Dribble & Tembakan Bola Basket SMP',
    'deskripsi' => 'Crossover dribble, operan dada (chest pass), tembakan lay-up dua langkah SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 10,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Teknik memasukkan bola ke ring basket yang diawali dengan gerakan melompat melayang setelah dua langkah lari dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Pivot shoot',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Lay-up shoot',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Free throw',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Three point',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Gerakan pivot dalam bola basket dilakukan dengan memutar badan dengan salah satu kaki tetap bertindak sebagai poros tumpuan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Operan bola lurus setinggi dada kepada rekan satu tim dalam permainan bola basket dinamakan chest...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'pass',
      ),
    ),
  ),
  199 => 
  array (
    'judul' => 'Ulangan Lari Cepat Sprint & Start Jongkok SMP',
    'deskripsi' => 'Teknik start pendek medium panjang, dorongan balok start, posisi condong sprint SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 10,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Jenis posisi start yang wajib digunakan oleh atlet pelari pada perlombaan lari jarak pendek (sprint 100m) adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Start melayang',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Start jongkok (crouch start)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Start berdiri',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Start duduk',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Urutan aba-aba resmi pada perlombaan lari cepat di lintasan atletik adalah "Bersedia", "Siap", dan bunyi letupan pistol/aba-aba "Ya".',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Alat tumpuan kaki dari lempengan logam pada garis awal lintasan lari cepat dinamakan starting...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'block',
      ),
    ),
  ),
  200 => 
  array (
    'judul' => 'Latihan Kuda-Kuda & Tangkisan Pencak Silat SMP',
    'deskripsi' => 'Kuda-kuda depan tengah samping, tangkisan luar dalam, pukulan lurus silat SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 10,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sikap dasar menjejakkan kaki kokoh menopang bobot badan untuk bersiap menyerang atau bertahan dalam silat dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Langkah serong',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Kuda-kuda',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Tangkisan',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Kuncian',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Usaha pembelaan diri dengan mengadakan kontak benturan langsung terhadap serangan pukulan lawan dinamakan tangkisan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Olahraga seni bela diri warisan leluhur asli bangsa Indonesia yang telah diakui dunia adalah pencak...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'silat',
      ),
    ),
  ),
  201 => 
  array (
    'judul' => 'Tantangan Tes Lari Bolak-Balik Shuttle Run SMP',
    'deskripsi' => 'Mengukur kelincahan (agility), daya tahan kardiorespiratori, dan kelenturan SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 10,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Bentuk latihan lari bolak-balik dalam jarak 5-10 meter yang dilakukan secara cepat untuk melatih kelincahan gerak disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Interval training',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Shuttle run',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Fartlek',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Maraton',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Latihan lari jogging jarak jauh santai (aerobik) dapat meningkatkan kapasitas daya tahan organ jantung dan paru-paru.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kemampuan tubuh seseorang untuk mengubah arah gerak secara cepat dan tepat tanpa kehilangan keseimbangan disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'kelincahan',
      ),
    ),
  ),
  202 => 
  array (
    'judul' => 'Uji Bahaya Narkoba, Tar Nikotin & Miras SMP',
    'deskripsi' => 'Kandungan racun rokok, pengaruh miras terhadap sel saraf, jauhi narkotika SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 10,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Gas beracun berbahaya dalam asap rokok yang mengikat hemoglobin darah dan menurunkan kadar pasokan oksigen adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Gas oksigen murni',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Gas karbon monoksida (CO)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Gas nitrogen',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Gas argon',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Minuman beralkohol dapat menyebabkan hilangnya koordinasi gerak motorik tubuh serta kerusakan permanen organ hati.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Zat adiktif stimulan yang terkandung di dalam daun tembakau rokok yang menyebabkan candu adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'nikotin',
      ),
    ),
  ),
  203 => 
  array (
    'judul' => 'Kuis Taktik Penyerangan Total Football SMA',
    'deskripsi' => 'Formasi 4-3-3, operan tiki-taka, jebakan offside, pressing tinggi pertahanan SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 10,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sistem formasi modern sepak bola 4-3-3 menempatkan komposisi pemain berupa...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '4 bek, 4 gelandang, 2 penyerang',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '4 bek bertahan, 3 pemain tengah gelandang, dan 3 penyerang',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '3 bek, 5 gelandang, 2 penyerang',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '5 bek, 3 gelandang, 2 penyerang',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Perangkap offside dirancang oleh barisan pemain belakang untuk menjebak striker lawan berada di belakang bek saat bola dioper.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Dua petugas di tepi garis lapangan sepak bola yang bertugas membantu wasit utama mengangkat bendera dinamakan hakim...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'garis',
      ),
    ),
  ),
  204 => 
  array (
    'judul' => 'Evaluasi Pola Fast Break & Zone Defense Basket SMA',
    'deskripsi' => 'Transisi kilat fast break, perangkap man to man, penjagaan wilayah zona SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 10,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pola penyerangan kilat dalam bola basket yang dilancarkan secara cepat sebelum regu bertahan sempat mengatur formasi disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Set offense',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Fast break',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Zone defense',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Man-to-man defense',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pelanggaran melangkah membawa bola lebih dari dua langkah kaki tanpa memantulkan bola ke lantai disebut traveling violation.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Sistem pertahanan basket di mana setiap pemain bertanggung jawab menjaga area tertentu dinamakan sistem zone...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'defense',
      ),
    ),
  ),
  205 => 
  array (
    'judul' => 'Kuis Taktik Pukulan Dropshot & Smash Badminton SMA',
    'deskripsi' => 'Forehand net kill, dropshot tipis bibir net, drive mendatar bulu tangkis SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 10,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pukulan dalam bulu tangkis yang dipukul pelan meluncur menukik tajam dan jatuh sedekat mungkin di dekat jaring net lawan dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Pukulan lob',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Pukulan dropshot',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Pukulan drive',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Servis panjang',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pukulan lob dalam permainan bulu tangkis bertujuan menerbangkan shuttlecock setinggi-tingginya jauh ke belakang garis lapangan lawan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Bola bulu angsa yang digunakan pada pertandingan olahraga bulu tangkis dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'shuttlecock',
      ),
    ),
  ),
  206 => 
  array (
    'judul' => 'Ulangan Tolak Peluru Gaya Menyamping & O Brien SMA',
    'deskripsi' => 'Punggung sektor lempar O Brien, tolakan siku 45 derajat, balok tumpuan SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 10,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Gaya tolak peluru di mana atlet mengawali gerakan dengan membelakangi arah sektor tolakan peluru dinamakan gaya...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Ortodoks (menyamping)',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'O\'Brien (glide gaya membelakangi)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Spin gaya memutar',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Flop lompat',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Peluru besi dalam tolak peluru tidak boleh dilempar seperti bola, melainkan harus ditolak/didorong kuat dari bahu leher.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Bak pendaratan atlet lompat jauh berisi hamparan butiran pasir halus yang berfungsi meredam benturan saat...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'mendarat',
      ),
    ),
  ),
  207 => 
  array (
    'judul' => 'Latihan Aerobik Ritmik & Irama Musik SMA',
    'deskripsi' => 'Rangkaian low impact, v-step, mambo, pendinginan cooling down aerobik SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 10,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Gerakan pemanasan awal dan peregangan pada senam ritmik aerobik bertujuan utama...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Meningkatkan asam laktat',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Mempersiapkan elastisitas otot dan meningkatkan suhu tubuh secara bertahap',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Menguras tenaga dengan cepat',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Mempercepat kelelahan',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Fase pendinginan (cooling down) membantu mengembalikan denyut jantung dan sirkulasi darah kembali ke kondisi normal.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Gerakan melangkahkan kaki membentuk pola huruf V ke depan dan kembali ke posisi semula dalam aerobik disebut langkah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'v-step',
      ),
    ),
  ),
  208 => 
  array (
    'judul' => 'Tantangan Metode RICE Pertolongan Cedera Otot SMA',
    'deskripsi' => 'Penanganan sprain terkilir akut: Rest, Ice kompres, Compression, Elevation SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 10,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Tindakan pertolongan pertama pada cedera otot terkilir akut dengan prinsip RICE mencakup langkah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Massage, heat, run, eat',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Rest, Ice, Compression, Elevation',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Run, inject, compress, exercise',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Rub, ignite, cold, energy',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Kompres es dingin pada cedera baru bermanfaat mempersempit pembuluh darah sehingga mengurangi pendarahan dalam dan bengkak.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Papan kayu penyangga darurat yang dipasang mengikat anggota tubuh yang dicurigai patah tulang dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'bidai',
      ),
    ),
  ),
  209 => 
  array (
    'judul' => 'Uji Indeks Massa Tubuh (BMI) & Kebugaran SMA',
    'deskripsi' => 'Menghitung rasio BB/(TB)^2, denyut nadi maksimal MHR, body fat composition SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 10,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Rumus standar penentuan Indeks Massa Tubuh (Body Mass Index / BMI) adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Berat badan (kg) dibagi tinggi badan (m)',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Berat badan (kg) dibagi kuadrat tinggi badan (m²)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Tinggi badan dikurangi berat badan',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Berat badan dikali lingkar pinggang',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Nilai BMI seseorang yang berada di atas angka 25 mengindikasikan status berat badan berlebih (overweight).',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Denyut nadi maksimal saat berolahraga diperkirakan dengan rumus 220 dikurangi angka...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'umur',
      ),
    ),
  ),
  210 => 
  array (
    'judul' => 'Kuis Gerak Melingkar Beraturan (GMB) SMA',
    'deskripsi' => 'Kecepatan sudut omega, periode, frekuensi, dan percepatan sentripetal GMB SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 11,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Percepatan yang selalu mengarah ke pusat lingkaran dan berfungsi mengubah arah kecepatan linier benda dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Percepatan tangensial',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Percepatan sentripetal',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Percepatan gravitasi',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Percepatan sudut',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pada gerak melingkar beraturan, besar kelajuan linier benda konstan namun arah kecepatannya selalu berubah.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Hubungan antara kecepatan linier v, jari-jari r, dan kecepatan sudut omega dirumuskan v = omega dikali...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'r',
      ),
    ),
  ),
  211 => 
  array (
    'judul' => 'Evaluasi Usaha & Hukum Kekekalan Energi SMA',
    'deskripsi' => 'Hubungan gaya perpindahan W = F.s, energi potensial mgh, energi kinetik 1/2mv^2 SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 11,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sebuah benda bermassa 2 kg bergerak dengan kecepatan 10 m/s. Besar energi kinetik yang dimiliki benda tersebut adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '10 Joule',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '50 Joule',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '100 Joule',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '200 Joule',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pada sistem konservatif tanpa gesekan, jumlah total energi mekanik (Ep + Ek) selalu bernilai konstan kekal.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Energi potensial gravitasi suatu benda berbanding lurus dengan massa, percepatan gravitasi, dan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'ketinggian',
      ),
    ),
  ),
  212 => 
  array (
    'judul' => 'Kuis Impuls, Momentum & Tumbukan Lenting SMA',
    'deskripsi' => 'Hukum kekekalan momentum p = mv, impuls I = F.dt, koefisien restitusi tumbukan SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 11,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pada peristiwa tumbukan lenting sempurna antara dua benda, nilai koefisien restitusinya (e) adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'e = 0',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'e = 0,5',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'e = 1',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'e > 1',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Impuls didefinisikan sebagai perubahan momentum yang dialami oleh suatu benda.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Momentum suatu benda merupakan hasil perkalian antara massa benda dengan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'kecepatan',
      ),
    ),
  ),
  213 => 
  array (
    'judul' => 'Ulangan Fluida Statis: Archimedes & Pascal SMA',
    'deskripsi' => 'Tekanan hidrostatis p = rho.g.h, gaya apung Archimedes, tegangan permukaan kapilaritas SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 11,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Gaya ke atas yang dialami oleh benda yang tercelup ke dalam zat cair sama dengan berat zat cair yang dipindahkan menurut Hukum...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Boyle',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Archimedes',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Bernoulli',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Stokes',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Tekanan hidrostatis zat cair tidak dipengaruhi oleh bentuk dan luas penampang wadah penampungnya.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Peristiwa naik atau turunnya zat cair di dalam pipa kapiler yang sempit disebut fenomena...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'kapilaritas',
      ),
    ),
  ),
  214 => 
  array (
    'judul' => 'Latihan Suhu, Kalor & Asas Black Percampuran SMA',
    'deskripsi' => 'Kalor jenis Q = m.c.dT, kalor laten lebur uap, asas Black Q lepas = Q serap SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 11,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Prinsip fisika yang menyatakan bahwa kalor yang dilepaskan oleh benda bersuhu tinggi sama dengan kalor yang diserap benda dingin adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Hukum Stefan-Boltzmann',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Asas Black',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Hukum Joule',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Hukum Wien',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Kalor laten lebur adalah kalor yang diserap untuk mengubah wujud zat dari padat menjadi cair pada titik leburnya tanpa kenaikan suhu.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Perpindahan panas melalui pancaran gelombang elektromagnetik tanpa memerlukan zat perantara disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'radiasi',
      ),
    ),
  ),
  215 => 
  array (
    'judul' => 'Tantangan Gaya Coulomb & Potensial Elektrostatik SMA',
    'deskripsi' => 'Hukum Coulomb F = k.q1.q2/r^2, kuat medan listrik E, energi potensial muatan SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 11,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Jika jarak antara dua muatan listrik sejenis diperbesar menjadi 2 kali lipat dari semula, maka gaya tolak-menolak Coulomb menjadi...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '2 kali semula',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '1/2 kali semula',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '1/4 kali semula',
            'is_correct' => true,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '4 kali semula',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Garis-garis medan listrik selalu keluar mengarah menjauhi muatan positif dan masuk menuju muatan negatif.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Satuan internasional (SI) untuk mengukur besaran muatan listrik adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'coulomb',
      ),
    ),
  ),
  216 => 
  array (
    'judul' => 'Uji Induksi Elektromagnetik & Hukum Faraday SMA',
    'deskripsi' => 'Fluks magnetik, GGL induksi Faraday epsilon = -N.dPhi/dt, hukum Lenz, transformator SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 11,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Timbulnya gaya gerak listrik (GGL) induksi pada kumparan terjadi karena adanya perubahan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Kuat arus konstan',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Fluks magnetik yang melingkupi kumparan',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Hambatan kawat penghantar',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Suhu lingkungan',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Transformator step-up memiliki jumlah lilitan kumparan sekunder yang lebih banyak dibandingkan lilitan primer.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Arah arus induksi selalu melawan arah perubahan fluks magnetik penyebabnya sesuai dengan Hukum...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'lenz',
      ),
    ),
  ),
  217 => 
  array (
    'judul' => 'Kuis Teori Model Atom & Bilangan Kuantum SMA',
    'deskripsi' => 'Model Bohr spektrum garis, mekanika kuantum orbital, bilangan n l m s SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 12,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Bilangan kuantum yang menunjukkan bentuk orbital tempat peluang ditemukannya elektron adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Bilangan kuantum utama (n)',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Bilangan kuantum azimut (l)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Bilangan kuantum magnetik (m)',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Bilangan kuantum spin (s)',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Prinsip larangan Pauli menyatakan bahwa dalam satu atom tidak boleh ada dua elektron yang memiliki keempat bilangan kuantum sama persis.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Jumlah elektron maksimum yang dapat mengisi satu kamar orbital dengan spin berlawanan adalah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '2',
      ),
    ),
  ),
  218 => 
  array (
    'judul' => 'Evaluasi Tabel Periodik & Sifat Keperiodikan SMA',
    'deskripsi' => 'Jari-jari atom, energi ionisasi, afinitas elektron, keelektronegatifan unsur SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 12,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kecenderungan sifat unsur dalam satu golongan dari atas ke bawah pada tabel periodik adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Jari-jari atom semakin kecil',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Jari-jari atom semakin besar',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Energi ionisasi semakin besar',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Keelektronegatifan meningkat',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Unsur golongan gas mulia (golongan VIIIA) memiliki konfigurasi elektron kulit terluar stabil berisi 8 elektron (kaidah oktet).',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kemampuan suatu atom dalam senyawa untuk menarik pasangan elektron ikatan ke arah dirinya disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'keelektronegatifan',
      ),
    ),
  ),
  219 => 
  array (
    'judul' => 'Kuis Teori Domain Elektron & Bentuk Molekul SMA',
    'deskripsi' => 'VSEPR, PEI, PEB, bentuk linier, segitiga planar, tetrahedral, piramida trigonal SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 12,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Molekul metana (CH4) dengan 4 pasangan elektron ikatan dan tanpa pasangan elektron bebas memiliki bentuk molekul...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Linier',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Tetrahedral',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Segitiga datar',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Oktahedral',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Gaya tolakan antara pasangan elektron bebas (PEB) lebih kuat dibandingkan tolakan antar pasangan elektron ikatan (PEI).',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Molekul air (H2O) yang memiliki 2 PEI dan 2 PEB memiliki geometri bentuk molekul menyerupai huruf...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'v',
      ),
    ),
  ),
  220 => 
  array (
    'judul' => 'Ulangan Hukum Dasar Kimia & Perhitungan Mol SMA',
    'deskripsi' => 'Lavoisier kekekalan massa, Proust perbandingan tetap, Dalton, Avogadro 6,02x10^23 SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 12,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Hukum kimia yang menyatakan bahwa massa zat-zat sebelum dan sesudah reaksi dalam ruang tertutup adalah sama dikemukakan oleh...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'John Dalton',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Antoine Lavoisier',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Joseph Proust',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Gay-Lussac',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Satu mol gas ideal pada keadaan standar suhu dan tekanan (STP 0°C, 1 atm) memiliki volume tepat 22,4 liter.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Jumlah partikel dalam satu mol zat diukur sebesar bilangan Avogadro yaitu 6,02 dikali sepuluh pangkat...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '23',
      ),
    ),
  ),
  221 => 
  array (
    'judul' => 'Latihan Termokimia & Perhitungan Hukum Hess SMA',
    'deskripsi' => 'Reaksi eksoterm endoterm, entalpi pembentukan standar, siklus energi kalorimeter SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 12,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Ciri reaksi kimia yang tergolong reaksi eksoterm adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Menyerap kalor dari lingkungan ke sistem',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Membebaskan kalor sehingga suhu lingkungan naik dan delta H bernilai negatif',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Suhu lingkungan menjadi dingin',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Delta H bernilai positif',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Hukum Hess menyatakan bahwa perubahan entalpi reaksi hanya bergantung pada keadaan awal dan akhir reaksi, bukan pada jalannya reaksi.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Alat terisolasi yang digunakan di laboratorium untuk mengukur perubahan kalor suatu reaksi kimia disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'kalorimeter',
      ),
    ),
  ),
  222 => 
  array (
    'judul' => 'Tantangan Laju Reaksi & Faktor Suhu Konsentrasi SMA',
    'deskripsi' => 'Teori tumbukan efektif, energi aktivasi, luas permukaan, katalisator reaksi SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 12,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kenaikan suhu mempercepat laju reaksi kimia karena meningkatkan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Energi aktivasi reaksi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Energi kinetik partikel sehingga frekuensi tumbukan efektif bertambah',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Volume reaktan',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Jumlah pelarut',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Katalis mempercepat tercapainya kesetimbangan reaksi kimia dengan cara menurunkan energi aktivasi tanpa ikut habis bereaksi.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Batas energi minimal yang harus dimiliki partikel zat agar tumbukan dapat menghasilkan reaksi kimia disebut energi...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'aktivasi',
      ),
    ),
  ),
  223 => 
  array (
    'judul' => 'Uji Pergeseran Kesetimbangan Asas Le Chatelier SMA',
    'deskripsi' => 'Pengaruh konsentrasi, tekanan, volume, suhu pada pergeseran arah kesetimbangan SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 12,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Berdasarkan asas Le Chatelier, jika suhu suatu sistem reaksi kesetimbangan endoterm dinaikkan, maka kesetimbangan akan bergeser ke arah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Reaktan (kiri)',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Produk pembentukan (kanan)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Tidak bergeser',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Reaksi berhenti',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Penambahan tekanan pada sistem kesetimbangan gas akan menggeser arah kesetimbangan menuju sisi yang memiliki jumlah koefisien gas lebih kecil.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Prinsip penyesuaian sistem kesetimbangan terhadap gangguan dari luar dirumuskan oleh ilmuwan bernama Henri Le...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'chatelier',
      ),
    ),
  ),
  224 => 
  array (
    'judul' => 'Kuis Struktur Bakteriofag & Daur Litik Virus SMA',
    'deskripsi' => 'Kapsid protein, materi genetik DNA/RNA, daur litik lisogenik virus SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 13,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Selubung pembungkus materi genetik yang tersusun atas subunit protein pada partikel virus dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Kapsul lendir',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Kapsid',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Glikoprotein sel',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Dinding sel kitin',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pada siklus litik, reproduksi virus diakhiri dengan pecahnya (lisis) membran sel inang sehingga virus baru berhamburan keluar.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Virus yang khusus menginfeksi dan menghancurkan sel bakteri disebut virus bakterio-...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'fag',
      ),
    ),
  ),
  225 => 
  array (
    'judul' => 'Evaluasi Keanekaragaman Plantae Lumut & Paku SMA',
    'deskripsi' => 'Metagenesis pergiliran keturunan gametofit sporofit, spora, trakeofita SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 13,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Fase pergiliran keturunan (metagenesis) yang bersifat dominan dan hidup bebas pada tumbuhan lumut (Bryophyta) adalah fase...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Sporofit',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Gametofit',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Protalium',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Protonema sporogonium',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Tumbuhan paku (Pteridophyta) tergolong tumbuhan berpembuluh (Tracheophyta) karena telah memiliki jaringan xilem dan floem sejati.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kotak spora tempat pembentukan butir spora pada tumbuhan paku dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'sporangium',
      ),
    ),
  ),
  226 => 
  array (
    'judul' => 'Kuis Ciri Filum Hewan Avertebrata SMA',
    'deskripsi' => 'Porifera berpori, Coelenterata berongga, Annelida cincin, Arthropoda berbuku SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 13,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Hewan avertebrata yang tubuhnya berpori-pori halus dan hidup menetap (sesil) di dasar laut tergolong ke dalam filum...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Cnidaria',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Porifera',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Platyhelminthes',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Mollusca',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Filum Arthropoda memiliki ciri khas kaki beruas-ruas dan rangka luar (eksoskeleton) yang tersusun dari senyawa kitin.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Hewan lunak bertubuh basah seperti cumi-cumi, kerang, dan bekicot dikelompokkan ke dalam filum...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'mollusca',
      ),
    ),
  ),
  227 => 
  array (
    'judul' => 'Ulangan Rantai Makanan & Daur Biogeokimia SMA',
    'deskripsi' => 'Tingkat trofik produsen herbivora karnivora, daur karbon, nitrogen, fosfor SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 13,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Bakteri bintil akar leguminosa (Rhizobium) memegang peranan krusial dalam siklus daur biogeokimia unsur...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Fosfor',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Nitrogen',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Belerang (Sulfur)',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Karbon dioksida',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Piramida energi menggambarkan bahwa energi yang berpindah ke tingkat trofik di atasnya selalu berkurang karena hilang sebagai panas metabolisme.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Organisme yang menguraikan sisa-sisa bangkai dan sampah organik menjadi senyawa mineral tanah disebut dekomposer atau...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'pengurai',
      ),
    ),
  ),
  228 => 
  array (
    'judul' => 'Latihan Diferensiasi Jaringan Tumbuhan SMA',
    'deskripsi' => 'Meristem apikal kambium, parenkim spons palisade, xilem floem spons SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 13,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Jaringan pembuluh angkut pada batang tumbuhan yang bertugas mengangkut hasil fotosintesis dari daun ke seluruh bagian tanaman adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Xilem',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Floem',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Kambium gabus',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Kolenkim',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Jaringan parenkim palisade (jaringan tiang) pada daun mengandung banyak klorofil dan menjadi tempat utama fotosintesis.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Jaringan pembuluh yang mengangkut air dan mineral dari dalam tanah melalui akar menuju daun dinamakan jaringan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'xilem',
      ),
    ),
  ),
  229 => 
  array (
    'judul' => 'Tantangan Sirkulasi Darah & Golongan Darah SMA',
    'deskripsi' => 'Sistem peredaran darah ganda tertutup, aglutinogen eritrosit ABO, rhesus SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 13,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Seseorang yang memiliki golongan darah AB menurut sistem ABO memiliki karakteristik sel darah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Memiliki antibodi anti-A dan anti-B',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Memiliki antigen (aglutinogen) A dan B pada membran eritrositnya',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Tidak memiliki antigen A maupun B',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Dapat mendonorkan darah ke semua golongan tanpa reaksi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pembuluh nadi (arteri) mengalirkan darah keluar dari jantung dengan tekanan kuat dan denyut terasa di pergelangan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Komponen sel darah merah yang mengikat oksigen dan memberikan warna merah darah dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'hemoglobin',
      ),
    ),
  ),
  230 => 
  array (
    'judul' => 'Uji Regulasi Hormon Endokrin Manusia SMA',
    'deskripsi' => 'Insulin glukagon pankreas, tiroksin tiroid, adrenalin kelenjar adrenal SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 13,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Hormon yang disekresikan oleh pulau Langerhans pankreas untuk menurunkan kadar glukosa dalam darah adalah hormon...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Glukagon',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Insulin',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Adrenalin',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Tiroksin',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Kelenjar hipofisis (pituitari) dijuluki master of glands karena menghasilkan hormon pengatur aktivitas kelenjar endokrin lain.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kelenjar anak ginjal (adrenal) memproduksi hormon darurat yang memacu detak jantung saat terkejut yaitu hormon...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'adrenalin',
      ),
    ),
  ),
  231 => 
  array (
    'judul' => 'Kuis Masalah Kelangkaan & Biaya Peluang SMA',
    'deskripsi' => 'Kebutuhan tak terbatas sumber daya terbatas, opportunity cost pilihan ekonomi SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 14,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Nilai dari kesempatan atau alternatif terbaik berikutnya yang terpaksa dikorbankan saat memilih suatu keputusan ekonomi dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Biaya produksi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Biaya peluang (opportunity cost)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Biaya variabel',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Biaya marjinal',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Masalah kelangkaan timbul karena kebutuhan manusia tidak terbatas sementara alat pemuas kebutuhan jumlahnya terbatas.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Tiga masalah pokok ekonomi klasik mencakup produksi, konsumsi, dan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'distribusi',
      ),
    ),
  ),
  232 => 
  array (
    'judul' => 'Evaluasi Kurva Indiferensi & Hukum Gossen SMA',
    'deskripsi' => 'Hukum Gossen I kepuasan menurun, Gossen II berbagai kebutuhan seimbang, utilitas SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 14,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kurva yang menggambarkan berbagai kombinasi pilihan konsumsi dua macam barang yang memberikan tingkat kepuasan yang sama bagi konsumen adalah kurva...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Permintaan',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Indiferensi (indifference curve)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Isoquant',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Lorenz',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Hukum Gossen I menyatakan bahwa pemenuhan kebutuhan atas satu macam barang secara terus-menerus akan menghasilkan kenikmatan yang semakin berkurang.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Tambahan kepuasan yang dinikmati konsumen akibat menambah konsumsi satu unit barang dinamakan marginal...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'utility',
      ),
    ),
  ),
  233 => 
  array (
    'judul' => 'Kuis Koefisien Elastisitas Harga Permintaan SMA',
    'deskripsi' => 'Elastis Ed > 1, inelastis Ed < 1, uniter Ed = 1, elastis sempurna SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 14,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Jika persentase perubahan jumlah barang yang diminta lebih kecil dibanding persentase perubahan harga barang tersebut (Ed < 1), maka sifat permintaannya adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Elastis',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Inelastis',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Elastis uniter',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Elastis sempurna',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Barang-barang kebutuhan pokok pokok sehari-hari seperti beras dan garam umumnya memiliki koefisien elastisitas permintaan yang inelastis.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Permintaan yang memiliki nilai koefisien elastisitas tepat sama dengan satu disebut permintaan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'uniter',
      ),
    ),
  ),
  234 => 
  array (
    'judul' => 'Ulangan Kebijakan Moneter & Pengendalian Inflasi SMA',
    'deskripsi' => 'Operasi pasar terbuka, politik diskonto BI, cadangan kas minimum giro wajib SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 14,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kebijakan Bank Indonesia mengendalikan jumlah uang beredar dengan cara menaikkan atau menurunkan tingkat suku bunga acuan bank dinamakan politik...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Pasar terbuka',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Diskonto',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Cadangan kas minimum',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Kredit selektif',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Kenaikan harga barang dan jasa secara umum serta berlangsung terus menerus dalam jangka waktu tertentu disebut inflasi.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Bank sentral Republik Indonesia yang memiliki wewenang tunggal mengeluarkan dan mengedarkan uang rupiah adalah Bank...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'indonesia',
      ),
    ),
  ),
  235 => 
  array (
    'judul' => 'Latihan Struktur APBN & Penerimaan Pajak SMA',
    'deskripsi' => 'Pajak langsung PPh, PBB, PPN, belanja modal daerah, defisit anggaran SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 14,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sumber penerimaan terbesar dalam Anggaran Pendapatan dan Belanja Negara (APBN) Republik Indonesia berasal dari pos...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Pinjaman luar negeri',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Penerimaan perpajakan dalam negeri',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Pencetakan uang baru',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Laba BUMN saja',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Kondisi di mana total rencana pengeluaran belanja negara melebihi total rencana penerimaan negara dinamakan anggaran defisit.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pungutan wajib dari warga negara kepada kas negara berdasarkan undang-undang tanpa kontraprestasi langsung disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'pajak',
      ),
    ),
  ),
  236 => 
  array (
    'judul' => 'Tantangan Persamaan Dasar Akuntansi Neraca SMA',
    'deskripsi' => 'Rumus Aset = Liabilitas + Ekuitas, pengaruh transaksi modal, beban, pendapatan SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 14,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Rumus persamaan dasar akuntansi yang benar dan baku adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Aset = Liabilitas - Ekuitas',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Aset = Liabilitas + Ekuitas (Modal)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Aset + Liabilitas = Ekuitas',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Aset = Modal - Beban',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pengambilan uang perusahaan oleh pemilik modal untuk keperluan pribadi (prive) akan mengurangi jumlah ekuitas modal pemilik.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kewajiban atau utang masa kini perusahaan yang timbul dari peristiwa masa lalu dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'liabilitas',
      ),
    ),
  ),
  237 => 
  array (
    'judul' => 'Uji Jurnal Umum & Posting Buku Besar Akuntansi SMA',
    'deskripsi' => 'Debet kredit akun kas piutang utang modal beban, saldo normal akun SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 14,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Transaksi pelunasan utang usaha secara tunai dicatat pada jurnal umum dengan mendebet akun...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Kas',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Utang Usaha',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Modal Pemilik',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Piutang Usaha',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Akun-akun kelompok aset dan beban memiliki saldo normal di sebelah debit.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Proses memindahkan catatan transaksi dari jurnal umum ke akun masing-masing di buku besar dinamakan proses...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'posting',
      ),
    ),
  ),
  238 => 
  array (
    'judul' => 'Kuis 10 Konsep Esensial Geografi SMA',
    'deskripsi' => 'Lokasi absolut relatif, jarak, keterjangkauan, pola, aglomerasi, diferensiasi area SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 15,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Konsep geografi yang mengkaji kecenderungan pengelompokan fenomena aktivitas penduduk di suatu tempat, seperti kawasan industri terpadu adalah konsep...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Morfologi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Aglomerasi',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Interaksi spasial',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Keterjangkauan',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Lokasi absolut suatu wilayah ditentukan berdasarkan garis lintang dan garis bujur astronomis.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kemudahan akses transportasi untuk menjangkau suatu wilayah dalam konsep esensial geografi dinamakan konsep...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'keterjangkauan',
      ),
    ),
  ),
  239 => 
  array (
    'judul' => 'Evaluasi Tenaga Endogen: Tektonisme & Seisme SMA',
    'deskripsi' => 'Orogenesa patahan lipatan, gempa tektonik episentrum, skala Richter hiposentrum SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 15,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Titik pusat pelepasan gelombang gempa bumi yang terletak tepat di permukaan bumi tegak lurus di atas sumber gempa disebut...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Hiposentrum',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Episentrum',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Makroseisma',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Isoseista',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Gerakan tektonisme pembentuk pegunungan lipatan dan patahan dalam waktu relatif cepat dan area sempit disebut gerak orogenesa.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pusat sumber gempa bumi yang terletak di dalam lapisan kerak bumi di bawah tanah dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'hiposentrum',
      ),
    ),
  ),
  240 => 
  array (
    'judul' => 'Kuis Pelapukan & Profil Lapisan Tanah Pedosfer SMA',
    'deskripsi' => 'Pelapukan mekanik kimiawi organik, horizon O A B C tanah, upaya terasering SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 15,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Metode pengawetan tanah pada lereng perbukitan miring dengan membuat sengkedan berundak bertingkat dinamakan teknik...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Reboisasi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Terasering (sengkedan)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Crop rotation',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Mulching',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Horizon A pada profil penampang tanah merupakan lapisan atas (topsoil) yang kaya akan zat organik humus subur.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Penanaman kembali hutan yang gundul untuk mencegah bencana tanah longsor dan erosi tanah disebut...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'reboisasi',
      ),
    ),
  ),
  241 => 
  array (
    'judul' => 'Ulangan Dinamika Hidrosfer & Pola Aliran Sungai SMA',
    'deskripsi' => 'Pola dendritik trelis radial sentrifugal, meander danau tapal kuda oxbow lake SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 15,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pola aliran sungai yang percabangannya menyerupai ranting-ranting pohon dan berkembang pada batuan homogen adalah pola...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Trellis',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Dendritik',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Radial sentrifugal',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Rektangular',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Danau tapal kuda (oxbow lake) terbentuk pada aliran sungai bagian hilir akibat proses pengendapan pemotongan meander yang berkelok.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pola aliran sungai yang menyebar keluar meninggalkan puncak gunung kerucut dinamakan pola radial...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'sentrifugal',
      ),
    ),
  ),
  242 => 
  array (
    'judul' => 'Latihan Persebaran Bioma Flora Fauna Dunia SMA',
    'deskripsi' => 'Tundra es, taiga konifer, padang rumput stepa, sabana tropis, hutan hujan ekuator SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 15,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Bioma yang didominasi oleh hutan pohon berdaun jarum (konifer) seperti pinus dan cemara di wilayah beriklim dingin boreal dinamakan bioma...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Tundra',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Taiga',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Sabana',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Stepa',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Bioma tundra ditandai dengan vegetasi lumut dan semak kerdil serta tanah lapisan es beku abadi (permafrost).',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Padang rumput luas di daerah tropis yang diselingi oleh kelompok semak dan pepohonan dinamakan bioma...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'sabana',
      ),
    ),
  ),
  243 => 
  array (
    'judul' => 'Tantangan Sumber Daya Tambang Strategis Indonesia SMA',
    'deskripsi' => 'Minyak bumi, gas alam, nikel Sulawesi, timah Bangka, batu bara Kalimantan SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 15,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pulau di Indonesia yang terkenal memiliki cadangan endapan bijih nikel terbesar dan menjadi pusat hilirisasi baterai adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Pulau Bangka',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Pulau Sulawesi',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Pulau Madura',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Pulau Bali',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Minyak bumi dan gas alam tergolong sebagai sumber daya alam strategis (Golongan A) yang tidak dapat diperbarui.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pulau penghasil tambang timah terbesar di kepulauan Indonesia adalah Pulau...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'bangka',
      ),
    ),
  ),
  244 => 
  array (
    'judul' => 'Uji Mitigasi Bencana Alam Likuifaksi & Tsunami SMA',
    'deskripsi' => 'Gejala likuifaksi tanah tanah bergerak, early warning tsunami, jalur evakuasi SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 15,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Fenomena hilangnya kekuatan lapisan tanah berpasir jenuh air saat diguncang gempa dahsyat sehingga tanah berubah menjadi lumpur cair dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Erosi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Likuifaksi (pencairan tanah)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Abrasi',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Sedimentasi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Tanda-tanda alam sebelum tsunami biasanya diawali dengan gempa bumi kuat dangkal dan surutnya air laut pesisir secara mendadak.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Lembaga pemerintah nonkementerian di Indonesia yang bertugas khusus mengoordinasikan penanggulangan bencana disingkat...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'bnpb',
      ),
    ),
  ),
  245 => 
  array (
    'judul' => 'Kuis Interaksi Sosial Asosiatif Kerjasama SMA',
    'deskripsi' => 'Kooperasi bargaining koalisi joint venture, akomodasi kompromi mediasi arbitrase SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 16,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Bentuk akomodasi penyelesaian sengketa di mana kedua belah pihak sepakat menunjuk pihak ketiga yang netral untuk mengambil keputusan mengikat dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Mediasi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Arbitrase',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Kompromi',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Ajudikasi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Koalisi merupakan bentuk kerjasama antara dua organisasi atau lebih yang menggabungkan kekuatan untuk mencapai tujuan politik tertentu.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Penyelesaian sengketa hukum antarpihak yang dilaksanakan melalui meja hijau peradilan formal dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'ajudikasi',
      ),
    ),
  ),
  246 => 
  array (
    'judul' => 'Evaluasi Proses Interaksi Sosial Disosiatif SMA',
    'deskripsi' => 'Kompetisi persaingan sehat, kontravensi penolakan tersembunyi, konflik kekerasan SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 16,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Bentuk proses sosial yang berada di antara persaingan dan pertentangan yang ditandai oleh perasaan tidak suka, keraguan, dan kebencian tersembunyi adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Kompetisi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Kontravensi',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Akulturasi',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Asimilasi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Persaingan atau kompetisi yang sportif dapat mendorong peningkatan prestasi dan efisiensi kerja individu.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pertentangan antarpihak yang disertai ancaman, bentrokan fisik, atau kekerasan dinamakan peristiwa...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'konflik',
      ),
    ),
  ),
  247 => 
  array (
    'judul' => 'Kuis Norma Kelakuan Mores & Adat Istiadat SMA',
    'deskripsi' => 'Cara usage, kebiasaan folkways, tata kelakuan mores, adat istiadat customs sanksi SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 16,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Norma masyarakat yang memiliki daya ikat paling kuat dan jika dilanggar pelakunya akan mendapat sanksi adat berat adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Cara (Usage)',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Adat istiadat (Customs)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Kebiasaan (Folkways)',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Mode tren',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Mores (tata kelakuan) merupakan aturan pergaulan yang dijadikan alat pengawas tingkah laku anggota masyarakat.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Norma sosial yang mengatur kebiasaan berulang-ulang yang dilakukan secara sadar seperti mengetuk pintu dinamakan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'folkways',
      ),
    ),
  ),
  248 => 
  array (
    'judul' => 'Ulangan Teori Labeling & Perilaku Menyimpang SMA',
    'deskripsi' => 'Edwin Lemert labeling primer sekunder, konformitas, diferensial asosiasi Sutherland SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 16,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Teori yang menyatakan bahwa penyimpangan sosial terjadi karena masyarakat memberikan julukan (cap negatif) berulang kepada seseorang adalah teori...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Anomi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Labeling (pemberian cap)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Konflik kelas',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Sosialisasi tidak sempurna',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Penyimpangan primer adalah penyimpangan yang sifatnya sementara dan pelakunya masih dapat diterima oleh masyarakat umum.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kondisi di mana masyarakat kehilangan pegangan norma atau terjadi kekosongan aturan moral dinamakan kondisi...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'anomi',
      ),
    ),
  ),
  249 => 
  array (
    'judul' => 'Latihan Pengendalian Sosial Preventif Represif SMA',
    'deskripsi' => 'Pengendalian preventif cegah, represif tindak, persuasif ajak, koersif paksa hukum SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 16,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Upaya pengendalian sosial yang dilakukan oleh aparat atau keluarga sebelum terjadinya tindakan penyimpangan dinamakan pengendalian...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Represif',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Preventif',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Kuratif',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Koersif',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pengendalian sosial secara koersif dilakukan dengan menggunakan unsur kekerasan atau paksaan fisik berdasar hukum.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Desas-desus atau kabar angin yang menyebar di masyarakat yang berfungsi mengontrol perilaku seseorang disebut kabar...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'gosip',
      ),
    ),
  ),
  250 => 
  array (
    'judul' => 'Tantangan Saluran Mobilitas Sosial Pendidikan SMA',
    'deskripsi' => 'Social elevator sekolah, partai politik, angkatan bersenjata, profesi mobilitas SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 16,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Saluran mobilitas sosial vertikal naik yang paling terbuka dan dianggap sebagai elevator sosial terbaik bagi seluruh lapisan rakyat adalah lembaga...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Keluarga feodal',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Pendidikan formal (sekolah)',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Ikatan kesukuan',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Klub hobi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Mobilitas sosial horizontal adalah perpindahan status sosial seseorang menuju kelompok baru yang berderajat sama tanpa perubahan kasta.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Perpindahan status sosial seseorang dari kedudukan terpandang menuju tingkatan yang lebih rendah dinamakan social...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'sinking',
      ),
    ),
  ),
  251 => 
  array (
    'judul' => 'Uji Pemberdayaan Komunitas Berbasis Tradisi SMA',
    'deskripsi' => 'Kearifan lokal Subak Bali, Pranoto Mongso Jawa, kemandirian adat partisipatif SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 16,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Sistem tata kelola pembagian air irigasi persawahan tradisional berbasis kearifan lokal di Pulau Bali dinamakan sistem...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Subak',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Pranoto mongso',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Huma ladang',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Pasar apung',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pemberdayaan komunitas lokal bertujuan menumbuhkan kemandirian ekonomi dan melestarikan nilai budaya luhur setempat.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Sikap menolak dan meremehkan produk atau kebudayaan sendiri demi memuja budaya asing dinamakan krisis...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'identitas',
      ),
    ),
  ),
  252 => 
  array (
    'judul' => 'Kuis Prasasti Yupa Kerajaan Kutai SD',
    'deskripsi' => 'Prasasti tiang batu huruf Pallawa, sedekah 20.000 ekor sapi Raja Mulawarman SD.',
    'id_jenjang' => 1,
    'id_mapel' => 17,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Kerajaan Hindu tertua di kepulauan Nusantara yang terletak di tepi Sungai Mahakam Kalimantan Timur adalah Kerajaan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Tarumanegara',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Kutai Kartanegara',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Majapahit',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Singasari',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Prasasti Yupa berbentuk tugu atau tiang batu bertuliskan huruf Pallawa peninggalan Raja Mulawarman.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Nama raja terbesar Kerajaan Kutai yang menyedekahkan 20.000 ekor sapi adalah Raja...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'mulawarman',
      ),
    ),
  ),
  253 => 
  array (
    'judul' => 'Evaluasi Pahlawan Maluku Kapitan Pattimura SD',
    'deskripsi' => 'Perlawanan Thomas Matulessy di Benteng Duurstede Saparua Maluku SD.',
    'id_jenjang' => 1,
    'id_mapel' => 17,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Nama asli pahlawan nasional dari Maluku yang bergelar Kapitan Pattimura adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Thomas Matulessy',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Martha Christina Tiahahu',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Sultan Baabullah',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Johannes Leimena',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Kapitan Pattimura memimpin rakyat Maluku merebut Benteng Duurstede dari tangan penjajah Belanda pada 1817.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pahlawan remaja perempuan dari tanah Maluku yang turut berjuang mendampingi Pattimura adalah Martha Christina...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'tiahahu',
      ),
    ),
  ),
  254 => 
  array (
    'judul' => 'Kuis Kongres Perempuan & Hari Ibu SD',
    'deskripsi' => 'Kongres Perempuan I Yogyakarta 1928, perjuangan Dewi Sartika, R.A. Kartini SD.',
    'id_jenjang' => 1,
    'id_mapel' => 17,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Peringatan Hari Ibu di Indonesia setiap tanggal 22 Desember ditetapkan berdasarkan peristiwa bersejarah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Kelahiran R.A. Kartini',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Kongres Perempuan Indonesia I tahun 1928 di Yogyakarta',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Proklamasi Kemerdekaan',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Sumpah Pemuda',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'R.A. Kartini menulis surat-surat perjuangan emansipasi perempuan yang dibukukan dengan judul "Habis Gelap Terbitlah Terang".',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Tokoh pejuang perempuan dari Jawa Barat yang mendirikan sekolah Sakola Istri adalah Dewi...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'sartika',
      ),
    ),
  ),
  255 => 
  array (
    'judul' => 'Ulangan Tokoh Perumus Naskah Pancasila SD',
    'deskripsi' => 'Usulan dasar negara Muh. Yamin, Soepomo, dan Ir. Soekarno pada 1 Juni 1945 SD.',
    'id_jenjang' => 1,
    'id_mapel' => 17,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Ir. Soekarno pertama kali menyampaikan pidato rumusan lima asas dasar negara Pancasila pada tanggal...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => '29 Mei 1945',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => '1 Juni 1945',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => '22 Juni 1945',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => '17 Agustus 1945',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Naskah Piagam Jakarta (Jakarta Charter) dirumuskan oleh Panitia Sembilan pada tanggal 22 Juni 1945.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Hari Lahir Pancasila diperingati bangsa Indonesia setiap tanggal 1 bulan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'juni',
      ),
    ),
  ),
  256 => 
  array (
    'judul' => 'Latihan Sketsa Lambang Garuda Pancasila SD',
    'deskripsi' => 'Rancangan Sultan Hamid II, perisai simbol, cengkeraman pita semboyan SD.',
    'id_jenjang' => 1,
    'id_mapel' => 17,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Tokoh yang merancang sketsa awal lambang negara Garuda Pancasila adalah putra bangsa dari Pontianak yaitu...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Ki Hajar Dewantara',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Sultan Hamid II',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Mohammad Yamin',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'A.G. Pringgodigdo',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Jumlah helai bulu pada kedua sayap Garuda Pancasila masing-masing berjumlah 17 helai melambangkan tanggal kemerdekaan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Jumlah helai bulu pada bagian leher burung Garuda Pancasila berjumlah... helai.',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '45',
      ),
    ),
  ),
  257 => 
  array (
    'judul' => 'Tantangan Sejarah Lagu Indonesia Raya SD',
    'deskripsi' => 'W.R. Supratman, gesekan biola Kongres Pemuda II, sikap berdiri tegap SD.',
    'id_jenjang' => 1,
    'id_mapel' => 17,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Lagu kebangsaan Indonesia Raya pertama kali diperdengarkan kepada khalayak pada peristiwa...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Proklamasi 1945',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Kongres Pemuda II tahun 1928',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Rengasdengklok',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Sidang BPUPKI',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Wage Rudolf Supratman memperkenalkan lagu Indonesia Raya dengan memainkan alunan instrumen biola.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Ketika lagu kebangsaan Indonesia Raya dikumandangkan, kita wajib berdiri dengan sikap...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'sempurna',
      ),
    ),
  ),
  258 => 
  array (
    'judul' => 'Uji Pengibaran Bendera Pusaka 1945 SD',
    'deskripsi' => 'Jahitan Ibu Fatmawati, tiang bambu Pegangsaan, Latief Hendraningrat, Suhud SD.',
    'id_jenjang' => 1,
    'id_mapel' => 17,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 20,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Bendera pusaka Merah Putih yang pertama kali dikibarkan pada detik-detik Proklamasi dijahit langsung oleh...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Ibu Fatmawati',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Ibu Kartini',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Ibu Tien Soeharto',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Ibu Rasuna Said',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Tokoh pemuda yang bertindak sebagai komandan upacara pengibar bendera pada 17 Agustus 1945 adalah Latief Hendraningrat.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Pembacaan teks proklamasi kemerdekaan Indonesia berlangsung pada hari...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'jumat',
      ),
    ),
  ),
  259 => 
  array (
    'judul' => 'Kuis Monopoli VOC & Jalan Raya Pos Daendels SMP',
    'deskripsi' => 'Hak oktroi VOC Batavia, kebangkrutan 1799, pembuatan jalan Anyer Panarukan SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 17,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Gubernur Jenderal Hindia Belanda yang memerintahkan pembangunan proyek kerja paksa Jalan Raya Pos (Anyer hingga Panarukan) adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Van den Bosch',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Herman Willem Daendels',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Jan Pieterszoon Coen',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Thomas Stamford Raffles',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'VOC dibubarkan pada tanggal 31 Desember 1799 karena terlilit utang besar dan korupsi yang meluas di kalangan pegawainya.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Hak-hak istimewa yang dimiliki kongsi dagang VOC dari pemerintah kerajaan Belanda disebut hak...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'oktroi',
      ),
    ),
  ),
  260 => 
  array (
    'judul' => 'Evaluasi Perang Padri & Perang Jawa Diponegoro SMP',
    'deskripsi' => 'Kaum Padri Tuanku Imam Bonjol, benteng stelsel De Kock, perang gerilya Jawa SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 17,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Taktik militer yang diterapkan Jenderal De Kock untuk mempersempit ruang gerak pasukan Pangeran Diponegoro adalah taktik...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Supit Urang',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Benteng Stelsel',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Devide et Impera',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Perang Gerilya',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Perang Padri di Sumatera Barat awalnya dipicu oleh perselisihan pemurnian ajaran antara Kaum Padri dan Kaum Adat.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Perang Jawa yang dipimpin Pangeran Diponegoro melawan pemerintah kolonial Belanda berlangsung dari tahun 1825 hingga...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => '1830',
      ),
    ),
  ),
  261 => 
  array (
    'judul' => 'Kuis Perang Puputan Bali & Perang Banjar SMP',
    'deskripsi' => 'Pangeran Antasari Banjar, hak tawan karang kapal Belanda, Puputan Jagaraga SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 17,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Tradisi raja-raja di Bali untuk menguasai kapal asing yang terdampar di pesisir wilayah perairannya dinamakan hak...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Hak Oktroi',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Hak Tawan Karang',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Hak Ulayat',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Hak Ekstirpasi',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Perang Puputan di Bali bermakna pertempuran habis-habisan sampai tetes darah penghabisan demi menjaga kehormatan kerajaan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Semboyan perjuangan heroik Pangeran Antasari dalam Perang Banjar berbunyi "Haram Manyarah Waja Sampai..."',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'kaputing',
      ),
    ),
  ),
  262 => 
  array (
    'judul' => 'Ulangan Sarekat Islam & Indische Partij SMP',
    'deskripsi' => 'SDI Samanhudi Solo, Tjokroaminoto, Tiga Serangkai Douwes Dekker Ki Hajar Tjipto SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 17,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Organisasi pergerakan politik pertama di Hindia Belanda yang secara tegas menuntut kemerdekaan adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Budi Utomo',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Indische Partij',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Sarekat Islam',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Perhimpunan Indonesia',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'H.O.S. Tjokroaminoto dikenal sebagai guru para tokoh bangsa sekaligus pemimpin besar Sarekat Islam.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Tiga tokoh pendiri Indische Partij dikenal luas di kalangan sejarah pergerakan dengan julukan Tiga...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'serangkai',
      ),
    ),
  ),
  263 => 
  array (
    'judul' => 'Latihan Perhimpunan Indonesia & Manifesto Politik SMP',
    'deskripsi' => 'Kiprah Mohammad Hatta di Belanda, nama Indonesia merdeka, manifesto 1925 SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 17,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Organisasi pelajar mahasiswa Indonesia di Belanda yang memelopori penggunaan nama "Indonesia" di kancah internasional adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Indische Vereeniging / Perhimpunan Indonesia',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Indische Partij',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Gerakan Pemuda',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Jong Java',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Manifesto Politik tahun 1925 yang dikeluarkan Perhimpunan Indonesia menegaskan prinsip kesatuan nasional, kemandirian, dan non-kooperasi.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Majalah propaganda perjuangan yang diterbitkan oleh Perhimpunan Indonesia berjudul...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'indonesia merdeka',
      ),
    ),
  ),
  264 => 
  array (
    'judul' => 'Tantangan Piagam Jakarta & Perubahan Sila Pertama SMP',
    'deskripsi' => 'Rancangan Mukadimah, 22 Juni 1945, kompromi tokoh Islam dan Kristen kawasan timur SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 17,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pernyataan pada sila pertama Piagam Jakarta yang disepakati untuk diubah demi persatuan bangsa adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Kemanusiaan yang adil',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Ketuhanan dengan kewajiban menjalankan syariat Islam bagi pemeluk-pemeluknya',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Persatuan Indonesia',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Keadilan sosial',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Perubahan tujuh kata pada sila pertama Piagam Jakarta menjadi "Ketuhanan Yang Maha Esa" disepakati pada sidang PPKI 18 Agustus 1945.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Ketua Panitia Sembilan yang memimpin perumusan Piagam Jakarta adalah Ir....',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'soekarno',
      ),
    ),
  ),
  265 => 
  array (
    'judul' => 'Uji Palagan Ambarawa & Pertempuran Medan Area SMP',
    'deskripsi' => 'Taktik Supit Urang Sudirman Ambarawa, perlawanan pemuda Medan Area Sekutu SMP.',
    'id_jenjang' => 2,
    'id_mapel' => 17,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 25,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Taktik pengepungan rangkap yang diterapkan oleh Kolonel Soedirman dalam memenangkan pertempuran Palagan Ambarawa dinamakan taktik...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Benteng Stelsel',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Gelar Supit Urang',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Perang Gerilya Semesta',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Bumi Hangus',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Kemenangan pejuang TKR dalam Palagan Ambarawa kini diperingati setiap tahun sebagai Hari Juang Kartika TNI AD.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Hari Juang Kartika TNI AD yang merujuk pada kemenangan pertempuran Palagan Ambarawa diperingati setiap tanggal 15...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'desember',
      ),
    ),
  ),
  266 => 
  array (
    'judul' => 'Kuis Manusia Purba & Artefak Pleistosen SMA',
    'deskripsi' => 'Pithecanthropus Trinil Dubois, Meganthropus Sangiran Von Koenigswald, kapak perimbas SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 17,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Fosil manusia purba bertubuh raksasa tertua di Pulau Jawa yang ditemukan oleh Von Koenigswald di Sangiran dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Homo soloensis',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Meganthropus paleojavanicus',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Pithecanthropus erectus',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Homo wajakensis',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Situs Sangiran di Jawa Tengah telah ditetapkan oleh UNESCO sebagai situs warisan dunia peninggalan manusia purba.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Fosil Pithecanthropus erectus (manusia kera berjalan tegak) pertama kali ditemukan di lembah Bengawan Solo daerah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'trinil',
      ),
    ),
  ),
  267 => 
  array (
    'judul' => 'Evaluasi Jalur Sutra Maritim & Hubungan Dagang India SMA',
    'deskripsi' => 'Teori Brahmana Ksatria Waisya Arus Balik, pengaruh candi Hindu-Buddha SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 17,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Teori masuknya pengaruh agama Hindu ke Nusantara yang menyatakan bahwa pemuda bangsawan Indonesia sendiri yang menuntut ilmu ke India lalu menyebarkannya adalah teori...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Brahmana',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Waisya',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Ksatria',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Arus Balik (F.D.K. Bosch)',
            'is_correct' => true,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Bangunan candi Borobudur mengadopsi akulturasi seni arsitektur India dengan tradisi asli megalitikum punden berundak di Nusantara.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Teori yang berpendapat bahwa agama Hindu disebarkan ke Indonesia oleh golongan rohaniwan pendeta disebut teori...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'brahmana',
      ),
    ),
  ),
  268 => 
  array (
    'judul' => 'Kuis Ekspedisi Pamalayu & Kejayaan Nusantara SMA',
    'deskripsi' => 'Raja Kertanegara Singasari, Sumpah Palapa Patih Gajah Mada, armada laut Nusantara SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 17,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 1,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Ekspedisi militer dan persahabatan yang dikirim oleh Raja Kertanegara dari Singasari ke Pulau Sumatera pada tahun 1275 dikenal dengan sebutan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Ekspedisi Sumpah Palapa',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Ekspedisi Pamalayu',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Ekspedisi Samudra',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Ekspedisi Pasai',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Kitab Negarakertagama karangan Mpu Prapanca memuat catatan emas wilayah pengaruh kekuasaan kemaritiman Majapahit.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Patih Majapahit yang mengucapkan janji tidak akan memakan buah palapa sebelum menyatukan Nusantara adalah Patih Gajah...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'mada',
      ),
    ),
  ),
  269 => 
  array (
    'judul' => 'Ulangan Pendudukan Jepang & Organisasi PETA SMA',
    'deskripsi' => 'Romusha kerja paksa, eksploitasi beras padi, pemberontakan PETA Supriyadi Blitar SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 17,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Pemberontakan prajurit PETA melawan kesewenang-wenangan militer pendudukan Jepang yang dipimpin oleh Supriyadi meletus di kota...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Semarang',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Blitar',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Cirebon',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Tasikmalaya',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Organisasi militer sukarela Pembela Tanah Air (PETA) dibentuk Jepang untuk membantu pertahanan pulau dari serangan Sekutu.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Kerja paksa massal rakyat pada masa pendudukan militer Jepang yang memakan ribuan korban jiwa dinamakan sistem...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'romusha',
      ),
    ),
  ),
  270 => 
  array (
    'judul' => 'Latihan Agresi Militer Belanda & Serangan 1 Maret SMA',
    'deskripsi' => 'Agresi Militer I dan II, penahanan Soekarno Hatta di Bangka, Serangan Umum 1 Maret SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 17,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 30,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Serangan mendadak pejuang TNI pada 1 Maret 1949 di ibu kota Yogyakarta yang berhasil menguasai kota selama enam jam bertujuan untuk...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Menghancurkan istana Belanda',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Membuktikan kepada dunia internasional dan PBB bahwa TNI dan Republik Indonesia masih eksis',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Merebut lapangan udara Maguwo',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Menangkap van Mook',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Pemerintah Darurat Republik Indonesia (PDRI) dibentuk di Bukittinggi Sumatera Barat dipimpin oleh Sjafruddin Prawiranegara saat pemimpin RI ditawan.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Presiden Pemerintah Darurat Republik Indonesia (PDRI) yang menyelamatkan kedaulatan RI tahun 1948 adalah Sjafruddin...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'prawiranegara',
      ),
    ),
  ),
  271 => 
  array (
    'judul' => 'Tantangan Peristiwa Dekrit Presiden 5 Juli 1959 SMA',
    'deskripsi' => 'Kegagalan dewan Konstituante, kembali ke UUD 1945, pembubaran badan Konstituante SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 17,
    'id_tipequiz' => 1,
    'id_tingkatquiz' => 2,
    'mode_pengerjaan' => 'wayground',
    'durasi_total_menit' => NULL,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Latar belakang utama dikeluarkannya Dekrit Presiden pada 5 Juli 1959 oleh Presiden Soekarno adalah...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Kekalahan militer',
            'is_correct' => false,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Kegagalan Dewan Konstituante menyusun UUD baru untuk menggantikan UUDS 1950',
            'is_correct' => true,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Terjadinya krisis moneter',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Pembubaran partai politik',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Salah satu isi Dekrit Presiden 5 Juli 1959 adalah menetapkan berlakunya kembali UUD 1945 dan tidak berlakunya lagi UUDS 1950.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Badan hasil Pemilu 1955 yang bertugas menyusun undang-undang dasar baru dinamakan Dewan...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'konstituante',
      ),
    ),
  ),
  272 => 
  array (
    'judul' => 'Uji Peran Indonesia KTT Asia Afrika & GNB SMA',
    'deskripsi' => 'Dasasila Bandung 1955, pemrakarsa GNB Beograd 1961, penentang kolonialisme SMA.',
    'id_jenjang' => 3,
    'id_mapel' => 17,
    'id_tipequiz' => 2,
    'id_tingkatquiz' => 3,
    'mode_pengerjaan' => 'biasa',
    'durasi_total_menit' => 35,
    'token' => NULL,
    'proggressQuiz' => 'Tersedia',
    'opsi_preview' => 'lengkap',
    'soal' => 
    array (
      0 => 
      array (
        'jenis' => 'pilihan_ganda',
        'pertanyaan' => 'Konferensi Asia Afrika (KAA) yang diselenggarakan di Bandung pada tahun 1955 menghasilkan kesepakatan prinsip perdamaian yang dinamakan...',
        'poin' => 10,
        'durasi_detik' => 20,
        'pilihan' => 
        array (
          0 => 
          array (
            'label' => 'A',
            'teks_pilihan' => 'Dasasila Bandung',
            'is_correct' => true,
          ),
          1 => 
          array (
            'label' => 'B',
            'teks_pilihan' => 'Deklarasi Djuanda',
            'is_correct' => false,
          ),
          2 => 
          array (
            'label' => 'C',
            'teks_pilihan' => 'Piagam Jakarta',
            'is_correct' => false,
          ),
          3 => 
          array (
            'label' => 'D',
            'teks_pilihan' => 'Perjanjian Renville',
            'is_correct' => false,
          ),
        ),
      ),
      1 => 
      array (
        'jenis' => 'benar_salah',
        'pertanyaan' => 'Gerakan Non-Blok (GNB) dibentuk di Beograd pada 1961 sebagai sikap negara berkembang untuk tidak memihak Blok Barat maupun Blok Timur dalam Perang Dingin.',
        'poin' => 10,
        'durasi_detik' => 15,
        'jawaban_benar' => 'A',
      ),
      2 => 
      array (
        'jenis' => 'isian',
        'pertanyaan' => 'Gedung bersejarah di Kota Bandung tempat diselenggarakannya Konferensi Asia Afrika 1955 bernama Gedung...',
        'poin' => 15,
        'durasi_detik' => 20,
        'jawaban_benar' => 'merdeka',
      ),
    ),
  ),
);
    }
}

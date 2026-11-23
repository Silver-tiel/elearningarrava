<?php

namespace Database\Seeders\Dungeon;

class DungeonQuestionDatasetSd
{
    /**
     * Mengambil daftar soal dungeon jenjang SD per mapel.
     * Masing-masing mapel memiliki minimal 30 soal (10 Mudah, 10 Sedang, 10 Sulit).
     * (Matematika SD id=1 dan IPA SD id=4 sudah disediakan di DungeonSeeder utama masing-masing 60 soal).
     */
    public static function getQuestionsByMapel(): array
    {
        return [
            // -------------------------------------------------------------------------
            // MAPEL 2: BAHASA INDONESIA SD
            // -------------------------------------------------------------------------
            2 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Lawan kata (antonim) dari kata "tinggi" adalah...', 'ans' => 'Pendek', 'opts' => ['Besar', 'Pendek', 'Kecil', 'Luas']],
                ['t' => 'mudah', 'q' => 'Persamaan kata (sinonim) dari kata "pandai" adalah...', 'ans' => 'Pintar', 'opts' => ['Rajin', 'Pintar', 'Tekun', 'Cepat']],
                ['t' => 'mudah', 'q' => 'Tanda baca yang digunakan pada akhir kalimat berita adalah tanda...', 'ans' => 'Titik (.)', 'opts' => ['Koma (,)', 'Titik (.)', 'Tanya (?)', 'Seru (!)']],
                ['t' => 'mudah', 'q' => 'Kalimat tanya selalu diakhiri dengan tanda tanya (?).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Penulisan huruf kapital yang benar untuk nama kota adalah...', 'ans' => 'Surabaya', 'opts' => ['surabaya', 'Surabaya', 'SuraBaya', 'SURABAyA']],
                ['t' => 'mudah', 'q' => 'Kata dasar dari kata berimbuhan "bermain" adalah...', 'ans' => 'Main', 'opts' => ['Bermain', 'Main', 'Mainan', 'Permainan']],
                ['t' => 'mudah', 'q' => 'Dongeng yang menceritakan tentang kehidupan binatang yang berperilaku seperti manusia disebut...', 'ans' => 'Fabel', 'opts' => ['Legenda', 'Mite', 'Fabel', 'Sage']],
                ['t' => 'mudah', 'q' => 'Huruf pertama pada awal sebuah kalimat harus ditulis dengan huruf kapital.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Kata hubung yang menyatakan pilihan adalah...', 'ans' => 'Atau', 'opts' => ['Dan', 'Tetapi', 'Atau', 'Karena']],
                ['t' => 'mudah', 'q' => 'Kata sapaan yang sopan kepada seorang guru wanita adalah...', 'ans' => 'Ibu Guru', 'opts' => ['Ibu Guru', 'Nona', 'Adik', 'Kamu']],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Ibu membeli sayur di pasar. Pola kalimat tersebut adalah...', 'ans' => 'S-P-O-K', 'opts' => ['S-P-O', 'S-P-K', 'S-P-O-K', 'K-S-P-O']],
                ['t' => 'sedang', 'q' => 'Kata ulang "kupu-kupu" termasuk dalam jenis kata ulang...', 'ans' => 'Kata ulang utuh (dwilingga)', 'opts' => ['Kata ulang sebagian', 'Kata ulang utuh (dwilingga)', 'Kata ulang berubah bunyi', 'Kata ulang berimbuhan']],
                ['t' => 'sedang', 'q' => 'Buku itu sangat tebal, ... ia tetap membacanya sampai selesai. Konjungsi yang tepat adalah...', 'ans' => 'Namun', 'opts' => ['Sehingga', 'Namun', 'Karena', 'Supaya']],
                ['t' => 'sedang', 'q' => 'Ungkapan "panjang tangan" memiliki arti...', 'ans' => 'Suka mencuri', 'opts' => ['Suka menolong', 'Suka mencuri', 'Rajin bekerja', 'Suka memberi']],
                ['t' => 'sedang', 'q' => 'Ide pokok dalam sebuah paragraf biasanya terdapat pada...', 'ans' => 'Kalimat utama', 'opts' => ['Kalimat penjelas', 'Kalimat utama', 'Kalimat terakhir saja', 'Judul bacaan saja']],
                ['t' => 'sedang', 'q' => 'Penulisan kata baku yang benar di bawah ini adalah...', 'ans' => 'Apotek', 'opts' => ['Apotik', 'Apotek', 'Apotiek', 'Apothex']],
                ['t' => 'sedang', 'q' => 'Pernyataan yang sesuai fakta dapat dibuktikan kebenarannya secara nyata.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Puisi lama yang setiap baitnya terdiri dari empat baris dengan rima a-b-a-b disebut...', 'ans' => 'Pantun', 'opts' => ['Syair', 'Pantun', 'Gurindam', 'Soneta']],
                ['t' => 'sedang', 'q' => 'Imbuhan "pe-an" pada kata "penanaman" menyatakan makna...', 'ans' => 'Proses atau perbuatan', 'opts' => ['Alat', 'Tempat', 'Proses atau perbuatan', 'Hasil']],
                ['t' => 'sedang', 'q' => 'Ringkasan cerita yang memuat inti permasalahan dalam teks disebut...', 'ans' => 'Sinopsis', 'opts' => ['Amanat', 'Latar', 'Sinopsis', 'Alur']],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Kalimat efektif harus memiliki kelogisan bahasa, kehematan kata, dan ketegasan makna.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Manakah kalimat berikut yang merupakan kalimat majemuk bertingkat?', 'ans' => 'Adik menangis karena mainannya rusak', 'opts' => ['Ayah membaca koran dan ibu memasak', 'Adik menangis karena mainannya rusak', 'Budi pandai berhitung tetapi malas menulis', 'Ani menyapu halaman lalu menyiram bunga']],
                ['t' => 'sulit', 'q' => 'Pesan moral yang ingin disampaikan pengarang kepada pembaca dalam sebuah cerita disebut...', 'ans' => 'Amanat', 'opts' => ['Tema', 'Sudut pandang', 'Amanat', 'Perwatakan']],
                ['t' => 'sulit', 'q' => 'Berdasarkan letak kalimat utamanya, paragraf yang gagasan utamanya di awal disebut paragraf...', 'ans' => 'Deduktif', 'opts' => ['Induktif', 'Deduktif', 'Campuran', 'Naratif']],
                ['t' => 'sulit', 'q' => 'Majas yang membandingkan benda mati seolah-olah memiliki sifat seperti manusia disebut majas...', 'ans' => 'Personifikasi', 'opts' => ['Metafora', 'Hiperbola', 'Personifikasi', 'Litotes']],
                ['t' => 'sulit', 'q' => 'Teks yang berisi petunjuk langkah-langkah dalam membuat atau melakukan sesuatu secara berurutan disebut teks...', 'ans' => 'Prosedur', 'opts' => ['Deskripsi', 'Eksplanasi', 'Prosedur', 'Narasi']],
                ['t' => 'sulit', 'q' => 'Penggunaan tanda koma yang benar terdapat pada kalimat...', 'ans' => 'Ibu membeli apel, jeruk, dan mangga.', 'opts' => ['Ibu membeli apel jeruk, dan mangga.', 'Ibu membeli, apel, jeruk, dan mangga.', 'Ibu membeli apel, jeruk, dan mangga.', 'Ibu membeli apel jeruk dan, mangga.']],
                ['t' => 'sulit', 'q' => 'Peribahasa "Tong kosong nyaring bunyinya" bermakna...', 'ans' => 'Orang yang banyak bicara biasanya kurang berilmu', 'opts' => ['Orang pandai yang rendah hati', 'Orang yang banyak bicara biasanya kurang berilmu', 'Orang miskin yang banyak harta', 'Benda yang tidak terisi bunyinya keras']],
                ['t' => 'sulit', 'q' => 'Gaya bahasa yang melebih-lebihkan suatu hal dari kenyataan sebenarnya disebut majas...', 'ans' => 'Hiperbola', 'opts' => ['Personifikasi', 'Hiperbola', 'Ironi', 'Litotes']],
                ['t' => 'sulit', 'q' => 'Kata berimbuhan berikut yang bermakna "menyatakan saling melakukan perbuatan" adalah...', 'ans' => 'Bersalaman', 'opts' => ['Berpakaian', 'Bersalaman', 'Bersepeda', 'Bersenang-senang']],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 3: BAHASA INGGRIS SD
            // -------------------------------------------------------------------------
            3 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'What is the English word for "Buku"?', 'ans' => 'Book', 'opts' => ['Pencil', 'Book', 'Ruler', 'Bag']],
                ['t' => 'mudah', 'q' => 'What is the Indonesian word for "Apple"?', 'ans' => 'Apel', 'opts' => ['Jeruk', 'Mangga', 'Apel', 'Pisang']],
                ['t' => 'mudah', 'q' => 'The color of the sky on a sunny day is...', 'ans' => 'Blue', 'opts' => ['Red', 'Green', 'Blue', 'Yellow']],
                ['t' => 'mudah', 'q' => '"Good morning" in Indonesian means "Selamat pagi".', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'How do you say number 10 in English?', 'ans' => 'Ten', 'opts' => ['Five', 'Eight', 'Nine', 'Ten']],
                ['t' => 'mudah', 'q' => 'What is the plural form of "cat"?', 'ans' => 'Cats', 'opts' => ['Cats', 'Cates', 'Caties', 'Cat']],
                ['t' => 'mudah', 'q' => '"Thank you" is used to show gratitude.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Which animal can fly in the sky?', 'ans' => 'Bird', 'opts' => ['Cat', 'Bird', 'Fish', 'Cow']],
                ['t' => 'mudah', 'q' => 'What day comes after Monday?', 'ans' => 'Tuesday', 'opts' => ['Sunday', 'Tuesday', 'Wednesday', 'Friday']],
                ['t' => 'mudah', 'q' => '"My name is Budi" means "Nama saya adalah Budi".', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Choose the correct pronoun: "Siti is my sister. ... is nine years old."', 'ans' => 'She', 'opts' => ['He', 'She', 'It', 'They']],
                ['t' => 'sedang', 'q' => 'Choose the correct form: "They ... playing football in the field."', 'ans' => 'are', 'opts' => ['is', 'are', 'am', 'be']],
                ['t' => 'sedang', 'q' => 'What is the opposite of "Hot"?', 'ans' => 'Cold', 'opts' => ['Warm', 'Cold', 'Cool', 'Dry']],
                ['t' => 'sedang', 'q' => 'Which one is a vegetable?', 'ans' => 'Carrot', 'opts' => ['Mango', 'Banana', 'Carrot', 'Strawberry']],
                ['t' => 'sedang', 'q' => 'Complete the sentence: "An elephant has a ... body."', 'ans' => 'big', 'opts' => ['small', 'tiny', 'big', 'short']],
                ['t' => 'sedang', 'q' => 'How many months are there in a year?', 'ans' => 'Twelve', 'opts' => ['Ten', 'Eleven', 'Twelve', 'Seven']],
                ['t' => 'sedang', 'q' => 'Where do you sleep at night?', 'ans' => 'Bedroom', 'opts' => ['Kitchen', 'Bedroom', 'Bathroom', 'Garden']],
                ['t' => 'sedang', 'q' => '"He washes his hands before eating." The word "washes" is a verb.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'What is the English word for "Meja"?', 'ans' => 'Table', 'opts' => ['Chair', 'Table', 'Door', 'Window']],
                ['t' => 'sedang', 'q' => 'Choose the correct article: "I see ... elephant in the zoo."', 'ans' => 'an', 'opts' => ['a', 'an', 'the', 'some']],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'What is the past tense form of the verb "go"?', 'ans' => 'Went', 'opts' => ['Goes', 'Going', 'Went', 'Gone']],
                ['t' => 'sulit', 'q' => 'Complete: "She ... milk every morning."', 'ans' => 'drinks', 'opts' => ['drink', 'drinks', 'drinking', 'drank']],
                ['t' => 'sulit', 'q' => 'Which sentence is in the Simple Present Tense?', 'ans' => 'The sun rises in the east', 'opts' => ['I went to Bali yesterday', 'The sun rises in the east', 'He will come tomorrow', 'They were sleeping']],
                ['t' => 'sulit', 'q' => 'The comparative form of the adjective "fast" is "faster".', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'What does "Look out!" mean as an exclamation?', 'ans' => 'Be careful (Hati-hati)', 'opts' => ['Lihat ke luar', 'Be careful (Hati-hati)', 'Tutup pintu', 'Cepat lari']],
                ['t' => 'sulit', 'q' => 'Complete the sentence: "A doctor works in a ..."', 'ans' => 'Hospital', 'opts' => ['School', 'Market', 'Hospital', 'Post office']],
                ['t' => 'sulit', 'q' => 'Choose the correct conjunction: "I like ice cream ... it is sweet and tasty."', 'ans' => 'because', 'opts' => ['but', 'although', 'because', 'or']],
                ['t' => 'sulit', 'q' => 'What is the plural form of "child"?', 'ans' => 'Children', 'opts' => ['Childs', 'Children', 'Childes', 'Childer']],
                ['t' => 'sulit', 'q' => 'Which preposition is correct? "The cat is sleeping ... the table."', 'ans' => 'under', 'opts' => ['under', 'between', 'into', 'through']],
                ['t' => 'sulit', 'q' => 'What time is "Half past seven"?', 'ans' => '07.30', 'opts' => ['07.15', '07.30', '07.45', '08.30']],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 5: IPS SD
            // -------------------------------------------------------------------------
            5 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Ibukota negara Indonesia saat ini adalah...', 'ans' => 'Jakarta', 'opts' => ['Bandung', 'Jakarta', 'Surabaya', 'Medan']],
                ['t' => 'mudah', 'q' => 'Indonesia diapit oleh dua benua, yaitu Benua Asia dan Benua...', 'ans' => 'Australia', 'opts' => ['Eropa', 'Afrika', 'Australia', 'Amerika']],
                ['t' => 'mudah', 'q' => 'Pekerjaan masyarakat yang tinggal di pesisir pantai sebagian besar adalah...', 'ans' => 'Nelayan', 'opts' => ['Petani', 'Nelayan', 'Peternak', 'Pegawai pabrik']],
                ['t' => 'mudah', 'q' => 'Mata uang resmi Negara Kesatuan Republik Indonesia adalah Rupiah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Pulau terbesar di wilayah negara Indonesia adalah Pulau...', 'ans' => 'Kalimantan', 'opts' => ['Jawa', 'Sumatra', 'Kalimantan', 'Sulawesi']],
                ['t' => 'mudah', 'q' => 'Kegiatan menghasilkan barang atau jasa disebut kegiatan...', 'ans' => 'Produksi', 'opts' => ['Produksi', 'Konsumsi', 'Distribusi', 'Investasi']],
                ['t' => 'mudah', 'q' => 'Orang yang memakai atau menghabiskan barang dan jasa disebut...', 'ans' => 'Konsumen', 'opts' => ['Produsen', 'Konsumen', 'Distributor', 'Eksportir']],
                ['t' => 'mudah', 'q' => 'Indonesia memiliki dua musim, yaitu musim hujan dan musim kemarau.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Suku Asmat merupakan suku bangsa asli yang berasal dari daerah...', 'ans' => 'Papua', 'opts' => ['Aceh', 'Papua', 'Bali', 'Madura']],
                ['t' => 'mudah', 'q' => 'Alat penunjuk arah mata angin yang memanfaatkan magnet bumi disebut...', 'ans' => 'Kompas', 'opts' => ['Termometer', 'Kompas', 'Barometer', 'Speedometer']],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Dua samudra yang mengapit kepulauan Indonesia adalah Samudra Hindia dan Samudra...', 'ans' => 'Pasifik', 'opts' => ['Atlantik', 'Pasifik', 'Arktik', 'Antarktika']],
                ['t' => 'sedang', 'q' => 'Rumah adat khas Minangkabau yang memiliki atap seperti tanduk kerbau disebut...', 'ans' => 'Rumah Gadang', 'opts' => ['Rumah Joglo', 'Rumah Gadang', 'Rumah Tongkonan', 'Rumah Honai']],
                ['t' => 'sedang', 'q' => 'Kegiatan menyalurkan barang dari produsen ke konsumen disebut kegiatan...', 'ans' => 'Distribusi', 'opts' => ['Produksi', 'Konsumsi', 'Distribusi', 'Perdagangan']],
                ['t' => 'sedang', 'q' => 'Garis khayal yang membagi bumi menjadi belahan bumi utara dan selatan adalah garis...', 'ans' => 'Khatulistiwa (Ekuator)', 'opts' => ['Bujur', 'Khatulistiwa (Ekuator)', 'Meridian', 'Wallace']],
                ['t' => 'sedang', 'q' => 'Candi Borobudur merupakan candi bercorak agama...', 'ans' => 'Buddha', 'opts' => ['Hindu', 'Buddha', 'Islam', 'Kristen']],
                ['t' => 'sedang', 'q' => 'Sistem bercocok tanam bertingkat di lereng pegunungan untuk mencegah erosi disebut...', 'ans' => 'Terasering (Sengkedan)', 'opts' => ['Terasering (Sengkedan)', 'Irigasi', 'Tumpang sari', 'Hidroponik']],
                ['t' => 'sedang', 'q' => 'Organisasi negara-negara di kawasan Asia Tenggara dinamakan...', 'ans' => 'ASEAN', 'opts' => ['PBB', 'ASEAN', 'OPEC', 'APEC']],
                ['t' => 'sedang', 'q' => 'Kerajaan Tarumanegara merupakan salah satu kerajaan Hindu tertua di Pulau Jawa.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Batas wilayah Indonesia bagian barat langsung berbatasan dengan...', 'ans' => 'Samudra Hindia', 'opts' => ['Samudra Pasifik', 'Samudra Hindia', 'Laut Cina Selatan', 'Papua Nugini']],
                ['t' => 'sedang', 'q' => 'Koperasi yang anggotanya terdiri atas siswa dan guru di sekolah disebut...', 'ans' => 'Koperasi Sekolah', 'opts' => ['KUD', 'Koperasi Sekolah', 'Koperasi Unit Usaha', 'Koperasi Simpan Pinjam']],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Garis khayal yang memisahkan fauna tipe Asiatis dan tipe Peralihan di Indonesia adalah garis...', 'ans' => 'Garis Wallace', 'opts' => ['Garis Weber', 'Garis Wallace', 'Garis Khatulistiwa', 'Garis Meridian']],
                ['t' => 'sulit', 'q' => 'Tokoh penjelajah dari Spanyol yang memimpin armada pertama mengelilingi dunia adalah...', 'ans' => 'Ferdinand Magellan', 'opts' => ['Vasco da Gama', 'Ferdinand Magellan', 'Cornelis de Houtman', 'Christopher Columbus']],
                ['t' => 'sulit', 'q' => 'Prasasti Ciaruteun memuat telapak kaki Raja Purnawarman dari Kerajaan Tarumanegara.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Pahlawan nasional yang memimpin Perang Padri di Sumatra Barat adalah...', 'ans' => 'Tuanku Imam Bonjol', 'opts' => ['Pangeran Diponegoro', 'Tuanku Imam Bonjol', 'Pangeran Antasari', 'Pattimura']],
                ['t' => 'sulit', 'q' => 'Sistem tanam paksa (Cultuurstelsel) di Hindia Belanda dicetuskan oleh Gubernur Jenderal...', 'ans' => 'Johannes van den Bosch', 'opts' => ['Herman Willem Daendels', 'Johannes van den Bosch', 'Jan Pieterszoon Coen', 'Thomas Stamford Raffles']],
                ['t' => 'sulit', 'q' => 'Peristiwa Rengasdengklok bertujuan untuk mendesak Soekarno dan Hatta agar...', 'ans' => 'Segera memproklamasikan kemerdekaan Indonesia', 'opts' => ['Menyerah kepada Jepang', 'Segera memproklamasikan kemerdekaan Indonesia', 'Membentuk tentara Sekutu', 'Menandatangani perjanjian Linggarjati']],
                ['t' => 'sulit', 'q' => 'Berdasarkan pembagian zona waktu di Indonesia, selisih waktu antara WIB dan WIT adalah...', 'ans' => '2 jam', 'opts' => ['1 jam', '2 jam', '3 jam', '4 jam']],
                ['t' => 'sulit', 'q' => 'KTT Asia Afrika (KAA) yang melahirkan Dasa Sila Bandung pertama kali diselenggarakan di...', 'ans' => 'Bandung, tahun 1955', 'opts' => ['Jakarta, tahun 1945', 'Bandung, tahun 1955', 'Yogyakarta, tahun 1949', 'Surabaya, tahun 1950']],
                ['t' => 'sulit', 'q' => 'Badan usaha yang modalnya berasal dari saham-saham dan memiliki tanggung jawab terbatas disebut...', 'ans' => 'Perseroan Terbatas (PT)', 'opts' => ['Firma', 'CV', 'Perseroan Terbatas (PT)', 'Koperasi']],
                ['t' => 'sulit', 'q' => 'Danau Toba di Sumatra Utara merupakan contoh dari danau tipe...', 'ans' => 'Vulkano-tektonik', 'opts' => ['Karst', 'Tektonik murni', 'Vulkano-tektonik', 'Glasial']],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 6: PPKN SD
            // -------------------------------------------------------------------------
            6 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Dasar negara Republik Indonesia adalah...', 'ans' => 'Pancasila', 'opts' => ['UUD 1945', 'Pancasila', 'Bhinneka Tunggal Ika', 'NKRI']],
                ['t' => 'mudah', 'q' => 'Semboyan negara Indonesia "Bhinneka Tunggal Ika" memiliki arti...', 'ans' => 'Berbeda-beda tetapi tetap satu jua', 'opts' => ['Bersatu kita teguh bercerai runtuh', 'Berbeda-beda tetapi tetap satu jua', 'Maju tak gentar membela yang benar', 'Adil dan makmur sejahtera']],
                ['t' => 'mudah', 'q' => 'Lambang sila pertama Pancasila adalah...', 'ans' => 'Bintang', 'opts' => ['Bintang', 'Rantai Emas', 'Pohon Beringin', 'Kepala Banteng']],
                ['t' => 'mudah', 'q' => 'Lambang negara Indonesia adalah Burung Garuda.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Sikap saling menghargai perbedaan suku, agama, dan budaya disebut...', 'ans' => 'Toleransi', 'opts' => ['Egois', 'Toleransi', 'Diskriminasi', 'Individualis']],
                ['t' => 'mudah', 'q' => 'Kewajiban utama seorang siswa di sekolah adalah...', 'ans' => 'Belajar dengan sungguh-sungguh', 'opts' => ['Bermain game', 'Belajar dengan sungguh-sungguh', 'Membayar uang kas', 'Menjaga gerbang sekolah']],
                ['t' => 'mudah', 'q' => 'Menghormati orang tua dan guru merupakan contoh pengamalan nilai kesopanan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Sila kedua Pancasila berbunyi...', 'ans' => 'Kemanusiaan yang adil dan beradab', 'opts' => ['Ketuhanan Yang Maha Esa', 'Kemanusiaan yang adil dan beradab', 'Persatuan Indonesia', 'Keadilan sosial bagi seluruh rakyat Indonesia']],
                ['t' => 'mudah', 'q' => 'Gotong royong membersihkan lingkungan kelas termasuk perbuatan terpuji.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Warna bendera kebangsaan Indonesia adalah merah dan...', 'ans' => 'Putih', 'opts' => ['Kuning', 'Biru', 'Putih', 'Hijau']],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Lambang sila keempat Pancasila adalah...', 'ans' => 'Kepala Banteng', 'opts' => ['Pohon Beringin', 'Kepala Banteng', 'Padi dan Kapas', 'Rantai Emas']],
                ['t' => 'sedang', 'q' => 'Musyawarah untuk mufakat merupakan cerminan pengamalan Pancasila sila ke-...', 'ans' => '4', 'opts' => ['2', '3', '4', '5']],
                ['t' => 'sedang', 'q' => 'Hak anak di rumah menurut konvensi hak anak antara lain adalah...', 'ans' => 'Mendapatkan kasih sayang dan perlindungan', 'opts' => ['Membantu mencari nafkah keluarga', 'Mendapatkan kasih sayang dan perlindungan', 'Bebas tidak bersekolah', 'Mengatur seluruh anggota keluarga']],
                ['t' => 'sedang', 'q' => 'Sikap yang mencerminkan sila ketiga Pancasila adalah...', 'ans' => 'Cinta tanah air dan bangga produk Indonesia', 'opts' => ['Menjalankan ibadah tepat waktu', 'Cinta tanah air dan bangga produk Indonesia', 'Menghargai hasil karya orang lain', 'Mengikuti pemilihan ketua kelas']],
                ['t' => 'sedang', 'q' => 'Norma yang bersumber dari hati nurani manusia mengenai kebaikan dan keburukan disebut norma...', 'ans' => 'Kesusilaan', 'opts' => ['Hukum', 'Agama', 'Kesusilaan', 'Kesopanan']],
                ['t' => 'sedang', 'q' => 'Pohon beringin melambangkan tempat berteduh dan persatuan bangsa Indonesia.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Sesuatu yang mutlak menjadi milik kita dan penggunaannya tergantung kepada kita disebut...', 'ans' => 'Hak', 'opts' => ['Hak', 'Kewajiban', 'Tanggung jawab', 'Aturan']],
                ['t' => 'sedang', 'q' => 'Lambang padi dan kapas pada lambang negara melambangkan kebutuhan dasar manusia yaitu...', 'ans' => 'Pangan dan sandang', 'opts' => ['Kekayaan dan kemewahan', 'Pangan dan sandang', 'Kekuatan dan ketabahan', 'Persatuan dan kesatuan']],
                ['t' => 'sedang', 'q' => 'Sikap tidak membeda-bedakan teman saat bermain di sekolah mencerminkan nilai...', 'ans' => 'Keadilan dan persatuan', 'opts' => ['Individualisme', 'Keadilan dan persatuan', 'Fanatisme suku', 'Materialisme']],
                ['t' => 'sedang', 'q' => 'Aturan tertulis yang dibuat oleh lembaga berwenang dan bersifat memaksa adalah norma...', 'ans' => 'Hukum', 'opts' => ['Kesopanan', 'Kesusilaan', 'Hukum', 'Adat']],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Lagu kebangsaan Indonesia Raya diciptakan oleh...', 'ans' => 'Wage Rudolf Soepratman', 'opts' => ['Ismail Marzuki', 'Wage Rudolf Soepratman', 'Kusbini', 'Cornel Simanjuntak']],
                ['t' => 'sulit', 'q' => 'Tanggal 1 Juni diperingati oleh bangsa Indonesia sebagai hari...', 'ans' => 'Lahirnya Pancasila', 'opts' => ['Kesaktian Pancasila', 'Lahirnya Pancasila', 'Sumpah Pemuda', 'Kemerdekaan RI']],
                ['t' => 'sulit', 'q' => 'Hari Kesaktian Pancasila diperingati setiap tanggal 1 Oktober.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Sidang BPUPKI pertama yang membahas perumusan dasar negara berlangsung pada tanggal...', 'ans' => '29 Mei - 1 Juni 1945', 'opts' => ['29 Mei - 1 Juni 1945', '10 - 17 Juli 1945', '17 - 18 Agustus 1945', '22 Juni 1945']],
                ['t' => 'sulit', 'q' => 'Panitia sembilan berhasil merumuskan rancangan pembukaan UUD yang dikenal dengan sebutan...', 'ans' => 'Piagam Jakarta (Jakarta Charter)', 'opts' => ['Dekrit Presiden', 'Piagam Jakarta (Jakarta Charter)', 'Supersemar', 'Maklumat Pemerintah']],
                ['t' => 'sulit', 'q' => 'Lembaga tinggi negara yang bertugas mengawasi jalannya pemerintahan bersama Presiden adalah...', 'ans' => 'DPR', 'opts' => ['DPR', 'MA', 'MK', 'KY']],
                ['t' => 'sulit', 'q' => 'Nilai patriotisme dapat diwujudkan siswa dengan cara...', 'ans' => 'Belajar giat dan berprestasi demi mengharumkan nama bangsa', 'opts' => ['Ikut serta dalam demonstrasi jalanan', 'Belajar giat dan berprestasi demi mengharumkan nama bangsa', 'Membeli barang mewah impor', 'Menghindari kerja kelompok']],
                ['t' => 'sulit', 'q' => 'Pasal dalam UUD 1945 yang mengatur bahwa setiap warga negara berhak dan wajib ikut serta dalam bela negara adalah...', 'ans' => 'Pasal 27 ayat 3', 'opts' => ['Pasal 27 ayat 3', 'Pasal 29 ayat 2', 'Pasal 31 ayat 1', 'Pasal 33 ayat 1']],
                ['t' => 'sulit', 'q' => 'Kata "Bhinneka Tunggal Ika" pertama kali tertulis dalam kitab Sutasoma karya...', 'ans' => 'Mpu Tantular', 'opts' => ['Mpu Prapanca', 'Mpu Tantular', 'Mpu Sedah', 'Mpu Panuluh']],
                ['t' => 'sulit', 'q' => 'Asas kewarganegaraan berdasarkan tempat seseorang dilahirkan disebut asas...', 'ans' => 'Ius soli', 'opts' => ['Ius sanguinis', 'Ius soli', 'Apatride', 'Bipatride']],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 7: PENDIDIKAN AGAMA & BUDI PEKERTI SD
            // -------------------------------------------------------------------------
            7 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Kitab suci umat Islam adalah...', 'ans' => 'Al-Qur\'an', 'opts' => ['Al-Qur\'an', 'Injil', 'Weda', 'Tripitaka']],
                ['t' => 'mudah', 'q' => 'Tempat ibadah bagi pemeluk agama Islam adalah...', 'ans' => 'Masjid', 'opts' => ['Gereja', 'Pura', 'Masjid', 'Vihara']],
                ['t' => 'mudah', 'q' => 'Sebelum dan sesudah melakukan kegiatan belajar, sebaiknya kita...', 'ans' => 'Berdoa', 'opts' => ['Makan', 'Berdoa', 'Tidur', 'Bermain']],
                ['t' => 'mudah', 'q' => 'Sikap jujur akan membuat seseorang dipercaya oleh orang lain.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Hari raya peringatan kelahiran Yesus Kristus bagi umat Kristen adalah...', 'ans' => 'Natal', 'opts' => ['Paskah', 'Natal', 'Nyepi', 'Waisak']],
                ['t' => 'mudah', 'q' => 'Kitab suci agama Hindu adalah...', 'ans' => 'Weda', 'opts' => ['Al-Qur\'an', 'Injil', 'Weda', 'Tripitaka']],
                ['t' => 'mudah', 'q' => 'Rukun Islam yang pertama adalah mengucapkan...', 'ans' => 'Dua kalimat syahadat', 'opts' => ['Dua kalimat syahadat', 'Takbir', 'Basmalah', 'Hamdalah']],
                ['t' => 'mudah', 'q' => 'Menolong orang lain yang sedang kesusahan harus dilakukan dengan hati yang ikhlas.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Tempat beribadah bagi umat Buddha disebut...', 'ans' => 'Vihara', 'opts' => ['Masjid', 'Gereja', 'Pura', 'Vihara']],
                ['t' => 'mudah', 'q' => 'Hari raya keagamaan umat Islam setelah berpuasa sebulan penuh di bulan Ramadan adalah...', 'ans' => 'Idul Fitri', 'opts' => ['Idul Adha', 'Idul Fitri', 'Tahun Baru Hijriah', 'Isra Mi\'raj']],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Jumlah rukun iman dalam ajaran agama Islam ada...', 'ans' => '6', 'opts' => ['4', '5', '6', '7']],
                ['t' => 'sedang', 'q' => 'Sifat wajib bagi rasul yang berarti "dapat dipercaya" adalah...', 'ans' => 'Amanah', 'opts' => ['Siddiq', 'Amanah', 'Tabligh', 'Fathanah']],
                ['t' => 'sedang', 'q' => 'Perilaku hormat dan patuh kepada orang tua dalam ajaran agama disebut...', 'ans' => 'Birrul walidain', 'opts' => ['Silaturahmi', 'Birrul walidain', 'Ukhuwah', 'Tawakal']],
                ['t' => 'sedang', 'q' => 'Hari raya keagamaan umat Hindu yang dirayakan dengan tidak menyalakan api dan berdiam diri adalah...', 'ans' => 'Nyepi', 'opts' => ['Galungan', 'Kuningan', 'Nyepi', 'Saraswati']],
                ['t' => 'sedang', 'q' => 'Nabi dan Rasul pertama yang diciptakan oleh Tuhan Yang Maha Esa adalah...', 'ans' => 'Nabi Adam A.S.', 'opts' => ['Nabi Nuh A.S.', 'Nabi Ibrahim A.S.', 'Nabi Adam A.S.', 'Nabi Muhammad S.A.W.']],
                ['t' => 'sedang', 'q' => 'Sikap ikhlas berarti melakukan suatu perbuatan semata-mata karena mengharap ridha Tuhan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Membersihkan diri dari hadas kecil sebelum salat dilakukan dengan cara...', 'ans' => 'Berwudu', 'opts' => ['Mandi wajib', 'Berwudu', 'Tayamum saja', 'Mencuci kaki saja']],
                ['t' => 'sedang', 'q' => 'Kitab suci yang diturunkan kepada Nabi Musa A.S. adalah Kitab...', 'ans' => 'Taurat', 'opts' => ['Zabur', 'Taurat', 'Injil', 'Al-Qur\'an']],
                ['t' => 'sedang', 'q' => 'Hukum menuntut ilmu bagi setiap umat manusia adalah wajib.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Sikap tenggang rasa dan menghargai teman yang sedang beribadah sesuai agamanya merupakan bentuk...', 'ans' => 'Toleransi beragama', 'opts' => ['Toleransi beragama', 'Fanatisme', 'Asimilasi', 'Akulturasi']],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Asmaul Husna berjumlah 99 nama yang indah bagi Allah SWT.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Arti dari Asmaul Husna "Ar-Rahman" adalah...', 'ans' => 'Maha Pengasih', 'opts' => ['Maha Penyayang', 'Maha Pengasih', 'Maha Adil', 'Maha Bijaksana']],
                ['t' => 'sulit', 'q' => 'Surah dalam Al-Qur\'an yang menegaskan tentang keesaan Allah SWT adalah Surah...', 'ans' => 'Al-Ikhlas', 'opts' => ['Al-Fatihah', 'Al-Ikhlas', 'Al-Falaq', 'An-Nas']],
                ['t' => 'sulit', 'q' => 'Malaikat yang bertugas menyampaikan wahyu kepada para nabi dan rasul adalah Malaikat...', 'ans' => 'Jibril', 'opts' => ['Mikail', 'Israfil', 'Izrail', 'Jibril']],
                ['t' => 'sulit', 'q' => 'Peristiwa perjalanan Nabi Muhammad SAW dari Masjidil Haram ke Masjidil Aqsa lalu ke Sidratul Muntaha disebut...', 'ans' => 'Isra Mi\'raj', 'opts' => ['Hijrah', 'Isra Mi\'raj', 'Fathu Makkah', 'Baiat Aqabah']],
                ['t' => 'sulit', 'q' => 'Sifat rasul "Fathanah" berarti memiliki sifat cerdas dan bijaksana.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Zakat fitrah yang wajib dikeluarkan setiap jiwa di bulan Ramadan berupa makanan pokok seberat...', 'ans' => '2,5 kg atau 3,5 liter beras', 'opts' => ['1,5 kg', '2,5 kg atau 3,5 liter beras', '5 kg beras', '10 kg beras']],
                ['t' => 'sulit', 'q' => 'Shalat fardhu yang terdiri dari 3 rakaat adalah shalat...', 'ans' => 'Maghrib', 'opts' => ['Subuh', 'Dzuhur', 'Ashar', 'Maghrib']],
                ['t' => 'sulit', 'q' => 'Sikap berserah diri kepada Tuhan setelah berusaha semaksimal mungkin disebut...', 'ans' => 'Tawakal', 'opts' => ['Ikhtiar', 'Tawakal', 'Qana\'ah', 'Sabar']],
                ['t' => 'sulit', 'q' => 'Kitab suci agama Konghucu adalah...', 'ans' => 'Si Shu dan Wu Jing', 'opts' => ['Tripitaka', 'Weda', 'Si Shu dan Wu Jing', 'Injil']],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 8: INFORMATIKA & TIK SD
            // -------------------------------------------------------------------------
            8 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Perangkat komputer yang digunakan untuk mengetik huruf dan angka adalah...', 'ans' => 'Keyboard', 'opts' => ['Mouse', 'Monitor', 'Keyboard', 'Speaker']],
                ['t' => 'mudah', 'q' => 'Layar yang menampilkan hasil gambar dan teks pada komputer disebut...', 'ans' => 'Monitor', 'opts' => ['CPU', 'Monitor', 'Printer', 'Flashdisk']],
                ['t' => 'mudah', 'q' => 'Alat penunjuk (kursor) berbentuk panah di layar komputer digerakkan dengan...', 'ans' => 'Mouse', 'opts' => ['Keyboard', 'Mouse', 'Speaker', 'Scanner']],
                ['t' => 'mudah', 'q' => 'Tombol power pada komputer digunakan untuk menyalakan atau mematikan komputer.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Alat untuk mencetak teks dan gambar dari komputer ke kertas adalah...', 'ans' => 'Printer', 'opts' => ['Scanner', 'Printer', 'Plotter', 'Proyektor']],
                ['t' => 'mudah', 'q' => 'Jaringan komputer yang menghubungkan seluruh dunia disebut Internet.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Perangkat keras komputer dalam bahasa Inggris disebut...', 'ans' => 'Hardware', 'opts' => ['Software', 'Hardware', 'Brainware', 'Malware']],
                ['t' => 'mudah', 'q' => 'Aplikasi Microsoft Word digunakan terutama untuk...', 'ans' => 'Mengolah kata dan mengetik dokumen', 'opts' => ['Menonton video', 'Mengolah kata dan mengetik dokumen', 'Menggambar peta 3D', 'Memutar musik']],
                ['t' => 'mudah', 'q' => 'Flashdisk merupakan salah satu media penyimpan data portabel.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Untuk menghapus karakter di sebelah kiri kursor pada keyboard digunakan tombol...', 'ans' => 'Backspace', 'opts' => ['Enter', 'Delete', 'Backspace', 'Shift']],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Otak utama dari sistem komputer yang bertugas memproses data adalah...', 'ans' => 'CPU (Central Processing Unit)', 'opts' => ['RAM', 'Harddisk', 'CPU (Central Processing Unit)', 'Power Supply']],
                ['t' => 'sedang', 'q' => 'Kombinasi tombol keyboard untuk menyalin (copy) teks yang dipilih adalah...', 'ans' => 'Ctrl + C', 'opts' => ['Ctrl + V', 'Ctrl + C', 'Ctrl + X', 'Ctrl + Z']],
                ['t' => 'sedang', 'q' => 'Kombinasi tombol keyboard untuk menempelkan (paste) teks adalah...', 'ans' => 'Ctrl + V', 'opts' => ['Ctrl + P', 'Ctrl + S', 'Ctrl + V', 'Ctrl + A']],
                ['t' => 'sedang', 'q' => 'Perangkat lunak (software) peramban yang digunakan untuk membuka situs web adalah...', 'ans' => 'Google Chrome', 'opts' => ['Microsoft Excel', 'Google Chrome', 'Notepad', 'WinRAR']],
                ['t' => 'sedang', 'q' => 'Sistem operasi komputer yang sangat populer dibuat oleh Microsoft adalah...', 'ans' => 'Windows', 'opts' => ['Android', 'Windows', 'Linux', 'macOS']],
                ['t' => 'sedang', 'q' => 'Menyimpan password akun dengan aman dan tidak membagikannya ke orang lain adalah etika digital yang baik.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Aplikasi presentasi yang umum digunakan di sekolah adalah...', 'ans' => 'Microsoft PowerPoint', 'opts' => ['Microsoft Word', 'Microsoft Excel', 'Microsoft PowerPoint', 'Microsoft Access']],
                ['t' => 'sedang', 'q' => 'Simbol "@" (at) selalu digunakan dalam penulisan alamat surat elektronik (email).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Satuan kapasitas penyimpanan data di bawah ini yang paling besar adalah...', 'ans' => 'Gigabyte (GB)', 'opts' => ['Byte', 'Kilobyte (KB)', 'Megabyte (MB)', 'Gigabyte (GB)']],
                ['t' => 'sedang', 'q' => 'Alat yang berfungsi mengubah sinyal digital menjadi gambar di layar proyektor adalah...', 'ans' => 'LCD Proyektor', 'opts' => ['Printer', 'Scanner', 'LCD Proyektor', 'Webcam']],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Langkah-langkah terurut yang logis untuk menyelesaikan suatu masalah komputasi disebut...', 'ans' => 'Algoritma', 'opts' => ['Variabel', 'Algoritma', 'Sintaks', 'Kompilasi']],
                ['t' => 'sulit', 'q' => 'Perangkat lunak perusak yang dapat merusak sistem dan mencuri data komputer disebut...', 'ans' => 'Malware / Virus', 'opts' => ['Antivirus', 'Malware / Virus', 'Firewall', 'Freeware']],
                ['t' => 'sulit', 'q' => 'Di Microsoft Excel, rumus penjumlahan otomatis ditulis dengan fungsi...', 'ans' => '=SUM(...)', 'opts' => ['=COUNT(...)', '=AVERAGE(...)', '=SUM(...)', '=MAX(...)']],
                ['t' => 'sulit', 'q' => 'Konsep berpikir komputasional mencakup dekomposisi, pengenalan pola, abstraksi, dan algoritma.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Alamat web (URL) yang diawali dengan "https://" menandakan bahwa situs web tersebut...', 'ans' => 'Menggunakan koneksi yang terenkripsi dan aman', 'opts' => ['Gratis tanpa kuota', 'Menggunakan koneksi yang terenkripsi dan aman', 'Hanya bisa dibuka di komputer', 'Tidak memiliki iklan']],
                ['t' => 'sulit', 'q' => 'Bahasa pemrograman visual berbasis blok yang ramah anak untuk belajar coding adalah...', 'ans' => 'Scratch', 'opts' => ['C++', 'Scratch', 'Assembly', 'PHP']],
                ['t' => 'sulit', 'q' => 'Penyimpanan data berbasis awan (cloud storage) contohnya adalah...', 'ans' => 'Google Drive', 'opts' => ['Flashdisk', 'Harddisk eksternal', 'Google Drive', 'Disket']],
                ['t' => 'sulit', 'q' => 'Kombinasi tombol untuk membatalkan perintah terakhir (undo) adalah...', 'ans' => 'Ctrl + Z', 'opts' => ['Ctrl + Y', 'Ctrl + Z', 'Ctrl + U', 'Ctrl + R']],
                ['t' => 'sulit', 'q' => 'Kamera digital kecil yang terpasang pada laptop untuk panggilan video disebut...', 'ans' => 'Webcam', 'opts' => ['Microphone', 'Webcam', 'Sensometer', 'Barcode Reader']],
                ['t' => 'sulit', 'q' => 'Sikap membagikan berita tanpa memeriksa kebenarannya dapat menyebarkan berita bohong (hoax).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 9: SENI BUDAYA & PRAKARYA SD
            // -------------------------------------------------------------------------
            9 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Warna primer terdiri dari tiga warna dasar, yaitu merah, biru, dan...', 'ans' => 'Kuning', 'opts' => ['Hijau', 'Kuning', 'Hitam', 'Ungu']],
                ['t' => 'mudah', 'q' => 'Alat musik tradisional Angklung dimainkan dengan cara...', 'ans' => 'Digoyang', 'opts' => ['Dipukul', 'Digoyang', 'Ditiup', 'Dipetik']],
                ['t' => 'mudah', 'q' => 'Bahan lunak alami yang sering digunakan untuk membuat patung atau gerabah adalah...', 'ans' => 'Tanah liat', 'opts' => ['Batu kali', 'Tanah liat', 'Kayu jati', 'Besi']],
                ['t' => 'mudah', 'q' => 'Lagu anak-anak "Pelangi-Pelangi" diciptakan oleh...', 'ans' => 'A.T. Mahmud', 'opts' => ['Ibu Sud', 'A.T. Mahmud', 'Pak Kasur', 'Kusbini']],
                ['t' => 'mudah', 'q' => 'Pencampuran warna merah dan kuning akan menghasilkan warna jingga (oranye).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Seni melipat kertas asal Jepang disebut origami.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Tari Saman berasal dari provinsi...', 'ans' => 'Aceh', 'opts' => ['Aceh', 'Bali', 'Jawa Barat', 'Papua']],
                ['t' => 'mudah', 'q' => 'Alat musik tiup modern berbahan logam atau plastik yang bersuara khas tiupan adalah...', 'ans' => 'Pianika / Terompet', 'opts' => ['Gitar', 'Pianika / Terompet', 'Drum', 'Biola']],
                ['t' => 'mudah', 'q' => 'Karya seni rupa dua dimensi hanya memiliki ukuran panjang dan...', 'ans' => 'Lebar', 'opts' => ['Tinggi', 'Volume', 'Lebar', 'Ruang']],
                ['t' => 'mudah', 'q' => 'Gambar rancangan awal sebelum membuat lukisan disebut sketsa.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Pencampuran warna biru dan kuning menghasilkan warna...', 'ans' => 'Hijau', 'opts' => ['Ungu', 'Cokelat', 'Hijau', 'Oranye']],
                ['t' => 'sedang', 'q' => 'Tangga nada diatonis mayor memiliki susunan jarak nada (interval)...', 'ans' => '1 - 1 - 1/2 - 1 - 1 - 1 - 1/2', 'opts' => ['1 - 1/2 - 1 - 1 - 1/2 - 1 - 1', '1 - 1 - 1/2 - 1 - 1 - 1 - 1/2', '1 - 1 - 1 - 1/2 - 1 - 1 - 1/2', '1/2 - 1 - 1 - 1 - 1/2 - 1 - 1']],
                ['t' => 'sedang', 'q' => 'Tari Kecak merupakan tarian tradisional yang sangat terkenal dari daerah...', 'ans' => 'Bali', 'opts' => ['Jawa Tengah', 'Bali', 'NTT', 'Kalimantan Timur']],
                ['t' => 'sedang', 'q' => 'Teknik menempelkan potongan-potongan bahan (kertas, kaca, keramik) pada bidang gambar disebut teknik...', 'ans' => 'Mosaik', 'opts' => ['Kolase', 'Mosaik', 'Montase', 'Aplikasi']],
                ['t' => 'sedang', 'q' => 'Gamelan merupakan seperangkat alat musik tradisional khas suku...', 'ans' => 'Jawa dan Bali', 'opts' => ['Batak', 'Jawa dan Bali', 'Dayak', 'Asmat']],
                ['t' => 'sedang', 'q' => 'Tempo musik "Andante" memiliki arti lagu dimainkan dengan kecepatan...', 'ans' => 'Sedang (seperti orang berjalan)', 'opts' => ['Sangat lambat', 'Sedang (seperti orang berjalan)', 'Sangat cepat', 'Bersemangat']],
                ['t' => 'sedang', 'q' => 'Batik yang pembuatannya menggunakan canting dan malam cair disebut...', 'ans' => 'Batik tulis', 'opts' => ['Batik cap', 'Batik tulis', 'Batik cetak', 'Batik ikat']],
                ['t' => 'sedang', 'q' => 'Karya seni rupa tiga dimensi memiliki panjang, lebar, dan tinggi serta dapat dilihat dari segala arah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Tari Piring berasal dari daerah Minangkabau, Sumatra Barat.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Alat musik Sasando yang dipetik berasal dari pulau Rote, Nusa Tenggara Timur.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Lagu bertangga nada diatonis minor biasanya memiliki karakteristik suasana...', 'ans' => 'Sedih dan khidmat', 'opts' => ['Riang gembira', 'Sedih dan khidmat', 'Bersemangat tinggi', 'Cepat dan lincah']],
                ['t' => 'sulit', 'q' => 'Bahan pewarna batik tradisional yang tahan lama dan tidak mudah luntur disebut lilin...', 'ans' => 'Malam', 'opts' => ['Minyak', 'Malam', 'Parafin cair', 'Getah damar']],
                ['t' => 'sulit', 'q' => 'Pola lantai garis lurus pada tarian tradisional melambangkan hubungan...', 'ans' => 'Antarmanusia yang sejajar dan harmonis', 'opts' => ['Kekacauan gerak', 'Antarmanusia yang sejajar dan harmonis', 'Ketertundukan pada alam', 'Kelemahan fisik']],
                ['t' => 'sulit', 'q' => 'Karya seni rupa murni lebih mengutamakan nilai estetika (keindahan) daripada nilai fungsi pakai.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Tanda dinamika "forte (f)" dalam sebuah partitur lagu berarti lagu dinyanyikan dengan...', 'ans' => 'Keras / Kuat', 'opts' => ['Lembut', 'Keras / Kuat', 'Sangat perlahan', 'Makin melambat']],
                ['t' => 'sulit', 'q' => 'Teknik membuat patung dengan cara mengurangi bahan sedikit demi sedikit menggunakan pahat disebut...', 'ans' => 'Memahat (Carving)', 'opts' => ['Mencetak (Casting)', 'Memahat (Carving)', 'Membungkus (Assembling)', 'Menganyam']],
                ['t' => 'sulit', 'q' => 'Tari Jaipong merupakan tarian kreasi baru yang berasal dari provinsi...', 'ans' => 'Jawa Barat', 'opts' => ['Jawa Tengah', 'Jawa Barat', 'Banten', 'DKI Jakarta']],
                ['t' => 'sulit', 'q' => 'Alat musik Kolintang yang terbuat dari bilah kayu berasal dari daerah...', 'ans' => 'Minahasa, Sulawesi Utara', 'opts' => ['Toraja, Sulawesi Selatan', 'Minahasa, Sulawesi Utara', 'Maluku', 'Kupang']],
                ['t' => 'sulit', 'q' => 'Susunan warna-warna sekunder dihasilkan dari percampuran dua warna primer.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Karya montase dibuat dengan cara menempelkan potongan gambar-gambar yang sudah jadi dari koran atau majalah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 10: PJOK (OLAHRAGA) SD
            // -------------------------------------------------------------------------
            10 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Sebelum berolahraga, kita wajib melakukan pemanasan untuk mencegah...', 'ans' => 'Cedera otot', 'opts' => ['Kelelahan', 'Cedera otot', 'Haus', 'Mengantuk']],
                ['t' => 'mudah', 'q' => 'Gerakan lokomotor adalah gerakan tubuh yang disertai dengan...', 'ans' => 'Perpindahan tempat', 'opts' => ['Perpindahan tempat', 'Diam di tempat', 'Mengayun tangan saja', 'Menekuk lutut saja']],
                ['t' => 'mudah', 'q' => 'Contoh gerak lokomotor dalam olahraga adalah...', 'ans' => 'Berlari', 'opts' => ['Meliuk', 'Berlari', 'Menggelengkan kepala', 'Mengayun tangan']],
                ['t' => 'mudah', 'q' => 'Jumlah pemain dalam satu tim sepak bola di lapangan adalah...', 'ans' => '11 orang', 'opts' => ['9 orang', '10 orang', '11 orang', '12 orang']],
                ['t' => 'mudah', 'q' => 'Gerakan meliukkan badan di tempat termasuk gerak non-lokomotor.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Menendang dan melempar bola termasuk ke dalam gerak manipulatif.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Organ tubuh yang bertambah kuat saat kita rajin berolahraga lari adalah...', 'ans' => 'Jantung dan paru-paru', 'opts' => ['Lambung', 'Jantung dan paru-paru', 'Empedu', 'Ginjal']],
                ['t' => 'mudah', 'q' => 'Setelah berolahraga selesai, sebaiknya dilakukan pendinginan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Alat pemukul dalam permainan kasti terbuat dari...', 'ans' => 'Kayu', 'opts' => ['Besi', 'Kayu', 'Plastik tipis', 'Kaca']],
                ['t' => 'mudah', 'q' => 'Permainan bola kasti termasuk dalam permainan bola kecil.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Lari cepat jarak pendek dalam atletik disebut juga dengan lari...', 'ans' => 'Sprint', 'opts' => ['Maraton', 'Sprint', 'Estafet', 'Jogging']],
                ['t' => 'sedang', 'q' => 'Start yang digunakan dalam lari cepat jarak pendek adalah start...', 'ans' => 'Jongkok', 'opts' => ['Berdiri', 'Jongkok', 'Melayang', 'Duduk']],
                ['t' => 'sedang', 'q' => 'Latihan gerakan push-up bertujuan untuk melatih kekuatan otot...', 'ans' => 'Lengan dan dada', 'opts' => ['Kaki', 'Lengan dan dada', 'Perut saja', 'Leher']],
                ['t' => 'sedang', 'q' => 'Latihan gerakan sit-up berguna untuk melatih kekuatan otot...', 'ans' => 'Perut', 'opts' => ['Punggung', 'Kaki', 'Perut', 'Bahu']],
                ['t' => 'sedang', 'q' => 'Sikap lilin dalam senam lantai bertumpu pada...', 'ans' => 'Punggung bagian atas dan tengkuk', 'opts' => ['Kepala saja', 'Kedua telapak tangan', 'Punggung bagian atas dan tengkuk', 'Ujung kaki']],
                ['t' => 'sedang', 'q' => 'Gaya renang yang gerakannya menyerupai gerakan katak berenang adalah gaya...', 'ans' => 'Dada', 'opts' => ['Bebas', 'Punggung', 'Dada', 'Kupu-kupu']],
                ['t' => 'sedang', 'q' => 'Satu regu bola voli dalam lapangan terdiri dari berapa orang pemain?', 'ans' => '6 orang', 'opts' => ['5 orang', '6 orang', '7 orang', '11 orang']],
                ['t' => 'sedang', 'q' => 'Gerakan menggiring bola basket ke lantai menggunakan satu tangan disebut...', 'ans' => 'Dribbling', 'opts' => ['Passing', 'Dribbling', 'Shooting', 'Pivot']],
                ['t' => 'sedang', 'q' => 'Menjaga kebersihan diri seperti mandi dua kali sehari dapat mencegah penyakit kulit.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Istirahat yang paling baik setelah beraktivitas seharian adalah tidur cukup 8 jam semalam.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Teknik mengoper bola jarak jauh di atas kepala dalam permainan bola basket disebut...', 'ans' => 'Overhead pass', 'opts' => ['Chest pass', 'Bounce pass', 'Overhead pass', 'Baseball pass']],
                ['t' => 'sulit', 'q' => 'Pada lompat jauh, urutan tahapan gerak yang benar adalah...', 'ans' => 'Awalan - tolakan - melayang di udara - mendarat', 'opts' => ['Awalan - tolakan - mendarat - melayang', 'Awalan - melayang - tolakan - mendarat', 'Awalan - tolakan - melayang di udara - mendarat', 'Tolakan - awalan - melayang - mendarat']],
                ['t' => 'sulit', 'q' => 'Gaya renang di mana posisi dada menghadap ke atas permukaan air adalah gaya...', 'ans' => 'Punggung', 'opts' => ['Bebas', 'Dada', 'Punggung', 'Kupu-kupu']],
                ['t' => 'sulit', 'q' => 'Kemampuan tubuh untuk melakukan aktivitas fisik dalam waktu lama tanpa mengalami kelelahan berlebihan disebut...', 'ans' => 'Daya tahan (endurance)', 'opts' => ['Kelenturan', 'Daya tahan (endurance)', 'Kelincahan', 'Kekuatan']],
                ['t' => 'sulit', 'q' => 'Lari zig-zag mengelilingi rintangan bertujuan untuk melatih...', 'ans' => 'Kelincahan (agility)', 'opts' => ['Daya tahan', 'Keseimbangan', 'Kelincahan (agility)', 'Kecepatan lurus']],
                ['t' => 'sulit', 'q' => 'Dalam permainan kasti, pelempar bola kepada pemukul disebut pitcher / pelambung.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Pukulan dalam bulu tangkis yang melambung tinggi ke bagian belakang lapangan lawan disebut...', 'ans' => 'Pukulan Lob', 'opts' => ['Smash', 'Dropshot', 'Pukulan Lob', 'Drive']],
                ['t' => 'sulit', 'q' => 'Pertolongan pertama pada cedera memar otot adalah mengompres dengan es dingin.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Berapa tinggi net bola voli putra standar internasional?', 'ans' => '2,43 meter', 'opts' => ['2,24 meter', '2,35 meter', '2,43 meter', '2,50 meter']],
                ['t' => 'sulit', 'q' => 'Gerakan senam irama diiringi oleh ketukan atau musik yang berirama tetap.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 17: SEJARAH INDONESIA SD
            // -------------------------------------------------------------------------
            17 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Hari Kemerdekaan Republik Indonesia diperingati setiap tanggal...', 'ans' => '17 Agustus', 'opts' => ['1 Juni', '17 Agustus', '28 Oktober', '10 November']],
                ['t' => 'mudah', 'q' => 'Presiden pertama Republik Indonesia adalah...', 'ans' => 'Ir. Soekarno', 'opts' => ['Drs. Moh. Hatta', 'Ir. Soekarno', 'Soeharto', 'B.J. Habibie']],
                ['t' => 'mudah', 'q' => 'Wakil Presiden pertama Republik Indonesia adalah...', 'ans' => 'Drs. Mohammad Hatta', 'opts' => ['Sutan Sjahrir', 'Drs. Mohammad Hatta', 'Adam Malik', 'Hamengkubuwono IX']],
                ['t' => 'mudah', 'q' => 'Teks Proklamasi Kemerdekaan Indonesia dibacakan di Jalan Pegangsaan Timur No. 56, Jakarta.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Bendera pusaka merah putih dijahit langsung oleh...', 'ans' => 'Ibu Fatmawati', 'opts' => ['Ibu Kartini', 'Ibu Fatmawati', 'Cut Nyak Dien', 'Dewi Sartika']],
                ['t' => 'mudah', 'q' => 'Tokoh yang mengetik naskah proklamasi kemerdekaan Indonesia adalah...', 'ans' => 'Sayuti Melik', 'opts' => ['Sukarni', 'Sayuti Melik', 'Chairul Saleh', 'Latief Hendraningrat']],
                ['t' => 'mudah', 'q' => 'Hari Pahlawan diperingati setiap tanggal 10 November.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Pahlawan emansipasi wanita asal Jepara yang menulis surat "Habis Gelap Terbitlah Terang" adalah...', 'ans' => 'R.A. Kartini', 'opts' => ['Dewi Sartika', 'R.A. Kartini', 'Cut Nyak Dien', 'Rasuna Said']],
                ['t' => 'mudah', 'q' => 'Sumpah Pemuda dicetuskan pada tanggal 28 Oktober 1928.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Pahlawan wanita dari Aceh yang gigih berjuang melawan penjajah Belanda adalah...', 'ans' => 'Cut Nyak Dien', 'opts' => ['Martha Christina Tiahahu', 'Cut Nyak Dien', 'Dewi Sartika', 'Nyi Ageng Serang']],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Organisasi pergerakan nasional pertama di Indonesia yang berdiri pada 20 Mei 1908 adalah...', 'ans' => 'Budi Utomo', 'opts' => ['Sarekat Islam', 'Budi Utomo', 'Indische Partij', 'PNI']],
                ['t' => 'sedang', 'q' => 'Tokoh pendiri Budi Utomo yang juga menggagas dana pendidikan pelajar adalah...', 'ans' => 'dr. Wahidin Sudirohusodo', 'opts' => ['dr. Soetomo', 'dr. Wahidin Sudirohusodo', 'Ki Hajar Dewantara', 'H.O.S. Tjokroaminoto']],
                ['t' => 'sedang', 'q' => 'Hari Kebangkitan Nasional diperingati setiap tanggal...', 'ans' => '20 Mei', 'opts' => ['2 Mei', '20 Mei', '1 Juni', '17 Agustus']],
                ['t' => 'sedang', 'q' => 'Bapak Pendidikan Nasional Indonesia adalah...', 'ans' => 'Ki Hajar Dewantara', 'opts' => ['dr. Soetomo', 'Ki Hajar Dewantara', 'K.H. Ahmad Dahlan', 'H. Agus Salim']],
                ['t' => 'sedang', 'q' => 'Semboyan pendidikan "Tut Wuri Handayani" memiliki arti...', 'ans' => 'Di belakang memberikan dorongan dan semangat', 'opts' => ['Di depan memberi teladan', 'Di tengah membangun karsa', 'Di belakang memberikan dorongan dan semangat', 'Selalu bersama mencapai cita-cita']],
                ['t' => 'sedang', 'q' => 'Perang Diponegoro melawan penjajah Belanda berlangsung pada kurun waktu...', 'ans' => '1825 - 1830', 'opts' => ['1800 - 1805', '1825 - 1830', '1850 - 1855', '1900 - 1905']],
                ['t' => 'sedang', 'q' => 'Pahlawan nasional yang memimpin perlawanan rakyat Maluku melawan Belanda di Benteng Duurstede adalah...', 'ans' => 'Kapitan Pattimura', 'opts' => ['Sultan Hasanuddin', 'Kapitan Pattimura', 'Pangeran Antasari', 'Silas Papare']],
                ['t' => 'sedang', 'q' => 'Sultan Hasanuddin dari Kerajaan Gowa dijuluki oleh penjajah Belanda sebagai...', 'ans' => 'Ayam Jantan dari Timur', 'opts' => ['Singa Padang Pasir', 'Ayam Jantan dari Timur', 'Elang Laut Hitam', 'Banteng Perkasa']],
                ['t' => 'sedang', 'q' => 'Pertempuran Surabaya 10 November 1945 dipimpin dengan orasi pembakar semangat oleh...', 'ans' => 'Bung Tomo', 'opts' => ['Jenderal Sudirman', 'Bung Tomo', 'Supriyadi', 'Moestopo']],
                ['t' => 'sedang', 'q' => 'Peristiwa Bandung Lautan Api terjadi karena para pejuang membumihanguskan kota Bandung agar tidak dimanfaatkan oleh Sekutu.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Rumah tempat perumusan naskah proklamasi kemerdekaan Indonesia adalah rumah milik...', 'ans' => 'Laksamana Maeda', 'opts' => ['Jenderal Terauchi', 'Laksamana Maeda', 'Hitoshi Imamura', 'Kuniaki Koiso']],
                ['t' => 'sulit', 'q' => 'Jenderal besar yang memimpin perang gerilya melawan agresi militer Belanda meskipun dalam kondisi sakit paru-paru adalah...', 'ans' => 'Jenderal Sudirman', 'opts' => ['Jenderal Ahmad Yani', 'Jenderal Sudirman', 'Jenderal Gatot Soebroto', 'Jenderal A.H. Nasution']],
                ['t' => 'sulit', 'q' => 'Tiga tokoh yang mengibarkan bendera merah putih saat proklamasi 17 Agustus 1945 adalah...', 'ans' => 'Latief Hendraningrat, Suhud Sastrokusumo, dan SK Trimurti', 'opts' => ['Sayuti Melik, Sukarni, dan Chaerul Saleh', 'Latief Hendraningrat, Suhud Sastrokusumo, dan SK Trimurti', 'Bung Karno, Bung Hatta, dan Sjahrir', 'Wikana, Yusuf Kunto, dan dr. Muwardi']],
                ['t' => 'sulit', 'q' => 'Perjanjian Linggarjati antara Indonesia dan Belanda diadakan pada tahun...', 'ans' => '1946 (disahkan 1947)', 'opts' => ['1945', '1946 (disahkan 1947)', '1948', '1949']],
                ['t' => 'sulit', 'q' => 'Konferensi Meja Bundar (KMB) di Den Haag Belanda yang mengakui kedaulatan Indonesia berlangsung pada tahun...', 'ans' => '1949', 'opts' => ['1947', '1948', '1949', '1950']],
                ['t' => 'sulit', 'q' => 'Serangan Umum 1 Maret 1949 di Yogyakarta bertujuan untuk membuktikan kepada dunia internasional bahwa TNI dan Republik Indonesia masih ada.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Nama kabinet pertama Republik Indonesia dipimpin oleh Presiden Soekarno selaku kepala pemerintahan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Tokoh yang memimpin delegasi Indonesia dalam Perundingan Renville di atas kapal perang USS Renville adalah...', 'ans' => 'Amir Sjarifuddin', 'opts' => ['Sutan Sjahrir', 'Mohammad Roem', 'Amir Sjarifuddin', 'Ali Sastroamidjojo']],
                ['t' => 'sulit', 'q' => 'Pahlawan kemerdekaan dari Papua yang mengusulkan nama "IRIAN" (Ikut Republik Indonesia Anti Nederland) adalah...', 'ans' => 'Frans Kaisiepo', 'opts' => ['Marthen Indey', 'Frans Kaisiepo', 'Silas Papare', 'Johannes Leimena']],
                ['t' => 'sulit', 'q' => 'Trisakti yang dicetuskan oleh Ir. Soekarno terdiri dari berdaulat dalam politik, berdikari dalam ekonomi, dan berkepribadian dalam kebudayaan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],
        ];
    }
}

<?php

namespace Database\Seeders\Dungeon;

class DungeonQuestionDatasetSmp
{
    /**
     * Mengambil daftar soal dungeon jenjang SMP per mapel (11 mapel).
     * Masing-masing mapel memiliki minimal 30 soal (10 Mudah, 10 Sedang, 10 Sulit).
     */
    public static function getQuestionsByMapel(): array
    {
        return [
            // -------------------------------------------------------------------------
            // MAPEL 1: MATEMATIKA SMP
            // -------------------------------------------------------------------------
            1 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Hasil dari (-15) + 27 adalah...', 'ans' => '12', 'opts' => ['-12', '12', '42', '-42']],
                ['t' => 'mudah', 'q' => 'Hasil dari (-8) x (-6) adalah...', 'ans' => '48', 'opts' => ['-48', '-14', '14', '48']],
                ['t' => 'mudah', 'q' => 'Bentuk sederhana dari 3x + 5y - x + 2y adalah...', 'ans' => '2x + 7y', 'opts' => ['2x + 7y', '4x + 7y', '2x + 3y', '4x + 3y']],
                ['t' => 'mudah', 'q' => 'Jika 2x = 18, maka nilai x adalah...', 'ans' => '9', 'opts' => ['6', '8', '9', '12']],
                ['t' => 'mudah', 'q' => 'KPK dari 12 dan 16 adalah...', 'ans' => '48', 'opts' => ['24', '36', '48', '64']],
                ['t' => 'mudah', 'q' => 'FPB dari 24 dan 36 adalah...', 'ans' => '12', 'opts' => ['6', '8', '12', '18']],
                ['t' => 'mudah', 'q' => 'Besar sudut siku-siku adalah tepat 90 derajat.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Sebuah segitiga memiliki alas 12 cm dan tinggi 5 cm. Luasnya adalah...', 'ans' => '30 cm²', 'opts' => ['17 cm²', '30 cm²', '60 cm²', '72 cm²']],
                ['t' => 'mudah', 'q' => 'Bilangan prima antara 10 dan 20 adalah...', 'ans' => '11, 13, 17, 19', 'opts' => ['11, 13, 15, 17', '11, 13, 17, 19', '11, 15, 17, 19', '13, 15, 17, 19']],
                ['t' => 'mudah', 'q' => 'Hasil dari 5 pangkat 3 (5³) adalah...', 'ans' => '125', 'opts' => ['15', '25', '75', '125']],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Teorema Pythagoras pada segitiga siku-siku dengan sisi siku-siku a dan b serta hipotenusa c adalah...', 'ans' => 'a² + b² = c²', 'opts' => ['a² + b² = c²', 'a + b = c', 'a² - b² = c²', 'c² + a² = b²']],
                ['t' => 'sedang', 'q' => 'Panjang hipotenusa segitiga siku-siku dengan panjang sisi siku-siku 6 cm dan 8 cm adalah...', 'ans' => '10 cm', 'opts' => ['9 cm', '10 cm', '12 cm', '14 cm']],
                ['t' => 'sedang', 'q' => 'Gradien (kemiringan) garis dengan persamaan y = 3x - 5 adalah...', 'ans' => '3', 'opts' => ['-5', '3', '-3', '5']],
                ['t' => 'sedang', 'q' => 'Rata-rata (mean) dari data: 7, 8, 6, 9, 10 adalah...', 'ans' => '8', 'opts' => ['7,5', '8', '8,5', '9']],
                ['t' => 'sedang', 'q' => 'Median dari data terurut: 4, 5, 7, 8, 9, 11 adalah...', 'ans' => '7,5', 'opts' => ['7', '7,5', '8', '8,5']],
                ['t' => 'sedang', 'q' => 'Keliling lingkaran dengan jari-jari 7 cm (pi = 22/7) adalah...', 'ans' => '44 cm', 'opts' => ['22 cm', '44 cm', '88 cm', '154 cm']],
                ['t' => 'sedang', 'q' => 'Jika f(x) = 2x + 7, maka nilai f(4) adalah...', 'ans' => '15', 'opts' => ['11', '13', '15', '17']],
                ['t' => 'sedang', 'q' => 'Dua garis dikatakan saling sejajar jika memiliki gradien yang sama.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Sebuah dadu bersisi 6 dilempar sekali. Peluang munculnya mata dadu genap adalah...', 'ans' => '1/2', 'opts' => ['1/6', '1/3', '1/2', '2/3']],
                ['t' => 'sedang', 'q' => 'Himpunan penyelesaian dari 3x - 4 < 11 dengan x bilangan bulat positif adalah...', 'ans' => '{1, 2, 3, 4}', 'opts' => ['{1, 2, 3}', '{1, 2, 3, 4}', '{0, 1, 2, 3, 4}', '{1, 2, 3, 4, 5}']],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Sistem persamaan linear 2x + y = 11 dan x - y = 1 memiliki nilai x dan y berturut-turut...', 'ans' => 'x = 4 dan y = 3', 'opts' => ['x = 4 dan y = 3', 'x = 3 dan y = 5', 'x = 5 dan y = 1', 'x = 2 dan y = 7']],
                ['t' => 'sulit', 'q' => 'Volume kerucut dengan jari-jari 7 cm dan tinggi 12 cm adalah... (pi = 22/7)', 'ans' => '616 cm³', 'opts' => ['308 cm³', '616 cm³', '1.232 cm³', '1.848 cm³']],
                ['t' => 'sulit', 'q' => 'Suku ke-20 dari barisan aritmatika 3, 7, 11, 15, ... adalah...', 'ans' => '79', 'opts' => ['75', '79', '83', '87']],
                ['t' => 'sulit', 'q' => 'Sebuah bola memiliki jari-jari 21 cm. Luas permukaan bola tersebut adalah... (pi = 22/7)', 'ans' => '5.544 cm²', 'opts' => ['1.386 cm²', '2.772 cm²', '5.544 cm²', '38.808 cm²']],
                ['t' => 'sulit', 'q' => 'Dua koin dilempar bersamaan. Peluang muncul paling sedikit satu angka adalah...', 'ans' => '3/4', 'opts' => ['1/4', '1/2', '3/4', '1']],
                ['t' => 'sulit', 'q' => 'Persamaan kuadrat x² - 5x + 6 = 0 memiliki akar-akar penyelesaian...', 'ans' => 'x = 2 atau x = 3', 'opts' => ['x = -2 atau x = -3', 'x = 2 atau x = 3', 'x = 1 atau x = 6', 'x = -1 atau x = -6']],
                ['t' => 'sulit', 'q' => 'Fungsi kuadrat f(x) = x² - 4x + 3 memiliki titik puncak minimum di koordinat...', 'ans' => '(2, -1)', 'opts' => ['(2, -1)', '(-2, 1)', '(4, 3)', '(2, 3)']],
                ['t' => 'sulit', 'q' => 'Suatu tiang tingginya 12 m berdiri tegak di atas tanah. Seutas kawat diikatkan dari puncak tiang ke tanah yang berjarak 5 m dari kaki tiang. Panjang kawat adalah...', 'ans' => '13 meter', 'opts' => ['11 meter', '13 meter', '15 meter', '17 meter']],
                ['t' => 'sulit', 'q' => 'Jika selisih dua bilangan adalah 5 dan hasil kalinya 84, kedua bilangan tersebut adalah...', 'ans' => '12 dan 7', 'opts' => ['14 dan 6', '12 dan 7', '15 dan 10', '21 dan 4']],
                ['t' => 'sulit', 'q' => 'Bentuk rasional dari penyebut pecahan 6 / √3 adalah...', 'ans' => '2√3', 'opts' => ['√3', '2√3', '3√3', '6√3']],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 2: BAHASA INDONESIA SMP
            // -------------------------------------------------------------------------
            2 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Teks yang menggambarkan objek secara rinci sehingga pembaca seolah melihat atau merasakannya sendiri disebut teks...', 'ans' => 'Deskripsi', 'opts' => ['Eksposisi', 'Deskripsi', 'Eksplanasi', 'Laporan Hasil Observasi']],
                ['t' => 'mudah', 'q' => 'Sinonim dari kata "orisinal" adalah...', 'ans' => 'Asli', 'opts' => ['Tiruan', 'Asli', 'Modern', 'Lengkap']],
                ['t' => 'mudah', 'q' => 'Struktur teks deskripsi terdiri dari identifikasi dan deskripsi bagian.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Kalimat yang berisi perintah atau larangan disebut kalimat...', 'ans' => 'Imperatif', 'opts' => ['Deklaratif', 'Interogatif', 'Imperatif', 'Eksklamatif']],
                ['t' => 'mudah', 'q' => 'Penulisan kata baku yang tepat adalah...', 'ans' => 'Kuitansi', 'opts' => ['Kwitansi', 'Kuitansi', 'Kwitansi', 'Kwintansi']],
                ['t' => 'mudah', 'q' => 'Tokoh utama yang menjadi penentang tokoh protagonis dalam drama disebut...', 'ans' => 'Antagonis', 'opts' => ['Tritagonis', 'Antagonis', 'Figuran', 'Deuteragonis']],
                ['t' => 'mudah', 'q' => 'Bagian surat dinas yang menunjukkan instansi atau lembaga pengirim surat adalah...', 'ans' => 'Kepala surat (Kop surat)', 'opts' => ['Kepala surat (Kop surat)', 'Nomor surat', 'Alamat tujuan', 'Lampiran']],
                ['t' => 'mudah', 'q' => 'Kata tanya "mengapa" digunakan untuk menanyakan...', 'ans' => 'Sebab atau alasan', 'opts' => ['Waktu', 'Tempat', 'Sebab atau alasan', 'Cara']],
                ['t' => 'mudah', 'q' => 'Gagasan pokok dalam sebuah paragraf dapat terletak di awal (deduktif) maupun di akhir (induktif).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Teks laporan hasil observasi harus disusun berdasarkan fakta dan data nyata dari pengamatan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Teks eksposisi bertujuan untuk...', 'ans' => 'Menjelaskan informasi secara objektif disertai argumen', 'opts' => ['Menghibur pembaca dengan cerita khayal', 'Menjelaskan informasi secara objektif disertai argumen', 'Menceritakan kembali masa lalu', 'Menggambarkan watak tokoh']],
                ['t' => 'sedang', 'q' => 'Unsur 5W + 1H dalam penulisan teks berita mencakup apa, siapa, di mana, kapan, mengapa, dan bagaimana.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Kalimat yang menggunakan majas metafora adalah...', 'ans' => 'Raja siang mulai terik menyinari padang pasir', 'opts' => ['Angin malam berbisik lembut di telingaku', 'Raja siang mulai terik menyinari padang pasir', 'Suaranya menggelegar membelah angkasa', 'Pena itu menari-nari di atas kertas']],
                ['t' => 'sedang', 'q' => 'Struktur teks fabel umumnya terdiri dari...', 'ans' => 'Orientasi, komplikasi, resolusi, koda', 'opts' => ['Orientasi, komplikasi, resolusi, koda', 'Tesis, argumen, penegasan ulang', 'Pernyataan umum, deretan penjelas, interpretasi', 'Abstraksi, orientasi, krisis, reaksi']],
                ['t' => 'sedang', 'q' => 'Konjungsi kronologis (urutan waktu) yang tepat adalah...', 'ans' => 'Kemudian, lalu, setelah itu', 'opts' => ['Karena, sebab, akibatnya', 'Kemudian, lalu, setelah itu', 'Jika, jikalau, seandainya', 'Walaupun, meskipun, kendati']],
                ['t' => 'sedang', 'q' => 'Unsur intrinsik cerpen yang berkaitan dengan tempat, waktu, dan suasana cerita disebut...', 'ans' => 'Latar (setting)', 'opts' => ['Alur', 'Latar (setting)', 'Penokohan', 'Sudut pandang']],
                ['t' => 'sedang', 'q' => 'Puisi rakyat yang terdiri atas dua baris dalam satu bait dan bersajak a-a disebut...', 'ans' => 'Gurindam', 'opts' => ['Pantun', 'Syair', 'Gurindam', 'Karmina']],
                ['t' => 'sedang', 'q' => 'Kalimat langsung harus diapit oleh tanda petik ganda ("...").', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Kalimat pasif ditandai dengan predikat berimbuhan di- atau ter-.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Buku yang memuat kisah atau karangan imajinatif disebut buku fiksi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Teks ulasan buku atau karya seni biasanya memuat bagian evaluasi yang menilai...', 'ans' => 'Kelebihan dan kelemahan karya secara kritis', 'opts' => ['Harga cetak buku', 'Kelebihan dan kelemahan karya secara kritis', 'Kekayaan penulis', 'Desain percetakan saja']],
                ['t' => 'sulit', 'q' => 'Struktur teks eksplanasi secara berurutan adalah...', 'ans' => 'Identifikasi fenomena, rangkaian proses kejadian, ulasan (interpretasi)', 'opts' => ['Tesis, argumentasi, penegasan ulang', 'Identifikasi fenomena, rangkaian proses kejadian, ulasan (interpretasi)', 'Orientasi, evaluasi, komplikasi', 'Pernyataan umum, aspek yang dilaporkan']],
                ['t' => 'sulit', 'q' => 'Kalimat persuasif yang bertujuan mengajak masyarakat menghemat energi listrik adalah...', 'ans' => 'Matikan lampu dan peralatan elektronik jika tidak digunakan!', 'opts' => ['Listrik sangat bermanfaat untuk kehidupan kita.', 'Matikan lampu dan peralatan elektronik jika tidak digunakan!', 'Tagihan listrik bulan ini meningkat drastis.', 'Pembangkit listrik tenaga uap menghasilkan polusi.']],
                ['t' => 'sulit', 'q' => 'Perbedaan utama antara teks diskusi dan teks eksposisi adalah teks diskusi menyajikan...', 'ans' => 'Dua sudut pandang berbeda (pro dan kontra) secara berimbang', 'opts' => ['Opini sepihak pengarang saja', 'Dua sudut pandang berbeda (pro dan kontra) secara berimbang', 'Langkah-langkah pembuatan karya', 'Data riwayat hidup tokoh']],
                ['t' => 'sulit', 'q' => 'Sudut pandang orang pertama dalam cerita ditandai dengan penggunaan kata ganti...', 'ans' => 'Aku atau Saya', 'opts' => ['Dia atau Ia', 'Mereka', 'Aku atau Saya', 'Beliau']],
                ['t' => 'sulit', 'q' => 'Gaya penulisan pidato persuasif yang efektif menggunakan pendekatan etika, emosi, dan logika.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Pernyataan retoris dalam teks pidato adalah pertanyaan yang...', 'ans' => 'Tidak memerlukan jawaban karena jawabannya sudah jelas', 'opts' => ['Sangat sulit dijawab pendengar', 'Tidak memerlukan jawaban karena jawabannya sudah jelas', 'Wajib dijawab serentak oleh audiens', 'Berisi rumus matematika']],
                ['t' => 'sulit', 'q' => 'Makna lugas (denotatif) dari kata "bunga" adalah bagian tumbuhan yang akan menjadi buah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Penulisan daftar pustaka yang benar berdasarkan format APA/EBI diawali dengan...', 'ans' => 'Nama belakang penulis', 'opts' => ['Judul buku', 'Nama belakang penulis', 'Tahun terbit', 'Kota penerbit']],
                ['t' => 'sulit', 'q' => 'Alur cerita yang diawali dari masa kini, lalu menceritakan masa lalu, kemudian kembali ke masa kini disebut alur...', 'ans' => 'Campuran (Flashback)', 'opts' => ['Maju (Progresif)', 'Mundur (Regresif)', 'Campuran (Flashback)', 'Sirkuler']],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 3: BAHASA INGGRIS SMP
            // -------------------------------------------------------------------------
            3 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'What is the past form of the verb "eat"?', 'ans' => 'Ate', 'opts' => ['Eaten', 'Eating', 'Ate', 'Eats']],
                ['t' => 'mudah', 'q' => '"She ... a talented singer." Choose the correct verb to be:', 'ans' => 'is', 'opts' => ['am', 'is', 'are', 'were']],
                ['t' => 'mudah', 'q' => 'What is the opposite of "Difficult"?', 'ans' => 'Easy', 'opts' => ['Hard', 'Easy', 'Heavy', 'Complicated']],
                ['t' => 'mudah', 'q' => 'Which word is a noun?', 'ans' => 'Chair', 'opts' => ['Run', 'Beautiful', 'Quickly', 'Chair']],
                ['t' => 'mudah', 'q' => '"Congratulations on your graduation!" expresses praise and appreciation.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'What modal auxiliary expresses ability?', 'ans' => 'Can', 'opts' => ['Must', 'Should', 'Can', 'May']],
                ['t' => 'mudah', 'q' => 'The plural form of "tooth" is...', 'ans' => 'Teeth', 'opts' => ['Tooths', 'Teeth', 'Teethes', 'Toothies']],
                ['t' => 'mudah', 'q' => '"I am sorry for coming late." expresses an apology.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Choose the correct preposition: "The class starts ... 07.00 AM."', 'ans' => 'at', 'opts' => ['on', 'in', 'at', 'by']],
                ['t' => 'mudah', 'q' => 'What is the comparative degree of "good"?', 'ans' => 'Better', 'opts' => ['Gooder', 'Better', 'Best', 'More good']],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'The generic structure of a Recount Text is...', 'ans' => 'Orientation, Events, Reorientation', 'opts' => ['Goal, Materials, Steps', 'Orientation, Complication, Resolution', 'Orientation, Events, Reorientation', 'Identification, Description']],
                ['t' => 'sedang', 'q' => '"While mother was cooking, father ... the newspaper."', 'ans' => 'was reading', 'opts' => ['reads', 'is reading', 'was reading', 'will read']],
                ['t' => 'sedang', 'q' => 'Change into passive voice: "Active: Rina opens the door."', 'ans' => 'The door is opened by Rina', 'opts' => ['The door was opened by Rina', 'The door is opened by Rina', 'The door has opened by Rina', 'The door opened by Rina']],
                ['t' => 'sedang', 'q' => 'Which conjunction indicates contrast?', 'ans' => 'Although', 'opts' => ['Because', 'Therefore', 'Although', 'Moreover']],
                ['t' => 'sedang', 'q' => '"You should see a doctor soon." The modal "should" gives...', 'ans' => 'Advice / Suggestion', 'opts' => ['Prohibition', 'Advice / Suggestion', 'Permission', 'Command']],
                ['t' => 'sedang', 'q' => 'What type of text tells a chronological folklore or fairy tale?', 'ans' => 'Narrative text', 'opts' => ['Procedure text', 'Narrative text', 'Report text', 'Descriptive text']],
                ['t' => 'sedang', 'q' => 'The superlative degree of "expensive" is "most expensive".', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Complete the sentence: "If it rains tomorrow, we ... stay at home."', 'ans' => 'will', 'opts' => ['would', 'will', 'had', 'were']],
                ['t' => 'sedang', 'q' => '"May I borrow your ruler?" is an expression of asking for permission.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'What is the main purpose of a Procedure Text?', 'ans' => 'To explain how to make or do something step by step', 'opts' => ['To persuade readers', 'To explain how to make or do something step by step', 'To report scientific phenomena', 'To describe personal feeling']],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Identify the Present Perfect Tense sentence:', 'ans' => 'They have lived in Jakarta for ten years', 'opts' => ['They lived in Jakarta ten years ago', 'They have lived in Jakarta for ten years', 'They will live in Jakarta next year', 'They were living in Jakarta']],
                ['t' => 'sulit', 'q' => 'Change into passive: "Shakespeare wrote Romeo and Juliet."', 'ans' => 'Romeo and Juliet was written by Shakespeare', 'opts' => ['Romeo and Juliet is written by Shakespeare', 'Romeo and Juliet was written by Shakespeare', 'Romeo and Juliet has been written by Shakespeare', 'Romeo and Juliet wrote by Shakespeare']],
                ['t' => 'sulit', 'q' => 'Complete the conditional sentence Type 2: "If I ... a bird, I would fly around the world."', 'ans' => 'were', 'opts' => ['am', 'was', 'were', 'had been']],
                ['t' => 'sulit', 'q' => 'The word "however" has a similar meaning to "nevertheless".', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'A factual text that describes natural or social phenomena from a scientific point of view is a...', 'ans' => 'Report Text', 'opts' => ['Descriptive Text', 'Recount Text', 'Report Text', 'Narrative Text']],
                ['t' => 'sulit', 'q' => 'Identify the sentence with an adjective clause:', 'ans' => 'The girl who won the singing contest is my niece', 'opts' => ['The girl sang beautifully on stage', 'The girl who won the singing contest is my niece', 'Because she practiced hard, she won', 'She won the contest yesterday']],
                ['t' => 'sulit', 'q' => '"Neither Joni nor his brothers ... attending the party tonight."', 'ans' => 'are', 'opts' => ['is', 'are', 'was', 'be']],
                ['t' => 'sulit', 'q' => 'What does the idiom "A piece of cake" mean?', 'ans' => 'Very easy to do', 'opts' => ['Delicious food', 'Very easy to do', 'Extremely heavy', 'Expensive treat']],
                ['t' => 'sulit', 'q' => 'Choose the correct indirect speech: Direct: He said, "I am tired."', 'ans' => 'He said that he was tired', 'opts' => ['He said that I was tired', 'He said that he was tired', 'He said that he is tired', 'He said that I am tired']],
                ['t' => 'sulit', 'q' => 'The synonym of the word "enormous" is "huge / gigantic".', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 4: IPA SMP
            // -------------------------------------------------------------------------
            4 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Satuan internasional (SI) untuk besaran suhu adalah...', 'ans' => 'Kelvin', 'opts' => ['Celsius', 'Kelvin', 'Fahrenheit', 'Reaumur']],
                ['t' => 'mudah', 'q' => 'Alat untuk mengukur kuat arus listrik dalam rangkaian adalah...', 'ans' => 'Amperemeter', 'opts' => ['Voltmeter', 'Amperemeter', 'Ohmmeter', 'Barometer']],
                ['t' => 'mudah', 'q' => 'Molekul air tersusun atas unsur hidrogen dan oksigen dengan rumus kimia...', 'ans' => 'H₂O', 'opts' => ['CO₂', 'H₂O', 'O₂', 'NaCl']],
                ['t' => 'mudah', 'q' => 'Organel sel yang berfungsi sebagai tempat penghasil energi (respirasi seluler) adalah...', 'ans' => 'Mitokondria', 'opts' => ['Nukleus', 'Mitokondria', 'Ribosom', 'Kloroplas']],
                ['t' => 'mudah', 'q' => 'Sel tumbuhan memiliki dinding sel yang terbuat dari selulosa, sedangkan sel hewan tidak.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Besaran pokok dalam fisika antara lain panjang, massa, dan waktu.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Kecepatan adalah perpindahan yang ditempuh per satuan waktu.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Zat yang memiliki pH lebih kecil dari 7 digolongkan sebagai larutan...', 'ans' => 'Asam', 'opts' => ['Basa', 'Netral', 'Asam', 'Garam']],
                ['t' => 'mudah', 'q' => 'Kertas lakmus merah akan berubah menjadi biru jika dicelupkan ke dalam larutan basa.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Peristiwa pembelahan sel yang menghasilkan sel gamet (sel kelamin) dengan jumlah kromosom separuh disebut...', 'ans' => 'Meiosis', 'opts' => ['Mitosis', 'Meiosis', 'Amitosis', 'Biner']],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Hukum II Newton menyatakan bahwa percepatan sebanding dengan gaya dan berbanding terbalik dengan...', 'ans' => 'Massa benda (F = m.a)', 'opts' => ['Kecepatan', 'Massa benda (F = m.a)', 'Volume benda', 'Berat jenis']],
                ['t' => 'sedang', 'q' => 'Sebuah benda bermassa 2 kg ditarik dengan gaya 10 N. Percepatan benda tersebut adalah...', 'ans' => '5 m/s²', 'opts' => ['2 m/s²', '5 m/s²', '12 m/s²', '20 m/s²']],
                ['t' => 'sedang', 'q' => 'Hukum Ohm menghubungkan tegangan (V), arus (I), dan hambatan (R) dengan rumus...', 'ans' => 'V = I x R', 'opts' => ['V = I / R', 'V = I x R', 'R = V x I', 'I = V x R']],
                ['t' => 'sedang', 'q' => 'Enzim ptialin (amilase) di dalam rongga mulut berfungsi mengubah amilum menjadi...', 'ans' => 'Maltosa / Glukosa', 'opts' => ['Asam amino', 'Maltosa / Glukosa', 'Asam lemak', 'Gliserol']],
                ['t' => 'sedang', 'q' => 'Organ tubuh manusia yang berfungsi menyaring darah dan menghasilkan urine adalah...', 'ans' => 'Ginjal', 'opts' => ['Hati', 'Ginjal', 'Paru-paru', 'Pankreas']],
                ['t' => 'sedang', 'q' => 'Hukum pemantulan cahaya menyatakan bahwa sudut datang (i) sama dengan sudut pantul (r).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Contoh tuas (pengungkit) jenis pertama di mana titik tumpu berada di antara titik beban dan kuasa adalah...', 'ans' => 'Gunting', 'opts' => ['Gerobak dorong roda satu', 'Gunting', 'Pinset', 'Sekop']],
                ['t' => 'sedang', 'q' => 'Bunyi dengan frekuensi antara 20 Hz sampai 20.000 Hz yang dapat didengar manusia disebut bunyi...', 'ans' => 'Audiosonik', 'opts' => ['Infrasonik', 'Audiosonik', 'Ultrasonik', 'Supersonik']],
                ['t' => 'sedang', 'q' => 'Persilangan monohibrid dominan penuh antara bunga merah (MM) dan bunga putih (mm) menghasilkan F1 berfenotipe...', 'ans' => '100% Merah', 'opts' => ['100% Putih', '100% Merah', '50% Merah, 50% Putih', '75% Merah, 25% Putih']],
                ['t' => 'sedang', 'q' => 'Lapisan atmosfer yang menjadi tempat berlangsungnya peristiwa cuaca seperti hujan dan angin adalah...', 'ans' => 'Troposfer', 'opts' => ['Stratosfer', 'Mesosfer', 'Troposfer', 'Termosfer']],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Tekanan hidrostatis zat cair berbanding lurus dengan massa jenis, percepatan gravitasi, dan...', 'ans' => 'Kedalaman zat cair (P = ρ.g.h)', 'opts' => ['Luas permukaan bejana', 'Kedalaman zat cair (P = ρ.g.h)', 'Volume total air', 'Suhu zat cair']],
                ['t' => 'sulit', 'q' => 'Benda bermassa 5 kg berada pada ketinggian 10 m di atas tanah (g = 10 m/s²). Energi potensialnya adalah...', 'ans' => '500 Joule', 'opts' => ['50 Joule', '250 Joule', '500 Joule', '1.000 Joule']],
                ['t' => 'sulit', 'q' => 'Pada pembelahan mitosis, tahap di mana kromosom berjajar di bidang ekuator disebut tahap...', 'ans' => 'Metafase', 'opts' => ['Profase', 'Metafase', 'Anafase', 'Telofase']],
                ['t' => 'sulit', 'q' => 'Hukum Archimedes menyatakan bahwa gaya apung ke atas sama dengan berat zat cair yang dipindahkan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Zat aditif makanan MSG (Monosodium Glutamat) berfungsi sebagai...', 'ans' => 'Penguat rasa / penyedap', 'opts' => ['Pewarna buatan', 'Pemanis buatan', 'Penguat rasa / penyedap', 'Pengawet']],
                ['t' => 'sulit', 'q' => 'Hormon insulin yang mengatur kadar gula darah dihasilkan oleh kelenjar...', 'ans' => 'Pankreas', 'opts' => ['Tiroid', 'Hipofisis', 'Pankreas', 'Adrenal']],
                ['t' => 'sulit', 'q' => 'Cahaya merambat paling cepat di ruang hampa dengan kecepatan mendekati...', 'ans' => '3 x 10⁸ m/s', 'opts' => ['3 x 10⁶ m/s', '3 x 10⁸ m/s', '340 m/s', '3 x 10¹⁰ m/s']],
                ['t' => 'sulit', 'q' => 'Peristiwa resonansi bunyi terjadi jika dua sumber bunyi memiliki frekuensi alami yang sama.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Pembentukan urine di nefron ginjal melalui tiga tahapan utama berurutan, yaitu...', 'ans' => 'Filtrasi, reabsorpsi, augmentasi', 'opts' => ['Reabsorpsi, filtrasi, augmentasi', 'Filtrasi, augmentasi, reabsorpsi', 'Filtrasi, reabsorpsi, augmentasi', 'Sekresi, filtrasi, ekskresi']],
                ['t' => 'sulit', 'q' => 'Bioteknologi konvensional pembuatan tempe memanfaatkan mikroorganisme jamur...', 'ans' => 'Rhizopus oryzae', 'opts' => ['Saccharomyces cerevisiae', 'Rhizopus oryzae', 'Lactobacillus bulgaricus', 'Acetobacter xylinum']],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 5: IPS SMP
            // -------------------------------------------------------------------------
            5 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Benua terluas di dunia adalah Benua...', 'ans' => 'Asia', 'opts' => ['Afrika', 'Amerika', 'Asia', 'Eropa']],
                ['t' => 'mudah', 'q' => 'Kawasan Asia Tenggara memiliki iklim tropis karena dilalui oleh garis khatulistiwa.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Hukum permintaan menyatakan jika harga barang naik, maka jumlah barang yang diminta akan...', 'ans' => 'Turun', 'opts' => ['Naik', 'Turun', 'Tetap', 'Tidak terpengaruh']],
                ['t' => 'mudah', 'q' => 'Kegiatan menjual barang buatan dalam negeri ke luar negeri disebut...', 'ans' => 'Ekspor', 'opts' => ['Impor', 'Ekspor', 'Barter', 'Reekspor']],
                ['t' => 'mudah', 'q' => 'Organisasi negara-negara pengekspor minyak bumi disebut...', 'ans' => 'OPEC', 'opts' => ['ASEAN', 'OPEC', 'APEC', 'WHO']],
                ['t' => 'mudah', 'q' => 'Negara tetangga Indonesia yang berbentuk kerajaan dan beribu kota di Kuala Lumpur adalah...', 'ans' => 'Malaysia', 'opts' => ['Singapura', 'Malaysia', 'Thailand', 'Filipina']],
                ['t' => 'mudah', 'q' => 'Perpindahan penduduk dari desa ke kota disebut urbanisasi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Bentuk interaksi sosial yang bersifat mengarah pada persatuan dan kerja sama disebut interaksi asosiatif.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Pasar tempat bertemunya penjual dan pembeli secara langsung untuk bertransaksi barang fisik disebut pasar konkret.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Faktor produksi alam contohnya adalah tanah, air, udara, dan sinar matahari.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Letak astronomis Indonesia berada di antara...', 'ans' => '6°LU - 11°LS dan 95°BT - 141°BT', 'opts' => ['6°LU - 11°LS dan 95°BT - 141°BT', '11°LU - 6°LS dan 90°BT - 140°BT', '0° - 15°LU dan 100°BT - 150°BT', '5°LU - 10°LS dan 95°BB - 141°BB']],
                ['t' => 'sedang', 'q' => 'Dampak letak geologis Indonesia yang berada pada pertemuan tiga lempeng tektonik utama adalah...', 'ans' => 'Banyak gunung berapi aktif dan rawan gempa bumi', 'opts' => ['Memiliki empat musim dalam setahun', 'Banyak gunung berapi aktif dan rawan gempa bumi', 'Bebas dari bencana alam geologi', 'Kekurangan sumber daya mineral']],
                ['t' => 'sedang', 'q' => 'Kerajaan maritim terbesar di Nusantara yang bercorak Buddha di Palembang adalah...', 'ans' => 'Kerajaan Sriwijaya', 'opts' => ['Kerajaan Majapahit', 'Kerajaan Sriwijaya', 'Kerajaan Kutai', 'Kerajaan Samudera Pasai']],
                ['t' => 'sedang', 'q' => 'Patih Majapahit yang mengucapkan Sumpah Palapa untuk menyatukan Nusantara adalah...', 'ans' => 'Gajah Mada', 'opts' => ['Hayam Wuruk', 'Gajah Mada', 'Kertanegara', 'Raden Wijaya']],
                ['t' => 'sedang', 'q' => 'Kurva penawaran memiliki kemiringan (slope) positif bergerak dari kiri bawah ke kanan atas.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Perubahan sosial budaya yang berlangsung secara lambat dalam kurun waktu lama disebut...', 'ans' => 'Evolusi', 'opts' => ['Revolusi', 'Evolusi', 'Inovasi', 'Akulturasi']],
                ['t' => 'sedang', 'q' => 'Lembaga sosial terkecil dan pertama dalam membentuk kepribadian seorang anak adalah...', 'ans' => 'Keluarga', 'opts' => ['Sekolah', 'Keluarga', 'Masyarakat', 'Lembaga agama']],
                ['t' => 'sedang', 'q' => 'Saluran mobilitas sosial vertikal naik yang paling terbuka bagi setiap lapisan masyarakat adalah...', 'ans' => 'Pendidikan', 'opts' => ['Kasta', 'Kekerabatan', 'Pendidikan', 'Warisan']],
                ['t' => 'sedang', 'q' => 'Piramida penduduk dengan dasar lebar dan puncak mengerucut menunjukkan...', 'ans' => 'Pertumbuhan penduduk yang tinggi (usia muda dominan)', 'opts' => ['Penduduk usia tua lebih banyak', 'Pertumbuhan penduduk yang tinggi (usia muda dominan)', 'Jumlah kelahiran sama dengan kematian', 'Penurunan angka kelahiran drastis']],
                ['t' => 'sedang', 'q' => 'Perjanjian Tordesillas membagi wilayah penjelajahan dunia di luar Eropa antara Spanyol dan Portugal.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Konferensi Asia Afrika (KAA) 1955 di Bandung diprakarsai oleh 5 negara, yaitu Indonesia, India, Pakistan, Burma, dan...', 'ans' => 'Sri Lanka (Ceylon)', 'opts' => ['Mesir', 'Sri Lanka (Ceylon)', 'Filipina', 'Thailand']],
                ['t' => 'sulit', 'q' => 'Kebijakan moneter bank sentral untuk mengatasi inflasi dengan cara menaikkan suku bunga acuan disebut...', 'ans' => 'Kebijakan diskonto', 'opts' => ['Operasi pasar terbuka', 'Kebijakan diskonto', 'Cadangan kas minimum', 'Dorongan moral']],
                ['t' => 'sulit', 'q' => 'Proses meleburnya dua kebudayaan menjadi satu kebudayaan baru tanpa menghilangkan ciri kepribadian aslinya disebut...', 'ans' => 'Akulturasi', 'opts' => ['Asimilasi', 'Akulturasi', 'Difusi', 'Enkulturasi']],
                ['t' => 'sulit', 'q' => 'Kerajaan Islam pertama di kepulauan Nusantara yang didirikan oleh Marah Silu adalah...', 'ans' => 'Samudera Pasai', 'opts' => ['Kesultanan Demak', 'Samudera Pasai', 'Kesultanan Malaka', 'Kesultanan Mataram']],
                ['t' => 'sulit', 'q' => 'Teori Masuknya Hindu-Buddha yang menyatakan bahwa penyebaran agama dibawa oleh kaum pedagang adalah Teori...', 'ans' => 'Waisya', 'opts' => ['Brahmana', 'Ksatria', 'Waisya', 'Arus Balik']],
                ['t' => 'sulit', 'q' => 'Deklarasi Djuanda 13 Desember 1957 mengubah batas laut teritorial Indonesia dari 3 mil menjadi...', 'ans' => '12 mil laut', 'opts' => ['12 mil laut', '24 mil laut', '100 mil laut', '200 mil laut (ZEE)']],
                ['t' => 'sulit', 'q' => 'Pasar monopoli adalah bentuk pasar di mana hanya terdapat satu penjual yang menguasai seluruh penawaran barang.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Pendapatan per kapita diperoleh dari membagi total Pendapatan Nasional dengan...', 'ans' => 'Jumlah seluruh penduduk', 'opts' => ['Jumlah tenaga kerja', 'Jumlah seluruh penduduk', 'Total luas wilayah', 'Total konsumsi masyarakat']],
                ['t' => 'sulit', 'q' => 'Dampak positif globalisasi di bidang ilmu pengetahuan dan teknologi adalah kemudahan akses informasi dunia.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Terusan Suez yang menghubungkan Laut Tengah dan Laut Merah terletak di negara...', 'ans' => 'Mesir', 'opts' => ['Panama', 'Mesir', 'Turki', 'Arab Saudi']],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 6: PPKN SMP
            // -------------------------------------------------------------------------
            6 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Pancasila disahkan sebagai dasar negara Republik Indonesia oleh PPKI pada tanggal...', 'ans' => '18 Agustus 1945', 'opts' => ['17 Agustus 1945', '18 Agustus 1945', '1 Juni 1945', '22 Juni 1945']],
                ['t' => 'mudah', 'q' => 'Hukum dasar tertulis tertinggi di Negara Kesatuan Republik Indonesia adalah...', 'ans' => 'UUD Negara Republik Indonesia Tahun 1945', 'opts' => ['Pancasila', 'UUD Negara Republik Indonesia Tahun 1945', 'Ketetapan MPR', 'Undang-Undang']],
                ['t' => 'mudah', 'q' => 'Kedaulatan berada di tangan rakyat dan dilaksanakan menurut Undang-Undang Dasar bunyi pasal 1 ayat 2 UUD 1945.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Bentuk negara Indonesia adalah Negara Kesatuan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Bentuk pemerintahan negara Indonesia adalah Republik.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Ikrar Sumpah Pemuda 28 Oktober 1928 mengakui bertumpah darah yang satu, berbangsa yang satu, dan menjunjung bahasa...', 'ans' => 'Persatuan, Bahasa Indonesia', 'opts' => ['Internasional', 'Persatuan, Bahasa Indonesia', 'Daerah', 'Sansekerta']],
                ['t' => 'mudah', 'q' => 'Sikap rela berkorban demi kepentingan bangsa dan negara disebut patriotisme.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Presiden Republik Indonesia memegang kekuasaan pemerintahan menurut Undang-Undang Dasar (Kekuasaan Eksekutif).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Hak Asasi Manusia (HAM) dimiliki setiap insan sejak lahir sebagai anugerah Tuhan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Pemilihan umum (Pemilu) di Indonesia dilaksanakan berdasarkan asas LUBER dan JURDIL.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Pemisahan kekuasaan negara menurut Montesquieu (Trias Politica) mencakup...', 'ans' => 'Legislatif, Eksekutif, Yudikatif', 'opts' => ['Federatif, Yudikatif, Monarki', 'Legislatif, Eksekutif, Yudikatif', 'Presidensial, Parlementer, Campuran', 'Otokrasi, Oligarki, Demokrasi']],
                ['t' => 'sedang', 'q' => 'Lembaga yang berwenang mengubah dan menetapkan Undang-Undang Dasar di Indonesia adalah...', 'ans' => 'MPR (Majelis Permusyawaratan Rakyat)', 'opts' => ['DPR', 'Presiden', 'MPR (Majelis Permusyawaratan Rakyat)', 'Mahkamah Konstitusi']],
                ['t' => 'sedang', 'q' => 'Lembaga yudikatif yang berwenang menguji undang-undang terhadap UUD 1945 adalah...', 'ans' => 'Mahkamah Konstitusi (MK)', 'opts' => ['Mahkamah Agung (MA)', 'Mahkamah Konstitusi (MK)', 'Komisi Yudisial (KY)', 'Kejaksaan Agung']],
                ['t' => 'sedang', 'q' => 'Pembukaan UUD 1945 alinea pertama memuat prinsip universal bahwa...', 'ans' => 'Kemerdekaan ialah hak segala bangsa dan penjajahan harus dihapuskan', 'opts' => ['Perjuangan telah mengantarkan rakyat ke depan gerbang kemerdekaan', 'Kemerdekaan ialah hak segala bangsa dan penjajahan harus dihapuskan', 'Atas berkat rahmat Allah Yang Maha Kuasa', 'Melindungi segenap bangsa Indonesia']],
                ['t' => 'sedang', 'q' => 'Pokok kaidah fundamental negara yang termuat dalam Pembukaan UUD 1945 tidak dapat diubah oleh siapapun.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Sistem pemerintahan di Indonesia adalah sistem...', 'ans' => 'Presidensial', 'opts' => ['Parlementer', 'Presidensial', 'Semipresidensial', 'Monarki konstitusional']],
                ['t' => 'sedang', 'q' => 'Prinsip Wawasan Nusantara menempatkan kepulauan Indonesia sebagai satu kesatuan politik, ekonomi, sosial budaya, dan pertahanan keamanan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Organisasi pertahanan rakyat semesta melibatkan TNI sebagai kekuatan utama dan rakyat sebagai kekuatan pendukung.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Kewenangan daerah otonom untuk mengatur dan mengurus kepentingan masyarakat setempat dinamakan...', 'ans' => 'Otonomi Daerah', 'opts' => ['Sentralisasi', 'Otonomi Daerah', 'Dekonsentrasi', 'Tugas Pembantuan']],
                ['t' => 'sedang', 'q' => 'Pancasila berfungsi sebagai sumber dari segala sumber hukum negara di Indonesia.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Pasal 33 ayat 3 UUD 1945 menegaskan bahwa bumi, air, dan kekayaan alam yang terkandung di dalamnya dikuasai oleh negara dan dipergunakan untuk...', 'ans' => 'Sebesar-besar kemakmuran rakyat', 'opts' => ['Modal pembangunan pihak swasta', 'Sebesar-besar kemakmuran rakyat', 'Keuntungan pejabat negara', 'Membayar utang luar negeri']],
                ['t' => 'sulit', 'q' => 'Hierarki peraturan perundang-undangan diatur dalam UU Nomor 12 Tahun 2011.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Komisi Yudisial (KY) berwenang mengusulkan pengangkatan hakim agung dan menjaga kehormatan serta perilaku hakim.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Amandemen UUD 1945 telah dilakukan oleh MPR sebanyak...', 'ans' => '4 kali (1999, 2000, 2001, 2002)', 'opts' => ['2 kali', '3 kali', '4 kali (1999, 2000, 2001, 2002)', '5 kali']],
                ['t' => 'sulit', 'q' => 'Hak DPR untuk meminta keterangan kepada pemerintah mengenai kebijakan penting yang berdampak luas disebut hak...', 'ans' => 'Interpelasi', 'opts' => ['Angket', 'Interpelasi', 'Menyatakan pendapat', 'Imunitas']],
                ['t' => 'sulit', 'q' => 'Hak DPR untuk melakukan penyelidikan terhadap pelaksanaan undang-undang atau kebijakan pemerintah disebut hak...', 'ans' => 'Angket', 'opts' => ['Interpelasi', 'Angket', 'Budget', 'Inisiatif']],
                ['t' => 'sulit', 'q' => 'Badan Pemeriksa Keuangan (BPK) adalah lembaga yang bebas dan mandiri bertugas memeriksa...', 'ans' => 'Pengelolaan dan tanggung jawab tentang keuangan negara', 'opts' => ['Kinerja aparatur kepolisian', 'Pengelolaan dan tanggung jawab tentang keuangan negara', 'Pelanggaran kode etik hakim', 'Kecurangan pemilu']],
                ['t' => 'sulit', 'q' => 'Konsep kedaulatan ke dalam (internal) bermakna kekuasaan pemerintah untuk...', 'ans' => 'Mengatur dan mengelola seluruh wilayah negara tanpa campur tangan negara lain', 'opts' => ['Menjalin hubungan diplomatik bebas', 'Mengatur dan mengelola seluruh wilayah negara tanpa campur tangan negara lain', 'Menyatakan perang kepada negara tetangga', 'Menguasai perdagangan internasional']],
                ['t' => 'sulit', 'q' => 'Paham chauvinisme adalah bentuk cinta tanah air yang berlebihan hingga memandang rendah bangsa lain.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Kewarganegaraan ganda terbatas di Indonesia diatur bagi anak hasil perkawinan campur hingga berusia 18 tahun.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 7: PENDIDIKAN AGAMA & BUDI PEKERTI SMP
            // -------------------------------------------------------------------------
            7 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Kitab suci Al-Qur\'an diturunkan kepada Nabi Muhammad SAW melalui perantara Malaikat...', 'ans' => 'Jibril', 'opts' => ['Mikail', 'Israfil', 'Izrail', 'Jibril']],
                ['t' => 'mudah', 'q' => 'Hukum membaca Al-Qur\'an dengan kaidah tajwid yang benar adalah fardhu \'ain.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Sikap istiqomah bermakna teguh pendirian dalam mempertahankan kebenaran.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Hari kiamat (kiamat kubra) pasti akan terjadi dan menjadi rukun iman kelima.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Salat fardhu yang dapat dijamak dan diqasar saat bepergian jauh (safar) adalah Dzuhur, Ashar, dan Isya.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Zakat mal wajib dikeluarkan bagi harta yang telah mencapai nishab dan haul.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Sikap tasamuh dalam kehidupan bermasyarakat memiliki arti...', 'ans' => 'Toleransi', 'opts' => ['Kikir', 'Toleransi', 'Putus asa', 'Dusta']],
                ['t' => 'mudah', 'q' => 'Ibadah haji ke Baitullah merupakan rukun Islam yang kelima bagi yang mampu.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Menghormati guru merupakan adab yang sangat mulia bagi penuntut ilmu.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Perilaku boros (mubazir) dalam ajaran agama sangat dilarang karena bersaudara dengan setan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Hukum bacaan nun sukun atau tanwin bertemu dengan huruf ba (ب) adalah...', 'ans' => 'Iqlab', 'opts' => ['Izhar Halqi', 'Idgham Bigunnah', 'Iqlab', 'Ikhfa Hakiki']],
                ['t' => 'sedang', 'q' => 'Suci dari hadas besar dapat dicapai dengan cara...', 'ans' => 'Mandi wajib (mandi junub)', 'opts' => ['Berwudu biasa', 'Mandi wajib (mandi junub)', 'Tayamum tanpa air', 'Mencuci tangan tiga kali']],
                ['t' => 'sedang', 'q' => 'Sujud yang dilakukan karena lupa atau ragu terhadap jumlah rakaat salat disebut sujud...', 'ans' => 'Sahwi', 'opts' => ['Tilawah', 'Syukur', 'Sahwi', 'Rukun']],
                ['t' => 'sedang', 'q' => 'Sujud yang dilakukan saat membaca atau mendengar ayat sajdah dalam Al-Qur\'an adalah sujud...', 'ans' => 'Tilawah', 'opts' => ['Sahwi', 'Syukur', 'Tilawah', 'Hajat']],
                ['t' => 'sedang', 'q' => 'Nabi dan rasul yang memiliki ketabahan luar biasa dalam menghadapi cobaan dakwah digelari rasul...', 'ans' => 'Ulul Azmi', 'opts' => ['Khulafaur Rasyidin', 'Ulul Azmi', 'Mujaddid', 'Hawariyun']],
                ['t' => 'sedang', 'q' => 'Berikut ini yang termasuk kelompok Rasul Ulul Azmi adalah...', 'ans' => 'Nuh, Ibrahim, Musa, Isa, Muhammad SAW', 'opts' => ['Adam, Idris, Nuh, Hud, Saleh', 'Nuh, Ibrahim, Musa, Isa, Muhammad SAW', 'Ibrahim, Ismail, Ishaq, Ya\'qub, Yusuf', 'Daud, Sulaiman, Yunus, Zakariya, Yahya']],
                ['t' => 'sedang', 'q' => 'Puasa sunnah yang dikerjakan pada tanggal 9 Zulhijah bagi yang tidak berhaji disebut puasa...', 'ans' => 'Arafah', 'opts' => ['Tasyrik', 'Arafah', 'Syawal', 'Asyura']],
                ['t' => 'sedang', 'q' => 'Hewan qurban pada hari raya Idul Adha disembelih pada tanggal 10 Zulhijah dan hari-hari Tasyrik.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Khulafaur Rasyidin kedua yang terkenal dengan ketegasan dan keadilannya adalah...', 'ans' => 'Umar bin Khattab', 'opts' => ['Abu Bakar Ash-Shiddiq', 'Umar bin Khattab', 'Utsman bin Affan', 'Ali bin Abi Thalib']],
                ['t' => 'sedang', 'q' => 'Sikap tawadhu bermakna rendah hati dan tidak sombong atas nikmat yang dimiliki.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Al-Qur\'an pertama kali diturunkan di Gua Hira bertepatan pada tanggal 17 Ramadan, yaitu Surah...', 'ans' => 'Al-\'Alaq ayat 1 - 5', 'opts' => ['Al-Fatihah ayat 1 - 7', 'Al-\'Alaq ayat 1 - 5', 'Al-Muddatstsir ayat 1 - 7', 'Al-Baqarah ayat 183']],
                ['t' => 'sulit', 'q' => 'Peristiwa Baiat Aqabah terjadi sebelum peristiwa hijrahnya Nabi Muhammad SAW ke Madinah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Piagam Madinah yang dirumuskan oleh Nabi Muhammad SAW menjamin kebebasan beragama dan persatuan seluruh warga Madinah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Iman kepada Qada dan Qadar mengajarkan bahwa segala ketentuan Allah SWT di alam semesta telah tertulis di Lauhul Mahfuzh.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Takdir mu\'allaq adalah ketentuan takdir yang masih dapat diubah melalui ikhtiar dan doa manusia.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Tokoh ilmuwan muslim yang dijuluki Bapak Kedokteran Modern melalui kitabnya "Al-Qanun fi at-Tibb" adalah...', 'ans' => 'Ibnu Sina (Avicenna)', 'opts' => ['Al-Khawarizmi', 'Ibnu Sina (Avicenna)', 'Al-Farabi', 'Ibnu Rusyd']],
                ['t' => 'sulit', 'q' => 'Bani Umayyah beribukota di Damaskus, sedangkan Bani Abbasiyah beribukota di Baghdad.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Masa keemasan ilmu pengetahuan Islam pada masa Dinasti Abbasiyah ditandai dengan berdirinya pusat perpustakaan dan riset...', 'ans' => 'Baitul Hikmah', 'opts' => ['Darul Arqam', 'Baitul Hikmah', 'Nizhamiyah', 'Al-Azhar']],
                ['t' => 'sulit', 'q' => 'Hukum memakan bangkai, darah yang mengalir, dan daging babi adalah haram mutlak.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Wali Songo menyebarkan agama Islam di Pulau Jawa dengan metode pendekatan kebudayaan lokal yang damai.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 8: INFORMATIKA & TIK SMP
            // -------------------------------------------------------------------------
            8 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Sistem bilangan yang hanya menggunakan angka 0 dan 1 disebut sistem...', 'ans' => 'Biner', 'opts' => ['Desimal', 'Biner', 'Oktal', 'Heksadesimal']],
                ['t' => 'mudah', 'q' => 'Perangkat keras yang bertindak sebagai jembatan jaringan nirkabel lokal adalah Access Point / Router Wi-Fi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Satu byte terdiri dari berapa bit?', 'ans' => '8 bit', 'opts' => ['2 bit', '4 bit', '8 bit', '16 bit']],
                ['t' => 'mudah', 'q' => 'Singkatan dari LAN dalam jaringan komputer adalah Local Area Network.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Ekstensi file dokumen Microsoft Word versi modern adalah...', 'ans' => '.docx', 'opts' => ['.xlsx', '.docx', '.pptx', '.pdf']],
                ['t' => 'mudah', 'q' => 'Ekstensi file spreadsheet Microsoft Excel adalah...', 'ans' => '.xlsx', 'opts' => ['.docx', '.xlsx', '.pptx', '.jpg']],
                ['t' => 'mudah', 'q' => 'Mesin pencari (search engine) paling populer di dunia saat ini adalah Google.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'RAM (Random Access Memory) bersifat volatile, artinya data di dalamnya hilang saat komputer dimatikan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Proses menghidupkan kembali komputer secara otomatis disebut restart atau reboot.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Situs media sosial digunakan untuk berinteraksi dan berbagi informasi secara daring.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Topologi jaringan di mana semua komputer terhubung ke satu titik pusat (hub/switch) disebut topologi...', 'ans' => 'Star (Bintang)', 'opts' => ['Bus', 'Ring', 'Star (Bintang)', 'Mesh']],
                ['t' => 'sedang', 'q' => 'Konversi bilangan biner 1010 ke dalam bilangan desimal bernilai...', 'ans' => '10', 'opts' => ['8', '10', '12', '14']],
                ['t' => 'sedang', 'q' => 'Protokol standar untuk mentransfer halaman web di internet adalah...', 'ans' => 'HTTP / HTTPS', 'opts' => ['FTP', 'HTTP / HTTPS', 'SMTP', 'DHCP']],
                ['t' => 'sedang', 'q' => 'Pada Microsoft Excel, rumus untuk mencari nilai rata-rata dari sekelompok sel adalah...', 'ans' => '=AVERAGE(...)', 'opts' => ['=SUM(...)', '=MEAN(...)', '=AVERAGE(...)', '=COUNT(...)']],
                ['t' => 'sedang', 'q' => 'Rumus untuk mencari nilai tertinggi dalam rentang sel di Excel adalah...', 'ans' => '=MAX(...)', 'opts' => ['=TOP(...)', '=MAX(...)', '=HIGH(...)', '=UPPER(...)']],
                ['t' => 'sedang', 'q' => 'Kejahatan penipuan digital untuk memancing korban memberikan password atau informasi rahasia disebut...', 'ans' => 'Phishing', 'opts' => ['Defacing', 'Phishing', 'DDoS', 'Spyware']],
                ['t' => 'sedang', 'q' => 'Struktur kontrol perulangan (looping) dalam algoritma pemrograman contohnya adalah perulangan FOR dan WHILE.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Alamat unik berupa angka yang mengidentifikasi setiap perangkat di jaringan internet disebut...', 'ans' => 'Alamat IP (IP Address)', 'opts' => ['MAC Address', 'Alamat IP (IP Address)', 'DNS', 'Domain']],
                ['t' => 'sedang', 'q' => 'Konektor kabel jaringan UTP yang paling umum digunakan adalah RJ-45.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Sistem operasi open-source yang logonya berbentuk penguin adalah Linux.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Struktur data LIFO (Last In First Out) di mana data terakhir masuk akan keluar pertama kali adalah...', 'ans' => 'Stack (Tumpukan)', 'opts' => ['Queue (Antrean)', 'Stack (Tumpukan)', 'Array', 'Tree']],
                ['t' => 'sulit', 'q' => 'Struktur data FIFO (First In First Out) di mana data pertama masuk akan keluar pertama kali adalah...', 'ans' => 'Queue (Antrean)', 'opts' => ['Stack', 'Queue (Antrean)', 'Graph', 'Record']],
                ['t' => 'sulit', 'q' => 'Fungsi logika di Excel yang memeriksa suatu kondisi dan mengembalikan nilai jika benar atau salah adalah...', 'ans' => '=IF(...)', 'opts' => ['=CHECK(...)', '=IF(...)', '=LOGIC(...)', '=CONDITION(...)']],
                ['t' => 'sulit', 'q' => 'DNS (Domain Name System) berfungsi untuk menerjemahkan nama domain (seperti google.com) menjadi alamat IP.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Teknologi enkripsi data pada protokol HTTPS menggunakan sertifikat SSL / TLS.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Algoritma pencarian biner (Binary Search) hanya dapat bekerja secara efektif pada data yang...', 'ans' => 'Sudah terurut (sorted)', 'opts' => ['Acak', 'Sudah terurut (sorted)', 'Hanya bilangan genap', 'Berukuran sangat kecil']],
                ['t' => 'sulit', 'q' => 'Bahasa pembuat struktur halaman web standar adalah HTML (Hypertext Markup Language).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'CSS (Cascading Style Sheets) digunakan untuk mengatur gaya visual dan tata letak halaman web.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Konsep kecerdasan buatan yang memungkinkan komputer belajar dari data tanpa diprogram secara eksplisit disebut Machine Learning.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Perangkat jaringan yang berfungsi membagi jaringan menjadi beberapa subnet dan meneruskan paket antar jaringan berbeda adalah...', 'ans' => 'Router', 'opts' => ['Hub', 'Switch unmanaged', 'Router', 'Repeater']],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 9: SENI BUDAYA SMP
            // -------------------------------------------------------------------------
            9 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Seni rupa terapan (applied art) diciptakan dengan mengutamakan fungsi pakai selain keindahan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Gambar ilustrasi berfungsi untuk memperjelas cerita atau naskah tulisan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Alat musik tiup tradisional khas suku Minangkabau yang mirip terompet adalah...', 'ans' => 'Saluang', 'opts' => ['Saluang', 'Angklung', 'Kolintang', 'Sasando']],
                ['t' => 'mudah', 'q' => 'Bernyanyi bersama dalam satu kelompok tanpa iringan instrumen musik disebut...', 'ans' => 'Akapela', 'opts' => ['Kanon', 'Akapela', 'Paduan suara orkestra', 'Solo']],
                ['t' => 'mudah', 'q' => 'Pola gambar berulang yang digunakan untuk menghias kain batik disebut ragam hias (motif).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Bahan pewarna basah yang larut dalam air untuk melukis pada kertas gambar adalah cat air.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Pementasan drama tradisional ludruk berasal dari provinsi Jawa Timur.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Alat musik gesek dalam ansambel musik barat contohnya adalah biola (violin).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Tari pendet merupakan tarian penyambutan selamat datang yang berasal dari Bali.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Suara tinggi wanita dalam paduan suara disebut sopran.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Suara rendah wanita dalam paduan suara disebut...', 'ans' => 'Alto', 'opts' => ['Sopran', 'Mezzosopran', 'Alto', 'Tenor']],
                ['t' => 'sedang', 'q' => 'Suara tinggi pria dalam klasifikasi vokal dewasa disebut...', 'ans' => 'Tenor', 'opts' => ['Bariton', 'Bass', 'Tenor', 'Kontra-tenor']],
                ['t' => 'sedang', 'q' => 'Gambar perspektif satu titik hilang digunakan untuk menggambar benda dengan kesan...', 'ans' => 'Kedalaman dan ruang tiga dimensi', 'opts' => ['Dua dimensi datar', 'Kedalaman dan ruang tiga dimensi', 'Ukuran raksasa tanpa skala', 'Warna abstrak']],
                ['t' => 'sedang', 'q' => 'Alat musik idiofon menghasilkan suara dari...', 'ans' => 'Getaran badan alat musik itu sendiri', 'opts' => ['Getaran senar/dawai', 'Getaran selaput membran', 'Getaran udara', 'Getaran badan alat musik itu sendiri']],
                ['t' => 'sedang', 'q' => 'Gendang dan bedug tergolong alat musik membranofon karena bersumber bunyi dari getaran kulit membran.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Teknik vokal yang mengatur artikulasi dan kejelasan pengucapan kata demi kata disebut...', 'ans' => 'Artikulasi', 'opts' => ['Intonasi', 'Frasering', 'Artikulasi', 'Resonansi']],
                ['t' => 'sedang', 'q' => 'Pernapasan yang paling baik digunakan untuk bernyanyi adalah pernapasan...', 'ans' => 'Diafragma', 'opts' => ['Dada', 'Perut', 'Diafragma', 'Hidung']],
                ['t' => 'sedang', 'q' => 'Tari berkelompok yang ditarikan oleh banyak penari membutuhkan keselarasan gerak yang tinggi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Pameran karya seni rupa di sekolah bertujuan untuk mengapresiasi dan mempublikasikan karya seni siswa.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Ciri khas tari Tor-Tor dari Batak Toba diiringi oleh musik gondang sembilan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Aliran seni lukis yang menggambarkan objek sesuai dengan kenyataan hidup sehari-hari tanpa dramatisasi disebut...', 'ans' => 'Realisme', 'opts' => ['Romantisme', 'Realisme', 'Kubisme', 'Surrealisme']],
                ['t' => 'sulit', 'q' => 'Aliran seni lukis yang menggambarkan alam mimpi dan alam bawah sadar di luar logika nyata adalah...', 'ans' => 'Surrealisme', 'opts' => ['Impresionisme', 'Ekspresionisme', 'Surrealisme', 'Dadaisme']],
                ['t' => 'sulit', 'q' => 'Tokoh pelukis maestro ekspresionisme legendaris asal Indonesia yang melukis dengan plototan cat adalah...', 'ans' => 'Affandi', 'opts' => ['Raden Saleh', 'Basoeki Abdullah', 'Affandi', 'S. Sudjojono']],
                ['t' => 'sulit', 'q' => 'Raden Saleh merupakan pelopor seni lukis modern Indonesia beraliran romantisme.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Seni grafis cetak tinggi (relief print) teknik cukil kayu dikenal dengan istilah...', 'ans' => 'Woodcut (Xylography)', 'opts' => ['Sablon (Silkscreen)', 'Intaglio', 'Woodcut (Xylography)', 'Litografi']],
                ['t' => 'sulit', 'q' => 'Interval nada dari nada C (do) ke nada G (sol) adalah interval...', 'ans' => 'Kuint (Fifth)', 'opts' => ['Ters (Third)', 'Kuart (Fourth)', 'Kuint (Fifth)', 'Oktaf']],
                ['t' => 'sulit', 'q' => 'Lagu kanon dinyanyikan oleh dua atau lebih kelompok penyanyi dengan melodi yang sama namun masuk secara bersusulan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Naskah tertulis yang memuat dialog, lakon, dan petunjuk teknis pementasan drama disebut...', 'ans' => 'Skenario / Naskah Drama', 'opts' => ['Sinopsis singkat', 'Skenario / Naskah Drama', 'Resensi', 'Silabus']],
                ['t' => 'sulit', 'q' => 'Unsur tata artistik panggung teater yang mengatur pencahayaan untuk menciptakan suasana adegan disebut tata lampu (lighting).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Pola lantai melengkung pada tarian tradisional memberikan kesan gerak yang lembut dan dinamis.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 10: PJOK (OLAHRAGA) SMP
            // -------------------------------------------------------------------------
            10 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Panjang ukuran lapangan sepak bola standar internasional adalah...', 'ans' => '100 - 110 meter', 'opts' => ['80 - 90 meter', '100 - 110 meter', '120 - 130 meter', '140 - 150 meter']],
                ['t' => 'mudah', 'q' => 'Durasi pertandingan sepak bola normal adalah 2 x 45 menit.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Pukulan sajian pertama untuk memulai permainan dalam bola voli atau bulu tangkis disebut...', 'ans' => 'Servis', 'opts' => ['Smash', 'Passing', 'Servis', 'Block']],
                ['t' => 'mudah', 'q' => 'Jumlah pemain dalam satu regu bola basket adalah 5 orang.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Pencak silat merupakan seni bela diri tradisional asli dari kepulauan Nusantara.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Teknik mendarat yang benar pada lompat jauh dilakukan dengan kedua kaki secara bersamaan dan lutut mengeper.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Lari estafet menggunakan tongkat yang dipindahkan secara bergantian antar pelari.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Gaya dada dalam renang sering juga disebut gaya katak.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Olahraga teratur dapat memperkuat sistem imun tubuh dan menjaga kebugaran jasmani.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Wasit memimpin pertandingan sepak bola dibantu oleh dua orang hakim garis.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Posisi pemain sepak bola yang bertugas mencegah serangan lawan dan melindungi gawang adalah...', 'ans' => 'Bek (Defender)', 'opts' => ['Penyerang (Striker)', 'Gelandang (Midfielder)', 'Bek (Defender)', 'Sayap (Winger)']],
                ['t' => 'sedang', 'q' => 'Offside dalam sepak bola terjadi jika seorang pemain berada lebih dekat ke garis gawang lawan daripada bola dan pemain bertahan lawan saat bola dioper.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Sistem perolehan angka dalam permainan bulu tangkis menggunakan sistem rally point 21 angka.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Kuda-kuda dalam pencak silat berfungsi sebagai dasar tumpuan untuk menyerang maupun bertahan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Ukuran lapangan bola basket standar FIBA adalah...', 'ans' => '28 m x 15 m', 'opts' => ['24 m x 12 m', '28 m x 15 m', '30 m x 18 m', '32 m x 16 m']],
                ['t' => 'sedang', 'q' => 'Tes kebugaran jasmani lari 12 menit atau tes lari 2,4 km digunakan untuk mengukur...', 'ans' => 'Daya tahan jantung dan paru-paru (VO2 max)', 'opts' => ['Kelenturan tubuh', 'Daya tahan jantung dan paru-paru (VO2 max)', 'Kecepatan reaksi', 'Kekuatan otot bahu saja']],
                ['t' => 'sedang', 'q' => 'Teknik operan memantulkan bola ke lantai dalam bola basket disebut...', 'ans' => 'Bounce pass', 'opts' => ['Chest pass', 'Bounce pass', 'Overhead pass', 'Baseball pass']],
                ['t' => 'sedang', 'q' => 'Gerakan senam lantai roll depan dilakukan dengan bertumpu pada tengkuk, bukan pada dahi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Penyakit menular yang dapat dicegah dengan pola hidup sehat dan sanitasi air bersih contohnya adalah kolera dan disentri.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Zat gizi yang berfungsi sebagai sumber energi utama bagi tubuh adalah karbohidrat.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Gaya lompat tinggi di mana posisi tubuh telentang melewati mistar dengan punggung menghadap mistar disebut gaya...', 'ans' => 'Fosbury Flop', 'opts' => ['Straddle (Gunting)', 'Fosbury Flop', 'Western Roll', 'Eastern Cut-off']],
                ['t' => 'sulit', 'q' => 'Zona pergantian tongkat (wisselzone) pada lari estafet memiliki panjang lintasan...', 'ans' => '20 meter', 'opts' => ['10 meter', '15 meter', '20 meter', '25 meter']],
                ['t' => 'sulit', 'q' => 'Teknik servis bola voli yang dilakukan dengan melompat tinggi memukul bola di udara disebut...', 'ans' => 'Jump serve', 'opts' => ['Underhand serve', 'Float serve', 'Jump serve', 'Side serve']],
                ['t' => 'sulit', 'q' => 'Prinsip RICE untuk menangani cedera terkilir (sprain) adalah Rest, Ice, Compression, dan...', 'ans' => 'Elevation', 'opts' => ['Exercise', 'Elevation', 'Extension', 'Elongation']],
                ['t' => 'sulit', 'q' => 'Pola penyerangan cepat dalam bola basket saat lawan belum sempat membangun pertahanan disebut...', 'ans' => 'Fast break', 'opts' => ['Zone defense', 'Man-to-man defense', 'Fast break', 'Set offense']],
                ['t' => 'sulit', 'q' => 'Nomor lari jarak menengah dalam atletik meliputi jarak...', 'ans' => '800 meter dan 1.500 meter', 'opts' => ['100 m dan 200 m', '400 m dan 800 m', '800 meter dan 1.500 meter', '5.000 m dan 10.000 m']],
                ['t' => 'sulit', 'q' => 'Gaya renang tercepat dari seluruh empat nomor gaya renang adalah gaya bebas (crawl).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Dalam pencak silat, sasaran sah yang menghasilkan nilai pada badan lawan adalah dada, perut, dan punggung.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Indeks Massa Tubuh (IMT / BMI) dihitung dengan membagi berat badan (kg) dengan...', 'ans' => 'Tinggi badan kuadrat (m²)', 'opts' => ['Tinggi badan (m)', 'Tinggi badan kuadrat (m²)', 'Lingkar pinggang (cm)', 'Usia (tahun)']],
                ['t' => 'sulit', 'q' => 'Narkotika Golongan I dilarang keras digunakan untuk terapi medis karena memiliki potensi ketergantungan sangat tinggi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 17: SEJARAH INDONESIA SMP
            // -------------------------------------------------------------------------
            17 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Organisasi Budi Utomo didirikan pada tanggal 20 Mei 1908 di gedung STOVIA Jakarta.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Kongres Pemuda II yang menghasilkan ikrar Sumpah Pemuda diadakan pada tahun...', 'ans' => '1928', 'opts' => ['1908', '1926', '1928', '1945']],
                ['t' => 'mudah', 'q' => 'Lagu Indonesia Raya pertama kali diperdengarkan secara instrumental biola pada Kongres Pemuda II oleh...', 'ans' => 'W.R. Soepratman', 'opts' => ['Ismail Marzuki', 'W.R. Soepratman', 'Kusbini', 'Amir Pasaribu']],
                ['t' => 'mudah', 'q' => 'Penjajahan Jepang di Indonesia berlangsung dari tahun 1942 hingga 1945.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'BPUPKI dibentuk oleh Jepang dengan nama Jepang Dokuritsu Junbi Cosakai.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Ketua BPUPKI adalah dr. K.R.T. Radjiman Wedyodiningrat.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Kota Hiroshima dan Nagasaki di Jepang dijatuhi bom atom oleh Sekutu pada bulan Agustus 1945.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Proklamasi Kemerdekaan Indonesia dibacakan pada hari Jumat, 17 Agustus 1945 pukul 10.00 WIB.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Tiga tokoh yang menandatangani naskah proklamasi atas nama bangsa Indonesia adalah Soekarno dan Hatta.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Perang Puputan di Bali dipimpin oleh I Gusti Ngurah Rai melawan pasukan Belanda.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Tiga Serangkai pendiri partai politik pertama di Hindia Belanda (Indische Partij) adalah...', 'ans' => 'Douwes Dekker, Tjipto Mangoenkoesoemo, Ki Hajar Dewantara', 'opts' => ['Soekarno, Hatta, Sjahrir', 'Douwes Dekker, Tjipto Mangoenkoesoemo, Ki Hajar Dewantara', 'Wahidin, Soetomo, H.O.S. Tjokroaminoto', 'Agus Salim, Semaun, Darsono']],
                ['t' => 'sedang', 'q' => 'Organisasi Islam yang didirikan oleh K.H. Ahmad Dahlan pada tahun 1912 di Yogyakarta adalah...', 'ans' => 'Muhammadiyah', 'opts' => ['Nahdlatul Ulama', 'Muhammadiyah', 'Sarekat Islam', 'Persis']],
                ['t' => 'sedang', 'q' => 'Organisasi Nahdlatul Ulama (NU) didirikan pada tahun 1926 di Surabaya oleh para ulama yang dipimpin oleh...', 'ans' => 'K.H. Hasyim Asy\'ari', 'opts' => ['K.H. Ahmad Dahlan', 'K.H. Hasyim Asy\'ari', 'H.O.S. Tjokroaminoto', 'K.H. Agus Salim']],
                ['t' => 'sedang', 'q' => 'Peristiwa penculikan Soekarno dan Hatta ke Rengasdengklok diprakarsai oleh golongan muda seperti...', 'ans' => 'Sukarni, Chaerul Saleh, dan Wikana', 'opts' => ['Sayuti Melik dan Radjiman', 'Sukarni, Chaerul Saleh, dan Wikana', 'Achmad Soebardjo dan Latief', 'Amir Sjarifuddin dan Tan Malaka']],
                ['t' => 'sedang', 'q' => 'Tokoh golongan tua yang menjamin kemerdekaan akan diproklamasikan esok hari sehingga Soekarno-Hatta dilepaskan adalah...', 'ans' => 'Mr. Achmad Soebardjo', 'opts' => ['Mr. Kasman Singodimedjo', 'Mr. Achmad Soebardjo', 'Mr. Mohammad Roem', 'Mr. Sartono']],
                ['t' => 'sedang', 'q' => 'Sidang pertama PPKI tanggal 18 Agustus 1945 mengesahkan UUD 1945 serta memilih Presiden dan Wakil Presiden pertama RI.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Peristiwa tewasnya Jenderal AWS Mallaby memicu meletusnya pertempuran dahsyat di kota...', 'ans' => 'Surabaya', 'opts' => ['Semarang', 'Surabaya', 'Bandung', 'Medan']],
                ['t' => 'sedang', 'q' => 'Agresi Militer Belanda I terjadi pada tanggal 21 Juli 1947.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Pemerintah Darurat Republik Indonesia (PDRI) dibentuk di Bukittinggi Sumatra Barat dipimpin oleh...', 'ans' => 'Sjafruddin Prawiranegara', 'opts' => ['Sutan Sjahrir', 'Sjafruddin Prawiranegara', 'Mr. Assaat', 'Amir Sjarifuddin']],
                ['t' => 'sedang', 'q' => 'Komisi Tiga Negara (KTN) yang menengahi konflik Indonesia dan Belanda terdiri dari Australia, Belgia, dan...', 'ans' => 'Amerika Serikat', 'opts' => ['Inggris', 'Amerika Serikat', 'Prancis', 'Uni Soviet']],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Perjanjian Roem-Royen pada Mei 1949 menyepakati penghentian permusuhan dan kembalinya pemerintah RI ke Yogyakarta.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Bentuk negara Indonesia sempat berubah menjadi Republik Indonesia Serikat (RIS) sebagai hasil dari...', 'ans' => 'Konferensi Meja Bundar (KMB) 1949', 'opts' => ['Perjanjian Linggarjati', 'Perjanjian Renville', 'Konferensi Meja Bundar (KMB) 1949', 'Dekrit Presiden 1959']],
                ['t' => 'sulit', 'q' => 'Negara Kesatuan Republik Indonesia kembali ditegakkan membubarkan RIS pada tanggal...', 'ans' => '17 Agustus 1950', 'opts' => ['27 Desember 1949', '17 Agustus 1950', '5 Juli 1959', '11 Maret 1966']],
                ['t' => 'sulit', 'q' => 'Pemilihan Umum pertama di Indonesia yang demokratis diselenggarakan pada tahun 1955 untuk memilih anggota...', 'ans' => 'DPR dan Konstituante', 'opts' => ['Presiden langsung', 'DPR dan Konstituante', 'MPR dan DPD', 'Kepala Daerah']],
                ['t' => 'sulit', 'q' => 'Dekrit Presiden 5 Juli 1959 dikeluarkan oleh Presiden Soekarno untuk menetapkan...', 'ans' => 'Berlakunya kembali UUD 1945 dan membubarkan Konstituante', 'opts' => ['Pembentukan kabinet baru', 'Berlakunya kembali UUD 1945 dan membubarkan Konstituante', 'Pembubaran partai politik', 'Negara darurat militer selamanya']],
                ['t' => 'sulit', 'q' => 'Operasi Trikora (Tri Komando Rakyat) dikumandangkan di Yogyakarta untuk membebaskan wilayah...', 'ans' => 'Irian Barat', 'opts' => ['Timor Timur', 'Irian Barat', 'Kalimantan Utara', 'Kepulauan Riau']],
                ['t' => 'sulit', 'q' => 'Surat Perintah Sebelas Maret (Supersemar) 1966 menandai peralihan kekuasaan dari Orde Lama ke Orde Baru.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Gerakan Non-Blok (GNB) didirikan pada Konferensi Beograd 1961 yang diprakarsai oleh Indonesia, Yugoslavia, Mesir, India, dan Ghana.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Era Reformasi di Indonesia dimulai sejak pengunduran diri Presiden Soeharto pada tanggal...', 'ans' => '21 Mei 1998', 'opts' => ['11 Maret 1998', '21 Mei 1998', '17 Agustus 1998', '10 November 1998']],
                ['t' => 'sulit', 'q' => 'Tokoh yang menjabat sebagai Presiden Republik Indonesia ketiga menggantikan Soeharto adalah B.J. Habibie.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],
        ];
    }
}

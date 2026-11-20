<?php

namespace Database\Seeders\Dungeon;

class DungeonQuestionDatasetSmaUmum
{
    /**
     * Mengambil daftar soal dungeon SMA Umum (11 mapel).
     * Masing-masing mapel memiliki minimal 30 soal (10 Mudah, 10 Sedang, 10 Sulit).
     */
    public static function getQuestionsByMapel(): array
    {
        return [
            // -------------------------------------------------------------------------
            // MAPEL 1: MATEMATIKA SMA
            // -------------------------------------------------------------------------
            1 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Bentuk sederhana dari 2⁵ x 2³ adalah...', 'ans' => '2⁸', 'opts' => ['2¹⁵', '2⁸', '4⁸', '4¹⁵']],
                ['t' => 'mudah', 'q' => 'Nilai dari logaritma ²log 16 adalah...', 'ans' => '4', 'opts' => ['2', '3', '4', '8']],
                ['t' => 'mudah', 'q' => 'Nilai sin 30° pada trigonometri sudut istimewa adalah...', 'ans' => '1/2', 'opts' => ['0', '1/2', '1/2√2', '1/2√3']],
                ['t' => 'mudah', 'q' => 'Nilai cos 60° adalah 1/2.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Nilai tan 45° adalah tepat 1.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Identitas trigonometri dasar menyatakan bahwa sin²x + cos²x selalu bernilai...', 'ans' => '1', 'opts' => ['0', '1', '2', '-1']],
                ['t' => 'mudah', 'q' => 'Akar kuadrat dari 196 adalah...', 'ans' => '14', 'opts' => ['12', '13', '14', '16']],
                ['t' => 'mudah', 'q' => 'Suku pertama barisan aritmatika adalah 5 dan bedanya 3. Suku ke-4 adalah...', 'ans' => '14', 'opts' => ['11', '14', '17', '20']],
                ['t' => 'mudah', 'q' => 'Matriks identitas perkalian ordo 2x2 adalah [[1, 0], [0, 1]].', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Turunan pertama dari f(x) = x³ adalah f\'(x) = 3x².', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Determinan dari matriks A = [[3, 2], [1, 4]] adalah...', 'ans' => '10', 'opts' => ['8', '10', '12', '14']],
                ['t' => 'sedang', 'q' => 'Suku ke-10 dari barisan geometri 2, 4, 8, 16, ... adalah...', 'ans' => '1.024', 'opts' => ['512', '1.024', '2.048', '4.096']],
                ['t' => 'sedang', 'q' => 'Turunan pertama dari f(x) = 4x³ - 5x² + 7x - 2 adalah...', 'ans' => '12x² - 10x + 7', 'opts' => ['12x² - 10x + 7', '12x² - 5x + 7', '4x² - 10x + 7', '12x³ - 10x² + 7']],
                ['t' => 'sedang', 'q' => 'Nilai integral tak tentu ∫(6x² + 4x - 1) dx adalah...', 'ans' => '2x³ + 2x² - x + C', 'opts' => ['2x³ + 2x² - x + C', '3x³ + 2x² - x + C', '6x³ + 4x² - x + C', '2x³ + 4x² - x + C']],
                ['t' => 'sedang', 'q' => 'Persamaan lingkaran yang berpusat di titik (0, 0) dengan jari-jari r adalah x² + y² = r².', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Banyaknya cara menyusun 3 huruf berbeda dari kata "PINTAR" (Permutasi 6P3) adalah...', 'ans' => '120 cara', 'opts' => ['20 cara', '60 cara', '120 cara', '720 cara']],
                ['t' => 'sedang', 'q' => 'Banyaknya jabat tangan yang terjadi jika ada 10 orang saling bersalaman (Kombinasi 10C2) adalah...', 'ans' => '45 kali', 'opts' => ['20 kali', '45 kali', '90 kali', '100 kali']],
                ['t' => 'sedang', 'q' => 'Nilai limit fungsi lim (x->3) (x² - 9) / (x - 3) adalah...', 'ans' => '6', 'opts' => ['0', '3', '6', '9']],
                ['t' => 'sedang', 'q' => 'Vektor a = (2, 3) dan vektor b = (4, -1). Hasil perkalian titik (dot product) a . b adalah...', 'ans' => '5', 'opts' => ['5', '7', '8', '11']],
                ['t' => 'sedang', 'q' => 'Jumlah tak hingga deret geometri 16 + 8 + 4 + 2 + ... adalah...', 'ans' => '32', 'opts' => ['24', '30', '32', '64']],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Himpunan penyelesaian pertidaksamaan nilai mutlak |2x - 3| < 7 adalah...', 'ans' => '-2 < x < 5', 'opts' => ['-2 < x < 5', '-5 < x < 2', 'x < -2 atau x > 5', '-4 < x < 5']],
                ['t' => 'sulit', 'q' => 'Persamaan garis singgung lingkaran x² + y² = 25 di titik (3, 4) adalah...', 'ans' => '3x + 4y = 25', 'opts' => ['3x + 4y = 25', '4x + 3y = 25', '3x - 4y = 25', '4x - 3y = 25']],
                ['t' => 'sulit', 'q' => 'Jika f(x) = 2x + 1 dan g(x) = x² - 3, maka nilai komposisi fungsi (g o f)(2) adalah...', 'ans' => '22', 'opts' => ['17', '22', '25', '27']],
                ['t' => 'sulit', 'q' => 'Invers dari fungsi f(x) = (2x + 3) / (x - 1) untuk x ≠ 1 adalah...', 'ans' => 'f⁻¹(x) = (x + 3) / (x - 2)', 'opts' => ['f⁻¹(x) = (x + 3) / (x - 2)', 'f⁻¹(x) = (2x - 3) / (x + 1)', 'f⁻¹(x) = (x - 1) / (2x + 3)', 'f⁻¹(x) = (3x + 1) / (x - 2)']],
                ['t' => 'sulit', 'q' => 'Nilai maksimum fungsi objektif z = 3x + 4y pada daerah penyelesaian x + y ≤ 10, x ≥ 0, y ≥ 0 adalah...', 'ans' => '40', 'opts' => ['30', '35', '40', '50']],
                ['t' => 'sulit', 'q' => 'Nilai integral tentu ∫ (dari 0 ke 2) (3x² + 2x) dx adalah...', 'ans' => '12', 'opts' => ['8', '10', '12', '16']],
                ['t' => 'sulit', 'q' => 'Luas daerah yang dibatasi oleh kurva y = x² dan garis y = 4 adalah...', 'ans' => '32/3 satuan luas', 'opts' => ['16/3 satuan luas', '32/3 satuan luas', '16 satuan luas', '24 satuan luas']],
                ['t' => 'sulit', 'q' => 'Jarak titik ke bidang pada kubus ABCD.EFGH dengan rusuk 6 cm, jarak titik E ke bidang BDHF adalah...', 'ans' => '3√2 cm', 'opts' => ['3 cm', '3√2 cm', '3√3 cm', '6 cm']],
                ['t' => 'sulit', 'q' => 'Simpangan baku (standar deviasi) adalah akar kuadrat dari varians (ragam) data.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Dua vektor saling tegak lurus (ortogonal) jika dan hanya jika hasil perkalian titiknya sama dengan nol.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 2: BAHASA INDONESIA SMA
            // -------------------------------------------------------------------------
            2 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Teks yang berisi pengajuan lamaran pekerjaan kepada suatu instansi disebut...', 'ans' => 'Surat lamaran pekerjaan', 'opts' => ['Surat dinas', 'Surat lamaran pekerjaan', 'Curriculum vitae', 'Surat keputusan']],
                ['t' => 'mudah', 'q' => 'Teks laporan hasil observasi harus disajikan secara objektif berdasarkan fakta.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Bagian surat lamaran yang berisi identitas pelamar disebut...', 'ans' => 'Kualifikasi / Biodata diri', 'opts' => ['Salam penutup', 'Kualifikasi / Biodata diri', 'Kop surat', 'Nomor surat']],
                ['t' => 'mudah', 'q' => 'Teks editorial (tajuk rencana) ditulis oleh redaksi surat kabar untuk merespons isu aktual yang sedang hangat.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Karya sastra berupa cerita rekaan yang panjang dengan jalinan cerita kompleks disebut...', 'ans' => 'Novel', 'opts' => ['Cerpen', 'Novel', 'Anekdot', 'Monolog']],
                ['t' => 'mudah', 'q' => 'Kata serapan dari bahasa asing harus disesuaikan dengan pedoman ejaan bahasa Indonesia.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Teks negosiasi bertujuan untuk mencapai kesepakatan bersama yang saling menguntungkan (win-win solution).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Riwayat hidup seseorang yang ditulis oleh orang lain disebut biografi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Riwayat hidup yang ditulis sendiri oleh tokoh yang bersangkutan disebut autobiografi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Teks anekdot adalah cerita singkat dan lucu yang mengandung kritik sosial.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Struktur teks negosiasi umumnya terdiri dari...', 'ans' => 'Orientasi, pengajuan, penawaran, persetujuan, penutup', 'opts' => ['Tesis, argumentasi, rekomendasi', 'Orientasi, pengajuan, penawaran, persetujuan, penutup', 'Abstraksi, orientasi, krisis, reaksi', 'Pernyataan umum, deretan penjelas, penutup']],
                ['t' => 'sedang', 'q' => 'Kalimat yang mengandung opini (pendapat) dalam teks editorial adalah...', 'ans' => 'Pemerintah sebaiknya segera mengevaluasi kebijakan impor beras', 'opts' => ['Badan Pusat Statistik merilis data inflasi bulan ini 0,2%', 'Pemerintah sebaiknya segera mengevaluasi kebijakan impor beras', 'Presiden melantik menteri baru di Istana Negara', 'Gempa bumi bermagnitudo 6,2 mengguncang wilayah Maluku']],
                ['t' => 'sedang', 'q' => 'Struktur artikel ilmiah populer terdiri dari...', 'ans' => 'Judul, pendahuluan, isi/pembahasan, penutup/kesimpulan', 'opts' => ['Abstraksi, koda, orientasi', 'Judul, pendahuluan, isi/pembahasan, penutup/kesimpulan', 'Tesis, sanggahan, koda', 'Orientasi, komplikasi, evaluasi']],
                ['t' => 'sedang', 'q' => 'Kritik sastra harus didasarkan pada analisis objektif dengan argumen logis terhadap karya sastra.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Esai lebih menonjolkan sudut pandang pribadi penulis secara lugas dan mendalam.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Unsur ekstrinsik karya sastra berkaitan dengan latar belakang sosial budaya, biografi pengarang, dan nilai moral.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Perbedaan majas litotes dan hiperbola adalah litotes merendahkan diri sedangkan hiperbola melebih-lebihkan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Dalam karya ilmiah, bagian metodologi penelitian menjelaskan pendekatan dan instrumen yang digunakan untuk mengumpulkan data.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Kata serapan yang tepat untuk istilah "effective" dan "activity" adalah efektif dan aktivitas.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Makna konotatif adalah makna kiasan atau makna tambahan yang dipengaruhi oleh nilai rasa.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Struktur proposal penelitian formal secara umum mencakup...', 'ans' => 'Latar belakang, rumusan masalah, tujuan, manfaat, landasan teori, metodologi', 'opts' => ['Judul dan anggaran biaya saja', 'Latar belakang, rumusan masalah, tujuan, manfaat, landasan teori, metodologi', 'Sinopsis, daftar pustaka, lampiran', 'Abstrak, kesimpulan, biodata peneliti']],
                ['t' => 'sulit', 'q' => 'Kalimat efektif harus memenuhi kaidah keparalelan bentuk kata dalam rincian kalimat.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Pernyataan berikut yang menggunakan kalimat tidak efektif karena pemborosan kata adalah...', 'ans' => 'Para hadirin sekalian dipersilakan untuk dapat berdiri', 'opts' => ['Hadirin dipersilakan berdiri', 'Para hadirin sekalian dipersilakan untuk dapat berdiri', 'Peserta seminar mendengarkan paparan narasumber', 'Siswa mengumpulkan tugas tepat waktu']],
                ['t' => 'sulit', 'q' => 'Novel "Laskar Pelangi" karya Andrea Hirata sarat dengan nilai edukasi dan perjuangan anak-anak Belitong.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Novel "Bumi Manusia" merupakan karya mahakarya sastra Indonesia yang ditulis oleh...', 'ans' => 'Pramoedya Ananta Toer', 'opts' => ['Chairil Anwar', 'Pramoedya Ananta Toer', 'Mochtar Lubis', 'Sutan Takdir Alisjahbana']],
                ['t' => 'sulit', 'q' => 'Pelopor Angkatan \'45 dalam kesusastraan Indonesia yang terkenal dengan puisi "Aku" adalah...', 'ans' => 'Chairil Anwar', 'opts' => ['Amir Hamzah', 'Chairil Anwar', 'Marah Rusli', 'Sapardi Djoko Damono']],
                ['t' => 'sulit', 'q' => 'Format penulisan kutipan langsung yang lebih dari empat baris diketik dengan spasi tunggal dan menjorok ke dalam.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Majas paradoks mengemukakan hal yang seolah-olah bertentangan padahal kenyataannya mengandung kebenaran.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Drama satu babak adalah pementasan drama yang hanya terdiri dari satu kesatuan adegan tanpa pergantian babak.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Fungsi utama abstrak dalam laporan karya ilmiah adalah menyajikan ringkasan padat mengenai latar, metode, dan temuan penelitian.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 3: BAHASA INGGRIS SMA
            // -------------------------------------------------------------------------
            3 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'What is the synonym of "essential"?', 'ans' => 'Crucial / Important', 'opts' => ['Trivial', 'Crucial / Important', 'Minor', 'Optional']],
                ['t' => 'mudah', 'q' => 'Which modal expresses a strong obligation or regulation?', 'ans' => 'Must', 'opts' => ['May', 'Must', 'Could', 'Might']],
                ['t' => 'mudah', 'q' => 'The passive voice of "They build a bridge" is "A bridge is built by them".', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'A text that aims to argue a viewpoint and influence readers is an analytical exposition.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'What tense is used in "She has already finished her assignment"?', 'ans' => 'Present Perfect Tense', 'opts' => ['Simple Past Tense', 'Present Continuous Tense', 'Present Perfect Tense', 'Past Perfect Tense']],
                ['t' => 'mudah', 'q' => 'The opposite of "transparent" is "opaque".', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Which conjunction indicates cause and effect?', 'ans' => 'Consequently', 'opts' => ['However', 'Consequently', 'Although', 'Despite']],
                ['t' => 'mudah', 'q' => 'A formal curriculum vitae (CV) lists educational background, work experience, and skills.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'What is the noun form of the verb "decide"?', 'ans' => 'Decision', 'opts' => ['Decided', 'Deciding', 'Decision', 'Decisive']],
                ['t' => 'mudah', 'q' => 'The idiom "Break a leg" means "Good luck" in performing arts.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Identify the Conditional Sentence Type 3:', 'ans' => 'If you had studied harder, you would have passed the exam', 'opts' => ['If you study harder, you will pass', 'If you studied harder, you would pass', 'If you had studied harder, you would have passed the exam', 'If you had studied, you pass']],
                ['t' => 'sedang', 'q' => 'The generic structure of an Hortatory Exposition text is...', 'ans' => 'Thesis, Arguments, Recommendation', 'opts' => ['Thesis, Arguments, Reiteration', 'Thesis, Arguments, Recommendation', 'Orientation, Crisis, Reaction', 'Goal, Materials, Steps']],
                ['t' => 'sedang', 'q' => 'The difference between Analytical Exposition and Hortatory Exposition lies in the concluding paragraph: Reiteration vs Recommendation.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Identify the reduced relative clause in: "The boy injured in the accident was taken to hospital."', 'ans' => 'who was injured', 'opts' => ['who was injured', 'who is injured', 'whom injured', 'whose injury']],
                ['t' => 'sedang', 'q' => 'Complete the sentence: "Despite ... hard, he failed the driving test."', 'ans' => 'practicing', 'opts' => ['practiced', 'practicing', 'practice', 'to practice']],
                ['t' => 'sedang', 'q' => 'A News Item text gives factual information about newsworthy events of the day.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Choose the correct subjunctive: "I wish I ... more time to finish the thesis."', 'ans' => 'had', 'opts' => ['have', 'had', 'would have', 'will have']],
                ['t' => 'sedang', 'q' => 'What is the antonym of "scarce"?', 'ans' => 'Abundant', 'opts' => ['Rare', 'Abundant', 'Limited', 'Narrow']],
                ['t' => 'sedang', 'q' => '"Hardly had the meeting started when the earthquake occurred." is an inverted sentence.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Reported Speech: "I can speak German," he said. becomes "He said that he could speak German."', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Complete the sentence: "Had they known the weather forecast, they ... cancelled the flight."', 'ans' => 'would have', 'opts' => ['will have', 'would have', 'had', 'should']],
                ['t' => 'sulit', 'q' => 'Which sentence contains a cleft sentence emphasizing the subject?', 'ans' => 'It was Sarah who discovered the security vulnerability', 'opts' => ['Sarah discovered the vulnerability', 'The vulnerability was discovered by Sarah', 'It was Sarah who discovered the security vulnerability', 'Because of Sarah, it was discovered']],
                ['t' => 'sulit', 'q' => 'In academic English writing, passive voice is frequently used to maintain objective tone and focus on the result.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'The idiom "Bite the bullet" means...', 'ans' => 'To face a painful situation with courage', 'opts' => ['To shoot an enemy', 'To face a painful situation with courage', 'To eat something tough', 'To give up completely']],
                ['t' => 'sulit', 'q' => 'Identify the correct participle clause: "... by the sudden explosion, everyone ran out of the building."', 'ans' => 'Alarmed', 'opts' => ['Alarming', 'Alarmed', 'To alarm', 'Having alarming']],
                ['t' => 'sulit', 'q' => 'Identify the meaning of the prefix "omni-" in "omnipotent":', 'ans' => 'All / Everywhere', 'opts' => ['Self', 'Against', 'All / Everywhere', 'Half']],
                ['t' => 'sulit', 'q' => 'The word "ubiquitous" means...', 'ans' => 'Present everywhere simultaneously', 'opts' => ['Very strange', 'Present everywhere simultaneously', 'Outdated', 'Extremely expensive']],
                ['t' => 'sulit', 'q' => 'Choose the correct prepositional phrase: "The research was conducted ... cooperation with Oxford University."', 'ans' => 'in', 'opts' => ['at', 'with', 'in', 'by']],
                ['t' => 'sulit', 'q' => '"Not only did he win the championship, but he also broke the world record." demonstrates parallel correlative conjunction.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'A Discussion Text presents information and opinions about more than one side of an issue (pros and cons).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 4: IPA / SAINS LINTAS SMA
            // -------------------------------------------------------------------------
            4 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Energi terbarukan adalah sumber energi yang dapat diperbarui secara alami, contohnya sinar matahari dan angin.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Pemanasan global disebabkan oleh meningkatnya konsentrasi gas rumah kaca seperti karbon dioksida di atmosfer.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Lapisan ozon di stratosfer berfungsi menyerap radiasi sinar ultraviolet berbahaya dari matahari.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Zat radioaktif memancarkan sinar alfa, beta, dan gama saat meluruh.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Panel surya fotovoltaik mengubah energi cahaya matahari langsung menjadi energi listrik.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Bioteknologi modern memanfaatkan teknologi DNA rekombinan dan kultur jaringan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Bahan bakar fosil meliputi minyak bumi, gas alam, dan batu bara.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Hujan asam terjadi akibat tingginya emisi gas belerang dioksida (SO₂) dan nitrogen oksida (NOx).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Nanoteknologi bekerja pada skala material berukuran 1 hingga 100 nanometer.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Reaktor fusi nuklir meniru reaksi pembentukan energi yang terjadi di inti matahari.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Protokol Kyoto dan Perjanjian Paris adalah kesepakatan internasional untuk membatasi emisi gas rumah kaca.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Dampak pencairan es kutub akibat pemanasan global adalah kenaikan permukaan air laut global.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Bahan bakar hidrogen menghasilkan produk sampingan pembakaran yang sangat bersih yaitu...', 'ans' => 'Uap air (H₂O)', 'opts' => ['Karbon monoksida', 'Uap air (H₂O)', 'Gas metana', 'Belerang padat']],
                ['t' => 'sedang', 'q' => 'Eutrofikasi di perairan terjadi akibat penumpukan limbah fosfat dan nitrat yang memicu ledakan populasi alga.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Bioetanol sebagai bahan bakar nabati dihasilkan dari fermentasi tanaman berpati atau berkadar gula tinggi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Polimer plastik biodegradable lebih mudah diuraikan oleh mikroorganisme tanah dibandingkan plastik konvensional.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Prinsip kimia hijau (Green Chemistry) bertujuan merancang proses kimia yang meminimalkan timbulan limbah berbahaya.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'CFC (Klorofluorokarbon) yang digunakan pada pendingin lama dilarang karena merusak lapisan ozon.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Sel bahan bakar (fuel cell) mengubah energi kimia dari bahan bakar langsung menjadi listrik secara elektrokimia.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Kloning genetik pada hewan pertama kali berhasil dibuktikan pada domba Dolly.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Mekanisme penangkapan dan penyimpanan karbon (Carbon Capture and Storage / CCS) menyuntikkan CO₂ ke dalam formasi geologi bawah tanah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Teknologi penyuntingan gen CRISPR-Cas9 menggunakan enzim Cas9 sebagai gunting molekuler RNA terarah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Superkonduktor adalah material yang memiliki hambatan listrik tepat nol pada suhu sangat rendah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Efek albedo bumi mengukur fraksi radiasi matahari yang dipantulkan kembali ke angkasa oleh permukaan bumi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Asidifikasi air laut (penurunan pH laut) terjadi karena penyerapan kelebihan gas CO₂ atmosfer oleh air laut.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Transmutasi inti buatan dalam akselerator partikel dapat mengubah unsur stabil menjadi radioisotop medis.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Teknologi kuantum komputasi memanfaatkan prinsip superposisi dan keterikatan kuantum (entanglement) dari Qubit.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Bioremediasi adalah pemanfaatan mikroorganisme hidup untuk mendegradasi polutan berbahaya di tanah dan air.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Grafena adalah lembaran karbon satu atom berbentuk kisi sarang lebah dengan konduktivitas listrik luar biasa.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Siklus biogeokimia mencakup perputaran unsur karbon, nitrogen, fosfor, dan air antara komponen biotik dan abiotik bumi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 5: IPS / SOSIAL LINTAS SMA
            // -------------------------------------------------------------------------
            5 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Globalisasi adalah proses integrasi internasional yang terjadi karena pertukaran pandangan dunia, produk, dan pemikiran.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Tujuan Pembangunan Berkelanjutan (Sustainable Development Goals / SDGs) dicanangkan oleh PBB dengan 17 tujuan utama.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Masyarakat ekonomi digital memanfaatkan platform internet untuk transaksi perdagangan daring (e-commerce).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Konsumerisme adalah paham atau gaya hidup yang menganggap barang mewah sebagai ukuran kebahagiaan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Revolusi Industri 4.0 dicirikan oleh integrasi teknologi siber, kecerdasan buatan, dan internet of things (IoT).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Masyarakat multikultural hidup berdampingan secara damai dengan menghargai keberagaman budaya.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Kearifan lokal (local wisdom) adalah nilai-nilai luhur yang berlaku dalam tata kehidupan masyarakat setempat.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Transmigrasi adalah perpindahan penduduk dari daerah padat ke daerah yang masih jarang penduduknya di dalam negeri.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Emigrasi adalah tindakan keluar dari negara asal untuk menetap di negara lain.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'PBB (Perserikatan Bangsa-Bangsa) didirikan pada tahun 1945 untuk memelihara perdamaian dan keamanan dunia.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Kesenjangan sosial ekonomi dapat diatasi melalui pemerataan akses pendidikan berkualitas dan jaminan kesehatan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Cultural lag (ketertinggalan budaya) menurut William F. Ogburn terjadi ketika perkembangan teknologi material lebih cepat daripada kesiapan norma mental masyarakat.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Komunitas ASEAN (ASEAN Community) berdiri di atas tiga pilar: Politik-Keamanan, Ekonomi, dan Sosial-Budaya.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Masyarakat Ekonomi ASEAN (MEA) membuka arus bebas barang, jasa, investasi, dan tenaga kerja terampil di Asia Tenggara.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Sensus penduduk di Indonesia diselenggarakan oleh Badan Pusat Statistik (BPS) setiap 10 tahun sekali.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Indeks Pembangunan Manusia (IPM / HDI) mengukur pencapaian pembangunan manusia berdasarkan kesehatan, pendidikan, dan standar hidup layak.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Westernisasi adalah proses peniruan gaya hidup bangsa barat tanpa menyaring kesesuaiannya dengan nilai luhur bangsa sendiri.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Sekularisme adalah paham yang memisahkan antara urusan agama dengan urusan publik atau kenegaraan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Pemberdayaan komunitas lokal bertujuan menumbuhkan kemandirian ekonomi dan sosial masyarakat berbasis potensi daerah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Konflik agraria di pedesaan sering kali bersumber dari tumpang tindih sertifikat hak kepemilikan tanah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Teori Sistem Dunia (World-System Theory) yang membagi negara menjadi Core, Semi-Periphery, dan Periphery dikemukakan oleh...', 'ans' => 'Immanuel Wallerstein', 'opts' => ['Francis Fukuyama', 'Immanuel Wallerstein', 'Samuel Huntington', 'Anthony Giddens']],
                ['t' => 'sulit', 'q' => 'Konsep "The Clash of Civilizations" (Benturan Antarperadaban) dalam hubungan pasca-Perang Dingin ditulis oleh Samuel P. Huntington.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Teori Modernisasi menurut Walt W. Rostow membagi tahapan pertumbuhan ekonomi menjadi lima tahapan linier.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Teori Ketergantungan (Dependency Theory) menyatakan bahwa keterbelakangan negara dunia ketiga disebabkan oleh eksploitasi negara maju.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Neoliberalisme ekonomi menekankan deregulasi pasar, privatisasi BUMN, dan pengurangan intervensi pemerintah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Konsep "Genshiken" atau modal sosial (Social Capital) mencakup kepercayaan (trust), norma timbal balik, dan jaringan sosial.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Politik bebas aktif Indonesia bermakna tidak memihak blok kekuatan manapun dan aktif memperjuangkan ketertiban dunia.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Diplomasi multilateral Indonesia tercermin dalam partisipasinya di sidang umum PBB dan G20.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Resolusi konflik pasca-bencana atau kerusuhan sosial memerlukan rekonsiliasi dan rekonstruksi sosial menyeluruh.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Kedaulatan pangan berbeda dengan ketahanan pangan karena kedaulatan pangan menekankan hak bangsa untuk menentukan kebijakan pangan mandiri.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 6: PPKN SMA
            // -------------------------------------------------------------------------
            6 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Indonesia adalah negara hukum (Pasal 1 ayat 3 UUD 1945).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Kekuasaan yudikatif bertugas mengadili pelanggaran terhadap undang-undang.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Wawasan Nusantara adalah cara pandang bangsa Indonesia mengenai diri dan lingkungannya yang serba beragam dan bernilai strategis.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Pancasila sebagai ideologi terbuka mampu berinteraksi secara dinamis dengan perkembangan zaman tanpa mengubah nilai dasarnya.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Pelanggaran HAM berat mencakup kejahatan genosida dan kejahatan terhadap kemanusiaan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Komisi Nasional Hak Asasi Manusia (Komnas HAM) bertugas menegakkan dan melindungi HAM di Indonesia.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Sistem pertahanan dan keamanan negara Indonesia menggunakan Sistem Pertahanan dan Keamanan Rakyat Semesta (Sishankamrata).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'DPR memegang kekuasaan membentuk undang-undang (Kekuasaan Legislatif).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Presiden dan Wakil Presiden memegang jabatan selama lima tahun dan sesudahnya dapat dipilih kembali hanya untuk satu kali masa jabatan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Mahkamah Agung membawahi badan peradilan umum, agama, militer, dan tata usaha negara.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Unsur deklaratif berdirinya suatu negara adalah pengakuan dari negara lain.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Tiga unsur konstitutif mutlak berdirinya negara adalah wilayah, rakyat, dan pemerintah yang berdaulat.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Asas Wawasan Nusantara mencakup kepentingan bersama, keadilan, kejujuran, solidaritas, kerja sama, dan kesetiaan terhadap kesepakatan bersama.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Good Governance (Tata Kelola Pemerintahan yang Baik) memiliki prinsip utama transparansi, akuntabilitas, dan partisipasi publik.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Mahkamah Konstitusi berwenang mengadili pada tingkat pertama dan terakhir yang putusannya bersifat final untuk memutus sengketa kewenangan lembaga negara.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Pemakzulan (impeachment) Presiden di Indonesia diproses oleh DPR, diadili secara hukum oleh MK, dan diputuskan oleh MPR.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Hak prerogatif presiden contohnya adalah memberikan grasi, amnesti, abolisi, dan rehabilitasi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Grasi adalah pengampunan berupa perubahan, peringanan, pengurangan, atau penghapusan pelaksanaan pidana kepada terpidana yang diberikan Presiden.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Ancaman non-militer dapat berdimensi ideologi, politik, ekonomi, sosial budaya, teknologi informasi, serta keselamatan umum.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Pemberian amnesti dan abolisi oleh Presiden harus dengan memperhatikan pertimbangan Dewan Perwakilan Rakyat.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Dimensi realitas ideologi Pancasila mencerminkan kemampuan nilai-nilai dasar Pancasila hidup dan mengakar dalam masyarakat.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Dimensi idealitas ideologi Pancasila memuat nilai-nilai yang memberi harapan dan optimisme masa depan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Dimensi fleksibilitas ideologi Pancasila memungkinkan pengembangan pemikiran-pemikiran baru yang relevan tanpa merusak jati diri.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Pancasila sebagai staatsfundamentalnorm menempati hierarki tertinggi norma hukum di Indonesia.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Kewenangan Judicial Review terhadap undang-undang terhadap UUD 1945 berada di MK, sedangkan pengujian peraturan di bawah undang-undang terhadap UU berada di MA.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Komisi Pemberantasan Korupsi (KPK) adalah lembaga negara yang independen dan bebas dari pengaruh kekuasaan manapun.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Paham radikalisme dan terorisme merupakan ancaman nyata terhadap keutuhan NKRI dan Pancasila.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Pasal 28A sampai 28J UUD 1945 memuat jaminan komprehensif Hak Asasi Manusia bagi setiap warga negara.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Perjanjian internasional yang menimbulkan akibat luas dan mendasar bagi kehidupan rakyat yang terkait dengan beban keuangan negara memerlukan persetujuan DPR.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Pencegahan korupsi, kolusi, dan nepotisme (KKN) merupakan salah satu amanat utama agenda Reformasi 1998.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 7: PENDIDIKAN AGAMA & BUDI PEKERTI SMA
            // -------------------------------------------------------------------------
            7 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Berpikir kritis dan merenungi penciptaan langit dan bumi termaktub dalam Surah Ali \'Imran ayat 190-191.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Islam melarang keras perilaku pergaulan bebas dan zina sebagaimana ditegaskan dalam Surah Al-Isra\' ayat 32.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Bersikap adil dan jujur dalam bertransaksi merupakan kewajiban setiap muslim.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Pernikahan dalam Islam bertujuan untuk membangun keluarga yang sakinah, mawaddah, dan rahmah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Hukum waris Islam (Faraid) mengatur pembagian harta peninggalan secara adil berdasarkan ketentuan syariat.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Sikap kerja keras dan tanggung jawab dalam mencari nafkah halal terhitung sebagai nilai ibadah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Menjaga kerukunan antarumat beragama merupakan wujud pengamalan toleransi berbangsa.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Ihsan berarti beribadah kepada Allah seolah-olah melihat-Nya, atau meyakini bahwa Dia senantiasa melihat kita.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Sikap syaja\'ah dalam Islam bermakna keberanian membela kebenaran.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Perilaku riddah (murtad) dan syirik merupakan dosa yang sangat besar.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Sumber hukum Islam yang disepakati oleh mayoritas ulama adalah Al-Qur\'an, Hadis, Ijma\', dan Qiyas.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Kesepakatan para mujtahid umat Islam pada suatu masa setelah wafatnya Rasulullah SAW tentang suatu hukum syar\'i disebut...', 'ans' => 'Ijma\'', 'opts' => ['Qiyas', 'Ijma\'', 'Istihsan', 'Maslahah Mursalah']],
                ['t' => 'sedang', 'q' => 'Menetapkan hukum suatu peristiwa yang tidak ada nashnya dengan peristiwa yang ada nashnya karena ada kesamaan \'illat (sebab) disebut...', 'ans' => 'Qiyas', 'opts' => ['Ijma\'', 'Qiyas', 'Urf', 'Istishab']],
                ['t' => 'sedang', 'q' => 'Rukun nikah dalam Islam meliputi calon pengantin pria dan wanita, wali nikah, dua orang saksi adil, dan...', 'ans' => 'Ijab dan qabul (sighat)', 'opts' => ['Pesta walimah', 'Ijab dan qabul (sighat)', 'Mahar emas murni', 'Baju pengantin']],
                ['t' => 'sedang', 'q' => 'Ahli waris yang bagiannya sudah ditentukan secara pasti dalam Al-Qur\'an disebut Dzawil Furudh.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Ahli waris yang mengambil seluruh sisa harta warisan setelah dibagikan kepada Dzawil Furudh disebut Asabah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Transaksi jual beli terlarang yang mengandung ketidakpastian atau spekulasi penipuan disebut...', 'ans' => 'Gharar', 'opts' => ['Riba', 'Gharar', 'Maysir', 'Ihtikar']],
                ['t' => 'sedang', 'q' => 'Akad kerjasama usaha antara pemilik modal (shahibul mal) dan pengelola modal (mudharib) disebut akad...', 'ans' => 'Mudharabah', 'opts' => ['Musyarakah', 'Mudharabah', 'Murabahah', 'Ijarah']],
                ['t' => 'sedang', 'q' => 'Pengurusan jenazah muslim meliputi memandikan, mengafani, mensolatkan, dan menguburkan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Salat jenazah terdiri dari empat takbir tanpa ruku\' dan sujud.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Konsep ijtihad adalah pengerahan segenap kesanggupan akal pikiran untuk menetapkan hukum syariat dari dalil-dalil terperinci.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Empat mazhab fikih ahlussunnah wal jama\'ah yang masyhur adalah Mazhab Hanafi, Maliki, Syafi\'i, dan Hambali.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Tokoh pembaharu pemikiran Islam modern dari Mesir yang menggagas gerakan Pan-Islamisme adalah Jamaluddin Al-Afghani.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Praktek penimbunan barang dagangan untuk menaikkan harga pasar secara sepihak disebut ihtikar dan hukumnya haram.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Teori Gujarat, Mekkah, dan Persia merupakan tiga teori utama masuknya Islam ke kepulauan Indonesia.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Prinsip asuransi syariah berlandaskan tolong-menolong (ta\'awun) dan saling menanggung (takaful).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Konsep Wasathiyah dalam Islam mengajarkan moderasi beragama, berada di tengah, dan menolak ekstremisme.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Perbuatan menghindarkan diri dari perkara syubhat (samar-samar antara halal dan haram) disebut sikap wara\'.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Hak waris seorang anak perempuan tunggal jika tidak ada anak laki-laki adalah setengah (1/2) dari harta warisan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Ibu kandung mendapat bagian waris 1/6 jika pewaris memiliki anak atau cucu keturunan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 8: INFORMATIKA & TIK SMA
            // -------------------------------------------------------------------------
            8 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Bahasa pemrograman tingkat tinggi yang populer untuk Data Science dan Artificial Intelligence adalah Python.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Dalam pemrograman, variabel digunakan untuk menyimpan nilai data di memori.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Tipe data boolean hanya memiliki dua nilai kemungkinan yaitu True atau False.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Sistem basis data relasional (RDBMS) mengorganisasi data dalam bentuk tabel-tabel baris dan kolom.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'SQL (Structured Query Language) adalah bahasa standar untuk mengelola basis data relasional.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Perintah SQL "SELECT * FROM siswa;" digunakan untuk mengambil seluruh data dari tabel siswa.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Otak komputer yang memproses miliaran instruksi per detik adalah CPU / Mikroprosesor.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'SSD (Solid State Drive) membaca dan menulis data jauh lebih cepat daripada Harddisk magnetik (HDD).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Git adalah sistem pengontrol versi (version control system) terdistribusi yang sangat populer bagi pengembang perangkat lunak.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Cyberbullying dan penyebaran berita palsu (hoax) diatur sanksinya dalam Undang-Undang ITE.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Struktur data graf (Graph) terdiri dari kumpulan simpul (vertex/node) dan sisi (edge/arc) yang menghubungkannya.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Kompleksitas waktu notasi Big-O untuk algoritma pencarian biner (Binary Search) adalah O(log n).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Kompleksitas waktu rata-rata algoritma Bubble Sort pada larik n elemen adalah O(n²).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Model referensi jaringan OSI (Open Systems Interconnection) terdiri dari...', 'ans' => '7 lapisan (layers)', 'opts' => ['4 lapisan', '5 lapisan', '7 lapisan (layers)', '9 lapisan']],
                ['t' => 'sedang', 'q' => 'Lapisan OSI paling atas yang berinteraksi langsung dengan perangkat lunak aplikasi pengguna adalah...', 'ans' => 'Application Layer', 'opts' => ['Network Layer', 'Transport Layer', 'Application Layer', 'Physical Layer']],
                ['t' => 'sedang', 'q' => 'Protokol lapisan transport yang menjamin pengiriman paket data andal dan bebas galat (reliable connection-oriented) adalah...', 'ans' => 'TCP (Transmission Control Protocol)', 'opts' => ['UDP', 'TCP (Transmission Control Protocol)', 'IP', 'ICMP']],
                ['t' => 'sedang', 'q' => 'Pemrograman Berorientasi Objek (OOP) memiliki empat pilar utama: Enkapsulasi, Abstraksi, Pewarisan (Inheritance), dan Polimorfisme.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Primary Key dalam tabel database menjamin setiap baris data bersifat unik dan tidak bernilai NULL.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Foreign Key berfungsi untuk menghubungkan data antar dua tabel yang berelasi dalam database.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Serangan siber DDoS (Distributed Denial of Service) bertujuan melumpuhkan server target dengan membanjiri lalu lintas data dari banyak sumber.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Kriptografi kunci asimetris (kunci publik) menggunakan pasangan kunci publik untuk enkripsi dan kunci pribadi untuk dekripsi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Fungsi hash satu arah (seperti SHA-256) menghasilkan nilai keluaran berukuran tetap dan tidak dapat dibalikkan ke data asli.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Teknologi Blockchain merupakan buku besar terdistribusi yang tidak dapat diubah (immutable) dan terdesentralisasi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Algoritma Dijkstra digunakan untuk mencari lintasan terpendek (shortest path) pada sebuah graf berbobot.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Dynamic Programming menyelesaikan masalah kompleks dengan memecahnya menjadi sub-masalah yang tumpang tindih dan menyimpan solusinya (memoization).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Metode normalisasi basis data (1NF, 2NF, 3NF) bertujuan menghilangkan anomali redundansi data dan inkonsistensi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Cloud computing model IaaS (Infrastructure as a Service) menyediakan infrastruktur server virtual dan media penyimpanan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Arsitektur REST API menggunakan metode HTTP standar seperti GET, POST, PUT, dan DELETE untuk komunikasi data antar sistem.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Jaringan saraf tiruan (Artificial Neural Network / ANN) pada deep learning terinspirasi dari struktur neuron biologis otak manusia.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Two-Factor Authentication (2FA) meningkatkan keamanan akun dengan mewajibkan verifikasi ganda saat login.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 9: SENI BUDAYA SMA
            // -------------------------------------------------------------------------
            9 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Apresiasi seni adalah aktivitas mengamati, memahami, menghayati, dan menilai karya seni secara kritis.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Pameran seni rupa berfungsi sebagai sarana edukasi, apresiasi, dan komunikasi antara perupa dan penikmat seni.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Seni rupa kontemporer merupakan karya seni yang berkembang pada masa kini dan merefleksikan situasi mutakhir.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Musik tradisional adalah musik yang hidup dan berkembang secara turun-temurun di suatu daerah tertentu.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Orkestra simfoni memainkan instrumen musik gesek, tiup kayu, tiup logam, dan perkusi secara terpadu.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Seseorang yang memimpin pertunjukan paduan suara atau orkestra musik disebut konduktor (dirigen).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Koreografi adalah seni merancang dan menata susunan gerak dalam pertunjukan tari.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Sutradara bertugas memimpin dan mengarahkan jalannya seluruh pementasan teater atau pembuatan film.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Monolog adalah percakapan atau lakon yang dibawakan oleh seorang pemeran tunggal di atas panggung.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Karya seni instalasi menggabungkan berbagai media dan benda di dalam suatu ruang pameran interaktif.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Prinsip-prinsip seni rupa mencakup kesatuan (unity), keseimbangan (balance), proporsi, irama (rhythm), dan pusat perhatian (vocal point).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Aliran seni lukis Kubisme yang memecah objek menjadi bentuk-bentuk geometris dipelopori oleh...', 'ans' => 'Pablo Picasso', 'opts' => ['Vincent van Gogh', 'Pablo Picasso', 'Claude Monet', 'Salvador Dali']],
                ['t' => 'sedang', 'q' => 'Aliran Impresionisme mengutamakan efek pencahayaan seketika pada objek di alam terbuka.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Komposisi musik terdiri dari melodi, harmoni, ritme, dan warna suara (timbre).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Tangga nada pentatonis tradisional Jawa terdiri dari laras Slendro dan laras...', 'ans' => 'Pelog', 'opts' => ['Diatonis', 'Pelog', 'Kromatis', 'Modal']],
                ['t' => 'sedang', 'q' => 'Tari kreasi baru bersumber dari tari tradisional yang dikembangkan gerak dan kostumnya sesuai perkembangan zaman.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Pentas teater kontemporer sering kali mengaburkan batas antara panggung pemeran dan tempat duduk penonton.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Desain Komunikasi Visual (DKV) memanfaatkan elemen tipografi, ilustrasi, dan fotografi untuk menyampaikan pesan visual persuasif.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Kurator seni bertugas menyeleksi, mengelola, dan mengonsep narasi kuratorial karya seni dalam pameran seni rupa.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Akord mayor dibentuk oleh nada dasar, nada ters mayor (jarak 2 laras), dan nada kuint (jarak 3 1/2 laras).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Kritik seni rupa menurut Feldman dibagi menjadi kritik jurnalistik, pedagogik, ilmiah (akademik), dan kritik populer.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Tahapan kritik seni rupa berurutan menurut Feldman adalah deskripsi, analisis formal, interpretasi, dan evaluasi/penilaian.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Bentuk arsitektur candi Hindu di Indonesia seperti Prambanan berpuncak pada bentuk Ratna, sedangkan candi Buddha berpuncak pada bentuk Stupa.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Musik atonal adalah musik yang disusun tanpa memusat pada suatu tangga nada tonika pokok tertentu.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Teater Epik yang bertujuan memancing pemikiran kritis penonton melalui efek keterasingan (Verfremdungseffekt) dipelopori oleh...', 'ans' => 'Bertolt Brecht', 'opts' => ['Konstantin Stanislavski', 'Bertolt Brecht', 'William Shakespeare', 'Anton Chekhov']],
                ['t' => 'sulit', 'q' => 'Metode keaktoran "The Method" yang menuntut penghayatan psikologis mendalam atas karakter dipelopori oleh Konstantin Stanislavski.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Seni pertunjukan Happening Art dan Performance Art menekankan keterlibatan aksi tubuh seniman dalam ruang dan waktu nyata.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Properti panggung pada pertunjukan teater berfungsi mendukung penokohan watak dan suasana dramatik adegan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Karya seni rupa Pop Art yang mengangkat ikon budaya populer dan periklanan dipopulerkan oleh Andy Warhol.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Hak Cipta (Copyright) melindungi hak moral dan hak ekonomi seniman atas ciptaan karyanya.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 10: PJOK (OLAHRAGA) SMA
            // -------------------------------------------------------------------------
            10 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Kebugaran jasmani mencakup daya tahan kardiorespirasi, kekuatan otot, kelenturan, dan komposisi tubuh.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Pemanasan dinamis dilakukan dengan gerakan berirama dan meregangkan otot secara aktif sebelum berolahraga.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Organisasi sepak bola dunia adalah FIFA (Federation Internationale de Football Association).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Induk organisasi sepak bola nasional di Indonesia adalah PSSI.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Induk organisasi bola basket nasional di Indonesia adalah PERBASI.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Induk organisasi bulu tangkis nasional di Indonesia adalah PBSI.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Gaya hidup sedenter (kurang gerak) dapat meningkatkan risiko penyakit kardiovaskular dan obesitas.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Latihan angkat beban terencana dapat meningkatkan massa otot dan kepadatan tulang.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Dehidrasi saat berolahraga dapat dicegah dengan minum air putih yang cukup sebelum, saat, dan sesudah latihan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Tidur berkualitas 7-8 jam per malam sangat penting untuk regenerasi sel dan pemulihan otot.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Pola pertahanan zona (Zone Defense) dalam permainan bola basket berarti setiap pemain menjaga area tertentu.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Formasi sepak bola 4-4-2 terdiri dari 4 pemain bertahan, 4 pemain tengah, dan 2 penyerang.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Zona target denyut nadi latihan (Training Heart Rate) untuk meningkatkan kebugaran aerobik adalah 60% - 80% dari Denyut Nadi Maksimum (220 - usia).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Prinsip latihan beban FITT terdiri dari Frequency, Intensity, Time, dan Type.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Pola penyerangan bola voli yang memanfaatkan bola umpan cepat di dekat net disebut quick attack.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Sistem pernapasan dalam renang gaya bebas dilakukan dengan memiringkan kepala ke salah satu sisi saat ayunan tangan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Doping dilarang keras dalam olahraga karena melanggar sportivitas dan membahayakan kesehatan atlet.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Pencegahan penularan HIV/AIDS dilakukan dengan menjauhi pergaulan bebas, jarum suntik bekas, dan narkoba.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Latihan kelenturan (stretching) teratur dapat meningkatkan rentang gerak sendi (Range of Motion).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Kekuatan anaerobik digunakan saat tubuh membutuhkan ledakan tenaga maksimal dalam waktu singkat, seperti pada lari sprint 100 meter.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Kapasitas aerobik maksimal seseorang dinyatakan dengan nilai VO₂ Max (mililiter oksigen per kilogram berat badan per menit).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Asam laktat yang menumpuk di jaringan otot akibat metabolisme anaerobik dapat memicu rasa pegal dan kelelahan otot.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Prinsip beban lebih (Overload Principle) menyatakan bahwa adaptasi fisik hanya terjadi jika beban latihan ditingkatkan secara berkala.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Latihan pliometrik (seperti jump squat dan box jumps) dirancang untuk meningkatkan daya ledak otot (power).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Pola pertahanan gerendel (Catenaccio) dalam sepak bola terkenal dengan fokus pertahanan rapat dan disiplin tinggi asal Italia.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Filosofi sepak bola "Total Football" dipopulerkan oleh tim nasional Belanda di mana setiap pemain dapat bertukar peran posisi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Cedera robekan ligamen lutut anterior yang sering dialami atlet sepak bola dan bola basket adalah cedera ACL (Anterior Cruciate Ligament).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Resusitasi Jantung Paru (RJP / CPR) darurat dilakukan dengan kompresi dada sedalam 5-6 cm dengan kecepatan 100-120 kali per menit.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Nutrisi makro bagi pemulihan otot pasca latihan beban intensif menuntut asupan protein berkualitas tinggi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Nilai fair play dalam olahraga mencakup integritas, respek pada lawan, mematuhi keputusan wasit, dan menolak kecurangan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 17: SEJARAH INDONESIA SMA
            // -------------------------------------------------------------------------
            17 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Konsep berpikir kronologis dalam sejarah berarti mempelajari peristiwa secara berurutan sesuai urutan waktu terjadinya.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Konsep berpikir sinkronik mempelajari peristiwa sejarah dengan memperdalam ruang lingkup kondisi sosial budaya pada kurun waktu terbatas.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Sumber primer sejarah adalah peninggalan asli yang berasal langsung dari zaman terjadinya peristiwa, seperti prasasti atau dokumen sezaman.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Kerajaan Kutai di Kalimantan Timur merupakan kerajaan Hindu tertua di kepulauan Indonesia berdasarkan bukti Prasasti Yupa.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Raja terbesar Kerajaan Majapahit yang memimpin puncak kejayaannya adalah Raja Hayam Wuruk didampingi Patih Gajah Mada.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'VOC (Vereenigde Oostindische Compagnie) adalah kongsi dagang Belanda yang didirikan pada tahun 1602.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Hak Octrooi adalah hak-hak istimewa yang diberikan pemerintah Belanda kepada VOC, termasuk hak monopoli dagang dan mencetak uang.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Politik Etis (Balas Budi) yang dicetuskan Van Deventer memiliki tiga program: Irigasi, Emigrasi, dan Edukasi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Dekrit Presiden 5 Juli 1959 menetapkan pembubaran Konstituante dan berlakunya kembali UUD 1945.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'ASEAN didirikan di Bangkok pada tanggal 8 Agustus 1967 oleh lima negara pemrakarsa termasuk Indonesia.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Metode historiografi penelitian sejarah terdiri atas empat tahapan berurutan: Heuristik, Kritik Sumber, Interpretasi, dan Historiografi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Kritik eksternal sumber sejarah bertujuan untuk menguji keaslian fisik (otentisitas) dokumen sejarah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Kritik internal sumber sejarah bertujuan untuk menguji kebenaran isi informasi (kredibilitas) dokumen sejarah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Sistem Demokrasi Liberal di Indonesia (1950-1959) menggunakan sistem pemerintahan parlementer dengan kabinet yang sering jatuh bangun.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Kabinet Djuanda berhasil melahirkan Deklarasi Djuanda 1957 yang menetapkan batas laut wilayah perairan Nusantara.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Sistem Demokrasi Terpimpin (1959-1965) ditandai dengan pemusatan kekuasaan politik pada figur Presiden Soekarno.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Masa Orde Baru di bawah Presiden Soeharto memfokuskan stabilitas politik dan pembangunan ekonomi melalui program Repelita.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Konsep Dwifungsi ABRI pada masa Orde Baru memberi peran kepada militer dalam bidang pertahanan dan pemerintahan sipil.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Krisis moneter 1997 memicu krisis multidimensi yang berujung pada runtuhnya kekuasaan Orde Baru pada Mei 1998.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Amandemen UUD 1945 pada era reformasi membatasi masa jabatan presiden maksimal dua periode berturut-turut.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Pemberontakan PRRI di Sumatra dan Permesta di Sulawesi pada akhir era 1950-an dipicu oleh ketidakpuasan daerah terhadap ketimpangan alokasi pembangunan dari pusat.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Peristiwa Konfrontasi Indonesia-Malaysia pada masa Demokrasi Terpimpin ditandai dengan komando Dwikora dan keluarnya Indonesia dari PBB pada tahun 1965.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Fusi partai politik tahun 1973 pada masa Orde Baru menyederhanakan partai politik menjadi tiga kekuatan: PPP, PDI, dan Golongan Karya.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Tragedi Trisakti pada 12 Mei 1998 menewaskan empat mahasiswa dan menjadi pemicu gelombang demonstrasi mahasiswa besar-besaran.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Referendum Timor Timur diselenggarakan pada masa pemerintahan Presiden B.J. Habibie pada Agustus 1999.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Gus Dur (K.H. Abdurrahman Wahid) menjabat sebagai Presiden ke-4 RI dan dikenal atas pembelaannya terhadap pluralisme dan minoritas.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Megawati Soekarnoputri adalah presiden wanita pertama di Indonesia yang memimpin dari tahun 2001 hingga 2004.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Pemilihan Presiden secara langsung oleh rakyat pertama kali diselenggarakan pada tahun 2004.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Perjanjian Damai Helsinki tahun 2005 mengakhiri konflik bersenjata antara Gerakan Aceh Merdeka (GAM) dan Pemerintah RI.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Garis imajiner pergerakan sejarah bersifat berkesinambungan (kontinuitas) dan perubahan (change).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],
        ];
    }
}

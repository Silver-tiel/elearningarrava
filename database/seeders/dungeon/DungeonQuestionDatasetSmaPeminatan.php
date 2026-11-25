<?php

namespace Database\Seeders\Dungeon;

class DungeonQuestionDatasetSmaPeminatan
{
    /**
     * Mengambil daftar soal dungeon SMA Peminatan (6 mapel).
     * Masing-masing mapel memiliki minimal 30 soal (10 Mudah, 10 Sedang, 10 Sulit).
     */
    public static function getQuestionsByMapel(): array
    {
        return [
            // -------------------------------------------------------------------------
            // MAPEL 11: FISIKA SMA (id_mapel = 11)
            // -------------------------------------------------------------------------
            11 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Satuan internasional (SI) untuk besaran energi dan usaha adalah...', 'ans' => 'Joule', 'opts' => ['Watt', 'Joule', 'Newton', 'Pascal']],
                ['t' => 'mudah', 'q' => 'Alat ukur yang memiliki ketelitian hingga 0,01 mm untuk mengukur diameter kawat adalah...', 'ans' => 'Mikrometer sekrup', 'opts' => ['Jangka sorong', 'Mikrometer sekrup', 'Mistar baja', 'Roll meter']],
                ['t' => 'mudah', 'q' => 'Hukum I Newton sering juga disebut sebagai hukum kelembaman (inersia).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Rumus energi kinetik sebuah benda bermassa m yang bergerak dengan kecepatan v adalah...', 'ans' => 'Ek = 1/2 m.v²', 'opts' => ['Ek = m.g.h', 'Ek = 1/2 m.v²', 'Ek = m.v', 'Ek = 1/2 k.x²']],
                ['t' => 'mudah', 'q' => 'Rumus energi potensial gravitasi benda di dekat permukaan bumi adalah...', 'ans' => 'Ep = m.g.h', 'opts' => ['Ep = m.g.h', 'Ep = 1/2 m.v²', 'Ep = F.s', 'Ep = m.a']],
                ['t' => 'mudah', 'q' => 'Usaha yang dilakukan pada benda bernilai nol jika gaya yang bekerja tegak lurus dengan arah perpindahan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Percepatan gravitasi standar di dekat permukaan bumi bernilai sekitar...', 'ans' => '9,8 m/s²', 'opts' => ['8,9 m/s²', '9,8 m/s²', '10,8 m/s²', '12,5 m/s²']],
                ['t' => 'mudah', 'q' => 'Benda yang bergerak melingkar beraturan memiliki kelajuan tetap namun arah kecepatannya selalu berubah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Satuan daya listrik dalam SI adalah Watt.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Hukum kekekalan energi menyatakan bahwa energi total dalam sistem terisolasi selalu konstan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Sebuah mobil bergerak dengan kecepatan 72 km/jam. Kecepatan tersebut setara dengan...', 'ans' => '20 m/s', 'opts' => ['15 m/s', '20 m/s', '25 m/s', '30 m/s']],
                ['t' => 'sedang', 'q' => 'Mobil bermassa 1.000 kg dipercepat dari keadaan diam hingga mencapai kecepatan 20 m/s dalam 5 detik. Gaya yang bekerja adalah...', 'ans' => '4.000 N', 'opts' => ['2.000 N', '4.000 N', '5.000 N', '10.000 N']],
                ['t' => 'sedang', 'q' => 'Hukum Hooke pada pegas menyatakan hubungan gaya pemulih dan pertambahan panjang pegas dengan rumus...', 'ans' => 'F = k . Δx', 'opts' => ['F = k / Δx', 'F = k . Δx', 'F = 1/2 k . Δx²', 'F = m . a']],
                ['t' => 'sedang', 'q' => 'Sebuah pegas memiliki konstanta 200 N/m ditarik sejauh 0,05 m. Energi potensial pegas adalah...', 'ans' => '0,25 Joule', 'opts' => ['0,1 Joule', '0,25 Joule', '0,5 Joule', '1 Joule']],
                ['t' => 'sedang', 'q' => 'Hukum Kekekalan Momentum menyatakan bahwa jika tidak ada gaya luar yang bekerja, momentum total sebelum tumbukan sama dengan setelah tumbukan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Pada tumbukan lenting sempurna, koefisien restitusi (e) bernilai...', 'ans' => 'e = 1', 'opts' => ['e = 0', '0 < e < 1', 'e = 1', 'e > 1']],
                ['t' => 'sedang', 'q' => 'Hukum gravitasi universal Newton menyatakan gaya tarik dua massa berbanding terbalik dengan...', 'ans' => 'Kuadrat jarak kedua pusat massa (r²)', 'opts' => ['Jarak antar massa (r)', 'Kuadrat jarak kedua pusat massa (r²)', 'Jumlah kedua massa', 'Akar jarak antar massa']],
                ['t' => 'sedang', 'q' => 'Efek Doppler menjelaskan perubahan frekuensi gelombang bunyi yang didengar pengamat ketika sumber bunyi atau pengamat bergerak relatif.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Hukum Pascal menyatakan bahwa tekanan yang diberikan pada zat cair dalam ruang tertutup diteruskan ke segala arah sama besar.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Tiga buah hambatan 6 Ohm, 3 Ohm, dan 2 Ohm disusun paralel. Hambatan penggantinya adalah...', 'ans' => '1 Ohm', 'opts' => ['1 Ohm', '2 Ohm', '3 Ohm', '11 Ohm']],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Teori Relativitas Khusus Einstein menyatakan bahwa kelajuan cahaya di ruang hampa bernilai konstan bagi semua pengamat inersial.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Persamaan kesetaraan massa dan energi Einstein yang sangat terkenal adalah...', 'ans' => 'E = m . c²', 'opts' => ['E = 1/2 m.c²', 'E = m . c²', 'E = h . f', 'E = p . c']],
                ['t' => 'sulit', 'q' => 'Efek fotolistrik membuktikan bahwa cahaya dapat berperilaku sebagai partikel (foton) dengan energi E = h.f.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Hukum Gauss menghubungkan fluks listrik yang menembus permukaan tertutup dengan muatan total yang dilingkupinya.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Gaya Lorentz yang dialami kawat berarus listrik I sepanjang L dalam medan magnet B dinyatakan dengan...', 'ans' => 'F = B . I . L . sin θ', 'opts' => ['F = q . v . B', 'F = B . I . L . sin θ', 'F = B / (I . L)', 'F = I . R']],
                ['t' => 'sulit', 'q' => 'Persamaan gerak harmonik sederhana memiliki simpangan y = A sin(ωt). Kecepatan maksimumnya adalah...', 'ans' => 'v_maks = ω . A', 'opts' => ['v_maks = ω . A', 'v_maks = ω² . A', 'v_maks = A / ω', 'v_maks = 2π . A']],
                ['t' => 'sulit', 'q' => 'Efisiensi mesin Carnot ideal yang bekerja antara reservoir suhu tinggi 600 K dan suhu rendah 300 K adalah...', 'ans' => '50%', 'opts' => ['25%', '33,3%', '50%', '75%']],
                ['t' => 'sulit', 'q' => 'Hukum Termodinamika II menyatakan bahwa total entropi dari sistem yang terisolasi tidak pernah berkurang seiring waktu.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Panjang gelombang de Broglie suatu partikel bermassa m yang bergerak dengan momentum p adalah...', 'ans' => 'λ = h / p', 'opts' => ['λ = h . p', 'λ = h / p', 'λ = p / h', 'λ = h / (m.c)']],
                ['t' => 'sulit', 'q' => 'Waktu paruh (half-life) adalah waktu yang dibutuhkan oleh separuh inti radioaktif untuk meluruh.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 12: KIMIA SMA (id_mapel = 12)
            // -------------------------------------------------------------------------
            12 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Partikel penyusun inti atom terdiri dari proton dan...', 'ans' => 'Neutron', 'opts' => ['Elektron', 'Neutron', 'Positron', 'Foton']],
                ['t' => 'mudah', 'q' => 'Partikel atom yang bermuatan listrik negatif adalah elektron.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Nomor atom suatu unsur menunjukkan jumlah...', 'ans' => 'Proton dalam inti atom', 'opts' => ['Proton dalam inti atom', 'Neutron dalam inti atom', 'Massa atom relatif', 'Kulit atom']],
                ['t' => 'mudah', 'q' => 'Lambang kimia untuk unsur Emas adalah...', 'ans' => 'Au', 'opts' => ['Ag', 'Fe', 'Au', 'Cu']],
                ['t' => 'mudah', 'q' => 'Rumus kimia garam dapur yang sering dikonsumsi adalah...', 'ans' => 'NaCl', 'opts' => ['HCl', 'NaOH', 'NaCl', 'KCl']],
                ['t' => 'mudah', 'q' => 'Tabel periodik unsur modern disusun berdasarkan kenaikan nomor atom oleh Henry Moseley.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Gas mulia pada golongan VIIIA bersifat sangat stabil karena memiliki 8 elektron valensi (oktet).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Larutan yang dapat menghantarkan arus listrik disebut larutan elektrolit.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Air murni pada suhu kamar memiliki nilai pH netral yaitu tepat 7.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Bilangan Avogadro yang menyatakan jumlah partikel dalam satu mol zat adalah...', 'ans' => '6,02 x 10²³ partikel/mol', 'opts' => ['3,14 x 10²³', '6,02 x 10²³ partikel/mol', '1,60 x 10⁻¹⁹', '9,8 x 10²³']],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Ikatan kimia yang terbentuk akibat serah terima elektron antara ion positif dan negatif disebut...', 'ans' => 'Ikatan ion', 'opts' => ['Ikatan kovalen polar', 'Ikatan ion', 'Ikatan kovalen nonpolar', 'Ikatan logam']],
                ['t' => 'sedang', 'q' => 'Ikatan yang terbentuk akibat penggunaan bersama pasangan elektron oleh dua atom nonlogam disebut...', 'ans' => 'Ikatan kovalen', 'opts' => ['Ikatan ion', 'Ikatan kovalen', 'Ikatan hidrogen', 'Ikatan logam']],
                ['t' => 'sedang', 'q' => 'Berapa massa molekul relatif (Mr) dari air (H₂O) jika diketahui Ar H = 1 dan Ar O = 16?', 'ans' => '18', 'opts' => ['16', '17', '18', '20']],
                ['t' => 'sedang', 'q' => 'Hukum Lavoisier (Hukum Kekekalan Massa) menyatakan massa total zat sebelum reaksi sama dengan massa setelah reaksi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Pada suhu dan tekanan standar (STP: 0°C, 1 atm), volume 1 mol gas ideal adalah...', 'ans' => '22,4 liter', 'opts' => ['11,2 liter', '22,4 liter', '24,0 liter', '44,8 liter']],
                ['t' => 'sedang', 'q' => 'Asam kuat yang terionisasi sempurna dalam larutan contohnya adalah asam klorida (HCl).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Reaksi kimia yang menyerap kalor dari lingkungan ke sistem disebut reaksi endoterm.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Laju reaksi kimia dapat dipercepat dengan menaikkan suhu, memperbesar konsentrasi, dan menambahkan...', 'ans' => 'Katalis', 'opts' => ['Inhibitor', 'Katalis', 'Pelarut dingin', 'Pengendap']],
                ['t' => 'sedang', 'q' => 'Senyawa hidrokarbon alkana memiliki rumus umum...', 'ans' => 'CnH2n+2', 'opts' => ['CnH2n', 'CnH2n+2', 'CnH2n-2', 'CnH2n+1OH']],
                ['t' => 'sedang', 'q' => 'Larutan penyangga (buffer) berfungsi untuk mempertahankan pH larutan terhadap penambahan sedikit asam atau basa.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Berdasarkan teori asam-basa Bronsted-Lowry, asam adalah spesi yang...', 'ans' => 'Mendonorkan proton (H⁺)', 'opts' => ['Menerima pasangan elektron bebas', 'Mendonorkan proton (H⁺)', 'Menerima proton (H⁺)', 'Melepaskan ion OH⁻']],
                ['t' => 'sulit', 'q' => 'Dalam reaksi redoks, oksidasi didefinisikan sebagai peristiwa pelepasan elektron atau kenaikan bilangan oksidasi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Bilangan oksidasi atom Mangan (Mn) dalam senyawa KMnO₄ adalah...', 'ans' => '+7', 'opts' => ['+2', '+4', '+6', '+7']],
                ['t' => 'sulit', 'q' => 'Pada sel volta, kutub anoda bermuatan negatif dan terjadi reaksi...', 'ans' => 'Oksidasi', 'opts' => ['Reduksi', 'Oksidasi', 'Hidrolisis', 'Netralisasi']],
                ['t' => 'sulit', 'q' => 'Hukum Pergeseran Kesetimbangan Le Chatelier menyatakan jika sistem kesetimbangan diberi aksi, sistem akan bergeser mengurangi pengaruh aksi tersebut.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Konfigurasi elektron atom Klorin (Nomor atom 17) pada keadaan dasar adalah...', 'ans' => '1s² 2s² 2p⁶ 3s² 3p⁵', 'opts' => ['1s² 2s² 2p⁶ 3s² 3p⁶', '1s² 2s² 2p⁶ 3s² 3p⁵', '1s² 2s² 2p⁶ 3s¹ 3p⁶', '1s² 2s² 2p⁶ 4s² 3d⁵']],
                ['t' => 'sulit', 'q' => 'Sifat koligatif larutan tidak bergantung pada jenis zat terlarut, melainkan pada...', 'ans' => 'Jumlah partikel zat terlarut', 'opts' => ['Warna zat terlarut', 'Jumlah partikel zat terlarut', 'Bentuk molekul zat', 'Massa jenis pelarut']],
                ['t' => 'sulit', 'q' => 'Senyawa organik turunan alkana dengan gugus fungsi -OH disebut...', 'ans' => 'Alkohol (Alkanol)', 'opts' => ['Eter', 'Alkohol (Alkanol)', 'Aldehida', 'Asam karboksilat']],
                ['t' => 'sulit', 'q' => 'Isomer optik aktif memiliki atom karbon asimetris (karbon kiral) yang mengikat empat gugus berbeda.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Polimer sintesis yang terbentuk dari polimerisasi kondensasi asam tereftalat dan etilen glikol adalah...', 'ans' => 'Dacron (Poliester)', 'opts' => ['Polietilena', 'PVC', 'Dacron (Poliester)', 'Teflon']],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 13: BIOLOGI SMA (id_mapel = 13)
            // -------------------------------------------------------------------------
            13 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Unit struktural dan fungsional terkecil dari makhluk hidup adalah...', 'ans' => 'Sel', 'opts' => ['Jaringan', 'Organ', 'Sel', 'Molekul']],
                ['t' => 'mudah', 'q' => 'Organel sel yang bertindak sebagai pengendali seluruh aktivitas sel adalah...', 'ans' => 'Nukleus (Inti sel)', 'opts' => ['Ribosom', 'Nukleus (Inti sel)', 'Lisosom', 'Sentrosom']],
                ['t' => 'mudah', 'q' => 'Molekul pembawa informasi genetika utama pada sebagian besar makhluk hidup adalah DNA.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Organel sel tumbuhan yang mengandung klorofil untuk fotosintesis adalah...', 'ans' => 'Kloroplas', 'opts' => ['Mitokondria', 'Kloroplas', 'Vakuola', 'Badan Golgi']],
                ['t' => 'mudah', 'q' => 'Hewan yang tidak bertulang belakang disebut hewan avertebrata (invertebrata).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Jaringan tumbuhan yang bertugas mengangkut air dan mineral dari akar ke daun adalah...', 'ans' => 'Xilem', 'opts' => ['Floem', 'Xilem', 'Kambium', 'Epidermis']],
                ['t' => 'mudah', 'q' => 'Jaringan floem bertugas mengangkut hasil fotosintesis dari daun ke seluruh tubuh tumbuhan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Bakteri tergolong dalam organisme prokariotik karena tidak memiliki membran inti sel.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Virus berukuran ultramikroskopis dan hanya dapat bereplikasi di dalam sel inang hidup.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Gregor Mendel dikenal sebagai Bapak Genetika Modern atas penelitian persilangan tanaman kacang ercis.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Pada respirasi seluler aerob, satu molekul glukosa secara teoritis menghasilkan sekitar...', 'ans' => '36 hingga 38 ATP', 'opts' => ['2 ATP', '4 ATP', '36 hingga 38 ATP', '100 ATP']],
                ['t' => 'sedang', 'q' => 'Empat tahapan utama respirasi aerob berurutan adalah...', 'ans' => 'Glikolisis, Dekarboksilasi Oksidatif, Siklus Krebs, Transpor Elektron', 'opts' => ['Glikolisis, Siklus Krebs, Transpor Elektron, Fermentasi', 'Glikolisis, Dekarboksilasi Oksidatif, Siklus Krebs, Transpor Elektron', 'Siklus Calvin, Glikolisis, Transpor Elektron', 'Fotolisis, Siklus Krebs, Glikolisis']],
                ['t' => 'sedang', 'q' => 'Glikolisis berlangsung di dalam sitoplasma (sitosol) sel dan tidak membutuhkan oksigen.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Basa nitrogen pirimidin pada molekul DNA adalah...', 'ans' => 'Sitosin dan Timin', 'opts' => ['Adenin dan Guanin', 'Sitosin dan Timin', 'Adenin dan Urasil', 'Urasil dan Timin']],
                ['t' => 'sedang', 'q' => 'Pada RNA, basa nitrogen Timin digantikan oleh basa...', 'ans' => 'Urasil', 'opts' => ['Adenin', 'Guanin', 'Urasil', 'Sitosin']],
                ['t' => 'sedang', 'q' => 'Persilangan dihibrid heterozigot (AaBb x AaBb) menghasilkan rasio fenotipe F2...', 'ans' => '9 : 3 : 3 : 1', 'opts' => ['3 : 1', '9 : 3 : 3 : 1', '1 : 2 : 1', '15 : 1']],
                ['t' => 'sedang', 'q' => 'Hormon tumbuhan yang merangsang pemanjangan sel dan pembengkokan batang ke arah cahaya adalah...', 'ans' => 'Auksin', 'opts' => ['Giberelin', 'Sitokinin', 'Auksin', 'Asam Absisat']],
                ['t' => 'sedang', 'q' => 'Pembuluh darah yang membawa darah kaya oksigen dari paru-paru menuju ke serambi kiri jantung adalah...', 'ans' => 'Vena pulmonalis', 'opts' => ['Arteri pulmonalis', 'Vena pulmonalis', 'Aorta', 'Vena kava']],
                ['t' => 'sedang', 'q' => 'Contoh mutasi genetik akibat kelebihan kromosom nomor 21 (Trisomi 21) adalah sindrom...', 'ans' => 'Down', 'opts' => ['Turner', 'Klinefelter', 'Down', 'Patau']],
                ['t' => 'sedang', 'q' => 'Spesies baru dapat terbentuk akibat isolasi geografis yang berlangsung dalam kurun waktu lama.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Proses sintesis protein terdiri dari dua tahapan utama yaitu transkripsi dan...', 'ans' => 'Translasi', 'opts' => ['Replikasi', 'Translasi', 'Duplikasi', 'Transduksi']],
                ['t' => 'sulit', 'q' => 'Transkripsi menghasilkan untai mRNA di dalam inti sel dengan bantuan enzim RNA polimerase.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Kodon awal (start codon) universal yang mengodekan asam amino metionin adalah...', 'ans' => 'AUG', 'opts' => ['UAA', 'UAG', 'AUG', 'UGA']],
                ['t' => 'sulit', 'q' => 'Kodon stop yang menghentikan proses translasi adalah UAA, UAG, dan UGA.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Enzim restriksi endonuklease dalam rekayasa genetika berfungsi untuk...', 'ans' => 'Memotong rantai DNA pada urutan basa spesifik', 'opts' => ['Menyambungkan fragmen DNA', 'Memotong rantai DNA pada urutan basa spesifik', 'Menggandakan molekul RNA', 'Membuka untai ganda DNA']],
                ['t' => 'sulit', 'q' => 'Enzim DNA ligase berfungsi sebagai "lem biologi" yang menyambungkan fragmen DNA.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Hukum Hardy-Weinberg berlaku jika populasi besar, perkawinan acak, tidak ada mutasi, dan tidak ada seleksi alam.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Reaksi terang pada fotosintesis berlangsung di tilakoid/grana dan menghasilkan ATP, NADPH, serta O₂.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Reaksi gelap (Siklus Calvin) berlangsung di stroma kloroplas dan mengikat CO₂ untuk menghasilkan glukosa.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Antibodi monoklonal diproduksi dengan menggabungkan sel limfosit B dengan sel mieloma melalui teknologi hibridoma.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 14: EKONOMI & AKUNTANSI SMA (id_mapel = 14)
            // -------------------------------------------------------------------------
            14 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Masalah pokok ekonomi klasik meliputi masalah produksi, konsumsi, dan...', 'ans' => 'Distribusi', 'opts' => ['Investasi', 'Distribusi', 'Inflasi', 'Ekspor']],
                ['t' => 'mudah', 'q' => 'Masalah pokok ekonomi modern adalah barang apa yang diproduksi (what), bagaimana memproduksi (how), dan...', 'ans' => 'Untuk siapa barang diproduksi (for whom)', 'opts' => ['Kapan barang diproduksi', 'Untuk siapa barang diproduksi (for whom)', 'Di mana lokasi pabrik', 'Berapa keuntungan yang diperoleh']],
                ['t' => 'mudah', 'q' => 'Kelangkaan (scarcity) terjadi karena kebutuhan manusia tidak terbatas sedangkan alat pemuas kebutuhan bersifat terbatas.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Biaya peluang (opportunity cost) adalah nilai dari alternatif terbaik yang dikorbankan ketika memilih suatu keputusan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Bank sentral di Indonesia yang bertugas memelihara kestabilan nilai rupiah adalah Bank Indonesia (BI).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Persamaan dasar akuntansi yang benar adalah...', 'ans' => 'Aset = Liabilitas + Ekuitas', 'opts' => ['Aset = Liabilitas - Ekuitas', 'Aset = Liabilitas + Ekuitas', 'Ekuitas = Aset + Liabilitas', 'Liabilitas = Aset + Ekuitas']],
                ['t' => 'mudah', 'q' => 'Laporan keuangan yang menyajikan pendapatan dan beban perusahaan selama periode tertentu disebut laporan...', 'ans' => 'Laba Rugi', 'opts' => ['Neraca', 'Laba Rugi', 'Perubahan Modal', 'Arus Kas']],
                ['t' => 'mudah', 'q' => 'Kenaikan harga barang secara umum dan terus menerus dalam jangka waktu tertentu disebut inflasi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Pajak merupakan pungutan wajib kepada negara yang bersifat memaksa tanpa imbalan langsung.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Bapak Ekonomi Dunia yang menulis buku "The Wealth of Nations" adalah Adam Smith.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Elastisitas permintaan yang bernilai Ed > 1 menunjukkan sifat permintaan...', 'ans' => 'Elastis', 'opts' => ['Inelastis', 'Elastis', 'Elastis uniter', 'Inelastis sempurna']],
                ['t' => 'sedang', 'q' => 'Jika koefisien elastisitas pendapatan bernilai positif (Ey > 0), maka barang tersebut digolongkan sebagai...', 'ans' => 'Barang normal', 'opts' => ['Barang inferior', 'Barang normal', 'Barang bebas', 'Barang giffen']],
                ['t' => 'sedang', 'q' => 'Produk Domestik Bruto (PDB / GDP) mengukur total nilai barang dan jasa akhir yang dihasilkan di dalam wilayah suatu negara selama satu tahun.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Pendapatan Nasional dengan pendekatan pengeluaran dihitung dengan rumus...', 'ans' => 'Y = C + I + G + (X - M)', 'opts' => ['Y = w + r + i + p', 'Y = C + I + G + (X - M)', 'Y = P1.Q1 + P2.Q2', 'Y = C + S']],
                ['t' => 'sedang', 'q' => 'Instrumen kebijakan fiskal pemerintah untuk menstabilkan perekonomian adalah mengatur...', 'ans' => 'Penerimaan pajak dan pengeluaran belanja negara (APBN)', 'opts' => ['Tingkat suku bunga acuan bank', 'Penerimaan pajak dan pengeluaran belanja negara (APBN)', 'Cadangan kas minimum bank', 'Nilai tukar rupiah terhadap dolar']],
                ['t' => 'sedang', 'q' => 'Buku harian tempat mencatat transaksi keuangan secara kronologis dan sistematis disebut...', 'ans' => 'Jurnal umum', 'opts' => ['Buku besar', 'Jurnal umum', 'Neraca saldo', 'Kertas kerja']],
                ['t' => 'sedang', 'q' => 'Akun di bawah ini yang bersaldo normal Debit adalah...', 'ans' => 'Kas, Piutang, dan Beban', 'opts' => ['Pendapatan dan Modal', 'Utang dan Modal', 'Kas, Piutang, dan Beban', 'Utang Usaha dan Penjualan']],
                ['t' => 'sedang', 'q' => 'Koperasi berasaskan kekeluargaan dan bertujuan untuk menyejahterakan anggota pada khususnya dan masyarakat pada umumnya.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Bursa Efek Indonesia (BEI) adalah pasar modal resmi tempat diperdagangkannya instrumen keuangan seperti saham dan obligasi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Pengangguran yang terjadi karena seseorang berhenti bekerja untuk mencari pekerjaan yang lebih baik disebut pengangguran...', 'ans' => 'Friksional', 'opts' => ['Struktural', 'Friksional', 'Siklikal', 'Musiman']],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Kurva indiferensi (indifference curve) memiliki kemiringan negatif dan cembung ke arah titik asal (origin).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Laba maksimum pada pasar persaingan sempurna dicapai pada saat...', 'ans' => 'Penerimaan marjinal sama dengan biaya marjinal (MR = MC)', 'opts' => ['Biaya rata-rata minimum (AC min)', 'Penerimaan marjinal sama dengan biaya marjinal (MR = MC)', 'Penerimaan total maksimum (TR max)', 'Biaya total minimum (TC min)']],
                ['t' => 'sulit', 'q' => 'Hukum Hasil Lebih yang Berkurang (The Law of Diminishing Returns) dikemukakan oleh David Ricardo.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Koefisien Gini bernilai antara 0 sampai 1 dan digunakan untuk mengukur tingkat ketimpangan distribusi pendapatan masyarakat.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Angka Pengganda (Multiplier) investasi dirumuskan dengan k = 1 / (1 - MPC) atau k = 1 / MPS.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Jurnal penyesuaian (adjusting entries) dibuat pada akhir periode akuntansi untuk mencocokkan saldo akun dengan kondisi riil.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Jurnal penutup (closing entries) dibuat untuk menutup seluruh akun nominal (pendapatan, beban, dan prive) menjadi bersaldo nol.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Dalam perdagangan internasional, teori keunggulan komparatif dicetuskan oleh David Ricardo.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Kebijakan kuota impor adalah pembatasan jumlah fisik barang yang boleh diimpor masuk ke dalam negeri.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Otoritas Jasa Keuangan (OJK) bertugas mengatur dan mengawasi seluruh kegiatan di sektor jasa keuangan perbankan dan pasar modal.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 15: GEOGRAFI SMA (id_mapel = 15)
            // -------------------------------------------------------------------------
            15 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Prinsip-prinsip dasar geografi meliputi prinsip distribusi, interelasi, deskripsi, dan korologi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Lapisan batuan padat yang membentuk kerak bumi disebut...', 'ans' => 'Litosfer', 'opts' => ['Atmosfer', 'Litosfer', 'Hidrosfer', 'Biosfer']],
                ['t' => 'mudah', 'q' => 'Lapisan perairan di bumi meliputi samudera, laut, sungai, danau, dan air tanah disebut...', 'ans' => 'Hidrosfer', 'opts' => ['Litosfer', 'Atmosfer', 'Hidrosfer', 'Antroposfer']],
                ['t' => 'mudah', 'q' => 'Kompas dan peta selalu menggunakan arah utara sebagai orientasi arah atas standar.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Skala peta 1 : 100.000 berarti 1 cm pada peta mewakili jarak sebenarnya sejauh...', 'ans' => '1 km', 'opts' => ['100 meter', '1 km', '10 km', '100 km']],
                ['t' => 'mudah', 'q' => 'Alat perekam data permukaan bumi pada penginderaan jauh yang terpasang pada satelit atau pesawat disebut...', 'ans' => 'Sensor', 'opts' => ['Sensor', 'Wahana', 'Citra', 'Piksel']],
                ['t' => 'mudah', 'q' => 'Siklus hidrologi adalah perputaran air yang terus menerus dari bumi ke atmosfer dan kembali ke bumi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Inti bumi bagian dalam tersusun atas unsur nikel dan besi padat dengan suhu sangat tinggi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Letusan gunung berapi yang mengeluarkan magma ke permukaan bumi disebut peristiwa vulkanisme.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Titik pusat gempa bumi yang berada di dalam kerak bumi disebut hiposentrum.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Titik di permukaan bumi yang berada tepat tegak lurus di atas hiposentrum gempa disebut...', 'ans' => 'Episentrum', 'opts' => ['Pletoseista', 'Episentrum', 'Homoseista', 'Isoseista']],
                ['t' => 'sedang', 'q' => 'Batas pertemuan dua lempeng tektonik yang saling bertumbukan atau mendekat disebut batas...', 'ans' => 'Konvergen', 'opts' => ['Divergen', 'Konvergen', 'Transform (Sesar)', 'Pasif']],
                ['t' => 'sedang', 'q' => 'Batas lempeng yang saling bergerak menjauh sehingga membentuk punggungan tengah samudera disebut batas...', 'ans' => 'Divergen', 'opts' => ['Divergen', 'Konvergen', 'Subduksi', 'Obduksi']],
                ['t' => 'sedang', 'q' => 'Teori Pengapungan Benua (Continental Drift) pertama kali dicetuskan pada tahun 1912 oleh...', 'ans' => 'Alfred Wegener', 'opts' => ['Harry Hess', 'Alfred Wegener', 'James Hutton', 'Arthur Holmes']],
                ['t' => 'sedang', 'q' => 'Klasifikasi iklim Koppen membagi iklim berdasarkan rata-rata suhu udara dan curah hujan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Zona laut berdasarkan kedalamannya antara 0 hingga 200 meter di mana cahaya matahari masih tembus adalah zona...', 'ans' => 'Neritik', 'opts' => ['Litoral', 'Neritik', 'Batial', 'Abisal']],
                ['t' => 'sedang', 'q' => 'Sistem Informasi Geografis (SIG) memproses data spasial dan data atribut untuk analisis keruangan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Pola aliran sungai yang membentuk percabangan menyerupai ranting pohon pada batuan homogen adalah pola...', 'ans' => 'Dendritik', 'opts' => ['Trellis', 'Dendritik', 'Radial sentrifugal', 'Rectangular']],
                ['t' => 'sedang', 'q' => 'Fenomena El Nino menyebabkan penurunan curah hujan drastis dan kekeringan panjang di wilayah Indonesia.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Angin muson barat yang bertiup dari benua Asia menuju Australia melewati samudera luas membawa musim hujan di Indonesia.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Proyeksi peta silinder konformal yang mempertahankan bentuk sudut dan arah dengan akurat untuk navigasi pelayaran adalah...', 'ans' => 'Proyeksi Mercator', 'opts' => ['Proyeksi Azimutal', 'Proyeksi Mercator', 'Proyeksi Kerucut', 'Proyeksi Mollweide']],
                ['t' => 'sulit', 'q' => 'Teori Tempat Sentral (Central Place Theory) dengan hierarki heksagonal dikemukakan oleh Walter Christaller.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Hukum Gravitasi Keruangan (Model Gravitasi) untuk mengukur kekuatan interaksi antar dua kota dirumuskan oleh...', 'ans' => 'W.J. Reilly', 'opts' => ['David Ricardo', 'W.J. Reilly', 'E.W. Burgess', 'Homer Hoyt']],
                ['t' => 'sulit', 'q' => 'Teori Konsentris struktur kota yang menyatakan kota berkembang melingkar dari pusat kegiatan bisnis (CBD) dikemukakan oleh...', 'ans' => 'Ernest W. Burgess', 'opts' => ['Homer Hoyt', 'Ernest W. Burgess', 'Harris dan Ullman', 'Von Thunen']],
                ['t' => 'sulit', 'q' => 'Indeks Titik Henti (Breaking Point Theory) digunakan untuk menentukan batas wilayah pengaruh perdagangan antar dua kota.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Tanah Andosol merupakan tanah subur berwarna gelap yang berasal dari abu vulkanik letusan gunung berapi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Arus laut Kuroshio di Samudra Pasifik utara merupakan arus laut hangat yang mengalir ke arah utara kepulauan Jepang.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Segitiga Terumbu Karang Dunia (Coral Triangle) di mana Indonesia menjadi pusatnya memiliki keanekaragaman hayati laut tertinggi di dunia.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Bonus demografi adalah kondisi di mana proporsi penduduk usia produktif (15-64 tahun) lebih besar dibandingkan usia non-produktif.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Bentuk bentang alam hasil erosi dan pelarutan batuan kapur (gamping) oleh air tanah disebut morfologi Karst.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],

            // -------------------------------------------------------------------------
            // MAPEL 16: SOSIOLOGI SMA (id_mapel = 16)
            // -------------------------------------------------------------------------
            16 => [
                // 10 MUDAH
                ['t' => 'mudah', 'q' => 'Tokoh asal Prancis yang pertama kali mencetuskan istilah "Sosiologi" dan dijuluki Bapak Sosiologi adalah...', 'ans' => 'Auguste Comte', 'opts' => ['Karl Marx', 'Auguste Comte', 'Max Weber', 'Emile Durkheim']],
                ['t' => 'mudah', 'q' => 'Objek kajian utama ilmu sosiologi adalah masyarakat dan hubungan antarmanusia.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Ciri sosiologi sebagai ilmu pengetahuan adalah empiris, teoritis, kumulatif, dan non-etis.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Sifat non-etis dalam sosiologi berarti sosiologi tidak menilai baik atau buruknya suatu fakta sosial, melainkan menjelaskannya secara ilmiah.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Kontak sosial dan komunikasi merupakan dua syarat mutlak terjadinya interaksi sosial.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Nilai sosial adalah anggapan masyarakat mengenai apa yang dianggap baik, benar, dan berharga.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Norma sosial adalah aturan atau pedoman tingkah laku yang disertai sanksi di dalam masyarakat.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Tingkatan norma sosial dari yang paling lemah sanksinya ke yang paling kuat adalah cara (usage), kebiasaan (folkways), tata kelakuan (mores), dan adat istiadat (customs).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Proses belajar seorang individu mengenai nilai dan norma sosial agar dapat hidup dalam masyarakat disebut sosialisasi.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'mudah', 'q' => 'Penyimpangan sosial (perilaku menyimpang) adalah perilaku yang tidak sesuai dengan nilai dan norma yang berlaku dalam masyarakat.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SEDANG
                ['t' => 'sedang', 'q' => 'Konsep Solidaritas Mekanik dan Solidaritas Organik dalam masyarakat dikemukakan oleh...', 'ans' => 'Emile Durkheim', 'opts' => ['Max Weber', 'Emile Durkheim', 'Karl Marx', 'Herbert Spencer']],
                ['t' => 'sedang', 'q' => 'Solidaritas organik dicirikan oleh pembagian kerja yang kompleks pada masyarakat perkotaan modern.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Pelapisan sosial masyarakat secara hierarkis atau bertingkat disebut...', 'ans' => 'Stratifikasi sosial', 'opts' => ['Diferensiasi sosial', 'Stratifikasi sosial', 'Mobilitas sosial', 'Integrasi sosial']],
                ['t' => 'sedang', 'q' => 'Pembedaan masyarakat secara horizontal berdasarkan suku, ras, agama, atau jenis kelamin tanpa tingkatan disebut...', 'ans' => 'Diferensiasi sosial', 'opts' => ['Stratifikasi sosial', 'Diferensiasi sosial', 'Marginalisasi', 'Asimilasi']],
                ['t' => 'sedang', 'q' => 'Sistem kasta di Bali atau India merupakan contoh dari stratifikasi sosial tertutup.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Konflik sosial menurut Karl Marx bersumber dari pertentangan kelas antara kaum borjuis (pemilik modal) dan kaum...', 'ans' => 'Proletar (kaum buruh)', 'opts' => ['Bangsawan', 'Proletar (kaum buruh)', 'Petani tradisional', 'Intelektual']],
                ['t' => 'sedang', 'q' => 'Akomodasi adalah proses penyelesaian konflik atau perselisihan antara pihak-pihak yang bertikai.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sedang', 'q' => 'Penyelesaian konflik melalui bantuan pihak ketiga yang berwenang mengambil keputusan mengikat disebut...', 'ans' => 'Arbitrase', 'opts' => ['Mediasi', 'Arbitrase', 'Konsiliasi', 'Kompromi']],
                ['t' => 'sedang', 'q' => 'Jika pihak ketiga hanya bertindak sebagai penasihat netral tanpa hak memutuskan, bentuk akomodasi tersebut adalah...', 'ans' => 'Mediasi', 'opts' => ['Arbitrase', 'Mediasi', 'Ajudikasi', 'Koersi']],
                ['t' => 'sedang', 'q' => 'Tindakan sosial menurut Max Weber mencakup tindakan rasional instrumental, berorientasi nilai, afektif, dan tradisional.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],

                // 10 SULIT
                ['t' => 'sulit', 'q' => 'Ferdinand Tonnies membagi kelompok sosial menjadi Paguyuban (Gemeinschaft) dan Patembayan (Gesellschaft).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Ciri paguyuban (Gemeinschaft) adalah ikatan batin yang mendalam, alami, dan kekal seperti ikatan keluarga.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Teori Pelabelan (Labeling Theory) yang menjelaskan bahwa penyimpangan timbul karena cap negatif dari masyarakat dikemukakan oleh...', 'ans' => 'Edwin M. Lemert', 'opts' => ['Robert K. Merton', 'Edwin M. Lemert', 'Cesare Lombroso', 'Howard Becker']],
                ['t' => 'sulit', 'q' => 'Teori Anomi menurut Robert K. Merton terjadi karena ketidakharmonisan antara tujuan budaya dan cara yang sah untuk mencapainya.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Status sosial yang diperoleh seseorang sejak lahir tanpa usaha pribadi disebut ascribed status.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Status sosial yang diperoleh seseorang melalui usaha dan prestasi kerja keras disebut achieved status.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Metode penelitian sosiologi yang menggunakan data angka dan analisis statistik disebut metode kuantitatif.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Sikap etnosentrisme adalah kecenderungan menilai budaya kelompok lain berdasarkan standar budayanya sendiri dan menganggap budayanya paling unggul.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Primordialisme adalah ikatan loyalitas yang kuat terhadap hal-hal yang dibawa sejak lahir seperti kesukuan, kedaerahan, atau keagamaan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
                ['t' => 'sulit', 'q' => 'Globalisasi memicu terbentuknya masyarakat multikultural yang menuntut integrasi sosial berdasarkan kesetaraan hak.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ],
        ];
    }
}

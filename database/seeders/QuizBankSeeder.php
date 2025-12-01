<?php

namespace Database\Seeders;

use App\Models\QuizBank;
use App\Models\QuizQuestion;
use App\Models\Program;
use Illuminate\Database\Seeder;

class QuizBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get programs by slug
        $ukomReguler = Program::where('slug', 'bimbel-ukom-d3-farmasi')->first();
        $ukomIntensif = Program::where('slug', 'bimbel-ukom-intensif')->first();
        $ukomExpress = Program::where('slug', 'bimbel-ukom-express')->first();
        $cpnsLengkap = Program::where('slug', 'cpns-p3k-farmasi')->first();
        $cpnsSKD = Program::where('slug', 'cpns-p3k-skd')->first();
        $cpnsSKB = Program::where('slug', 'cpns-p3k-skb')->first();

        // ========== BANK SOAL UKOM - FARMAKOLOGI ==========
        $bankFarmakologi = QuizBank::create([
            'program_id' => $ukomReguler->id,
            'title' => 'Latihan Farmakologi UKOM - Dasar',
            'description' => 'Bank soal farmakologi dasar untuk persiapan UKOM D3 Farmasi mencakup mekanisme kerja obat, farmakokinetik, dan farmakodinamik.',
            'category' => 'Farmakologi',
            'duration_minutes' => 60,
            'passing_score' => 70,
        ]);

        // Soal Farmakologi
        $farmakoQuestions = [
            [
                'question' => 'Obat antihipertensi golongan ACE Inhibitor yang paling sering digunakan adalah?',
                'option_a' => 'Amlodipin',
                'option_b' => 'Captopril',
                'option_c' => 'Furosemid',
                'option_d' => 'Propranolol',
                'option_e' => 'Valsartan',
                'correct_answer' => 'B',
                'explanation' => 'Captopril adalah obat golongan ACE Inhibitor yang bekerja dengan menghambat enzim pengubah angiotensin, sehingga menurunkan tekanan darah.',
            ],
            [
                'question' => 'Mekanisme kerja obat Paracetamol sebagai analgetik-antipiretik adalah?',
                'option_a' => 'Menghambat COX-1 perifer',
                'option_b' => 'Menghambat COX-2 sentral',
                'option_c' => 'Meningkatkan produksi prostaglandin',
                'option_d' => 'Menghambat reseptor opioid',
                'option_e' => 'Meningkatkan metabolisme hati',
                'correct_answer' => 'B',
                'explanation' => 'Paracetamol bekerja dengan menghambat COX-2 di sistem saraf pusat (sentral), mengurangi produksi prostaglandin yang menyebabkan demam dan nyeri.',
            ],
            [
                'question' => 'Antibiotik yang bekerja dengan menghambat sintesis dinding sel bakteri adalah?',
                'option_a' => 'Tetrasiklin',
                'option_b' => 'Amoksisilin',
                'option_c' => 'Kloramfenikol',
                'option_d' => 'Ciprofloxacin',
                'option_e' => 'Eritromisin',
                'correct_answer' => 'B',
                'explanation' => 'Amoksisilin adalah antibiotik golongan penisilin yang bekerja dengan menghambat sintesis peptidoglikan pada dinding sel bakteri.',
            ],
            [
                'question' => 'Efek samping yang paling sering terjadi pada penggunaan NSAID (Obat Anti Inflamasi Non-Steroid) adalah?',
                'option_a' => 'Gangguan penglihatan',
                'option_b' => 'Gangguan pendengaran',
                'option_c' => 'Gangguan saluran cerna',
                'option_d' => 'Gangguan pernapasan',
                'option_e' => 'Gangguan kulit',
                'correct_answer' => 'C',
                'explanation' => 'NSAID dapat mengiritasi lambung karena menghambat prostaglandin yang berfungsi melindungi mukosa lambung, sehingga menyebabkan gastritis atau tukak lambung.',
            ],
            [
                'question' => 'Antidiabetik oral yang bekerja dengan meningkatkan sensitivitas insulin adalah?',
                'option_a' => 'Glibenklamid',
                'option_b' => 'Metformin',
                'option_c' => 'Acarbose',
                'option_d' => 'Insulin',
                'option_e' => 'Glimepirid',
                'correct_answer' => 'B',
                'explanation' => 'Metformin adalah obat golongan biguanid yang bekerja dengan meningkatkan sensitivitas sel terhadap insulin dan mengurangi produksi glukosa di hati.',
            ],
        ];

        foreach ($farmakoQuestions as $q) {
            QuizQuestion::create(array_merge($q, ['quiz_bank_id' => $bankFarmakologi->id]));
        }

        // ========== BANK SOAL UKOM - FARMASI KLINIK ==========
        $bankKlinik = QuizBank::create([
            'program_id' => $ukomIntensif->id,
            'title' => 'Latihan Farmasi Klinik UKOM',
            'description' => 'Bank soal farmasi klinik mencakup pelayanan informasi obat, monitoring terapi, dan konseling pasien.',
            'category' => 'Farmasi Klinik',
            'duration_minutes' => 90,
            'passing_score' => 75,
        ]);

        $klinikQuestions = [
            [
                'question' => 'Seorang pasien mendapat resep Warfarin. Makanan yang harus dihindari karena dapat mengurangi efektivitas obat adalah?',
                'option_a' => 'Daging merah',
                'option_b' => 'Sayuran hijau (bayam, brokoli)',
                'option_c' => 'Buah jeruk',
                'option_d' => 'Ikan salmon',
                'option_e' => 'Susu',
                'correct_answer' => 'B',
                'explanation' => 'Sayuran hijau mengandung vitamin K yang tinggi. Vitamin K adalah antidot dari Warfarin, sehingga konsumsi berlebihan dapat mengurangi efek antikoagulan.',
            ],
            [
                'question' => 'Waktu yang tepat untuk mengkonsumsi obat Omeprazol adalah?',
                'option_a' => 'Sesudah makan pagi',
                'option_b' => 'Sebelum tidur',
                'option_c' => '30 menit sebelum makan pagi',
                'option_d' => 'Saat makan',
                'option_e' => 'Kapan saja',
                'correct_answer' => 'C',
                'explanation' => 'Omeprazol sebaiknya diminum 30 menit sebelum makan pagi karena obat ini bekerja lebih optimal saat lambung kosong dan sebelum produksi asam lambung meningkat.',
            ],
            [
                'question' => 'Parameter laboratorium yang harus dimonitor pada pasien yang menggunakan Gentamisin adalah?',
                'option_a' => 'Fungsi hati (SGOT/SGPT)',
                'option_b' => 'Fungsi ginjal (Kreatinin)',
                'option_c' => 'Kadar gula darah',
                'option_d' => 'Kadar kolesterol',
                'option_e' => 'Kadar asam urat',
                'correct_answer' => 'B',
                'explanation' => 'Gentamisin adalah antibiotik aminoglikosida yang bersifat nefrotoksik (merusak ginjal). Monitoring kreatinin serum penting untuk mendeteksi gangguan fungsi ginjal.',
            ],
            [
                'question' => 'Interaksi obat yang terjadi antara Ciprofloxacin dengan antasida adalah?',
                'option_a' => 'Peningkatan efek samping',
                'option_b' => 'Penurunan absorpsi Ciprofloxacin',
                'option_c' => 'Peningkatan toksisitas',
                'option_d' => 'Tidak ada interaksi',
                'option_e' => 'Peningkatan efek antasida',
                'correct_answer' => 'B',
                'explanation' => 'Antasida yang mengandung kalsium, magnesium, atau aluminium dapat membentuk kompleks dengan Ciprofloxacin, mengurangi penyerapannya di saluran cerna.',
            ],
            [
                'question' => 'Konseling yang tepat untuk pasien yang mendapat terapi Antibiotik adalah?',
                'option_a' => 'Hentikan jika sudah merasa sembuh',
                'option_b' => 'Simpan sisanya untuk digunakan lain waktu',
                'option_c' => 'Habiskan sesuai resep dokter',
                'option_d' => 'Boleh berbagi dengan keluarga yang sakit',
                'option_e' => 'Minum hanya saat merasa sakit',
                'correct_answer' => 'C',
                'explanation' => 'Antibiotik harus dihabiskan sesuai resep dokter untuk mencegah resistensi bakteri, meskipun gejala sudah membaik sebelum obat habis.',
            ],
        ];

        foreach ($klinikQuestions as $q) {
            QuizQuestion::create(array_merge($q, ['quiz_bank_id' => $bankKlinik->id]));
        }

        // ========== BANK SOAL UKOM - FARMASETIKA ==========
        $bankFarmasetika = QuizBank::create([
            'program_id' => $ukomExpress->id,
            'title' => 'Latihan Farmasetika & Formulasi',
            'description' => 'Bank soal farmasetika mencakup pembuatan sediaan obat, teknologi farmasi, dan formulasi.',
            'category' => 'Farmasetika',
            'duration_minutes' => 75,
            'passing_score' => 70,
        ]);

        $farmasetikaQuestions = [
            [
                'question' => 'Bahan tambahan yang berfungsi sebagai pengikat dalam tablet adalah?',
                'option_a' => 'Talkum',
                'option_b' => 'Magnesium stearat',
                'option_c' => 'PVP (Polivinilpirolidon)',
                'option_d' => 'Asam stearat',
                'option_e' => 'Aerosil',
                'correct_answer' => 'C',
                'explanation' => 'PVP (Polivinilpirolidon) berfungsi sebagai bahan pengikat (binder) yang merekatkan partikel-partikel dalam granul tablet.',
            ],
            [
                'question' => 'Metode sterilisasi yang paling tepat untuk larutan injeksi yang tidak tahan panas adalah?',
                'option_a' => 'Autoklaf',
                'option_b' => 'Oven panas kering',
                'option_c' => 'Filtrasi steril',
                'option_d' => 'Radiasi gamma',
                'option_e' => 'Uap air panas',
                'correct_answer' => 'C',
                'explanation' => 'Filtrasi steril menggunakan membran filter 0.22 μm adalah metode sterilisasi yang tepat untuk sediaan yang tidak tahan panas (termolabil).',
            ],
            [
                'question' => 'Tujuan penambahan surfaktan dalam sediaan emulsi adalah?',
                'option_a' => 'Meningkatkan viskositas',
                'option_b' => 'Menurunkan tegangan permukaan',
                'option_c' => 'Meningkatkan kelarutan',
                'option_d' => 'Mempercepat absorpsi',
                'option_e' => 'Meningkatkan stabilitas kimia',
                'correct_answer' => 'B',
                'explanation' => 'Surfaktan (surface active agent) berfungsi menurunkan tegangan permukaan antara fase minyak dan air, membantu pembentukan dan stabilitas emulsi.',
            ],
            [
                'question' => 'Bentuk sediaan yang paling cepat memberikan efek sistemik adalah?',
                'option_a' => 'Tablet salut enterik',
                'option_b' => 'Kapsul',
                'option_c' => 'Larutan oral',
                'option_d' => 'Injeksi intravena',
                'option_e' => 'Supositoria',
                'correct_answer' => 'D',
                'explanation' => 'Injeksi intravena (IV) langsung masuk ke pembuluh darah, memberikan efek paling cepat karena tidak melalui proses absorpsi.',
            ],
            [
                'question' => 'Pengawet yang umum digunakan dalam sediaan sirup adalah?',
                'option_a' => 'Benzalkonium klorida',
                'option_b' => 'Metil paraben',
                'option_c' => 'Fenol',
                'option_d' => 'Kloroform',
                'option_e' => 'Etanol 96%',
                'correct_answer' => 'B',
                'explanation' => 'Metil paraben adalah pengawet yang efektif untuk sediaan cair seperti sirup, mencegah pertumbuhan mikroba dan jamur.',
            ],
        ];

        foreach ($farmasetikaQuestions as $q) {
            QuizQuestion::create(array_merge($q, ['quiz_bank_id' => $bankFarmasetika->id]));
        }

        // ========== BANK SOAL CPNS - KIMIA FARMASI ==========
        $bankKimia = QuizBank::create([
            'program_id' => $cpnsLengkap->id,
            'title' => 'Latihan Kimia Farmasi untuk CPNS',
            'description' => 'Bank soal kimia farmasi mencakup kimia organik, analisis obat, dan identifikasi senyawa.',
            'category' => 'Kimia Farmasi',
            'duration_minutes' => 60,
            'passing_score' => 65,
        ]);

        $kimiaQuestions = [
            [
                'question' => 'Gugus fungsi yang terdapat pada Aspirin adalah?',
                'option_a' => 'Ester dan Fenol',
                'option_b' => 'Ester dan Karboksilat',
                'option_c' => 'Keton dan Alkohol',
                'option_d' => 'Amina dan Karboksilat',
                'option_e' => 'Eter dan Fenol',
                'correct_answer' => 'B',
                'explanation' => 'Aspirin (Asam Asetilsalisilat) memiliki gugus ester (-OCOCH3) dan gugus karboksilat (-COOH) dalam strukturnya.',
            ],
            [
                'question' => 'Metode analisis yang digunakan untuk identifikasi golongan alkaloid adalah?',
                'option_a' => 'Pereaksi Fehling',
                'option_b' => 'Pereaksi Molisch',
                'option_c' => 'Pereaksi Dragendorff',
                'option_d' => 'Pereaksi Benedict',
                'option_e' => 'Pereaksi Tollens',
                'correct_answer' => 'C',
                'explanation' => 'Pereaksi Dragendorff menghasilkan endapan jingga-coklat yang khas untuk identifikasi senyawa alkaloid.',
            ],
            [
                'question' => 'pH optimum untuk penyerapan obat yang bersifat asam lemah di lambung adalah?',
                'option_a' => 'pH 1-2',
                'option_b' => 'pH 7',
                'option_c' => 'pH 8-9',
                'option_d' => 'pH 10',
                'option_e' => 'pH netral',
                'correct_answer' => 'A',
                'explanation' => 'Obat asam lemah lebih mudah diserap dalam bentuk tidak terion pada pH asam (pH 1-2) di lambung sesuai prinsip Henderson-Hasselbalch.',
            ],
            [
                'question' => 'Teknik pemisahan yang paling tepat untuk isolasi senyawa volatil dari bahan alam adalah?',
                'option_a' => 'Kristalisasi',
                'option_b' => 'Destilasi uap',
                'option_c' => 'Ekstraksi cair-cair',
                'option_d' => 'Sublimasi',
                'option_e' => 'Kromatografi kolom',
                'correct_answer' => 'B',
                'explanation' => 'Destilasi uap (steam distillation) efektif untuk memisahkan senyawa volatil seperti minyak atsiri dari bahan alam.',
            ],
            [
                'question' => 'Reaksi kimia yang terjadi pada penetapan kadar Iodium dengan metode Iodometri adalah?',
                'option_a' => 'Reaksi pengendapan',
                'option_b' => 'Reaksi oksidasi-reduksi',
                'option_c' => 'Reaksi netralisasi',
                'option_d' => 'Reaksi kompleksometri',
                'option_e' => 'Reaksi substitusi',
                'correct_answer' => 'B',
                'explanation' => 'Iodometri adalah metode titrasi redoks yang melibatkan reaksi oksidasi-reduksi dengan menggunakan iodium sebagai oksidator.',
            ],
        ];

        foreach ($kimiaQuestions as $q) {
            QuizQuestion::create(array_merge($q, ['quiz_bank_id' => $bankKimia->id]));
        }

        // ========== BANK SOAL CPNS - SKD (TIU, TWK, TKP) ==========
        $bankSKD = QuizBank::create([
            'program_id' => $cpnsSKD->id,
            'title' => 'Latihan SKD - Tes Intelegensi Umum',
            'description' => 'Bank soal SKD CPNS mencakup Tes Intelegensi Umum (TIU), Tes Wawasan Kebangsaan, dan Tes Karakteristik Pribadi.',
            'category' => 'CPNS',
            'duration_minutes' => 100,
            'passing_score' => 80,
        ]);

        $skdQuestions = [
            [
                'question' => 'Jika semua A adalah B, dan semua B adalah C, maka dapat disimpulkan bahwa?',
                'option_a' => 'Semua C adalah A',
                'option_b' => 'Semua A adalah C',
                'option_c' => 'Beberapa A adalah C',
                'option_d' => 'Tidak ada A yang C',
                'option_e' => 'Beberapa C bukan A',
                'correct_answer' => 'B',
                'explanation' => 'Menggunakan silogisme: jika A⊆B dan B⊆C, maka A⊆C (Semua A adalah C).',
            ],
            [
                'question' => 'Pancasila sebagai dasar negara Indonesia tercantum dalam?',
                'option_a' => 'Pembukaan UUD 1945 Alinea 1',
                'option_b' => 'Pembukaan UUD 1945 Alinea 2',
                'option_c' => 'Pembukaan UUD 1945 Alinea 3',
                'option_d' => 'Pembukaan UUD 1945 Alinea 4',
                'option_e' => 'Pasal 1 UUD 1945',
                'correct_answer' => 'D',
                'explanation' => 'Pancasila sebagai dasar negara tercantum dalam Pembukaan UUD 1945 Alinea Keempat.',
            ],
            [
                'question' => 'Dalam menghadapi konflik dengan rekan kerja, sikap yang paling tepat adalah?',
                'option_a' => 'Mengabaikan konflik tersebut',
                'option_b' => 'Membalas dengan sikap yang sama',
                'option_c' => 'Melaporkan kepada atasan',
                'option_d' => 'Mencari solusi bersama secara komunikatif',
                'option_e' => 'Menghindar dari rekan tersebut',
                'correct_answer' => 'D',
                'explanation' => 'Sikap profesional adalah menyelesaikan konflik dengan komunikasi yang baik dan mencari solusi win-win.',
            ],
            [
                'question' => '15, 18, 22, 27, 33, ..., ... Angka yang tepat untuk melengkapi deret tersebut adalah?',
                'option_a' => '38, 44',
                'option_b' => '39, 45',
                'option_c' => '40, 48',
                'option_d' => '41, 50',
                'option_e' => '40, 47',
                'correct_answer' => 'C',
                'explanation' => 'Pola: +3, +4, +5, +6, +7, +8. Maka 33+7=40, 40+8=48.',
            ],
            [
                'question' => 'Nilai-nilai Pancasila yang tercermin dalam kehidupan berbangsa dan bernegara adalah?',
                'option_a' => 'Individualisme',
                'option_b' => 'Liberalisme',
                'option_c' => 'Gotong royong dan musyawarah',
                'option_d' => 'Kapitalisme',
                'option_e' => 'Materialisme',
                'correct_answer' => 'C',
                'explanation' => 'Gotong royong dan musyawarah merupakan nilai-nilai Pancasila sila ke-4 yang menjadi pedoman kehidupan berbangsa.',
            ],
        ];

        foreach ($skdQuestions as $q) {
            QuizQuestion::create(array_merge($q, ['quiz_bank_id' => $bankSKD->id]));
        }

        // ========== BANK SOAL CPNS - SKB FARMASI ==========
        $bankSKB = QuizBank::create([
            'program_id' => $cpnsSKB->id,
            'title' => 'Latihan SKB Farmasi - Soal Teknis',
            'description' => 'Bank soal SKB (Seleksi Kompetensi Bidang) Farmasi untuk CPNS mencakup pengetahuan teknis kefarmasian.',
            'category' => 'CPNS',
            'duration_minutes' => 90,
            'passing_score' => 75,
        ]);

        $skbQuestions = [
            [
                'question' => 'Tugas dan fungsi Apoteker di Puskesmas sesuai Permenkes adalah?',
                'option_a' => 'Hanya meracik obat',
                'option_b' => 'Pelayanan kefarmasian dan manajemen obat',
                'option_c' => 'Menjual obat bebas',
                'option_d' => 'Administrasi keuangan',
                'option_e' => 'Membuat kebijakan kesehatan',
                'correct_answer' => 'B',
                'explanation' => 'Apoteker di Puskesmas bertugas melakukan pelayanan kefarmasian (farmasi klinik dan manajemen) serta manajemen obat dan BMHP.',
            ],
            [
                'question' => 'Obat golongan Narkotika harus disimpan dalam lemari khusus dengan syarat?',
                'option_a' => 'Lemari biasa',
                'option_b' => 'Lemari berkunci satu',
                'option_c' => 'Lemari berkunci dua dan terpisah',
                'option_d' => 'Kulkas',
                'option_e' => 'Brankas bank',
                'correct_answer' => 'C',
                'explanation' => 'Sesuai Permenkes, Narkotika harus disimpan dalam lemari khusus berkunci ganda dan terpisah dari obat lain.',
            ],
            [
                'question' => 'Metode distribusi obat di rumah sakit yang paling menjamin keamanan pasien adalah?',
                'option_a' => 'Floor stock',
                'option_b' => 'Individual prescription',
                'option_c' => 'Unit dose dispensing',
                'option_d' => 'Automatic dispensing',
                'option_e' => 'Ward stock',
                'correct_answer' => 'C',
                'explanation' => 'Unit Dose Dispensing System (UDD) adalah sistem distribusi dosis unit yang paling aman karena meminimalkan medication error.',
            ],
            [
                'question' => 'Dalam pelaksanaan Keputusan Bersama WHO dan FIP, peran apoteker adalah?',
                'option_a' => 'Hanya menjual obat',
                'option_b' => 'Seven Star Pharmacist',
                'option_c' => 'Membuat obat tradisional',
                'option_d' => 'Riset laboratorium',
                'option_e' => 'Administrasi rumah sakit',
                'correct_answer' => 'B',
                'explanation' => 'WHO-FIP menetapkan peran apoteker sebagai Seven Star Pharmacist: Care-giver, Decision-maker, Communicator, Manager, Life-long-learner, Teacher, Leader.',
            ],
            [
                'question' => 'Pada resep racikan, singkatan "m.f. pulv. dtd No. X" artinya adalah?',
                'option_a' => 'Buat pulvis, berikan 10 bungkus',
                'option_b' => 'Buat tablet 10 buah',
                'option_c' => 'Buat kapsul 10 buah',
                'option_d' => 'Buat salep 10 gram',
                'option_e' => 'Buat puyer 10 kali',
                'correct_answer' => 'A',
                'explanation' => 'm.f. pulv. (misce fac pulvis) = campur buat serbuk, dtd (dentur tales doses) = berikan dosis seperti itu, No. X = sebanyak 10 bungkus.',
            ],
        ];

        foreach ($skbQuestions as $q) {
            QuizQuestion::create(array_merge($q, ['quiz_bank_id' => $bankSKB->id]));
        }

        // ========== BANK SOAL UKOM KOMPREHENSIF ==========
        $bankUKOM = QuizBank::create([
            'program_id' => $ukomReguler->id,
            'title' => 'Try Out UKOM D3 Farmasi - Komprehensif',
            'description' => 'Bank soal try out komprehensif UKOM D3 Farmasi mencakup semua materi: farmakologi, farmasetika, farmasi klinik, dan kimia farmasi.',
            'category' => 'UKOM',
            'duration_minutes' => 120,
            'passing_score' => 70,
        ]);

        $ukomQuestions = [
            [
                'question' => 'Seorang pasien diabetes melitus tipe 2 mendapat terapi Metformin 500 mg. Efek samping yang paling sering terjadi adalah?',
                'option_a' => 'Hipoglikemia berat',
                'option_b' => 'Gangguan pencernaan (mual, diare)',
                'option_c' => 'Peningkatan berat badan',
                'option_d' => 'Reaksi alergi kulit',
                'option_e' => 'Gangguan penglihatan',
                'correct_answer' => 'B',
                'explanation' => 'Metformin sering menyebabkan efek samping gastrointestinal seperti mual, muntah, dan diare terutama pada awal terapi. Dapat dikurangi dengan minum bersama makanan.',
            ],
            [
                'question' => 'Pasien anak usia 5 tahun dengan BB 20 kg mendapat resep Amoksisilin sirup 125 mg/5 mL. Dosis 50 mg/kgBB/hari dibagi 3 dosis. Berapa mL yang harus diberikan sekali minum?',
                'option_a' => '5 mL',
                'option_b' => '10 mL',
                'option_c' => '13.3 mL',
                'option_d' => '15 mL',
                'option_e' => '20 mL',
                'correct_answer' => 'C',
                'explanation' => 'Dosis total = 50 mg × 20 kg = 1000 mg/hari. Dosis sekali minum = 1000/3 = 333.3 mg. Dalam sirup: (333.3 mg / 125 mg) × 5 mL = 13.3 mL.',
            ],
            [
                'question' => 'Penyimpanan insulin yang benar adalah?',
                'option_a' => 'Freezer (-20°C)',
                'option_b' => 'Kulkas (2-8°C)',
                'option_c' => 'Suhu ruang (25-30°C)',
                'option_d' => 'Tempat gelap suhu ruang',
                'option_e' => 'Dipanaskan sebelum digunakan',
                'correct_answer' => 'B',
                'explanation' => 'Insulin yang belum dibuka harus disimpan di kulkas (2-8°C). Jangan dibekukan. Insulin yang sudah dibuka dapat disimpan di suhu ruang maksimal 28 hari.',
            ],
            [
                'question' => 'Obat yang dikontraindikasikan untuk ibu hamil trimester pertama adalah?',
                'option_a' => 'Paracetamol',
                'option_b' => 'Amoksisilin',
                'option_c' => 'Asam folat',
                'option_d' => 'Isotretinoin',
                'option_e' => 'Vitamin B complex',
                'correct_answer' => 'D',
                'explanation' => 'Isotretinoin (obat jerawat) tergolong kategori X untuk kehamilan, sangat teratogenik dan dapat menyebabkan cacat janin serius.',
            ],
            [
                'question' => 'Cara pemberian obat tetes mata yang benar adalah?',
                'option_a' => 'Teteskan di bagian putih mata',
                'option_b' => 'Teteskan di kantung konjungtiva bawah',
                'option_c' => 'Teteskan di kelopak mata atas',
                'option_d' => 'Teteskan di tengah kornea',
                'option_e' => 'Teteskan di sudut mata',
                'correct_answer' => 'B',
                'explanation' => 'Obat tetes mata diteteskan di kantung konjungtiva bawah (dengan menarik kelopak mata bawah) untuk absorpsi optimal dan menghindari iritasi kornea.',
            ],
        ];

        foreach ($ukomQuestions as $q) {
            QuizQuestion::create(array_merge($q, ['quiz_bank_id' => $bankUKOM->id]));
        }

        $this->command->info('✅ Bank soal berhasil dibuat untuk semua layanan!');
        $this->command->info('📊 Total: 7 Bank Soal dengan 35 Soal');
    }
}

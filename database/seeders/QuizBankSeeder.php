<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\QuizBank;
use App\Models\QuizQuestion;
use App\Models\Order;
use App\Models\User;

class QuizBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user yang sudah ada
        $users = User::where('is_admin', 0)->take(3)->get();
        
        if ($users->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada user biasa. Buat user dulu atau jalankan UserSeeder');
            return;
        }

        foreach ($users as $user) {
            // Cari order user ini atau buat order dummy
            $order = Order::where('user_id', $user->id)->first();
            
            if (!$order) {
                // Buat order dummy untuk demo
                $order = Order::create([
                    'order_number' => 'ORD-' . strtoupper(uniqid()),
                    'user_id' => $user->id,
                    'program_id' => 1,
                    'amount' => 500000,
                    'status' => 'completed',
                    'notes' => 'Order untuk demo quiz',
                ]);
            }

            // Bank Soal 1: Farmakologi
            $quiz1 = QuizBank::create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'title' => 'Ujian Farmakologi - UKOM D3 Farmasi',
                'description' => 'Bank soal farmakologi untuk persiapan UKOM D3 Farmasi',
                'category' => 'Farmakologi',
                'total_questions' => 10,
                'duration_minutes' => 30,
                'passing_score' => 70,
            ]);

            // Soal-soal Farmakologi
            $questions1 = [
                [
                    'question' => 'Seorang pasien wanita usia 45 tahun datang ke apotek dengan keluhan nyeri kepala hebat. Pasien memiliki riwayat tukak lambung. Obat analgetik yang paling tepat adalah?',
                    'option_a' => 'Aspirin',
                    'option_b' => 'Ibuprofen',
                    'option_c' => 'Paracetamol',
                    'option_d' => 'Asam mefenamat',
                    'option_e' => 'Natrium diklofenak',
                    'correct_answer' => 'C',
                    'explanation' => 'Paracetamol adalah analgetik pilihan untuk pasien dengan riwayat tukak lambung karena tidak bersifat iritatif terhadap lambung, berbeda dengan NSAID lainnya',
                ],
                [
                    'question' => 'Pasien TB mendapat terapi rifampisin, isoniazid, pirazinamid, dan etambutol. Vitamin yang perlu diberikan sebagai suplemen adalah?',
                    'option_a' => 'Vitamin A',
                    'option_b' => 'Vitamin B1 (Tiamin)',
                    'option_c' => 'Vitamin B6 (Piridoksin)',
                    'option_d' => 'Vitamin C',
                    'option_e' => 'Vitamin D',
                    'correct_answer' => 'C',
                    'explanation' => 'Isoniazid dapat menyebabkan defisiensi vitamin B6 yang mengakibatkan neuropati perifer, sehingga suplementasi piridoksin 10-25 mg/hari direkomendasikan',
                ],
                [
                    'question' => 'Antidotum untuk keracunan paracetamol adalah?',
                    'option_a' => 'Nalokson',
                    'option_b' => 'Flumazenil',
                    'option_c' => 'N-Asetilsistein',
                    'option_d' => 'Atropin',
                    'option_e' => 'Vitamin K',
                    'correct_answer' => 'C',
                    'explanation' => 'N-Asetilsistein (NAC) adalah antidotum spesifik untuk overdosis paracetamol dengan menggantikan glutathion yang habis dan mencegah kerusakan hati',
                ],
                [
                    'question' => 'Pasien hipertensi mendapat captopril. Efek samping yang perlu dimonitoring adalah?',
                    'option_a' => 'Batuk kering',
                    'option_b' => 'Hiperkalemia',
                    'option_c' => 'Angioedema',
                    'option_d' => 'Penurunan fungsi ginjal',
                    'option_e' => 'Semua benar',
                    'correct_answer' => 'E',
                    'explanation' => 'ACE inhibitor seperti captopril dapat menyebabkan batuk kering (10-20%), hiperkalemia, angioedema (jarang tapi serius), dan penurunan fungsi ginjal terutama pada stenosis arteri renal',
                ],
                [
                    'question' => 'Mekanisme kerja omeprazol dalam mengatasi GERD adalah?',
                    'option_a' => 'Menetralkan asam lambung',
                    'option_b' => 'Menghambat reseptor H2',
                    'option_c' => 'Menghambat pompa proton H+/K+ ATPase',
                    'option_d' => 'Melapisi mukosa lambung',
                    'option_e' => 'Meningkatkan motilitas lambung',
                    'correct_answer' => 'C',
                    'explanation' => 'Omeprazol adalah proton pump inhibitor (PPI) yang menghambat H+/K+ ATPase pada sel parietal lambung, mengurangi sekresi asam lambung hingga 90%',
                ],
                [
                    'question' => 'Pasien dengan atrial fibrilasi mendapat warfarin. Parameter laboratorium yang perlu dimonitor adalah?',
                    'option_a' => 'APTT',
                    'option_b' => 'INR',
                    'option_c' => 'Trombosit',
                    'option_d' => 'Fibrinogen',
                    'option_e' => 'D-Dimer',
                    'correct_answer' => 'B',
                    'explanation' => 'INR (International Normalized Ratio) adalah parameter untuk monitoring warfarin dengan target terapeutik 2-3 untuk atrial fibrilasi',
                ],
                [
                    'question' => 'Antibiotik yang harus diminum dalam keadaan perut kosong adalah?',
                    'option_a' => 'Amoksisilin',
                    'option_b' => 'Ampisilin',
                    'option_c' => 'Eritromisin',
                    'option_d' => 'Tetrasiklin',
                    'option_e' => 'Semua benar',
                    'correct_answer' => 'D',
                    'explanation' => 'Tetrasiklin harus diminum saat perut kosong karena absorpsinya berkurang bila diminum bersamaan dengan makanan, susu, atau antasida yang mengandung kalsium',
                ],
                [
                    'question' => 'Kontraindikasi pemberian metformin adalah?',
                    'option_a' => 'Gangguan fungsi ginjal berat (eGFR <30 mL/menit)',
                    'option_b' => 'Gagal jantung',
                    'option_c' => 'Penyakit hati berat',
                    'option_d' => 'Kondisi hipoksia',
                    'option_e' => 'Semua benar',
                    'correct_answer' => 'E',
                    'explanation' => 'Metformin dikontraindikasikan pada kondisi yang meningkatkan risiko asidosis laktat: gangguan ginjal berat, gagal jantung, penyakit hati berat, dan kondisi hipoksia',
                ],
                [
                    'question' => 'Pasien asma menggunakan salbutamol inhaler. Teknik penggunaan yang benar adalah?',
                    'option_a' => 'Hirup napas dalam sebelum menyemprotkan',
                    'option_b' => 'Semprotkan saat mulai menghirup napas perlahan',
                    'option_c' => 'Tahan napas 10 detik setelah inhalasi',
                    'option_d' => 'Bilas mulut setelah penggunaan',
                    'option_e' => 'B dan C benar',
                    'correct_answer' => 'E',
                    'explanation' => 'Teknik inhaler yang benar: semprotkan saat mulai inhalasi, hirup perlahan dan dalam, tahan napas 10 detik untuk deposisi optimal obat di saluran napas',
                ],
                [
                    'question' => 'Obat antikoagulan yang dapat diberikan secara oral tanpa monitoring ketat adalah?',
                    'option_a' => 'Warfarin',
                    'option_b' => 'Heparin',
                    'option_c' => 'Rivaroxaban',
                    'option_d' => 'Enoxaparin',
                    'option_e' => 'Fondaparinux',
                    'correct_answer' => 'C',
                    'explanation' => 'Rivaroxaban adalah NOAC (Novel Oral Anticoagulant) yang tidak memerlukan monitoring INR rutin seperti warfarin, dengan dosis tetap',
                ],
            ];

            foreach ($questions1 as $q) {
                QuizQuestion::create(array_merge(['quiz_bank_id' => $quiz1->id], $q));
            }

            // Bank Soal 2: Farmasi Klinik
            $quiz2 = QuizBank::create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'title' => 'Ujian Farmasi Klinik - UKOM D3 Farmasi',
                'description' => 'Bank soal farmasi klinik untuk persiapan UKOM D3 Farmasi',
                'category' => 'Farmasi Klinik',
                'total_questions' => 10,
                'duration_minutes' => 30,
                'passing_score' => 70,
            ]);

            $questions2 = [
                [
                    'question' => 'Seorang pasien diabetes tipe 2 mendapat metformin 500 mg 3x1. Pasien mengeluh mual dan diare. Apa rekomendasi yang tepat?',
                    'option_a' => 'Ganti dengan insulin',
                    'option_b' => 'Hentikan metformin',
                    'option_c' => 'Konsumsi metformin saat atau sesudah makan',
                    'option_d' => 'Tambahkan antidiare',
                    'option_e' => 'Kurangi dosis menjadi 1x sehari',
                    'correct_answer' => 'C',
                    'explanation' => 'Efek samping gastrointestinal metformin dapat diminimalkan dengan konsumsi saat atau sesudah makan, dan efek ini biasanya berkurang setelah 2-4 minggu',
                ],
                [
                    'question' => 'Pasien hipertensi dengan eGFR 25 mL/menit/1.73m2. Antihipertensi yang harus dihindari adalah?',
                    'option_a' => 'Amlodipine',
                    'option_b' => 'Bisoprolol',
                    'option_c' => 'Spironolakton',
                    'option_d' => 'Clonidine',
                    'option_e' => 'Hydralazine',
                    'correct_answer' => 'C',
                    'explanation' => 'Spironolakton harus dihindari pada gangguan ginjal berat (eGFR <30) karena risiko hiperkalemia yang mengancam jiwa',
                ],
                [
                    'question' => 'Monitoring yang diperlukan untuk pasien yang mendapat terapi simvastatin adalah?',
                    'option_a' => 'Fungsi hati (ALT/AST)',
                    'option_b' => 'Creatine kinase (CK)',
                    'option_c' => 'Profil lipid',
                    'option_d' => 'Gejala miopati',
                    'option_e' => 'Semua benar',
                    'correct_answer' => 'E',
                    'explanation' => 'Monitoring statin meliputi fungsi hati (baseline dan periodik), CK bila ada gejala miopati, profil lipid untuk evaluasi efektivitas, dan gejala nyeri otot',
                ],
                [
                    'question' => 'Pasien mendapat levofloxacin dan teofilin bersamaan. Interaksi yang mungkin terjadi adalah?',
                    'option_a' => 'Penurunan efek levofloxacin',
                    'option_b' => 'Peningkatan kadar teofilin dan risiko toksisitas',
                    'option_c' => 'Penurunan efek teofilin',
                    'option_d' => 'Tidak ada interaksi',
                    'option_e' => 'Peningkatan efek antibiotik',
                    'correct_answer' => 'B',
                    'explanation' => 'Fluoroquinolone menghambat metabolisme teofilin di hati, meningkatkan kadar teofilin dan risiko toksisitas (tremor, aritmia, kejang)',
                ],
                [
                    'question' => 'Pasien COVID-19 rawat jalan mendapat azithromycin. Edukasi yang penting adalah?',
                    'option_a' => 'Diminum 1 jam sebelum atau 2 jam sesudah makan',
                    'option_b' => 'Hindari paparan sinar matahari berlebihan',
                    'option_c' => 'Selesaikan seluruh dosis antibiotik',
                    'option_d' => 'Segera ke RS bila nyeri dada atau palpitasi',
                    'option_e' => 'C dan D benar',
                    'correct_answer' => 'E',
                    'explanation' => 'Azithromycin harus diminum sampai habis untuk mencegah resistensi, dan dapat menyebabkan perpanjangan QT sehingga pasien harus waspada terhadap gejala aritmia',
                ],
                [
                    'question' => 'Dosis loading digoxin untuk pasien gagal jantung akut adalah?',
                    'option_a' => '0.25 mg sekali sehari',
                    'option_b' => '0.5-1 mg dalam dosis terbagi 24 jam',
                    'option_c' => '2 mg bolus IV',
                    'option_d' => '0.125 mg sekali sehari',
                    'option_e' => 'Tidak perlu loading dose',
                    'correct_answer' => 'B',
                    'explanation' => 'Loading dose digoxin adalah 0.5-1 mg dibagi dalam 3-4 dosis selama 24 jam untuk mencapai kadar terapeutik dengan cepat, diikuti maintenance dose 0.125-0.25 mg/hari',
                ],
                [
                    'question' => 'Pasien asma persisten mendapat budesonide inhaler 2x sehari. Edukasi penting yang harus diberikan adalah?',
                    'option_a' => 'Gunakan hanya saat sesak',
                    'option_b' => 'Bilas mulut setelah penggunaan',
                    'option_c' => 'Gunakan sebelum salbutamol',
                    'option_d' => 'Hentikan bila gejala membaik',
                    'option_e' => 'Gunakan lebih sering saat serangan',
                    'correct_answer' => 'B',
                    'explanation' => 'Kortikosteroid inhalasi harus diikuti dengan berkumur dan membuang air kumur untuk mencegah kandidiasis oral dan disfonia',
                ],
                [
                    'question' => 'Terapi empiris untuk pneumonia komunitas rawat jalan pada pasien dewasa tanpa komorbid adalah?',
                    'option_a' => 'Amoksisilin atau makrolid',
                    'option_b' => 'Ciprofloxacin',
                    'option_c' => 'Ceftriaxone IV',
                    'option_d' => 'Meropenem',
                    'option_e' => 'Linezolid',
                    'correct_answer' => 'A',
                    'explanation' => 'CAP (Community-Acquired Pneumonia) rawat jalan tanpa komorbid: amoksisilin 1 g 3x sehari atau makrolid (azithromycin, clarithromycin) sesuai guideline',
                ],
                [
                    'question' => 'Pasien epilepsi mendapat fenitoin. Kadar terapeutik fenitoin dalam darah adalah?',
                    'option_a' => '5-10 mcg/mL',
                    'option_b' => '10-20 mcg/mL',
                    'option_c' => '20-30 mcg/mL',
                    'option_d' => '30-40 mcg/mL',
                    'option_e' => '40-50 mcg/mL',
                    'correct_answer' => 'B',
                    'explanation' => 'Therapeutic range fenitoin adalah 10-20 mcg/mL (40-80 µmol/L). Kadar >20 mcg/mL meningkatkan risiko toksisitas (nistagmus, ataksia, konfusi)',
                ],
                [
                    'question' => 'Apa yang harus dilakukan jika pasien lupa minum pil KB kombinasi 1 tablet?',
                    'option_a' => 'Minum 2 tablet sekaligus saat ingat',
                    'option_b' => 'Lewati tablet yang terlupa',
                    'option_c' => 'Hentikan siklus dan mulai yang baru',
                    'option_d' => 'Gunakan kontrasepsi tambahan 7 hari',
                    'option_e' => 'Konsultasi dokter',
                    'correct_answer' => 'A',
                    'explanation' => 'Bila lupa 1 tablet (<24 jam): minum tablet yang terlupa segera, lanjutkan tablet berikutnya sesuai jadwal. Efektivitas kontrasepsi tetap terjaga',
                ],
            ];

            foreach ($questions2 as $q) {
                QuizQuestion::create(array_merge(['quiz_bank_id' => $quiz2->id], $q));
            }

            // Bank Soal 3: Farmakognosi
            $quiz3 = QuizBank::create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'title' => 'Ujian Farmakognosi - Obat Bahan Alam',
                'description' => 'Bank soal farmakognosi tentang obat dari bahan alam',
                'category' => 'Farmakognosi',
                'total_questions' => 10,
                'duration_minutes' => 30,
                'passing_score' => 70,
            ]);

            $questions3 = [
                [
                    'question' => 'Senyawa artemisin yang digunakan untuk terapi malaria berasal dari tanaman?',
                    'option_a' => 'Cinchona (Kina)',
                    'option_b' => 'Artemisia annua (Qinghao)',
                    'option_c' => 'Catharanthus roseus (Tapak dara)',
                    'option_d' => 'Papaver somniferum (Opium)',
                    'option_e' => 'Digitalis purpurea',
                    'correct_answer' => 'B',
                    'explanation' => 'Artemisin diisolasi dari Artemisia annua (sweet wormwood/qinghao). Obat ini sangat efektif untuk malaria falciparum yang resisten terhadap klorokuin',
                ],
                [
                    'question' => 'Metode standarisasi simplisia yang menggunakan pengukuran kandungan senyawa kimia tertentu disebut?',
                    'option_a' => 'Standarisasi morfologi',
                    'option_b' => 'Standarisasi mikroskopis',
                    'option_c' => 'Standarisasi fitokimia',
                    'option_d' => 'Standarisasi biologi',
                    'option_e' => 'Standarisasi organoleptik',
                    'correct_answer' => 'C',
                    'explanation' => 'Standarisasi fitokimia mengukur kadar senyawa aktif atau marker compound tertentu untuk menjamin kualitas dan efektivitas simplisia',
                ],
                [
                    'question' => 'Alkaloid morfin yang merupakan analgetik kuat berasal dari getah buah tanaman?',
                    'option_a' => 'Cannabis sativa',
                    'option_b' => 'Papaver somniferum',
                    'option_c' => 'Erythroxylum coca',
                    'option_d' => 'Strychnos nux-vomica',
                    'option_e' => 'Atropa belladonna',
                    'correct_answer' => 'B',
                    'explanation' => 'Morfin adalah alkaloid utama dari getah (opium) buah Papaver somniferum (opium poppy), digunakan sebagai analgetik narkotik untuk nyeri berat',
                ],
                [
                    'question' => 'Glikosida antosianin yang memberikan warna merah, ungu, atau biru pada bunga dan buah berfungsi sebagai?',
                    'option_a' => 'Antibakteri',
                    'option_b' => 'Antioksidan',
                    'option_c' => 'Analgetik',
                    'option_d' => 'Antipiretik',
                    'option_e' => 'Antikoagulan',
                    'correct_answer' => 'B',
                    'explanation' => 'Antosianin adalah pigmen flavonoid yang berfungsi sebagai antioksidan kuat, menangkal radikal bebas dan melindungi sel dari kerusakan oksidatif',
                ],
                [
                    'question' => 'Ekstraksi dengan pelarut yang terus menerus disirkulasi menggunakan alat Soxhlet termasuk metode?',
                    'option_a' => 'Maserasi',
                    'option_b' => 'Perkolasi',
                    'option_c' => 'Refluks',
                    'option_d' => 'Soxhletasi',
                    'option_e' => 'Destilasi',
                    'correct_answer' => 'D',
                    'explanation' => 'Soxhletasi adalah metode ekstraksi kontinyu dengan pelarut yang terus disirkulasi, efisien untuk ekstraksi senyawa yang larut dalam pelarut organik',
                ],
                [
                    'question' => 'Senyawa andrografolid yang berkhasiat hepatoprotektor dan imunomodulator terdapat pada tanaman?',
                    'option_a' => 'Sambiloto (Andrographis paniculata)',
                    'option_b' => 'Temulawak (Curcuma xanthorrhiza)',
                    'option_c' => 'Meniran (Phyllanthus niruri)',
                    'option_d' => 'Pegagan (Centella asiatica)',
                    'option_e' => 'Sembung (Blumea balsamifera)',
                    'correct_answer' => 'A',
                    'explanation' => 'Andrografolid adalah senyawa lakton diterpen dari sambiloto yang terbukti berkhasiat sebagai hepatoprotektor, antiinflamasi, dan imunomodulator',
                ],
                [
                    'question' => 'Uji fitokimia yang memberikan warna hijau kehitaman dengan FeCl3 menunjukkan adanya?',
                    'option_a' => 'Alkaloid',
                    'option_b' => 'Flavonoid',
                    'option_c' => 'Tanin',
                    'option_d' => 'Saponin',
                    'option_e' => 'Steroid',
                    'correct_answer' => 'C',
                    'explanation' => 'Reaksi positif dengan FeCl3 (besi(III) klorida) menghasilkan warna hijau kehitaman atau biru kehitaman yang menunjukkan keberadaan senyawa tanin',
                ],
                [
                    'question' => 'Senyawa ginkgolide yang berkhasiat meningkatkan fungsi kognitif dan sirkulasi darah berasal dari?',
                    'option_a' => 'Ginseng (Panax ginseng)',
                    'option_b' => 'Ginkgo (Ginkgo biloba)',
                    'option_c' => 'Gotu kola (Centella asiatica)',
                    'option_d' => 'Brahmi (Bacopa monnieri)',
                    'option_e' => 'Rosemary (Rosmarinus officinalis)',
                    'correct_answer' => 'B',
                    'explanation' => 'Ginkgolide adalah terpenoid unik dari daun Ginkgo biloba yang meningkatkan sirkulasi serebral dan memiliki efek neuroprotektif',
                ],
                [
                    'question' => 'Kadar air maksimal yang diperbolehkan untuk simplisia kering menurut farmakope adalah?',
                    'option_a' => '5%',
                    'option_b' => '8%',
                    'option_c' => '10%',
                    'option_d' => '15%',
                    'option_e' => '20%',
                    'correct_answer' => 'C',
                    'explanation' => 'Farmakope Indonesia menetapkan kadar air maksimal simplisia adalah 10% untuk mencegah pertumbuhan mikroba dan degradasi senyawa aktif',
                ],
                [
                    'question' => 'Senyawa paclitaxel yang digunakan sebagai kemoterapi kanker payudara dan ovarium berasal dari kulit pohon?',
                    'option_a' => 'Taxus brevifolia (Pacific yew)',
                    'option_b' => 'Catharanthus roseus (Madagascar periwinkle)',
                    'option_c' => 'Cinchona (Kina)',
                    'option_d' => 'Podophyllum peltatum (Mayapple)',
                    'option_e' => 'Camptotheca acuminata (Happy tree)',
                    'correct_answer' => 'A',
                    'explanation' => 'Paclitaxel (Taxol) pertama kali diisolasi dari kulit Taxus brevifolia, bekerja dengan menstabilkan mikrotubulus sehingga menghambat pembelahan sel kanker',
                ],
            ];

            foreach ($questions3 as $q) {
                QuizQuestion::create(array_merge(['quiz_bank_id' => $quiz3->id], $q));
            }

            // Bank Soal 4: Farmasi Rumah Sakit
            $quiz4 = QuizBank::create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'title' => 'Farmasi Rumah Sakit - UKOM D3 Farmasi',
                'description' => 'Bank soal farmasi rumah sakit dan pelayanan kefarmasian',
                'category' => 'Farmasi Rumah Sakit',
                'total_questions' => 10,
                'duration_minutes' => 30,
                'passing_score' => 70,
            ]);

            $questions4 = [
                [
                    'question' => 'Obat high alert yang penyimpanannya harus terpisah dan diberi label khusus adalah?',
                    'option_a' => 'Paracetamol injeksi',
                    'option_b' => 'Insulin, KCl injeksi, heparin',
                    'option_c' => 'Antibiotik',
                    'option_d' => 'Vitamin injeksi',
                    'option_e' => 'Antihistamin',
                    'correct_answer' => 'B',
                    'explanation' => 'Obat high alert seperti insulin, KCl pekat, heparin, antikoagulan oral memerlukan penyimpanan terpisah dengan label peringatan karena risiko kesalahan dapat fatal',
                ],
                [
                    'question' => 'LASA (Look Alike Sound Alike) yang sering terjadi adalah?',
                    'option_a' => 'Paracetamol dan Ibuprofen',
                    'option_b' => 'DOPamine dan DOBUtamine',
                    'option_c' => 'Amoksisilin dan Ampisilin',
                    'option_d' => 'Vitamin B1 dan B6',
                    'option_e' => 'Captopril dan Lisinopril',
                    'correct_answer' => 'B',
                    'explanation' => 'DOPamine dan DOBUtamine adalah contoh klasik LASA dengan indikasi berbeda: dopamine untuk shock, dobutamine untuk gagal jantung. Salah pemberian dapat fatal',
                ],
                [
                    'question' => 'Sistem Unit Dose Dispensing (UDD) di rumah sakit memberikan keuntungan?',
                    'option_a' => 'Mengurangi medication error',
                    'option_b' => 'Mempermudah monitoring penggunaan obat',
                    'option_c' => 'Mengurangi waste obat',
                    'option_d' => 'Meningkatkan akuntabilitas',
                    'option_e' => 'Semua benar',
                    'correct_answer' => 'E',
                    'explanation' => 'UDD menyiapkan obat per dosis per pasien untuk 24 jam, mengurangi error, waste, memudahkan monitoring, dan meningkatkan akuntabilitas penggunaan obat',
                ],
                [
                    'question' => 'Pencampuran sitostatika harus dilakukan di ruangan dengan tekanan udara?',
                    'option_a' => 'Tekanan positif',
                    'option_b' => 'Tekanan negatif dengan BSC Class II',
                    'option_c' => 'Tekanan netral',
                    'option_d' => 'Tidak ada persyaratan khusus',
                    'option_e' => 'Tekanan positif dengan LAF',
                    'correct_answer' => 'B',
                    'explanation' => 'Sitostatika harus dicampur di ruang bertekanan negatif dengan BSC (Biological Safety Cabinet) Class II untuk melindungi petugas dan mencegah kontaminasi lingkungan',
                ],
                [
                    'question' => 'Sediaan intravena yang harus diproteksi dari cahaya selama pemberian adalah?',
                    'option_a' => 'NaCl 0.9%',
                    'option_b' => 'Dextrose 5%',
                    'option_c' => 'Nitroprusside, Furosemide',
                    'option_d' => 'Aminophylline',
                    'option_e' => 'Ceftriaxone',
                    'correct_answer' => 'C',
                    'explanation' => 'Nitroprusside dan furosemide fotosensitif dan harus diproteksi dari cahaya dengan aluminium foil atau kantong pelindung selama pemberian',
                ],
                [
                    'question' => 'Rekonsiliasi obat harus dilakukan saat?',
                    'option_a' => 'Pasien masuk rumah sakit',
                    'option_b' => 'Transfer antar ruangan',
                    'option_c' => 'Pasien pulang',
                    'option_d' => 'Semua transisi pelayanan',
                    'option_e' => 'Hanya saat masuk RS',
                    'correct_answer' => 'D',
                    'explanation' => 'Rekonsiliasi obat adalah proses membandingkan obat yang sedang digunakan pasien dengan order baru di setiap transisi pelayanan untuk mencegah discrepancy',
                ],
                [
                    'question' => 'Penyimpanan vaksin cold chain harus pada suhu?',
                    'option_a' => 'Di bawah 0°C',
                    'option_b' => '2-8°C',
                    'option_c' => '15-25°C',
                    'option_d' => '25-30°C',
                    'option_e' => 'Suhu ruangan',
                    'correct_answer' => 'B',
                    'explanation' => 'Vaksin harus disimpan pada cold chain 2-8°C. Pembekuan atau suhu >8°C dapat merusak potensi vaksin',
                ],
                [
                    'question' => 'Penulisan resep racikan yang benar untuk anak usia 5 tahun BB 18 kg adalah?',
                    'option_a' => 'Hanya mencantumkan nama obat',
                    'option_b' => 'Mencantumkan nama, dosis/puyer, frekuensi, durasi',
                    'option_c' => 'Mencantumkan nama dan jumlah saja',
                    'option_d' => 'Tidak perlu mencantumkan BB',
                    'option_e' => 'Hanya mencantumkan signa',
                    'correct_answer' => 'B',
                    'explanation' => 'Resep racikan anak harus lengkap: nama obat, dosis per puyer/kapsul, frekuensi pemberian, durasi terapi, dan idealnya mencantumkan BB untuk verifikasi dosis',
                ],
                [
                    'question' => 'Obat yang tidak boleh diberikan melalui selang NGT adalah?',
                    'option_a' => 'Tablet yang dapat digerus',
                    'option_b' => 'Sirup',
                    'option_c' => 'Kapsul lepas lambat (sustained release)',
                    'option_d' => 'Suspensi',
                    'option_e' => 'Larutan',
                    'correct_answer' => 'C',
                    'explanation' => 'Sediaan lepas lambat, enteric coated, sublingual tidak boleh digerus dan diberikan via NGT karena akan merusak mekanisme pelepasan obat',
                ],
                [
                    'question' => 'Stabilitas sediaan insulin setelah dibuka (in-use stability) adalah?',
                    'option_a' => '7 hari',
                    'option_b' => '14 hari',
                    'option_c' => '28 hari pada suhu ruang',
                    'option_d' => '60 hari',
                    'option_e' => '90 hari',
                    'correct_answer' => 'C',
                    'explanation' => 'Insulin yang sedang digunakan stabil 28 hari pada suhu ruang (<25°C). Insulin yang belum dibuka harus disimpan di kulkas 2-8°C',
                ],
            ];

            foreach ($questions4 as $q) {
                QuizQuestion::create(array_merge(['quiz_bank_id' => $quiz4->id], $q));
            }

            // Bank Soal 5: Kimia Farmasi
            $quiz5 = QuizBank::create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'title' => 'Kimia Farmasi Analisis - UKOM D3 Farmasi',
                'description' => 'Bank soal kimia farmasi dan analisis obat',
                'category' => 'Kimia Farmasi',
                'total_questions' => 10,
                'duration_minutes' => 30,
                'passing_score' => 70,
            ]);

            $questions5 = [
                [
                    'question' => 'Metode analisis kuantitatif paracetamol tablet menggunakan spektrofotometri UV-Vis pada panjang gelombang?',
                    'option_a' => '200 nm',
                    'option_b' => '243 nm',
                    'option_c' => '280 nm',
                    'option_d' => '320 nm',
                    'option_e' => '400 nm',
                    'correct_answer' => 'B',
                    'explanation' => 'Paracetamol memiliki absorbansi maksimum pada panjang gelombang 243 nm dalam pelarut asam, atau 257 nm dalam pelarut basa',
                ],
                [
                    'question' => 'Prinsip kerja HPLC (High Performance Liquid Chromatography) adalah?',
                    'option_a' => 'Pemisahan berdasarkan titik didih',
                    'option_b' => 'Pemisahan berdasarkan interaksi dengan fase diam',
                    'option_c' => 'Pemisahan berdasarkan berat molekul',
                    'option_d' => 'Pemisahan berdasarkan muatan',
                    'option_e' => 'Pemisahan berdasarkan kelarutan',
                    'correct_answer' => 'B',
                    'explanation' => 'HPLC memisahkan komponen berdasarkan perbedaan interaksi (adsorpsi, partisi, ion exchange) dengan fase diam (kolom) yang dialiri fase gerak bertekanan tinggi',
                ],
                [
                    'question' => 'Uji disolusi tablet dilakukan untuk mengetahui?',
                    'option_a' => 'Keseragaman bobot',
                    'option_b' => 'Kecepatan pelepasan zat aktif dari tablet',
                    'option_c' => 'Kandungan zat aktif',
                    'option_d' => 'Waktu hancur tablet',
                    'option_e' => 'Kekerasan tablet',
                    'correct_answer' => 'B',
                    'explanation' => 'Uji disolusi mengukur kecepatan dan jumlah zat aktif yang terlarut dari sediaan padat dalam waktu tertentu, parameter penting untuk bioavailabilitas',
                ],
                [
                    'question' => 'Indikator yang digunakan dalam titrasi asam basa untuk penetapan kadar asam salisilat adalah?',
                    'option_a' => 'Metil merah',
                    'option_b' => 'Fenolftalein',
                    'option_c' => 'Metil orange',
                    'option_d' => 'Brom timol biru',
                    'option_e' => 'Amilum',
                    'correct_answer' => 'B',
                    'explanation' => 'Titrasi asam salisilat (asam lemah) dengan NaOH (basa kuat) menggunakan indikator fenolftalein (pH 8.3-10.0) karena titik ekivalen berada di pH basa',
                ],
                [
                    'question' => 'Validasi metode analisis parameter akurasi menunjukkan?',
                    'option_a' => 'Kedekatan hasil pengukuran yang berulang',
                    'option_b' => 'Kedekatan hasil pengukuran dengan nilai sebenarnya',
                    'option_c' => 'Rentang konsentrasi analisis',
                    'option_d' => 'Konsentrasi terendah yang terdeteksi',
                    'option_e' => 'Spesifisitas metode',
                    'correct_answer' => 'B',
                    'explanation' => 'Akurasi (accuracy) adalah kedekatan hasil pengukuran dengan nilai sebenarnya (true value), dinyatakan sebagai % recovery',
                ],
                [
                    'question' => 'Kromatografi lapis tipis (KLT) digunakan untuk?',
                    'option_a' => 'Analisis kuantitatif saja',
                    'option_b' => 'Identifikasi dan uji kemurnian',
                    'option_c' => 'Penetapan kadar',
                    'option_d' => 'Uji sterilitas',
                    'option_e' => 'Uji disolusi',
                    'correct_answer' => 'B',
                    'explanation' => 'KLT terutama digunakan untuk identifikasi senyawa dan uji kemurnian berdasarkan nilai Rf, dapat juga untuk analisis kuantitatif dengan densitometri',
                ],
                [
                    'question' => 'Limit deteksi (LOD) dalam validasi metode analisis adalah?',
                    'option_a' => 'Konsentrasi tertinggi yang dapat diukur',
                    'option_b' => 'Konsentrasi terendah yang dapat dideteksi',
                    'option_c' => 'Konsentrasi terendah yang dapat dikuantifikasi',
                    'option_d' => 'Rentang linearitas',
                    'option_e' => 'Presisi metode',
                    'correct_answer' => 'B',
                    'explanation' => 'LOD (Limit of Detection) adalah konsentrasi terendah analit yang dapat terdeteksi tetapi tidak perlu terkuantifikasi, biasanya dihitung sebagai 3.3 σ/S',
                ],
                [
                    'question' => 'Fase gerak yang digunakan dalam KLT untuk analisis alkaloid adalah?',
                    'option_a' => 'N-Heksana',
                    'option_b' => 'Kloroform : Metanol : Amoniak',
                    'option_c' => 'Etil asetat',
                    'option_d' => 'Aseton',
                    'option_e' => 'Air',
                    'correct_answer' => 'B',
                    'explanation' => 'Alkaloid bersifat basa sehingga memerlukan fase gerak yang mengandung basa (amoniak) seperti kloroform:metanol:amoniak (8:2:0.1) untuk elusi optimal',
                ],
                [
                    'question' => 'Spektrofotometri IR (Infrared) digunakan untuk?',
                    'option_a' => 'Identifikasi gugus fungsi',
                    'option_b' => 'Penetapan kadar',
                    'option_c' => 'Uji disolusi',
                    'option_d' => 'Uji keseragaman kandungan',
                    'option_e' => 'Uji sterilitas',
                    'correct_answer' => 'A',
                    'explanation' => 'Spektrofotometri IR mengidentifikasi gugus fungsi molekul berdasarkan vibrasi ikatan kimia, menghasilkan fingerprint spectrum untuk identifikasi senyawa',
                ],
                [
                    'question' => 'Uji batas cemaran logam berat dalam sediaan farmasi menggunakan metode?',
                    'option_a' => 'Spektrofotometri UV',
                    'option_b' => 'HPLC',
                    'option_c' => 'AAS (Atomic Absorption Spectroscopy)',
                    'option_d' => 'KLT',
                    'option_e' => 'GC',
                    'correct_answer' => 'C',
                    'explanation' => 'AAS adalah metode pilihan untuk analisis logam berat (Pb, Hg, As, Cd) karena sensitif dan spesifik untuk unsur logam',
                ],
            ];

            foreach ($questions5 as $q) {
                QuizQuestion::create(array_merge(['quiz_bank_id' => $quiz5->id], $q));
            }

            // Bank Soal 6: Manajemen Farmasi
            $quiz6 = QuizBank::create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'title' => 'Manajemen Farmasi - UKOM D3 Farmasi',
                'description' => 'Bank soal manajemen dan administrasi farmasi',
                'category' => 'Manajemen Farmasi',
                'total_questions' => 10,
                'duration_minutes' => 30,
                'passing_score' => 70,
            ]);

            $questions6 = [
                [
                    'question' => 'Metode pengadaan obat dengan membuat surat pesanan langsung ke PBF adalah?',
                    'option_a' => 'Tender terbuka',
                    'option_b' => 'Tender tertutup',
                    'option_c' => 'Pembelian langsung',
                    'option_d' => 'Konsinyasi',
                    'option_e' => 'Drop ship',
                    'correct_answer' => 'C',
                    'explanation' => 'Pembelian langsung adalah metode pengadaan dengan membuat surat pesanan (SP) langsung ke PBF, cocok untuk kebutuhan rutin dan nilai kecil',
                ],
                [
                    'question' => 'Sistem konsinyasi dalam pengadaan obat adalah?',
                    'option_a' => 'Pembayaran langsung saat pembelian',
                    'option_b' => 'Obat dititipkan, bayar setelah terjual',
                    'option_c' => 'Pembelian dengan kredit 30 hari',
                    'option_d' => 'Pembelian melalui tender',
                    'option_e' => 'Pembelian dengan discount',
                    'correct_answer' => 'B',
                    'explanation' => 'Konsinyasi adalah sistem penitipan obat oleh PBF, apotek membayar hanya obat yang terjual. Mengurangi modal kerja tapi harga biasanya lebih tinggi',
                ],
                [
                    'question' => 'Metode perencanaan obat ABC analysis berdasarkan?',
                    'option_a' => 'Frekuensi penggunaan',
                    'option_b' => 'Nilai investasi obat',
                    'option_c' => 'Kecepatan perputaran',
                    'option_d' => 'Tanggal kadaluarsa',
                    'option_e' => 'Golongan obat',
                    'correct_answer' => 'B',
                    'explanation' => 'ABC analysis mengelompokkan obat berdasarkan nilai investasi: A (70% nilai, 10% item), B (20% nilai, 20% item), C (10% nilai, 70% item)',
                ],
                [
                    'question' => 'Metode FIFO (First In First Out) dalam penyimpanan obat artinya?',
                    'option_a' => 'Obat termahal dikeluarkan pertama',
                    'option_b' => 'Obat yang masuk pertama keluar pertama',
                    'option_c' => 'Obat ED terdekat keluar pertama',
                    'option_d' => 'Obat terlaris keluar pertama',
                    'option_e' => 'Obat generik keluar pertama',
                    'correct_answer' => 'B',
                    'explanation' => 'FIFO memastikan obat yang datang pertama dikeluarkan lebih dulu untuk menghindari obat rusak atau kadaluarsa. Berbeda dengan FEFO (First Expired First Out)',
                ],
                [
                    'question' => 'Resep narkotika harus disimpan di apotek selama?',
                    'option_a' => '1 tahun',
                    'option_b' => '2 tahun',
                    'option_c' => '3 tahun',
                    'option_d' => '5 tahun',
                    'option_e' => '10 tahun',
                    'correct_answer' => 'C',
                    'explanation' => 'Sesuai Permenkes, resep narkotika dan psikotropika harus disimpan terpisah dan mudah diambil selama 3 tahun untuk keperluan inspeksi',
                ],
                [
                    'question' => 'Perhitungan turnover rate (TOR) obat dilakukan untuk mengetahui?',
                    'option_a' => 'Harga jual obat',
                    'option_b' => 'Kecepatan perputaran stok',
                    'option_c' => 'Jumlah obat rusak',
                    'option_d' => 'Keuntungan apotek',
                    'option_e' => 'Biaya operasional',
                    'correct_answer' => 'B',
                    'explanation' => 'TOR = Penjualan/Stok rata-rata, menunjukkan berapa kali stok berputar dalam periode tertentu. TOR tinggi = modal berputar cepat',
                ],
                [
                    'question' => 'Stok opname di apotek sebaiknya dilakukan?',
                    'option_a' => 'Setiap hari',
                    'option_b' => 'Setiap minggu',
                    'option_c' => 'Setiap bulan',
                    'option_d' => 'Setiap 6 bulan',
                    'option_e' => 'Setiap tahun',
                    'correct_answer' => 'C',
                    'explanation' => 'Stok opname idealnya dilakukan minimal setiap bulan untuk mendeteksi selisih, obat rusak/ED, dan rekonsiliasi pembukuan dengan fisik',
                ],
                [
                    'question' => 'Pelaporan penggunaan narkotika dan psikotropika di apotek dilaporkan ke?',
                    'option_a' => 'BPOM',
                    'option_b' => 'Dinas Kesehatan setempat',
                    'option_c' => 'Kementerian Kesehatan',
                    'option_d' => 'Kepolisian',
                    'option_e' => 'Organisasi profesi',
                    'correct_answer' => 'B',
                    'explanation' => 'Apotek wajib melaporkan penggunaan narkotika dan psikotropika setiap bulan ke Dinkes Kabupaten/Kota setempat',
                ],
                [
                    'question' => 'Markup atau margin keuntungan apotek pada umumnya adalah?',
                    'option_a' => '5-10%',
                    'option_b' => '15-25%',
                    'option_c' => '30-40%',
                    'option_d' => '50-60%',
                    'option_e' => '70-80%',
                    'correct_answer' => 'B',
                    'explanation' => 'Margin apotek umumnya 15-25% tergantung jenis obat, lokasi, dan kompetisi. Obat generik margin lebih tinggi, obat branded margin lebih kecil',
                ],
                [
                    'question' => 'Dead stock dalam manajemen persediaan obat adalah?',
                    'option_a' => 'Obat yang sering terjual',
                    'option_b' => 'Obat yang tidak laku/tidak bergerak',
                    'option_c' => 'Obat kadaluarsa',
                    'option_d' => 'Obat mahal',
                    'option_e' => 'Obat narkotika',
                    'correct_answer' => 'B',
                    'explanation' => 'Dead stock adalah obat yang tidak bergerak/tidak terjual dalam periode tertentu (misal 6 bulan), mengikat modal dan berisiko ED. Perlu strategi promosi atau retur',
                ],
            ];

            foreach ($questions6 as $q) {
                QuizQuestion::create(array_merge(['quiz_bank_id' => $quiz6->id], $q));
            }
        }

        $this->command->info('✅ Quiz Bank seeder berhasil dijalankan!');
        $this->command->info('📝 Total quiz banks: ' . QuizBank::count());
        $this->command->info('❓ Total questions: ' . QuizQuestion::count());
    }
}

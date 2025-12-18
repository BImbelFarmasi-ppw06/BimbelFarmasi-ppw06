<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuizBank;
use App\Models\QuizQuestion;
use App\Models\Order;
use App\Models\User;
use App\Models\Program;

class TryOutSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🎯 Memulai seeding Try Out untuk semua program...');
        
        $user = User::where('is_admin', 0)->first();
        
        if (!$user) {
            $this->command->warn('⚠️ Membuat user dummy untuk try out demo...');
            $user = User::create([
                'name' => 'Demo Student',
                'email' => 'student.demo@bimbelfarmasi.com',
                'password' => bcrypt('password'),
                'phone' => '081234567890',
                'is_admin' => false,
            ]);
        }

        $ukomPrograms = Program::where('type', 'bimbel')->get();
        $cpnsPrograms = Program::where('type', 'cpns')->get();

        foreach ($ukomPrograms as $program) {
            $this->command->info("🎯 Seeding try out untuk: {$program->name}");
            
            $order = Order::where('user_id', $user->id)
                ->where('program_id', $program->id)
                ->first();
            
            if (!$order) {
                $order = Order::create([
                    'order_number' => 'ORD-' . strtoupper(uniqid()),
                    'user_id' => $user->id,
                    'program_id' => $program->id,
                    'amount' => $program->price,
                    'status' => 'completed',
                    'notes' => 'Order demo untuk try out seeder',
                ]);
            }

            $this->seedUkomTryOut($order, $user);
        }

        foreach ($cpnsPrograms as $program) {
            $this->command->info("🎯 Seeding try out untuk: {$program->name}");
            
            $order = Order::where('user_id', $user->id)
                ->where('program_id', $program->id)
                ->first();
            
            if (!$order) {
                $order = Order::create([
                    'order_number' => 'ORD-' . strtoupper(uniqid()),
                    'user_id' => $user->id,
                    'program_id' => $program->id,
                    'amount' => $program->price,
                    'status' => 'completed',
                    'notes' => 'Order demo untuk try out seeder',
                ]);
            }

            $this->seedCpnsTryOut($order, $user);
        }

        $this->command->info('✅ Seeding Try Out selesai!');
    }

    private function seedUkomTryOut($order, $user)
    {
        // TRY OUT 1: UKOM D3 Farmasi - Sesi 1 (Campuran Semua Kategori)
        $tryout1Questions = [
            // Farmakologi
            [
                'question' => 'Mekanisme kerja obat golongan beta blocker dalam menurunkan tekanan darah adalah?',
                'option_a' => 'Vasodilatasi pembuluh darah',
                'option_b' => 'Menurunkan cardiac output dan menghambat renin',
                'option_c' => 'Menghambat ACE',
                'option_d' => 'Diuretik',
                'correct_answer' => 'B',
                'explanation' => 'Beta blocker menurunkan tekanan darah dengan mengurangi cardiac output dan menghambat pelepasan renin dari ginjal',
            ],
            [
                'question' => 'Obat yang dapat menyebabkan sindrom gray baby adalah?',
                'option_a' => 'Tetrasiklin',
                'option_b' => 'Kloramfenikol',
                'option_c' => 'Gentamisin',
                'option_d' => 'Siprofloksasin',
                'correct_answer' => 'B',
                'explanation' => 'Kloramfenikol dapat menyebabkan gray baby syndrome pada neonatus karena sistem enzim hati yang belum matang',
            ],
            [
                'question' => 'Antidotum untuk keracunan organofosfat adalah?',
                'option_a' => 'Nalokson',
                'option_b' => 'Flumazenil',
                'option_c' => 'Atropin',
                'option_d' => 'N-asetilsistein',
                'correct_answer' => 'C',
                'explanation' => 'Atropin adalah antidotum untuk keracunan organofosfat (pestisida) karena memblok efek kolinergik berlebih',
            ],
            
            // Farmasi Klinik
            [
                'question' => 'Pada pasien dengan CrCl 30 mL/menit, perlu dilakukan?',
                'option_a' => 'Peningkatan dosis obat',
                'option_b' => 'Penyesuaian dosis atau interval obat',
                'option_c' => 'Tidak perlu penyesuaian',
                'option_d' => 'Penghentian obat',
                'correct_answer' => 'B',
                'explanation' => 'Pada gangguan ginjal (CrCl <60), perlu penyesuaian dosis atau interval pemberian obat yang diekskresi lewat ginjal',
            ],
            [
                'question' => 'Obat TB kategori 1 fase intensif diberikan selama?',
                'option_a' => '1 bulan',
                'option_b' => '2 bulan',
                'option_c' => '4 bulan',
                'option_d' => '6 bulan',
                'correct_answer' => 'B',
                'explanation' => 'TB kategori 1 fase intensif diberikan 2 bulan pertama dengan 4 obat (RHZE)',
            ],
            [
                'question' => 'Efek samping serius dari obat isoniazid adalah?',
                'option_a' => 'Hepatotoksisitas',
                'option_b' => 'Nefrotoksisitas',
                'option_c' => 'Kardiotoksisitas',
                'option_d' => 'Neurotoksisitas ringan',
                'correct_answer' => 'A',
                'explanation' => 'Isoniazid dapat menyebabkan hepatotoksisitas, perlu monitoring fungsi hati',
            ],
            
            // Farmasetika
            [
                'question' => 'Cara penyimpanan insulin yang benar adalah?',
                'option_a' => 'Suhu kamar',
                'option_b' => 'Kulkas 2-8°C, jangan dibekukan',
                'option_c' => 'Freezer',
                'option_d' => 'Tempat panas',
                'correct_answer' => 'B',
                'explanation' => 'Insulin disimpan di kulkas 2-8°C dan tidak boleh dibekukan karena akan rusak',
            ],
            [
                'question' => 'Sediaan suppositoria menggunakan basis yang meleleh pada suhu?',
                'option_a' => '20-25°C',
                'option_b' => '30-37°C',
                'option_c' => '40-45°C',
                'option_d' => '50-60°C',
                'correct_answer' => 'B',
                'explanation' => 'Basis suppositoria seperti oleum cacao meleleh pada suhu tubuh (30-37°C)',
            ],
            [
                'question' => 'Pengawet yang umum digunakan dalam sediaan sirup adalah?',
                'option_a' => 'Benzalkonium klorida',
                'option_b' => 'Metil paraben dan propil paraben',
                'option_c' => 'Timerosal',
                'option_d' => 'Fenol',
                'correct_answer' => 'B',
                'explanation' => 'Metil dan propil paraben adalah pengawet yang umum dan aman untuk sediaan oral seperti sirup',
            ],
            
            // Kimia Farmasi
            [
                'question' => 'Obat NSAID yang relatif paling aman untuk lambung adalah?',
                'option_a' => 'Aspirin',
                'option_b' => 'Diklofenak',
                'option_c' => 'Celecoxib (COX-2 inhibitor)',
                'option_d' => 'Indometasin',
                'correct_answer' => 'C',
                'explanation' => 'Celecoxib adalah COX-2 selective inhibitor yang lebih aman untuk lambung dibanding NSAID non-selektif',
            ],
            [
                'question' => 'Obat golongan sulfonilurea yang paling sering digunakan adalah?',
                'option_a' => 'Metformin',
                'option_b' => 'Glimepiride',
                'option_c' => 'Acarbose',
                'option_d' => 'Insulin',
                'correct_answer' => 'B',
                'explanation' => 'Glimepiride adalah sulfonilurea yang sering digunakan untuk diabetes tipe 2',
            ],
            
            // Farmakognosi
            [
                'question' => 'Senyawa artemisinin yang digunakan untuk malaria berasal dari tanaman?',
                'option_a' => 'Kina',
                'option_b' => 'Artemisia annua',
                'option_c' => 'Cinchona',
                'option_d' => 'Belladonna',
                'correct_answer' => 'B',
                'explanation' => 'Artemisinin berasal dari tanaman Artemisia annua (sweet wormwood) dan efektif untuk malaria',
            ],
            [
                'question' => 'Morfin adalah alkaloid yang diperoleh dari?',
                'option_a' => 'Cannabis sativa',
                'option_b' => 'Papaver somniferum (opium)',
                'option_c' => 'Erythroxylum coca',
                'option_d' => 'Atropa belladonna',
                'correct_answer' => 'B',
                'explanation' => 'Morfin adalah alkaloid utama dari opium (Papaver somniferum)',
            ],
            [
                'question' => 'Atropin berasal dari tanaman Atropa belladonna dan digunakan sebagai?',
                'option_a' => 'Analgesik',
                'option_b' => 'Antispasmodik dan midriasis',
                'option_c' => 'Antipiretik',
                'option_d' => 'Antibiotik',
                'correct_answer' => 'B',
                'explanation' => 'Atropin adalah antikolinergik dari belladonna yang digunakan sebagai antispasmodik dan untuk melebarkan pupil',
            ],
            [
                'question' => 'Digoksin yang digunakan untuk gagal jantung berasal dari?',
                'option_a' => 'Digitalis purpurea',
                'option_b' => 'Rauwolfia serpentina',
                'option_c' => 'Strophanthus gratus',
                'option_d' => 'A dan C benar',
                'correct_answer' => 'D',
                'explanation' => 'Digoksin adalah glikosida jantung yang berasal dari Digitalis purpurea dan Strophanthus gratus',
            ],
        ];

        $this->createTryOut($order, $user, 'Try Out UKOM D3 Farmasi - Sesi 1', $tryout1Questions, 90, 'Try Out Komprehensif');

        // TRY OUT 2: UKOM D3 Farmasi - Sesi 2
        $tryout2Questions = [
            [
                'question' => 'Obat antihipertensi yang kontraindikasi pada ibu hamil adalah?',
                'option_a' => 'Metildopa',
                'option_b' => 'ACE inhibitor',
                'option_c' => 'Nifedipin',
                'option_d' => 'Labetalol',
                'correct_answer' => 'B',
                'explanation' => 'ACE inhibitor teratogenik dan kontraindikasi mutlak pada kehamilan',
            ],
            [
                'question' => 'Pasien diabetes mengalami hipoglikemia, pertolongan pertama yang tepat adalah?',
                'option_a' => 'Berikan insulin tambahan',
                'option_b' => 'Berikan gula/glukosa segera',
                'option_c' => 'Berikan obat antidiabetes oral',
                'option_d' => 'Tunggu hingga gejala hilang',
                'correct_answer' => 'B',
                'explanation' => 'Hipoglikemia adalah kondisi darurat, berikan gula/glukosa segera',
            ],
            [
                'question' => 'Obat kumur yang mengandung antiseptik klorheksidin dapat menyebabkan?',
                'option_a' => 'Gigi berlubang',
                'option_b' => 'Pewarnaan gigi (staining)',
                'option_c' => 'Kerusakan email',
                'option_d' => 'Tidak ada efek samping',
                'correct_answer' => 'B',
                'explanation' => 'Penggunaan klorheksidin jangka panjang dapat menyebabkan pewarnaan gigi',
            ],
            [
                'question' => 'Vaksin yang diberikan pada bayi usia 0 bulan (saat lahir) adalah?',
                'option_a' => 'BCG',
                'option_b' => 'Hepatitis B dan Polio 0',
                'option_c' => 'DPT',
                'option_d' => 'Campak',
                'correct_answer' => 'B',
                'explanation' => 'Vaksin Hepatitis B dan Polio 0 diberikan segera setelah lahir (0 bulan)',
            ],
            [
                'question' => 'Cream tipe O/W lebih cocok untuk kulit?',
                'option_a' => 'Kering',
                'option_b' => 'Berminyak',
                'option_c' => 'Normal saja',
                'option_d' => 'Semua jenis kulit',
                'correct_answer' => 'B',
                'explanation' => 'Cream O/W tidak berminyak, cocok untuk kulit berminyak',
            ],
            [
                'question' => 'Metode sterilisasi untuk alat-alat logam adalah?',
                'option_a' => 'Autoklaf atau sterilisasi kering',
                'option_b' => 'Filtrasi',
                'option_c' => 'Pasteurisasi',
                'option_d' => 'Radiasi UV',
                'correct_answer' => 'A',
                'explanation' => 'Alat logam dapat disterilkan dengan autoklaf atau oven (sterilisasi kering)',
            ],
            [
                'question' => 'Tablet lepas lambat (sustained release) bekerja dengan cara?',
                'option_a' => 'Cepat hancur di lambung',
                'option_b' => 'Melepas obat secara bertahap dalam waktu lama',
                'option_c' => 'Hanya hancur di usus',
                'option_d' => 'Langsung diserap',
                'correct_answer' => 'B',
                'explanation' => 'Tablet sustained release dirancang melepas obat secara bertahap untuk efek yang lebih lama',
            ],
            [
                'question' => 'Antibiotik spektrum luas yang aman untuk ibu hamil adalah?',
                'option_a' => 'Tetrasiklin',
                'option_b' => 'Amoksisilin',
                'option_c' => 'Siprofloksasin',
                'option_d' => 'Doksisiklin',
                'correct_answer' => 'B',
                'explanation' => 'Amoksisilin (penisilin) relatif aman untuk ibu hamil',
            ],
            [
                'question' => 'Epinefrin (adrenalin) digunakan sebagai obat darurat untuk?',
                'option_a' => 'Demam tinggi',
                'option_b' => 'Syok anafilaksis',
                'option_c' => 'Diare',
                'option_d' => 'Batuk',
                'correct_answer' => 'B',
                'explanation' => 'Epinefrin adalah obat pilihan pertama untuk syok anafilaksis',
            ],
            [
                'question' => 'Obat yang memerlukan therapeutic drug monitoring (TDM) adalah?',
                'option_a' => 'Parasetamol',
                'option_b' => 'Fenitoin, digoksin, teofilin',
                'option_c' => 'Vitamin C',
                'option_d' => 'Antasida',
                'correct_answer' => 'B',
                'explanation' => 'Obat dengan indeks terapi sempit seperti fenitoin, digoksin memerlukan TDM',
            ],
            [
                'question' => 'Kuersetin adalah senyawa flavonoid yang terdapat pada?',
                'option_a' => 'Bawang merah',
                'option_b' => 'Jahe',
                'option_c' => 'Kunyit',
                'option_d' => 'Sirih',
                'correct_answer' => 'A',
                'explanation' => 'Kuersetin adalah flavonoid yang banyak terdapat pada bawang merah dan memiliki efek antioksidan',
            ],
            [
                'question' => 'Senna (Cassia angustifolia) digunakan sebagai?',
                'option_a' => 'Antidiare',
                'option_b' => 'Laksatif (pencahar)',
                'option_c' => 'Antiemetik',
                'option_d' => 'Karminatif',
                'correct_answer' => 'B',
                'explanation' => 'Senna mengandung sennosida yang merupakan laksatif stimulan',
            ],
            [
                'question' => 'Reserpina yang digunakan sebagai antihipertensi berasal dari?',
                'option_a' => 'Rauwolfia serpentina',
                'option_b' => 'Digitalis',
                'option_c' => 'Cinchona',
                'option_d' => 'Papaver',
                'correct_answer' => 'A',
                'explanation' => 'Reserpina adalah alkaloid dari Rauwolfia serpentina yang memiliki efek antihipertensi',
            ],
            [
                'question' => 'Asam valerat yang memiliki efek sedatif terdapat pada?',
                'option_a' => 'Valerian (Valeriana officinalis)',
                'option_b' => 'Ginseng',
                'option_c' => 'Echinacea',
                'option_d' => 'St. John\'s Wort',
                'correct_answer' => 'A',
                'explanation' => 'Asam valerat dari akar valerian memiliki efek sedatif dan digunakan untuk insomnia',
            ],
            [
                'question' => 'Emetin yang digunakan sebagai amebisida berasal dari?',
                'option_a' => 'Ipecac (Cephaelis ipecacuanha)',
                'option_b' => 'Kina',
                'option_c' => 'Artemisia',
                'option_d' => 'Rauwolfia',
                'correct_answer' => 'A',
                'explanation' => 'Emetin adalah alkaloid dari akar ipecac yang efektif untuk amubiasis',
            ],
        ];

        $this->createTryOut($order, $user, 'Try Out UKOM D3 Farmasi - Sesi 2', $tryout2Questions, 90, 'Try Out Komprehensif');

        $this->command->info("  ✓ Selesai membuat 2 try out UKOM");
    }

    private function seedCpnsTryOut($order, $user)
    {
        // TRY OUT 1: CPNS Farmasi - Simulasi Lengkap
        $tryout1Questions = [
            // TWK
            [
                'question' => 'Pasal 33 UUD 1945 mengatur tentang?',
                'option_a' => 'Hak Asasi Manusia',
                'option_b' => 'Perekonomian nasional dan kesejahteraan sosial',
                'option_c' => 'Pertahanan negara',
                'option_d' => 'Pendidikan',
                'correct_answer' => 'B',
                'explanation' => 'Pasal 33 UUD 1945 mengatur tentang perekonomian nasional dan kesejahteraan sosial',
            ],
            [
                'question' => 'Tujuan negara Indonesia yang tercantum dalam Pembukaan UUD 1945 alinea ke-4 adalah?',
                'option_a' => 'Merdeka dan berdaulat',
                'option_b' => 'Mencerdaskan kehidupan bangsa, melindungi segenap bangsa, memajukan kesejahteraan umum, ikut melaksanakan ketertiban dunia',
                'option_c' => 'Negara hukum',
                'option_d' => 'Negara kesatuan',
                'correct_answer' => 'B',
                'explanation' => 'Pembukaan UUD 1945 alinea 4 menyebutkan 4 tujuan negara Indonesia',
            ],
            [
                'question' => 'Kedaulatan rakyat di Indonesia dilaksanakan menurut?',
                'option_a' => 'UUD 1945',
                'option_b' => 'Pancasila',
                'option_c' => 'Tap MPR',
                'option_d' => 'Peraturan Presiden',
                'correct_answer' => 'A',
                'explanation' => 'Pasal 1 ayat 2 UUD 1945: Kedaulatan berada di tangan rakyat dan dilaksanakan menurut UUD',
            ],
            [
                'question' => 'Yang bukan termasuk lembaga negara dalam sistem ketatanegaraan Indonesia adalah?',
                'option_a' => 'DPR',
                'option_b' => 'KPK',
                'option_c' => 'MA',
                'option_d' => 'MK',
                'correct_answer' => 'B',
                'explanation' => 'KPK adalah lembaga negara independen namun bukan lembaga tinggi negara seperti DPR, MA, MK',
            ],
            [
                'question' => 'Hak untuk mendapatkan pendidikan dijamin dalam UUD 1945 Pasal?',
                'option_a' => 'Pasal 28',
                'option_b' => 'Pasal 31',
                'option_c' => 'Pasal 33',
                'option_d' => 'Pasal 34',
                'correct_answer' => 'B',
                'explanation' => 'Pasal 31 UUD 1945 mengatur tentang hak setiap warga negara untuk mendapat pendidikan',
            ],
            
            // TIU
            [
                'question' => 'Jika semua A adalah B, dan semua B adalah C, maka?',
                'option_a' => 'Semua A adalah C',
                'option_b' => 'Semua C adalah A',
                'option_c' => 'Tidak ada hubungan',
                'option_d' => 'Tidak dapat disimpulkan',
                'correct_answer' => 'A',
                'explanation' => 'Silogisme: Jika A⊂B dan B⊂C maka A⊂C',
            ],
            [
                'question' => 'Deret: 3, 6, 12, 24, ...?',
                'option_a' => '36',
                'option_b' => '48',
                'option_c' => '52',
                'option_d' => '60',
                'correct_answer' => 'B',
                'explanation' => 'Pola dikali 2: 3×2=6, 6×2=12, 12×2=24, 24×2=48',
            ],
            [
                'question' => 'Antonim dari EFISIEN adalah?',
                'option_a' => 'Boros',
                'option_b' => 'Hemat',
                'option_c' => 'Cepat',
                'option_d' => 'Lambat',
                'correct_answer' => 'A',
                'explanation' => 'Antonim efisien adalah boros (tidak hemat)',
            ],
            [
                'question' => 'Jika harga 5 kg beras adalah Rp 75.000, berapa harga 8 kg?',
                'option_a' => 'Rp 100.000',
                'option_b' => 'Rp 120.000',
                'option_c' => 'Rp 125.000',
                'option_d' => 'Rp 150.000',
                'correct_answer' => 'B',
                'explanation' => 'Harga per kg = 75.000/5 = 15.000. Maka 8 kg = 8×15.000 = 120.000',
            ],
            [
                'question' => 'ANALOG dengan DIGITAL, seperti MANUAL dengan?',
                'option_a' => 'Otomatis',
                'option_b' => 'Mesin',
                'option_c' => 'Komputer',
                'option_d' => 'Elektronik',
                'correct_answer' => 'A',
                'explanation' => 'Analog lawan digital, manual lawan otomatis',
            ],
            
            // TKP
            [
                'question' => 'Atasan Anda memberikan tugas yang menurutAnda tidak sesuai dengan job desc. Sikap Anda?',
                'option_a' => 'Menolak dengan keras',
                'option_b' => 'Menerima dan berusaha sebaik mungkin sambil berkonsultasi',
                'option_c' => 'Mengabaikan',
                'option_d' => 'Komplain ke atasan yang lebih tinggi',
                'correct_answer' => 'B',
                'explanation' => 'Sikap profesional adalah menerima tugas sambil berkomunikasi dengan baik',
            ],
            [
                'question' => 'Anda melihat rekan kerja menggunakan fasilitas kantor untuk kepentingan pribadi. Anda akan?',
                'option_a' => 'Ikut menggunakan juga',
                'option_b' => 'Mengingatkan dengan cara yang baik',
                'option_c' => 'Diam saja',
                'option_d' => 'Langsung melaporkan',
                'correct_answer' => 'B',
                'explanation' => 'Teguran dengan cara baik lebih efektif daripada langsung melaporkan',
            ],
            [
                'question' => 'Dalam menghadapi perbedaan pendapat dalam tim, Anda akan?',
                'option_a' => 'Memaksakan pendapat sendiri',
                'option_b' => 'Mencari solusi dengan diskusi dan kompromi',
                'option_c' => 'Mengalah saja',
                'option_d' => 'Keluar dari diskusi',
                'correct_answer' => 'B',
                'explanation' => 'Diskusi dan kompromi adalah cara terbaik menyelesaikan perbedaan pendapat',
            ],
            [
                'question' => 'Ketika target pekerjaan tidak tercapai, Anda akan?',
                'option_a' => 'Menyalahkan rekan kerja',
                'option_b' => 'Evaluasi dan perbaiki strategi kerja',
                'option_c' => 'Menyerah',
                'option_d' => 'Mencari alasan',
                'correct_answer' => 'B',
                'explanation' => 'Evaluasi dan perbaikan adalah sikap bertanggung jawab',
            ],
            [
                'question' => 'Anda diminta membantu rekan yang kesulitan padahal pekerjaan Anda juga banyak. Anda akan?',
                'option_a' => 'Menolak mentah-mentah',
                'option_b' => 'Membantu setelah menyelesaikan pekerjaan prioritas',
                'option_c' => 'Membantu tapi pekerjaan sendiri terbengkalai',
                'option_d' => 'Mengabaikan',
                'correct_answer' => 'B',
                'explanation' => 'Prioritaskan pekerjaan sendiri namun tetap membantu rekan',
            ],
            
            // Bidang Farmasi
            [
                'question' => 'Dalam pelayanan resep, apoteker harus melakukan skrining resep yang meliputi?',
                'option_a' => 'Hanya melihat nama obat',
                'option_b' => 'Administratif, farmasetik, klinis',
                'option_c' => 'Hanya dosis',
                'option_d' => 'Hanya harga',
                'correct_answer' => 'B',
                'explanation' => 'Skrining resep meliputi aspek administratif, farmasetik, dan klinis',
            ],
            [
                'question' => 'Peran apoteker dalam Puskesmas sesuai Permenkes No. 74 tahun 2016 adalah?',
                'option_a' => 'Hanya meracik obat',
                'option_b' => 'Pengelolaan obat dan pelayanan farmasi klinik',
                'option_c' => 'Administrasi',
                'option_d' => 'Cleaning service',
                'correct_answer' => 'B',
                'explanation' => 'Apoteker bertanggung jawab atas pengelolaan sediaan farmasi dan pelayanan farmasi klinik',
            ],
            [
                'question' => 'LASA (Look Alike Sound Alike) adalah konsep untuk mencegah?',
                'option_a' => 'Obat kadaluarsa',
                'option_b' => 'Medication error akibat nama obat mirip',
                'option_c' => 'Harga obat mahal',
                'option_d' => 'Stok obat habis',
                'correct_answer' => 'B',
                'explanation' => 'LASA adalah strategi untuk mencegah kesalahan pemberian obat yang namanya mirip',
            ],
            [
                'question' => 'Dalam pengelolaan obat, metode FEFO singkatan dari?',
                'option_a' => 'First Expire First Out',
                'option_b' => 'First End First Out',
                'option_c' => 'Fast Entry Fast Out',
                'option_d' => 'Final Expire Final Out',
                'correct_answer' => 'A',
                'explanation' => 'FEFO = First Expire First Out, obat yang expired datenya lebih dulu dikeluarkan lebih dahulu',
            ],
            [
                'question' => 'Salah satu indikator mutu pelayanan kefarmasian adalah?',
                'option_a' => 'Jumlah pasien',
                'option_b' => 'Waktu tunggu pelayanan resep',
                'option_c' => 'Jumlah obat',
                'option_d' => 'Luas apotek',
                'correct_answer' => 'B',
                'explanation' => 'Waktu tunggu pelayanan resep adalah salah satu indikator mutu pelayanan kefarmasian',
            ],
        ];

        $this->createTryOut($order, $user, 'Try Out CPNS Farmasi - SKD + SKB Lengkap', $tryout1Questions, 120, 'Try Out Simulasi SKD + SKB');

        // TRY OUT 2: CPNS Farmasi - Fokus SKB
        $tryout2Questions = [
            [
                'question' => 'Swamedikasi adalah?',
                'option_a' => 'Pengobatan sendiri dengan obat bebas/bebas terbatas untuk penyakit ringan',
                'option_b' => 'Pengobatan oleh dokter',
                'option_c' => 'Pengobatan herbal',
                'option_d' => 'Pengobatan tradisional',
                'correct_answer' => 'A',
                'explanation' => 'Swamedikasi adalah upaya mengobati diri sendiri dengan obat bebas/bebas terbatas',
            ],
            [
                'question' => 'Yang termasuk 7 bintang kompetensi apoteker adalah?',
                'option_a' => 'Pemberi layanan, pengambil keputusan, komunikator, pemimpin, manajer, pembelajar sepanjang hayat, pendidik',
                'option_b' => 'Hanya pemberi layanan',
                'option_c' => 'Hanya manajer',
                'option_d' => 'Hanya pendidik',
                'correct_answer' => 'A',
                'explanation' => '7 bintang apoteker: care giver, decision maker, communicator, leader, manager, life-long learner, teacher',
            ],
            [
                'question' => 'Apotek yang melayani resep dokter dari rumah sakit disebut?',
                'option_a' => 'Apotek biasa',
                'option_b' => 'Apotek satelit rumah sakit',
                'option_c' => 'Apotek klinik',
                'option_d' => 'Apotek umum',
                'correct_answer' => 'B',
                'explanation' => 'Apotek satelit rumah sakit melayani resep pasien rawat jalan rumah sakit',
            ],
            [
                'question' => 'Obat generik adalah?',
                'option_a' => 'Obat dengan merek dagang',
                'option_b' => 'Obat dengan nama zat aktif (INN)',
                'option_c' => 'Obat paten',
                'option_d' => 'Obat herbal',
                'correct_answer' => 'B',
                'explanation' => 'Obat generik menggunakan nama INN (International Nonproprietary Name) atau nama zat aktif',
            ],
            [
                'question' => 'PIO (Penyuluhan Informasi Obat) kepada pasien bertujuan untuk?',
                'option_a' => 'Meningkatkan kepatuhan dan pemahaman pasien tentang obat',
                'option_b' => 'Menjual lebih banyak obat',
                'option_c' => 'Mempersulit pasien',
                'option_d' => 'Membuat pasien bingung',
                'correct_answer' => 'A',
                'explanation' => 'PIO bertujuan meningkatkan pengetahuan dan kepatuhan pasien terhadap terapi',
            ],
            [
                'question' => 'Resep yang mengandung narkotika harus disimpan terpisah selama?',
                'option_a' => '1 tahun',
                'option_b' => '3 tahun',
                'option_c' => '5 tahun',
                'option_d' => 'Selamanya',
                'correct_answer' => 'B',
                'explanation' => 'Resep narkotika disimpan terpisah selama 3 tahun sesuai peraturan',
            ],
            [
                'question' => 'High alert medication adalah?',
                'option_a' => 'Obat yang bila terjadi kesalahan dapat menyebabkan cedera serius atau kematian',
                'option_b' => 'Obat mahal',
                'option_c' => 'Obat baru',
                'option_d' => 'Obat herbal',
                'correct_answer' => 'A',
                'explanation' => 'High alert medication seperti insulin, heparin, KCl injeksi perlu perhatian ekstra',
            ],
            [
                'question' => 'E-prescribing adalah?',
                'option_a' => 'Resep elektronik',
                'option_b' => 'Resep kertas',
                'option_c' => 'Resep lisan',
                'option_d' => 'Resep tradisional',
                'correct_answer' => 'A',
                'explanation' => 'E-prescribing adalah sistem penulisan resep secara elektronik untuk mengurangi medication error',
            ],
            [
                'question' => 'Dalam rantai dingin (cold chain) vaksin, suhu yang harus dijaga adalah?',
                'option_a' => '0-2°C',
                'option_b' => '2-8°C',
                'option_c' => '8-15°C',
                'option_d' => '15-25°C',
                'correct_answer' => 'B',
                'explanation' => 'Vaksin harus disimpan pada suhu 2-8°C untuk menjaga potensinya',
            ],
            [
                'question' => 'MESO (Monitoring Efek Samping Obat) penting untuk?',
                'option_a' => 'Deteksi dini efek samping obat',
                'option_b' => 'Menambah penjualan',
                'option_c' => 'Mengurangi harga obat',
                'option_d' => 'Menambah stok',
                'correct_answer' => 'A',
                'explanation' => 'MESO/pharmacovigilance penting untuk mendeteksi dan mencegah efek samping obat',
            ],
        ];

        $this->createTryOut($order, $user, 'Try Out CPNS Farmasi - Fokus SKB', $tryout2Questions, 60, 'Try Out SKB Farmasi');

        $this->command->info("  ✓ Selesai membuat 2 try out CPNS");
    }

    private function createTryOut($order, $user, $title, $questions, $duration, $category)
    {
        $tryout = QuizBank::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'program_id' => $order->program_id,
            'title' => $title,
            'description' => 'Try Out komprehensif untuk simulasi ujian sebenarnya',
            'category' => $category,
            'type' => 'tryout',
            'total_questions' => count($questions),
            'duration_minutes' => $duration,
            'passing_score' => 70,
        ]);

        foreach ($questions as $q) {
            QuizQuestion::create(array_merge(['quiz_bank_id' => $tryout->id], $q));
        }

        $this->command->line("    → Try Out: {$title} ({$duration} menit, " . count($questions) . " soal)");
    }
}

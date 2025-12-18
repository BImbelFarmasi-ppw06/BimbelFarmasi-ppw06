<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuizBank;
use App\Models\QuizQuestion;
use App\Models\Order;
use App\Models\User;
use App\Models\Program;

class QuizBankSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Memulai seeding Quiz Banks dan Questions...');
        
        $user = User::where('is_admin', 0)->first();
        
        if (!$user) {
            $this->command->warn('⚠️ Membuat user dummy untuk quiz demo...');
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
            $this->command->info("📚 Seeding quiz untuk: {$program->name}");
            
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => $user->id,
                'program_id' => $program->id,
                'amount' => $program->price,
                'status' => 'completed',
                'notes' => 'Order demo untuk quiz seeder',
            ]);

            $this->seedUkomQuizzes($order, $user);
        }

        foreach ($cpnsPrograms as $program) {
            $this->command->info("📚 Seeding quiz untuk: {$program->name}");
            
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => $user->id,
                'program_id' => $program->id,
                'amount' => $program->price,
                'status' => 'completed',
                'notes' => 'Order demo untuk quiz seeder',
            ]);

            $this->seedCpnsQuizzes($order, $user);
        }

        $this->command->info('✅ Seeding Quiz Banks selesai!');
    }

    private function seedUkomQuizzes($order, $user)
    {
        // 1. FARMAKOLOGI
        $this->createQuizBank($order, $user, 'Farmakologi', [
            [
                'question' => 'Apa yang dimaksud dengan farmakokinetik?',
                'option_a' => 'Efek obat terhadap tubuh',
                'option_b' => 'Perjalanan obat dalam tubuh (ADME)',
                'option_c' => 'Interaksi obat dengan reseptor',
                'option_d' => 'Mekanisme kerja obat',
                'correct_answer' => 'B',
                'explanation' => 'Farmakokinetik adalah perjalanan obat dalam tubuh meliputi Absorpsi, Distribusi, Metabolisme, dan Ekskresi (ADME)',
            ],
            [
                'question' => 'Organ utama yang berperan dalam metabolisme obat adalah?',
                'option_a' => 'Ginjal',
                'option_b' => 'Jantung',
                'option_c' => 'Hati',
                'option_d' => 'Paru-paru',
                'correct_answer' => 'C',
                'explanation' => 'Hati adalah organ utama metabolisme obat melalui enzim sitokrom P450',
            ],
            [
                'question' => 'Rute pemberian obat yang memberikan onset tercepat adalah?',
                'option_a' => 'Oral',
                'option_b' => 'Intravena (IV)',
                'option_c' => 'Intramuskular (IM)',
                'option_d' => 'Subkutan',
                'correct_answer' => 'B',
                'explanation' => 'Pemberian IV langsung masuk ke aliran darah sehingga memberikan onset paling cepat',
            ],
            [
                'question' => 'Bioavailabilitas obat oral biasanya lebih rendah karena?',
                'option_a' => 'Absorpsi yang buruk',
                'option_b' => 'Efek first-pass metabolism di hati',
                'option_c' => 'pH lambung',
                'option_d' => 'Semua benar',
                'correct_answer' => 'D',
                'explanation' => 'Bioavailabilitas oral dipengaruhi oleh absorpsi, first-pass metabolism, dan pH saluran cerna',
            ],
            [
                'question' => 'Obat golongan ACE inhibitor digunakan untuk mengobati?',
                'option_a' => 'Diabetes',
                'option_b' => 'Hipertensi',
                'option_c' => 'Asma',
                'option_d' => 'Gastritis',
                'correct_answer' => 'B',
                'explanation' => 'ACE inhibitor menghambat konversi angiotensin I menjadi angiotensin II sehingga menurunkan tekanan darah',
            ],
            [
                'question' => 'Obat yang termasuk antagonis reseptor H2 adalah?',
                'option_a' => 'Omeprazol',
                'option_b' => 'Ranitidin',
                'option_c' => 'Sukralfat',
                'option_d' => 'Antasida',
                'correct_answer' => 'B',
                'explanation' => 'Ranitidin adalah antagonis reseptor H2 yang mengurangi produksi asam lambung',
            ],
            [
                'question' => 'Volume distribusi obat yang besar menunjukkan bahwa obat?',
                'option_a' => 'Terdistribusi luas ke jaringan',
                'option_b' => 'Hanya di pembuluh darah',
                'option_c' => 'Tidak terdistribusi',
                'option_d' => 'Langsung diekskresi',
                'correct_answer' => 'A',
                'explanation' => 'Volume distribusi besar menunjukkan obat terdistribusi luas ke jaringan di luar pembuluh darah',
            ],
            [
                'question' => 'Waktu paruh (half-life) obat adalah?',
                'option_a' => 'Waktu obat mencapai konsentrasi maksimal',
                'option_b' => 'Waktu yang dibutuhkan untuk mengurangi konsentrasi obat menjadi setengahnya',
                'option_c' => 'Waktu obat mulai bekerja',
                'option_d' => 'Waktu obat selesai bekerja',
                'correct_answer' => 'B',
                'explanation' => 'Waktu paruh adalah waktu yang dibutuhkan untuk mengurangi konsentrasi plasma obat menjadi setengahnya',
            ],
        ], 45);

        // 2. FARMASI KLINIK
        $this->createQuizBank($order, $user, 'Farmasi Klinik', [
            [
                'question' => 'Apa yang dimaksud dengan Pharmaceutical Care?',
                'option_a' => 'Pelayanan farmasi di apotek',
                'option_b' => 'Tanggung jawab farmasis untuk mencapai outcome terapi optimal',
                'option_c' => 'Penjualan obat bebas',
                'option_d' => 'Pembuatan obat',
                'correct_answer' => 'B',
                'explanation' => 'Pharmaceutical care adalah tanggung jawab langsung farmasis dalam pelayanan terkait obat untuk mencapai outcome yang meningkatkan kualitas hidup pasien',
            ],
            [
                'question' => 'DRP (Drug Related Problem) yang paling sering terjadi adalah?',
                'option_a' => 'Obat tidak tersedia',
                'option_b' => 'Dosis tidak tepat',
                'option_c' => 'Ketidakpatuhan pasien (non-adherence)',
                'option_d' => 'Obat mahal',
                'correct_answer' => 'C',
                'explanation' => 'Non-adherence atau ketidakpatuhan pasien adalah DRP yang paling sering terjadi dan memengaruhi outcome terapi',
            ],
            [
                'question' => 'Monitoring efek samping antibiotik golongan aminoglikosida yang penting adalah?',
                'option_a' => 'Fungsi hati',
                'option_b' => 'Fungsi ginjal dan pendengaran',
                'option_c' => 'Fungsi jantung',
                'option_d' => 'Tekanan darah',
                'correct_answer' => 'B',
                'explanation' => 'Aminoglikosida bersifat nefrotoksik dan ototoksik, sehingga monitoring fungsi ginjal dan pendengaran sangat penting',
            ],
            [
                'question' => 'Interaksi obat warfarin dengan aspirin dapat menyebabkan?',
                'option_a' => 'Penurunan efek antikoagulan',
                'option_b' => 'Peningkatan risiko perdarahan',
                'option_c' => 'Tidak ada interaksi',
                'option_d' => 'Gangguan fungsi hati',
                'correct_answer' => 'B',
                'explanation' => 'Kombinasi warfarin dan aspirin meningkatkan risiko perdarahan karena efek antiplatelet aspirin',
            ],
            [
                'question' => 'Obat antidiabetes yang bekerja meningkatkan sekresi insulin adalah?',
                'option_a' => 'Metformin',
                'option_b' => 'Sulfonilurea',
                'option_c' => 'Acarbose',
                'option_d' => 'Pioglitazone',
                'correct_answer' => 'B',
                'explanation' => 'Sulfonilurea bekerja dengan merangsang sel beta pankreas untuk meningkatkan sekresi insulin',
            ],
            [
                'question' => 'Dalam terapi asma, obat yang digunakan untuk serangan akut adalah?',
                'option_a' => 'Kortikosteroid inhalasi',
                'option_b' => 'LABA (Long Acting Beta Agonist)',
                'option_c' => 'SABA (Short Acting Beta Agonist)',
                'option_d' => 'Teofilin',
                'correct_answer' => 'C',
                'explanation' => 'SABA seperti salbutamol adalah obat pilihan untuk meredakan serangan asma akut',
            ],
            [
                'question' => 'Konseling obat antibiotik yang penting disampaikan adalah?',
                'option_a' => 'Diminum hingga habis sesuai resep',
                'option_b' => 'Boleh dihentikan jika sudah merasa baik',
                'option_c' => 'Boleh disimpan untuk nanti',
                'option_d' => 'Boleh dibagi dengan orang lain',
                'correct_answer' => 'A',
                'explanation' => 'Antibiotik harus diminum hingga habis sesuai resep untuk mencegah resistensi',
            ],
        ], 45);

        // 3. FARMASETIKA
        $this->createQuizBank($order, $user, 'Farmasetika', [
            [
                'question' => 'Sediaan tablet yang tidak boleh digerus adalah?',
                'option_a' => 'Tablet biasa',
                'option_b' => 'Tablet salut enterik',
                'option_c' => 'Tablet effervescent',
                'option_d' => 'Tablet kunyah',
                'correct_answer' => 'B',
                'explanation' => 'Tablet salut enterik tidak boleh digerus karena akan merusak lapisan pelindung yang mencegah degradasi di lambung',
            ],
            [
                'question' => 'Zat tambahan yang berfungsi sebagai pengikat dalam tablet adalah?',
                'option_a' => 'Talk',
                'option_b' => 'Magnesium stearat',
                'option_c' => 'PVP (Povidone)',
                'option_d' => 'Aerosil',
                'correct_answer' => 'C',
                'explanation' => 'PVP (Povidone) adalah bahan pengikat yang umum digunakan dalam pembuatan tablet',
            ],
            [
                'question' => 'Metode sterilisasi yang paling baik untuk larutan injeksi adalah?',
                'option_a' => 'Sterilisasi kering',
                'option_b' => 'Autoklaf',
                'option_c' => 'Filtrasi',
                'option_d' => 'Radiasi',
                'correct_answer' => 'B',
                'explanation' => 'Autoklaf (sterilisasi uap panas basah) adalah metode paling efektif untuk sterilisasi larutan injeksi',
            ],
            [
                'question' => 'Basis salep yang bersifat hidrofilik adalah?',
                'option_a' => 'Vaselin',
                'option_b' => 'PEG (Polietilen glikol)',
                'option_c' => 'Adeps lanae',
                'option_d' => 'Cera alba',
                'correct_answer' => 'B',
                'explanation' => 'PEG adalah basis salep larut air yang bersifat hidrofilik dan mudah dicuci',
            ],
            [
                'question' => 'Suhu penyimpanan obat di cold chain adalah?',
                'option_a' => '0-4°C',
                'option_b' => '2-8°C',
                'option_c' => '8-15°C',
                'option_d' => '15-25°C',
                'correct_answer' => 'B',
                'explanation' => 'Cold chain untuk obat seperti vaksin harus disimpan pada suhu 2-8°C',
            ],
            [
                'question' => 'Emulsi tipe O/W (Oil in Water) dapat diidentifikasi dengan?',
                'option_a' => 'Mudah tercampur dengan air',
                'option_b' => 'Mudah tercampur dengan minyak',
                'option_c' => 'Tidak tercampur dengan air maupun minyak',
                'option_d' => 'Mengeras dalam air',
                'correct_answer' => 'A',
                'explanation' => 'Emulsi O/W memiliki fase luar air sehingga mudah tercampur atau diencerkan dengan air',
            ],
        ], 40);

        // 4. KIMIA FARMASI
        $this->createQuizBank($order, $user, 'Kimia Farmasi', [
            [
                'question' => 'Golongan obat antibiotik beta laktam adalah?',
                'option_a' => 'Tetrasiklin',
                'option_b' => 'Penisilin',
                'option_c' => 'Aminoglikosida',
                'option_d' => 'Makrolida',
                'correct_answer' => 'B',
                'explanation' => 'Penisilin termasuk golongan beta laktam yang memiliki cincin beta laktam dalam strukturnya',
            ],
            [
                'question' => 'Parasetamol termasuk golongan obat?',
                'option_a' => 'NSAID',
                'option_b' => 'Analgesik antipiretik',
                'option_c' => 'Opioid',
                'option_d' => 'Kortikosteroid',
                'correct_answer' => 'B',
                'explanation' => 'Parasetamol adalah analgesik antipiretik yang bekerja menghambat sintesis prostaglandin di SSP',
            ],
            [
                'question' => 'Obat yang termasuk golongan proton pump inhibitor (PPI) adalah?',
                'option_a' => 'Ranitidin',
                'option_b' => 'Omeprazol',
                'option_c' => 'Sukralfat',
                'option_d' => 'Antasida',
                'correct_answer' => 'B',
                'explanation' => 'Omeprazol adalah PPI yang menghambat pompa proton H+/K+ ATPase di sel parietal lambung',
            ],
            [
                'question' => 'Gugus farmakofora adalah?',
                'option_a' => 'Bagian molekul yang tidak aktif',
                'option_b' => 'Bagian molekul yang bertanggung jawab terhadap aktivitas farmakologi',
                'option_c' => 'Zat pembawa obat',
                'option_d' => 'Metabolit obat',
                'correct_answer' => 'B',
                'explanation' => 'Farmakofora adalah bagian molekul yang bertanggung jawab langsung terhadap aktivitas farmakologi obat',
            ],
            [
                'question' => 'Uji identifikasi aspirin menggunakan pereaksi?',
                'option_a' => 'FeCl3',
                'option_b' => 'H2SO4',
                'option_c' => 'NaOH',
                'option_d' => 'HCl',
                'correct_answer' => 'A',
                'explanation' => 'Aspirin dapat diidentifikasi dengan FeCl3 yang memberikan warna ungu',
            ],
            [
                'question' => 'Obat golongan statin bekerja dengan cara?',
                'option_a' => 'Menghambat absorpsi kolesterol',
                'option_b' => 'Menghambat HMG-CoA reduktase',
                'option_c' => 'Meningkatkan ekskresi kolesterol',
                'option_d' => 'Mengikat asam empedu',
                'correct_answer' => 'B',
                'explanation' => 'Statin bekerja dengan menghambat enzim HMG-CoA reduktase dalam sintesis kolesterol',
            ],
        ], 40);

        // 5. FARMAKOGNOSI
        $this->createQuizBank($order, $user, 'Farmakognosi', [
            [
                'question' => 'Alkaloid kafein banyak terdapat pada tanaman?',
                'option_a' => 'Jahe',
                'option_b' => 'Kopi dan teh',
                'option_c' => 'Kunyit',
                'option_d' => 'Sirih',
                'correct_answer' => 'B',
                'explanation' => 'Kafein adalah alkaloid yang banyak terdapat pada biji kopi dan daun teh',
            ],
            [
                'question' => 'Senyawa kurkumin yang berkhasiat sebagai antiinflamasi terdapat pada?',
                'option_a' => 'Temulawak',
                'option_b' => 'Kunyit',
                'option_c' => 'Jahe',
                'option_d' => 'Lengkuas',
                'correct_answer' => 'B',
                'explanation' => 'Kurkumin adalah senyawa aktif utama dalam kunyit yang memiliki efek antiinflamasi',
            ],
            [
                'question' => 'Metode ekstraksi yang paling sederhana adalah?',
                'option_a' => 'Destilasi',
                'option_b' => 'Kromatografi',
                'option_c' => 'Maserasi',
                'option_d' => 'Soxhletasi',
                'correct_answer' => 'C',
                'explanation' => 'Maserasi adalah metode ekstraksi paling sederhana dengan merendam simplisia dalam pelarut pada suhu ruang',
            ],
            [
                'question' => 'Tanaman yang mengandung glikosida jantung adalah?',
                'option_a' => 'Digitalis',
                'option_b' => 'Sambiloto',
                'option_c' => 'Daun salam',
                'option_d' => 'Sirih',
                'correct_answer' => 'A',
                'explanation' => 'Digitalis purpurea mengandung glikosida jantung seperti digoksin yang digunakan untuk gagal jantung',
            ],
            [
                'question' => 'Simplisia adalah?',
                'option_a' => 'Obat jadi',
                'option_b' => 'Bahan obat yang belum mengalami pengolahan',
                'option_c' => 'Bahan baku obat yang telah dikeringkan',
                'option_d' => 'Ekstrak tanaman',
                'correct_answer' => 'C',
                'explanation' => 'Simplisia adalah bahan alamiah yang digunakan sebagai obat dan belum mengalami pengolahan apapun kecuali pengeringan',
            ],
            [
                'question' => 'Senyawa gingerol yang memberikan rasa pedas terdapat pada?',
                'option_a' => 'Kunyit',
                'option_b' => 'Jahe',
                'option_c' => 'Lengkuas',
                'option_d' => 'Temulawak',
                'correct_answer' => 'B',
                'explanation' => 'Gingerol adalah senyawa aktif dalam jahe yang memberikan rasa pedas dan berkhasiat antiinflamasi',
            ],
        ], 35);

        $this->command->info("  ✓ Selesai membuat 5 quiz bank UKOM");
    }

    private function seedCpnsQuizzes($order, $user)
    {
        // 1. TWK (Tes Wawasan Kebangsaan)
        $this->createQuizBank($order, $user, 'TWK', [
            [
                'question' => 'Pancasila disahkan sebagai dasar negara pada tanggal?',
                'option_a' => '17 Agustus 1945',
                'option_b' => '18 Agustus 1945',
                'option_c' => '1 Juni 1945',
                'option_d' => '22 Juni 1945',
                'correct_answer' => 'B',
                'explanation' => 'Pancasila disahkan sebagai dasar negara pada 18 Agustus 1945 oleh PPKI',
            ],
            [
                'question' => 'Lembaga negara yang berwenang mengubah UUD 1945 adalah?',
                'option_a' => 'DPR',
                'option_b' => 'Presiden',
                'option_c' => 'MPR',
                'option_d' => 'MA',
                'correct_answer' => 'C',
                'explanation' => 'MPR memiliki wewenang untuk mengubah dan menetapkan Undang-Undang Dasar',
            ],
            [
                'question' => 'Makna dari sila Kemanusiaan yang Adil dan Beradab adalah?',
                'option_a' => 'Mengakui persamaan derajat, hak, dan kewajiban',
                'option_b' => 'Mengutamakan kepentingan pribadi',
                'option_c' => 'Mengutamakan suku tertentu',
                'option_d' => 'Mementingkan golongan',
                'correct_answer' => 'A',
                'explanation' => 'Sila kedua menekankan pengakuan terhadap persamaan derajat, hak, dan kewajiban setiap manusia',
            ],
            [
                'question' => 'Bhinneka Tunggal Ika terdapat dalam kitab?',
                'option_a' => 'Sutasoma',
                'option_b' => 'Negarakertagama',
                'option_c' => 'Arjunawiwaha',
                'option_d' => 'Ramayana',
                'correct_answer' => 'A',
                'explanation' => 'Semboyan Bhinneka Tunggal Ika berasal dari kitab Sutasoma karya Mpu Tantular',
            ],
            [
                'question' => 'Sistem pemerintahan Indonesia adalah?',
                'option_a' => 'Parlementer',
                'option_b' => 'Presidensial',
                'option_c' => 'Monarki',
                'option_d' => 'Federal',
                'correct_answer' => 'B',
                'explanation' => 'Indonesia menganut sistem pemerintahan presidensial dimana presiden sebagai kepala negara dan kepala pemerintahan',
            ],
            [
                'question' => 'Dasar hukum pembentukan peraturan perundang-undangan di Indonesia adalah?',
                'option_a' => 'UU No. 10 Tahun 2004',
                'option_b' => 'UU No. 12 Tahun 2011',
                'option_c' => 'UU No. 14 Tahun 2008',
                'option_d' => 'UU No. 15 Tahun 2019',
                'correct_answer' => 'B',
                'explanation' => 'UU No. 12 Tahun 2011 tentang Pembentukan Peraturan Perundang-undangan',
            ],
            [
                'question' => 'Makna sila Persatuan Indonesia adalah?',
                'option_a' => 'Mengutamakan kepentingan golongan',
                'option_b' => 'Menempatkan kesatuan, persatuan di atas kepentingan pribadi',
                'option_c' => 'Mementingkan suku sendiri',
                'option_d' => 'Memisahkan diri dari negara',
                'correct_answer' => 'B',
                'explanation' => 'Sila ketiga menekankan pentingnya menempatkan kepentingan bangsa di atas kepentingan pribadi dan golongan',
            ],
        ], 30);

        // 2. TIU (Tes Intelegensia Umum)
        $this->createQuizBank($order, $user, 'TIU', [
            [
                'question' => 'Antonim dari kata HARMONIS adalah?',
                'option_a' => 'Selaras',
                'option_b' => 'Serasi',
                'option_c' => 'Konflik',
                'option_d' => 'Seirama',
                'correct_answer' => 'C',
                'explanation' => 'Antonim (lawan kata) dari harmonis adalah konflik',
            ],
            [
                'question' => 'Jika 2x + 3 = 11, maka nilai x adalah?',
                'option_a' => '3',
                'option_b' => '4',
                'option_c' => '5',
                'option_d' => '6',
                'correct_answer' => 'B',
                'explanation' => '2x + 3 = 11, maka 2x = 8, sehingga x = 4',
            ],
            [
                'question' => 'Melanjutkan deret: 2, 4, 8, 16, ...?',
                'option_a' => '24',
                'option_b' => '28',
                'option_c' => '32',
                'option_d' => '36',
                'correct_answer' => 'C',
                'explanation' => 'Pola deret adalah dikali 2, sehingga 16 x 2 = 32',
            ],
            [
                'question' => 'Sinonim dari kata KOMPETEN adalah?',
                'option_a' => 'Bodoh',
                'option_b' => 'Cakap',
                'option_c' => 'Malas',
                'option_d' => 'Lemah',
                'correct_answer' => 'B',
                'explanation' => 'Sinonim (persamaan kata) dari kompeten adalah cakap atau mahir',
            ],
            [
                'question' => 'Sebuah mobil menempuh jarak 120 km dalam waktu 2 jam. Kecepatan rata-ratanya adalah?',
                'option_a' => '50 km/jam',
                'option_b' => '60 km/jam',
                'option_c' => '70 km/jam',
                'option_d' => '80 km/jam',
                'correct_answer' => 'B',
                'explanation' => 'Kecepatan = Jarak / Waktu = 120 km / 2 jam = 60 km/jam',
            ],
            [
                'question' => 'Jika A > B dan B > C, maka?',
                'option_a' => 'A < C',
                'option_b' => 'A = C',
                'option_c' => 'A > C',
                'option_d' => 'Tidak dapat ditentukan',
                'correct_answer' => 'C',
                'explanation' => 'Hubungan transitif: jika A > B dan B > C, maka A > C',
            ],
            [
                'question' => 'Lanjutkan: Senin, Rabu, Jumat, ...?',
                'option_a' => 'Sabtu',
                'option_b' => 'Minggu',
                'option_c' => 'Kamis',
                'option_d' => 'Selasa',
                'correct_answer' => 'B',
                'explanation' => 'Pola deret melompat satu hari, maka setelah Jumat adalah Minggu',
            ],
        ], 30);

        // 3. TKP (Tes Karakteristik Pribadi)
        $this->createQuizBank($order, $user, 'TKP', [
            [
                'question' => 'Ketika mendapat tugas yang sulit, sikap Anda adalah?',
                'option_a' => 'Mengeluh dan menyerah',
                'option_b' => 'Meminta orang lain mengerjakan',
                'option_c' => 'Berusaha semaksimal mungkin dan belajar dari kesulitan',
                'option_d' => 'Mengabaikan tugas tersebut',
                'correct_answer' => 'C',
                'explanation' => 'Sikap positif adalah berusaha maksimal dan menjadikan kesulitan sebagai pembelajaran',
            ],
            [
                'question' => 'Anda melihat rekan kerja melakukan kesalahan. Apa yang Anda lakukan?',
                'option_a' => 'Membiarkan saja',
                'option_b' => 'Melaporkan langsung ke atasan',
                'option_c' => 'Mengingatkan secara baik-baik',
                'option_d' => 'Menyebarkan ke rekan lain',
                'correct_answer' => 'C',
                'explanation' => 'Sikap yang baik adalah mengingatkan rekan dengan cara yang sopan dan konstruktif',
            ],
            [
                'question' => 'Bagaimana Anda menghadapi kritik dari atasan?',
                'option_a' => 'Marah dan membela diri',
                'option_b' => 'Menerima dan memperbaiki',
                'option_c' => 'Mengabaikan',
                'option_d' => 'Membalas dengan kritik',
                'correct_answer' => 'B',
                'explanation' => 'Kritik yang membangun harus diterima dengan lapang dada dan dijadikan bahan perbaikan',
            ],
            [
                'question' => 'Ketika ada konflik dalam tim, Anda akan?',
                'option_a' => 'Memihak salah satu pihak',
                'option_b' => 'Membiarkan saja',
                'option_c' => 'Memediasi dan mencari solusi bersama',
                'option_d' => 'Keluar dari tim',
                'correct_answer' => 'C',
                'explanation' => 'Pemimpin yang baik mampu memediasi konflik dan mencari solusi yang menguntungkan semua pihak',
            ],
            [
                'question' => 'Anda diminta menyelesaikan pekerjaan dengan deadline ketat. Anda akan?',
                'option_a' => 'Menolak karena waktu terlalu singkat',
                'option_b' => 'Menerima dan menyusun prioritas dengan baik',
                'option_c' => 'Menerima tapi mengerjakan asal-asalan',
                'option_d' => 'Meminta perpanjangan waktu',
                'correct_answer' => 'B',
                'explanation' => 'Profesionalisme ditunjukkan dengan menerima tantangan dan mengatur prioritas dengan efektif',
            ],
            [
                'question' => 'Rekan kerja Anda meminta bantuan saat Anda sedang sibuk, Anda akan?',
                'option_a' => 'Menolak mentah-mentah',
                'option_b' => 'Membantu setelah pekerjaan sendiri selesai',
                'option_c' => 'Marah karena diganggu',
                'option_d' => 'Mengabaikannya',
                'correct_answer' => 'B',
                'explanation' => 'Keseimbangan antara tanggung jawab pribadi dan membantu rekan adalah sikap profesional',
            ],
        ], 25);

        // 4. Bidang Farmasi (Khusus CPNS Farmasi)
        $this->createQuizBank($order, $user, 'Bidang Farmasi', [
            [
                'question' => 'Tugas pokok apoteker di Puskesmas adalah?',
                'option_a' => 'Hanya meracik obat',
                'option_b' => 'Pengelolaan obat dan pelayanan farmasi klinik',
                'option_c' => 'Menjual obat bebas',
                'option_d' => 'Administrasi saja',
                'correct_answer' => 'B',
                'explanation' => 'Apoteker di Puskesmas bertanggung jawab atas pengelolaan obat dan memberikan pelayanan farmasi klinik',
            ],
            [
                'question' => 'Program pemerintah untuk menjamin ketersediaan obat esensial adalah?',
                'option_a' => 'BPJS',
                'option_b' => 'Fornas (Formularium Nasional)',
                'option_c' => 'JKN',
                'option_d' => 'UHC',
                'correct_answer' => 'B',
                'explanation' => 'Fornas adalah daftar obat esensial yang menjadi pedoman pengadaan dan pelayanan obat di fasilitas kesehatan',
            ],
            [
                'question' => 'Standar pelayanan kefarmasian di apotek diatur dalam?',
                'option_a' => 'UU Kesehatan',
                'option_b' => 'Permenkes No. 73 Tahun 2016',
                'option_c' => 'PP Kefarmasian',
                'option_d' => 'UU Praktik Farmasi',
                'correct_answer' => 'B',
                'explanation' => 'Standar pelayanan kefarmasian di apotek diatur dalam Permenkes No. 73 Tahun 2016',
            ],
            [
                'question' => 'Obat narkotika dan psikotropika harus disimpan dalam?',
                'option_a' => 'Lemari biasa',
                'option_b' => 'Lemari khusus berkunci ganda',
                'option_c' => 'Kulkas',
                'option_d' => 'Rak terbuka',
                'correct_answer' => 'B',
                'explanation' => 'Obat narkotika dan psikotropika harus disimpan dalam lemari khusus dengan kunci ganda untuk keamanan',
            ],
            [
                'question' => 'Sistem pencatatan obat yang menggunakan prinsip "masuk pertama, keluar pertama" disebut?',
                'option_a' => 'LIFO',
                'option_b' => 'FIFO',
                'option_c' => 'ABC',
                'option_d' => 'VEN',
                'correct_answer' => 'B',
                'explanation' => 'FIFO (First In First Out) adalah sistem dimana obat yang masuk pertama harus dikeluarkan pertama',
            ],
            [
                'question' => 'Dalam pengelolaan obat di Puskesmas, sistem ABC analysis digunakan untuk?',
                'option_a' => 'Mengklasifikasi obat berdasarkan harga',
                'option_b' => 'Mengklasifikasi obat berdasarkan nilai investasi',
                'option_c' => 'Mengklasifikasi obat berdasarkan efek samping',
                'option_d' => 'Mengklasifikasi obat berdasarkan warna',
                'correct_answer' => 'B',
                'explanation' => 'ABC analysis mengklasifikasikan obat berdasarkan nilai investasi: A (nilai tinggi), B (sedang), C (rendah)',
            ],
            [
                'question' => 'Peran apoteker dalam tim kesehatan adalah?',
                'option_a' => 'Hanya menyiapkan obat',
                'option_b' => 'Memberikan konsultasi terapi obat dan monitoring',
                'option_c' => 'Mengobati pasien',
                'option_d' => 'Mendiagnosis penyakit',
                'correct_answer' => 'B',
                'explanation' => 'Apoteker berperan memberikan konsultasi terapi obat, monitoring efektivitas dan keamanan obat dalam tim kesehatan',
            ],
        ], 35);

        $this->command->info("  ✓ Selesai membuat 4 quiz bank CPNS");
    }

    private function createQuizBank($order, $user, $category, $questions, $duration = 30)
    {
        $quiz = QuizBank::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'program_id' => $order->program_id,
            'title' => 'Latihan Soal ' . $category,
            'description' => 'Bank soal ' . $category . ' untuk persiapan ujian',
            'category' => $category,
            'total_questions' => count($questions),
            'duration_minutes' => $duration,
            'passing_score' => 70,
        ]);

        foreach ($questions as $q) {
            QuizQuestion::create(array_merge(['quiz_bank_id' => $quiz->id], $q));
        }

        $this->command->line("    → Quiz {$category}: " . count($questions) . " soal");
    }
}

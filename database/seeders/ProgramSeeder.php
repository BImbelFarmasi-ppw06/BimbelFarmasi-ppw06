<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            // ========== BIMBEL UKOM PACKAGES ==========
            [
                'name' => 'Bimbel UKOM D3 Farmasi - Reguler',
                'slug' => 'bimbel-ukom-d3-farmasi',
                'type' => 'bimbel',
                'description' => 'Program bimbingan belajar intensif untuk persiapan UKOM D3 Farmasi dengan materi lengkap dan try out berkala.',
                'features' => [
                    'Materi lengkap sesuai kisi-kisi UKOM terbaru',
                    'Try out mingguan dengan pembahasan detail',
                    'Konsultasi langsung dengan mentor berpengalaman',
                    'Video pembelajaran on-demand',
                    'Bank soal 1000+ pertanyaan',
                    'Grup diskusi eksklusif',
                    'Sertifikat kelulusan',
                    'Akses e-learning 24/7',
                ],
                'price' => 1250000,
                'duration_months' => 3,
                'total_sessions' => 24,
                'is_active' => true,
            ],
            [
                'name' => 'Bimbel UKOM D3 Farmasi - Intensif',
                'slug' => 'bimbel-ukom-intensif',
                'type' => 'bimbel',
                'description' => 'Program bimbingan belajar super intensif dengan jadwal padat dan materi mendalam untuk hasil maksimal.',
                'features' => [
                    'Semua benefit paket Reguler',
                    'Pertemuan lebih sering (4x seminggu)',
                    'Konsultasi private 1-on-1',
                    'Materi tambahan dan soal prediksi',
                    'Pembahasan soal eksklusif',
                    'Prioritas tanya jawab',
                ],
                'price' => 1850000,
                'duration_months' => 3,
                'total_sessions' => 36,
                'is_active' => true,
            ],
            [
                'name' => 'Bimbel UKOM D3 Farmasi - Express',
                'slug' => 'bimbel-ukom-express',
                'type' => 'bimbel',
                'description' => 'Paket singkat untuk persiapan kilat menjelang ujian UKOM.',
                'features' => [
                    'Ringkasan materi penting',
                    'Try out intensif',
                    'Tips dan trik menjawab soal',
                    'Bank soal prediksi terbaru',
                    'Konsultasi grup online',
                ],
                'price' => 750000,
                'duration_months' => 1,
                'total_sessions' => 12,
                'is_active' => true,
            ],

            // ========== CPNS & P3K PACKAGES ==========
            [
                'name' => 'CPNS & P3K Farmasi - Paket Lengkap',
                'slug' => 'cpns-p3k-farmasi',
                'type' => 'cpns',
                'description' => 'Persiapan lengkap untuk menghadapi tes CPNS dan P3K bidang farmasi dengan materi TWK, TIU, TKP, dan farmasi.',
                'features' => [
                    'Materi TWK, TIU, TKP lengkap',
                    'Materi khusus bidang farmasi',
                    'Try out CAT system',
                    'Pembahasan soal interaktif',
                    'Prediksi soal berdasarkan trend',
                    'Konsultasi strategi belajar',
                    'Update informasi CPNS/P3K terbaru',
                    'Simulasi wawancara',
                    'E-book dan modul eksklusif',
                ],
                'price' => 1750000,
                'duration_months' => 4,
                'total_sessions' => 32,
                'is_active' => true,
            ],
            [
                'name' => 'CPNS & P3K Farmasi - Paket SKD Fokus',
                'slug' => 'cpns-p3k-skd',
                'type' => 'cpns',
                'description' => 'Fokus persiapan SKD (TWK, TIU, TKP) dengan strategi jitu untuk mendapatkan skor tinggi.',
                'features' => [
                    'Materi TWK, TIU, TKP mendalam',
                    'Try out CAT system mingguan',
                    'Pembahasan detail setiap soal',
                    'Strategi time management',
                    'Bank soal 2000+ pertanyaan',
                    'Video pembelajaran SKD',
                    'Konsultasi strategi belajar',
                ],
                'price' => 1450000,
                'duration_months' => 3,
                'total_sessions' => 24,
                'is_active' => true,
            ],
            [
                'name' => 'CPNS & P3K Farmasi - Paket SKB Farmasi',
                'slug' => 'cpns-p3k-skb',
                'type' => 'cpns',
                'description' => 'Khusus persiapan SKB bidang farmasi dengan materi spesifik dan soal-soal prediksi.',
                'features' => [
                    'Materi farmasi komprehensif',
                    'Soal-soal SKB farmasi tahun lalu',
                    'Prediksi soal terbaru',
                    'Pembahasan kasus farmasi',
                    'Try out SKB farmasi',
                    'E-book materi farmasi',
                    'Konsultasi dengan apoteker berpengalaman',
                ],
                'price' => 1250000,
                'duration_months' => 2,
                'total_sessions' => 16,
                'is_active' => true,
            ],

            // ========== JOKI TUGAS PACKAGES ==========
            [
                'name' => 'Joki Tugas Farmasi - Basic',
                'slug' => 'joki-tugas-farmasi',
                'type' => 'joki',
                'description' => 'Layanan bantuan pengerjaan tugas kuliah farmasi oleh ahli berpengalaman dengan jaminan kualitas terbaik.',
                'features' => [
                    'Dikerjakan oleh ahli farmasi berpengalaman',
                    'Plagiarism check dijamin lolos',
                    'Revisi unlimited hingga puas',
                    'On-time delivery guarantee',
                    'Konsultasi materi gratis',
                    'Referensi jurnal terpercaya',
                    'Format sesuai kampus',
                    'Confidential & aman',
                ],
                'price' => 500000,
                'duration_months' => 0,
                'total_sessions' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Joki Tugas Farmasi - Premium',
                'slug' => 'joki-tugas-premium',
                'type' => 'joki',
                'description' => 'Paket premium untuk tugas-tugas besar seperti skripsi, tesis, atau jurnal ilmiah.',
                'features' => [
                    'Semua benefit paket Basic',
                    'Prioritas pengerjaan',
                    'Konsultasi intensif dengan ahli',
                    'Bantuan presentasi',
                    'Simulasi sidang',
                    'Pendampingan revisi dosen',
                    'Garansi hingga lulus sidang',
                ],
                'price' => 2500000,
                'duration_months' => 0,
                'total_sessions' => 0,
                'is_active' => true,
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}

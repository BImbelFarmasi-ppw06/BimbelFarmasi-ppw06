<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use App\Models\User;
use App\Models\Program;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample users if they don't exist
        $users = [];
        
        $users[] = User::firstOrCreate(
            ['email' => 'dewi.lestari@example.com'],
            [
                'name' => 'Dewi Lestari',
                'password' => bcrypt('password123'),
                'phone' => '081234567890',
            ]
        );

        $users[] = User::firstOrCreate(
            ['email' => 'budi.santoso@example.com'],
            [
                'name' => 'Budi Santoso',
                'password' => bcrypt('password123'),
                'phone' => '081234567891',
            ]
        );

        $users[] = User::firstOrCreate(
            ['email' => 'siti.nurhaliza@example.com'],
            [
                'name' => 'Siti Nurhaliza',
                'password' => bcrypt('password123'),
                'phone' => '081234567892',
            ]
        );

        $users[] = User::firstOrCreate(
            ['email' => 'ahmad.fauzi@example.com'],
            [
                'name' => 'Ahmad Fauzi',
                'password' => bcrypt('password123'),
                'phone' => '081234567893',
            ]
        );

        $users[] = User::firstOrCreate(
            ['email' => 'rina.wijaya@example.com'],
            [
                'name' => 'Rina Wijaya',
                'password' => bcrypt('password123'),
                'phone' => '081234567894',
            ]
        );

        // Get programs
        $programs = Program::all();
        
        if ($programs->isEmpty()) {
            $this->command->warn('No programs found. Please run ProgramSeeder first.');
            return;
        }

        // Sample testimonials data
        $testimonials = [
            [
                'user_index' => 0,
                'program_slug' => 'bimbel-ukom-d3-farmasi',
                'rating' => 5,
                'comment' => 'Alhamdulillah berkat bimbel ini saya lulus UKOM dengan nilai memuaskan! Materinya sangat lengkap dan mudah dipahami. Mentor-mentornya juga sangat sabar dalam menjawab pertanyaan. Highly recommended!',
                'is_approved' => true,
            ],
            [
                'user_index' => 1,
                'program_slug' => 'cpns-p3k-farmasi',
                'rating' => 5,
                'comment' => 'Program yang sangat membantu dalam persiapan CPNS/P3K. Soal-soal try out sangat mirip dengan soal aslinya. Terima kasih atas bimbingannya, akhirnya lolos seleksi!',
                'is_approved' => true,
            ],
            [
                'user_index' => 2,
                'program_slug' => 'bimbel-ukom-intensif',
                'rating' => 4,
                'comment' => 'Bimbel yang worth it banget! Jadwalnya intensif tapi hasilnya sebanding. Video pembelajarannya bisa diakses kapan saja jadi sangat fleksibel untuk yang kerja sambil belajar.',
                'is_approved' => true,
            ],
            [
                'user_index' => 3,
                'program_slug' => 'joki-tugas-farmasi',
                'rating' => 5,
                'comment' => 'Pelayanan sangat cepat dan profesional. Tugas dikerjakan dengan detail dan tepat waktu. Nilai yang saya dapat juga memuaskan. Terima kasih banyak!',
                'is_approved' => true,
            ],
            [
                'user_index' => 4,
                'program_slug' => 'cpns-p3k-skb',
                'rating' => 5,
                'comment' => 'Materi SKB sangat komprehensif. Bank soalnya update terus sesuai perkembangan terbaru. Sistem belajarnya terstruktur jadi mudah dipahami dari dasar. Sukses terus!',
                'is_approved' => true,
            ],
            [
                'user_index' => 0,
                'program_slug' => 'joki-tugas-premium',
                'rating' => 4,
                'comment' => 'Hasil skripsi nya rapi dan sesuai format. Revisi juga dibantu sampai selesai. Sangat membantu di saat deadline mepet. Recommended!',
                'is_approved' => true,
            ],
            [
                'user_index' => 2,
                'program_slug' => 'bimbel-ukom-express',
                'rating' => 5,
                'comment' => 'Paket express yang sangat efektif! Meskipun singkat tapi materinya padat dan fokus ke yang penting. Cocok untuk persiapan kilat sebelum ujian.',
                'is_approved' => true,
            ],
            [
                'user_index' => 1,
                'program_slug' => 'cpns-p3k-farmasi',
                'rating' => 4,
                'comment' => 'Pembahasan try out sangat detail. Setiap soal dijelaskan sampai paham. Grup diskusinya juga aktif, bisa tanya jawab kapan saja.',
                'is_approved' => true,
            ],
            [
                'user_index' => 3,
                'program_slug' => 'bimbel-ukom-d3-farmasi',
                'rating' => 5,
                'comment' => 'Materi UKOM nya update dan sesuai dengan ujian sebenarnya. Sistem belajarnya juga fleksibel, cocok buat yang masih kuliah. Terima kasih sudah membantu saya lulus!',
                'is_approved' => true,
            ],
            [
                'user_index' => 4,
                'program_slug' => 'joki-tugas-premium',
                'rating' => 5,
                'comment' => 'Kualitas pengerjaan sangat bagus! Referensi lengkap, format rapi, dan bahasa akademiknya bagus. Dosen saya sampai kasih nilai A. Worth every penny!',
                'is_approved' => true,
            ],
            [
                'user_index' => 0,
                'program_slug' => 'cpns-p3k-skd',
                'rating' => 4,
                'comment' => 'Latihan soal-soalnya banyak dan bervariasi. Teknik cepat yang diajarkan sangat membantu saat ujian. Alhamdulillah lulus seleksi administrasi dan SKD.',
                'is_approved' => true,
            ],
            [
                'user_index' => 1,
                'program_slug' => 'bimbel-ukom-intensif',
                'rating' => 5,
                'comment' => 'Program intensif yang benar-benar intensif! Materi dikupas tuntas, latihan soal setiap hari, dan mentor selalu siap membantu. Recommended untuk yang mau hasil maksimal!',
                'is_approved' => true,
            ],
            [
                'user_index' => 2,
                'program_slug' => 'joki-tugas-farmasi',
                'rating' => 4,
                'comment' => 'Pengerjaan cepat dan hasilnya memuaskan. Admin responsif dan helpful. Harga juga masih terjangkau untuk mahasiswa. Terima kasih!',
                'is_approved' => true,
            ],
            [
                'user_index' => 3,
                'program_slug' => 'cpns-p3k-skb',
                'rating' => 5,
                'comment' => 'Materi SKB Farmasi sangat lengkap dan mendalam. Simulasi wawancara juga sangat membantu. Alhamdulillah sekarang sudah PNS!',
                'is_approved' => true,
            ],
            [
                'user_index' => 4,
                'program_slug' => 'bimbel-ukom-express',
                'rating' => 5,
                'comment' => 'Paket kilat yang sangat efisien! Fokus ke materi penting dan tips menjawab soal. Cocok banget buat yang waktunya mepet. Terima kasih!',
                'is_approved' => true,
            ],
        ];

        // Create orders, payments, and testimonials
        foreach ($testimonials as $testimoniData) {
            $user = $users[$testimoniData['user_index']];
            $program = $programs->where('slug', $testimoniData['program_slug'])->first();

            if (!$program) {
                continue;
            }

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'program_id' => $program->id,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'amount' => $program->price,
                'status' => 'completed',
            ]);

            // Create payment
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'transfer_bank',
                'amount' => $program->price,
                'status' => 'verified',
                'proof_url' => 'payment-proofs/sample-proof.jpg',
                'notes' => 'Pembayaran terverifikasi',
            ]);

            // Create testimonial
            Testimonial::create([
                'user_id' => $user->id,
                'program_id' => $program->id,
                'order_id' => $order->id,
                'rating' => $testimoniData['rating'],
                'comment' => $testimoniData['comment'],
                'is_approved' => $testimoniData['is_approved'],
            ]);
        }

        $this->command->info('Testimonials seeded successfully!');
    }
}

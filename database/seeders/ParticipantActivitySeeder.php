<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Program;
use App\Models\QuizBank;
use App\Models\QuizAttempt;
use Carbon\Carbon;

class ParticipantActivitySeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('👥 Memulai seeding aktivitas peserta...');

        // Buat 10 peserta dengan program berbeda-beda
        $participants = [
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@bimbelfarmasi.com',
                'phone' => '081234567890',
                'programs' => ['Bimbel UKOM D3 Farmasi - Reguler'], 
                'activity_level' => 'high',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@bimbelfarmasi.com',
                'phone' => '081234567891',
                'programs' => ['Bimbel UKOM D3 Farmasi - Intensif'],
                'activity_level' => 'medium',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@bimbelfarmasi.com',
                'phone' => '081234567892',
                'programs' => ['CPNS & P3K Farmasi - Paket Lengkap'],
                'activity_level' => 'high',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@bimbelfarmasi.com',
                'phone' => '081234567893',
                'programs' => ['Bimbel UKOM D3 Farmasi - Express'],
                'activity_level' => 'low',
            ],
            [
                'name' => 'Raka Prasetyo',
                'email' => 'raka.prasetyo@bimbelfarmasi.com',
                'phone' => '081234567894',
                'programs' => ['CPNS & P3K Farmasi - Paket SKD Fokus'],
                'activity_level' => 'medium',
            ],
            [
                'name' => 'Fitri Rahmawati',
                'email' => 'fitri.rahmawati@bimbelfarmasi.com',
                'phone' => '081234567895',
                'programs' => ['Bimbel UKOM D3 Farmasi - Reguler', 'CPNS & P3K Farmasi - Paket Lengkap'],
                'activity_level' => 'high',
            ],
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi.wijaya@bimbelfarmasi.com',
                'phone' => '081234567896',
                'programs' => ['CPNS & P3K Farmasi - Paket SKB Farmasi'],
                'activity_level' => 'medium',
            ],
            [
                'name' => 'Putri Anggraini',
                'email' => 'putri.anggraini@bimbelfarmasi.com',
                'phone' => '081234567897',
                'programs' => ['Bimbel UKOM D3 Farmasi - Intensif', 'CPNS & P3K Farmasi - Paket SKD Fokus'],
                'activity_level' => 'high',
            ],
            [
                'name' => 'Deni Kurniawan',
                'email' => 'deni.kurniawan@bimbelfarmasi.com',
                'phone' => '081234567898',
                'programs' => ['Bimbel UKOM D3 Farmasi - Express'],
                'activity_level' => 'low',
            ],
            [
                'name' => 'Mega Kusuma',
                'email' => 'mega.kusuma@bimbelfarmasi.com',
                'phone' => '081234567899',
                'programs' => ['CPNS & P3K Farmasi - Paket Lengkap', 'Bimbel UKOM D3 Farmasi - Reguler'],
                'activity_level' => 'medium',
            ],
        ];

        foreach ($participants as $participantData) {
            $this->command->info("📝 Membuat aktivitas untuk: {$participantData['name']}");
            
            // Cek apakah user sudah ada
            $user = User::where('email', $participantData['email'])->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $participantData['name'],
                    'email' => $participantData['email'],
                    'password' => bcrypt('password'),
                    'phone' => $participantData['phone'],
                    'is_admin' => false,
                ]);
            }

            foreach ($participantData['programs'] as $programName) {
                // Ambil program berdasarkan nama
                $program = Program::where('name', $programName)->first();
                
                if (!$program) continue;

                // Buat order
                $createdAt = Carbon::now()->subDays(rand(7, 30));
                $order = Order::create([
                    'order_number' => 'ORD-' . strtoupper(uniqid()),
                    'user_id' => $user->id,
                    'program_id' => $program->id,
                    'amount' => $program->price,
                    'status' => 'completed',
                    'notes' => 'Order untuk seeder aktivitas peserta',
                    'created_at' => $createdAt,
                ]);

                // Buat payment untuk order ini
                Payment::create([
                    'order_id' => $order->id,
                    'amount' => $program->price,
                    'payment_method' => 'bank_transfer',
                    'status' => 'paid',
                    'proof_url' => 'seeder/payment_proof_' . $order->order_number . '.jpg',
                    'paid_at' => $createdAt->copy()->addHours(rand(1, 24)),
                    'notes' => 'Pembayaran seeder aktivitas peserta',
                    'created_at' => $createdAt,
                ]);

                $this->command->line("  → Terdaftar di: {$program->name}");

                // Ambil quiz banks untuk program ini
                $quizBanks = QuizBank::where('program_id', $program->id)->get();

                if ($quizBanks->isEmpty()) continue;

                // Buat aktivitas quiz berdasarkan level
                $this->createQuizActivity($user, $quizBanks, $participantData['activity_level']);
            }
        }

        $this->command->info('✅ Seeding aktivitas peserta selesai!');
        $this->command->info('📊 Data siap untuk ditampilkan di dashboard admin');
    }

    private function createQuizActivity($user, $quizBanks, $activityLevel)
    {
        // Tentukan berapa banyak quiz yang dikerjakan berdasarkan activity level
        $quizToComplete = match($activityLevel) {
            'high' => min(count($quizBanks), rand(8, 12)), // Kerjakan banyak
            'medium' => min(count($quizBanks), rand(4, 7)), // Sedang
            'low' => min(count($quizBanks), rand(1, 3)), // Sedikit
            default => rand(2, 5),
        };

        $selectedQuizzes = $quizBanks->random(min($quizToComplete, count($quizBanks)));

        foreach ($selectedQuizzes as $quizBank) {
            // Tentukan apakah quiz ini selesai atau belum
            $isCompleted = rand(1, 100) <= 85; // 85% kemungkinan selesai
            
            if (!$isCompleted) {
                // Quiz belum selesai (in progress)
                QuizAttempt::create([
                    'user_id' => $user->id,
                    'quiz_bank_id' => $quizBank->id,
                    'score' => 0,
                    'total_questions' => $quizBank->total_questions,
                    'correct_answers' => 0,
                    'is_passed' => false,
                    'started_at' => Carbon::now()->subDays(rand(1, 7)),
                    'completed_at' => null,
                ]);
                $this->command->line("    → Sedang mengerjakan: {$quizBank->title}");
            } else {
                // Quiz selesai
                $correctAnswers = $this->calculateScore($quizBank->total_questions, $activityLevel);
                $score = round(($correctAnswers / $quizBank->total_questions) * 100, 2);
                $isPassed = $score >= $quizBank->passing_score;

                $startedAt = Carbon::now()->subDays(rand(1, 20));
                $completedAt = $startedAt->copy()->addMinutes(rand(10, $quizBank->duration_minutes));

                QuizAttempt::create([
                    'user_id' => $user->id,
                    'quiz_bank_id' => $quizBank->id,
                    'score' => $score,
                    'total_questions' => $quizBank->total_questions,
                    'correct_answers' => $correctAnswers,
                    'is_passed' => $isPassed,
                    'started_at' => $startedAt,
                    'completed_at' => $completedAt,
                ]);

                $status = $isPassed ? '✓ LULUS' : '✗ Tidak Lulus';
                $this->command->line("    → {$quizBank->title}: {$score}% ({$correctAnswers}/{$quizBank->total_questions}) {$status}");
            }
        }
    }

    private function calculateScore($totalQuestions, $activityLevel)
    {
        // Hitung jawaban benar berdasarkan activity level
        return match($activityLevel) {
            'high' => rand(
                max(1, (int)($totalQuestions * 0.7)), // 70-95% benar
                max(1, (int)($totalQuestions * 0.95))
            ),
            'medium' => rand(
                max(1, (int)($totalQuestions * 0.5)), // 50-80% benar
                max(1, (int)($totalQuestions * 0.8))
            ),
            'low' => rand(
                max(1, (int)($totalQuestions * 0.3)), // 30-60% benar
                max(1, (int)($totalQuestions * 0.6))
            ),
            default => rand(
                max(1, (int)($totalQuestions * 0.4)),
                max(1, (int)($totalQuestions * 0.7))
            ),
        };
    }
}

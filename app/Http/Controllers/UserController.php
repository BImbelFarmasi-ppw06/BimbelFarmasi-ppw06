<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Show user profile page
     */
    public function profile()
    {
        return view('pages.profile', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:20'],
            'university' => ['nullable', 'string', 'max:255'],
            'interest' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'phone.required' => 'Nomor handphone wajib diisi.',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Show my services page (purchased programs)
     */
    public function myServices()
    {
        $user = Auth::user();
        
        // Get user's verified orders (purchased programs)
        $enrollments = $user->orders()
            ->with('program', 'payment')
            ->whereHas('payment', function($query) {
                $query->where('status', 'verified');
            })
            ->get()
            ->map(function($order) {
                $startDate = $order->payment->verified_at ?? $order->created_at;
                $endDate = $startDate->copy()->addMonths(4); // Durasi 4 bulan
                
                return [
                    'id' => $order->program->id,
                    'program' => $order->program->name,
                    'status' => 'active', // Semua program yang sudah dibeli dianggap aktif
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                    'progress' => 0, // Dimulai dari 0%
                    'total_sessions' => 24, // Default 24 sesi
                    'completed_sessions' => 0, // Dimulai dari 0 sesi
                ];
            })
            ->toArray();

        return view('pages.my-services', compact('enrollments'));
    }

    /**
     * Show transaction history
     */
    public function transactions()
    {
        $user = Auth::user();
        
        // Get only orders that have payment record (user already uploaded proof)
        $orders = $user->orders()
            ->with(['program', 'payment'])
            ->whereHas('payment') // Only orders with payment record
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Transform to match view format
        $transactions = $orders->map(function ($order) {
            return [
                'id' => $order->order_number,
                'date' => $order->created_at->format('Y-m-d'),
                'program' => $order->program->name,
                'amount' => $order->amount,
                'status' => $order->payment->status, // pending, verified, or rejected
                'payment_method' => ucwords(str_replace('_', ' ', $order->payment->payment_method)),
                'invoice_url' => '#',
            ];
        })->toArray();

        return view('pages.transactions', compact('transactions'));
    }

    /**
     * Show settings page
     */
    public function settings()
    {
        return view('pages.settings', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    /**
     * Delete account
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ], [
            'password.required' => 'Password wajib diisi untuk konfirmasi.',
            'password.current_password' => 'Password tidak sesuai.',
        ]);

        /** @var User $user */
        $user = Auth::user();
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect()->route('home')->with('success', 'Akun Anda telah dihapus.');
    }

    /**
     * Access program dashboard
     */
    public function accessProgram($id)
    {
        // TODO: Get program data from database and check user access
        return view('pages.program.dashboard', [
            'programId' => $id,
            'programName' => 'Bimbel UKOM D3 Farmasi'
        ]);
    }

    /**
     * Show program materials
     */
    public function materials($id)
    {
        // TODO: Get materials from database
        $materials = [
            [
                'id' => 1,
                'title' => 'Farmakologi Dasar',
                'type' => 'video',
                'duration' => '45 menit',
                'completed' => true,
            ],
            [
                'id' => 2,
                'title' => 'Farmasetika',
                'type' => 'pdf',
                'size' => '2.5 MB',
                'completed' => true,
            ],
            [
                'id' => 3,
                'title' => 'Kimia Farmasi',
                'type' => 'video',
                'duration' => '60 menit',
                'completed' => false,
            ],
        ];

        return view('pages.program.materials', [
            'programId' => $id,
            'materials' => $materials
        ]);
    }

    /**
     * Show program schedule
     */
    public function schedule($id)
    {
        // TODO: Get schedule from database
        $schedules = [
            [
                'date' => '2025-11-20',
                'time' => '19:00 - 21:00',
                'topic' => 'Farmakologi Klinik',
                'mentor' => 'Apt. Dr. Ahmad Fauzi',
                'status' => 'upcoming',
            ],
            [
                'date' => '2025-11-18',
                'time' => '19:00 - 21:00',
                'topic' => 'Farmasetika Lanjutan',
                'mentor' => 'Apt. Dr. Siti Nurhaliza',
                'status' => 'completed',
            ],
        ];

        return view('pages.program.schedule', [
            'programId' => $id,
            'schedules' => $schedules
        ]);
    }

    /**
     * Show program discussion forum
     */
    public function discussion($id)
    {
        // TODO: Get discussions from database
        $discussions = [
            [
                'id' => 1,
                'author' => 'Budi Santoso',
                'topic' => 'Pertanyaan tentang Farmakokinetik',
                'replies' => 5,
                'lastReply' => '2 jam yang lalu',
            ],
            [
                'id' => 2,
                'author' => 'Ani Wijaya',
                'topic' => 'Diskusi Soal Try Out Week 3',
                'replies' => 12,
                'lastReply' => '5 jam yang lalu',
            ],
        ];

        return view('pages.program.discussion', [
            'programId' => $id,
            'discussions' => $discussions
        ]);
    }

    /**
     * Show exercises list
     */
    public function exercises($id)
    {
        // TODO: Get exercises from database
        $exercises = [
            [
                'id' => 1,
                'title' => 'Farmakologi Dasar - Bagian 1',
                'description' => 'Latihan soal tentang konsep dasar farmakologi',
                'total_questions' => 20,
                'duration' => 30,
                'difficulty' => 'easy',
                'completed' => true,
                'score' => 85,
            ],
            [
                'id' => 2,
                'title' => 'Farmasetika - Formulasi',
                'description' => 'Soal-soal tentang formulasi sediaan farmasi',
                'total_questions' => 25,
                'duration' => 40,
                'difficulty' => 'medium',
                'completed' => true,
                'score' => 78,
            ],
            [
                'id' => 3,
                'title' => 'Kimia Farmasi Lanjutan',
                'description' => 'Latihan soal kimia farmasi tingkat lanjut',
                'total_questions' => 30,
                'duration' => 45,
                'difficulty' => 'hard',
                'completed' => false,
                'score' => null,
            ],
        ];

        return view('pages.program.exercises', [
            'programId' => $id,
            'exercises' => $exercises
        ]);
    }

    /**
     * Start an exercise
     */
    public function startExercise($id, $exerciseId)
    {
        // TODO: Get exercise questions from database
        $exercise = [
            'id' => $exerciseId,
            'title' => 'Farmakologi Dasar - Bagian 1',
            'duration' => 30,
            'total_questions' => 20,
        ];

        $questions = [
            [
                'id' => 1,
                'question' => 'Apa yang dimaksud dengan farmakokinetik?',
                'options' => [
                    'A' => 'Studi tentang efek obat pada tubuh',
                    'B' => 'Studi tentang pergerakan obat dalam tubuh',
                    'C' => 'Studi tentang interaksi obat',
                    'D' => 'Studi tentang pembuatan obat',
                ],
            ],
            [
                'id' => 2,
                'question' => 'Fase farmakokinetik yang melibatkan penyerapan obat adalah?',
                'options' => [
                    'A' => 'Distribusi',
                    'B' => 'Metabolisme',
                    'C' => 'Absorpsi',
                    'D' => 'Ekskresi',
                ],
            ],
            // Add more sample questions as needed
        ];

        return view('pages.program.exercise-start', [
            'programId' => $id,
            'exercise' => $exercise,
            'questions' => $questions
        ]);
    }

    /**
     * Submit exercise answers
     */
    public function submitExercise(Request $request, $id, $exerciseId)
    {
        // TODO: Process and save answers
        $answers = $request->input('answers', []);
        
        // Calculate score (dummy calculation)
        $totalQuestions = 20;
        $correctAnswers = rand(15, 19);
        $score = round(($correctAnswers / $totalQuestions) * 100);

        return redirect()->route('program.result', ['id' => $id, 'resultId' => rand(1, 100)])
            ->with('success', 'Latihan soal berhasil diselesaikan!');
    }

    /**
     * Show try out list
     */
    public function tryouts($id)
    {
        // TODO: Get try outs from database
        $tryouts = [
            [
                'id' => 1,
                'title' => 'Try Out UKOM D3 - Week 1',
                'description' => 'Simulasi ujian UKOM minggu pertama dengan 100 soal',
                'total_questions' => 100,
                'duration' => 120,
                'start_date' => '2025-11-15',
                'end_date' => '2025-11-22',
                'status' => 'available',
                'completed' => true,
                'score' => 82,
            ],
            [
                'id' => 2,
                'title' => 'Try Out UKOM D3 - Week 2',
                'description' => 'Simulasi ujian UKOM minggu kedua dengan tingkat kesulitan meningkat',
                'total_questions' => 100,
                'duration' => 120,
                'start_date' => '2025-11-18',
                'end_date' => '2025-11-25',
                'status' => 'available',
                'completed' => false,
                'score' => null,
            ],
            [
                'id' => 3,
                'title' => 'Try Out UKOM D3 - Week 3',
                'description' => 'Try out komprehensif dengan soal dari semua materi',
                'total_questions' => 100,
                'duration' => 120,
                'start_date' => '2025-11-25',
                'end_date' => '2025-12-02',
                'status' => 'upcoming',
                'completed' => false,
                'score' => null,
            ],
        ];

        return view('pages.program.tryouts', [
            'programId' => $id,
            'tryouts' => $tryouts
        ]);
    }

    /**
     * Start a try out
     */
    public function startTryout($id, $tryoutId)
    {
        // TODO: Get try out questions from database
        $tryout = [
            'id' => $tryoutId,
            'title' => 'Try Out UKOM D3 - Week 2',
            'duration' => 120,
            'total_questions' => 100,
        ];

        $questions = [];
        for ($i = 1; $i <= 100; $i++) {
            $questions[] = [
                'id' => $i,
                'question' => "Soal nomor {$i}: Lorem ipsum dolor sit amet, consectetur adipiscing elit?",
                'options' => [
                    'A' => 'Pilihan A - Lorem ipsum',
                    'B' => 'Pilihan B - Dolor sit amet',
                    'C' => 'Pilihan C - Consectetur adipiscing',
                    'D' => 'Pilihan D - Elit sed do',
                ],
            ];
        }

        return view('pages.program.tryout-start', [
            'programId' => $id,
            'tryout' => $tryout,
            'questions' => $questions
        ]);
    }

    /**
     * Submit try out answers
     */
    public function submitTryout(Request $request, $id, $tryoutId)
    {
        // TODO: Process and save answers
        $answers = $request->input('answers', []);
        
        // Calculate score (dummy calculation)
        $totalQuestions = 100;
        $correctAnswers = rand(70, 95);
        $score = round(($correctAnswers / $totalQuestions) * 100);

        return redirect()->route('program.result', ['id' => $id, 'resultId' => rand(100, 200)])
            ->with('success', 'Try Out berhasil diselesaikan!');
    }

    /**
     * View result
     */
    public function viewResult($id, $resultId)
    {
        // TODO: Get result from database
        $result = [
            'id' => $resultId,
            'title' => 'Try Out UKOM D3 - Week 1',
            'type' => 'tryout',
            'score' => 82,
            'correct_answers' => 82,
            'total_questions' => 100,
            'duration_spent' => 105,
            'completed_at' => '2025-11-16 14:30:00',
            'passing_grade' => 70,
        ];

        $breakdown = [
            ['category' => 'Farmakologi', 'correct' => 18, 'total' => 20, 'percentage' => 90],
            ['category' => 'Farmasetika', 'correct' => 16, 'total' => 20, 'percentage' => 80],
            ['category' => 'Kimia Farmasi', 'correct' => 15, 'total' => 20, 'percentage' => 75],
            ['category' => 'Farmasi Klinik', 'correct' => 17, 'total' => 20, 'percentage' => 85],
            ['category' => 'Manajemen Farmasi', 'correct' => 16, 'total' => 20, 'percentage' => 80],
        ];

        return view('pages.program.result', [
            'programId' => $id,
            'result' => $result,
            'breakdown' => $breakdown
        ]);
    }
}

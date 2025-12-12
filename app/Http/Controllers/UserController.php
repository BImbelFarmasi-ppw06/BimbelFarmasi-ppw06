<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Program;
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
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'phone.required' => 'Nomor handphone wajib diisi.',
            'profile_photo.image' => 'File harus berupa gambar.',
            'profile_photo.mimes' => 'Format foto harus jpeg, jpg, png, atau gif.',
            'profile_photo.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && \Storage::exists('public/' . $user->profile_photo)) {
                \Storage::delete('public/' . $user->profile_photo);
            }

            // Store new photo
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Show my services page (purchased programs)
     */
    public function myServices()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Try to get courses if Course model exists
        $courses = collect([]);
        if (class_exists('\App\Models\Course')) {
            try {
                $courses = \App\Models\Course::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            } catch (\Exception $e) {
                // Table doesn't exist yet
            }
        }

        // Try to get quiz banks if QuizBank model exists
        $quizBanks = collect([]);
        if (class_exists('\App\Models\QuizBank')) {
            try {
                $quizBanks = \App\Models\QuizBank::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            } catch (\Exception $e) {
                // Table doesn't exist yet
            }
        }

        // Check if user has any courses or quiz banks
        $hasContent = $courses->count() > 0 || $quizBanks->count() > 0;

        // Get user's paid orders (purchased programs)
        try {
            $enrollments = $user->orders()
                ->with('program', 'payment')
                ->whereHas('payment', function($query) {
                    $query->where('status', 'paid'); // Status setelah admin approve
                })
                ->get()
                ->map(function($order) {
                    $startDate = $order->payment->paid_at ?? $order->created_at;
                    $endDate = $startDate->copy()->addMonths($order->program->duration_months ?? 4);
                    
                    return [
                        'id' => $order->program->id,
                        'program' => $order->program->name,
                        'status' => 'active', // Semua program yang sudah dibeli dianggap aktif
                        'start_date' => $startDate->format('Y-m-d'),
                        'end_date' => $endDate->format('Y-m-d'),
                        'progress' => 0, // Dimulai dari 0%
                        'total_sessions' => $order->program->total_sessions ?? 24,
                        'completed_sessions' => 0, // Dimulai dari 0 sesi
                    ];
                })
                ->toArray();
        } catch (\Exception $e) {
            // If no orders yet, show empty array
            $enrollments = [];
        }

        return view('pages.my-services', compact('enrollments', 'courses', 'quizBanks', 'hasContent'));
    }

    /**
     * Show transaction history
     */
    public function transactions()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Get only orders that have payment record (user already uploaded proof)
        $orders = $user->orders()
            ->with(['program', 'payment'])
            ->whereHas('payment') // Only orders with payment record
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Transform to match view format
        $transactions = $orders->map(function ($order) {
            // Map payment status: paid = verified, pending = pending, rejected = rejected
            $status = $order->payment->status;
            if ($status === 'paid') {
                $status = 'verified';
            }
            
            return [
                'id' => $order->order_number,
                'date' => $order->created_at->format('Y-m-d'),
                'program' => $order->program->name,
                'amount' => $order->amount,
                'status' => $status,
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
        $user = Auth::user();
        
        // Get program with related data
        $program = Program::with(['courses', 'classSchedules', 'quizBanks.questions'])
            ->findOrFail($id);
        
        // Check if user has paid access to this program
        $hasAccess = Order::where('user_id', $user->id)
            ->where('program_id', $id)
            ->whereHas('payment', function($q) {
                $q->where('status', 'paid');
            })
            ->exists();
        
        if (!$hasAccess) {
            return redirect()->route('layanan')->with('error', 'Anda belum memiliki akses ke program ini.');
        }
        
        // Calculate statistics
        $totalMaterials = $program->courses->count();
        $totalSchedules = $program->classSchedules->count();
        $totalExercises = $program->quizBanks->where('type', 'practice')->count();
        $totalTryouts = $program->quizBanks->where('type', 'tryout')->count();
        
        // Get user's progress (for future implementation)
        $completedMaterials = 0; // TODO: Track completed materials
        $averageScore = 0; // TODO: Calculate from quiz attempts
        $studyDays = 0; // TODO: Calculate active study days
        
        return view('pages.program.dashboard', compact(
            'program',
            'totalMaterials',
            'totalSchedules', 
            'totalExercises',
            'totalTryouts',
            'completedMaterials',
            'averageScore',
            'studyDays'
        ));
    }

    /**
     * Show program materials
     */
    public function materials($id)
    {
        $user = Auth::user();
        
        // Check access
        $hasAccess = Order::where('user_id', $user->id)
            ->where('program_id', $id)
            ->whereHas('payment', function($q) {
                $q->where('status', 'paid');
            })
            ->exists();
        
        if (!$hasAccess) {
            return redirect()->route('layanan')->with('error', 'Anda belum memiliki akses ke program ini.');
        }
        
        $program = Program::with('courses')->findOrFail($id);
        $materials = $program->courses;

        return view('pages.program.materials', compact('program', 'materials'));
    }

    /**
     * Show program schedule
     */
    public function schedule($id)
    {
        $user = Auth::user();
        
        // Check access
        $hasAccess = Order::where('user_id', $user->id)
            ->where('program_id', $id)
            ->whereHas('payment', function($q) {
                $q->where('status', 'paid');
            })
            ->exists();
        
        if (!$hasAccess) {
            return redirect()->route('layanan')->with('error', 'Anda belum memiliki akses ke program ini.');
        }
        
        $program = Program::with(['classSchedules' => function($query) {
            $query->orderBy('date', 'asc')->orderBy('start_time', 'asc');
        }])->findOrFail($id);
        
        $schedules = $program->classSchedules;

        return view('pages.program.schedule', compact('program', 'schedules'));
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
        $user = Auth::user();
        
        // Check access
        $hasAccess = Order::where('user_id', $user->id)
            ->where('program_id', $id)
            ->whereHas('payment', function($q) {
                $q->where('status', 'paid');
            })
            ->exists();
        
        if (!$hasAccess) {
            return redirect()->route('layanan')->with('error', 'Anda belum memiliki akses ke program ini.');
        }
        
        $program = Program::with(['quizBanks' => function($query) {
            $query->where('type', 'practice')
                  ->withCount('questions')
                  ->with(['attempts' => function($q) {
                      $q->where('user_id', Auth::id())
                        ->latest()
                        ->limit(1);
                  }])
                  ->orderBy('created_at', 'desc');
        }])->findOrFail($id);
        
        $exercises = $program->quizBanks;

        return view('pages.program.exercises', compact('program', 'exercises'));
    }

    /**
     * Start an exercise
     */
    public function startExercise($id, $exerciseId)
    {
        $user = Auth::user();
        
        // Check access
        $hasAccess = Order::where('user_id', $user->id)
            ->where('program_id', $id)
            ->whereHas('payment', function($q) {
                $q->where('status', 'paid');
            })
            ->exists();
        
        if (!$hasAccess) {
            return redirect()->route('layanan')->with('error', 'Anda belum memiliki akses ke program ini.');
        }
        
        // Get quiz bank with questions
        $exercise = \App\Models\QuizBank::with('questions')
            ->where('id', $exerciseId)
            ->where('program_id', $id)
            ->where('type', 'practice')
            ->firstOrFail();
        
        $program = Program::findOrFail($id);
        $questions = $exercise->questions;

        return view('pages.program.exercise-start', compact('program', 'exercise', 'questions'));
    }

    /**
     * Submit exercise answers
     */
    public function submitExercise(Request $request, $id, $exerciseId)
    {
        $user = Auth::user();
        $answers = $request->input('answers', []);
        
        // Get quiz bank with questions
        $quiz = \App\Models\QuizBank::with('questions')->findOrFail($exerciseId);
        
        // Calculate score
        $totalQuestions = $quiz->questions->count();
        $correctAnswers = 0;
        
        foreach ($quiz->questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            if ($userAnswer && $userAnswer === $question->correct_answer) {
                $correctAnswers++;
            }
        }
        
        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;
        
        // Save attempt to database
        $attempt = \App\Models\QuizAttempt::create([
            'user_id' => $user->id,
            'quiz_bank_id' => $exerciseId,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'answers' => json_encode($answers),
            'completed_at' => now(),
        ]);

        return redirect()->route('program.result', ['id' => $id, 'resultId' => $attempt->id])
            ->with('success', 'Latihan soal berhasil diselesaikan!');
    }

    /**
     * Show try out list
     */
    public function tryouts($id)
    {
        $user = Auth::user();
        
        // Check access
        $hasAccess = Order::where('user_id', $user->id)
            ->where('program_id', $id)
            ->whereHas('payment', function($q) {
                $q->where('status', 'paid');
            })
            ->exists();
        
        if (!$hasAccess) {
            return redirect()->route('layanan')->with('error', 'Anda belum memiliki akses ke program ini.');
        }
        
        $program = Program::with(['quizBanks' => function($query) {
            $query->where('type', 'tryout')
                  ->withCount('questions')
                  ->with(['attempts' => function($q) {
                      $q->where('user_id', Auth::id())
                        ->latest()
                        ->limit(1);
                  }])
                  ->orderBy('created_at', 'desc');
        }])->findOrFail($id);
        
        $tryouts = $program->quizBanks;

        return view('pages.program.tryouts', compact('program', 'tryouts'));
    }

    /**
     * Start a try out
     */
    public function startTryout($id, $tryoutId)
    {
        $user = Auth::user();
        
        // Check access
        $hasAccess = Order::where('user_id', $user->id)
            ->where('program_id', $id)
            ->whereHas('payment', function($q) {
                $q->where('status', 'paid');
            })
            ->exists();
        
        if (!$hasAccess) {
            return redirect()->route('layanan')->with('error', 'Anda belum memiliki akses ke program ini.');
        }
        
        // Get quiz bank with questions
        $tryout = \App\Models\QuizBank::with('questions')
            ->where('id', $tryoutId)
            ->where('program_id', $id)
            ->where('type', 'tryout')
            ->firstOrFail();
        
        $program = Program::findOrFail($id);
        $questions = $tryout->questions;

        return view('pages.program.tryout-start', compact('program', 'tryout', 'questions'));
    }

    /**
     * Submit try out answers
     */
    public function submitTryout(Request $request, $id, $tryoutId)
    {
        $user = Auth::user();
        $answers = $request->input('answers', []);
        
        // Get quiz bank with questions
        $quiz = \App\Models\QuizBank::with('questions')->findOrFail($tryoutId);
        
        // Calculate score
        $totalQuestions = $quiz->questions->count();
        $correctAnswers = 0;
        
        foreach ($quiz->questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            if ($userAnswer && $userAnswer === $question->correct_answer) {
                $correctAnswers++;
            }
        }
        
        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;
        
        // Save attempt to database
        $attempt = \App\Models\QuizAttempt::create([
            'user_id' => $user->id,
            'quiz_bank_id' => $tryoutId,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'answers' => json_encode($answers),
            'completed_at' => now(),
        ]);

        return redirect()->route('program.result', ['id' => $id, 'resultId' => $attempt->id])
            ->with('success', 'Try Out berhasil diselesaikan!');
    }

    /**
     * View result
     */
    public function viewResult($id, $resultId)
    {
        $user = Auth::user();
        
        // Get attempt with quiz bank data
        $attempt = \App\Models\QuizAttempt::with(['quizBank', 'user'])
            ->where('id', $resultId)
            ->where('user_id', $user->id)
            ->firstOrFail();
        
        $program = Program::findOrFail($id);
        $wrongAnswers = $attempt->total_questions - $attempt->correct_answers;
        
        // Calculate duration spent (if started_at exists)
        $durationSpent = null;
        if ($attempt->started_at && $attempt->completed_at) {
            $durationSpent = $attempt->started_at->diffInMinutes($attempt->completed_at);
        }
        
        // Passing grade default
        $passingGrade = 70;

        return view('pages.program.result', compact(
            'program',
            'attempt',
            'wrongAnswers',
            'durationSpent',
            'passingGrade'
        ));
    }
}

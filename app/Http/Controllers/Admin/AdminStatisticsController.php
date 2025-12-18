<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Program;
use App\Models\QuizAttempt;
use App\Models\QuizBank;
use App\Models\QuizQuestion;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminStatisticsController extends Controller
{
    public function index()
    {
        // Get enrollment trend (last 10 months)
        $enrollmentTrend = $this->getEnrollmentTrend();
        
        // Get revenue trend (last 10 months)
        $revenueTrend = $this->getRevenueTrend();
        
        // Get key stats
        $stats = $this->getKeyStats();
        
        // Get program performance
        $programPerformance = $this->getProgramPerformance();
        
        // Get top question categories
        $topCategories = $this->getTopCategories();
        
        // Get latest activities
        $latestActivities = $this->getLatestActivities();
        
        return view('admin.statistics', compact(
            'enrollmentTrend',
            'revenueTrend',
            'stats',
            'programPerformance',
            'topCategories',
            'latestActivities'
        ));
    }
    
    private function getEnrollmentTrend()
    {
        $months = [];
        $data = [];
        
        for ($i = 9; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->locale('id')->format('M');
            
            $count = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('is_admin', false)
                ->count();
            
            $months[] = $monthName;
            $data[] = $count;
        }
        
        return [
            'labels' => $months,
            'data' => $data
        ];
    }
    
    private function getRevenueTrend()
    {
        $months = [];
        $data = [];
        
        for ($i = 9; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->locale('id')->format('M');
            
            $revenue = Payment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'success')
                ->sum('amount');
            
            $months[] = $monthName;
            $data[] = round($revenue / 1000000, 1); // Convert to millions
        }
        
        return [
            'labels' => $months,
            'data' => $data
        ];
    }
    
    private function getKeyStats()
    {
        // Calculate pass rate (only count completed quiz attempts)
        $totalAttempts = QuizAttempt::whereNotNull('completed_at')->count();
        $passedAttempts = QuizAttempt::whereNotNull('completed_at')
            ->where('is_passed', true)
            ->count();
        $passRate = $totalAttempts > 0 ? round(($passedAttempts / $totalAttempts) * 100, 1) : 0;
        
        // Calculate previous month pass rate for comparison
        $lastMonthTotal = QuizAttempt::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereNotNull('completed_at')
            ->count();
        $lastMonthPassed = QuizAttempt::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereNotNull('completed_at')
            ->where('is_passed', true)
            ->count();
        $lastMonthPassRate = $lastMonthTotal > 0 ? round(($lastMonthPassed / $lastMonthTotal) * 100, 1) : 0;
        $passRateChange = round($passRate - $lastMonthPassRate, 1);
        
        // Calculate average score (only completed attempts)
        $avgScore = QuizAttempt::whereNotNull('completed_at')->avg('score');
        $avgScore = $avgScore ? round($avgScore, 1) : 0;
        
        // Calculate previous month average score
        $lastMonthAvgScore = QuizAttempt::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereNotNull('completed_at')
            ->avg('score');
        $lastMonthAvgScore = $lastMonthAvgScore ? round($lastMonthAvgScore, 1) : 0;
        $avgScoreChange = round($avgScore - $lastMonthAvgScore, 1);
        
        // Calculate completion rate (quiz attempts that are completed vs total started)
        $totalStarted = QuizAttempt::count();
        $totalCompleted = QuizAttempt::whereNotNull('completed_at')->count();
        $completionRate = $totalStarted > 0 ? round(($totalCompleted / $totalStarted) * 100, 1) : 0;
        
        // Previous month completion rate
        $lastMonthTotalStarted = QuizAttempt::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();
        $lastMonthTotalCompleted = QuizAttempt::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereNotNull('completed_at')
            ->count();
        $lastMonthCompletionRate = $lastMonthTotalStarted > 0 ? round(($lastMonthTotalCompleted / $lastMonthTotalStarted) * 100, 1) : 0;
        $completionRateChange = round($completionRate - $lastMonthCompletionRate, 1);
        
        // Calculate satisfaction score from testimonials
        $avgRating = Testimonial::where('is_approved', true)->avg('rating');
        $avgRating = $avgRating ? round($avgRating, 1) : 0;
        $totalReviews = Testimonial::where('is_approved', true)->count();
        
        return [
            'passRate' => $passRate,
            'passRateChange' => $passRateChange,
            'avgScore' => $avgScore,
            'avgScoreChange' => $avgScoreChange,
            'completionRate' => $completionRate,
            'completionRateChange' => $completionRateChange,
            'satisfaction' => $avgRating,
            'totalReviews' => $totalReviews
        ];
    }
    
    private function getProgramPerformance()
    {
        $programs = Program::all();
        $labels = [];
        $data = [];
        
        foreach ($programs as $program) {
            // Get quiz attempts for this program
            $quizBankIds = QuizBank::where('program_id', $program->id)->pluck('id');
            
            if ($quizBankIds->isEmpty()) {
                continue; // Skip programs without quiz banks
            }
            
            $totalAttempts = QuizAttempt::whereIn('quiz_bank_id', $quizBankIds)
                ->whereNotNull('completed_at')
                ->count();
            
            if ($totalAttempts > 0) {
                $passedAttempts = QuizAttempt::whereIn('quiz_bank_id', $quizBankIds)
                    ->whereNotNull('completed_at')
                    ->where('is_passed', true)
                    ->count();
                
                $passRate = round(($passedAttempts / $totalAttempts) * 100, 1);
                
                $labels[] = $program->name;
                $data[] = $passRate;
            }
        }
        
        // If no data, provide a default message
        if (empty($labels)) {
            $labels = ['Belum ada data'];
            $data = [0];
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
    
    private function getTopCategories()
    {
        $categories = QuizQuestion::join('quiz_banks', 'quiz_questions.quiz_bank_id', '=', 'quiz_banks.id')
            ->select('quiz_banks.category', DB::raw('count(quiz_questions.id) as total'))
            ->whereNotNull('quiz_banks.category')
            ->groupBy('quiz_banks.category')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        $maxCount = $categories->max('total') ?? 1;
        
        return $categories->map(function($cat) use ($maxCount) {
            return [
                'name' => ucfirst($cat->category),
                'count' => $cat->total,
                'percentage' => round(($cat->total / $maxCount) * 100, 0)
            ];
        });
    }
    
    private function getLatestActivities()
    {
        $activities = QuizAttempt::with(['user', 'quizBank.program'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($attempt) {
                return [
                    'name' => $attempt->user->name,
                    'program' => $attempt->quizBank->program->name ?? 'N/A',
                    'activity' => ($attempt->quizBank->type == 'tryout' ? 'Try Out' : 'Latihan Soal') . ' - ' . $attempt->quizBank->title,
                    'score' => round($attempt->score, 0),
                    'time' => $attempt->created_at->diffForHumans()
                ];
            });
        
        return $activities;
    }
}

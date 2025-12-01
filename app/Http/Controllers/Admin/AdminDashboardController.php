<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Program;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Cache dashboard statistics for 5 minutes (300 seconds)
        $cacheKey = 'dashboard_stats_' . Carbon::now()->format('YmdHi');
        
        $stats = Cache::tags(['dashboard'])->remember($cacheKey, 300, function () {
            return [
                // Total users (excluding admins)
                'totalUsers' => User::where('is_admin', 0)->count(),
                
                // Active users (users with paid orders)
                'activeUsers' => User::where('is_admin', 0)
                    ->whereHas('orders', function($query) {
                        $query->whereHas('payment', function($q) {
                            $q->where('status', 'paid');
                        });
                    })
                    ->count(),
                
                // Total programs
                'totalPrograms' => Program::count(),
                
                // Total revenue from paid payments
                'totalRevenue' => Payment::where('status', 'paid')->sum('amount'),
                
                // Revenue this month
                'revenueThisMonth' => Payment::where('status', 'paid')
                    ->whereMonth('paid_at', Carbon::now()->month)
                    ->whereYear('paid_at', Carbon::now()->year)
                    ->sum('amount'),
                
                // Pending payments count
                'pendingPaymentsCount' => Payment::where('status', 'pending')->count(),
            ];
        });
        
        extract($stats);
        
        // Don't cache these - they need to be fresh
        $totalUsers = $stats['totalUsers'];
        $activeUsers = $stats['activeUsers'];
        $totalPrograms = $stats['totalPrograms'];
        $totalRevenue = $stats['totalRevenue'];
        $revenueThisMonth = $stats['revenueThisMonth'];
        $pendingPaymentsCount = $stats['pendingPaymentsCount'];
        
        // Recent users (last 5) - Fresh data
        $recentUsers = User::where('is_admin', 0)
            ->with(['orders' => function($query) {
                $query->latest()->take(1)->with('program');
            }])
            ->latest()
            ->take(5)
            ->get();
        
        // Pending payments (last 5) - Fresh data
        $pendingPayments = Payment::where('status', 'pending')
            ->with(['order.user', 'order.program'])
            ->latest()
            ->take(5)
            ->get();
        
        // Cache program distribution for 10 minutes
        $programDistribution = Cache::tags(['dashboard', 'programs'])->remember('program_distribution', 600, function () {
            return Program::withCount(['orders' => function($query) {
                $query->whereHas('payment', function($q) {
                    $q->where('status', 'paid');
                });
            }])
            ->get()
            ->map(function($program) {
                return [
                    'name' => $program->name,
                    'count' => $program->orders_count
                ];
            });
        });
        
        // Cache monthly enrollment for 1 hour
        $monthlyEnrollment = Cache::tags(['dashboard', 'charts'])->remember('monthly_enrollment', 3600, function () {
            $data = [];
            for ($i = 9; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $count = Order::whereHas('payment', function($q) {
                        $q->where('status', 'paid');
                    })
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count();
                
                $data[] = [
                    'month' => $date->format('M'),
                    'count' => $count
                ];
            }
            return $data;
        });
        
        // Cache monthly revenue for 1 hour
        $monthlyRevenue = Cache::tags(['dashboard', 'charts'])->remember('monthly_revenue', 3600, function () {
            $data = [];
            for ($i = 9; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $revenue = Payment::where('status', 'paid')
                    ->whereMonth('paid_at', $date->month)
                    ->whereYear('paid_at', $date->year)
                    ->sum('amount');
                
                $data[] = [
                    'month' => $date->format('M'),
                    'revenue' => $revenue / 1000000 // Convert to millions
                ];
            }
            return $data;
        });
        
        // Cache weekly activity for 15 minutes
        $weeklyActivity = Cache::tags(['dashboard', 'charts'])->remember('weekly_activity', 900, function () {
            $data = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $loginCount = User::where('is_admin', 0)
                    ->whereDate('updated_at', $date)
                    ->count();
                
                $data[] = [
                    'day' => $date->format('D'),
                    'logins' => $loginCount
                ];
            }
            return $data;
        });
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'totalPrograms',
            'totalRevenue',
            'revenueThisMonth',
            'pendingPaymentsCount',
            'recentUsers',
            'pendingPayments',
            'programDistribution',
            'monthlyEnrollment',
            'monthlyRevenue',
            'weeklyActivity'
        ));
    }
}

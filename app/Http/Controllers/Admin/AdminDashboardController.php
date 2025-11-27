<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Program;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total users (excluding admins)
        $totalUsers = User::where('is_admin', 0)->count();
        
        // Active users (users with paid orders)
        $activeUsers = User::where('is_admin', 0)
            ->whereHas('orders', function($query) {
                $query->whereHas('payment', function($q) {
                    $q->where('status', 'paid');
                });
            })
            ->count();
        
        // Total programs
        $totalPrograms = Program::count();
        
        // Total revenue from paid payments
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');
        
        // Revenue this month
        $revenueThisMonth = Payment::where('status', 'paid')
            ->whereMonth('paid_at', Carbon::now()->month)
            ->whereYear('paid_at', Carbon::now()->year)
            ->sum('amount');
        
        // Pending payments count
        $pendingPaymentsCount = Payment::where('status', 'pending')->count();
        
        // Recent users (last 5)
        $recentUsers = User::where('is_admin', 0)
            ->with(['orders' => function($query) {
                $query->latest()->take(1)->with('program');
            }])
            ->latest()
            ->take(5)
            ->get();
        
        // Pending payments (last 5)
        $pendingPayments = Payment::where('status', 'pending')
            ->with(['order.user', 'order.program'])
            ->latest()
            ->take(5)
            ->get();
        
        // Program distribution (count orders per program)
        $programDistribution = Program::withCount(['orders' => function($query) {
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
        
        // Monthly enrollment (last 10 months)
        $monthlyEnrollment = [];
        for ($i = 9; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Order::whereHas('payment', function($q) {
                    $q->where('status', 'paid');
                })
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            
            $monthlyEnrollment[] = [
                'month' => $date->format('M'),
                'count' => $count
            ];
        }
        
        // Monthly revenue (last 10 months)
        $monthlyRevenue = [];
        for ($i = 9; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = Payment::where('status', 'paid')
                ->whereMonth('paid_at', $date->month)
                ->whereYear('paid_at', $date->year)
                ->sum('amount');
            
            $monthlyRevenue[] = [
                'month' => $date->format('M'),
                'revenue' => $revenue / 1000000 // Convert to millions
            ];
        }
        
        // Weekly activity (last 7 days)
        $weeklyActivity = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $loginCount = User::where('is_admin', 0)
                ->whereDate('updated_at', $date)
                ->count();
            
            $weeklyActivity[] = [
                'day' => $date->format('D'),
                'logins' => $loginCount
            ];
        }
        
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

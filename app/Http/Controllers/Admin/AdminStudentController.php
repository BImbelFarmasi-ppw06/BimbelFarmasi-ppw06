<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminStudentController extends Controller
{
    /**
     * Display list of students (users with orders)
     */
    public function index(Request $request)
    {
        // Only show users who have uploaded payment proof
        $query = User::where('is_admin', 0)
            ->whereHas('orders.payment') // Must have payment (uploaded proof)
            ->withCount('orders')
            ->with(['orders' => function($q) {
                $q->latest()->with(['program', 'payment']);
            }]);

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by program
        if ($request->filled('program')) {
            $query->whereHas('orders.program', function($q) use ($request) {
                $q->where('slug', $request->program);
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $status = $request->status;
            $query->whereHas('orders.payment', function($q) use ($status) {
                if ($status === 'active') {
                    $q->where('status', 'paid'); // Payment approved
                } elseif ($status === 'pending') {
                    $q->where('status', 'pending'); // Waiting verification
                } elseif ($status === 'rejected') {
                    $q->where('status', 'rejected'); // Payment rejected
                }
            });
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(20);

        // Statistics - count unique users by their payment status
        $stats = [
            'total_students' => User::where('is_admin', 0)
                ->whereHas('orders.payment')
                ->count(),
            'active_students' => User::where('is_admin', 0)
                ->whereHas('orders.payment', function($q) {
                    $q->where('status', 'paid');
                })->count(),
            'pending_students' => User::where('is_admin', 0)
                ->whereHas('orders.payment', function($q) {
                    $q->where('status', 'pending');
                })->count(),
        ];

        return view('admin.students.index', compact('students', 'stats'));
    }

    /**
     * Show student detail
     */
    public function show($id)
    {
        $student = User::where('is_admin', 0)
            ->with(['orders.program', 'orders.payment'])
            ->findOrFail($id);

        return view('admin.students.show', compact('student'));
    }
}

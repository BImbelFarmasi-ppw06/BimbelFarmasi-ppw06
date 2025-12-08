<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminStudentController extends Controller
{
    /**
     * Display list of students (users with orders)
     */
    public function index(Request $request)
    {
        // Only show users who have completed orders (payment success via Midtrans)
        $query = User::where('is_admin', 0)
            ->whereHas('orders') // Must have orders
            ->withCount('orders')
            ->with(['orders' => function($q) {
                $q->latest()->with(['program']);
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

        // Filter by account status
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'active') {
                $query->where('is_suspended', false);
            } elseif ($status === 'suspended') {
                $query->where('is_suspended', true);
            }
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(20);

        // Statistics
        $stats = [
            'total_students' => User::where('is_admin', 0)
                ->whereHas('orders')
                ->count(),
            'active_students' => User::where('is_admin', 0)
                ->whereHas('orders')
                ->where('is_suspended', false)
                ->count(),
            'suspended_students' => User::where('is_admin', 0)
                ->whereHas('orders')
                ->where('is_suspended', true)
                ->count(),
            'recent_signups' => User::where('is_admin', 0)
                ->whereHas('orders')
                ->where('created_at', '>=', now()->subDays(7))
                ->count(),
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

    /**
     * Delete a student and their related data
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $student = User::where('is_admin', 0)->findOrFail($id);
            
            // Delete orders (Midtrans payment data is handled by Midtrans)
            $student->orders()->delete();
            
            // Delete user
            $student->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Peserta berhasil dihapus beserta semua data terkait.'
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus peserta: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete students
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id'
        ]);

        try {
            DB::beginTransaction();
            
            $students = User::where('is_admin', 0)
                ->whereIn('id', $request->student_ids)
                ->get();
            
            foreach ($students as $student) {
                // Delete orders
                $student->orders()->delete();
                $student->delete();
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => count($request->student_ids) . ' peserta berhasil dihapus.'
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus peserta: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Suspend student account
     */
    public function suspend(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);

        try {
            $student = User::where('is_admin', 0)->findOrFail($id);
            
            $student->update([
                'is_suspended' => true,
                'suspended_at' => now(),
                'suspended_by' => Auth::id(),
                'suspend_reason' => $request->reason ?? 'Tidak ada alasan yang diberikan'
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Akun peserta berhasil disuspend.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal suspend akun: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Activate student account
     */
    public function activate($id)
    {
        try {
            $student = User::where('is_admin', 0)->findOrFail($id);
            
            $student->update([
                'is_suspended' => false,
                'suspended_at' => null,
                'suspended_by' => null,
                'suspend_reason' => null
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Akun peserta berhasil diaktifkan kembali.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengaktifkan akun: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export students data to CSV
     */
    public function export(Request $request)
    {
        $query = User::where('is_admin', 0)
            ->whereHas('orders')
            ->with(['orders.program']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('program')) {
            $query->whereHas('orders.program', function($q) use ($request) {
                $q->where('slug', $request->program);
            });
        }

        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'active') {
                $query->where('is_suspended', false);
            } elseif ($status === 'suspended') {
                $query->where('is_suspended', true);
            }
        }

        $students = $query->orderBy('created_at', 'desc')->get();

        $filename = 'data-peserta-' . date('Y-m-d-H-i-s') . '.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($students) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV Headers
            fputcsv($file, [
                'ID',
                'Nama Lengkap',
                'Email',
                'No. WhatsApp',
                'Program',
                'Total Order',
                'Status Akun',
                'Tanggal Daftar',
                'Terakhir Login',
                'Alasan Suspend'
            ]);

            foreach ($students as $student) {
                $latestOrder = $student->orders->first();
                $accountStatus = $student->is_suspended ? 'Suspended' : 'Aktif';

                fputcsv($file, [
                    $student->id,
                    $student->name,
                    $student->email,
                    $student->whatsapp ?? '-',
                    $latestOrder ? $latestOrder->program->name : '-',
                    $student->orders_count,
                    $accountStatus,
                    $student->created_at->format('d/m/Y H:i'),
                    $student->last_login_at ? $student->last_login_at->format('d/m/Y H:i') : 'Belum pernah login',
                    $student->suspend_reason ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

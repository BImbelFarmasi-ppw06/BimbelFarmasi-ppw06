<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    /**
     * Get all notifications
     */
    public function index()
    {
        $notifications = Notification::orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Get unread count
     */
    public function getUnreadCount()
    {
        $count = Notification::where('is_read', false)->count();
        return response()->json(['count' => $count]);
    }

    /**
     * Get recent notifications
     */
    public function getRecent()
    {
        $notifications = Notification::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json($notifications);
    }

    /**
     * Mark as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all as read
     */
    public function markAllAsRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Delete notification
     */
    public function destroy($id)
    {
        Notification::findOrFail($id)->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus!');
    }

    /**
     * Clear all notifications
     */
    public function clearAll()
    {
        Notification::truncate();

        return back()->with('success', 'Semua notifikasi berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of all notifications.
     */
    public function index()
    {
        $notifications = Notification::where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', Auth::id())
            ->latest()
            ->paginate(20);

        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Get notifications for dropdown (AJAX).
     */
    public function list(Request $request)
    {
        $notifications = Notification::where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', Auth::id())
            ->latest()
            ->limit(10)
            ->get();

        $unreadCount = Notification::where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', Auth::id())
            ->unread()
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Get unread notifications count (AJAX).
     */
    public function unreadCount()
    {
        $count = Notification::where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', Auth::id())
            ->unread()
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Mark a notification as read (AJAX).
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', Auth::id())
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read (AJAX).
     */
    public function markAllAsRead()
    {
        Notification::where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', Auth::id())
            ->unread()
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Delete a notification.
     */
    public function destroy($id)
    {
        $notification = Notification::where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', Auth::id())
            ->findOrFail($id);

        $notification->delete();

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification deleted successfully.');
    }

    /**
     * Clear all notifications.
     */
    public function clearAll()
    {
        Notification::where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', Auth::id())
            ->delete();

        return redirect()->route('admin.notifications.index')
            ->with('success', 'All notifications cleared.');
    }
}
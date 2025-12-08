<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'notifications' => [],
                    'unread_count' => 0,
                    'error' => 'User not authenticated'
                ], 401);
            }
            
            Log::info('Fetching notifications for user: ' . $user->id);
            
            $notifications = Notification::where('notifiable_type', 'App\Models\User')
                ->where('notifiable_id', Auth::id())
                ->latest()
                ->limit(10)
                ->get()
                ->map(function ($notification) {
                    Log::info('Processing notification: ' . $notification->id);
                    Log::info('Raw notification data: ' . json_encode($notification->toArray()));
                    
                    return [
                        'id' => $notification->id,
                        'title' => $notification->title,
                        'message' => $notification->message,
                        'type' => $notification->type,
                        'data' => $notification->data,
                        'created_at' => $notification->created_at ? $notification->created_at->toDateTimeString() : now()->toDateTimeString(),
                        'read_at' => $notification->read_at ? $notification->read_at->toDateTimeString() : null,
                        'time_ago' => $notification->created_at ? $notification->created_at->diffForHumans() : 'Recently',
                    ];
                });

            $unreadCount = Notification::where('notifiable_type', 'App\Models\User')
                ->where('notifiable_id', Auth::id())
                ->whereNull('read_at')
                ->count();
            
            Log::info('Returning ' . count($notifications) . ' notifications, ' . $unreadCount . ' unread');

            return response()->json([
                'notifications' => $notifications,
                'unread_count' => $unreadCount
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in NotificationController@list: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json([
                'notifications' => [],
                'unread_count' => 0,
                'error' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get unread notifications count (AJAX).
     */
    public function unreadCount()
    {
        try {
            $count = Notification::where('notifiable_type', 'App\Models\User')
                ->where('notifiable_id', Auth::id())
                ->whereNull('read_at')
                ->count();
            
            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            Log::error('Error in NotificationController@unreadCount: ' . $e->getMessage());
            return response()->json(['count' => 0], 500);
        }
    }

    /**
     * Mark a notification as read (AJAX).
     */
    public function markAsRead($id)
    {
        try {
            $notification = Notification::where('notifiable_type', 'App\Models\User')
                ->where('notifiable_id', Auth::id())
                ->where('id', $id)
                ->first();
            
            if ($notification) {
                $notification->markAsRead();
                Log::info('Marked notification as read: ' . $id);
            }
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error in NotificationController@markAsRead: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Mark all notifications as read (AJAX).
     */
    public function markAllAsRead()
    {
        try {
            Notification::where('notifiable_type', 'App\Models\User')
                ->where('notifiable_id', Auth::id())
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
            
            Log::info('Marked all notifications as read for user: ' . Auth::id());
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error in NotificationController@markAllAsRead: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a notification.
     */
    public function destroy($id)
    {
        $notification = Notification::where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', Auth::id())
            ->where('id', $id)
            ->first();
        
        if ($notification) {
            $notification->delete();
        }
        
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

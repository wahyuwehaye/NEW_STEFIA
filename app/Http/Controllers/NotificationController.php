<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::where('user_id', Auth::id())
            ->with('user')
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'unread') {
                $query->unread();
            } elseif ($request->status === 'read') {
                $query->read();
            } else {
                $query->where('status', $request->status);
            }
        }

        // Filter by type
        if ($request->has('type') && $request->type !== '') {
            $query->byType($request->type);
        }

        // Filter by category
        if ($request->has('category') && $request->category !== '') {
            $query->byCategory($request->category);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority !== '') {
            $query->byPriority($request->priority);
        }

        // Date range filter
        if ($request->has('date_from') && $request->date_from !== '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to !== '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search
        if ($request->has('search') && $request->search !== '') {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('message', 'like', '%' . $request->search . '%');
            });
        }

        $notifications = $query->paginate(15);

        // Statistics
        $stats = [
            'total' => Notification::where('user_id', Auth::id())->count(),
            'unread' => Notification::where('user_id', Auth::id())->unread()->count(),
            'pending' => Notification::where('user_id', Auth::id())->pending()->count(),
            'sent' => Notification::where('user_id', Auth::id())->sent()->count(),
            'failed' => Notification::where('user_id', Auth::id())->failed()->count(),
        ];

        return view('notifications.index', compact('notifications', 'stats'));
    }

    public function show(Notification $notification)
    {
        // Check if user owns this notification
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        // Mark as read if not already
        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        return view('notifications.show', compact('notification'));
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
                'status' => 'read'
            ]);

        return response()->json(['success' => true]);
    }

    public function destroy(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->delete();

        return response()->json(['success' => true]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        
        Notification::where('user_id', Auth::id())
            ->whereIn('id', $ids)
            ->delete();

        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->unread()
            ->count();

        return response()->json(['count' => $count]);
    }

    public function getRecent()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json($notifications);
    }
}

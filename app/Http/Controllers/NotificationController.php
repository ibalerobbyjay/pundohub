<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Show all notifications
    public function index()
    {    
        $notifications = Auth::user()->notifications;       // all notifications
        $unread = Auth::user()->unreadNotifications;        // only unread

        return view('notifications.index', compact('notifications', 'unread'));
    }

    // Mark a single notification as read
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    // Mark all notifications as read
    public function markAllRead()
    {
        if (auth()->check()) {
            auth()->user()->unreadNotifications->markAsRead();
        }

        return redirect()->route('notifications.index')
                         ->with('success', 'All notifications marked as read.');
    }

    // Delete a notification
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();

        return redirect()->route('notifications.index')
                         ->with('success', 'Notification deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    /**
     * Full notifications page.
     */
    public function index()
    {
        $notifications = Notification::forUser(Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * API: get unread count.
     */
    public function unreadCount()
    {
        $count = Notification::forUser(Auth::id())->unread()->count();
        return response()->json(['count' => $count]);
    }

    /**
     * API: get recent notifications for the dropdown.
     */
    public function recent()
    {
        $notifications = Notification::forUser(Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get()
            ->map(function ($n) {
                return [
                    'id'         => $n->id,
                    'type'       => $n->type,
                    'title'      => $n->title,
                    'message'    => $n->message,
                    'is_read'    => $n->is_read,
                    'time_ago'   => $n->timeAgo(),
                    'url'        => $this->notificationUrl($n),
                    'job_id'     => $n->related_job_id,
                ];
            });

        $unreadCount = Notification::forUser(Auth::id())->unread()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count'  => $unreadCount,
        ]);
    }

    /**
     * Mark a single notification as read and redirect.
     */
    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->update(['is_read' => true]);

        return redirect($this->notificationUrl($notification));
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Notification::forUser(Auth::id())->unread()->update(['is_read' => true]);

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back();
    }

    /**
     * Determine the navigation URL based on notification type.
     */
    private function notificationUrl(Notification $notification): string
    {
        return match ($notification->type) {
            'new_lead' => $notification->related_job_id
                ? route('dashboard.professional', ['tab' => 'leads'])
                : route('dashboard.professional'),

            'quote_received' => $notification->related_job_id
                ? route('dashboard.customer.jobs.show', $notification->related_job_id)
                : route('dashboard.customer'),

            'quote_accepted' => $notification->related_job_id
                ? route('dashboard.professional', ['tab' => 'jobs'])
                : route('dashboard.professional'),

            'job_completed' => $notification->related_job_id
                ? route('dashboard.customer.jobs.show', $notification->related_job_id)
                : route('dashboard.customer'),

            'review_reminder' => $notification->related_job_id
                ? route('dashboard.customer')
                : route('dashboard.customer'),

            'new_message' => $notification->related_job_id
                ? route('messages.job', $notification->related_job_id)
                : route('messages.index'),

            'new_professional_signup' => route('admin.professionals'),

            'professional_approved' => route('dashboard.professional'),

            default => '#',
        };
    }
}

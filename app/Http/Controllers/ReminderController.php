<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $stats = $this->notificationService->getStatistics();
        
        return view('reminders.index', compact('stats'));
    }

    public function create()
    {
        $users = User::all();
        return view('reminders.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:payment_reminder,overdue_notice,collection_action,system_alert',
            'recipients' => 'required|array',
            'recipients.*' => 'exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:low,normal,high,urgent',
            'notification_type' => 'required|in:email,whatsapp,system',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        $notifications = [];

        foreach ($request->recipients as $userId) {
            $user = User::find($userId);
            
            $notificationData = [
                'type' => $request->notification_type,
                'title' => $request->title,
                'message' => $request->message,
                'user_id' => $userId,
                'category' => $request->type,
                'priority' => $request->priority,
                'status' => 'pending',
                'data' => $request->additional_data ?? [],
            ];

            if ($request->scheduled_at) {
                $notification = $this->notificationService->scheduleNotification(
                    $notificationData,
                    new \DateTime($request->scheduled_at)
                );
            } else {
                $notification = $this->notificationService->createNotification($notificationData);
            }

            $notifications[] = $notification;
        }

        return redirect()->route('reminders.index')
            ->with('success', 'Reminders created successfully for ' . count($notifications) . ' recipients.');
    }

    public function sendPaymentReminders(Request $request)
    {
        $request->validate([
            'students' => 'required|array',
            'students.*.user_id' => 'required|exists:users,id',
            'students.*.amount' => 'required|numeric|min:0',
            'students.*.due_date' => 'required|date',
            'students.*.fee_type' => 'required|string',
        ]);

        $notifications = $this->notificationService->sendBulkPaymentReminders($request->students);

        return response()->json([
            'success' => true,
            'message' => 'Payment reminders sent to ' . count($notifications) . ' students.',
            'notifications' => $notifications
        ]);
    }

    public function sendOverdueNotices(Request $request)
    {
        $request->validate([
            'students' => 'required|array',
            'students.*.user_id' => 'required|exists:users,id',
            'students.*.amount' => 'required|numeric|min:0',
            'students.*.overdue_days' => 'required|integer|min:1',
        ]);

        $notifications = [];

        foreach ($request->students as $studentData) {
            $user = User::find($studentData['user_id']);
            if ($user) {
                $notifications[] = $this->notificationService->sendOverdueNotice($user, $studentData);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Overdue notices sent to ' . count($notifications) . ' students.',
            'notifications' => $notifications
        ]);
    }

    public function sendSystemAlert(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'recipients' => 'required|array',
            'recipients.*' => 'exists:users,id',
            'data' => 'nullable|array',
        ]);

        $users = User::whereIn('id', $request->recipients)->get();
        $notifications = $this->notificationService->sendSystemAlert(
            $users->toArray(),
            $request->title,
            $request->message,
            $request->data ?? []
        );

        return response()->json([
            'success' => true,
            'message' => 'System alert sent to ' . count($notifications) . ' users.',
            'notifications' => $notifications
        ]);
    }

    public function processScheduled()
    {
        $processed = $this->notificationService->processScheduledNotifications();

        return response()->json([
            'success' => true,
            'message' => "Processed {$processed} scheduled notifications.",
            'processed' => $processed
        ]);
    }

    public function retryFailed()
    {
        $retried = $this->notificationService->retryFailedNotifications();

        return response()->json([
            'success' => true,
            'message' => "Retried {$retried} failed notifications.",
            'retried' => $retried
        ]);
    }

    public function statistics()
    {
        $stats = $this->notificationService->getStatistics();
        
        return response()->json($stats);
    }

    public function templates()
    {
        $templates = [
            'payment_reminder' => [
                'title' => 'Payment Reminder - {fee_type}',
                'message' => 'Dear {student_name}, your {fee_type} payment of Rp {amount} is due on {due_date}. Please ensure timely payment to avoid late fees.',
                'type' => 'email',
                'priority' => 'high'
            ],
            'overdue_notice' => [
                'title' => 'Overdue Notice - Outstanding Balance',
                'message' => 'Your account has an outstanding balance of Rp {amount}. This amount is now {overdue_days} days overdue. Please contact the finance office immediately.',
                'type' => 'whatsapp',
                'priority' => 'urgent'
            ],
            'collection_action' => [
                'title' => 'Collection Action Required',
                'message' => 'Collection action has been scheduled for student {student_name} (NIM: {student_id}). Please follow up with {action_type}.',
                'type' => 'system',
                'priority' => 'high'
            ],
            'system_maintenance' => [
                'title' => 'System Maintenance Notice',
                'message' => 'The STEFIA system will undergo maintenance on {maintenance_date} from {start_time} to {end_time}. Some features may be unavailable during this time.',
                'type' => 'system',
                'priority' => 'normal'
            ],
            'payment_confirmation' => [
                'title' => 'Payment Confirmation',
                'message' => 'We have received your payment of Rp {amount} for {fee_type}. Thank you for your payment.',
                'type' => 'email',
                'priority' => 'normal'
            ]
        ];

        return response()->json($templates);
    }
}

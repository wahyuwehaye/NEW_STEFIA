<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * Create a new notification
     */
    public function createNotification(array $data): Notification
    {
        return Notification::create($data);
    }

    /**
     * Send payment reminder to student
     */
    public function sendPaymentReminder(User $user, array $paymentData): Notification
    {
        $notification = $this->createNotification([
            'type' => 'email',
            'title' => 'Payment Reminder - ' . $paymentData['fee_type'],
            'message' => "Dear {$user->name}, your {$paymentData['fee_type']} payment of Rp " . number_format($paymentData['amount']) . " is due on {$paymentData['due_date']}. Please ensure timely payment to avoid late fees.",
            'user_id' => $user->id,
            'category' => 'payment_reminder',
            'priority' => 'high',
            'status' => 'pending',
            'data' => $paymentData,
        ]);

        // Send the notification
        $this->sendNotification($notification);

        return $notification;
    }

    /**
     * Send overdue notice
     */
    public function sendOverdueNotice(User $user, array $overdueData): Notification
    {
        $notification = $this->createNotification([
            'type' => 'whatsapp',
            'title' => 'Overdue Notice - Outstanding Balance',
            'message' => "Your account has an outstanding balance of Rp " . number_format($overdueData['amount']) . ". This amount is now overdue. Please contact the finance office immediately.",
            'user_id' => $user->id,
            'category' => 'overdue_notice',
            'priority' => 'urgent',
            'status' => 'pending',
            'data' => $overdueData,
        ]);

        // Send the notification
        $this->sendNotification($notification);

        return $notification;
    }

    /**
     * Send collection action notification
     */
    public function sendCollectionAction(User $user, array $actionData): Notification
    {
        $notification = $this->createNotification([
            'type' => 'system',
            'title' => 'Collection Action Required',
            'message' => "Collection action has been scheduled for student {$actionData['student_name']} (NIM: {$actionData['student_id']}). Please follow up with {$actionData['action_type']}.",
            'user_id' => $user->id,
            'category' => 'collection_action',
            'priority' => 'high',
            'status' => 'pending',
            'data' => $actionData,
        ]);

        // Send the notification
        $this->sendNotification($notification);

        return $notification;
    }

    /**
     * Send system alert
     */
    public function sendSystemAlert(array $users, string $title, string $message, array $data = []): array
    {
        $notifications = [];

        foreach ($users as $user) {
            $notification = $this->createNotification([
                'type' => 'system',
                'title' => $title,
                'message' => $message,
                'user_id' => $user->id,
                'category' => 'system_alert',
                'priority' => 'normal',
                'status' => 'pending',
                'data' => $data,
            ]);

            $this->sendNotification($notification);
            $notifications[] = $notification;
        }

        return $notifications;
    }

    /**
     * Send bulk payment reminders
     */
    public function sendBulkPaymentReminders(array $studentsData): array
    {
        $notifications = [];

        foreach ($studentsData as $studentData) {
            $user = User::find($studentData['user_id']);
            if ($user) {
                $notifications[] = $this->sendPaymentReminder($user, $studentData);
            }
        }

        return $notifications;
    }

    /**
     * Send notification based on type
     */
    private function sendNotification(Notification $notification): bool
    {
        try {
            switch ($notification->type) {
                case 'email':
                    return $this->sendEmail($notification);
                    
                case 'whatsapp':
                    return $this->sendWhatsApp($notification);
                    
                case 'system':
                    return $this->sendSystemNotification($notification);
                    
                default:
                    throw new \Exception("Unknown notification type: {$notification->type}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to send notification {$notification->id}: " . $e->getMessage());
            $notification->markAsFailed($e->getMessage());
            return false;
        }
    }

    /**
     * Send email notification
     */
    private function sendEmail(Notification $notification): bool
    {
        try {
            // Simulate email sending
            // In real implementation, you would use Laravel's Mail facade
            // Mail::to($notification->user->email)->send(new NotificationMail($notification));
            
            // For demo, we'll just mark as sent
            $notification->markAsSent();
            
            Log::info("Email notification sent to {$notification->user->email}");
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Email sending failed: " . $e->getMessage());
        }
    }

    /**
     * Send WhatsApp notification
     */
    private function sendWhatsApp(Notification $notification): bool
    {
        try {
            // Simulate WhatsApp API call
            // In real implementation, you would integrate with WhatsApp Business API
            
            // For demo, we'll just mark as sent
            $notification->markAsSent();
            
            Log::info("WhatsApp notification sent to {$notification->user->phone}");
            return true;
        } catch (\Exception $e) {
            throw new \Exception("WhatsApp sending failed: " . $e->getMessage());
        }
    }

    /**
     * Send system notification
     */
    private function sendSystemNotification(Notification $notification): bool
    {
        try {
            // System notifications are just stored in database
            $notification->markAsSent();
            
            Log::info("System notification created for user {$notification->user->id}");
            return true;
        } catch (\Exception $e) {
            throw new \Exception("System notification failed: " . $e->getMessage());
        }
    }

    /**
     * Schedule notification for later sending
     */
    public function scheduleNotification(array $data, \DateTime $scheduledAt): Notification
    {
        $data['scheduled_at'] = $scheduledAt;
        $data['status'] = 'pending';

        return $this->createNotification($data);
    }

    /**
     * Process scheduled notifications
     */
    public function processScheduledNotifications(): int
    {
        $notifications = Notification::where('status', 'pending')
            ->where('scheduled_at', '<=', now())
            ->get();

        $processed = 0;

        foreach ($notifications as $notification) {
            if ($this->sendNotification($notification)) {
                $processed++;
            }
        }

        return $processed;
    }

    /**
     * Retry failed notifications
     */
    public function retryFailedNotifications(int $maxRetries = 3): int
    {
        $notifications = Notification::where('status', 'failed')
            ->where('retry_count', '<', $maxRetries)
            ->get();

        $retried = 0;

        foreach ($notifications as $notification) {
            if ($this->sendNotification($notification)) {
                $retried++;
            }
        }

        return $retried;
    }

    /**
     * Get notification statistics
     */
    public function getStatistics(User $user = null): array
    {
        $query = Notification::query();

        if ($user) {
            $query->where('user_id', $user->id);
        }

        return [
            'total' => $query->count(),
            'unread' => $query->whereNull('read_at')->count(),
            'pending' => $query->where('status', 'pending')->count(),
            'sent' => $query->where('status', 'sent')->count(),
            'failed' => $query->where('status', 'failed')->count(),
            'by_type' => [
                'email' => $query->where('type', 'email')->count(),
                'whatsapp' => $query->where('type', 'whatsapp')->count(),
                'system' => $query->where('type', 'system')->count(),
            ],
            'by_priority' => [
                'urgent' => $query->where('priority', 'urgent')->count(),
                'high' => $query->where('priority', 'high')->count(),
                'normal' => $query->where('priority', 'normal')->count(),
                'low' => $query->where('priority', 'low')->count(),
            ],
        ];
    }
}

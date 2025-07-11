<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $users = User::all();

        $notifications = [
            [
                'type' => 'email',
                'title' => 'Payment Reminder - Tuition Fee Due',
                'message' => 'Dear Student, your tuition fee payment of Rp 15,000,000 is due on 25th January 2024. Please ensure timely payment to avoid late fees.',
                'category' => 'payment_reminder',
                'priority' => 'high',
                'status' => 'sent',
                'sent_at' => now()->subDays(2),
                'data' => [
                    'student_id' => 'S001',
                    'amount' => 15000000,
                    'due_date' => '2024-01-25',
                    'fee_type' => 'tuition'
                ]
            ],
            [
                'type' => 'whatsapp',
                'title' => 'Overdue Notice - Outstanding Balance',
                'message' => 'Your account has an outstanding balance of Rp 25,000,000. This amount is now overdue. Please contact the finance office immediately.',
                'category' => 'overdue_notice',
                'priority' => 'urgent',
                'status' => 'sent',
                'sent_at' => now()->subHours(6),
                'data' => [
                    'student_id' => 'S002',
                    'amount' => 25000000,
                    'overdue_days' => 15,
                    'last_payment' => '2023-10-15'
                ]
            ],
            [
                'type' => 'system',
                'title' => 'Collection Action Required',
                'message' => 'Collection action has been scheduled for student John Doe (NIM: 1234567890). Please follow up with home visit.',
                'category' => 'collection_action',
                'priority' => 'high',
                'status' => 'pending',
                'data' => [
                    'student_id' => 'S003',
                    'action_type' => 'home_visit',
                    'scheduled_date' => '2024-01-20',
                    'assigned_staff' => 'Finance Officer'
                ]
            ],
            [
                'type' => 'email',
                'title' => 'Payment Confirmation',
                'message' => 'We have received your payment of Rp 10,000,000 for semester fees. Thank you for your payment.',
                'category' => 'payment_confirmation',
                'priority' => 'normal',
                'status' => 'sent',
                'sent_at' => now()->subDays(1),
                'read_at' => now()->subHours(12),
                'data' => [
                    'student_id' => 'S004',
                    'amount' => 10000000,
                    'payment_date' => '2024-01-15',
                    'payment_method' => 'bank_transfer'
                ]
            ],
            [
                'type' => 'system',
                'title' => 'System Maintenance Notice',
                'message' => 'The STEFIA system will undergo maintenance on Sunday, January 21st from 02:00 to 06:00 AM. Some features may be unavailable during this time.',
                'category' => 'system_alert',
                'priority' => 'normal',
                'status' => 'pending',
                'scheduled_at' => now()->addDays(1),
                'data' => [
                    'maintenance_start' => '2024-01-21 02:00:00',
                    'maintenance_end' => '2024-01-21 06:00:00',
                    'affected_modules' => ['payments', 'reports']
                ]
            ],
            [
                'type' => 'email',
                'title' => 'Scholarship Application Deadline',
                'message' => 'Reminder: The deadline for scholarship applications is approaching. Please submit your application by January 30th, 2024.',
                'category' => 'scholarship_reminder',
                'priority' => 'normal',
                'status' => 'sent',
                'sent_at' => now()->subDays(3),
                'data' => [
                    'deadline' => '2024-01-30',
                    'scholarship_type' => 'Academic Excellence',
                    'application_portal' => 'https://portal.university.edu'
                ]
            ],
            [
                'type' => 'whatsapp',
                'title' => 'Failed Payment Processing',
                'message' => 'Your payment processing failed due to insufficient funds. Please try again with a different payment method.',
                'category' => 'payment_failed',
                'priority' => 'high',
                'status' => 'failed',
                'error_message' => 'WhatsApp API connection timeout',
                'retry_count' => 2,
                'data' => [
                    'student_id' => 'S005',
                    'amount' => 8000000,
                    'payment_reference' => 'PAY20240115001',
                    'failure_reason' => 'insufficient_funds'
                ]
            ],
            [
                'type' => 'system',
                'title' => 'Data Sync Completed',
                'message' => 'Daily data synchronization with iGracias system has been completed successfully. 1,250 student records updated.',
                'category' => 'system_alert',
                'priority' => 'low',
                'status' => 'sent',
                'sent_at' => now()->subHours(2),
                'read_at' => now()->subHours(1),
                'data' => [
                    'sync_date' => now()->format('Y-m-d'),
                    'records_updated' => 1250,
                    'sync_duration' => '45 minutes',
                    'status' => 'success'
                ]
            ],
            [
                'type' => 'email',
                'title' => 'Monthly Financial Report Available',
                'message' => 'The monthly financial report for December 2023 is now available for download. Please review the receivables summary.',
                'category' => 'report_available',
                'priority' => 'normal',
                'status' => 'sent',
                'sent_at' => now()->subDays(5),
                'data' => [
                    'report_period' => 'December 2023',
                    'report_type' => 'monthly_financial',
                    'total_receivables' => 2500000000,
                    'download_url' => '/reports/monthly/2023-12'
                ]
            ],
            [
                'type' => 'whatsapp',
                'title' => 'Parent Contact Reminder',
                'message' => 'Reminder to contact parent of student Sarah Wilson regarding outstanding fees. Last contact was 2 weeks ago.',
                'category' => 'collection_action',
                'priority' => 'normal',
                'status' => 'pending',
                'scheduled_at' => now()->addHours(4),
                'data' => [
                    'student_id' => 'S006',
                    'student_name' => 'Sarah Wilson',
                    'parent_phone' => '+62812345678',
                    'last_contact' => '2024-01-01',
                    'outstanding_amount' => 12000000
                ]
            ]
        ];

        foreach ($users as $user) {
            foreach ($notifications as $notificationData) {
                Notification::create(array_merge($notificationData, [
                    'user_id' => $user->id,
                    'created_at' => $notificationData['sent_at'] ?? now(),
                    'updated_at' => $notificationData['sent_at'] ?? now(),
                ]));
            }
        }
    }
}

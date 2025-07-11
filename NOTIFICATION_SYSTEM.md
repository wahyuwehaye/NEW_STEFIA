# STEFIA Notification System Documentation

## Overview
The STEFIA (Student Financial Information & Administration) application now includes a comprehensive notification system for managing payment reminders, overdue notices, and system alerts.

## Features Implemented

### 📧 Notification Management
- **Comprehensive Notification System**: Email, WhatsApp, and system notifications
- **Advanced Filtering**: Filter by status, type, category, priority, date range, and search
- **Bulk Operations**: Mark all as read, bulk delete selected notifications
- **Real-time Updates**: AJAX-powered interface for smooth user experience

### 🔔 Notification Types
1. **Email Notifications**
   - Payment reminders
   - Payment confirmations
   - Monthly reports
   - Scholarship deadlines

2. **WhatsApp Notifications**
   - Overdue notices
   - Failed payment alerts
   - Parent contact reminders

3. **System Notifications**
   - Collection action requirements
   - System maintenance alerts
   - Data sync status
   - Internal announcements

### 📊 Reminder Management
- **Payment Reminders**: Bulk send payment reminders to students
- **Overdue Notices**: Automated overdue balance notifications
- **System Alerts**: Broadcast system announcements to all users
- **Template System**: Pre-defined message templates for consistency
- **Scheduled Notifications**: Schedule notifications for future delivery
- **Retry Failed**: Automatic retry mechanism for failed notifications

### 🎯 Priority Levels
- **Urgent**: Critical notifications requiring immediate attention
- **High**: Important notifications (payment reminders, collection actions)
- **Normal**: Standard notifications (confirmations, reports)
- **Low**: Informational notifications (sync status, maintenance)

### 📈 Statistics & Analytics
- Total notifications count
- Status breakdown (pending, sent, failed, read/unread)
- Type distribution (email, WhatsApp, system)
- Priority analysis (urgent, high, normal, low)

## Database Structure

### Notifications Table
```sql
- id (Primary Key)
- type (email, whatsapp, system)
- title (Notification title)
- message (Notification content)
- data (JSON - Additional metadata)
- user_id (Foreign Key to users)
- status (pending, sent, failed, read)
- read_at (Timestamp when read)
- sent_at (Timestamp when sent)
- priority (low, normal, high, urgent)
- category (payment_reminder, overdue_notice, system_alert, etc.)
- error_message (Error details for failed notifications)
- retry_count (Number of retry attempts)
- scheduled_at (When to send scheduled notifications)
- created_at, updated_at
```

## API Endpoints

### Notification Routes
```php
GET    /notifications                    - List all notifications
GET    /notifications/{id}              - View notification details
POST   /notifications/{id}/read         - Mark notification as read
POST   /notifications/mark-all-read     - Mark all notifications as read
DELETE /notifications/{id}              - Delete notification
POST   /notifications/bulk-delete       - Bulk delete selected notifications
GET    /notifications/api/unread-count  - Get unread count
GET    /notifications/api/recent        - Get recent notifications
```

### Reminder Routes
```php
GET    /reminders                       - Reminder management dashboard
GET    /reminders/create               - Create new reminder
POST   /reminders                      - Store new reminder
POST   /reminders/payment-reminders    - Send bulk payment reminders
POST   /reminders/overdue-notices      - Send overdue notices
POST   /reminders/system-alert         - Send system alerts
POST   /reminders/process-scheduled    - Process scheduled notifications
POST   /reminders/retry-failed         - Retry failed notifications
GET    /reminders/statistics           - Get reminder statistics
GET    /reminders/templates            - Get notification templates
```

## Services

### NotificationService
Handles the business logic for:
- Creating notifications
- Sending different types of notifications
- Scheduling notifications
- Processing scheduled notifications
- Retrying failed notifications
- Generating statistics

### Key Methods
```php
- createNotification(array $data): Notification
- sendPaymentReminder(User $user, array $paymentData): Notification
- sendOverdueNotice(User $user, array $overdueData): Notification
- sendCollectionAction(User $user, array $actionData): Notification
- sendSystemAlert(array $users, string $title, string $message): array
- scheduleNotification(array $data, DateTime $scheduledAt): Notification
- processScheduledNotifications(): int
- retryFailedNotifications(int $maxRetries = 3): int
- getStatistics(User $user = null): array
```

## User Interface

### Notification List Page (`/notifications`)
- **Filter Controls**: Status, type, category, priority, date range, search
- **Statistics Cards**: Total, unread, pending, sent, failed counts
- **Bulk Actions**: Select all, mark as read, delete selected
- **Notification Items**: Title, message preview, type badges, status indicators
- **Pagination**: Laravel pagination with responsive design

### Notification Detail Page (`/notifications/{id}`)
- **Full Message Content**: Complete notification text
- **Metadata Sidebar**: Type, priority, status, timestamps
- **Additional Data**: JSON data display for complex notifications
- **Error Information**: Failed notification error details
- **Action Buttons**: Mark as read, retry, delete

### Reminder Management Page (`/reminders`)
- **Statistics Dashboard**: Comprehensive notification statistics
- **Quick Action Cards**: Payment reminders, overdue notices, system alerts
- **Type & Priority Breakdown**: Visual statistics by category
- **Bulk Operations**: Process scheduled, retry failed, template management

## Sample Data
The system comes pre-populated with 10 different types of sample notifications for each user:
1. Payment Reminder - Tuition Fee
2. Overdue Notice - Outstanding Balance
3. Collection Action Required
4. Payment Confirmation
5. System Maintenance Notice
6. Scholarship Application Deadline
7. Failed Payment Processing
8. Data Sync Completed
9. Monthly Financial Report Available
10. Parent Contact Reminder

## Integration Points

### iGracias Integration
The notification system is designed to integrate with the iGracias system:
- Automatic payment reminder generation based on iGracias data
- Payment confirmation notifications when iGracias processes payments
- Overdue notice automation based on iGracias payment status

### Email Integration
Ready for email service integration:
- Laravel Mail facades prepared in NotificationService
- Template-based email system
- Error handling and retry mechanisms

### WhatsApp Integration
Prepared for WhatsApp Business API:
- WhatsApp-specific notification type
- Phone number validation ready
- API call simulation implemented

## Security Features
- **User Isolation**: Users can only access their own notifications
- **CSRF Protection**: All forms protected with CSRF tokens
- **Input Validation**: Comprehensive validation on all inputs
- **Permission Checks**: Route-level permission checking
- **SQL Injection Protection**: Eloquent ORM prevents SQL injection

## Performance Considerations
- **Database Indexing**: Proper indexes on user_id, status, type, category
- **Pagination**: Efficient pagination for large notification lists
- **AJAX Operations**: Non-blocking operations for better UX
- **Eager Loading**: Optimized database queries with relationships

## Future Enhancements
1. **Real-time Notifications**: WebSocket integration for live updates
2. **Email Templates**: Rich HTML email templates
3. **Push Notifications**: Browser push notification support
4. **Notification Preferences**: User-configurable notification settings
5. **Analytics Dashboard**: Advanced reporting and analytics
6. **Multi-language Support**: Internationalization for notifications
7. **Attachment Support**: File attachments for notifications
8. **Delivery Reports**: Detailed delivery status tracking

## Usage Examples

### Sending a Payment Reminder
```php
$notificationService = new NotificationService();
$user = User::find(1);
$paymentData = [
    'amount' => 15000000,
    'due_date' => '2024-01-25',
    'fee_type' => 'Tuition Fee'
];

$notification = $notificationService->sendPaymentReminder($user, $paymentData);
```

### Processing Scheduled Notifications
```bash
# Can be run as a scheduled job
php artisan tinker
>>> app(NotificationService::class)->processScheduledNotifications();
```

### Getting User Statistics
```php
$stats = app(NotificationService::class)->getStatistics(Auth::user());
```

This notification system provides a solid foundation for the STEFIA application's communication needs and can be easily extended to meet additional requirements as the system grows.

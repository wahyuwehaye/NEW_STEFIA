<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function general()
    {
        $settings = [
            'system' => [
                'app_name' => 'STEFIA',
                'app_version' => '1.0.0',
                'timezone' => 'Asia/Jakarta',
                'language' => 'en',
                'maintenance_mode' => false,
                'debug_mode' => false
            ],
            'email' => [
                'mail_driver' => 'smtp',
                'mail_host' => 'smtp.gmail.com',
                'mail_port' => 587,
                'mail_encryption' => 'tls',
                'mail_from_address' => 'noreply@stefia.edu',
                'mail_from_name' => 'STEFIA System'
            ],
            'payment' => [
                'currency' => 'IDR',
                'payment_methods' => ['bank_transfer', 'credit_card', 'cash'],
                'late_fee_percentage' => 5,
                'payment_deadline_days' => 30
            ],
            'academic' => [
                'academic_year' => '2024/2025',
                'semester' => 'Semester 2',
                'registration_open' => true,
                'max_credit_hours' => 24
            ]
        ];
        
        return view('settings.general', compact('settings'));
    }
    
    public function users()
    {
        return view('settings.users');
    }
    
    public function permissions()
    {
        return view('settings.permissions');
    }

    public function integration()
    {
        $integrations = [
            'igracias' => [
                'name' => 'IGRACIAS',
                'description' => 'Integrated academic system for student data synchronization',
                'status' => 'active',
                'last_sync' => '2025-01-11 08:30:00',
                'sync_frequency' => 'daily',
                'endpoints' => [
                    'students' => 'https://api.igracias.edu/v1/students',
                    'payments' => 'https://api.igracias.edu/v1/payments',
                    'fees' => 'https://api.igracias.edu/v1/fees'
                ]
            ],
            'payment_gateway' => [
                'name' => 'Payment Gateway',
                'description' => 'Integration with multiple payment providers',
                'status' => 'active',
                'providers' => [
                    'midtrans' => ['status' => 'active', 'last_transaction' => '2025-01-11 10:15:00'],
                    'gopay' => ['status' => 'active', 'last_transaction' => '2025-01-11 09:45:00'],
                    'dana' => ['status' => 'inactive', 'last_transaction' => null]
                ]
            ],
            'whatsapp_api' => [
                'name' => 'WhatsApp Business API',
                'description' => 'Send notifications and reminders via WhatsApp',
                'status' => 'active',
                'phone_number' => '+62812345678',
                'verified' => true,
                'messages_sent_today' => 45
            ],
            'email_service' => [
                'name' => 'Email Service',
                'description' => 'Email notifications and communications',
                'status' => 'active',
                'provider' => 'Gmail SMTP',
                'daily_quota' => 500,
                'emails_sent_today' => 23
            ]
        ];
        
        return view('settings.integration', compact('integrations'));
    }

    public function backup()
    {
        $backups = [
            'automatic' => [
                'enabled' => true,
                'frequency' => 'daily',
                'time' => '02:00',
                'retention_days' => 30,
                'last_backup' => '2025-01-11 02:00:00',
                'backup_size' => '2.5 GB'
            ],
            'recent_backups' => [
                [
                    'filename' => 'stefia_backup_2025-01-11_02-00-00.sql',
                    'size' => '2.5 GB',
                    'type' => 'automatic',
                    'created_at' => '2025-01-11 02:00:00',
                    'status' => 'completed'
                ],
                [
                    'filename' => 'stefia_backup_2025-01-10_02-00-00.sql',
                    'size' => '2.4 GB',
                    'type' => 'automatic',
                    'created_at' => '2025-01-10 02:00:00',
                    'status' => 'completed'
                ],
                [
                    'filename' => 'stefia_manual_backup_2025-01-09_14-30-00.sql',
                    'size' => '2.4 GB',
                    'type' => 'manual',
                    'created_at' => '2025-01-09 14:30:00',
                    'status' => 'completed'
                ]
            ],
            'storage' => [
                'total_space' => '100 GB',
                'used_space' => '45.2 GB',
                'available_space' => '54.8 GB',
                'backup_location' => '/storage/backups/',
                'cloud_backup' => [
                    'enabled' => true,
                    'provider' => 'Google Drive',
                    'last_upload' => '2025-01-11 02:15:00'
                ]
            ]
        ];
        
        return view('settings.backup', compact('backups'));
    }
}

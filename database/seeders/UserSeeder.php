<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@stefia.com'],
            [
                'name' => 'Super Admin',
                'role' => 'super_admin',
                'phone' => '+1234567890',
                'address' => 'STEFIA Headquarters',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'is_active' => true,
                'is_approved' => true,
                'approved_at' => now(),
                'approved_by' => 1,
            ]
        );

        // Create Admin
        User::updateOrCreate(
            ['email' => 'admin@stefia.com'],
            [
                'name' => 'Admin User',
                'role' => 'super_admin',
                'phone' => '+1234567891',
                'address' => 'STEFIA Office',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'is_active' => true,
                'is_approved' => true,
                'approved_at' => now(),
                'approved_by' => 1,
            ]
        );

        // Create Finance Officer
        User::updateOrCreate(
            ['email' => 'finance@stefia.com'],
            [
                'name' => 'Finance Officer',
                'role' => 'finance',
                'phone' => '+1234567892',
                'address' => 'Finance Department',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        // Create Staff
        User::updateOrCreate(
            ['email' => 'staff@stefia.com'],
            [
                'name' => 'Staff Member',
                'role' => 'staff',
                'phone' => '+1234567893',
                'address' => 'STEFIA Office',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        // Create Regular User
        User::updateOrCreate(
            ['email' => 'user@stefia.com'],
            [
                'name' => 'Regular User',
                'role' => 'user',
                'phone' => '+1234567894',
                'address' => 'User Address',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        // Create Demo Student
        User::updateOrCreate(
            ['email' => 'student@stefia.com'],
            [
                'name' => 'John Doe',
                'role' => 'student',
                'phone' => '+1234567895',
                'address' => 'Student Dormitory',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        // Create additional test users with factory
        User::factory(10)->create();
    }
}

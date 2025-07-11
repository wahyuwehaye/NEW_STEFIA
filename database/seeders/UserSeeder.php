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
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@stefia.com',
            'role' => 'super_admin',
            'phone' => '+1234567890',
            'address' => 'STEFIA Headquarters',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@stefia.com',
            'role' => 'admin',
            'phone' => '+1234567891',
            'address' => 'STEFIA Office',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Create Finance Officer
        User::create([
            'name' => 'Finance Officer',
            'email' => 'finance@stefia.com',
            'role' => 'finance',
            'phone' => '+1234567892',
            'address' => 'Finance Department',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Create Staff
        User::create([
            'name' => 'Staff Member',
            'email' => 'staff@stefia.com',
            'role' => 'staff',
            'phone' => '+1234567893',
            'address' => 'STEFIA Office',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Create Regular User
        User::create([
            'name' => 'Regular User',
            'email' => 'user@stefia.com',
            'role' => 'user',
            'phone' => '+1234567894',
            'address' => 'User Address',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Create Demo Student
        User::create([
            'name' => 'John Doe',
            'email' => 'student@stefia.com',
            'role' => 'student',
            'phone' => '+1234567895',
            'address' => 'Student Dormitory',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Create additional test users with factory
        User::factory(10)->create();
    }
}

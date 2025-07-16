<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin user
        User::updateOrCreate([
            'email' => 'admin@stefia.com',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password123'), // Change this password
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        // Create Finance Admin user
        User::updateOrCreate([
            'email' => 'finance@stefia.com',
        ], [
            'name' => 'Finance Admin',
            'password' => Hash::make('password123'), // Change this password
            'role' => 'finance',
            'is_active' => true,
        ]);

        // Create Regular Admin user
        User::updateOrCreate([
            'email' => 'admin.user@stefia.com',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('password123'), // Change this password
            'role' => 'admin',
            'is_active' => true,
        ]);
    }
}

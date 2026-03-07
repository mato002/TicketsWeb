<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists
        $existingAdmin = \App\Models\Admin::where('email', 'admin@concerthub.com')->first();
        
        if (!$existingAdmin) {
            Admin::create([
                'name' => 'Admin User',
                'email' => 'admin@concerthub.com',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]);
        }
    }
}
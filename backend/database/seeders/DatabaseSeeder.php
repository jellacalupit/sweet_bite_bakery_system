<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed categories
        $this->call([
            CategorySeeder::class,
        ]);

        // Create Admin User
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin12345'),
                'role' => 'admin',
                'phone' => '1234567890',
                'address' => 'Admin Address',
                'email_verified_at' => now(),
            ]
        );

        // Create Customer User
        User::firstOrCreate(
            ['email' => 'test@gmail.com'],
            [
                'name' => 'Test Customer',
                'email' => 'test@gmail.com',
                'password' => Hash::make('test12345'),
                'role' => 'user', // Will be normalized to 'customer' on frontend
                'phone' => '0987654321',
                'address' => '123 Customer Street',
                'email_verified_at' => now(),
            ]
        );
    }
}

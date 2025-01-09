<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Listing;
use Illuminate\Database\Seeder;
use App\Models\UserAccount;
use App\Models\UserInformation;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
     /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Check if the email already exists
        $adminAccount = UserAccount::firstOrCreate(
            ['email' => 'admin@library.com'], // Check by email
            ['password' => Hash::make('password123')] // Create if not exists
        );

        // Create the corresponding user information for the admin
        UserInformation::firstOrCreate(
            ['email' => 'admin@library.com'], // Check by email
            [
                'name' => 'Admin User',
                'role' => 'admin',
                'status' => 'active',
                'contact_number' => '1234567890',
                'user_accounts_id' => $adminAccount->id,
            ]
        );

        // Create 5 non-admin user accounts and corresponding user information
    UserAccount::factory(5)->create()->each(function ($userAccount) {
        UserInformation::factory()->create([
            'user_accounts_id' => $userAccount->id, // Link to user account
            'email' => $userAccount->email, // Match email with the user account
            'role' => 'faculty', // Non-admin role
        ]);
    });
       User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}

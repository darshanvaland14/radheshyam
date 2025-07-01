<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Create a new admin user
        $admin = User::create([
            'name' => 'NB Super Admin',
            'email' => 'navbharat@support.com',
            'password' => Hash::make('Navbharat@2024'),  // Change 'password123' to the desired admin password
        ]);

        // Assign the admin role to the user
        $admin->assignRole('admin');  // Assuming 'admin' role exists
    }
}

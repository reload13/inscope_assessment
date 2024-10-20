<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserRole;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole(UserRole::Admin);

        $moderator = User::create([
            'name' => 'Moderator User',
            'email' => 'moderator@example.com',
            'password' => Hash::make('password'),
        ]);
        $moderator->assignRole(UserRole::Moderator);

        $user = User::create([
            'name' => 'Some Moderator User',
            'email' => 'moderator2@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole(UserRole::Moderator);
    }
}

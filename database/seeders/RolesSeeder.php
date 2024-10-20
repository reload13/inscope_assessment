<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Role::create(['name' => UserRole::getName(UserRole::Admin())]);
        Role::create(['name' => UserRole::getName(UserRole::Moderator())]);
    }
}

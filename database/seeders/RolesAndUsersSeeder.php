<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndUsersSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole   = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $userRole    = Role::firstOrCreate(['name' => 'user']);

        // Create an admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );
        $admin->syncRoles([$adminRole]);

        // Create a manager user
        $manager = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name'     => 'Manager User',
                'password' => Hash::make('password'),
            ]
        );
        $manager->syncRoles([$managerRole]);

        // Create a normal user
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name'     => 'Normal User',
                'password' => Hash::make('password'),
            ]
        );
        $user->syncRoles([$userRole]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'display_name' => 'Administrator'],
            ['name' => 'collector', 'display_name' => 'Collector'],
            ['name' => 'user', 'display_name' => 'Citizen'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                ['display_name' => $role['display_name']]
            );
        }

        // Create Default Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@ewaste.com'],
            [
                'name' => 'Riad Sarker',
                'password' => Hash::make('password'),
                'is_active' => true
            ]
        );
        $admin->assignRole('admin');

        // Create Sample Collector
        $collector = User::firstOrCreate(
            ['email' => 'collector@ewaste.com'],
            [
                'name' => 'RH-Joy',
                'password' => Hash::make('password'),
                'is_active' => true
            ]
        );
        $collector->assignRole('collector');

        // Create Sample User
        $user = User::firstOrCreate(
            ['email' => 'user@ewaste.com'],
            [
                'name' => 'Nasir Uddin',
                'password' => Hash::make('password'),
                'is_active' => true
            ]
        );
        $user->assignRole('user');
    }
}

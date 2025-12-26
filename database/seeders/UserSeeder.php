<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  public function run(): void
  {
    // Ensure roles exist
    $adminRole = Role::where('name', 'admin')->first();
    $collectorRole = Role::where('name', 'collector')->first();
    $userRole = Role::where('name', 'user')->first();

    // Create Admin User
    $admin = User::updateOrCreate(
      ['email' => 'admin@ewaste.com'],
      [
        'name' => 'Riad Sarker',
        'password' => Hash::make('password'),
        'is_active' => true
      ]
    );
    $admin->assignRole('admin');

    // Create Collector User
    $collector = User::updateOrCreate(
      ['email' => 'collector@ewaste.com'],
      [
        'name' => 'RH-Joy',
        'password' => Hash::make('password'),
        'is_active' => true
      ]
    );
    $collector->assignRole('collector');

    // Create Regular User
    $user = User::updateOrCreate(
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

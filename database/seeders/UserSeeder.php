<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@savornest.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
            'bio' => 'Platform administrator ensuring a wonderful cooking experience for everyone.',
        ]);

        User::create([
            'name' => 'Jane Cook',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'status' => 'active',
            'bio' => 'Home chef with a passion for baking.',
        ]);

        User::create([
            'name' => 'John Foodie',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'status' => 'active',
        ]);
    }
}

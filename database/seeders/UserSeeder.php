<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test.user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'test.admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }
}

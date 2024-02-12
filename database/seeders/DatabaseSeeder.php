<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'emp_id' => '111111',
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '123456',
            'phone' => '987654321',
            'department' => '6',
            'role' => '1',
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
         User::insert([
            [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'phone' => '081234567891',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Doctor User',
                'email' => 'doctor@gmail.com',
                'phone' => '081234567892',
                'role' => 'doctor',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Pharmacist User',
                'email' => 'pharmacist@gmail.com',
                'phone' => '081234567893',
                'role' => 'pharmacist',
                'password' => Hash::make('password'),
            ],
        ]);
    }
}

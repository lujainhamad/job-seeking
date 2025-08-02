<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@email.com',
                'password' => Hash::make('password123'),
                'birthdate' => '1995-03-15',
                'phone' => '+1-555-0101',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@email.com',
                'password' => Hash::make('password123'),
                'birthdate' => '1992-07-22',
                'phone' => '+1-555-0102',
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael.chen@email.com',
                'password' => Hash::make('password123'),
                'birthdate' => '1988-11-08',
                'phone' => '+1-555-0103',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
} 
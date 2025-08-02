<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'name' => 'TechCorp Solutions',
                'email' => 'hr@techcorp.com',
                'password' => Hash::make('password123'),
                'address' => '123 Innovation Drive, Silicon Valley, CA 94025',
                'is_active' => true,
            ],
            [
                'name' => 'Global Innovations Ltd',
                'email' => 'careers@globalinnovations.com',
                'password' => Hash::make('password123'),
                'address' => '456 Business Park, New York, NY 10001',
                'is_active' => true,
            ],
            [
                'name' => 'Digital Dynamics',
                'email' => 'jobs@digitaldynamics.com',
                'password' => Hash::make('password123'),
                'address' => '789 Tech Street, Austin, TX 73301',
                'is_active' => true,
            ],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
} 
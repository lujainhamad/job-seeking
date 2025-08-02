<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'birthdate' => '2000-08-24',
            'phone' => '0937785301'
        ]);

        $this->call([
            AdminSeeder::class,
            EducationSeeder::class,
            SkillSeeder::class,
            LanguageSeeder::class,
            CompanySeeder::class,
            UserSeeder::class,
            ResumeSeeder::class,
            JobSeeder::class,
            JobOfferDateSeeder::class,
            JobRelationsSeeder::class,
            JobApplicationSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class JobApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = Job::all();
        $users = User::all();

        if ($jobs->isEmpty() || $users->isEmpty()) {
            $this->command->error('No jobs or users found. Please run JobSeeder and UserSeeder first.');
            return;
        }

        // Define realistic job applications
        $applications = [
            // John Smith (Software Engineer) applications
            [
                'user' => $users[0], // John Smith
                'job' => $jobs[0], // Senior Software Engineer at TechCorp
                'initial_salary' => 125000,
                'interview_status' => 'approved',
                'is_approved' => true,
                'interview_date' => Carbon::now()->addDays(7),
            ],
            [
                'user' => $users[0], // John Smith
                'job' => $jobs[1], // Junior Frontend Developer at TechCorp
                'initial_salary' => 70000,
                'interview_status' => 'rejected',
                'is_approved' => false,
                'interview_date' => null,
            ],
            [
                'user' => $users[0], // John Smith
                'job' => $jobs[4], // DevOps Engineer at Digital Dynamics
                'initial_salary' => 90000,
                'interview_status' => 'pending',
                'is_approved' => false,
                'interview_date' => Carbon::now()->addDays(14),
            ],

            // Sarah Johnson (Data Scientist) applications
            [
                'user' => $users[1], // Sarah Johnson
                'job' => $jobs[2], // Data Scientist at Global Innovations
                'initial_salary' => 100000,
                'interview_status' => 'approved',
                'is_approved' => true,
                'interview_date' => Carbon::now()->addDays(5),
            ],
            [
                'user' => $users[1], // Sarah Johnson
                'job' => $jobs[3], // Product Manager at Global Innovations
                'initial_salary' => 115000,
                'interview_status' => 'pending',
                'is_approved' => false,
                'interview_date' => Carbon::now()->addDays(10),
            ],
            [
                'user' => $users[1], // Sarah Johnson
                'job' => $jobs[5], // UX/UI Designer at Digital Dynamics
                'initial_salary' => 80000,
                'interview_status' => 'rejected',
                'is_approved' => false,
                'interview_date' => null,
            ],

            // Michael Chen (Product Manager) applications
            [
                'user' => $users[2], // Michael Chen
                'job' => $jobs[3], // Product Manager at Global Innovations
                'initial_salary' => 120000,
                'interview_status' => 'approved',
                'is_approved' => true,
                'interview_date' => Carbon::now()->addDays(3),
            ],
            [
                'user' => $users[2], // Michael Chen
                'job' => $jobs[0], // Senior Software Engineer at TechCorp
                'initial_salary' => 110000,
                'interview_status' => 'rejected',
                'is_approved' => false,
                'interview_date' => null,
            ],
            [
                'user' => $users[2], // Michael Chen
                'job' => $jobs[4], // DevOps Engineer at Digital Dynamics
                'initial_salary' => 95000,
                'interview_status' => 'pending',
                'is_approved' => false,
                'interview_date' => Carbon::now()->addDays(12),
            ],
        ];

        foreach ($applications as $application) {
            $application['user']->jobOffers()->attach($application['job']->id, [
                'initial_salary' => $application['initial_salary'],
                'interview_status' => $application['interview_status'],
                'is_approved' => $application['is_approved'],
                'interview_date' => $application['interview_date'],
            ]);
        }

        $this->command->info('Job applications created successfully!');
        $this->command->info('Created ' . count($applications) . ' job applications.');
    }
} 
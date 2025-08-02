<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\Company;
use App\Models\Education;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get companies and education records
        $companies = Company::all();
        $educations = Education::all();
        
        if ($educations->isEmpty()) {
            $this->command->error('No education records found. Please run EducationSeeder first.');
            return;
        }

        $jobs = [
            // TechCorp Solutions Jobs
            [
                'company_id' => $companies[0]->id,
                'education_id' => $educations->random()->id,
                'job_title' => 'Senior Software Engineer',
                'salary' => 120000.00,
                'experience' => 5,
                'age' => 30,
                'job_type' => 'full-time',
                'gender' => 'none',
                'job_level' => 'senior',
                'application_deadline' => Carbon::now()->addMonths(2),
                'requirements' => 'Expert in JavaScript, React, Node.js. Experience with microservices architecture.',
                'skills_weight' => 60,
                'education_weight' => 20,
                'experience_weight' => 15,
                'lang_weight' => 5,
            ],
            [
                'company_id' => $companies[0]->id,
                'education_id' => $educations->random()->id,
                'job_title' => 'Junior Frontend Developer',
                'salary' => 65000.00,
                'experience' => 1,
                'age' => 25,
                'job_type' => 'full-time',
                'gender' => 'none',
                'job_level' => 'junior',
                'application_deadline' => Carbon::now()->addMonths(1),
                'requirements' => 'Knowledge of HTML, CSS, JavaScript. Familiarity with React is a plus.',
                'skills_weight' => 70,
                'education_weight' => 20,
                'experience_weight' => 5,
                'lang_weight' => 5,
            ],

            // Global Innovations Ltd Jobs
            [
                'company_id' => $companies[1]->id,
                'education_id' => $educations->random()->id,
                'job_title' => 'Data Scientist',
                'salary' => 95000.00,
                'experience' => 3,
                'age' => 28,
                'job_type' => 'full-time',
                'gender' => 'none',
                'job_level' => 'middle',
                'application_deadline' => Carbon::now()->addMonths(3),
                'requirements' => 'Strong background in statistics, Python, machine learning algorithms.',
                'skills_weight' => 50,
                'education_weight' => 30,
                'experience_weight' => 15,
                'lang_weight' => 5,
            ],
            [
                'company_id' => $companies[1]->id,
                'education_id' => $educations->random()->id,
                'job_title' => 'Product Manager',
                'salary' => 110000.00,
                'experience' => 4,
                'age' => 32,
                'job_type' => 'full-time',
                'gender' => 'none',
                'job_level' => 'senior',
                'application_deadline' => Carbon::now()->addMonths(2),
                'requirements' => 'Experience in product strategy, user research, agile methodologies.',
                'skills_weight' => 40,
                'education_weight' => 25,
                'experience_weight' => 30,
                'lang_weight' => 5,
            ],

            // Digital Dynamics Jobs
            [
                'company_id' => $companies[2]->id,
                'education_id' => $educations->random()->id,
                'job_title' => 'DevOps Engineer',
                'salary' => 85000.00,
                'experience' => 3,
                'age' => 29,
                'job_type' => 'full-time',
                'gender' => 'none',
                'job_level' => 'middle',
                'application_deadline' => Carbon::now()->addMonths(2),
                'requirements' => 'Experience with AWS, Docker, Kubernetes, CI/CD pipelines.',
                'skills_weight' => 65,
                'education_weight' => 15,
                'experience_weight' => 15,
                'lang_weight' => 5,
            ],
            [
                'company_id' => $companies[2]->id,
                'education_id' => $educations->random()->id,
                'job_title' => 'UX/UI Designer',
                'salary' => 75000.00,
                'experience' => 2,
                'age' => 26,
                'job_type' => 'full-time',
                'gender' => 'none',
                'job_level' => 'middle',
                'application_deadline' => Carbon::now()->addMonths(1),
                'requirements' => 'Proficiency in Figma, Adobe Creative Suite, user research methods.',
                'skills_weight' => 60,
                'education_weight' => 20,
                'experience_weight' => 15,
                'lang_weight' => 5,
            ],
        ];

        foreach ($jobs as $job) {
            Job::create($job);
        }
    }
} 
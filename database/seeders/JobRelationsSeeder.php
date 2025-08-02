<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\Skill;
use App\Models\Language;
use Illuminate\Database\Seeder;

class JobRelationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = Job::all();
        $skills = Skill::all();
        $languages = Language::all();

        if ($skills->isEmpty() || $languages->isEmpty()) {
            $this->command->error('No skills or languages found. Please run SkillSeeder and LanguageSeeder first.');
            return;
        }

        // Define job-specific skills and languages
        $jobRequirements = [
            'Senior Software Engineer' => [
                'skills' => ['JavaScript', 'React', 'Node.js', 'TypeScript', 'Git'],
                'languages' => ['English', 'Spanish']
            ],
            'Junior Frontend Developer' => [
                'skills' => ['HTML', 'CSS', 'JavaScript', 'React', 'Bootstrap'],
                'languages' => ['English']
            ],
            'Data Scientist' => [
                'skills' => ['Python', 'R', 'Machine Learning', 'Statistics', 'SQL'],
                'languages' => ['English', 'French']
            ],
            'Product Manager' => [
                'skills' => ['Product Strategy', 'User Research', 'Agile', 'Analytics', 'Communication'],
                'languages' => ['English', 'German']
            ],
            'DevOps Engineer' => [
                'skills' => ['AWS', 'Docker', 'Kubernetes', 'Linux', 'CI/CD'],
                'languages' => ['English']
            ],
            'UX/UI Designer' => [
                'skills' => ['Figma', 'Adobe Creative Suite', 'User Research', 'Prototyping', 'Design Systems'],
                'languages' => ['English', 'Italian']
            ],
        ];

        foreach ($jobs as $job) {
            $requirements = $jobRequirements[$job->job_title] ?? [
                'skills' => $skills->random(3)->pluck('name')->toArray(),
                'languages' => $languages->random(2)->pluck('name')->toArray()
            ];

            // Attach skills
            $jobSkills = $skills->whereIn('name', $requirements['skills']);
            if ($jobSkills->isNotEmpty()) {
                $job->skills()->attach($jobSkills->pluck('id')->toArray());
            }

            // Attach languages
            $jobLanguages = $languages->whereIn('name', $requirements['languages']);
            if ($jobLanguages->isNotEmpty()) {
                $job->languages()->attach($jobLanguages->pluck('id')->toArray());
            }
        }
    }
} 
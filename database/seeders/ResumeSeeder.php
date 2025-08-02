<?php

namespace Database\Seeders;

use App\Models\Resume;
use App\Models\Experience;
use App\Models\User;
use App\Models\Skill;
use App\Models\Language;
use App\Models\Education;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ResumeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $skills = Skill::all();
        $languages = Language::all();
        $educations = Education::all();

        if ($users->isEmpty() || $skills->isEmpty() || $languages->isEmpty() || $educations->isEmpty()) {
            $this->command->error('Required data not found. Please run UserSeeder, SkillSeeder, LanguageSeeder, and EducationSeeder first.');
            return;
        }

        $resumeData = [
            [
                'user' => $users[0], // John Smith
                'resume' => [
                    'title' => 'Senior Software Engineer Resume',
                    'about' => 'Experienced software engineer with 5+ years of expertise in full-stack development, specializing in JavaScript, React, and Node.js. Passionate about creating scalable web applications and mentoring junior developers.',
                    'main_field' => 'Software Development',
                    'second_field' => 'Web Development',
                ],
                'experiences' => [
                    [
                        'name' => 'Senior Software Engineer',
                        'description' => 'Led development of microservices architecture, mentored junior developers, and implemented CI/CD pipelines. Technologies: React, Node.js, TypeScript, Docker.',
                        'start_date' => '2021-03-01',
                        'end_date' => null, // Current job
                    ],
                    [
                        'name' => 'Full Stack Developer',
                        'description' => 'Developed and maintained web applications using React and Node.js. Collaborated with cross-functional teams and participated in code reviews.',
                        'start_date' => '2019-06-01',
                        'end_date' => '2021-02-28',
                    ],
                    [
                        'name' => 'Junior Developer',
                        'description' => 'Started career as a junior developer, learned modern web technologies and best practices. Worked on frontend development with HTML, CSS, and JavaScript.',
                        'start_date' => '2018-01-01',
                        'end_date' => '2019-05-31',
                    ],
                ],
                'skills' => ['JavaScript', 'React', 'Node.js', 'TypeScript', 'Git', 'Docker', 'MongoDB', 'Express.js'],
                'languages' => ['English', 'Spanish'],
                'educations' => ['Computer Science', 'Software Engineering'],
            ],
            [
                'user' => $users[1], // Sarah Johnson
                'resume' => [
                    'title' => 'Data Scientist Resume',
                    'about' => 'Data scientist with strong background in machine learning, statistical analysis, and data visualization. Experienced in Python, R, and SQL. Passionate about turning data into actionable insights.',
                    'main_field' => 'Data Science',
                    'second_field' => 'Machine Learning',
                ],
                'experiences' => [
                    [
                        'name' => 'Data Scientist',
                        'description' => 'Developed machine learning models for predictive analytics, performed statistical analysis, and created data visualizations. Tools: Python, R, SQL, Tableau.',
                        'start_date' => '2020-09-01',
                        'end_date' => null, // Current job
                    ],
                    [
                        'name' => 'Data Analyst',
                        'description' => 'Analyzed large datasets, created reports and dashboards, and provided insights to stakeholders. Used SQL, Python, and Excel for data analysis.',
                        'start_date' => '2018-08-01',
                        'end_date' => '2020-08-31',
                    ],
                ],
                'skills' => ['Python', 'R', 'Machine Learning', 'Statistics', 'SQL', 'Tableau', 'Pandas', 'Scikit-learn'],
                'languages' => ['English', 'French'],
                'educations' => ['Data Science', 'Statistics'],
            ],
            [
                'user' => $users[2], // Michael Chen
                'resume' => [
                    'title' => 'Product Manager Resume',
                    'about' => 'Product manager with 4+ years of experience in product strategy, user research, and agile methodologies. Skilled in leading cross-functional teams and delivering successful products.',
                    'main_field' => 'Product Management',
                    'second_field' => 'Business Strategy',
                ],
                'experiences' => [
                    [
                        'name' => 'Senior Product Manager',
                        'description' => 'Led product strategy for SaaS platform, managed product roadmap, conducted user research, and collaborated with engineering and design teams.',
                        'start_date' => '2020-01-01',
                        'end_date' => null, // Current job
                    ],
                    [
                        'name' => 'Product Manager',
                        'description' => 'Managed product lifecycle, gathered requirements, prioritized features, and worked with development teams to deliver products on time.',
                        'start_date' => '2018-03-01',
                        'end_date' => '2019-12-31',
                    ],
                    [
                        'name' => 'Business Analyst',
                        'description' => 'Analyzed business processes, gathered requirements, and created documentation for software development projects.',
                        'start_date' => '2016-06-01',
                        'end_date' => '2018-02-28',
                    ],
                ],
                'skills' => ['Product Strategy', 'User Research', 'Agile', 'Analytics', 'Communication', 'JIRA', 'Figma', 'SQL'],
                'languages' => ['English', 'German'],
                'educations' => ['Business Administration', 'Marketing'],
            ],
        ];

        foreach ($resumeData as $data) {
            // Create resume
            $resume = Resume::create([
                'user_id' => $data['user']->id,
                'title' => $data['resume']['title'],
                'about' => $data['resume']['about'],
                'main_field' => $data['resume']['main_field'],
                'second_field' => $data['resume']['second_field'],
            ]);

            // Create experiences
            foreach ($data['experiences'] as $exp) {
                Experience::create([
                    'user_id' => $data['user']->id,
                    'resume_id' => $resume->id,
                    'name' => $exp['name'],
                    'description' => $exp['description'],
                    'start_date' => $exp['start_date'],
                    'end_date' => $exp['end_date'],
                ]);
            }

            // Attach skills
            $resumeSkills = $skills->whereIn('name', $data['skills']);
            if ($resumeSkills->isNotEmpty()) {
                $resume->skills()->attach($resumeSkills->pluck('id')->toArray());
            }

            // Attach languages
            $resumeLanguages = $languages->whereIn('name', $data['languages']);
            if ($resumeLanguages->isNotEmpty()) {
                $resume->languages()->attach($resumeLanguages->pluck('id')->toArray());
            }

            // Attach educations
            $resumeEducations = $educations->whereIn('name', $data['educations']);
            if ($resumeEducations->isNotEmpty()) {
                $resume->educations()->attach($resumeEducations->pluck('id')->toArray());
            }
        }
    }
} 
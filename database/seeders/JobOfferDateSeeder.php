<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\JobOfferDate;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class JobOfferDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all jobs
        $jobs = Job::all();
        
        if ($jobs->isEmpty()) {
            $this->command->error('No jobs found. Please run JobSeeder first.');
            return;
        }

        foreach ($jobs as $job) {
            // Create 3-5 interview dates for each job
            $numberOfDates = rand(3, 5);
            
            for ($i = 0; $i < $numberOfDates; $i++) {
                // Generate dates within the next 2 months, avoiding weekends
                $date = Carbon::now()->addDays(rand(7, 60));
                
                // Adjust to next Monday if it's a weekend
                while ($date->isWeekend()) {
                    $date->addDay();
                }
                
                // Set time to business hours (9 AM to 5 PM)
                $date->setTime(rand(9, 17), 0, 0);
                
                JobOfferDate::create([
                    'job_offer_id' => $job->id,
                    'date' => $date,
                ]);
            }
        }

        $this->command->info('Job offer dates seeded successfully!');
    }
} 
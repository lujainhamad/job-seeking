<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $edus = [
            [
                'name' => ['ar'=>'ITE','en'=>'هندسة معلوماتية']
            ],
            [
                'name' => ['ar'=>'Economy','en'=>'اقتصاد']
            ],
        ];

        foreach ($edus as $key => $value) {
            Education::create($value);
        }
    }
}

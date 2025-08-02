<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            [
                'name' => ['en'=>'Laravel','ar'=>'لارفل']
            ],
            [
                'name' => ['en'=>'Flutter','ar'=>'فلاتر']
            ],
            [
                'name' => ['en'=>'Problem solving','ar'=>'حل مشكلات']
            ]
        ];

        foreach ($skills as $key => $value) {
            Skill::create($value);
        }
    }
}

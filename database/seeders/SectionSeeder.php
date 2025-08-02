<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $secs = [
            [
                'name' => ['ar'=>'ITE','en'=>'Human resources']
            ],
            [
                'name' => ['ar'=>'Economy','en'=>'اقتصاد']
            ],
        ];

        foreach ($secs as $key => $sec) {
            Section::create($sec);
        }
    }
}

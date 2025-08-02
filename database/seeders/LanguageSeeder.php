<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
          [
            'name' => ['en'=>'English','ar'=>'الانجليزية'],
          ],
          [
            'name' => ['en'=>'Arabic','ar'=>'العربية'],
          ]  
        ];

        foreach ($languages as $key => $language) {
            Language::create($language);
        }
    }
}

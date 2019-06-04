<?php

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    public function run()
    {
        $languages = [
            [
                'language' => 'English',
                'required' => 1
            ]
        ];

        foreach($languages as $language) {
            Language::updateOrCreate([
                'language' => $language['language']
            ], [
                'required' => $language['required']
            ]);
        }
    }
}

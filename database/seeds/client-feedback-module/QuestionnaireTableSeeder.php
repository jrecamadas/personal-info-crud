<?php

use App\Models\ClientFeedback\Questionnaire;

use Illuminate\Database\Seeder;

class QuestionnaireTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Questionnaire::updateOrCreate([
            'name' => 'Default Survey'
        ]);
    }
}

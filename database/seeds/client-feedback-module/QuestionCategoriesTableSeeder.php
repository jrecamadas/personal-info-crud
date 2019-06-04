<?php

use Illuminate\Database\Seeder;

use App\Models\ClientFeedback\QuestionCategory;
use App\Models\ClientFeedback\Questionnaire;

class QuestionCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $q = (new Questionnaire)->where('name', 'Default Survey')->first();

        $data = [
            [
                'questionnaire_id' => $q->id,
                'name' => 'OVERALL',
                'display_sequence' => 1
            ],
            [
                'questionnaire_id' => $q->id,
                'name' => 'PERFORMANCE',
                'display_sequence' => 2
            ],
            [
                'questionnaire_id' => $q->id,
                'name' => 'DELIVERY AND COMMITMENT',
                'display_sequence' => 3
            ]
        ];

        foreach($data as $v) {
            QuestionCategory::updateOrCreate($v);
        }
    }
}

<?php

use Illuminate\Database\Seeder;

use App\Models\ClientFeedback\QuestionCategory;
use App\Models\ClientFeedback\Question;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $c1 = (new QuestionCategory)->where('name', 'OVERALL')->first();
        $c2 = (new QuestionCategory)->where('name', 'PERFORMANCE')->first();
        $c3 = (new QuestionCategory)->where('name', 'DELIVERY AND COMMITMENT')->first();

        $data = [
            [
                'question_category_id' => $c1->id,
                'question' => 'Satisfaction with our services',
                'display_sequence' => 1
            ],
            [
                'question_category_id' => $c1->id,
                'question' => 'Satisfaction with your team',
                'display_sequence' => 2
            ],
            [
                'question_category_id' => $c1->id,
                'question' => 'Cost-effectiveness of our services',
                'display_sequence' => 3
            ],
            [
                'question_category_id' => $c2->id,
                'question' => 'Technical Skills and Business Knowledge',
                'display_sequence' => 1
            ],
            [
                'question_category_id' => $c2->id,
                'question' => 'Quality',
                'display_sequence' => 2
            ],
            [
                'question_category_id' => $c2->id,
                'question' => 'Attitude Towards Work',
                'display_sequence' => 3
            ],
            [
                'question_category_id' => $c3->id,
                'question' => 'Adherence to policies, standards, and work procedures',
                'display_sequence' => 1
            ],
            [
                'question_category_id' => $c3->id,
                'question' => 'Communications, Collaboration, and Teamwork',
                'display_sequence' => 2
            ],
            [
                'question_category_id' => $c3->id,
                'question' => 'Commitment and On-time Delivery',
                'display_sequence' => 3
            ],
            [
                'question_category_id' => $c3->id,
                'question' => 'How likely is it that you would use our services for different projects again?',
                'display_sequence' => 4
            ],
            [
                'question_category_id' => $c3->id,
                'question' => 'How likely is it that you would recommend us to a friend or business partner?',
                'display_sequence' => 5
            ]
        ];

        foreach($data as $v) {
            Question::updateOrCreate($v);
        }
    }
}

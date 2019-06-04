<?php

use Illuminate\Database\Seeder;

use App\Models\AllQuestion as Question;
use App\Models\AllQuestionChoice as QuestionChoice;
use App\Models\AllQuestionCategory as QuestionCategory;
use App\Models\Skill;

class InitialAllQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryId = $this->insertInitialCategory();
        $questions = $this->setQuestionsWithChoices(); // with choices

        foreach ($questions as $q) {
            $choices = $q['choices'];
            unset($q['choices']);
            $q['all_question_category_id'] = $categoryId;
            $question = Question::create($q);
            $choice = [];

            foreach ($choices as $c) {
                $choice[] = new QuestionChoice($c);
            }

            $question->questionChoices()->saveMany($choice);
        }
    }

    private function insertInitialCategory()
    {
        $category = new QuestionCategory();
        $category->name = 'client-onboarding';
        $category->save();

        return $category->id;
    }

    /**
     * setQuestionsWithChoices
     * To set array of data for questions with it's choices
     *
     * @return void
     */
    private function setQuestionsWithChoices()
    {
        return [
            [
                'description' => 'What is the name of your company?',
                'type' => 'short_text',
                'form_label' => 'company_name',
                'page' => 1,
                'display_sequence' => 1,
                'required' => 1,
                'choices' => [],
            ],
            [
                'description' => 'How soon are you thinking about getting started?',
                'type' => 'single_response',
                'form_label' => 'project_start',
                'page' => 1,
                'display_sequence' => 2,
                'required' => 1,
                'choices' => [
                    [
                        'description' => "I'm ready to start now",
                        'display_sequence' => 1,
                    ],
                    [
                        'description' => 'In less than 30 days',
                        'display_sequence' => 2,
                    ],
                    [
                        'description' => 'More than 30 days from now',
                        'display_sequence' => 3,
                    ],
                ],
            ],
            [
                'description' => 'What is your zip code?',
                'type' => 'short_text',
                'form_label' => 'zip_code',
                'page' => 1,
                'display_sequence' => 3,
                'required' => 1,
                'choices' => [],
            ],
            [
                'description' => 'What time is your business open?',
                'type' => 'multiple_response',
                'form_label' => 'business_hour',
                'page' => 1,
                'display_sequence' => 4,
                'required' => 1,
                'choices' => [
                    [
                        'description' => 'Normal daytime hours',
                        'display_sequence' => 1,
                    ],
                    [
                        'description' => 'Morning and Late',
                        'display_sequence' => 2,
                    ],
                    [
                        'description' => 'We never close',
                        'display_sequence' => 3,
                    ],
                ],
            ],
            [
                'description' => 'What time of day would you like your team to work?',
                'type' => 'multiple_response',
                'form_label' => 'work_hour',
                'page' => 1,
                'display_sequence' => 5,
                'required' => 1,
                'choices' => [
                    [
                        'description' => 'Overlap some with our morning hours',
                        'display_sequence' => 1,
                    ],
                    [
                        'description' => 'Overlap some with our evening hours',
                        'display_sequence' => 2,
                    ],
                    [
                        'description' => 'During the same hours we are open',
                        'display_sequence' => 3,
                    ],
                    [
                        'description' => 'Overnight so we can rest too',
                        'display_sequence' => 4,
                    ],
                    [
                        'description' => 'No Preference',
                        'display_sequence' => 5,
                    ],
                ],
            ],
            [
                'description' => 'What will your new team members do for you?',
                'type' => 'multiple_response',
                'form_label' => 'service_need',
                'page' => 1,
                'display_sequence' => 6,
                'required' => 1,
                'choices' => [
                    [
                        'description' => 'Programming',
                        'display_sequence' => 1,
                    ],
                    [
                        'description' => 'Maintenance',
                        'display_sequence' => 2,
                    ],
                    [
                        'description' => 'QA Testing',
                        'display_sequence' => 3,
                    ],
                    [
                        'description' => 'Automation',
                        'display_sequence' => 4,
                    ],
                    [
                        'description' => 'Creative Stuff',
                        'display_sequence' => 5,
                    ],
                    [
                        'description' => 'Mobile App Development',
                        'display_sequence' => 6,
                    ],
                    [
                        'description' => 'Other',
                        'display_sequence' => 7,
                    ],
                ],
            ],
            [
                'description' => 'Do you see your needs as?',
                'type' => 'multiple_response',
                'form_label' => 'project_term',
                'page' => 1,
                'display_sequence' => 7,
                'required' => 1,
                'choices' => [
                    [
                        'description' => 'Short-term, maybe more later.',
                        'display_sequence' => 1,
                    ],
                    [
                        'description' => 'Long term, I need to build a team!',
                        'display_sequence' => 2,
                    ],
                ],
            ],
            [
                'description' => 'What technology does/will your product or concept use?',
                'type' => 'multiple_response',
                'form_label' => 'tech_require',
                'page' => 1,
                'display_sequence' => 8,
                'required' => 1,
                'choices' => $this->skillChoices(),
            ],
            [
                'description' => 'What stage is your company or product at?',
                'type' => 'multiple_response',
                'form_label' => 'product_status',
                'page' => 1,
                'display_sequence' => 9,
                'required' => 1,
                'choices' => [
                    [
                        'description' => 'We’ve been around for a while',
                        'display_sequence' => 1,
                    ],
                    [
                        'description' => 'Still gaining traction',
                        'display_sequence' => 2,
                    ],
                    [
                        'description' => 'Pre-revenue but we have something',
                        'display_sequence' => 3,
                    ],
                    [
                        'description' => 'Pre-everything',
                        'display_sequence' => 4,
                    ],
                    [
                        'description' => 'Other',
                        'display_sequence' => 5,
                    ],
                ],
            ],
            [
                'description' => 'Do you currently have a:',
                'type' => 'multiple_response',
                'form_label' => 'current_resource',
                'page' => 1,
                'display_sequence' => 10,
                'required' => 1,
                'choices' => [
                    [
                        'description' => 'Product Manager',
                        'display_sequence' => 1,
                    ],
                    [
                        'description' => 'Product Owner',
                        'display_sequence' => 2,
                    ],
                    [
                        'description' => 'Lead Developer',
                        'display_sequence' => 3,
                    ],
                    [
                        'description' => 'None',
                        'display_sequence' => 4,
                    ],
                ],
            ],
            [
                'description' => 'Have you worked with remote teams before?',
                'type' => 'single_response',
                'form_label' => 'remote_team_exp',
                'page' => 1,
                'display_sequence' => 11,
                'required' => 1,
                'choices' => [
                    [
                        'description' => 'Yes',
                        'display_sequence' => 1,
                    ],
                    [
                        'description' => 'No',
                        'display_sequence' => 2,
                    ],
                ],
            ],
            [
                'description' => 'What types? (If yes)',
                'type' => 'multiple_response',
                'form_label' => 'remote_team_exp_type',
                'page' => 1,
                'display_sequence' => 12,
                'required' => 1,
                'choices' => [
                    [
                        'description' => 'Developers',
                        'display_sequence' => 1,
                    ],
                    [
                        'description' => 'Virtual Assistant',
                        'display_sequence' => 2,
                    ],
                    [
                        'description' => 'Designer',
                        'display_sequence' => 3,
                    ],
                    [
                        'description' => 'Call Center',
                        'display_sequence' => 4,
                    ],
                    [
                        'description' => 'Others',
                        'display_sequence' => 5,
                    ],
                ],
            ],
            [
                'description' => 'What country was your remote team in?',
                'type' => 'multiple_response',
                'form_label' => 'remote_team_exp_country',
                'page' => 1,
                'display_sequence' => 13,
                'required' => 1,
                'choices' => [
                    [
                        'description' => 'Philippines',
                        'display_sequence' => 1,
                    ],
                    [
                        'description' => 'India',
                        'display_sequence' => 2,
                    ],
                    [
                        'description' => 'Eastern Europe',
                        'display_sequence' => 3,
                    ],
                    [
                        'description' => 'South America/Mexico',
                        'display_sequence' => 4,
                    ],
                    [
                        'description' => 'Others',
                        'display_sequence' => 5,
                    ],
                ],
            ],
        ];
    }

    private function skillChoices()
    {
        $skills = Skill::all();
        $results = [];

        foreach ($skills as $key => $skill) {
            $results[] = [
                'description' => $skill->name,
                'display_sequence' => $key + 1,
            ];
        }

        return $results;
    }
}

<?php

use Illuminate\Database\Seeder;

use App\Models\AllQuestion;

class UpdateAllQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Update description and is_active respectively Only
        $updateData = [
            [
                'id'          => 1,
                'description' => 'What is the legal name of your business?',
                'is_active'   => 1
            ],
            [
                'id'          => 3,
                'description' => 'What is your zip code?',
                'is_active'   => 0
            ]
        ];
        //Direct Insert
        $createData = [
            [
                'all_question_category_id' => 1,
                'description'              => 'What is your business address?',
                'type'                     => 'short_text',
                'form_label'               => 'business_address',
                'page'                     => 1,
                'required'                 => 1,
                'display_sequence'         => 2,
                'is_active'                => 1,
            ],
            [
                'all_question_category_id' => 1,
                'description'              => 'What is your business phone?',
                'type'                     => 'short_text',
                'form_label'               => 'business_phone',
                'page'                     => 1,
                'required'                 => 1,
                'display_sequence'         => 3,
                'is_active'                => 1,
            ],
            [
                'all_question_category_id' => 1,
                'description'              => 'Who is the primary contact we can reach out to?',
                'type'                     => 'short_text',
                'form_label'               => 'primary_contact',
                'page'                     => 1,
                'required'                 => 1,
                'display_sequence'         => 4,
                'is_active'                => 1,
            ],
            [
                'all_question_category_id' => 1,
                'description'              => 'What is the email address of the primary contact?',
                'type'                     => 'short_text',
                'form_label'               => 'email_address_primary_contact',
                'page'                     => 1,
                'required'                 => 1,
                'display_sequence'         => 5,
                'is_active'                => 1,
            ],
        ];
        //Update Sequence Only
        $updateSequence = [
            [
                'id'               => 2,
                'display_sequence' => 6,
            ],
            [
                'id'               => 3,
                'display_sequence' => 7,
            ],
            [
                'id'               => 4,
                'display_sequence' => 8,
            ],
            [
                'id'               => 5,
                'display_sequence' => 9,
            ],
            [
                'id'               => 6,
                'display_sequence' => 10,
            ],
            [
                'id'               => 7,
                'display_sequence' => 11,
            ],
            [
                'id'               => 8,
                'display_sequence' => 12,
            ],
            [
                'id'               => 9,
                'display_sequence' => 13,
            ],
            [
                'id'               => 10,
                'display_sequence' => 14,
            ],
            [
                'id'               => 11,
                'display_sequence' => 15,
            ],
            [
                'id'               => 12,
                'display_sequence' => 16,
            ],
            [
                'id'               => 13,
                'display_sequence' => 17,
            ],
        ];

        //Update Only
        foreach ($updateData as $toUpdate) {
            AllQuestion::updateOrCreate(
                [
                    'id' => $toUpdate['id']
                ],
                [
                    'description' => $toUpdate['description'],
                    'is_active'   => $toUpdate['is_active']
                ]
            );
        }
        //Direct Insert
        foreach ($createData as $v) {
            AllQuestion::updateOrCreate($v);
        }


        //Update Sequence Only
        foreach ($updateSequence as $toUpdateSequence) {
            AllQuestion::updateOrCreate(
                [
                    'id' => $toUpdateSequence['id']
                ],
                [
                    'display_sequence' => $toUpdateSequence['display_sequence'],
                ]
            );
        }
    }
}

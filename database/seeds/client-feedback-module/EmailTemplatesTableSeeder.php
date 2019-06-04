<?php

use Illuminate\Database\Seeder;

use App\Models\ClientFeedback\EmailTemplate;

class EmailTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'template_name' => 'Default Email Template',
                'email_subject' => 'What do you think about the team?',
                'email_body' => '<p>Hi {{$contactName}},</p><p>&nbsp;</p><p>I’ve checked with your team members, and it looks like everything is in progress and going well. I am interested to know if there is anything I can assist with especially in these areas:</p><p>&nbsp;</p><ul><li>Communication and Visibility</li><li>Delivery (Commitment, Quality, Skills, Knowledge Transfer)</li><li>Tools</li></ul><p>&nbsp;</p><p>Please take time to take our survey by <a href="{{$surveyLink}}">clicking here</a>.</p><p>&nbsp;</p><p>I would also like to ask for your inputs on how we can improve and help you better.On behalf of our team, we appreciate you taking time in responding to this.</p><p>&nbsp;</p><p>Thank you and best wishes,</p><p>Sharon</p>'
            ]
        ];

        foreach($data as $v) {
            EmailTemplate::updateOrCreate(
                [
                    'template_name' => $v['template_name']
                ],
                [
                    'template_name' => $v['template_name'],
                    'email_subject' => $v['email_subject'],
                    'email_body'    => $v['email_body']
                ]
            );
        }
    }
}

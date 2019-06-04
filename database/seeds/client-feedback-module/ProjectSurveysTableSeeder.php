<?php

use Illuminate\Database\Seeder;

use App\Models\ClientFeedback\ProjectSurvey;
use App\Models\ClientFeedback\Questionnaire;
use App\Models\ClientFeedback\EmailTemplate;
use App\Models\ClientProject;

class ProjectSurveysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $q = (new Questionnaire)->where('name', 'Default Survey')->first();
        $e = (new EmailTemplate)->where('template_name', 'Default Email Template')->first();
        $p = (new ClientProject)->where('project_name', 'EmployeeDB Automated Infrastructure Deployment')->first();

        $data = [
            [
                'questionnaire_id' => $q->id,
                'email_template_id' => $e->id,
                'project_id' => $p->id,
                'client_id' => $p->client_id,
                'recurring_type' => 1,
                'project_survey_name' => 'Monthly Survey'
            ]
        ];

        foreach($data as $v) {
            ProjectSurvey::updateOrCreate($v);
        }
    }
}

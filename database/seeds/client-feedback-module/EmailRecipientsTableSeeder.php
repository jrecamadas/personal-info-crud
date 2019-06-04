<?php

use Illuminate\Database\Seeder;

use App\Models\ClientFeedback\ProjectSurvey;
use App\Models\ClientFeedback\EmailRecipient;
use App\Models\Client;
use App\Models\ClientContact;

class EmailRecipientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = (new Client)->where('company', 'EmployeeDB')->first();
        $contacts = (new ClientContact)->where('client_id', $client->id)->get();
        $p = (new ProjectSurvey)->where('project_survey_name', 'Monthly Survey')->first();

        foreach ($contacts as $contact) {
            $data = [
                'project_survey_id' => $p->id,
                'client_contact_id' => $contact->id
            ];

            EmailRecipient::updateOrCreate($data);
        }
    }
}

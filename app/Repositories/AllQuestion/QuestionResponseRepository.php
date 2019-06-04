<?php

namespace App\Repositories\AllQuestion;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\AllQuestionResponse;
use App\Models\Client;
use App\Models\ClientContact;
use App\Validators\AllQuestion\QuestionResponseValidator as AllQuestionResponseValidator;

/**
 * Class QuestionResponseRepository.
 *
 * @package namespace App\Repositories\AllQuestion;
 */
class QuestionResponseRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AllQuestionResponse::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {
        return AllQuestionResponseValidator::class;
    }

    public function saveAllResponses($responses)
    {
        $clientOnboardCtgryId                = 1;// client-onboarding question category id
        $clientInsertQuestionId              = [1, 14];// questions id for insertion of client
        $clientStatusProspect                = 2;// id of client status for `Prospect` clients
        $clientContactQuestionIds            = [15, 16, 17];// id of questions for inserting client contacts
        $results                             = [];
        $clientId = $client = $clientContact = null;

        foreach ($responses as $response) {
            if ($response['all_question_category_id'] == $clientOnboardCtgryId) {
                if (in_array($response['all_question_id'], $clientInsertQuestionId)) {
                    if (is_null($client)) {
                        $client                         = new Client;
                        $client->company                = $response['response'];
                        $client->status                 = $clientStatusProspect;
                        $client->timezone               = 'America/Chicago';
                        $client->is_high_growth_client  = 0; // default to false/no

                        $client->save();
                        $clientId = $client->id;
                    } else {
                        Client::where('id', $clientId)->update(['location' => $response['response']]);// location address insertion
                    }
                } elseif (in_array($response['all_question_id'], $clientContactQuestionIds)) {
                    if (is_null($clientContact)) {
                        $clientContact                  = new ClientContact;
                        $clientContact->client_id       = $clientId;
                        $clientContact->contact_no      = $response['response'];
                    } elseif ($response['all_question_id'] == 16) {// client contact name
                        $clientContact->name            = $response['response'];
                    } else {// client contact email
                        $clientContact->email           = $response['response'];
                        $clientContact->save();
                    }
                }
            }

            $data               = $response;
            $data['client_id']  = $clientId;
            $results[]          = $this->create($data);
        }

        return $results;
    }
}

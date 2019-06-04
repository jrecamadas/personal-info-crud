<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Client;

class ClientTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'user'
    ];

    protected $defaultIncludes = [
        'contacts',
        'projects',
        'photo'
    ];

    public function transform(Client $client)
    {
        $timezone = !empty($client->tz) ? $client->tz->zone_name : $client->timezone;

        return [
            'id'                    => (int)$client->id,
            'company'               => $client->company,
            'is_high_growth_client' => $client->is_high_growth_client,
            'contract_signed'       => $client->contract_signed,
            'initial_deposit'       => $client->initial_deposit,
            'start_guide'           => $client->start_guide,
            'first_week_check_up'   => $client->first_week_check_up,
            'team_emails_sent'      => $client->team_emails_sent,
            'first_month_check_up'  => $client->first_month_check_up,
            'status'                => $client->status,
            'location'              => $client->location,
            'timezone'              => $timezone,
            'notes'                 => $client->notes,
            'introductory_call'     => $client->introductory_call,
            'description'           => $client->description,
            'start_date'            => $client->start_date,
            'projects_count'        => $client->projects_count,
            'resources_count'       => $client->resources_count
        ];
    }

    /**
     * Include Client Contacts
     *
     * @param  Client $client
     * @return Collection
     */
    public function includeContacts(Client $client)
    {
        return $this->collection($client->contacts, new ClientContactTransformer());
    }

    /**
     * Include Client Projects
     *
     * @param  Client $client
     * @return Collection
     */
    public function includeProjects(Client $client)
    {
        return $this->collection($client->projects, new ClientProjectTransformer());
    }

    /**
     * Include Photo
     *
     * @param Client $client
     * @return Collection
     */
    public function includePhoto(Client $client)
    {
        return $this->collection($client->photo, new AssetTransformer());
    }

    /**
     * Include User Account
     *
     * @param Client $client
     * @return Item
     */
    public function includeUser(Client $client)
    {
        $user = $client->user;

        if (is_null($user)) {
            return null;
        }

        return $this->item($user, new UserTransformer());
    }
}

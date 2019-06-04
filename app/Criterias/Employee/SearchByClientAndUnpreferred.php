<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchByClientAndUnpreferred implements CriteriaInterface
{

    private $clientID;

    public function __construct($clientID)
    {
        $this->clientID = $clientID;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where(function($query){
            return $query->whereNull('client_preferred_teams.id')
                ->orWhere('client_preferred_teams.client_id', '=', $this->clientID);
        });
        
    }
}

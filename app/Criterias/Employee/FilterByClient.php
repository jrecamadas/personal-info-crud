<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterByClient implements CriteriaInterface
{
    private $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('clients.company', '=', $this->client);
    }
}

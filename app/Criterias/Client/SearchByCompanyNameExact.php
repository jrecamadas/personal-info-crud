<?php

namespace App\Criterias\Client;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchByCompanyNameExact implements CriteriaInterface
{
    private $term;

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('company', '=', $this->term);

        return $model;
    }
}

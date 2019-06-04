<?php

namespace App\Criterias\ClientProjectJobcode;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class JobcodeMapping implements CriteriaInterface
{
    private $term;

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('jobcode', '=', $this->term);

        return $model;
    }
}

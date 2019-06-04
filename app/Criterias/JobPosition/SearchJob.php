<?php

namespace App\Criterias\JobPosition;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchJob implements CriteriaInterface
{
    private $term;

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('job_title', 'like', $this->term . '%')
                     ->orWhere('job_description', 'like', '%' . $this->term . '%');
    }
}

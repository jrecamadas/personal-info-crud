<?php

namespace App\Criterias\Skill;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchSkill implements CriteriaInterface
{
    private $term;

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('name', 'like', '%' . $this->term . '%')
                       ->orWhere('description', 'like', '%' . $this->term . '%');

        return $model;
    }
}

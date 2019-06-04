<?php

namespace App\Criterias\ClientFeedback;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchByLink implements CriteriaInterface
{
    private $link;

    public function __construct($link)
    {
        $this->link = $link;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('survey_link', '=', $this->link);
        return $model;
    }
}

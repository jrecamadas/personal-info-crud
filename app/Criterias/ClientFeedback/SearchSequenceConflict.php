<?php

namespace App\Criterias\ClientFeedback;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchSequenceConflict implements CriteriaInterface
{
    private $displaySequence;

    public function __construct($sequence)
    {
        $this->displaySequence = $sequence;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('display_sequence', '=', $this->displaySequence);
        return $model;
    }
}

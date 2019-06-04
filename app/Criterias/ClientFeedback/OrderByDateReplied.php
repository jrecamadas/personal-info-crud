<?php

namespace App\Criterias\ClientFeedback;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class OrderByDateReplied implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->orderBy('is_expired', 'asc')
                    ->orderBy('date_replied', 'desc');

        return $model;
    }
}

<?php

namespace App\Criterias\Client;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SortByCreatedatAndStatus implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->orderByRaw('DATE(clients.created_at) desc')
            ->orderBy('clients.status', 'desc')
            ->orderBy('company', 'asc');

        return $model;
    }
}

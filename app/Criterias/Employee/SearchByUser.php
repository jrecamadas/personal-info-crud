<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchByUser implements CriteriaInterface
{
    private $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where(function ($query) {
            $query->where('employees.user_id', '=',  $this->userId);
        });
    }
}

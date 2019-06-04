<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithClientPreferredTeam implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {

        return $model->leftJoin('client_preferred_teams', function($join)
            {
                $join->on('client_preferred_teams.employee_id', '=', 'employees.id')
                    ->where('client_preferred_teams.deleted_at');
            });
    }
}

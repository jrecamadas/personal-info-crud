<?php
namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchByDeveloper implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereNotIn('job_positions.id', array('6','40','43','33','34','35','30','31','49','55'));
    }
}

<?php
namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchByEmail implements CriteriaInterface
{
    private $term;

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return  $model->where('employees.email', '=', $this->term);
    }
}
